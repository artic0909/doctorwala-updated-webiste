<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\DwPartnerModel;
use App\Models\PartnerPatientInquiry;
use App\Services\TwilioWhatsAppService;

class TwilioWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Twilio Webhook Received:', $request->all());

        $from = $request->input('From');
        $buttonPayload = $request->input('ButtonPayload');
        $body = $request->input('Body');

        // Determine action via robust case-insensitive substring match
        $action = null;
        if (
            (is_string($buttonPayload) && stripos($buttonPayload, 'confirm') !== false) ||
            (is_string($body) && stripos($body, 'confirm') !== false)
        ) {
            $action = 'Confirmed';
        } elseif (
            (is_string($buttonPayload) && stripos($buttonPayload, 'cancel') !== false) ||
            (is_string($body) && stripos($body, 'cancel') !== false)
        ) {
            $action = 'Cancelled';
        }

        // Always return TwiML 200 OK so Twilio doesn't throw errors
        $twimlResponse = response('<Response></Response>', 200)->header('Content-Type', 'text/xml');

        if (!$action || empty($from)) {
            return $twimlResponse;
        }

        // Clean phone number
        $cleanPhone = str_replace(['whatsapp:', '+', ' '], '', $from);
        
        if (strlen($cleanPhone) < 10) {
            Log::warning('Webhook: Invalid phone number length: ' . $cleanPhone);
            return $twimlResponse;
        }

        // Try to find the partner by mobile number
        $partner = DwPartnerModel::where('partner_mobile_number', $cleanPhone)
            ->orWhere('partner_mobile_number', 'like', '%' . substr($cleanPhone, -10))
            ->first();

        if (!$partner) {
            Log::warning('Webhook: Partner not found for mobile: ' . $cleanPhone);
            return $twimlResponse;
        }

        // Find the most recent pending inquiry for this partner
        $inquiry = PartnerPatientInquiry::where('currently_loggedin_partner_id', $partner->currently_loggedin_partner_id)
            ->where(function ($query) {
                $query->whereNull('status')
                      ->orWhere('status', 'Pending');
            })
            ->orderBy('id', 'desc')
            ->first();

        if (!$inquiry) {
            Log::warning('Webhook: No pending inquiry found for partner: ' . $partner->currently_loggedin_partner_id);
            return $twimlResponse;
        }

        // Update the status
        $inquiry->status = $action;
        $inquiry->save();

        Log::info('Webhook: Updated inquiry #' . $inquiry->id . ' status to ' . $action);

        // Notify the user via Twilio
        if ($inquiry->user_mobile) {
            try {
                $twilioService = new TwilioWhatsAppService();
                if ($action === 'Confirmed') {
                    $twilioService->sendUserConfirmationAlert($inquiry);
                } else {
                    $twilioService->sendUserCancellationAlert($inquiry);
                }
            } catch (\Exception $e) {
                Log::error('Webhook: Error sending user notification: ' . $e->getMessage());
            }
        }

        return $twimlResponse;
    }
}
