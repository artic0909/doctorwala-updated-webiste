<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            'user' => [
                'id' => $user->id,
                'name' => $user->user_name,
                'email' => $user->user_email,
                'mobile' => $user->user_mobile,
                'city' => $user->user_city,
            ],
        ]);
    }

    /**
     * Update user name and email
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'user_name'  => 'required|string|max:255',
            'user_email' => 'required|email|max:255|unique:dw_user_models,user_email,' . $user->id,
            'user_mobile' => 'required|string|max:10',
            'user_city' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user->user_name = $request->user_name;
        $user->user_email = $request->user_email;
        $user->user_mobile = $request->user_mobile;
        $user->user_city = $request->user_city;
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Profile updated successfully',
        ]);
    }

    /**
     * Override and update password (no old password needed)
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user->user_password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Password updated successfully',
        ]);
    }
}
