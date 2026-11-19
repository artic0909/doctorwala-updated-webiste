<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DwPartnerModel;
use App\Models\Followup;
use Illuminate\Http\Request;

class SuperFollowupController extends Controller
{
    public function index(Request $request)
    {
        $allPartners = DwPartnerModel::orderBy('partner_clinic_name', 'asc')->get();
        $selectedPartner = null;

        $query = Followup::with('partner');

        if ($request->filled('dw_partner_id')) {
            $selectedPartner = DwPartnerModel::find($request->dw_partner_id);
            $query->where('dw_partner_id', $request->dw_partner_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('remarks', 'like', "%{$search}%")
                  ->orWhereHas('partner', function($pq) use ($search) {
                      $pq->where('partner_clinic_name', 'like', "%{$search}%")
                         ->orWhere('partner_contact_person_name', 'like', "%{$search}%")
                         ->orWhere('partner_mobile_number', 'like', "%{$search}%");
                  });
            });
        }

        $followups = $query->orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('superadmin.followup.create', compact('selectedPartner', 'followups', 'allPartners'));
    }

    /**
     * Store a newly created followup tracking record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dw_partner_id' => 'required|exists:dw_partner_models,id',
            'type' => 'required|in:cll,message,both',
            'remarks' => 'required|string',
            'date' => 'required|date',
        ]);

        try {
            Followup::create($validated);
            return redirect()->back()->with('success', 'Follow-up added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add follow-up: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified followup record from database.
     */
    public function delete($id)
    {
        $followup = Followup::find($id);

        if ($followup) {
            $followup->delete();
            return redirect()->back()->with('success', 'Follow-up deleted successfully!');
        }

        return redirect()->back()->with('error', 'Follow-up record not found.');
    }
}
