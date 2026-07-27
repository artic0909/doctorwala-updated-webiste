<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class SendWhatsAppBulkMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phoneNumber;
    public $imageUrl;

    /**
     * Create a new job instance.
     */
    public function __construct($phoneNumber, $imageUrl)
    {
        $this->phoneNumber = $phoneNumber;
        $this->imageUrl = $imageUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $twilioSid = env('TWILIO_SID');
            $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
            $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER'); // e.g. whatsapp:+14155238886
            $twilioAccountSid = env('TWILIO_ACCOUNT_SID');

            if (!$twilioSid || !$twilioAuthToken || !$twilioWhatsAppNumber) {
                Log::error('Twilio credentials missing for WhatsApp broadcast.');
                return;
            }

            if ($twilioAccountSid) {
                $client = new Client($twilioSid, $twilioAuthToken, $twilioAccountSid);
            } else {
                $client = new Client($twilioSid, $twilioAuthToken);
            }

            // Using the Twilio WhatsApp Content API with the approved template SID
            $message = $client->messages->create(
                "whatsapp:" . $this->phoneNumber, // to
                [
                    "from" => $twilioWhatsAppNumber,
                    "contentSid" => "HX6e98e4b8eb959da4e4c072c9872bccb2",
                    "contentVariables" => json_encode([
                        "1" => basename($this->imageUrl)
                    ])
                ]
            );

            Log::info("WhatsApp message sent to " . $this->phoneNumber . " with SID: " . $message->sid);
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp message to " . $this->phoneNumber . ". Error: " . $e->getMessage());
            // Optional: you can re-throw to retry the job
            // throw $e;
        }
    }
}
