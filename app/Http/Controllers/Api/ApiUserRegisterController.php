<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserRegisterWelcomeMail;
use Illuminate\Http\Request;
use App\Models\DwUserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApiUserRegisterController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name'     => 'required|string|max:255',
            'user_mobile'   => 'required|digits:10|unique:dw_user_models,user_mobile',
            'user_city'     => 'required|string|max:255',
            'user_email'    => 'required|email|max:255|unique:dw_user_models,user_email',
            'user_password' => 'required|string|min:8',
        ], [
            'user_name.required'     => 'Full name is required.',
            'user_name.max'          => 'Name must not exceed 255 characters.',
            'user_mobile.required'   => 'Mobile number is required.',
            'user_mobile.digits'     => 'Mobile number must be exactly 10 digits.',
            'user_mobile.unique'     => 'This mobile number is already registered. Please login.',
            'user_city.required'     => 'City is required.',
            'user_email.required'    => 'Email address is required.',
            'user_email.email'       => 'Please enter a valid email address.',
            'user_email.unique'      => 'This email address is already registered. Please login.',
            'user_password.required' => 'Password is required.',
            'user_password.min'      => 'Password must be at least 8 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $currentYear      = now()->format('Y');
            $currentYearShort = now()->format('y');

            // Find the last memberid for this year to get the next serial number
            $lastUser = DwUserModel::where('memberid', 'like', "DW-$currentYear-%")
                ->orderBy('memberid', 'desc')
                ->first();

            $serial = 1;
            if ($lastUser && $lastUser->memberid) {
                $parts = explode('-', $lastUser->memberid);
                $lastSerialNum = end($parts);
                if (is_numeric($lastSerialNum)) {
                    $serial = (int)$lastSerialNum + 1;
                }
            }

            $paddedSerial = str_pad($serial, 3, '0', STR_PAD_LEFT);
            $memberId     = 'DW-' . $currentYear . '-' . $paddedSerial;

            $last4Mobile   = substr(preg_replace('/\D/', '', $request->user_mobile), -4);
            $cardSerial    = str_pad($serial, 2, '0', STR_PAD_LEFT);
            $medicalCardNo = 'DW' . $currentYearShort . ' ' . $last4Mobile . ' ' . $cardSerial;

            $dwuser                  = new DwUserModel($request->only(['user_name', 'user_mobile', 'user_city', 'user_email']));
            $dwuser->user_password   = bcrypt($request->user_password);
            $dwuser->memberid        = $memberId;
            $dwuser->medical_card_no = $medicalCardNo;

            $dwuser->save();

            // Send Welcome Email
            try {
                Mail::to($dwuser->user_email)->send(new UserRegisterWelcomeMail($dwuser));
            } catch (\Exception $e) {
                // Log the error or ignore it so registration still succeeds
                \Log::error('API Registration Email Error: ' . $e->getMessage());
            }

            $token = $dwuser->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status'  => true,
                'message' => 'Hi, ' . $dwuser->user_name . '! Your Medical Card ID ' . $memberId . ' is successfully created. Please login.',
                'token'   => $token,
                'user'    => [
                    'id'             => $dwuser->id,
                    'name'           => $dwuser->user_name,
                    'email'          => $dwuser->user_email,
                    'mobile'         => $dwuser->user_mobile,
                    'city'           => $dwuser->user_city,
                    'member_id'      => $dwuser->memberid,
                    'medical_card_no' => $dwuser->medical_card_no,
                ]
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for duplicate entry error (MySQL 1062)
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Registration failed: This email, mobile number, or Medical ID is already in use.',
                ], 409);
            }
            return response()->json([
                'status'  => false,
                'message' => 'Registration failed due to a database error.',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }
}
