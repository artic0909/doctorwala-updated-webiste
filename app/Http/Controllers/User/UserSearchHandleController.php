<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PartnerAllOPDDoctorModel;
use App\Models\PartnerAllPathologyTestModel;
use App\Models\PartnerDoctorContactModel;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerPathologyContactModel;
use App\Models\SuperAboutusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSearchHandleController extends Controller
{
    protected $guard = 'dwuser';

    public function index(Request $request)
    {
        $aboutDetails = SuperAboutusModel::get();
        $user         = Auth::guard('dwuser')->user();
        $query        = trim($request->get('query', ''));
        $category     = $request->get('category', 'all');

        $opds  = collect();
        $paths = collect();
        $docs  = collect();

        if ($query !== '') {

            // ── OPD direct search ──────────────────────────────────────
            if (in_array($category, ['all', 'opd'])) {

                $directOPD = PartnerOPDContactModel::where('status', 'active')
                    ->where(function ($q) use ($query) {
                        $q->where('clinic_name',                'like', "%{$query}%")
                          ->orWhere('clinic_address',           'like', "%{$query}%")
                          ->orWhere('clinic_city',              'like', "%{$query}%")
                          ->orWhere('clinic_state',             'like', "%{$query}%")
                          ->orWhere('clinic_pincode',           'like', "%{$query}%")
                          ->orWhere('clinic_landmark',          'like', "%{$query}%")
                          ->orWhere('clinic_contact_person_name','like', "%{$query}%");
                    })
                    ->with('banner')
                    ->get(['id','clinic_name','clinic_address','slug','currently_loggedin_partner_id']);

                // OPD via specialist match
                $opdPartnerIds = PartnerAllOPDDoctorModel::where('doctor_specialist', 'like', "%{$query}%")
                    ->pluck('currently_loggedin_partner_id');

                $bySpecialistOPD = PartnerOPDContactModel::whereIn('currently_loggedin_partner_id', $opdPartnerIds)
                    ->where('status', 'active')
                    ->with('banner')
                    ->get(['id','clinic_name','clinic_address','slug','currently_loggedin_partner_id']);

                // Merge + deduplicate by id
                $opds = $directOPD->merge($bySpecialistOPD)->unique('id')->values();
            }

            // ── Pathology direct search ────────────────────────────────
            if (in_array($category, ['all', 'pathology'])) {

                $directPath = PartnerPathologyContactModel::where('status', 'active')
                    ->where(function ($q) use ($query) {
                        $q->where('clinic_name',                'like', "%{$query}%")
                          ->orWhere('clinic_address',           'like', "%{$query}%")
                          ->orWhere('clinic_city',              'like', "%{$query}%")
                          ->orWhere('clinic_state',             'like', "%{$query}%")
                          ->orWhere('clinic_pincode',           'like', "%{$query}%")
                          ->orWhere('clinic_landmark',          'like', "%{$query}%")
                          ->orWhere('clinic_contact_person_name','like', "%{$query}%");
                    })
                    ->with('banner')
                    ->get(['id','clinic_name','clinic_address','slug','currently_loggedin_partner_id']);

                // Pathology via test_type match
                $pathPartnerIds = PartnerAllPathologyTestModel::where('test_type', 'like', "%{$query}%")
                    ->pluck('currently_loggedin_partner_id');

                $byTestPath = PartnerPathologyContactModel::whereIn('currently_loggedin_partner_id', $pathPartnerIds)
                    ->where('status', 'active')
                    ->with('banner')
                    ->get(['id','clinic_name','clinic_address','slug','currently_loggedin_partner_id']);

                $paths = $directPath->merge($byTestPath)->unique('id')->values();
            }

            // ── Doctor search ──────────────────────────────────────────
            if (in_array($category, ['all', 'doctor'])) {
                $docs = PartnerDoctorContactModel::where('status', 'active')
                    ->where(function ($q) use ($query) {
                        $q->where('partner_doctor_name',        'like', "%{$query}%")
                          ->orWhere('partner_doctor_specialist', 'like', "%{$query}%")
                          ->orWhere('partner_doctor_designation','like', "%{$query}%")
                          ->orWhere('partner_doctor_address',    'like', "%{$query}%")
                          ->orWhere('partner_doctor_city',       'like', "%{$query}%")
                          ->orWhere('partner_doctor_state',      'like', "%{$query}%")
                          ->orWhere('partner_doctor_pincode',    'like', "%{$query}%")
                          ->orWhere('partner_doctor_landmark',   'like', "%{$query}%");
                    })
                    ->with('banner')
                    ->get(['id','partner_doctor_name','partner_doctor_address','slug','currently_loggedin_partner_id']);
            }
        }

        $totalResults = $opds->count() + $paths->count() + $docs->count();

        return view('search-result', compact(
            'aboutDetails',
            'user',
            'query',
            'category',
            'opds',
            'paths',
            'docs',
            'totalResults'
        ));
    }
}