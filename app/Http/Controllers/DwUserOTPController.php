<?php

namespace App\Http\Controllers;


use App\Mail\SendOTPUser;
use App\Models\DwUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DwUserOTPController extends Controller
{
    public function userOtpView()
    {
        return view('user-otp');
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'user_mobile_number' => 'required|string',
        ], [
            'user_mobile_number.required' => 'Mobile number is required.',
        ]);

        $user = DwUserModel::where('user_mobile', $request->user_mobile_number)->first();

        if (!$user) {
            return back()->withErrors(['user_mobile_number' => 'This mobile number is not registered with us.'])->withInput();
        }

        $otp = rand(1000, 9999);

        Cookie::queue('user_otp', $otp, 3);
        session(['user_mobile_number' => $request->user_mobile_number]);

        // Send WhatsApp OTP
        if ($user && $user->user_mobile) {
            $twilioService = new \App\Services\TwilioWhatsAppService();
            $twilioService->sendUserOtp($user->user_mobile, $otp);
        }

        return redirect()->route('dw.user-otp')
            ->with('message', 'OTP sent successfully! Please check your WhatsApp.');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'user_otp' => 'required|digits:4',
        ], [
            'user_otp.required' => 'Please enter the 4-digit OTP.',
            'user_otp.digits'   => 'OTP must be exactly 4 digits.',
        ]);

        $storedOtp = Cookie::get('user_otp');
        $mobile     = session('user_mobile_number');

        if (!$storedOtp) {
            return back()->withErrors(['user_otp' => 'OTP has expired. Please request a new one.']);
        }

        if ($request->user_otp != $storedOtp) {
            return back()->withErrors(['user_otp' => 'Incorrect OTP. Please try again.']);
        }

        $user = DwUserModel::where('user_mobile', $mobile)->first();

        if (!$user) {
            return back()->withErrors(['user_otp' => 'Account not found. Please contact support.']);
        }

        Cookie::queue(Cookie::forget('user_otp'));
        session()->forget('user_mobile_number');

        Auth::guard('dwuser')->login($user);
        $request->session()->regenerate();

        return redirect()->route('dw.opd')->with('success', 'Login successful! Welcome back.');
    }

    public function resetOtp(Request $request)
    {
        session()->forget('user_mobile_number');
        Cookie::queue(Cookie::forget('user_otp'));

        return response()->json(['status' => 'ok']);
    }
}
