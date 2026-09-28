<?php

namespace App\Http\Controllers\Partnerpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PartnerAboutDetailsModel;
use App\Models\PartnerDoctorBannerModel;
use App\Models\PartnerOPDBannerModel;
use App\Models\PartnerPathologyBannerModel;
use App\Models\PartnerPatientInquiry;
use Illuminate\Support\Facades\Auth;

class PartnerPatientInquiryController extends Controller
{
    public function create()
    {
        $partnerId = Auth::guard('partner')->id();

        $opdBanner = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $doctorBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();

        $partner = Auth::guard('partner')->user();
        $registrationTypes = $partner->registration_type;

        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }


        $aboutDetails = PartnerAboutDetailsModel::where('currently_loggedin_partner_id', $partnerId)->first();

        $partnerIds = array_values(array_filter([$partner->id, $partner->partner_id]));

        $opdContacts = \App\Models\PartnerOPDContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get();
        $pathContacts = \App\Models\PartnerPathologyContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get();
        $docContacts = \App\Models\PartnerDoctorContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get();

        $opdClinics = $opdContacts->pluck('clinic_name')->filter()->toArray();
        $pathClinics = $pathContacts->pluck('clinic_name')->filter()->toArray();
        $docClinics = $docContacts->pluck('partner_doctor_name')->filter()->toArray();

        $allClinicNames = array_values(array_filter(array_unique(array_merge(
            [$partner->partner_clinic_name ?? null],
            $opdClinics,
            $pathClinics,
            $docClinics
        ))));

        $contactIds = array_values(array_filter(array_unique(array_merge(
            $opdContacts->pluck('id')->toArray(),
            $pathContacts->pluck('id')->toArray(),
            $docContacts->pluck('id')->toArray()
        ))));

        $doctorIds = \App\Models\PartnerAllOPDDoctorModel::whereIn('currently_loggedin_partner_id', $partnerIds)
            ->pluck('id')
            ->filter()
            ->toArray();

        $patientInquiries = PartnerPatientInquiry::where(function ($q) use ($partnerIds, $contactIds, $allClinicNames, $doctorIds) {
                $q->whereIn('currently_loggedin_partner_id', $partnerIds);
                if (!empty($contactIds)) {
                    $q->orWhereIn('currently_loggedin_partner_id', $contactIds);
                }
                if (!empty($allClinicNames)) {
                    $q->orWhereIn('clinic_name', $allClinicNames);
                }
                if (!empty($doctorIds)) {
                    $q->orWhereIn('doctor_id', $doctorIds);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partnerpanel.partner-inquiry-from-patients', compact('opdBanner', 'pathologyBanner', 'doctorBanner', 'aboutDetails', 'registrationTypes', 'patientInquiries'));
    }


    public function delete($id)
    {
        $patientInquiry = PartnerPatientInquiry::find($id);
        $patientInquiry->delete();
        return redirect()->back()->with('success', 'Patient Inquiry deleted successfully');
    }
}
