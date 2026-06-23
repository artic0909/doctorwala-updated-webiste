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

        // Extract parameters from Twilio payload
        $from = $request->input('From'); // e.g. whatsapp:+919876543210
        $buttonPayload = $request->input('ButtonPayload'); // e.g. 'confirm' or 'cancel'
        $body = $request->input('Body'); // e.g. 'Confirm'

        // Determine action
        $action = null;
        if (strtolower($buttonPayload) === 'confirm' || strtolower($body) === 'confirm') {
            $action = 'Confirmed';
        } elseif (strtolower($buttonPayload) === 'cancel' || strtolower($body) === 'cancel') {
            $action = 'Cancelled';
        }

        if (!$action) {
            return response('Ignoring non-button payload', 200);
        }

        // Clean phone number (remove 'whatsapp:' and '+' prefix if present)
        $cleanPhone = str_replace(['whatsapp:', '+'], '', $from);

        // Usually numbers in database are stored without country code if they are local.
        // Try to find the partner by mobile number
        $partner = DwPartnerModel::where('partner_mobile_number', $cleanPhone)
            ->orWhere('partner_mobile_number', 'like', '%' . substr($cleanPhone, -10))
            ->first();

        if (!$partner) {
            Log::warning('Webhook: Partner not found for mobile: ' . $cleanPhone);
            return response('Partner not found', 404);
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
            return response('No pending inquiry found', 404);
        }

        // Update the status
        $inquiry->status = $action;
        $inquiry->save();

        Log::info('Webhook: Updated inquiry #' . $inquiry->id . ' status to ' . $action);

        // Notify the user via Twilio
        if ($inquiry->user_mobile) {
            $twilioService = new TwilioWhatsAppService();
            if ($action === 'Confirmed') {
                $twilioService->sendUserConfirmationAlert($inquiry);
            } else {
                $twilioService->sendUserCancellationAlert($inquiry);
            }
        }

        return response('Success', 200);
    }
}
