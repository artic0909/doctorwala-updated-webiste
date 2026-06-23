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
            'user_email' => 'required|email',
        ], [
            'user_email.required' => 'Email address is required.',
            'user_email.email'    => 'Please enter a valid email address.',
        ]);

        $user = DwUserModel::where('user_email', $request->user_email)->first();

        if (!$user) {
            return back()->withErrors(['user_email' => 'This email is not registered with us.'])->withInput();
        }

        $otp = rand(1000, 9999);

        Cookie::queue('user_otp', $otp, 3);
        session(['user_email' => $request->user_email]);

        Mail::to($request->user_email)->send(new SendOTPUser($otp));

        // Send WhatsApp OTP
        if ($user && $user->user_mobile) {
            $twilioService = new \App\Services\TwilioWhatsAppService();
            $twilioService->sendUserOtp($user->user_mobile, $otp);
        }

        return redirect()->route('dw.user-otp')
            ->with('message', 'OTP sent successfully! Please check your inbox (and spam folder).');
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
        $email     = session('user_email');

        if (!$storedOtp) {
            return back()->withErrors(['user_otp' => 'OTP has expired. Please request a new one.']);
        }

        if ($request->user_otp != $storedOtp) {
            return back()->withErrors(['user_otp' => 'Incorrect OTP. Please try again.']);
        }

        $user = DwUserModel::where('user_email', $email)->first();

        if (!$user) {
            return back()->withErrors(['user_otp' => 'Account not found. Please contact support.']);
        }

        Cookie::queue(Cookie::forget('user_otp'));
        session()->forget('user_email');

        Auth::guard('dwuser')->login($user);
        $request->session()->regenerate();

        return redirect()->route('dw.opd')->with('success', 'Login successful! Welcome back.');
    }

    public function resetOtp(Request $request)
    {
        session()->forget('user_email');
        Cookie::queue(Cookie::forget('user_otp'));

        return response()->json(['status' => 'ok']);
    }
}
