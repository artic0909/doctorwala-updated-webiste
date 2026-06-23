<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendOTPUser;
use App\Models\DwUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ApiUserOTPController extends Controller
{
    // Step 1: Send OTP
    public function sendOTP(Request $request)
    {
        $request->validate([
            'user_mobile_number' => 'required|string',
        ]);

        $user = DwUserModel::where('user_mobile', $request->user_mobile_number)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Mobile number not registered.',
            ]);
        }

        $otp = rand(1000, 9999);
        Cache::put('otp_' . $request->user_mobile_number, $otp, now()->addMinutes(3));

        // Send WhatsApp OTP
        if ($user && $user->user_mobile) {
            $twilioService = new \App\Services\TwilioWhatsAppService();
            $twilioService->sendUserOtp($user->user_mobile, $otp);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent to your WhatsApp.',
        ]);
    }

    // Step 2: Verify OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'user_mobile_number' => 'required|string',
            'otp' => 'required|digits:4',
        ]);

        $storedOtp = Cache::get('otp_' . $request->user_mobile_number);

        if ($storedOtp == $request->otp) {
            $user = DwUserModel::where('user_mobile', $request->user_mobile_number)->first();

            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found']);
            }

            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully.',
                'data' => $user,
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid or expired OTP']);
    }



      // Step 3: Update Password
    public function updatePasswordDuringOTP(Request $request)
    {
        $request->validate([
            'user_mobile_number' => 'required|string',
            'user_password' => 'required|string|min:8|confirmed',
        ]);

        $user = DwUserModel::where('user_mobile', $request->user_mobile_number)->first();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found']);
        }

        $user->user_password = Hash::make($request->user_password);
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Password updated successfully',
        ]);
    }
}
