<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Reffer;
use Illuminate\Http\Request;

class SuperRefferController extends Controller
{
    /**
     * Display a listing of referral registrations.
     */
    public function index(Request $request)
    {
        $query = Reffer::with('referredBy')->withCount('referees');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('referral_code', 'like', "%{$search}%")
                  ->orWhere('upi', 'like', "%{$search}%")
                  ->orWhere('medical_card_number', 'like', "%{$search}%");
            });
        }

        $referrals = $query->orderBy('id', 'desc')->paginate(10);
        return view('superadmin.super-all-reffer', compact('referrals'));
    }

    /**
     * Delete a referral registration.
     */
    public function delete($id)
    {
        $reffer = Reffer::findOrFail($id);
        
        // Delete profile screenshot from disk if it exists
        if ($reffer->profile_screenshot && file_exists(public_path('storage/' . $reffer->profile_screenshot))) {
            @unlink(public_path('storage/' . $reffer->profile_screenshot));
        }

        $reffer->delete();

        return back()->with('success', 'Referral registration deleted successfully!');
    }
}
