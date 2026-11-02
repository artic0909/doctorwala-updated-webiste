<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Calling;
use App\Services\VapiTranscriptExtractor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VapiWebhookController extends Controller
{
    /**
     * Handle incoming Vapi Webhook / Server URL requests
     */
    public function handle(Request $request)
    {
        Log::info('Vapi Webhook received:', [
            'type' => $request->input('message.type') ?? $request->input('type') ?? 'direct',
        ]);

        $payload = $request->all();
        $message = $request->input('message', []);

        // 1. Extract Vapi Call ID
        $vapiCallId = $this->extractCallId($request);

        // 2. Extract Customer / Recipient Phone Number automatically
        $phoneNumber = $this->extractPhoneNumber($request);

        // 3. Find existing Calling record or create a new one
        $calling = null;
        if (!empty($vapiCallId)) {
            $calling = Calling::where('vapi_call_id', $vapiCallId)->first();
        }

        if (!$calling && !empty($phoneNumber)) {
            // Find recent call within the last 60 minutes for this number
            $calling = Calling::where('phone_number', $phoneNumber)
                ->where('created_at', '>=', Carbon::now()->subMinutes(60))
                ->latest()
                ->first();
        }

        if (!$calling) {
            $calling = new Calling();
            $calling->call_status = 'in-progress';
        }

        if (!empty($vapiCallId)) {
            $calling->vapi_call_id = $vapiCallId;
        }

        if (!empty($phoneNumber)) {
            $calling->phone_number = $phoneNumber;
        }

        // Store/merge raw payload
        $calling->raw_payload = $payload;

        $messageType = $request->input('message.type') ?? $request->input('type');
        $results = [];

        // 4. Handle Tool Calls / Function Calls
        $toolCalls = $request->input('message.toolCalls')
            ?? $request->input('toolCalls')
            ?? [];

        $singleFunctionCall = $request->input('message.functionCall')
            ?? $request->input('functionCall');

        if (!empty($singleFunctionCall)) {
            $toolCalls[] = [
                'id' => $singleFunctionCall['id'] ?? 'legacy_func',
                'function' => $singleFunctionCall,
            ];
        }

        if (!empty($toolCalls) && is_array($toolCalls)) {
            foreach ($toolCalls as $toolCall) {
                $toolCallId = $toolCall['id'] ?? null;
                $function = $toolCall['function'] ?? [];
                $funcName = $function['name'] ?? '';
                $arguments = $function['arguments'] ?? [];

                if (is_string($arguments)) {
                    $decoded = json_decode($arguments, true);
                    if (is_array($decoded)) {
                        $arguments = $decoded;
                    }
                }

                $toolResult = $this->processToolCall($calling, $funcName, $arguments, $phoneNumber);

                if ($toolCallId) {
                    $results[] = [
                        'toolCallId' => $toolCallId,
                        'result' => $toolResult,
                    ];
                }
            }
        }

        // 5. Handle End of Call Report
        if ($messageType === 'end-of-call-report' || !empty($request->input('message.artifact')) || !empty($request->input('artifact'))) {
            $this->processEndOfCallReport($calling, $request);
        }

        // 6. Handle Status Update
        if ($messageType === 'status-update') {
            $status = $request->input('message.status') ?? $request->input('status');
            if (!empty($status)) {
                $calling->call_status = $status;
            }
        }

        // 7. Handle direct flat fields if posted directly to webhook
        $this->processDirectFields($calling, $request);

        // 8. AUTOMATIC TRANSCRIPT EXTRACTION FALLBACK
        // If provider_name, provider_type, location, etc. are still empty (e.g. LLM didn't call save_lead during call),
        // extract all discovery data directly from transcript and messages!
        $this->extractDataFromTranscriptFallback($calling, $request);

        $calling->save();

        // 9. Return response format expected by Vapi
        if (!empty($results)) {
            return response()->json([
                'results' => $results,
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Calling data recorded successfully',
            'calling_id' => $calling->id,
            'phone_number' => $calling->phone_number,
        ], 200);
    }

    /**
     * Ping endpoint for testing connection
     */
    public function ping()
    {
        return response()->json([
            'status' => 'ok',
            'message' => 'Doctorwala Vapi Calling Webhook Endpoint is Live and Ready!',
            'timestamp' => now()->toIso8601String(),
        ], 200);
    }

    /**
     * Extract Vapi Call ID from multiple payload paths
     */
    protected function extractCallId(Request $request): ?string
    {
        $candidates = [
            $request->input('message.artifact.variables.call.id'),
            $request->input('message.artifact.variableValues.call.id'),
            $request->input('artifact.variables.call.id'),
            $request->input('artifact.variableValues.call.id'),
            $request->input('message.call.id'),
            $request->input('call.id'),
            $request->input('callId'),
            $request->input('vapi_call_id'),
            $request->input('id'),
        ];

        foreach ($candidates as $c) {
            if (!empty($c) && is_string($c)) {
                return trim($c);
            }
        }

        return null;
    }

    /**
     * Automatically extract phone number from various Vapi payload formats
     */
    protected function extractPhoneNumber(Request $request): ?string
    {
        $candidates = [
            $request->input('message.artifact.variables.customer.number'),
            $request->input('message.artifact.variableValues.customer.number'),
            $request->input('artifact.variables.customer.number'),
            $request->input('artifact.variableValues.customer.number'),
            $request->input('message.call.customer.number'),
            $request->input('call.customer.number'),
            $request->input('message.customer.number'),
            $request->input('customer.number'),
            $request->input('message.call.destination.number'),
            $request->input('call.destination.number'),
            $request->input('phone_number'),
            $request->input('phoneNumber'),
            $request->input('customer_number'),
            $request->input('customerPhone'),
            $request->input('to'),
            $request->input('From'),
            $request->input('recipient'),
            $request->input('message.call.phone_number.number'),
            $request->input('message.artifact.variables.phoneNumber.number'),
        ];

        foreach ($candidates as $candidate) {
            if (!empty($candidate) && is_string($candidate) && strlen(trim($candidate)) >= 7) {
                return trim($candidate);
            }
        }

        return null;
    }

    /**
     * Process tool calls made by Riya (AI caller)
     */
    protected function processToolCall(Calling $calling, string $funcName, array $args, ?string $fallbackPhone): string
    {
        Log::info("Processing Vapi tool call: {$funcName}", $args);

        if (empty($calling->phone_number)) {
            if (!empty($args['phone_number'])) {
                $calling->phone_number = $args['phone_number'];
            } elseif (!empty($args['customer_number'])) {
                $calling->phone_number = $args['customer_number'];
            } elseif (!empty($fallbackPhone)) {
                $calling->phone_number = $fallbackPhone;
            }
        }

        switch (strtolower(str_replace(['-', ' '], '_', $funcName))) {
            case 'save_lead':
                if (!empty($args['provider_name'])) {
                    $calling->provider_name = $args['provider_name'];
                }
                if (!empty($args['provider_type'])) {
                    $calling->provider_type = $args['provider_type'];
                }
                if (!empty($args['location'])) {
                    $calling->location = $args['location'];
                }
                if (!empty($args['doctors_and_timings'])) {
                    $calling->doctors_and_timings = $args['doctors_and_timings'];
                }
                if (!empty($args['consultation_modes'])) {
                    $calling->consultation_modes = $args['consultation_modes'];
                }
                if (isset($args['doctor_fee_known'])) {
                    $calling->doctor_fee_known = is_bool($args['doctor_fee_known'])
                        ? ($args['doctor_fee_known'] ? 'yes' : 'no')
                        : (string)$args['doctor_fee_known'];
                }
                if (!empty($args['tests_offered'])) {
                    $calling->tests_offered = $args['tests_offered'];
                }
                if (isset($args['rates_list_exists'])) {
                    $calling->rates_list_exists = is_bool($args['rates_list_exists'])
                        ? ($args['rates_list_exists'] ? 'yes' : 'no')
                        : (string)$args['rates_list_exists'];
                }
                if (isset($args['home_sample_collection'])) {
                    $calling->home_sample_collection = is_bool($args['home_sample_collection'])
                        ? ($args['home_sample_collection'] ? 'yes' : 'no')
                        : (string)$args['home_sample_collection'];
                }
                if (!empty($args['language'])) {
                    $calling->language = $args['language'];
                }

                return "Lead details for {$calling->provider_name} saved successfully.";

            case 'schedule_callback':
                $calling->callback_scheduled = true;
                $callbackTime = $args['time'] ?? $args['date'] ?? $args['datetime'] ?? $args['callback_time'] ?? null;
                if (!empty($callbackTime)) {
                    $calling->callback_time = is_string($callbackTime) ? $callbackTime : json_encode($callbackTime);
                }
                $notes = $args['notes'] ?? $args['reason'] ?? $args['note'] ?? $args['callback_notes'] ?? null;
                if (!empty($notes)) {
                    $calling->callback_notes = $notes;
                }
                return "Callback scheduled successfully for {$calling->callback_time}.";

            case 'mark_dnd':
                $calling->is_dnd = true;
                $reason = $args['reason'] ?? 'Requested Do Not Disturb';
                if (!empty($calling->callback_notes)) {
                    $calling->callback_notes .= " | DND Reason: {$reason}";
                } else {
                    $calling->callback_notes = "DND Reason: {$reason}";
                }
                return "Contact marked as Do Not Disturb.";

            case 'send_link':
                $calling->app_link_sent = true;
                return "Doctorwala Partner App link sent successfully to the provider via WhatsApp/SMS.";

            case 'end_call':
                $calling->call_status = 'completed';
                return "Call completed and recorded.";

            default:
                foreach ($args as $key => $val) {
                    if (in_array($key, [
                        'provider_name', 'provider_type', 'location', 'doctors_and_timings',
                        'consultation_modes', 'doctor_fee_known', 'tests_offered',
                        'rates_list_exists', 'home_sample_collection', 'language'
                    ]) && !empty($val)) {
                        $calling->$key = $val;
                    }
                }
                return "Information recorded.";
        }
    }

    /**
     * Process End-of-Call Report sent by Vapi
     */
    protected function processEndOfCallReport(Calling $calling, Request $request): void
    {
        $message = $request->input('message', []);

        // Duration calculation
        $duration = $message['durationSeconds']
            ?? $request->input('durationSeconds')
            ?? $request->input('duration')
            ?? $request->input('message.call.durationSeconds')
            ?? null;

        // If durationSeconds is null, calculate from startedAt and endedAt
        if ($duration === null) {
            $startedAt = $message['startedAt'] ?? $request->input('startedAt');
            $endedAt = $message['endedAt'] ?? $request->input('endedAt');
            if ($startedAt && $endedAt) {
                try {
                    $duration = abs(Carbon::parse($endedAt)->diffInSeconds(Carbon::parse($startedAt)));
                } catch (\Exception $e) {
                    // ignore
                }
            }
        }

        if ($duration !== null) {
            $calling->duration_seconds = (int)$duration;
        }

        // Ended Reason
        $endedReason = $message['endedReason']
            ?? $request->input('endedReason')
            ?? $request->input('message.endedReason')
            ?? null;

        if (!empty($endedReason)) {
            $calling->ended_reason = $endedReason;
        }

        // Call Status
        $status = $message['status']
            ?? $request->input('status')
            ?? $request->input('message.call.status')
            ?? 'completed';

        $calling->call_status = $status;

        // Transcript
        $transcript = $message['transcript']
            ?? $request->input('transcript')
            ?? $request->input('message.artifact.transcript')
            ?? $request->input('artifact.transcript')
            ?? null;

        if (!empty($transcript)) {
            $calling->transcript = $transcript;
        }

        // Recording URL
        $recordingUrl = $message['recordingUrl']
            ?? $request->input('recordingUrl')
            ?? $request->input('message.artifact.recordingUrl')
            ?? $request->input('artifact.recordingUrl')
            ?? $request->input('message.artifact.recording.mono.combinedUrl')
            ?? $request->input('message.artifact.presignedMonoUrl')
            ?? null;

        if (!empty($recordingUrl)) {
            $calling->recording_url = $recordingUrl;
        }

        // Summary
        $summary = $message['summary']
            ?? $request->input('summary')
            ?? $request->input('message.analysis.summary')
            ?? $request->input('analysis.summary')
            ?? null;

        if (!empty($summary) && is_string($summary)) {
            $calling->summary = $summary;
        }

        // Cost
        $cost = $message['cost']
            ?? $request->input('cost')
            ?? $request->input('message.cost')
            ?? null;

        if (!empty($cost)) {
            $calling->cost = (string)$cost;
        }

        // Structured Data from Vapi Analysis
        $structuredData = $request->input('message.analysis.structuredData')
            ?? $request->input('analysis.structuredData')
            ?? [];

        if (!empty($structuredData) && is_array($structuredData)) {
            foreach ($structuredData as $key => $val) {
                if (empty($val)) continue;
                $k = strtolower(str_replace(['-', ' '], '_', $key));
                if (in_array($k, [
                    'provider_name', 'provider_type', 'location', 'doctors_and_timings',
                    'consultation_modes', 'doctor_fee_known', 'tests_offered',
                    'rates_list_exists', 'home_sample_collection', 'language'
                ])) {
                    if (empty($calling->$k)) {
                        $calling->$k = is_array($val) ? json_encode($val) : (string)$val;
                    }
                }
            }
        }
    }

    /**
     * Automatic fallback extraction from transcript and messages
     */
    protected function extractDataFromTranscriptFallback(Calling $calling, Request $request): void
    {
        $transcript = $calling->transcript
            ?? $request->input('message.artifact.transcript')
            ?? $request->input('artifact.transcript')
            ?? $request->input('message.transcript')
            ?? '';

        $messages = $request->input('message.artifact.messages')
            ?? $request->input('artifact.messages')
            ?? [];

        if (empty($transcript) && !empty($messages)) {
            $transcript = VapiTranscriptExtractor::buildTranscriptFromMessages($messages);
            $calling->transcript = $transcript;
        }

        if (empty($transcript)) {
            return;
        }

        $extracted = VapiTranscriptExtractor::extract($transcript, $messages);

        if (!empty($extracted)) {
            // Fill any missing field
            foreach ([
                'provider_name', 'provider_type', 'location', 'doctors_and_timings',
                'consultation_modes', 'doctor_fee_known', 'tests_offered',
                'rates_list_exists', 'home_sample_collection', 'language',
            ] as $field) {
                if (empty($calling->$field) && !empty($extracted[$field])) {
                    $calling->$field = $extracted[$field];
                }
            }

            if (!$calling->app_link_sent && !empty($extracted['app_link_sent'])) {
                $calling->app_link_sent = true;
            }

            if (!$calling->callback_scheduled && !empty($extracted['callback_scheduled'])) {
                $calling->callback_scheduled = true;
                if (!empty($extracted['callback_notes'])) {
                    $calling->callback_notes = $extracted['callback_notes'];
                }
            }

            if (!$calling->is_dnd && !empty($extracted['is_dnd'])) {
                $calling->is_dnd = true;
            }

            if (empty($calling->summary) && !empty($extracted['summary'])) {
                $calling->summary = $extracted['summary'];
            }
        }
    }

    /**
     * Process direct fields passed at root
     */
    protected function processDirectFields(Calling $calling, Request $request): void
    {
        $fields = [
            'provider_name', 'provider_type', 'location', 'doctors_and_timings',
            'consultation_modes', 'doctor_fee_known', 'tests_offered',
            'rates_list_exists', 'home_sample_collection', 'language',
            'callback_time', 'callback_notes', 'summary', 'transcript', 'recording_url'
        ];

        foreach ($fields as $field) {
            $val = $request->input($field);
            if (!empty($val)) {
                $calling->$field = is_array($val) ? json_encode($val) : $val;
            }
        }

        if ($request->has('callback_scheduled')) {
            $calling->callback_scheduled = $request->boolean('callback_scheduled');
        }
        if ($request->has('is_dnd')) {
            $calling->is_dnd = $request->boolean('is_dnd');
        }
        if ($request->has('app_link_sent')) {
            $calling->app_link_sent = $request->boolean('app_link_sent');
        }
    }
}
