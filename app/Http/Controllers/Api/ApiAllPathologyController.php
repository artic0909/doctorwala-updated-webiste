<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerAboutDetailsModel;
use App\Models\PartnerAllPathologyTestModel;
use App\Models\PartnerGalleryModel;
use App\Models\PartnerPathologyContactModel;
use App\Models\PartnerServiceListModel;
use App\Models\SuperAboutusModel;
use Illuminate\Http\Request;

class ApiAllPathologyController extends Controller
{
    // public function allPathologyData()
    // {
    //     $allPathologyContacts = PartnerPathologyContactModel::with('banner')->inRandomOrder()->get();

    //     $finalData = $allPathologyContacts->map(function ($contact) {
    //         if ($contact->banner && $contact->banner->pathologybanner) {
    //             $contact->banner->pathologybanner = asset('storage/' . $contact->banner->pathologybanner);
    //         }

    //         $partnerId = $contact->currently_loggedin_partner_id;

    //         $tests = PartnerAllPathologyTestModel::where('currently_loggedin_partner_id', $partnerId)->get();
    //         foreach ($tests as $test) {
    //             $test->test_day_time = json_decode($test->test_day_time, true);
    //         }

    //         return [
    //             'pathologyContact' => $contact,
    //             'tests' => $tests,
    //             'services' => PartnerServiceListModel::where('currently_loggedin_partner_id', $partnerId)->get(),
    //             'images' => PartnerGalleryModel::where('currently_loggedin_partner_id', $partnerId)->get(),
    //             'aboutClinics' => PartnerAboutDetailsModel::where('currently_loggedin_partner_id', $partnerId)->get(),
    //             'testsDetailsData' => PartnerAllPathologyTestModel::where('currently_loggedin_partner_id', $partnerId)->get(),

    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'count' => $finalData->count(),
    //         'data' => $finalData,
    //     ]);
    // }

    // ── Pathology ──────────────────────────────────────────────────────────────
    public function allPathologyData(Request $request)
    {
        try {
            $query = trim($request->get('query', ''));
            $user_city = trim($request->get('user_city', ''));

            $dbQuery = PartnerPathologyContactModel::with('banner')
                ->where('status', 'active');

            if ($user_city !== '') {
                $dbQuery->where('clinic_city', $user_city);
            }

            if ($query !== '') {
                // Search mode — also check test_type via related test model
                $pathPartnerIds = PartnerAllPathologyTestModel::where('test_type', 'like', "%{$query}%")
                    ->pluck('currently_loggedin_partner_id');

                $dbQuery->where(function ($q) use ($query, $pathPartnerIds) {
                    $q->where('clinic_name',                  'like', "%{$query}%")
                        ->orWhere('clinic_address',             'like', "%{$query}%")
                        ->orWhere('clinic_city',                'like', "%{$query}%")
                        ->orWhere('clinic_state',               'like', "%{$query}%")
                        ->orWhere('clinic_pincode',             'like', "%{$query}%")
                        ->orWhere('clinic_landmark',            'like', "%{$query}%")
                        ->orWhere('clinic_mobile_number',       'like', "%{$query}%")
                        ->orWhere('clinic_contact_person_name', 'like', "%{$query}%")
                        ->orWhereIn('currently_loggedin_partner_id', $pathPartnerIds);
                });

                $paths     = $dbQuery->get();
                $finalData = $paths->map(fn($c) => $this->formatPathology($c));

                return response()->json([
                    'status'    => true,
                    'is_search' => true,
                    'total'     => $finalData->count(),
                    'data'      => $finalData,
                ]);
            } else {
                // Normal mode — 10 random paginated
                $paginated = $dbQuery->inRandomOrder()->paginate(10);

                $finalData = $paginated->getCollection()
                    ->map(fn($c) => $this->formatPathology($c));

                return response()->json([
                    'status'       => true,
                    'is_search'    => false,
                    'total'        => $paginated->total(),
                    'current_page' => $paginated->currentPage(),
                    'last_page'    => $paginated->lastPage(),
                    'data'         => $finalData,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    private function formatPathology(PartnerPathologyContactModel $contact): array
    {
        if ($contact->banner && $contact->banner->pathologybanner) {
            $contact->banner->pathologybanner = asset('storage/' . $contact->banner->pathologybanner);
        }

        $partnerId = $contact->currently_loggedin_partner_id;

        $tests = PartnerAllPathologyTestModel::where('currently_loggedin_partner_id', $partnerId)->get();
        foreach ($tests as $test) {
            $test->test_day_time = json_decode($test->test_day_time, true);
        }

        return [
            'pathologyContact' => $contact,
            'tests'            => $tests,
            'services'         => PartnerServiceListModel::where('currently_loggedin_partner_id', $partnerId)->get(),
            'images'           => PartnerGalleryModel::where('currently_loggedin_partner_id', $partnerId)->get(),
            'aboutClinics'     => PartnerAboutDetailsModel::where('currently_loggedin_partner_id', $partnerId)->get(),
        ];
    }
}
