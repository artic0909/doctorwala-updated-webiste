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
     * Supports optional status filtering (Upcoming, Completed, Cancelled).
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

        $query = PartnerPatientInquiry::where('currently_loggedin_partner_id', $partner->id)
            ->with(['user', 'doctor', 'test']);

        if ($status) {
            if (str_contains($status, ',')) {
                $statuses = array_map('trim', explode(',', $status));
                $query->whereIn('status', $statuses);
            } else {
                $query->where('status', trim($status));
            }
        }

        $appointments = $query->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
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

        $partnerId = $partner->id;
        $todayDate = Carbon::today()->format('Y-m-d');

        $upcomingCount = PartnerPatientInquiry::where('currently_loggedin_partner_id', $partnerId)
            ->where('status', 'Upcoming')
            ->count();

        $completedCount = PartnerPatientInquiry::where('currently_loggedin_partner_id', $partnerId)
            ->where('status', 'Completed')
            ->count();

        $cancelledCount = PartnerPatientInquiry::where('currently_loggedin_partner_id', $partnerId)
            ->where('status', 'Cancelled')
            ->count();

        $todayCount = PartnerPatientInquiry::where('currently_loggedin_partner_id', $partnerId)
            ->whereDate('booking_date', $todayDate)
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
            'status' => 'required|in:Upcoming,Completed,Cancelled'
        ]);

        $appointment = PartnerPatientInquiry::where('currently_loggedin_partner_id', $partner->id)
            ->with(['doctor', 'test']) // Eager load relationships for Twilio templates
            ->where('id', $id)
            ->first();

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found.'
            ], 404);
        }

        $oldStatus = $appointment->status;
        $appointment->status = $request->status;
        $appointment->save();

        // Send Twilio WhatsApp Message on Status Change
        if ($appointment->user_mobile) {
            try {
                $twilioService = new \App\Services\TwilioWhatsAppService();
                
                // Confirm appointment
                if ($request->status === 'Upcoming' && $oldStatus !== 'Upcoming') {
                    $twilioService->sendUserConfirmationAlert($appointment);
                } 
                // Cancel appointment
                elseif ($request->status === 'Cancelled' && $oldStatus !== 'Cancelled') {
                    $twilioService->sendUserCancellationAlert($appointment);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Twilio Error in updateStatus: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Appointment status updated from {$oldStatus} to {$request->status} successfully.",
            'appointment' => $appointment
        ]);
    }
}
