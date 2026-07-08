<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Auth;

use App\Models\CouponHolderModel;
use App\Models\DwPartnerModel;
use App\Models\PartnerDoctorBannerModel;
use App\Models\PartnerFeedback;
use App\Models\PartnerOPDBannerModel;
use App\Models\PartnerPathologyBannerModel;
use App\Models\SuperAboutusModel;
use App\Models\SuperCouponModel;
use App\Models\SuperOtherBannerModel;
use App\Models\SuperSubscriptionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;

class DwPartnerController extends Controller
{

    protected $guard = 'partner';


    public function viewPartnerRegForm()
    {


        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();

        $testi = PartnerFeedback::get();

        return view('partner-register', compact('aboutDetails', 'otherBanners', 'testi'));
    }


    public function partnerLoginFormView()
    {

        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();

        $testi = PartnerFeedback::get();

        return view('partner-login', compact('aboutDetails', 'otherBanners', 'testi'));
    }


    public function partnerCouponCodeAddView()
    {

        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();

        $partnerID = Auth::guard('partner')->user();
        return view('payments', compact('partnerID', 'aboutDetails', 'otherBanners'));
    }


    public function getCouponDetails(Request $request)
    {
        $couponCode = $request->input('coupon_code');


        $coupon = SuperCouponModel::where('coupon_code', $couponCode)->first();

        if ($coupon) {
            return response()->json([
                'success' => true,
                'data' => $coupon,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Coupon not found.',
        ]);
    }

    public function partnerCouponCodeAdd(Request $request)
    {
        $validated = $request->validate([
            'currently_loggedin_partner_id' => 'required|string',
            'coupon_code' => 'required|string',
            'coupon_amount' => 'required|string',
            'coupon_start_date' => 'required|string',
            'coupon_end_date' => 'required|string',
        ]);

        CouponHolderModel::create([
            'currently_loggedin_partner_id' => $request->input('currently_loggedin_partner_id'),
            'coupon_code' => $request->input('coupon_code'),
            'coupon_amount' => $request->input('coupon_amount'),
            'coupon_start_date' => $request->input('coupon_start_date'),
            'coupon_end_date' => $request->input('coupon_end_date'),
        ]);

        // After successfully added then the DwPartnerModel's status will be change to Active
        // Change the status of the partner in DwPartnerModel to Active
        DwPartnerModel::where('id', $request->input('currently_loggedin_partner_id'))
            ->update(['status' => 'Active']);

        return redirect()->route('partnerpanel.partner-dashboard')->with('success', 'Coupon added successfully!');
    }

    public function partnerdashboardview()
    {
        $partnerId = Auth::guard('partner')->id();
        $opdBanner = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $doctorBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();


        $partner = Auth::guard('partner')->user();
        $registrationTypes = $partner->registration_type;

        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }


        $clinicName = $partner->partner_clinic_name;
        $partnerName = $partner->partner_contact_person_name;

        return view('partnerpanel.partner-dashboard', compact('opdBanner', 'pathologyBanner', 'doctorBanner', 'registrationTypes', 'partnerName', 'clinicName'));
    }

    public function partnerRegForm(Request $request)
    {
        $validated = $request->validate([
            'partner_clinic_name' => 'required|string|max:255',
            'partner_contact_person_name' => 'required|string|max:255',
            'partner_mobile_number' => 'required|string|max:15|unique:dw_partner_models,partner_mobile_number',
            'partner_email' => 'required|string|email|max:255|unique:dw_partner_models,partner_email',
            'partner_state' => 'required|string',
            'partner_city' => 'required|string',
            'partner_pincode' => 'required|string',
            'partner_landmark' => 'required|string',
            'partner_address' => 'required|string',
            'partner_password' => 'required|string',
            'registration_type' => 'required|array',
        ]);



        // $partnerCount = DwPartnerModel::count();
        // $partnerId = 'DWPTR' . ($partnerCount + 1);
        $partnerId = 'DWPTR' . (DwPartnerModel::max('id') + 1);

        try {
            // Create and save the partner
            $dwuser = new DwPartnerModel($validated);
            $dwuser->partner_id = $partnerId;
            $dwuser->partner_password = bcrypt($request->partner_password);
            $dwuser->registration_type = json_encode($request->registration_type);
            $dwuser->save();

            $regTypes = $request->registration_type ?? [];
            $partnerStatus = $dwuser->status ?? 'Inactive';

            if (in_array('OPD', $regTypes)) {
                \App\Models\PartnerOPDContactModel::create([
                    'currently_loggedin_partner_id' => $dwuser->id,
                    'clinic_registration_type' => 'OPD',
                    'clinic_contact_person_name' => $dwuser->partner_contact_person_name,
                    'clinic_name' => $dwuser->partner_clinic_name,
                    'clinic_mobile_number' => $dwuser->partner_mobile_number,
                    'clinic_email' => $dwuser->partner_email,
                    'clinic_landmark' => $dwuser->partner_landmark,
                    'clinic_pincode' => $dwuser->partner_pincode,
                    'clinic_state' => $dwuser->partner_state,
                    'clinic_city' => $dwuser->partner_city,
                    'clinic_google_map_link' => $request->clinic_google_map_link,
                    'clinic_address' => $dwuser->partner_address,
                    'status' => $partnerStatus,
                ]);
            }

            if (in_array('Pathology', $regTypes)) {
                \App\Models\PartnerPathologyContactModel::create([
                    'currently_loggedin_partner_id' => $dwuser->id,
                    'clinic_registration_type' => 'Pathology',
                    'clinic_contact_person_name' => $dwuser->partner_contact_person_name,
                    'clinic_name' => $dwuser->partner_clinic_name,
                    'clinic_mobile_number' => $dwuser->partner_mobile_number,
                    'clinic_email' => $dwuser->partner_email,
                    'clinic_landmark' => $dwuser->partner_landmark,
                    'clinic_pincode' => $dwuser->partner_pincode,
                    'clinic_state' => $dwuser->partner_state,
                    'clinic_city' => $dwuser->partner_city,
                    'clinic_google_map_link' => $request->clinic_google_map_link,
                    'clinic_address' => $dwuser->partner_address,
                    'status' => $partnerStatus,
                ]);
            }

            // Send WhatsApp Welcome Message
            if ($dwuser->partner_mobile_number) {
                $twilioService = new \App\Services\TwilioWhatsAppService();
                $regTypes = json_decode($dwuser->registration_type, true) ?? [];
                $clinicType = implode(', ', (array) $regTypes) ?: 'Partner';
                $twilioService->sendPartnerWelcome(
                    $dwuser->partner_mobile_number,
                    $dwuser->partner_contact_person_name,
                    $dwuser->partner_clinic_name,
                    $clinicType
                );
            }

            // Authenticate and redirect
            if (Auth::guard('partner')->loginUsingId($dwuser->id)) {
                $request->session()->regenerate(); // Regenerate session for security
                if ($request->ajax()) {
                    return response()->json(['success' => true, 'redirect' => route('partnerpanel.partner-coupon')]);
                }
                return redirect()->route('partnerpanel.partner-coupon')
                    ->with('success', 'Registration successful! Welcome to your dashboard.');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Partner Reg Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Registration unsuccessful! Please try again.'], 400);
            }
            return back()->with('unsuccess', 'Registration unsuccessful! Please try again.')->withInput();
        }

        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred. Please try again.'], 400);
        }
        return back()->with('unsuccess', 'An unexpected error occurred. Please try again.'); 
    }


    public function partnerLogin(Request $request)
    {

        $validated = $request->validate([
            'partner_email' => 'required|email',
            'partner_password' => 'required',
        ]);




        $credentials = [
            'partner_email' => $request->partner_email,
            'password' => $request->partner_password,
        ];


        if (Auth::guard('partner')->attempt($credentials)) {

            $request->session()->regenerate();
            if ($request->ajax()) {
                return response()->json(['success' => true, 'redirect' => route('partnerpanel.partner-dashboard')]);
            }
            return redirect()->route('partnerpanel.partner-dashboard');
        }

        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials. Please try again.'], 401);
        }
        return back()->withErrors([
            'partner_email' => 'Invalid credentials. Please try again.',
        ]);
    }

    public function partnerlogout(Request $request)
    {
        Auth::guard('partner')->logout();
        // $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/partner-login');
    }
}
