<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerDoctorContactModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiAllDoctorController extends Controller
{
    // ── Doctors ────────────────────────────────────────────────────────────────
    public function allDoctorData(Request $request)
    {
        try {
            $query = trim($request->get('query', ''));
            $user_city = trim($request->get('user_city', ''));
            $page = (int) $request->get('page', 1);

            $dbQuery = PartnerDoctorContactModel::with('banner')
                ->where('status', 'active');

            if ($user_city !== '') {
                $dbQuery->where('partner_doctor_city', $user_city);
            }

            if ($query !== '') {
                // Search mode — full table, no pagination
                $dbQuery->where(function ($q) use ($query) {
                    $q->where('partner_doctor_name',         'like', "%{$query}%")
                        ->orWhere('partner_doctor_specialist',  'like', "%{$query}%")
                        ->orWhere('partner_doctor_designation', 'like', "%{$query}%")
                        ->orWhere('partner_doctor_city',        'like', "%{$query}%")
                        ->orWhere('partner_doctor_state',       'like', "%{$query}%")
                        ->orWhere('partner_doctor_pincode',     'like', "%{$query}%")
                        ->orWhere('partner_doctor_mobile',      'like', "%{$query}%")
                        ->orWhere('partner_doctor_address',     'like', "%{$query}%")
                        ->orWhere('partner_doctor_landmark',    'like', "%{$query}%");
                });

                $doctors = $dbQuery->get();
                $finalData = $doctors->map(fn($d) => $this->formatDoctor($d));

                return response()->json([
                    'status'        => true,
                    'is_search'     => true,
                    'total'         => $finalData->count(),
                    'data'          => $finalData,
                ]);
            } else {
                // Normal mode with 10-minute caching to eliminate RAND() database bottleneck
                $cacheKey = "api_all_doc_v2_{$user_city}_page_{$page}";

                return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dbQuery) {
                    $paginated = $dbQuery->inRandomOrder()->paginate(10);
                    $finalData = $paginated->getCollection()->map(fn($d) => $this->formatDoctor($d));

                    return response()->json([
                        'status'        => true,
                        'is_search'     => false,
                        'total'         => $paginated->total(),
                        'current_page'  => $paginated->currentPage(),
                        'last_page'     => $paginated->lastPage(),
                        'data'          => $finalData,
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

    private function formatDoctor(PartnerDoctorContactModel $doctor): array
    {
        if ($doctor->banner && $doctor->banner->doctorbanner) {
            $doctor->banner->doctorbanner = asset('storage/' . $doctor->banner->doctorbanner);
        }
        return $doctor->toArray();
    }
}
