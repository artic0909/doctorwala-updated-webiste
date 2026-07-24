<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Reffer;
use Illuminate\Http\Request;
use App\Exports\ReferralsExport;
use Maatwebsite\Excel\Facades\Excel;

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

        if ($request->has('from_date') && $request->from_date != '') {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $referrals = $query->orderBy('id', 'desc')->paginate(10);
        
        // Calculate KPIs
        $totalReferrals = Reffer::count();
        $monthlyReferrals = Reffer::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)
                                  ->count();
                                  
        $totalUniqueReferrals = Reffer::whereNotNull('ip_address')->distinct('ip_address')->count('ip_address');
        $monthlyUniqueReferrals = Reffer::whereNotNull('ip_address')
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->distinct('ip_address')
                                        ->count('ip_address');

        // Find Duplicate IPs
        $duplicateIps = Reffer::select('ip_address')
            ->whereNotNull('ip_address')
            ->groupBy('ip_address')
            ->havingRaw('COUNT(id) > 1')
            ->pluck('ip_address')
            ->toArray();

        return view('superadmin.super-all-reffer', compact(
            'referrals', 
            'totalReferrals', 
            'monthlyReferrals', 
            'totalUniqueReferrals', 
            'monthlyUniqueReferrals',
            'duplicateIps'
        ));
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

    /**
     * Export referral registrations to Excel.
     */
    public function exportAsExel(Request $request)
    {
        return Excel::download(new ReferralsExport($request->all()), 'referral_registrations.xlsx');
    }
}
