<?php

namespace App\Http\Controllers;

use App\Models\DwPartnerModel;
use App\Models\SuperAboutusModel;
use App\Models\SuperOtherBannerModel;
use App\Models\PartnerFeedback;
use App\Mail\SendOTPPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DwPartnerOTPController extends Controller
{
    // Show OTP form
    public function partnerLoginWithOTPView()
    {
        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();

        $testi = PartnerFeedback::get();

        return view('partner-otp', compact('aboutDetails', 'otherBanners', 'testi'));
    }

    public function partnerLoginWithOTPVerifyView()
    {
        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();

        $testi = PartnerFeedback::get();
        return view('partner-otp-verify', compact('aboutDetails', 'otherBanners', 'testi'));
    }


    // Send OTP to the mobile
    public function sendOTP(Request $request)
    {
        $request->validate([
            'partner_mobile_number' => 'required|string',
        ]);

        $mobile = $request->partner_mobile_number;

        // Check if the mobile exists in the DwPartnerModel
        $partner = DwPartnerModel::where('partner_mobile_number', $mobile)->first();

        if (!$partner) {
            // If mobile is not found, return error message
            return back()->withErrors(['partner_mobile_number' => 'Mobile number is not registered.']);
        }

        // Generate OTP
        $otp = rand(1000, 9999);

        // Store OTP in cookie for 3 minutes
        Cookie::queue('partner_otp', $otp, 3);

        // Store mobile in session to use it later
        session(['partner_mobile_number' => $mobile]);

        // Send WhatsApp OTP
        if ($partner && $partner->partner_mobile_number) {
            $twilioService = new \App\Services\TwilioWhatsAppService();
            $twilioService->sendPartnerOtp($partner->partner_mobile_number, $otp);
        }

        // Redirect to OTP verification page
        return redirect()->route('partner-otp.verify')->with('message', 'OTP has been sent to your mobile number.');
    }


    // Verify OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'partner_otp' => 'required|numeric|digits:4',
        ]);

        $enteredOtp = $request->partner_otp;

        // Get OTP from the cookie
        $storedOtp = Cookie::get('partner_otp');

        // Get mobile from the session
        $mobile = session('partner_mobile_number');

        // Verify OTP
        if ($storedOtp && $enteredOtp == $storedOtp) {
            // OTP is valid, log the user in

            // Retrieve the partner data using the stored mobile
            $partner = DwPartnerModel::where('partner_mobile_number', $mobile)->first();

            if ($partner) {
                // Log the partner in using the partner guard
                Auth::guard('partner')->login($partner);

                // Redirect to the partner dashboard
                return redirect()->route('partnerpanel.partner-dashboard');
            } else {
                // Partner not found, return error
                return back()->withErrors(['partner_mobile_number' => 'Partner does not exist.']);
            }
        } else {
            // OTP is invalid or expired
            return back()->withErrors(['partner_otp' => 'Invalid or expired OTP.']);
        }
    }
}
