<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerAllOPDDoctorModel;
use Illuminate\Http\Request;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerServiceListModel;
use Illuminate\Support\Facades\Cache;

class ApiAllOPDController extends Controller
{
    // ── OPDs ───────────────────────────────────────────────────────────────────
    public function allOpdData(Request $request)
    {
        try {
            $query = trim($request->get('query', ''));
            $user_city = trim($request->get('user_city', ''));
            $page = (int) $request->get('page', 1);

            $dbQuery = PartnerOPDContactModel::with('banner')
                ->where('status', 'active');

            if ($user_city !== '') {
                $dbQuery->where('clinic_city', $user_city);
            }

            if ($query !== '') {
                // Search mode — also check specialist via related doctor model
                $opdPartnerIds = PartnerAllOPDDoctorModel::where('doctor_specialist', 'like', "%{$query}%")
                    ->pluck('currently_loggedin_partner_id');

                $dbQuery->where(function ($q) use ($query, $opdPartnerIds) {
                    $q->where('clinic_name',                  'like', "%{$query}%")
                        ->orWhere('clinic_address',             'like', "%{$query}%")
                        ->orWhere('clinic_city',                'like', "%{$query}%")
                        ->orWhere('clinic_state',               'like', "%{$query}%")
                        ->orWhere('clinic_pincode',             'like', "%{$query}%")
                        ->orWhere('clinic_landmark',            'like', "%{$query}%")
                        ->orWhere('clinic_mobile_number',       'like', "%{$query}%")
                        ->orWhere('clinic_contact_person_name', 'like', "%{$query}%")
                        ->orWhereIn('currently_loggedin_partner_id', $opdPartnerIds);
                });

                $opds = $dbQuery->get();
                $finalData = $this->formatOpdCollection($opds);

                return response()->json([
                    'status'    => true,
                    'is_search' => true,
                    'total'     => $finalData->count(),
                    'data'      => $finalData,
                ]);
            } else {
                // Normal mode with 10-minute caching to eliminate N+1 & RAND() database bottlenecks
                $cacheKey = "api_all_opd_v2_{$user_city}_page_{$page}";

                return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dbQuery) {
                    $paginated = $dbQuery->inRandomOrder()->paginate(10);
                    $finalData = $this->formatOpdCollection($paginated->getCollection());

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

    private function formatOpdCollection($contacts)
    {
        $partnerIds = $contacts->pluck('currently_loggedin_partner_id')->filter()->unique();

        $allDoctors = PartnerAllOPDDoctorModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get()
            ->groupBy('currently_loggedin_partner_id');

        $allServices = PartnerServiceListModel::whereIn('currently_loggedin_partner_id', $partnerIds)->get()
            ->groupBy('currently_loggedin_partner_id');

        return $contacts->map(function ($contact) use ($allDoctors, $allServices) {
            if ($contact->banner && $contact->banner->opdbanner) {
                $contact->banner->opdbanner = asset('storage/' . $contact->banner->opdbanner);
            }

            $partnerId = $contact->currently_loggedin_partner_id;

            $doctors = $allDoctors->get($partnerId, collect());
            foreach ($doctors as $doctor) {
                if (is_string($doctor->test_day_time)) {
                    $doctor->test_day_time = json_decode($doctor->test_day_time, true);
                }
            }

            return [
                'opdContact' => $contact,
                'doctors'    => $doctors->values(),
                'services'   => $allServices->get($partnerId, collect())->values(),
            ];
        });
    }
}
