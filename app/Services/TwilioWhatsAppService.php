<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioWhatsAppService
{
    protected $client;
    protected $fromNumber;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.auth_token');
        $accountSid = config('services.twilio.account_sid');

        if ($sid && str_starts_with($sid, 'SK')) {
            $this->client = new Client($sid, $token, $accountSid);
        } else {
            $this->client = new Client($sid, $token);
        }
        
        $number = config('services.twilio.whatsapp_number');
        // Ensure correct formatting
        if (strpos($number, 'whatsapp:') === false) {
            $number = 'whatsapp:' . $number;
        }
        $this->fromNumber = $number;
    }

    protected function formatMobileNumber($mobile)
    {
        // Ensure standard E.164 format. Assuming India +91 if length is 10
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        if (strlen($mobile) == 10) {
            $mobile = '+91' . $mobile;
        } elseif (strlen($mobile) > 10 && substr($mobile, 0, 1) != '+') {
            $mobile = '+' . $mobile;
        }
        return 'whatsapp:' . $mobile;
    }

    public function sendTemplateMessage($to, $contentSid, $variables = [])
    {
        try {
            $toNumber = $this->formatMobileNumber($to);
            $messagingServiceSid = config('services.twilio.messaging_service_sid');

            $messagePayload = [
                'contentSid' => $contentSid,
                'contentVariables' => json_encode($variables)
            ];

            if ($messagingServiceSid) {
                $messagePayload['messagingServiceSid'] = $messagingServiceSid;
            } else {
                $messagePayload['from'] = $this->fromNumber;
            }

            $message = $this->client->messages->create(
                $toNumber,
                $messagePayload
            );
            return $message->sid;
        } catch (\Exception $e) {
            Log::error('Twilio WhatsApp Error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendUserOtp($mobile, $otp)
    {
        $sid = 'HXbaf6bed2e3877ce67c5f1dda80706e70';
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => (string) $otp
        ]);
    }

    public function sendPartnerOtp($mobile, $otp)
    {
        $sid = 'HXa1df71d67a91e009bb4ea5861f54fe41';
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => (string) $otp
        ]);
    }

    public function sendPartnerWelcome($mobile, $partnerName, $clinicName, $clinicType)
    {
        $sid = 'HXd15710888d9eb58723afe9c2ced6e73f';
        // Hi {{1}}, Your {{2}} {{3}} account has been created successfully.
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $partnerName,
            '2' => $clinicName,
            '3' => $clinicType
        ]);
    }

    public function sendAppointmentUserAlert($mobile, $userName, $doctorName, $clinicName, $date, $time)
    {
        $sid = 'HXf91cf7cd8f09df56870a0aab01432944';
        // Hi {{1}}, Your appointment with Dr. {{2}} at {{3}} has been successfully booked for {{4}} at {{5}}.
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $userName,
            '2' => $doctorName ?? 'Doctor',
            '3' => $clinicName ?? 'Clinic',
            '4' => $date,
            '5' => $time
        ]);
    }

    public function sendAppointmentPartnerAlert($mobile, $patientName, $patientMobile, $patientCity, $doctorName, $doctorSpeciality, $date, $time)
    {
        $sid = 'HX4a3aa66a72c5294d9e501dbc3358d01d';
        // {{1}} ({{2}}) from {{3}} has booked an appointment with Dr. {{4}} ({{5}}) on {{6}} at {{7}}.
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $patientName,
            '2' => $patientMobile,
            '3' => $patientCity ?? 'their location',
            '4' => $doctorName ?? 'Doctor',
            '5' => $doctorSpeciality ?? 'Clinic',
            '6' => $date,
            '7' => $time
        ]);
    }
}
