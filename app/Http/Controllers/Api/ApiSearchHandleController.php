<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerAllOPDDoctorModel;
use App\Models\PartnerAllPathologyTestModel;
use App\Models\PartnerDoctorContactModel;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerPathologyContactModel;
use Illuminate\Http\Request;

class ApiSearchHandleController extends Controller
{
    public function search(Request $request)
    {
        $query    = trim($request->get('query', ''));
        $category = $request->get('category', 'all'); // all | opd | pathology | doctor

        if ($query === '') {
            return response()->json([
                'status'        => false,
                'message'       => 'Search query is required.',
                'data'          => [
                    'opds'          => [],
                    'pathologies'   => [],
                    'doctors'       => [],
                    'total_results' => 0,
                ]
            ], 422);
        }

        try {
            $opds  = collect();
            $paths = collect();
            $docs  = collect();

            $user_city = $request->get('user_city', '');

            // ── OPD Search ─────────────────────────────────────────────────
            if (in_array($category, ['all', 'opd'])) {

                $directOPDQuery = PartnerOPDContactModel::where('status', 'active');
                if ($user_city !== '') {
                    $directOPDQuery->where('clinic_city', $user_city);
                }
                
                $directOPD = $directOPDQuery->where(function ($q) use ($query) {
                        $q->where('clinic_name',                 'like', "%{$query}%")
                            ->orWhere('clinic_address',            'like', "%{$query}%")
                            ->orWhere('clinic_city',               'like', "%{$query}%")
                            ->orWhere('clinic_state',              'like', "%{$query}%")
                            ->orWhere('clinic_pincode',            'like', "%{$query}%")
                            ->orWhere('clinic_landmark',           'like', "%{$query}%")
                            ->orWhere('clinic_mobile_number',      'like', "%{$query}%")
                            ->orWhere('clinic_contact_person_name', 'like', "%{$query}%");
                    })
                    ->with(['banner', 'doctors'])
                    ->get([
                        'id',
                        'clinic_name',
                        'clinic_address',
                        'clinic_pincode',
                        'clinic_mobile_number',
                        'clinic_state',
                        'clinic_google_map_link',
                        'clinic_city',
                        'slug',
                        'currently_loggedin_partner_id'
                    ]);

                $opdPartnerIds = PartnerAllOPDDoctorModel::where('doctor_specialist', 'like', "%{$query}%")
                    ->pluck('currently_loggedin_partner_id');

                $bySpecialistOPDQuery = PartnerOPDContactModel::whereIn('currently_loggedin_partner_id', $opdPartnerIds)
                    ->where('status', 'active');
                if ($user_city !== '') {
                    $bySpecialistOPDQuery->where('clinic_city', $user_city);
                }

                $bySpecialistOPD = $bySpecialistOPDQuery->with(['banner', 'doctors'])
                    ->get([
                        'id',
                        'clinic_name',
                        'clinic_address',
                        'clinic_pincode',
                        'clinic_mobile_number',
                        'clinic_google_map_link',
                        'clinic_state',
                        'clinic_city',
                        'slug',
                        'currently_loggedin_partner_id'
                    ]);

                $opds = $directOPD->merge($bySpecialistOPD)->unique('id')->values();
            }

            // ── Pathology Search ───────────────────────────────────────────
            if (in_array($category, ['all', 'pathology'])) {

                $directPathQuery = PartnerPathologyContactModel::where('status', 'active');
                if ($user_city !== '') {
                    $directPathQuery->where('clinic_city', $user_city);
                }

                $directPath = $directPathQuery->where(function ($q) use ($query) {
                        $q->where('clinic_name',                 'like', "%{$query}%")
                            ->orWhere('clinic_address',            'like', "%{$query}%")
                            ->orWhere('clinic_city',               'like', "%{$query}%")
                            ->orWhere('clinic_state',              'like', "%{$query}%")
                            ->orWhere('clinic_pincode',            'like', "%{$query}%")
                            ->orWhere('clinic_landmark',           'like', "%{$query}%")
                            ->orWhere('clinic_mobile_number',      'like', "%{$query}%")
                            ->orWhere('clinic_contact_person_name', 'like', "%{$query}%");
                    })
                    ->with(['banner', 'tests'])
                    ->get([
                        'id',
                        'clinic_name',
                        'clinic_address',
                        'clinic_pincode',
                        'clinic_state',
                        'clinic_mobile_number',
                        'clinic_google_map_link',
                        'clinic_city',
                        'slug',
                        'currently_loggedin_partner_id'
                    ]);

                $pathPartnerIds = PartnerAllPathologyTestModel::where('test_type', 'like', "%{$query}%")
                    ->pluck('currently_loggedin_partner_id');

                $byTestPathQuery = PartnerPathologyContactModel::whereIn('currently_loggedin_partner_id', $pathPartnerIds)
                    ->where('status', 'active');
                if ($user_city !== '') {
                    $byTestPathQuery->where('clinic_city', $user_city);
                }

                $byTestPath = $byTestPathQuery->with(['banner', 'tests'])
                    ->get([
                        'id',
                        'clinic_name',
                        'clinic_address',
                        'clinic_pincode',
                        'clinic_mobile_number',
                        'clinic_google_map_link',
                        'clinic_state',
                        'clinic_city',
                        'slug',
                        'currently_loggedin_partner_id'
                    ]);

                $paths = $directPath->merge($byTestPath)->unique('id')->values();
            }

            // ── Doctor Search ──────────────────────────────────────────────
            if (in_array($category, ['all', 'doctor'])) {

                $docsQuery = PartnerDoctorContactModel::where('status', 'active');
                if ($user_city !== '') {
                    $docsQuery->where('partner_doctor_city', $user_city);
                }

                $docs = $docsQuery->where(function ($q) use ($query) {
                        $q->where('partner_doctor_name',         'like', "%{$query}%")
                            ->orWhere('partner_doctor_specialist',  'like', "%{$query}%")
                            ->orWhere('partner_doctor_designation', 'like', "%{$query}%")
                            ->orWhere('partner_doctor_address',     'like', "%{$query}%")
                            ->orWhere('partner_doctor_city',        'like', "%{$query}%")
                            ->orWhere('partner_doctor_state',       'like', "%{$query}%")
                            ->orWhere('partner_doctor_pincode',     'like', "%{$query}%")
                            ->orWhere('partner_doctor_mobile',      'like', "%{$query}%")
                            ->orWhere('partner_doctor_landmark',    'like', "%{$query}%");
                    })
                    ->with('banner')
                    ->get([
                        'id',
                        'partner_doctor_name',
                        'partner_doctor_specialist',
                        'partner_doctor_address',
                        'partner_doctor_city',
                        'partner_doctor_state',
                        'partner_doctor_pincode',
                        'partner_doctor_mobile',
                        'partner_doctor_landmark',
                        'slug',
                        'currently_loggedin_partner_id',
                        'status',
                        'visit_day_time',
                        'partner_doctor_google_map_link'
                    ]);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Search results fetched successfully.',
                'data'    => [
                    'query'         => $query,
                    'category'      => $category,
                    'total_results' => $opds->count() + $paths->count() + $docs->count(),
                    'opds'          => $opds->values(),
                    'pathologies'   => $paths->values(),
                    'doctors'       => $docs->values(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }
}
