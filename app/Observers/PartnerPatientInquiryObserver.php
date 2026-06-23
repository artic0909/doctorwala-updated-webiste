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
                if ($inquiry->currently_loggedin_partner_id) {
                    $partner = DwPartnerModel::find($inquiry->currently_loggedin_partner_id);
                    if ($partner && $partner->partner_mobile_number) {
                        $twilioService->sendLabBookingPartnerAlert(
                            $partner->partner_mobile_number,
                            $inquiry->user_name,
                            $inquiry->user_mobile,
                            $testName,
                            $inquiry->clinic_name,
                            $inquiry->booking_date ?? 'a requested date',
                            $formattedTime
                        );
                    }
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
                if ($inquiry->currently_loggedin_partner_id) {
                    $partner = DwPartnerModel::find($inquiry->currently_loggedin_partner_id);
                    if ($partner && $partner->partner_mobile_number) {
                        $twilioService->sendIndividualDoctorPartnerAlert(
                            $partner->partner_mobile_number,
                            $inquiry->user_name,
                            $inquiry->booking_date ?? 'a requested date',
                            $formattedTime,
                            $inquiry->user_mobile
                        );
                    }
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
                            $inquiry->booking_date ?? 'a requested date',
                            $formattedTime
                        );
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Observer WhatsApp Error: ' . $e->getMessage());
        }
    }
}
