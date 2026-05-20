<?php

namespace App\Http\Controllers\PartnerApi;

use App\Http\Controllers\Controller;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerPathologyContactModel;
use App\Models\PartnerDoctorContactModel;
use App\Models\PartnerOPDBannerModel;
use App\Models\PartnerPathologyBannerModel;
use App\Models\PartnerDoctorBannerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClinicProfileAddApiController extends Controller
{
    /**
     * Get OPD (Doctor Chamber) Contact Details
     */
    public function getOPDContact(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $contactDetails = PartnerOPDContactModel::where('currently_loggedin_partner_id', $partner->id)->first();
        $opdBanner = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partner->id)->first();

        $registrationTypes = $partner->registration_type;
        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }

        return response()->json([
            'status' => true,
            'contact_details' => $contactDetails,
            'opd_banner' => $opdBanner ? asset('storage/' . $opdBanner->opdbanner) : null,
            'registration_types' => $registrationTypes,
            'partner' => [
                'id' => $partner->id,
                'status' => $partner->status,
            ]
        ], 200);
    }

    /**
     * Store or Update OPD (Doctor Chamber) Contact Details
     */
    public function storeOPDContact(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'clinic_registration_type' => 'required|string',
            'clinic_contact_person_name' => 'required|string|max:255',
            'clinic_name' => 'required|string',
            'clinic_gstin' => 'nullable|string',
            'clinic_mobile_number' => 'required|string|max:15',
            'clinic_email' => 'required|email|max:255',
            'clinic_landmark' => 'required|string|max:255',
            'clinic_pincode' => 'required|numeric|digits:6',
            'clinic_state' => 'required|string|max:255',
            'clinic_city' => 'required|string|max:255',
            'clinic_google_map_link' => 'nullable|string|max:500',
            'clinic_address' => 'required|string',
            'opdbanner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $partnerId = $partner->id;
            $partnerStatus = $partner->status;

            $contactDetails = PartnerOPDContactModel::where('currently_loggedin_partner_id', $partnerId)
                ->where('status', $partnerStatus)
                ->first();

            $data = [
                'clinic_registration_type' => $request->clinic_registration_type,
                'clinic_contact_person_name' => $request->clinic_contact_person_name,
                'clinic_name' => $request->clinic_name,
                'clinic_gstin' => $request->clinic_gstin,
                'clinic_mobile_number' => $request->clinic_mobile_number,
                'clinic_email' => $request->clinic_email,
                'clinic_landmark' => $request->clinic_landmark,
                'clinic_pincode' => $request->clinic_pincode,
                'clinic_state' => $request->clinic_state,
                'clinic_city' => $request->clinic_city,
                'clinic_google_map_link' => $request->clinic_google_map_link,
                'clinic_address' => $request->clinic_address,
                'status' => $partnerStatus,
            ];

            if ($contactDetails) {
                $contactDetails->update($data);
                $message = 'OPD contact details updated successfully.';
            } else {
                $data['currently_loggedin_partner_id'] = $partnerId;
                $contactDetails = PartnerOPDContactModel::create($data);
                $message = 'OPD contact details saved successfully.';
            }

            // Handle OPD banner upload
            $opdBannerPath = null;
            if ($request->hasFile('opdbanner')) {
                $opdBannerPath = $request->file('opdbanner')->store('partner-opd-profile', 'public');
            }

            $opdBanner = null;
            if ($opdBannerPath) {
                $opdBanner = PartnerOPDBannerModel::firstOrNew(['currently_loggedin_partner_id' => $partnerId]);
                $opdBanner->opdbanner = $opdBannerPath;
                $opdBanner->save();
            } else {
                $opdBanner = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'contact_details' => $contactDetails,
                'opd_banner' => $opdBanner ? asset('storage/' . $opdBanner->opdbanner) : null,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while saving contact details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Pathology Contact Details
     */
    public function getPathologyContact(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $contactDetails = PartnerPathologyContactModel::where('currently_loggedin_partner_id', $partner->id)->first();
        $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partner->id)->first();

        $registrationTypes = $partner->registration_type;
        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }

        return response()->json([
            'status' => true,
            'contact_details' => $contactDetails,
            'pathology_banner' => $pathologyBanner ? asset('storage/' . $pathologyBanner->pathologybanner) : null,
            'registration_types' => $registrationTypes,
            'partner' => [
                'id' => $partner->id,
                'status' => $partner->status,
            ]
        ], 200);
    }

    /**
     * Store or Update Pathology Contact Details
     */
    public function storePathologyContact(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'clinic_registration_type' => 'required|string',
            'clinic_contact_person_name' => 'required|string|max:255',
            'clinic_name' => 'required|string',
            'clinic_gstin' => 'nullable|string',
            'clinic_mobile_number' => 'required|string|max:15',
            'clinic_email' => 'required|email|max:255',
            'clinic_landmark' => 'required|string|max:255',
            'clinic_pincode' => 'required|numeric|digits:6',
            'clinic_state' => 'required|string|max:255',
            'clinic_city' => 'required|string|max:255',
            'clinic_google_map_link' => 'nullable|string|max:500',
            'clinic_address' => 'required|string',
            'pathologybanner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $partnerId = $partner->id;
            $partnerStatus = $partner->status;

            $contactDetails = PartnerPathologyContactModel::where('currently_loggedin_partner_id', $partnerId)
                ->where('status', $partnerStatus)
                ->first();

            $data = [
                'clinic_registration_type' => $request->clinic_registration_type,
                'clinic_contact_person_name' => $request->clinic_contact_person_name,
                'clinic_name' => $request->clinic_name,
                'clinic_gstin' => $request->clinic_gstin,
                'clinic_mobile_number' => $request->clinic_mobile_number,
                'clinic_email' => $request->clinic_email,
                'clinic_landmark' => $request->clinic_landmark,
                'clinic_pincode' => $request->clinic_pincode,
                'clinic_state' => $request->clinic_state,
                'clinic_city' => $request->clinic_city,
                'clinic_google_map_link' => $request->clinic_google_map_link,
                'clinic_address' => $request->clinic_address,
                'status' => $partnerStatus,
            ];

            if ($contactDetails) {
                $contactDetails->update($data);
                $message = 'Pathology contact details updated successfully.';
            } else {
                $data['currently_loggedin_partner_id'] = $partnerId;
                $contactDetails = PartnerPathologyContactModel::create($data);
                $message = 'Pathology contact details saved successfully.';
            }

            // Handle Pathology banner upload
            $pathologyBannerPath = null;
            if ($request->hasFile('pathologybanner')) {
                $pathologyBannerPath = $request->file('pathologybanner')->store('partner-pathology-profile', 'public');
            }

            $pathologyBanner = null;
            if ($pathologyBannerPath) {
                $pathologyBanner = PartnerPathologyBannerModel::firstOrNew(['currently_loggedin_partner_id' => $partnerId]);
                $pathologyBanner->pathologybanner = $pathologyBannerPath;
                $pathologyBanner->save();
            } else {
                $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'contact_details' => $contactDetails,
                'pathology_banner' => $pathologyBanner ? asset('storage/' . $pathologyBanner->pathologybanner) : null,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while saving contact details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Doctor Contact Details
     */
    public function getDoctorContact(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $contactDetails = PartnerDoctorContactModel::where('currently_loggedin_partner_id', $partner->id)->first();
        $doctorBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partner->id)->first();
        $contactCount = PartnerDoctorContactModel::where('currently_loggedin_partner_id', $partner->id)->count();

        $registrationTypes = $partner->registration_type;
        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }

        return response()->json([
            'status' => true,
            'contact_details' => $contactDetails,
            'doctor_banner' => $doctorBanner ? asset('storage/' . $doctorBanner->doctorbanner) : null,
            'contact_count' => $contactCount,
            'registration_types' => $registrationTypes,
            'partner' => [
                'id' => $partner->id,
                'status' => $partner->status,
            ]
        ], 200);
    }

    /**
     * Store or Update Doctor Contact Details
     */
    public function storeDoctorContact(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'clinic_registration_type' => 'required|string',
            'partner_doctor_name' => 'required|string',
            'partner_doctor_specialist' => 'required|string',
            'partner_doctor_designation' => 'required|string',
            'partner_doctor_fees' => 'required|string',
            'partner_doctor_mobile' => 'required|string|max:15',
            'partner_doctor_email' => 'required|email',
            'partner_doctor_landmark' => 'required|string',
            'partner_doctor_pincode' => 'required|string|max:10',
            'partner_doctor_google_map_link' => 'nullable|url',
            'partner_doctor_state' => 'required|string',
            'partner_doctor_city' => 'required|string',
            'partner_doctor_address' => 'required|string',
            'partner_doctor_visit_day' => 'required|array',
            'partner_doctor_visit_day.*' => 'required|string',
            'partner_doctor_visit_start_time' => 'required|array',
            'partner_doctor_visit_start_time.*' => 'date_format:H:i',
            'partner_doctor_visit_end_time' => 'required|array',
            'partner_doctor_visit_end_time.*' => 'date_format:H:i|after:partner_doctor_visit_start_time.*',
            'doctorbanner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $partnerId = $partner->id;
            $partnerStatus = $partner->status;

            $visitDayTime = [];
            if ($request->has('partner_doctor_visit_day')) {
                foreach ($request->partner_doctor_visit_day as $index => $day) {
                    $visitDayTime[] = [
                        'day' => $day,
                        'start_time' => $request->partner_doctor_visit_start_time[$index] ?? null,
                        'end_time' => $request->partner_doctor_visit_end_time[$index] ?? null,
                    ];
                }
            }

            $validatedData = $validator->validated();
            $validatedData['visit_day_time'] = $visitDayTime;
            $validatedData['currently_loggedin_partner_id'] = $partnerId;
            $validatedData['status'] = $partnerStatus;

            // Remove array fields and file fields to avoid issues with direct insertion
            unset($validatedData['partner_doctor_visit_day']);
            unset($validatedData['partner_doctor_visit_start_time']);
            unset($validatedData['partner_doctor_visit_end_time']);
            unset($validatedData['doctorbanner']);

            $contactDetails = PartnerDoctorContactModel::updateOrCreate(
                ['currently_loggedin_partner_id' => $partnerId],
                $validatedData
            );

            // Handle Doctor banner upload
            $doctorBannerPath = null;
            if ($request->hasFile('doctorbanner')) {
                $doctorBannerPath = $request->file('doctorbanner')->store('partner-doctor-profile', 'public');
            }

            $doctorBanner = null;
            if ($doctorBannerPath) {
                $doctorBanner = PartnerDoctorBannerModel::firstOrNew(['currently_loggedin_partner_id' => $partnerId]);
                $doctorBanner->doctorbanner = $doctorBannerPath;
                $doctorBanner->save();
            } else {
                $doctorBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
            }

            return response()->json([
                'status' => true,
                'message' => 'Doctor contact saved successfully!',
                'contact_details' => $contactDetails,
                'doctor_banner' => $doctorBanner ? asset('storage/' . $doctorBanner->doctorbanner) : null,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while saving doctor contact details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
