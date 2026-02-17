<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DwUserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiUserRegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:dw_user_models,user_email',
            'user_password' => 'required|min:8|confirmed',
            'user_mobile' => 'required|string|max:15',
            'user_city' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = DwUserModel::create([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_password' => bcrypt($request->user_password),
            'user_mobile' => $request->user_mobile,
            'user_city' => $request->user_city,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->user_name,
                'email' => $user->user_email
            ]
        ]);
    }
}
