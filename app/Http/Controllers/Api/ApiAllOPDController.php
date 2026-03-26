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


    public function allOpdData()
    {
        // 1. Use 'paginate(10)' to fetch only 10 at a time
        // 2. Use 'with()' to fetch doctors and services in ONE go (Eager Loading)
        // IMPORTANT: You should define 'doctors' and 'services' relationships in your PartnerOPDContactModel
        $paginatedContacts = PartnerOPDContactModel::with(['banner'])
            ->inRandomOrder()
            ->paginate(10); // Fetch only 10

        $finalData = $paginatedContacts->getCollection()->map(function ($contact) {
            if ($contact->banner && $contact->banner->opdbanner) {
                $contact->banner->opdbanner = asset('storage/' . $contact->banner->opdbanner);
            }

            $partnerId = $contact->currently_loggedin_partner_id;

            // Optimized: Fetching these once per contact is okay if not using 'with', 
            // but it's better to fetch only what's needed.
            $doctors = PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partnerId)->get();
            foreach ($doctors as $doctor) {
                $doctor->test_day_time = json_decode($doctor->test_day_time, true);
            }

            return [
                'opdContact' => $contact,
                'doctors' => $doctors,
                'services' => PartnerServiceListModel::where('currently_loggedin_partner_id', $partnerId)->get(),
            ];
        });

        return response()->json([
            'status' => true,
            'total' => $paginatedContacts->total(),
            'current_page' => $paginatedContacts->currentPage(),
            'last_page' => $paginatedContacts->lastPage(),
            'data' => $finalData,
        ]);
    }
}
