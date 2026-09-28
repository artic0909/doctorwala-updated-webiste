<?php

namespace App\Services;

use App\Models\PartnerPatientInquiry;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmNotificationService
{
    protected ?string $serverKey;

    public function __construct()
    {
        $this->serverKey = config('services.fcm.server_key', env('FCM_SERVER_KEY'));
    }

    /**
     * Send FCM push notification for video appointment confirmation/scheduled
     *
     * @param PartnerPatientInquiry $appointment
     * @param string|null $fcmToken
     * @return bool
     */
    public function sendVideoAppointmentAcceptedNotification(PartnerPatientInquiry $appointment, ?string $fcmToken = null): bool
    {
        $token = $fcmToken ?? ($appointment->user->fcm_token ?? null);
        
        $title = "Video Consultation Confirmed";
        $body = "Your video appointment with {$appointment->clinic_name} on {$appointment->booking_date} at {$appointment->booking_time} has been confirmed.";
        
        $data = [
            'type' => 'video_appointment',
            'appointment_id' => (string) $appointment->id,
            'channel' => (string) $appointment->video_channel,
            'booking_date' => (string) $appointment->booking_date,
            'booking_time' => (string) $appointment->booking_time,
            'clinic_name' => (string) $appointment->clinic_name,
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        ];

        if (empty($token)) {
            Log::info("FCM: Patient has no FCM token for appointment #{$appointment->id}. Notification payload prepared: {$title} - {$body}");
            return false;
        }

        if (empty($this->serverKey)) {
            Log::info("FCM: FCM_SERVER_KEY not configured. Mock delivery to token {$token} for appointment #{$appointment->id}");
            return true;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type'  => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                    'sound' => 'default',
                ],
                'data' => $data,
                'priority' => 'high',
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("FCM Send Error: " . $e->getMessage());
            return false;
        }
    }
}
