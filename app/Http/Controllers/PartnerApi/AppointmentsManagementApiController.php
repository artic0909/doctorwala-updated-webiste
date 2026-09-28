<?php

namespace App\Http\Controllers\PartnerApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PartnerPatientInquiry;
use Carbon\Carbon;

class AppointmentsManagementApiController extends Controller
{
    /**
     * Build base query for inquiries belonging to this partner across all associations.
     */
    protected function getPartnerInquiriesQuery($partner)
    {
        $partnerIds = array_values(array_filter([$partner->id, $partner->partner_id]));

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

        return PartnerPatientInquiry::where(function ($q) use ($partnerIds, $contactIds, $allClinicNames, $doctorIds) {
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
    }

    /**
     * Get appointments for the authenticated partner.
     * Supports optional status filtering (Upcoming, Confirmed, Completed, Cancelled).
     */
    public function index(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $status = $request->query('status');

        $query = $this->getPartnerInquiriesQuery($partner)
            ->with(['user', 'doctor', 'test', 'doctorContact', 'opdContact', 'pathologyContact']);

        if ($status) {
            if (str_contains($status, ',')) {
                $statuses = array_map('trim', explode(',', $status));
            } else {
                $statuses = [trim($status)];
            }

            $query->where(function ($q) use ($statuses) {
                $hasUpcoming = in_array('Upcoming', $statuses, true) || in_array('upcoming', $statuses, true);
                $hasConfirmed = in_array('Confirmed', $statuses, true) || in_array('confirmed', $statuses, true);
                $hasCompleted = in_array('Completed', $statuses, true) || in_array('completed', $statuses, true);
                $hasCancelled = in_array('Cancelled', $statuses, true) || in_array('cancelled', $statuses, true);

                $targetStatuses = [];
                if ($hasUpcoming) {
                    $targetStatuses = array_merge($targetStatuses, ['Upcoming', 'upcoming', 'Pending', 'pending']);
                }
                if ($hasConfirmed) {
                    $targetStatuses = array_merge($targetStatuses, ['Confirmed', 'confirmed']);
                }
                if ($hasCompleted) {
                    $targetStatuses = array_merge($targetStatuses, ['Completed', 'completed']);
                }
                if ($hasCancelled) {
                    $targetStatuses = array_merge($targetStatuses, ['Cancelled', 'cancelled']);
                }

                if (!empty($targetStatuses)) {
                    $q->whereIn('status', array_unique($targetStatuses));
                }

                // If filtering for upcoming or confirmed, also capture appointments with empty or null status
                if ($hasUpcoming || $hasConfirmed) {
                    $q->orWhereNull('status')->orWhere('status', '');
                }
            });
        }

        $appointments = $query->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'appointments' => $appointments
        ]);
    }

    /**
     * Get count statistics of appointments for the authenticated partner.
     */
    public function stats(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $todayDate = Carbon::today()->format('Y-m-d');

        $upcomingCount = $this->getPartnerInquiriesQuery($partner)
            ->where(function ($q) {
                $q->whereIn('status', ['Upcoming', 'upcoming', 'Confirmed', 'confirmed', 'Pending', 'pending'])
                  ->orWhereNull('status')
                  ->orWhere('status', '');
            })
            ->count();

        $completedCount = $this->getPartnerInquiriesQuery($partner)
            ->whereIn('status', ['Completed', 'completed'])
            ->count();

        $cancelledCount = $this->getPartnerInquiriesQuery($partner)
            ->whereIn('status', ['Cancelled', 'cancelled'])
            ->count();

        $todayCount = $this->getPartnerInquiriesQuery($partner)
            ->whereDate('booking_date', $todayDate)
            ->where(function ($q) {
                $q->whereIn('status', ['Upcoming', 'upcoming', 'Confirmed', 'confirmed', 'Pending', 'pending', 'Completed', 'completed'])
                  ->orWhereNull('status')
                  ->orWhere('status', '');
            })
            ->count();

        return response()->json([
            'success' => true,
            'stats' => [
                'upcoming_count' => $upcomingCount,
                'completed_count' => $completedCount,
                'cancelled_count' => $cancelledCount,
                'today_count' => $todayCount
            ]
        ]);
    }

    /**
     * Update the status of an appointment.
     */
    public function updateStatus(Request $request, $id)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $request->validate([
            'status' => 'required|in:Pending,Upcoming,Confirmed,Completed,Cancelled,pending,upcoming,confirmed,completed,cancelled'
        ]);

        $formattedStatus = ucfirst(strtolower($request->status));

        $appointment = $this->getPartnerInquiriesQuery($partner)
            ->with(['doctor', 'test'])
            ->where('id', $id)
            ->first();

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found.'
            ], 404);
        }

        $oldStatus = $appointment->status ?? 'Upcoming';
        $appointment->status = $formattedStatus;

        // If appointment is confirmed and is a video consultation, ensure video channel and scheduled status
        $isVideo = $appointment->is_video || in_array(strtolower($appointment->visit_mode ?? ''), ['online', 'video']);
        if ($isVideo) {
            $appointment->is_video = true;
            if ($formattedStatus === 'Confirmed' && empty($appointment->video_channel)) {
                $appointment->video_channel = 'dw_vc_' . \Illuminate\Support\Str::random(24);
                $appointment->video_status = 'scheduled';
            } elseif ($formattedStatus === 'Cancelled') {
                $appointment->video_status = 'cancelled';
            } elseif ($formattedStatus === 'Completed') {
                $appointment->video_status = 'completed';
            }
        }

        $appointment->save();

        // If confirmed and is a video consultation, dispatch FCM notification to patient
        if ($formattedStatus === 'Confirmed' && $isVideo && $oldStatus !== 'Confirmed') {
            try {
                $fcmService = new \App\Services\FcmNotificationService();
                $fcmService->sendVideoAppointmentAcceptedNotification($appointment);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('FCM Notification Error on Confirmation: ' . $e->getMessage());
            }
        }

        // Send Twilio WhatsApp Message on Status Change
        if ($appointment->user_mobile) {
            try {
                $twilioService = new \App\Services\TwilioWhatsAppService();
                
                // Confirm appointment
                if ($formattedStatus === 'Confirmed' && $oldStatus !== 'Confirmed') {
                    $twilioService->sendUserConfirmationAlert($appointment);
                } 
                // Cancel appointment
                elseif ($formattedStatus === 'Cancelled' && $oldStatus !== 'Cancelled') {
                    $twilioService->sendUserCancellationAlert($appointment);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Twilio Error in updateStatus: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Appointment status updated from {$oldStatus} to {$formattedStatus} successfully.",
            'appointment' => $appointment
        ]);
    }
}
