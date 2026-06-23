<?php

namespace App\Observers;

use App\Models\PartnerPatientInquiry;
use App\Models\DwPartnerModel;
use App\Services\TwilioWhatsAppService;
use Illuminate\Support\Facades\Log;

class PartnerPatientInquiryObserver
{
    /**
     * Handle the PartnerPatientInquiry "created" event.
     *
     * @param  \App\Models\PartnerPatientInquiry  $inquiry
     * @return void
     */
    public function created(PartnerPatientInquiry $inquiry)
    {
        try {
            $twilioService = new TwilioWhatsAppService();

            // Get Doctor Name / Speciality if available
            $doctorName = null;
            $doctorSpeciality = null;
            if ($inquiry->doctor) {
                $doctorName = $inquiry->doctor->doctor_name;
                $doctorSpeciality = $inquiry->doctor->speciality;
            }

            // 1. Send Alert to Patient/User
            if ($inquiry->user_mobile) {
                $twilioService->sendAppointmentUserAlert(
                    $inquiry->user_mobile,
                    $inquiry->user_name,
                    $doctorName,
                    $inquiry->clinic_name,
                    $inquiry->booking_date,
                    $inquiry->booking_time
                );
            }

            // 2. Send Alert to Partner
            if ($inquiry->currently_loggedin_partner_id) {
                $partner = DwPartnerModel::find($inquiry->currently_loggedin_partner_id);
                if ($partner && $partner->partner_mobile_number) {
                    // For patient city, we can try to get it from User model if available
                    $patientCity = null;
                    if ($inquiry->user && $inquiry->user->user_city) {
                        $patientCity = $inquiry->user->user_city;
                    }

                    $twilioService->sendAppointmentPartnerAlert(
                        $partner->partner_mobile_number,
                        $inquiry->user_name,
                        $inquiry->user_mobile,
                        $patientCity,
                        $doctorName,
                        $doctorSpeciality ?? $inquiry->clinic_name,
                        $inquiry->booking_date,
                        $inquiry->booking_time
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error('Observer WhatsApp Error: ' . $e->getMessage());
        }
    }
}
