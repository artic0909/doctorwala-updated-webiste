<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorAppointmentSlot;
use App\Models\DwPartnerModel;
use App\Models\PartnerPatientInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiDocAppointmentBookingController extends Controller
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
            $data = $validator->validated();
            $clinicType = strtolower($data['clinic_type'] ?? '');
            if ($clinicType === 'doctor') {
                $data['visit_mode'] = 'online';
            } elseif ($clinicType === 'others') {
                $data['visit_mode'] = in_array(strtolower($data['visit_mode'] ?? ''), ['online', 'offline']) ? strtolower($data['visit_mode']) : 'offline';
            }

            // Check if slot already booked in doctor_appointment_slots or inquiries
            if (!empty($data['booking_date']) && !empty($data['booking_time'])) {
                $timeFormatted = substr(trim($data['booking_time']), 0, 5);
                $partner = DwPartnerModel::where('id', $data['currently_loggedin_partner_id'])
                    ->orWhere('partner_id', $data['currently_loggedin_partner_id'])
                    ->first();
                $partnerIds = array_filter([(string)$data['currently_loggedin_partner_id'], $partner?->id ? (string)$partner->id : null, $partner?->partner_id ? (string)$partner->partner_id : null]);

                $alreadyBooked = DoctorAppointmentSlot::whereDate('slot_date', $data['booking_date'])
                    ->whereIn('currently_loggedin_partner_id', $partnerIds)
                    ->when(!empty($data['doctor_id']), fn($q) => $q->where('doctor_id', $data['doctor_id']))
                    ->where('start_time', 'like', $timeFormatted . '%')
                    ->where('status', 'booked')
                    ->exists();

                if (!$alreadyBooked) {
                    $alreadyBooked = PartnerPatientInquiry::whereDate('booking_date', $data['booking_date'])
                        ->where(function ($q) use ($partnerIds, $data) {
                            $q->whereIn('currently_loggedin_partner_id', $partnerIds);
                            if (!empty($data['doctor_id'])) {
                                $q->where('doctor_id', $data['doctor_id']);
                            }
                        })
                        ->where('booking_time', 'like', $timeFormatted . '%')
                        ->whereNotIn(\Illuminate\Support\Facades\DB::raw('LOWER(status)'), ['cancelled', 'rejected'])
                        ->exists();
                }

                if ($alreadyBooked) {
                    return response()->json([
                        'status'  => false,
                        'message' => "The 10-minute slot at {$timeFormatted} on {$data['booking_date']} has already been booked by another patient.",
                    ], 422);
                }
            }

            $inquiry = PartnerPatientInquiry::create($data);

            // Mark slot as booked in doctor_appointment_slots table
            if (!empty($data['booking_date']) && !empty($data['booking_time'])) {
                $timeFormatted = substr(trim($data['booking_time']), 0, 5);
                $partnerIds = array_filter([(string)$data['currently_loggedin_partner_id'], $partner?->id ? (string)$partner->id : null, $partner?->partner_id ? (string)$partner->partner_id : null]);

                $slotRecord = DoctorAppointmentSlot::whereDate('slot_date', $data['booking_date'])
                    ->whereIn('currently_loggedin_partner_id', $partnerIds)
                    ->when(!empty($data['doctor_id']), fn($q) => $q->where('doctor_id', $data['doctor_id']))
                    ->where('start_time', 'like', $timeFormatted . '%')
                    ->first();

                if ($slotRecord) {
                    $slotRecord->update([
                        'status' => 'booked',
                        'dw_user_id' => $inquiry->dw_user_id,
                        'patient_name' => $inquiry->user_name,
                        'patient_mobile' => $inquiry->user_mobile,
                        'patient_email' => $inquiry->user_email,
                        'inquiry_id' => $inquiry->id,
                    ]);
                } else {
                    DoctorAppointmentSlot::create([
                        'currently_loggedin_partner_id' => (string) ($partner ? $partner->id : $data['currently_loggedin_partner_id']),
                        'doctor_id' => (int) ($data['doctor_id'] ?? 0),
                        'clinic_type' => $data['clinic_type'] ?? 'Doctor',
                        'slot_date' => $data['booking_date'],
                        'shift' => strtolower($data['booking_slot'] ?? 'morning'),
                        'shift_name' => ucfirst($data['booking_slot'] ?? 'Morning'),
                        'slot_number' => 1,
                        'slot_name' => 'Booked Slot',
                        'start_time' => $timeFormatted,
                        'end_time' => date('H:i', strtotime($timeFormatted . ' +10 minutes')),
                        'status' => 'booked',
                        'dw_user_id' => $inquiry->dw_user_id,
                        'patient_name' => $inquiry->user_name,
                        'patient_mobile' => $inquiry->user_mobile,
                        'patient_email' => $inquiry->user_email,
                        'inquiry_id' => $inquiry->id,
                    ]);
                }
            }

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
