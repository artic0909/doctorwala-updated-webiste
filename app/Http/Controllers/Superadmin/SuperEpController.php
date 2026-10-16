<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Ep;
use App\Models\Gp;
use Illuminate\Http\Request;

class SuperEpController extends Controller
{
    /**
     * Display a listing of EP records with search, filter, and KPI metrics.
     */
    public function index(Request $request)
    {
        $query = Ep::withCount('gps');

        // Search by keyword (name, code, mobile)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
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
        $totalCount     = Ep::count();
        $activeCount    = Ep::where('status', 'Active')->count();
        $inactiveCount  = Ep::where('status', 'Inactive')->count();
        $totalGpsCount  = Gp::count();

        return view('superadmin.super-ep', compact(
            'records',
            'totalCount',
            'activeCount',
            'inactiveCount',
            'totalGpsCount'
        ));
    }

    /**
     * Store a newly created EP in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:50|unique:eps,code',
            'mobile' => 'required|string|max:20|unique:eps,mobile',
            'status' => 'required|in:Active,Inactive',
        ]);

        $code = trim($request->code ?? '');

        // If no custom code is provided, auto-generate EP + 6 random digits
        if (empty($code)) {
            do {
                $code = 'EP' . mt_rand(100000, 999999);
            } while (Ep::where('code', $code)->exists());
        }

        $ep = Ep::create([
            'name'   => trim($request->name),
            'code'   => $code,
            'mobile' => trim($request->mobile),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', "EP '{$ep->name}' created successfully with code: {$code}!");
    }

    /**
     * Update the specified EP in storage.
     */
    public function update(Request $request, $id)
    {
        $ep = Ep::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'required|string|max:50|unique:eps,code,' . $id,
            'mobile' => 'required|string|max:20|unique:eps,mobile,' . $id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $ep->update([
            'name'   => trim($request->name),
            'code'   => trim($request->code),
            'mobile' => trim($request->mobile),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', "EP '{$ep->name}' updated successfully!");
    }

    /**
     * Toggle the status between Active and Inactive.
     */
    public function toggleStatus($id)
    {
        $ep = Ep::findOrFail($id);
        $ep->status = ($ep->status === 'Active') ? 'Inactive' : 'Active';
        $ep->save();

        return redirect()->back()->with('success', "Status of '{$ep->name}' changed to {$ep->status}!");
    }

    /**
     * Remove the specified EP from storage.
     */
    public function delete($id)
    {
        $ep = Ep::findOrFail($id);
        $name = $ep->name;
        $ep->delete();

        return redirect()->back()->with('success', "EP '{$name}' deleted successfully!");
    }
}
