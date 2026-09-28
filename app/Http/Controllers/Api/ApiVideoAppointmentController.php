<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DwPartnerModel;
use App\Models\DwUserModel;
use App\Models\PartnerPatientInquiry;
use App\Services\AgoraTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiVideoAppointmentController extends Controller
{
    protected AgoraTokenService $agoraTokenService;

    public function __construct(AgoraTokenService $agoraTokenService)
    {
        $this->agoraTokenService = $agoraTokenService;
    }

    /**
     * Generate an Agora RTC Video Token for an appointment.
     *
     * Only authorized patient or partner/doctor can request it.
     * Only allowed when confirmed and within the video window (-10m to +60m).
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateToken(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $appointment = PartnerPatientInquiry::with(['user', 'doctor', 'opdContact', 'doctorContact', 'pathologyContact'])->find($id);
        if (!$appointment) {
            return response()->json([
                'status'  => false,
                'message' => 'Appointment not found.'
            ], 404);
        }

        // 1. Authorize User/Partner
        $isPatient = ($user instanceof DwUserModel && $appointment->dw_user_id == $user->id);
        $isPartner = false;

        if ($user instanceof DwPartnerModel) {
            $isPartner = $this->isPartnerAuthorizedForAppointment($user, $appointment);
        }

        if (!$isPatient && !$isPartner) {
            return response()->json([
                'status'  => false,
                'message' => 'Forbidden. You are not an authorized participant for this appointment.'
            ], 403);
        }

        // 2. Validate Video Eligibility
        $isVideo = $appointment->is_video || in_array(strtolower($appointment->visit_mode ?? ''), ['online', 'video']);
        if (!$isVideo) {
            return response()->json([
                'status'  => false,
                'message' => 'This appointment is not scheduled for a video consultation.'
            ], 422);
        }

        // 3. Validate Status
        $activeStatuses = ['Upcoming', 'upcoming', 'Confirmed', 'confirmed', 'Pending', 'pending'];
        if (!in_array($appointment->status ?? 'Upcoming', $activeStatuses) && !empty($appointment->status)) {
            return response()->json([
                'status'  => false,
                'message' => "Appointment is {$appointment->status}. Video consultation is only available for active upcoming appointments."
            ], 422);
        }

        // 4. Validate Time Window (-10 mins to +60 mins)
        if (!$appointment->isWithinVideoWindow()) {
            $windowStart = $appointment->getVideoWindowStart();
            $formattedStart = $windowStart ? $windowStart->format('h:i A, d M Y') : '10 minutes before scheduled time';

            return response()->json([
                'status'       => false,
                'message'      => "Video call room is not open yet. It opens 10 minutes before the scheduled time ({$formattedStart}).",
                'window_start' => $windowStart ? $windowStart->toIso8601String() : null,
                'is_open'      => false,
            ], 422);
        }

        // 5. Ensure Unique Channel Name
        $channelName = $appointment->ensureVideoChannel();

        // 6. Assign Distinct Numeric UID for Agora
        // Patient uses offset 100000 + ID, Partner uses offset 200000 + ID to avoid UID collisions
        $uid = $isPatient ? (100000 + (int)$user->id) : (200000 + (int)$user->id);

        try {
            $tokenData = $this->agoraTokenService->generateRtcToken($channelName, $uid);

            // Update video status to live if first participant joins
            if ($appointment->video_status === 'scheduled') {
                $appointment->video_status = 'live';
                $appointment->save();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Agora token generated successfully.',
                'data'    => [
                    'app_id'            => $tokenData['app_id'],
                    'channel'           => $tokenData['channel'],
                    'uid'               => (int) $tokenData['uid'],
                    'token'             => $tokenData['token'],
                    'role'              => $isPatient ? 'patient' : 'doctor',
                    'expires_at'        => $tokenData['expires_at'],
                    'expires_in'        => $tokenData['expires_in'],
                    'appointment_id'    => $appointment->id,
                    'patient_name'      => $appointment->user_name,
                    'doctor_name'       => $appointment->doctor->doctor_name ?? $appointment->doctorContact->partner_doctor_name ?? $appointment->clinic_name,
                    'scheduled_time'    => "{$appointment->booking_date} {$appointment->booking_time}",
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Agora Token Generation Error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Failed to generate video session token: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update video call status (live, completed, missed, cancelled)
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateVideoStatus(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized.'], 401);
        }

        $request->validate([
            'video_status' => 'required|in:scheduled,live,completed,missed,cancelled'
        ]);

        $appointment = PartnerPatientInquiry::find($id);
        if (!$appointment) {
            return response()->json(['status' => false, 'message' => 'Appointment not found.'], 404);
        }

        $isPatient = ($user instanceof DwUserModel && $appointment->dw_user_id == $user->id);
        $isPartner = ($user instanceof DwPartnerModel && $this->isPartnerAuthorizedForAppointment($user, $appointment));

        if (!$isPatient && !$isPartner) {
            return response()->json(['status' => false, 'message' => 'Forbidden.'], 403);
        }

        $appointment->video_status = $request->video_status;
        if ($request->video_status === 'completed' && $isPartner) {
            $appointment->status = 'Completed';
        }
        $appointment->save();

        return response()->json([
            'status'  => true,
            'message' => 'Video status updated successfully.',
            'data'    => [
                'video_status' => $appointment->video_status,
                'status'       => $appointment->status,
            ]
        ]);
    }

    /**
     * Check if a DwPartnerModel instance owns/is authorized for the appointment.
     */
    protected function isPartnerAuthorizedForAppointment(DwPartnerModel $partner, PartnerPatientInquiry $appointment): bool
    {
        $partnerIds = array_values(array_filter([$partner->id, $partner->partner_id]));

        if (in_array($appointment->currently_loggedin_partner_id, $partnerIds)) {
            return true;
        }

        // Check contacts
        $opdIds = \App\Models\PartnerOPDContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->pluck('id')->toArray();
        $pathIds = \App\Models\PartnerPathologyContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->pluck('id')->toArray();
        $docIds = \App\Models\PartnerDoctorContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->pluck('id')->toArray();

        $allContactIds = array_merge($opdIds, $pathIds, $docIds);
        if (in_array($appointment->currently_loggedin_partner_id, $allContactIds)) {
            return true;
        }

        // Check clinic names
        $opdNames = \App\Models\PartnerOPDContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->pluck('clinic_name')->toArray();
        $pathNames = \App\Models\PartnerPathologyContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->pluck('clinic_name')->toArray();
        $docNames = \App\Models\PartnerDoctorContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->pluck('partner_doctor_name')->toArray();

        $allNames = array_filter(array_unique(array_merge([$partner->partner_clinic_name], $opdNames, $pathNames, $docNames)));
        if (in_array($appointment->clinic_name, $allNames)) {
            return true;
        }

        // Check doctor ID
        $doctorIds = \App\Models\PartnerAllOPDDoctorModel::whereIn('currently_loggedin_partner_id', $partnerIds)->pluck('id')->toArray();
        if (!empty($appointment->doctor_id) && in_array($appointment->doctor_id, $doctorIds)) {
            return true;
        }

        return false;
    }
}
