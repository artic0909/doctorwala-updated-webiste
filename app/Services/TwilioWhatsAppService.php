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

    public function sendAppointmentUserAlert($mobile, $userName, $doctorName, $doctorSpeciality, $clinicName, $date, $time)
    {
        $sid = 'HXf1cc2d8ed9fa51334da211fde6fba996';
        // Hi {{1}}, Your appointment with Dr. {{2}}, {{3}} at {{4}} has been successfully booked for {{5}} at {{6}}. See you soon! - Doctorwala
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $userName,
            '2' => $doctorName ?? 'Doctor',
            '3' => $doctorSpeciality ?? 'Specialist',
            '4' => $clinicName ?? 'Clinic',
            '5' => $date,
            '6' => $time
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

    public function sendLabBookingUserAlert($mobile, $userName, $testName, $clinicName, $date, $time)
    {
        $sid = 'HXd6ffa0b174d8b33b46d607f0206390c3';
        // Hi {{1}}, your {{2}} at {{3}} on {{4}} at {{5}} is booked successfully. - Doctorwala
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $userName,
            '2' => $testName ?? 'Lab Test',
            '3' => $clinicName ?? 'Clinic',
            '4' => $date,
            '5' => $time
        ]);
    }

    public function sendLabBookingPartnerAlert($mobile, $patientName, $patientMobile, $testName, $clinicName, $date, $time)
    {
        $sid = 'HX7c5df5542a2fa330726bb7dba2cfe044';
        // New Booking Alert! 🔔 Patient: {{1}} Contact No: {{2}} Test: {{3}} Lab: {{4}} Date: {{5}} Time: {{6}} Please confirm or cancel this booking.
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $patientName,
            '2' => $patientMobile,
            '3' => $testName ?? 'Lab Test',
            '4' => $clinicName,
            '5' => $date,
            '6' => $time
        ]);
    }

    public function sendIndividualDoctorUserAlert($mobile, $userName, $doctorName, $doctorSpeciality, $date, $time)
    {
        $sid = 'HX86b5815acded20301901a5b0e822d042';
        // Hi {{1}}, Your appointment with Dr. {{2}} ({{3}}) on {{4}} at {{5}} is booked successfully! ✅ Please arrive 20 minutes before your scheduled time. Thank you for choosing Doctorwala!
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $userName,
            '2' => $doctorName ?? 'Doctor',
            '3' => $doctorSpeciality ?? 'Specialist',
            '4' => $date,
            '5' => $time
        ]);
    }

    public function sendIndividualDoctorPartnerAlert($mobile, $patientName, $date, $time, $patientMobile)
    {
        $sid = 'HX8961a91a827db0ecf6ef6fd10ec66ae5';
        // New Appointment Alert! 🔔 Patient: {{1}} Date: {{4}} Time: {{5}} Phone: {{6}} Please confirm or cancel this appointment by calling the patient phone number - Doctorwala
        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $patientName,
            '4' => $date,
            '5' => $time,
            '6' => $patientMobile
        ]);
    }

    public function sendUserConfirmationAlert($inquiry)
    {
        $sid = 'HX573c38ede05a1813bce1e881bef7a26c';
        $mobile = $inquiry->user_mobile;
        
        $formattedTime = 'a requested time';
        if ($inquiry->booking_time) {
            try {
                $formattedTime = \Carbon\Carbon::parse($inquiry->booking_time)->format('g:i A');
            } catch (\Exception $e) {}
        }

        $typeString = 'Appointment';
        if ($inquiry->clinic_type === 'Pathology') {
            $typeString = $inquiry->test ? $inquiry->test->test_name : 'Lab Test';
        } else {
            $typeString = $inquiry->doctor ? ('Appointment with Dr. ' . $inquiry->doctor->doctor_name) : 'Doctor Appointment';
        }

        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $inquiry->user_name,
            '2' => $typeString,
            '3' => $inquiry->clinic_name,
            '4' => $inquiry->booking_date ?? 'a requested date',
            '5' => $formattedTime,
        ]);
    }

    public function sendUserCancellationAlert($inquiry)
    {
        $sid = 'HXb8324847f92f88567ae45f760f01444b';
        $mobile = $inquiry->user_mobile;

        $formattedTime = 'a requested time';
        if ($inquiry->booking_time) {
            try {
                $formattedTime = \Carbon\Carbon::parse($inquiry->booking_time)->format('g:i A');
            } catch (\Exception $e) {}
        }

        $typeString = 'Appointment';
        if ($inquiry->clinic_type === 'Pathology') {
            $typeString = $inquiry->test ? $inquiry->test->test_name : 'Lab Test';
        } else {
            $typeString = $inquiry->doctor ? ('Appointment with Dr. ' . $inquiry->doctor->doctor_name) : 'Doctor Appointment';
        }

        return $this->sendTemplateMessage($mobile, $sid, [
            '1' => $inquiry->user_name,
            '2' => $typeString,
            '3' => $inquiry->clinic_name,
            '4' => $inquiry->booking_date ?? 'a requested date',
            '5' => $formattedTime,
        ]);
    }
}
