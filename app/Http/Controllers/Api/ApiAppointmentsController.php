<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerPatientInquiry;
use Illuminate\Http\Request;

class ApiAppointmentsController extends Controller
{
    /**
     * Get all appointments of authenticated user
     */
    public function getAppointments(Request $request)
    {
        try {
            $user = $request->user();

            $bookings = PartnerPatientInquiry::where('dw_user_id', $user->id)
                ->with([
                    'opdContact.banner',
                    'pathologyContact.banner',
                    'doctorContact.banner',
                    'user',
                    'doctor',
                    'test'
                ])
                ->latest()
                ->get()
                ->map(fn($b) => $this->formatBooking($b));

            return response()->json([
                'status'  => true,
                'message' => 'Appointments fetched successfully.',
                'total'   => $bookings->count(),
                'data'    => $bookings,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Get appointments filtered by status
     * Allowed: Upcoming | Completed | Cancelled
     */
    public function getAppointmentsByStatus(Request $request, $status)
    {
        try {
            // UPDATED: Changed 'Pending' to 'Upcoming'
            $allowed = ['Upcoming', 'Completed', 'Cancelled'];

            if (!in_array($status, $allowed)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid status. Allowed: Upcoming, Completed, Cancelled.',
                ], 422);
            }

            $bookings = PartnerPatientInquiry::where('dw_user_id', $request->user()->id)
                ->where('status', $status)
                ->with([
                    'opdContact.banner',
                    'pathologyContact.banner',
                    'doctorContact.banner',
                    'user',
                    'doctor',
                    'test'
                ])
                ->latest()
                ->get()
                ->map(fn($b) => $this->formatBooking($b));

            return response()->json([
                'status'  => true,
                'message' => ucfirst($status) . ' appointments fetched successfully.',
                'total'   => $bookings->count(),
                'data'    => $bookings,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Mark appointment as Completed
     */
    public function markAsCompleted(Request $request, $id)
    {
        try {
            $inquiry = PartnerPatientInquiry::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            $inquiry->status = 'Completed';
            $inquiry->save();

            return response()->json([
                'status'  => true,
                'message' => 'Appointment marked as completed.',
                'data'    => $this->formatBooking($inquiry->fresh()),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Appointment not found or unauthorized.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Cancel appointment
     */
    public function cancelAppointment(Request $request, $id)
    {
        try {
            $inquiry = PartnerPatientInquiry::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            // Only allow cancellation if NOT already completed
            if ($inquiry->status === 'Completed') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Completed appointments cannot be cancelled.',
                ], 422);
            }

            $inquiry->status = 'Cancelled';
            $inquiry->save();

            // Send Twilio WhatsApp Message for User Cancellation
            if ($inquiry->user_mobile) {
                try {
                    $twilioService = new \App\Services\TwilioWhatsAppService();
                    $inquiry->load(['doctor', 'test']); // Eager load for template variables
                    $twilioService->sendUserCancellationAlert($inquiry);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Twilio Error in user cancelAppointment: ' . $e->getMessage());
                }
            }

            return response()->json([
                'status'  => true,
                'message' => 'Appointment has been cancelled.',
                'data'    => $this->formatBooking($inquiry->fresh()),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Appointment not found or unauthorized.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Helper — format booking with full banner image URLs
     */
    private function formatBooking(PartnerPatientInquiry $booking): array
    {
        $data = $booking->toArray();

        // Fix OPD banner URL
        if (isset($data['opd_contact']['banner']['opdbanner']) && $data['opd_contact']['banner']['opdbanner']) {
            $data['opd_contact']['banner']['opdbanner'] = asset('storage/' . $booking->opdContact->banner->opdbanner);
        }

        // Fix Pathology banner URL
        if (isset($data['pathology_contact']['banner']['pathologybanner']) && $data['pathology_contact']['banner']['pathologybanner']) {
            $data['pathology_contact']['banner']['pathologybanner'] = asset('storage/' . $booking->pathologyContact->banner->pathologybanner);
        }

        // Fix Doctor banner URL
        if (isset($data['doctor_contact']['banner']['doctorbanner']) && $data['doctor_contact']['banner']['doctorbanner']) {
            $data['doctor_contact']['banner']['doctorbanner'] = asset('storage/' . $booking->doctorContact->banner->doctorbanner);
        }

        return $data;
    }
}
