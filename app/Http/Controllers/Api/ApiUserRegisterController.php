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
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'user_name' => 'required|string|max:255',
    //         'user_email' => 'required|email|unique:dw_user_models,user_email',
    //         'user_password' => 'required|min:8|confirmed',
    //         'user_mobile' => 'required|string|max:15',
    //         'user_city' => 'nullable|string|max:255',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation error',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $user = DwUserModel::create([
    //         'user_name' => $request->user_name,
    //         'user_email' => $request->user_email,
    //         'user_password' => bcrypt($request->user_password),
    //         'user_mobile' => $request->user_mobile,
    //         'user_city' => $request->user_city,
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'User registered successfully',
    //         'user' => [
    //             'id' => $user->id,
    //             'name' => $user->user_name,
    //             'email' => $user->user_email
    //         ]
    //     ]);
    // }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name'     => 'required|string|max:255',
            'user_mobile'   => 'required|digits:10',
            'user_city'     => 'required|string|max:255',
            'user_email'    => 'required|email|max:255|unique:dw_user_models,user_email',
            'user_password' => 'required|string|min:8',
        ], [
            'user_name.required'     => 'Full name is required.',
            'user_name.max'          => 'Name must not exceed 255 characters.',
            'user_mobile.required'   => 'Mobile number is required.',
            'user_mobile.digits'     => 'Mobile number must be exactly 10 digits.',
            'user_city.required'     => 'City is required.',
            'user_email.required'    => 'Email address is required.',
            'user_email.email'       => 'Please enter a valid email address.',
            'user_email.unique'      => 'This email is already registered. Please login or use a different email.',
            'user_password.required' => 'Password is required.',
            'user_password.min'      => 'Password must be at least 8 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $currentYear      = now()->format('Y');
            $currentYearShort = now()->format('y');

            $serial = DwUserModel::whereYear('created_at', $currentYear)->count() + 1;

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
            Mail::to($dwuser->user_email)->send(new UserRegisterWelcomeMail($dwuser));

            $token = $dwuser->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status'  => true,
                'message' => 'Hi,' . $dwuser->user_name . '! Your Medical Card ID is ' . $memberId . 'successfully created, please login.',
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
            return response()->json([
                'status'  => false,
                'message' => 'This email or mobile number is already registered. Please log in or use different details.',
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }
}
