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

        if (!$partnerId) {
            return redirect()->route('superadmin.super-all-partner.get')->with('error', 'Please select a partner to view their follow-up history.');
        }

        // Get specific partner details
        $selectedPartner = DwPartnerModel::findOrFail($partnerId);

        // Get followup records associated specifically with this partner
        $followups = Followup::with('partner')
            ->where('dw_partner_id', $partnerId)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('superadmin.followup.create', compact('selectedPartner', 'followups'));
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
