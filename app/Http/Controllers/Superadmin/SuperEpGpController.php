<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\EpGp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuperEpGpController extends Controller
{
    /**
     * Display a listing of EP & GP records with search and filters.
     */
    public function index(Request $request)
    {
        $query = EpGp::query();

        // Search by keyword (name, code, mobile)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        // Filter by role (EP / GP)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
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

        // Metric counts for KPI cards
        $totalCount  = EpGp::count();
        $epCount     = EpGp::where('role', 'EP')->count();
        $gpCount     = EpGp::where('role', 'GP')->count();
        $activeCount = EpGp::where('status', 'Active')->count();

        return view('superadmin.super-ep-gp', compact(
            'records',
            'totalCount',
            'epCount',
            'gpCount',
            'activeCount'
        ));
    }

    /**
     * Store a newly created EP / GP record in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'role'   => 'required|in:EP,GP',
            'code'   => 'nullable|string|max:50|unique:ep_gps,code',
            'mobile' => 'required|string|max:20|unique:ep_gps,mobile',
            'status' => 'required|in:Active,Inactive',
        ]);

        $role = strtoupper(trim($request->role));
        $code = trim($request->code ?? '');

        // If no code provided, generate a unique one (e.g. EP739281, GP581920)
        if (empty($code)) {
            do {
                $code = $role . mt_rand(100000, 999999);
            } while (EpGp::where('code', $code)->exists());
        }

        EpGp::create([
            'name'   => trim($request->name),
            'role'   => $role,
            'code'   => $code,
            'mobile' => trim($request->mobile),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', "{$role} member created successfully with code: {$code}!");
    }

    /**
     * Update the specified EP / GP record.
     */
    public function update(Request $request, $id)
    {
        $record = EpGp::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'role'   => 'required|in:EP,GP',
            'code'   => 'required|string|max:50|unique:ep_gps,code,' . $id,
            'mobile' => 'required|string|max:20|unique:ep_gps,mobile,' . $id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $record->update([
            'name'   => trim($request->name),
            'role'   => strtoupper(trim($request->role)),
            'code'   => trim($request->code),
            'mobile' => trim($request->mobile),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Member updated successfully!');
    }

    /**
     * Toggle the status between Active and Inactive.
     */
    public function toggleStatus($id)
    {
        $record = EpGp::findOrFail($id);
        $record->status = ($record->status === 'Active') ? 'Inactive' : 'Active';
        $record->save();

        return redirect()->back()->with('success', "Status updated to {$record->status} successfully!");
    }

    /**
     * Remove the specified record from storage.
     */
    public function delete($id)
    {
        $record = EpGp::findOrFail($id);
        $name = $record->name;
        $role = $record->role;
        $record->delete();

        return redirect()->back()->with('success', "{$role} member ({$name}) deleted successfully!");
    }
}
