<?php

namespace App\Http\Controllers\PartnerApi;

use App\Http\Controllers\Controller;
use App\Mail\MedicalCardAccessRequestMail;
use App\Models\AccessRequest;
use App\Models\DwPartnerModel;
use App\Models\DwUserModel;
use App\Models\MedicalHistory;
use App\Models\PartnerAllOPDDoctorModel;
use App\Models\PartnerDoctorBannerModel;
use App\Models\PartnerOPDBannerModel;
use App\Models\PartnerPathologyBannerModel;
use App\Models\PartnerPatientInquiry;
use App\Models\SystemPrescription;
use App\Models\Vital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MedicalCardAccessController extends Controller
{
    /**
     * Get initial meta-data (banners, registration types) and doctors list
     * GET /partner-api/medical-card-access/meta
     */
    public function index(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $partnerId = $partner->id;
        $opdBanner = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $doctorBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $registrationTypes = $partner->registration_type;

        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }

        // Fetch all active doctors for this partner
        $doctors = PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partnerId)
            ->orderBy('doctor_name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'opdBanner' => $opdBanner,
                'pathologyBanner' => $pathologyBanner,
                'doctorBanner' => $doctorBanner,
                'registrationTypes' => $registrationTypes,
                'doctors' => $doctors
            ]
        ]);
    }

    /**
     * Look up patient by Medical Card No + Member ID
     * POST /partner-api/medical-card-access/lookup
     */
    public function patientLookup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dw_medical_id' => 'required|string|max:50',
            'dw_member_id' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors' => $validator->errors()
            ], 422);
        }

        $patient = DwUserModel::where('medical_card_no', $request->dw_medical_id)
            ->where('memberid', $request->dw_member_id)
            ->first();

        if (!$patient) {
            return response()->json([
                'success' => false,
                'found' => false,
                'message' => 'No patient found. Please check the IDs and try again.',
            ]);
        }

        return response()->json([
            'success' => true,
            'found' => true,
            'patient' => [
                'id' => $patient->id,
                'user_name' => $patient->user_name,
                'user_email' => $patient->user_email,
                'user_mobile' => $patient->user_mobile,
                'medical_card_no' => $patient->medical_card_no,
                'is_verified' => (bool) ($patient->is_verified ?? false),
                'encrypted_id' => Crypt::encryptString((string) $patient->id),
            ],
        ]);
    }

    /**
     * Send Medical Card Access Request
     * POST /partner-api/medical-card-access/request
     */
    public function sendRequest(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|integer|exists:partner_all_o_p_d_doctor_models,id',
            'dw_user_id' => 'required|integer|exists:dw_user_models,id',
            'dw_medical_id' => 'required|string|max:50',
            'dw_member_id' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Prevent duplicate pending requests
        $exists = AccessRequest::where('dw_user_id', $request->dw_user_id)
            ->where('currently_loggedin_partner_id', $partner->partner_id)
            ->where('req_status', 'pending')
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'A pending request for this patient already exists.'
            ], 400);
        }

        $accessRequest = AccessRequest::create([
            'dw_user_id' => $request->dw_user_id,
            'doctor_id' => $request->doctor_id,
            'currently_loggedin_partner_id' => $partner->partner_id,
            'partner_clinic_name' => $partner->partner_clinic_name,
            'partner_contact_person_name' => $partner->partner_contact_person_name,
            'partner_mobile_number' => $partner->partner_mobile_number,
            'partner_email' => $partner->partner_email,
            'partner_state' => $partner->partner_state,
            'partner_city' => $partner->partner_city,
            'partner_landmark' => $partner->partner_landmark,
            'partner_pincode' => $partner->partner_pincode,
            'dw_medical_id' => $request->dw_medical_id,
            'dw_member_id' => $request->dw_member_id,
        ]);

        // Send email to the patient
        $patient = DwUserModel::find($request->dw_user_id);
        if ($patient && $patient->user_email) {
            try {
                Mail::to($patient->user_email)->send(new MedicalCardAccessRequestMail($accessRequest));
            } catch (\Exception $e) {
                // Ignore mail sending failure
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Access request sent successfully. The patient will be notified.',
            'data' => $accessRequest
        ], 201);
    }

    /**
     * Get all access requests for the logged-in partner
     * GET /partner-api/medical-card-access/requests
     */
    public function allRequests(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $requests = AccessRequest::where('currently_loggedin_partner_id', $partner->partner_id)
            ->with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Attach encrypted IDs for Flutter client navigation
        $requests = $requests->map(function ($req) {
            if ($req->patient) {
                $req->patient->encrypted_id = Crypt::encryptString((string) $req->patient->id);
            }
            return $req;
        });

        return response()->json([
            'success' => true,
            'data' => $requests
        ]);
    }

    /**
     * View Patient Profile details
     * GET /partner-api/medical-card-access/patient/{encryptedId}
     */
    public function viewPatientProfile(Request $request, string $encryptedId)
    {
        [$dwUserId, $patient, $blocked] = $this->resolvePatient($request, $encryptedId);

        if (!$patient) {
            return response()->json(['success' => false, 'message' => 'Patient not found.'], 404);
        }

        if ($blocked) {
            return response()->json([
                'success' => false,
                'blocked' => true,
                'message' => 'Access request is not accepted or has been turned off by the patient.',
                'patient' => [
                    'id' => $patient->id,
                    'user_name' => $patient->user_name,
                    'medical_card_no' => $patient->medical_card_no,
                ]
            ], 403);
        }

        $partner = $request->user();
        $partnerId = $partner->id;

        $opdBanner = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $doctorBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();

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

        $vital = Vital::where('dw_user_id', $dwUserId)->latest()->first();
        $noOfRequest = AccessRequest::where('dw_user_id', $dwUserId)->count();

        $encryptedPatientId = Crypt::encryptString((string) $dwUserId);

        return response()->json([
            'success' => true,
            'blocked' => false,
            'data' => [
                'patient' => $patient,
                'opdBanner' => $opdBanner,
                'pathologyBanner' => $pathologyBanner,
                'doctorBanner' => $doctorBanner,
                'latestSingleBooking' => $latestSingleBooking,
                'bookings' => $bookings,
                'noOfPrescription' => $noOfPrescription,
                'noOfReport' => $noOfReport,
                'vital' => $vital,
                'noOfRequest' => $noOfRequest,
                'encryptedPatientId' => $encryptedPatientId
            ]
        ]);
    }

    /**
     * View Patient Medical History
     * GET /partner-api/medical-card-access/patient/{encryptedId}/history
     */
    public function viewMedicalHistory(Request $request, string $encryptedId)
    {
        [$dwUserId, $patient, $blocked] = $this->resolvePatient($request, $encryptedId);

        if (!$patient) {
            return response()->json(['success' => false, 'message' => 'Patient not found.'], 404);
        }

        if ($blocked) {
            return response()->json([
                'success' => false,
                'blocked' => true,
                'message' => 'Access request is not accepted or has been turned off by the patient.',
                'patient' => [
                    'id' => $patient->id,
                    'user_name' => $patient->user_name,
                    'medical_card_no' => $patient->medical_card_no,
                ]
            ], 403);
        }

        $histories = MedicalHistory::with(['doctor', 'opd'])->where('dw_user_id', $dwUserId)
            ->orderBy('date_of_report', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        try {
            $systemPrescriptions = SystemPrescription::with(['opd', 'doctor'])
                ->where('dw_user_id', $dwUserId)
                ->orderBy('prescription_date', 'desc')
                ->orderBy('id', 'desc')
                ->get();
        } catch (\Exception $e) {
            $systemPrescriptions = collect();
        }

        $noOfPrescription = MedicalHistory::where('dw_user_id', $dwUserId)
            ->where('type', 'prescription')
            ->count();

        $noOfReport = MedicalHistory::where('dw_user_id', $dwUserId)
            ->where('type', 'report')
            ->count();

        $vital = Vital::where('dw_user_id', $dwUserId)->latest()->first();
        $encryptedPatientId = Crypt::encryptString((string) $dwUserId);

        return response()->json([
            'success' => true,
            'blocked' => false,
            'data' => [
                'patient' => $patient,
                'histories' => $histories,
                'systemPrescriptions' => $systemPrescriptions,
                'noOfPrescription' => $noOfPrescription,
                'noOfReport' => $noOfReport,
                'vital' => $vital,
                'encryptedPatientId' => $encryptedPatientId
            ]
        ]);
    }

    /**
     * View specific medical report details
     * GET /partner-api/medical-card-access/report/{encryptedId}
     */
    public function viewPatientReportDetails(Request $request, string $encryptedId)
    {
        try {
            $recordId = Crypt::decryptString($encryptedId);
        } catch (DecryptException) {
            if (is_numeric($encryptedId)) {
                $recordId = $encryptedId;
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid link.'], 403);
            }
        }

        $record = MedicalHistory::with(['doctor', 'opd'])->find($recordId);
        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found.'], 404);
        }

        $dwUserId = $record->dw_user_id;
        $partner = $request->user();
        $partnerId = $partner->partner_id;

        $access = AccessRequest::where('dw_user_id', $dwUserId)
            ->where('currently_loggedin_partner_id', $partnerId)
            ->first();

        $blocked = !$access
            || $access->req_status !== 'accepted'
            || $access->access_status !== 'on';

        if ($blocked) {
            return response()->json(['success' => false, 'message' => 'Access Blocked.'], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $record
        ]);
    }

    /**
     * Helper method to resolve patient ID and check access rights
     */
    private function resolvePatient(Request $request, string $encryptedId): array
    {
        try {
            $dwUserId = Crypt::decryptString($encryptedId);
        } catch (DecryptException) {
            if (is_numeric($encryptedId)) {
                $dwUserId = $encryptedId;
            } else {
                return [null, null, true];
            }
        }

        $partner = $request->user();
        $partnerId = $partner->partner_id;

        $access = AccessRequest::where('dw_user_id', $dwUserId)
            ->where('currently_loggedin_partner_id', $partnerId)
            ->first();

        $blocked = !$access
            || $access->req_status !== 'accepted'
            || $access->access_status !== 'on';

        $patient = DwUserModel::find($dwUserId);

        return [$dwUserId, $patient, $blocked];
    }
}
