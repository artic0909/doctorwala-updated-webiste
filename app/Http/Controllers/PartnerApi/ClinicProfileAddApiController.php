<?php

namespace App\Http\Controllers\PartnerApi;

use App\Http\Controllers\Controller;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerPathologyContactModel;
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

        $registrationTypes = $partner->registration_type;
        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }

        return response()->json([
            'status' => true,
            'contact_details' => $contactDetails,
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

            return response()->json([
                'status' => true,
                'message' => $message,
                'contact_details' => $contactDetails
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

        $registrationTypes = $partner->registration_type;
        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }

        return response()->json([
            'status' => true,
            'contact_details' => $contactDetails,
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

            return response()->json([
                'status' => true,
                'message' => $message,
                'contact_details' => $contactDetails
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while saving contact details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
