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

    public function allDoctorData()
    {
        // 1. Paginate correctly
        $paginatedDoctors = PartnerDoctorContactModel::with('banner')->inRandomOrder()->paginate(10);

        $finalData = $paginatedDoctors->getCollection()->map(function ($contact) {
            if ($contact->banner && $contact->banner->doctorbanner) {
                $contact->banner->doctorbanner = asset('storage/' . $contact->banner->doctorbanner);
            }
            return $contact;
        });

        return response()->json([
            'status' => true,
            'total' => $paginatedDoctors->total(),
            'current_page' => $paginatedDoctors->currentPage(),
            'last_page' => $paginatedDoctors->lastPage(),
            'data' => $finalData,
        ]);
    }
}
