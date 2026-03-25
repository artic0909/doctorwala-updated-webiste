<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiUserProfileEditController extends Controller
{
    /**
     * Get authenticated user profile
     */
    public function getProfile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'user'   => [
                'id'                => $user->id,
                'name'              => $user->user_name,
                'email'             => $user->user_email,
                'mobile'            => $user->user_mobile,
                'city'              => $user->user_city,
                'dob'               => $user->dob,
                'gender'            => $user->gender,
                'address'           => $user->address,
                'blood_group'       => $user->blood_group,
                'height'            => $user->height,
                'weight'            => $user->weight,
                'emergency_contact' => $user->emergency_contact,
                'allergies'         => $user->allergies,
                'chronic_conditions'=> $user->chronic_conditions,
                'image'             => $user->image ? asset('storage/' . $user->image) : null,
                'member_id'         => $user->memberid,
                'medical_card_no'   => $user->medical_card_no,
            ],
        ]);
    }

    /**
     * Update user profile (mirrors website updateProfile)
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'user_name'          => 'required|string|max:255',
            'user_email'         => 'required|email|max:255',
            'user_mobile'        => 'required|string|max:15',
            'dob'                => 'nullable|date',
            'gender'             => 'nullable|string|max:10',
            'address'            => 'nullable|string|max:500',
            'blood_group'        => 'nullable|string|max:5',
            'height'             => 'nullable|numeric',
            'weight'             => 'nullable|numeric',
            'emergency_contact'  => 'nullable|string|max:15',
            'allergies'          => 'nullable|string',
            'chronic_conditions' => 'nullable|string',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'user_name'          => $request->user_name,
                'user_email'         => $request->user_email,
                'user_mobile'        => $request->user_mobile,
                'dob'                => $request->dob,
                'gender'             => $request->gender,
                'address'            => $request->address,
                'blood_group'        => $request->blood_group,
                'height'             => $request->height,
                'weight'             => $request->weight,
                'emergency_contact'  => $request->emergency_contact,
                'allergies'          => $request->allergies,
                'chronic_conditions' => $request->chronic_conditions,
            ];

            // ── Profile image upload ───────────────────────────────────────
            if ($request->hasFile('image')) {

                // Delete old image if exists
                $oldImage = DB::table('dw_user_models')->where('id', $user->id)->value('image');
                if ($oldImage && file_exists(public_path('storage/' . $oldImage))) {
                    unlink(public_path('storage/' . $oldImage));
                }

                $file     = $request->file('image');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/images'), $fileName);

                $data['image'] = 'images/' . $fileName;
            }

            DB::table('dw_user_models')
                ->where('id', $user->id)
                ->update($data);

            // Return updated image URL if changed
            $updatedUser = DB::table('dw_user_models')->where('id', $user->id)->first();

            return response()->json([
                'status'  => true,
                'message' => 'Profile updated successfully!',
                'image'   => $updatedUser->image ? asset('storage/' . $updatedUser->image) : null,
            ], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'This email or mobile is already in use.',
            ], 409);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Update password (mirrors website updatePassword — requires current password)
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'New password and confirm password do not match.',
            'password.min'       => 'New password must be at least 8 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Check current password against existing hash
        if (!Hash::check($request->current_password, $user->user_password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Current password is incorrect.',
            ], 401);
        }

        DB::table('dw_user_models')
            ->where('id', $user->id)
            ->update([
                'user_password' => Hash::make($request->password),
            ]);

        return response()->json([
            'status'  => true,
            'message' => 'Password updated successfully.',
        ], 200);
    }
}