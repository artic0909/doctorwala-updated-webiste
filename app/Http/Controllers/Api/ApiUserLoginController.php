<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\DwUserModel;

class ApiUserLoginController extends Controller
{
    /**
     * Login API
     */
    public function login(Request $request)
    {
        $request->validate([
            'user_identifier' => 'required|string',
            'user_password' => 'required|string|min:6',
        ]);

        $identifier = $request->user_identifier;

        // Try finding user by email or mobile
        $user = DwUserModel::where('user_email', $identifier)
            ->orWhere('user_mobile', $identifier)
            ->first();

        if (!$user || !Hash::check($request->user_password, $user->user_password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('flutter-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->user_name,
                'email' => $user->user_email,
                'mobile' => $user->user_mobile,
                'city' => $user->user_city,
            ]
        ]);
    }


    /**
     * Logout API
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['message' => 'User not authenticated'], 401);
    }
}
