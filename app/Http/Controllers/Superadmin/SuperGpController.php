<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Ep;
use App\Models\Gp;
use Illuminate\Http\Request;

class SuperGpController extends Controller
{
    /**
     * Display a listing of GP records with search, EP filter, status filter, and KPI metrics.
     */
    public function index(Request $request)
    {
        $query = Gp::with('ep');

        // Search by keyword (name, code, mobile, or parent EP name)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhereHas('ep', function ($epQ) use ($search) {
                      $epQ->where('name', 'like', "%{$search}%")
                          ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by parent EP
        if ($request->filled('ep_id')) {
            $query->where('ep_id', $request->ep_id);
        }

        // Filter by status (Active / Inactive)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range if provided
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $records = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        // Metric counts for KPI summary cards
        $totalCount    = Gp::count();
        $activeCount   = Gp::where('status', 'Active')->count();
        $inactiveCount = Gp::where('status', 'Inactive')->count();
        $totalEpsWithGp = Gp::distinct('ep_id')->count('ep_id');

        // All active EPs for dropdown selection in Add/Edit modals & filters
        $allEps = Ep::orderBy('name', 'asc')->get();

        return view('superadmin.super-gp', compact(
            'records',
            'totalCount',
            'activeCount',
            'inactiveCount',
            'totalEpsWithGp',
            'allEps'
        ));
    }

    /**
     * Store a newly created GP in storage linked to an EP.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ep_id'  => 'required|exists:eps,id',
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:50|unique:gps,code',
            'mobile' => 'required|string|max:20|unique:gps,mobile',
            'status' => 'required|in:Active,Inactive',
        ]);

        $code = trim($request->code ?? '');

        // If no custom code is provided, auto-generate GP + 6 random digits
        if (empty($code)) {
            do {
                $code = 'GP' . mt_rand(100000, 999999);
            } while (Gp::where('code', $code)->exists());
        }

        $gp = Gp::create([
            'ep_id'  => $request->ep_id,
            'name'   => trim($request->name),
            'code'   => $code,
            'mobile' => trim($request->mobile),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', "GP '{$gp->name}' created successfully with code: {$code}!");
    }

    /**
     * Update the specified GP in storage.
     */
    public function update(Request $request, $id)
    {
        $gp = Gp::findOrFail($id);

        $request->validate([
            'ep_id'  => 'required|exists:eps,id',
            'name'   => 'required|string|max:255',
            'code'   => 'required|string|max:50|unique:gps,code,' . $id,
            'mobile' => 'required|string|max:20|unique:gps,mobile,' . $id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $gp->update([
            'ep_id'  => $request->ep_id,
            'name'   => trim($request->name),
            'code'   => trim($request->code),
            'mobile' => trim($request->mobile),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', "GP '{$gp->name}' updated successfully!");
    }

    /**
     * Toggle the status between Active and Inactive.
     */
    public function toggleStatus($id)
    {
        $gp = Gp::findOrFail($id);
        $gp->status = ($gp->status === 'Active') ? 'Inactive' : 'Active';
        $gp->save();

        return redirect()->back()->with('success', "Status of '{$gp->name}' changed to {$gp->status}!");
    }

    /**
     * Remove the specified GP from storage.
     */
    public function delete($id)
    {
        $gp = Gp::findOrFail($id);
        $name = $gp->name;
        $gp->delete();

        return redirect()->back()->with('success', "GP '{$name}' deleted successfully!");
    }
}
