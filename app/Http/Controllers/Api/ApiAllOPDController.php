<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerAllOPDDoctorModel;
use Illuminate\Http\Request;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerServiceListModel;

class ApiAllOPDController extends Controller
{
    // public function allOpdData()
    // {
    //     $allOpdContacts = PartnerOPDContactModel::with('banner')->inRandomOrder()->get();

    //     $finalData = $allOpdContacts->map(function ($contact) {
    //         if ($contact->banner && $contact->banner->opdbanner) {
    //             $contact->banner->opdbanner = asset('storage/' . $contact->banner->opdbanner);
    //         }

    //         $partnerId = $contact->currently_loggedin_partner_id;

    //         $tests = PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partnerId)->get();
    //         foreach ($tests as $test) {
    //             $test->test_day_time = json_decode($test->test_day_time, true);
    //         }

    //         return [
    //             'opdContact' => $contact,
    //             'doctors' => $tests,
    //             'services' => PartnerServiceListModel::where('currently_loggedin_partner_id', $partnerId)->get(),
    //             'opdDetailsData' => PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partnerId)->get(),

    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'count' => $finalData->count(),
    //         'data' => $finalData,
    //     ]);
    // }


    // ── OPDs ───────────────────────────────────────────────────────────────────
    public function allOpdData(Request $request)
    {
        try {
            $query = trim($request->get('query', ''));

            $dbQuery = PartnerOPDContactModel::with('banner')
                ->where('status', 'active');

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

                $opds      = $dbQuery->get();
                $finalData = $opds->map(fn($c) => $this->formatOpd($c));

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
                    ->map(fn($c) => $this->formatOpd($c));

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

    private function formatOpd(PartnerOPDContactModel $contact): array
    {
        if ($contact->banner && $contact->banner->opdbanner) {
            $contact->banner->opdbanner = asset('storage/' . $contact->banner->opdbanner);
        }

        $partnerId = $contact->currently_loggedin_partner_id;

        $doctors = PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partnerId)->get();
        foreach ($doctors as $doctor) {
            $doctor->test_day_time = json_decode($doctor->test_day_time, true);
        }

        return [
            'opdContact' => $contact,
            'doctors'    => $doctors,
            'services'   => PartnerServiceListModel::where('currently_loggedin_partner_id', $partnerId)->get(),
        ];
    }
}
