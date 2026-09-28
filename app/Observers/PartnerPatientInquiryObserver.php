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
                $doctorSpeciality = $inquiry->doctor->doctor_specialist;
            } elseif ($inquiry->clinic_type === 'Doctor' && $inquiry->doctorContact) {
                $doctorName = $inquiry->doctorContact->partner_doctor_name;
                $doctorSpeciality = $inquiry->doctorContact->partner_doctor_specialist;
            }

            $formattedTime = 'a requested time';
            if ($inquiry->booking_time) {
                try {
                    $formattedTime = \Carbon\Carbon::parse($inquiry->booking_time)->format('g:i A');
                } catch (\Exception $e) {
                    $formattedTime = $inquiry->booking_time;
                }
            }

            if ($inquiry->clinic_type === 'Pathology') {
                $testName = null;
                if ($inquiry->test) {
                    $testName = $inquiry->test->test_name;
                }

                // 1. Send Alert to Patient/User
                if ($inquiry->user_mobile) {
                    $twilioService->sendLabBookingUserAlert(
                        $inquiry->user_mobile,
                        $inquiry->user_name,
                        $testName,
                        $inquiry->clinic_name,
                        $inquiry->booking_date ?? 'a requested date',
                        $formattedTime
                    );
                }

                // 2. Send Alert to Partner
                $partnerMobile = $this->resolvePartnerMobile($inquiry);
                if ($partnerMobile) {
                    $twilioService->sendLabBookingPartnerAlert(
                        $partnerMobile,
                        $inquiry->user_name,
                        $inquiry->user_mobile,
                        $testName,
                        $inquiry->clinic_name,
                        $inquiry->booking_date ?? 'a requested date',
                        $formattedTime
                    );
                }
            } elseif ($inquiry->clinic_type === 'Doctor') {
                // 1. Send Alert to Patient/User
                if ($inquiry->user_mobile) {
                    $twilioService->sendIndividualDoctorUserAlert(
                        $inquiry->user_mobile,
                        $inquiry->user_name,
                        $doctorName,
                        $doctorSpeciality ?? $inquiry->clinic_name,
                        $inquiry->booking_date ?? 'a requested date',
                        $formattedTime
                    );
                }

                // 2. Send Alert to Partner
                $partnerMobile = $this->resolvePartnerMobile($inquiry);
                if ($partnerMobile) {
                    $twilioService->sendIndividualDoctorPartnerAlert(
                        $partnerMobile,
                        $inquiry->user_name,
                        $inquiry->booking_date ?? 'a requested date',
                        $formattedTime,
                        $inquiry->user_mobile
                    );
                }
            } else {
                // 1. Send Alert to Patient/User
                if ($inquiry->user_mobile) {
                    $twilioService->sendAppointmentUserAlert(
                        $inquiry->user_mobile,
                        $inquiry->user_name,
                        $doctorName,
                        $doctorSpeciality ?? $inquiry->clinic_name,
                        $inquiry->clinic_name,
                        $inquiry->booking_date ?? 'a requested date',
                        $formattedTime
                    );
                }

                // 2. Send Alert to Partner
                $partnerMobile = $this->resolvePartnerMobile($inquiry);
                if ($partnerMobile) {
                    // For patient city, we can try to get it from User model if available
                    $patientCity = null;
                    if ($inquiry->user && $inquiry->user->user_city) {
                        $patientCity = $inquiry->user->user_city;
                    }

                    $twilioService->sendAppointmentPartnerAlert(
                        $partnerMobile,
                        $inquiry->user_name,
                        $inquiry->user_mobile,
                        $patientCity,
                        $doctorName,
                        $doctorSpeciality ?? $inquiry->clinic_name,
                        $inquiry->booking_date ?? 'a requested date',
                        $formattedTime
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error('Observer WhatsApp Error: ' . $e->getMessage());
        }
    }

    /**
     * Resolve partner's phone number across DwPartnerModel and all Contact models.
     */
    protected function resolvePartnerMobile(PartnerPatientInquiry $inquiry): ?string
    {
        $pid = $inquiry->currently_loggedin_partner_id;

        // 1. Try DwPartnerModel by ID or partner_id
        if (!empty($pid)) {
            $partner = DwPartnerModel::where('id', $pid)->orWhere('partner_id', $pid)->first();
            if ($partner && !empty($partner->partner_mobile_number)) {
                return $partner->partner_mobile_number;
            }
        }

        // 2. Try OPD contact by currently_loggedin_partner_id or clinic_name
        $opd = \App\Models\PartnerOPDContactModel::where(function ($q) use ($pid, $inquiry) {
            if (!empty($pid)) {
                $q->where('currently_loggedin_partner_id', $pid)->orWhere('id', $pid);
            }
            if (!empty($inquiry->clinic_name)) {
                $q->orWhere('clinic_name', $inquiry->clinic_name);
            }
        })->whereNotNull('clinic_mobile_number')->first();

        if ($opd && !empty($opd->clinic_mobile_number)) {
            return $opd->clinic_mobile_number;
        }

        // 3. Try Doctor contact by currently_loggedin_partner_id or partner_doctor_name
        $doc = \App\Models\PartnerDoctorContactModel::where(function ($q) use ($pid, $inquiry) {
            if (!empty($pid)) {
                $q->where('currently_loggedin_partner_id', $pid)->orWhere('id', $pid);
            }
            if (!empty($inquiry->clinic_name)) {
                $q->orWhere('partner_doctor_name', $inquiry->clinic_name);
            }
        })->whereNotNull('partner_doctor_mobile')->first();

        if ($doc && !empty($doc->partner_doctor_mobile)) {
            return $doc->partner_doctor_mobile;
        }

        // 4. Try Pathology contact by currently_loggedin_partner_id or clinic_name
        $path = \App\Models\PartnerPathologyContactModel::where(function ($q) use ($pid, $inquiry) {
            if (!empty($pid)) {
                $q->where('currently_loggedin_partner_id', $pid)->orWhere('id', $pid);
            }
            if (!empty($inquiry->clinic_name)) {
                $q->orWhere('clinic_name', $inquiry->clinic_name);
            }
        })->whereNotNull('clinic_mobile_number')->first();

        if ($path && !empty($path->clinic_mobile_number)) {
            return $path->clinic_mobile_number;
        }

        // 5. Try DwPartnerModel matching clinic name
        if (!empty($inquiry->clinic_name)) {
            $partnerByName = DwPartnerModel::where('partner_clinic_name', $inquiry->clinic_name)->first();
            if ($partnerByName && !empty($partnerByName->partner_mobile_number)) {
                return $partnerByName->partner_mobile_number;
            }
        }

        return null;
    }
}
