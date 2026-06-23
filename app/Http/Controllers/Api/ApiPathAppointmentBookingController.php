<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerPatientInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPathAppointmentBookingController extends Controller
{
    public function patientInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currently_loggedin_partner_id' => 'required|string',
            'clinic_type'                   => 'required|string',
            'clinic_name'                   => 'required|string',
            'user_name'                     => 'required|string|max:255',
            'user_mobile'                   => 'required|string|max:20',
            'user_email'                    => 'nullable|email|max:255',
            'user_inquiry'                  => 'required|string',

            'dw_user_id'   => 'nullable|exists:dw_user_models,id',
            'test_id'      => 'nullable|exists:partner_all_pathology_test_models,id',
            'booking_date' => 'nullable|date',
            'booking_time' => 'nullable|date_format:H:i',
            'visit_mode'   => 'nullable|in:online,offline,video,home_visit',
        ], [
            'user_email.email'         => 'Please enter a valid email address.',
            'dw_user_id.exists'        => 'Selected user does not exist.',
            'booking_date.date'        => 'Invalid booking date.',
            'booking_time.date_format' => 'Booking time must be in HH:MM format.',
            'visit_mode.in'            => 'Visit mode must be online, offline, video, or home_visit.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $inquiry = PartnerPatientInquiry::create($validator->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Your inquiry has been sent successfully!',
                'data'    => $inquiry
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to send your inquiry. Please try again.',
            ], 500);
        }
    }
}
