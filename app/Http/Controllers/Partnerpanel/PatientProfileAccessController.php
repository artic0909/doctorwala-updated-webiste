<?php

namespace App\Http\Controllers\Partnerpanel;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\DwPartnerModel;
use App\Models\DwUserModel;
use App\Models\PartnerAllOPDDoctorModel;
use App\Models\PartnerDoctorBannerModel;
use App\Models\PartnerOPDBannerModel;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerPathologyBannerModel;
use Illuminate\Support\Facades\Auth;

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

    public function viewPatientProfile() {}
}
