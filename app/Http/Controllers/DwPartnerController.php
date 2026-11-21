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
        return redirect()->route('partnerpanel.partner-dashboard')->with('info', 'Your account is already active.');
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

        \App\Models\PartnerOPDContactModel::where('currently_loggedin_partner_id', $request->input('currently_loggedin_partner_id'))
            ->update(['status' => 'Active']);

        \App\Models\PartnerPathologyContactModel::where('currently_loggedin_partner_id', $request->input('currently_loggedin_partner_id'))
            ->update(['status' => 'Active']);

        return redirect()->route('partnerpanel.partner-dashboard')->with('success', 'Coupon added successfully!');
    }

    public function partnerdashboardview()
    {
        $partner = Auth::guard('partner')->user();
        $partnerId = $partner->id;
        $partnerIds = array_values(array_filter([$partner->id, $partner->partner_id]));

        $opdBanner = PartnerOPDBannerModel::whereIn('currently_loggedin_partner_id', $partnerIds)->first();
        $pathologyBanner = PartnerPathologyBannerModel::whereIn('currently_loggedin_partner_id', $partnerIds)->first();
        $doctorBanner = PartnerDoctorBannerModel::whereIn('currently_loggedin_partner_id', $partnerIds)->first();

        $registrationTypes = $partner->registration_type;
        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }
        $registrationTypes = is_array($registrationTypes) ? $registrationTypes : [];

        $clinicName = $partner->partner_clinic_name;
        $partnerName = $partner->partner_contact_person_name;
        $partnerCode = $partner->partner_id ?? ('#DWPTR' . $partner->id);

        // --- KPI METRICS ---

        // 1. Doctors (OPD)
        $totalDoctors = \App\Models\PartnerAllOPDDoctorModel::whereIn('currently_loggedin_partner_id', $partnerIds)->count();
        $availableDoctors = \App\Models\PartnerAllOPDDoctorModel::whereIn('currently_loggedin_partner_id', $partnerIds)->where('status', 'Available')->count();

        // 2. Pathology Tests
        $totalTests = \App\Models\PartnerAllPathologyTestModel::whereIn('currently_loggedin_partner_id', $partnerIds)->count();
        $availableTests = \App\Models\PartnerAllPathologyTestModel::whereIn('currently_loggedin_partner_id', $partnerIds)->where('status', 'Available')->count();

        // 3. Patient Inquiries (Leads)
        $opdContacts = \App\Models\PartnerOPDContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get();
        $pathContacts = \App\Models\PartnerPathologyContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get();
        $docContacts = \App\Models\PartnerDoctorContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get();

        $opdClinics = $opdContacts->pluck('clinic_name')->filter()->toArray();
        $pathClinics = $pathContacts->pluck('clinic_name')->filter()->toArray();
        $docClinics = $docContacts->pluck('partner_doctor_name')->filter()->toArray();

        $allClinicNames = array_values(array_filter(array_unique(array_merge(
            [$partner->partner_clinic_name ?? null],
            $opdClinics,
            $pathClinics,
            $docClinics
        ))));

        $contactIds = array_values(array_filter(array_unique(array_merge(
            $opdContacts->pluck('id')->toArray(),
            $pathContacts->pluck('id')->toArray(),
            $docContacts->pluck('id')->toArray()
        ))));

        $doctorIds = \App\Models\PartnerAllOPDDoctorModel::whereIn('currently_loggedin_partner_id', $partnerIds)
            ->pluck('id')
            ->filter()
            ->toArray();

        $inquiryQuery = \App\Models\PartnerPatientInquiry::where(function ($q) use ($partnerIds, $contactIds, $allClinicNames, $doctorIds) {
            $q->whereIn('currently_loggedin_partner_id', $partnerIds);
            if (!empty($contactIds)) {
                $q->orWhereIn('currently_loggedin_partner_id', $contactIds);
            }
            if (!empty($allClinicNames)) {
                $q->orWhereIn('clinic_name', $allClinicNames);
            }
            if (!empty($doctorIds)) {
                $q->orWhereIn('doctor_id', $doctorIds);
            }
        });

        $totalInquiries = (clone $inquiryQuery)->count();
        $todayInquiries = (clone $inquiryQuery)->whereDate('created_at', now()->today())->count();
        $recentInquiries = (clone $inquiryQuery)->latest('created_at')->take(5)->get();

        // 4. Patient Health Record Requests
        $requestQuery = \App\Models\AccessRequest::whereIn('currently_loggedin_partner_id', $partnerIds);
        $totalRequests = (clone $requestQuery)->count();
        $acceptedRequests = (clone $requestQuery)->where('req_status', 'accepted')->count();
        $pendingRequests = (clone $requestQuery)->where('req_status', 'pending')->count();
        $recentRequests = (clone $requestQuery)->with(['patient', 'doctor'])->latest('created_at')->take(5)->get();

        // 5. Patient Reviews / Ratings
        $totalFeedbacks = \App\Models\PartnerFeedback::whereIn('currently_loggedin_partner_id', $partnerIds)->count();
        $avgRating = $totalFeedbacks > 0 ? round(\App\Models\PartnerFeedback::whereIn('currently_loggedin_partner_id', $partnerIds)->avg('rating'), 1) : 5.0;
        $recentFeedbacks = \App\Models\PartnerFeedback::whereIn('currently_loggedin_partner_id', $partnerIds)->latest('created_at')->take(3)->get();

        // 6. Helpdesk Support Tickets
        $totalTickets = \App\Models\PartnerInquiryModel::whereIn('currently_loggedin_partner_id', $partnerIds)->count();
        $pendingTickets = \App\Models\PartnerInquiryModel::whereIn('currently_loggedin_partner_id', $partnerIds)->where(function($q) {
            $q->whereNull('partner_problem_reply')->orWhere('partner_problem_reply', '');
        })->count();

        // 7. Subscription / Plan Status
        $activeSub = \App\Models\SubscriptionHolder::whereIn('currently_loggedin_partner_id', $partnerIds)->latest('id')->first();
        $couponSub = \App\Models\CouponHolderModel::whereIn('currently_loggedin_partner_id', $partnerIds)->latest('id')->first();
        $subPlanName = 'Free / Standard';
        $subDaysRemaining = null;

        if ($activeSub && $activeSub->close_date) {
            $subPlanName = $activeSub->subscription_title ?? 'Partner Premium';
            $close = \Carbon\Carbon::parse($activeSub->close_date);
            $subDaysRemaining = max(0, (int) now()->diffInDays($close, false));
        } elseif ($couponSub && $couponSub->coupon_end_date) {
            $subPlanName = 'Coupon Partner Plan';
            $close = \Carbon\Carbon::parse($couponSub->coupon_end_date);
            $subDaysRemaining = max(0, (int) now()->diffInDays($close, false));
        }

        return view('partnerpanel.dashboard.index', compact(
            'partner',
            'opdBanner',
            'pathologyBanner',
            'doctorBanner',
            'registrationTypes',
            'partnerName',
            'clinicName',
            'partnerCode',
            'totalDoctors',
            'availableDoctors',
            'totalTests',
            'availableTests',
            'totalInquiries',
            'todayInquiries',
            'recentInquiries',
            'totalRequests',
            'acceptedRequests',
            'pendingRequests',
            'recentRequests',
            'totalFeedbacks',
            'avgRating',
            'recentFeedbacks',
            'totalTickets',
            'pendingTickets',
            'subPlanName',
            'subDaysRemaining'
        ));
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
            'clinic_google_map_link' => 'nullable|string',
            'partner_address' => 'required|string',
            'partner_password' => 'required|string',
            'registration_type' => 'required|array',
            'ep_code' => 'nullable|string',
        ]);

        // Normalize registration_type (maps 'physiotherapist'/'others' -> 'Others', 'doctor' -> 'Doctor', 'clinic' -> 'OPD', 'lab' -> 'Pathology', 'both' -> ['OPD', 'Pathology'])
        if (is_array($request->registration_type)) {
            $mappedTypes = [];
            foreach ($request->registration_type as $type) {
                $t = strtolower(trim($type));
                if ($t === 'doctor' || $t === 'specialist') {
                    $mappedTypes[] = 'Doctor';
                } elseif ($t === 'physiotherapist' || $t === 'physiotherapy' || $t === 'allied' || $t === 'others') {
                    $mappedTypes[] = 'Others';
                } elseif ($t === 'opd' || $t === 'clinic') {
                    $mappedTypes[] = 'OPD';
                } elseif ($t === 'pathology' || $t === 'path' || $t === 'lab') {
                    $mappedTypes[] = 'Pathology';
                } elseif ($t === 'both') {
                    $mappedTypes[] = 'OPD';
                    $mappedTypes[] = 'Pathology';
                } else {
                    $mappedTypes[] = $type;
                }
            }
            $cleanTypes = array_values(array_unique($mappedTypes));
            $request->merge(['registration_type' => $cleanTypes]);
            $validated['registration_type'] = $cleanTypes;
        }

        // Check EP Code if entered
        $ep = null;
        if ($request->filled('ep_code')) {
            $inputEpCode = trim($request->ep_code);
            $ep = \App\Models\Ep::whereRaw('UPPER(code) = ?', [strtoupper($inputEpCode)])->first();
            if (!$ep) {
                $errorMsg = 'EP code is not correct, please enter correct EP code.';
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg,
                        'errors'  => ['ep_code' => [$errorMsg]],
                    ], 422);
                }
                return back()->withInput()->withErrors(['ep_code' => $errorMsg])->with('unsuccess', $errorMsg);
            }
        }

        try {
            // Create and save the partner with a temporary partner_id to avoid Duplicate Entry exceptions
            // caused by race conditions or soft-deleted rows throwing off max('id').
            $partnerData = collect($validated)->except(['ep_code'])->toArray();
            $dwuser = new DwPartnerModel($partnerData);
            $dwuser->partner_id = 'TMP_' . uniqid(); 
            $dwuser->partner_password = bcrypt($request->partner_password);
            $dwuser->registration_type = json_encode($request->registration_type);
            $dwuser->status = 'Active';
            if ($ep) {
                $dwuser->ep_id = $ep->id;
            }
            $dwuser->save();
            
            // Now that we have the true auto-incremented ID, we update partner_id securely
            $dwuser->partner_id = 'DWPTR' . $dwuser->id;
            $dwuser->status = 'Active';
            $dwuser->save();

            $regTypes = $request->registration_type ?? [];
            $partnerStatus = 'Active';

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
                    'status' => 'Active',
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
                    'status' => 'Active',
                ]);
            }

            if (in_array('Doctor', $regTypes) || in_array('Others', $regTypes)) {
                $isOthers = in_array('Others', $regTypes);
                \App\Models\PartnerDoctorContactModel::create([
                    'currently_loggedin_partner_id' => $dwuser->id,
                    'clinic_registration_type' => $isOthers ? 'Others' : 'Doctor',
                    'partner_doctor_name' => $dwuser->partner_contact_person_name,
                    'partner_doctor_specialist' => $isOthers ? 'Physiotherapist' : 'General Physician',
                    'partner_doctor_designation' => $isOthers ? 'Physiotherapist' : 'Doctor',
                    'partner_doctor_fees' => '500',
                    'partner_doctor_mobile' => $dwuser->partner_mobile_number,
                    'partner_doctor_email' => $dwuser->partner_email,
                    'partner_doctor_landmark' => $dwuser->partner_landmark,
                    'partner_doctor_pincode' => $dwuser->partner_pincode,
                    'partner_doctor_google_map_link' => $request->clinic_google_map_link ?? 'https://www.google.com/maps',
                    'partner_doctor_state' => $dwuser->partner_state,
                    'partner_doctor_city' => $dwuser->partner_city,
                    'partner_doctor_address' => $dwuser->partner_address,
                    'visit_day_time' => json_encode([]),
                    'status' => 'Active',
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

            // Authenticate and redirect directly to partner dashboard
            if (Auth::guard('partner')->loginUsingId($dwuser->id)) {
                $request->session()->regenerate(); // Regenerate session for security
                if ($request->ajax()) {
                    return response()->json(['success' => true, 'redirect' => route('partnerpanel.partner-dashboard')]);
                }
                return redirect()->route('partnerpanel.partner-dashboard')
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
