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
        $partnerId = $request->input('dw_partner_id');
        $allPartners = DwPartnerModel::orderBy('partner_clinic_name', 'asc')->get();
        $selectedPartner = null;

        if ($partnerId) {
            $selectedPartner = DwPartnerModel::find($partnerId);
            $followups = Followup::with('partner')
                ->where('dw_partner_id', $partnerId)
                ->orderBy('date', 'desc')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $followups = Followup::with('partner')
                ->orderBy('date', 'desc')
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

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
