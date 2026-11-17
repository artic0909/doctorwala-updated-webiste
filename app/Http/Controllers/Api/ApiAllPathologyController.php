<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerAboutDetailsModel;
use App\Models\PartnerAllPathologyTestModel;
use App\Models\PartnerGalleryModel;
use App\Models\PartnerPathologyContactModel;
use App\Models\PartnerServiceListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiAllPathologyController extends Controller
{
    // ── Pathology ──────────────────────────────────────────────────────────────
    public function allPathologyData(Request $request)
    {
        try {
            $query = trim($request->get('query', ''));
            $user_city = trim($request->get('user_city', ''));
            $page = (int) $request->get('page', 1);

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

                $paths = $dbQuery->get();
                $finalData = $this->formatPathologyCollection($paths);

                return response()->json([
                    'status'    => true,
                    'is_search' => true,
                    'total'     => $finalData->count(),
                    'data'      => $finalData,
                ]);
            } else {
                // Normal mode with 10-minute caching to eliminate N+1 & RAND() database bottlenecks
                $cacheKey = "api_all_path_v2_{$user_city}_page_{$page}";

                return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dbQuery) {
                    $paginated = $dbQuery->inRandomOrder()->paginate(10);
                    $finalData = $this->formatPathologyCollection($paginated->getCollection());

                    return response()->json([
                        'status'       => true,
                        'is_search'    => false,
                        'total'        => $paginated->total(),
                        'current_page' => $paginated->currentPage(),
                        'last_page'    => $paginated->lastPage(),
                        'data'         => $finalData,
                    ]);
                });
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    private function formatPathologyCollection($contacts)
    {
        $partnerIds = $contacts->pluck('currently_loggedin_partner_id')->filter()->unique();

        $allTests = PartnerAllPathologyTestModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get()
            ->groupBy('currently_loggedin_partner_id');

        $allServices = PartnerServiceListModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get()
            ->groupBy('currently_loggedin_partner_id');

        $allImages = PartnerGalleryModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get()
            ->groupBy('currently_loggedin_partner_id');

        $allAbout = PartnerAboutDetailsModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get()
            ->groupBy('currently_loggedin_partner_id');

        return $contacts->map(function ($contact) use ($allTests, $allServices, $allImages, $allAbout) {
            if ($contact->banner && $contact->banner->pathologybanner) {
                $contact->banner->pathologybanner = asset('storage/' . $contact->banner->pathologybanner);
            }

            $partnerId = $contact->currently_loggedin_partner_id;

            $tests = $allTests->get($partnerId, collect());
            foreach ($tests as $test) {
                if (is_string($test->test_day_time)) {
                    $test->test_day_time = json_decode($test->test_day_time, true);
                }
            }

            return [
                'pathologyContact' => $contact,
                'tests'            => $tests->values(),
                'services'         => $allServices->get($partnerId, collect())->values(),
                'images'           => $allImages->get($partnerId, collect())->values(),
                'aboutClinics'     => $allAbout->get($partnerId, collect())->values(),
            ];
        });
    }
}
