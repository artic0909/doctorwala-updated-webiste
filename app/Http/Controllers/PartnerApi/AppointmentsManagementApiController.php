<?php

namespace App\Http\Controllers\PartnerApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PartnerPatientInquiry;
use Carbon\Carbon;

class AppointmentsManagementApiController extends Controller
{
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

        $query = PartnerPatientInquiry::where(function ($q) use ($partner) {
                $q->where('currently_loggedin_partner_id', $partner->id);
                if (!empty($partner->partner_id)) {
                    $q->orWhere('currently_loggedin_partner_id', $partner->partner_id);
                }
            })
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

        $partnerFilter = function ($q) use ($partner) {
            $q->where('currently_loggedin_partner_id', $partner->id);
            if (!empty($partner->partner_id)) {
                $q->orWhere('currently_loggedin_partner_id', $partner->partner_id);
            }
        };

        $todayDate = Carbon::today()->format('Y-m-d');

        $upcomingCount = PartnerPatientInquiry::where($partnerFilter)
            ->where(function ($q) {
                $q->whereIn('status', ['Upcoming', 'upcoming', 'Confirmed', 'confirmed', 'Pending', 'pending'])
                  ->orWhereNull('status')
                  ->orWhere('status', '');
            })
            ->count();

        $completedCount = PartnerPatientInquiry::where($partnerFilter)
            ->whereIn('status', ['Completed', 'completed'])
            ->count();

        $cancelledCount = PartnerPatientInquiry::where($partnerFilter)
            ->whereIn('status', ['Cancelled', 'cancelled'])
            ->count();

        $todayCount = PartnerPatientInquiry::where($partnerFilter)
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

        $appointment = PartnerPatientInquiry::where(function ($q) use ($partner) {
                $q->where('currently_loggedin_partner_id', $partner->id);
                if (!empty($partner->partner_id)) {
                    $q->orWhere('currently_loggedin_partner_id', $partner->partner_id);
                }
            })
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
        $appointment->save();

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
