<?php

namespace App\Http\Controllers\Partnerpanel;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\DwPartnerModel;
use App\Models\DwUserModel;
use App\Models\MedicalHistory;
use App\Models\PartnerAllOPDDoctorModel;
use App\Models\PartnerDoctorBannerModel;
use App\Models\PartnerOPDBannerModel;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerPathologyBannerModel;
use App\Models\PartnerPatientInquiry;
use App\Models\Vital;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use Illuminate\Http\Request;

class PatientProfileAccessController extends Controller
{
    protected $guard = 'partner';

    public function index()
    {
        $partner           = Auth::guard('partner')->user();
        $partnerId         = Auth::guard('partner')->id();
        $opdBanner         = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $pathologyBanner   = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $doctorBanner      = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $registrationTypes = $partner->registration_type;

        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }

        // Fetch all active doctors for this partner
        $doctors = PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partnerId)
            ->orderBy('doctor_name')
            ->get();

        return view('partnerpanel.patient-profile-req', compact(
            'opdBanner',
            'pathologyBanner',
            'doctorBanner',
            'registrationTypes',
            'partner',
            'doctors'
        ));
    }

    /**
     * AJAX — lookup patient by Medical Card No + Member ID
     * POST /partner/patient/lookup
     */
    public function patientLookup(Request $request)
    {
        $request->validate([
            'dw_medical_id' => 'required|string|max:50',
            'dw_member_id'  => 'required|string|max:50',
        ]);

        // DB stores 'DW26 7211 03' so match directly
        $patient = DwUserModel::where('medical_card_no', $request->dw_medical_id)
            ->where('memberid', $request->dw_member_id)
            ->first();

        if (!$patient) {
            return response()->json([
                'found'   => false,
                'message' => 'No patient found. Please check the IDs and try again.',
            ]);
        }

        return response()->json([
            'found'   => true,
            'patient' => [
                'id'              => $patient->id,
                'user_name'       => $patient->user_name,
                'user_email'      => $patient->user_email,
                'user_mobile'     => $patient->user_mobile,
                'medical_card_no' => $patient->medical_card_no,
                'is_verified'     => (bool) ($patient->is_verified ?? false),
            ],
        ]);
    }


    public function sendRequest(Request $request)
    {
        $request->validate([
            'doctor_id'    => 'required|integer|exists:partner_all_o_p_d_doctor_models,id',
            'dw_user_id'   => 'required|integer|exists:dw_user_models,id',
            'dw_medical_id' => 'required|string|max:50',
            'dw_member_id' => 'required|string|max:50',
        ]);

        // Prevent duplicate pending requests
        $exists = AccessRequest::where('dw_user_id', $request->dw_user_id)
            ->where('currently_loggedin_partner_id', $request->currently_loggedin_partner_id)
            ->where('req_status', 'pending')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'A pending request for this patient already exists.');
        }

        AccessRequest::create([
            'dw_user_id'                    => $request->dw_user_id,
            'doctor_id'                     => $request->doctor_id,
            'currently_loggedin_partner_id' => $request->currently_loggedin_partner_id,
            'partner_clinic_name'           => $request->partner_clinic_name,
            'partner_contact_person_name'   => $request->partner_contact_person_name,
            'partner_mobile_number'         => $request->partner_mobile_number,
            'partner_email'                 => $request->partner_email,
            'partner_state'                 => $request->partner_state,
            'partner_city'                  => $request->partner_city,
            'partner_landmark'              => $request->partner_landmark,
            'partner_pincode'               => $request->partner_pincode,
            'dw_medical_id'                 => $request->dw_medical_id,
            'dw_member_id'                  => $request->dw_member_id,
            // read_status, req_status, access_status use model defaults
        ]);

        return redirect()->route('partner.patient.profile.all.request')->with('success', 'Access request sent successfully. The patient will be notified.');
    }

    public function allRequests()
    {
        $partner           = Auth::guard('partner')->user();
        $partnerId         = Auth::guard('partner')->id();
        $opdBanner         = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $pathologyBanner   = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $doctorBanner      = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $registrationTypes = $partner->registration_type;

        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }

        $requests = AccessRequest::where('currently_loggedin_partner_id', $partner->partner_id)
            ->with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partnerpanel.patient-all-profiles', compact('requests', 'opdBanner', 'pathologyBanner', 'doctorBanner', 'registrationTypes'));
    }

    // ─── shared: decrypt ID & verify access ───────────────────────
    private function resolvePatient(string $encryptedId): array
    {
        try {
            $dwUserId = Crypt::decryptString($encryptedId);
        } catch (DecryptException) {
            abort(403, 'Invalid link.');
        }

        $partner   = Auth::guard('partner')->user();
        $partnerId = $partner->partner_id;

        $access = AccessRequest::where('dw_user_id', $dwUserId)
            ->where('currently_loggedin_partner_id', $partnerId)
            ->first();

        $blocked = !$access
            || $access->req_status    !== 'accepted'
            || $access->access_status !== 'on';

        $patient = DwUserModel::findOrFail($dwUserId);

        return [$dwUserId, $patient, $blocked, $partner, $partnerId];
    }

    // ─── shared: partner meta ─────────────────────────────────────
    private function partnerMeta($partnerId): array
    {
        return [
            'opdBanner'       => PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first(),
            'pathologyBanner' => PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first(),
            'doctorBanner'    => PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first(),
        ];
    }

    // ─── VIEW PATIENT PROFILE ──────────────────────────────────────
    public function viewPatientProfile(string $encryptedId)
    {
        [$dwUserId, $patient, $blocked, $partner, $partnerId] = $this->resolvePatient($encryptedId);

        if ($blocked) {
            return view('partnerpanel.block', compact('patient'));
        }

        extract($this->partnerMeta($partnerId));

        $registrationTypes = is_string($partner->registration_type)
            ? json_decode($partner->registration_type, true)
            : $partner->registration_type;

        $latestSingleBooking = PartnerPatientInquiry::where('dw_user_id', $dwUserId)
            ->where('status', 'Upcoming')
            ->with(['opdContact.banner', 'pathologyContact.banner', 'doctorContact.banner', 'user', 'doctor', 'test'])
            ->latest()
            ->first();

        $bookings = PartnerPatientInquiry::where('dw_user_id', $dwUserId)
            ->with(['opdContact.banner', 'pathologyContact.banner', 'doctorContact.banner', 'user', 'doctor', 'test'])
            ->latest()
            ->get();

        $noOfPrescription = MedicalHistory::where('dw_user_id', $dwUserId)
            ->where('type', 'prescription')
            ->count();

        $noOfReport = MedicalHistory::where('dw_user_id', $dwUserId)
            ->where('type', 'report')
            ->count();

        $vital       = Vital::where('dw_user_id', $dwUserId)->latest()->first();
        $noOfRequest = AccessRequest::where('dw_user_id', $dwUserId)->count();

        $encryptedPatientId = Crypt::encryptString((string) $dwUserId);

        return view('partnerpanel.partner-user-profile-view', compact(
            'partner',
            'patient',
            'opdBanner',
            'pathologyBanner',
            'doctorBanner',
            'registrationTypes',
            'latestSingleBooking',
            'bookings',
            'noOfPrescription',
            'noOfReport',
            'vital',
            'noOfRequest',
            'encryptedPatientId'
        ));
    }

    // ─── VIEW MEDICAL HISTORY ──────────────────────────────────────
    public function viewMedicalHistory(string $encryptedId)
    {
        [$dwUserId, $patient, $blocked, $partner, $partnerId] = $this->resolvePatient($encryptedId);

        if ($blocked) {
            return view('partnerpanel.block', compact('patient'));
        }

        extract($this->partnerMeta($partnerId));

        $registrationTypes = is_string($partner->registration_type)
            ? json_decode($partner->registration_type, true)
            : $partner->registration_type;

        $histories = MedicalHistory::where('dw_user_id', $dwUserId)
            ->latest('date_of_report')
            ->paginate(10);

        $noOfPrescription = MedicalHistory::where('dw_user_id', $dwUserId)
            ->where('type', 'prescription')
            ->count();

        $noOfReport = MedicalHistory::where('dw_user_id', $dwUserId)
            ->where('type', 'report')
            ->count();

        $vital = Vital::where('dw_user_id', $dwUserId)->latest()->first();

        $encryptedPatientId = Crypt::encryptString((string) $dwUserId);

        return view('partnerpanel.patient-user-medical-history-view', compact(
            'partner',
            'patient',
            'opdBanner',
            'pathologyBanner',
            'doctorBanner',
            'registrationTypes',
            'histories',
            'noOfPrescription',
            'noOfReport',
            'vital',
            'encryptedPatientId'
        ));
    }

    // ─── VIEW REPORT FILES ─────────────────────────────────────────
    public function viewPatientReportImagesOrPdf(string $encryptedId)
    {
        try {
            $recordId = Crypt::decryptString($encryptedId);
        } catch (DecryptException) {
            abort(403, 'Invalid link.');
        }

        $record   = MedicalHistory::findOrFail($recordId);
        $dwUserId = $record->dw_user_id;

        $partner   = Auth::guard('partner')->user();
        $partnerId = $partner->partner_id;

        $access = AccessRequest::where('dw_user_id', $dwUserId)
            ->where('currently_loggedin_partner_id', $partnerId)
            ->first();

        $blocked = !$access
            || $access->req_status    !== 'accepted'
            || $access->access_status !== 'on';

        if ($blocked) {
            $patient = DwUserModel::findOrFail($dwUserId);
            return view('partnerpanel.block', compact('patient'));
        }

        return view('partnerpanel.patient-view-report-images', compact('record'));
    }



    // public function viewPatientProfile($dwUserId)
    // {
    //     $partner   = Auth::guard('partner')->user();
    //     $partnerId = Auth::guard('partner')->id();

    //     // Partner banners / meta
    //     $opdBanner       = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
    //     $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
    //     $doctorBanner    = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();

    //     $registrationTypes = $partner->registration_type;
    //     if (is_string($registrationTypes)) {
    //         $registrationTypes = json_decode($registrationTypes, true);
    //     }

    //     // The patient (dw user)
    //     $patient = DwUserModel::findOrFail($dwUserId);

    //     // Latest upcoming appointment for this patient
    //     $latestSingleBooking = PartnerPatientInquiry::where('dw_user_id', $dwUserId)
    //         ->where('status', 'Upcoming')
    //         ->with([
    //             'opdContact.banner',
    //             'pathologyContact.banner',
    //             'doctorContact.banner',
    //             'user',
    //             'doctor',
    //             'test',
    //         ])
    //         ->latest()
    //         ->first();

    //     // All bookings for this patient
    //     $bookings = PartnerPatientInquiry::where('dw_user_id', $dwUserId)
    //         ->with([
    //             'opdContact.banner',
    //             'pathologyContact.banner',
    //             'doctorContact.banner',
    //             'user',
    //             'doctor',
    //             'test',
    //         ])
    //         ->latest()
    //         ->get();

    //     // Medical history
    //     $noOfPrescription = MedicalHistory::where('dw_user_id', $dwUserId)
    //         ->where('type', 'prescription')
    //         ->count();

    //     $noOfReport = MedicalHistory::where('dw_user_id', $dwUserId)
    //         ->where('type', 'report')
    //         ->count();

    //     // Latest vitals
    //     $vital = Vital::where('dw_user_id', $dwUserId)->latest()->first();

    //     // Notifications / access requests count
    //     $noOfRequest = AccessRequest::where('dw_user_id', $dwUserId)->count();

    //     return view('partnerpanel.partner-user-profile-view', compact(
    //         'partner',
    //         'patient',
    //         'opdBanner',
    //         'pathologyBanner',
    //         'doctorBanner',
    //         'registrationTypes',
    //         'latestSingleBooking',
    //         'bookings',
    //         'noOfPrescription',
    //         'noOfReport',
    //         'vital',
    //         'noOfRequest'
    //     ));
    // }

    // public function viewMedicalHistory($dwUserId)
    // {
    //     $partner   = Auth::guard('partner')->user();
    //     $partnerId = Auth::guard('partner')->id();

    //     $opdBanner       = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
    //     $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
    //     $doctorBanner    = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();

    //     $registrationTypes = $partner->registration_type;
    //     if (is_string($registrationTypes)) {
    //         $registrationTypes = json_decode($registrationTypes, true);
    //     }

    //     // The patient
    //     $patient = DwUserModel::findOrFail($dwUserId);

    //     $histories = MedicalHistory::where('dw_user_id', $dwUserId)
    //         ->latest('date_of_report')
    //         ->paginate(10);

    //     $noOfPrescription = MedicalHistory::where('dw_user_id', $dwUserId)
    //         ->where('type', 'prescription')
    //         ->count();

    //     $noOfReport = MedicalHistory::where('dw_user_id', $dwUserId)
    //         ->where('type', 'report')
    //         ->count();

    //     $vital = Vital::where('dw_user_id', $dwUserId)->latest()->first();

    //     return view('partnerpanel.patient-user-medical-history-view', compact(
    //         'partner',
    //         'patient',
    //         'opdBanner',
    //         'pathologyBanner',
    //         'doctorBanner',
    //         'registrationTypes',
    //         'histories',
    //         'noOfPrescription',
    //         'noOfReport',
    //         'vital'
    //     ));
    // }

    // public function viewPatientReportImagesOrPdf($id)
    // {
    //     $record = MedicalHistory::findOrFail($id);

    //     return view('partnerpanel.patient-view-report-images', compact('record'));
    // }
}
