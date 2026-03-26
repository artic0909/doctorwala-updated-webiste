<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerDoctorContactModel;
use Illuminate\Http\Request;

class ApiAllDoctorController extends Controller
{
    // public function allDoctorData()
    // {
    //     $allDoctorContacts = PartnerDoctorContactModel::with('banner')->inRandomOrder()->get();

    //     $allDoctorContacts = $allDoctorContacts->map(function ($contact) {
    //         if ($contact->banner && $contact->banner->doctorbanner) {
    //             // Fix path with full URL using asset or url()
    //             $contact->banner->doctorbanner = asset('storage/' . $contact->banner->doctorbanner);
    //         }
    //         return $contact;
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'count' => $allDoctorContacts->count(),
    //         'allDoctorContacts' => $allDoctorContacts,
    //     ]);
    // }

    // ── Doctors ────────────────────────────────────────────────────────────────
    public function allDoctorData(Request $request)
    {
        try {
            $query = trim($request->get('query', ''));

            $dbQuery = PartnerDoctorContactModel::with('banner')
                ->where('status', 'active');

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
                // Normal mode — 10 random paginated
                $paginated = $dbQuery->inRandomOrder()->paginate(10);

                $finalData = $paginated->getCollection()
                    ->map(fn($d) => $this->formatDoctor($d));

                return response()->json([
                    'status'        => true,
                    'is_search'     => false,
                    'total'         => $paginated->total(),
                    'current_page'  => $paginated->currentPage(),
                    'last_page'     => $paginated->lastPage(),
                    'data'          => $finalData,
                ]);
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
