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
            $registration_type = strtolower(trim($request->get('registration_type', $request->get('filterRegistrationType', ''))));

            $dbQuery = PartnerDoctorContactModel::with('banner')
                ->where('status', 'active');

            if ($user_city !== '') {
                $dbQuery->where('partner_doctor_city', $user_city);
            }

            // Registration type / category filtering (e.g. 'others' for physiotherapist & allied care)
            if ($registration_type === 'others') {
                $dbQuery->where(function ($q) {
                    $q->where('clinic_registration_type', 'Others')
                        ->orWhere('clinic_registration_type', 'like', '%other%')
                        ->orWhere('partner_doctor_specialist', 'like', '%physio%')
                        ->orWhere('partner_doctor_designation', 'like', '%physio%')
                        ->orWhere('partner_doctor_specialist', 'like', '%therapy%')
                        ->orWhere('partner_doctor_name', 'like', '%physio%');
                });
            } elseif ($registration_type === 'doctor') {
                $dbQuery->where(function ($q) {
                    $q->where('clinic_registration_type', 'Doctor')
                        ->orWhereNull('clinic_registration_type')
                        ->orWhere('clinic_registration_type', '');
                })->where('partner_doctor_specialist', 'not like', '%physio%')
                  ->where('partner_doctor_name', 'not like', '%physio%');
            }

            if ($query !== '') {
                // If query is specifically "other" or "others" and registration_type wasn't passed, treat as others filter
                if (in_array(strtolower($query), ['other', 'others']) && empty($registration_type)) {
                    $dbQuery->where(function ($q) {
                        $q->where('clinic_registration_type', 'Others')
                            ->orWhere('clinic_registration_type', 'like', '%other%')
                            ->orWhere('partner_doctor_specialist', 'like', '%physio%')
                            ->orWhere('partner_doctor_designation', 'like', '%physio%')
                            ->orWhere('partner_doctor_specialist', 'like', '%therapy%')
                            ->orWhere('partner_doctor_name', 'like', '%physio%');
                    });
                    
                    $paginated = $dbQuery->paginate(10);
                    $finalData = $paginated->getCollection()->map(fn($d) => $this->formatDoctor($d));

                    return response()->json([
                        'status'        => true,
                        'is_search'     => false,
                        'total'         => $paginated->total(),
                        'current_page'  => $paginated->currentPage(),
                        'last_page'     => $paginated->lastPage(),
                        'data'          => $finalData,
                    ]);
                }

                // Search mode — paginated 10 per page
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

                $paginated = $dbQuery->paginate(10);
                $finalData = $paginated->getCollection()->map(fn($d) => $this->formatDoctor($d));

                return response()->json([
                    'status'        => true,
                    'is_search'     => true,
                    'total'         => $paginated->total(),
                    'current_page'  => $paginated->currentPage(),
                    'last_page'     => $paginated->lastPage(),
                    'data'          => $finalData,
                ]);
            } else {
                // Normal mode with 10-minute caching
                $cacheKey = "api_all_doc_v5_{$registration_type}_{$user_city}_page_{$page}";

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
