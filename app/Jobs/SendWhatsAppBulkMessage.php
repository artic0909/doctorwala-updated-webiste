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
            // In a real scenario, the template name might be passed or defined in env
            // $templateName = 'your_template_name';

            if (!$twilioSid || !$twilioAuthToken || !$twilioWhatsAppNumber) {
                Log::error('Twilio credentials missing for WhatsApp broadcast.');
                return;
            }

            $client = new Client($twilioSid, $twilioAuthToken);

            // Using the Twilio WhatsApp API
            $message = $client->messages->create(
                "whatsapp:" . $this->phoneNumber, // to
                [
                    "from" => $twilioWhatsAppNumber,
                    // If you want to use a template with variables:
                    // "contentVariables" => '{"1":"' . basename($this->imageUrl) . '"}',
                    // "contentSid" => 'HX...', // Content template SID if using Content API
                    // Or traditional body + media url
                    "body" => "Hello! Here is your latest update.",
                    "mediaUrl" => [$this->imageUrl]
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
