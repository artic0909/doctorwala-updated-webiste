<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DwPartnerModel;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuperSettlementController extends Controller
{
    /**
     * Display all partner consultation earnings & settlement management
     */
    public function index(Request $request)
    {
        $query = WalletTransaction::with(['partner.primaryBankDetail', 'partner.bankDetails', 'inquiry', 'settledByAdmin'])
            ->where('transaction_type', 'credit');

        // Status Filter
        $status = $request->get('status', 'all');
        if (in_array($status, ['pending', 'settled', 'rejected'])) {
            $query->where('settlement_status', $status);
        }

        // Search Filter (Partner Name, Partner ID, Mobile, Razorpay ID, Patient Name)
        if ($request->filled('search')) {
            $term = trim($request->search);
            $query->where(function ($q) use ($term) {
                $q->where('reference_id', 'like', "%{$term}%")
                  ->orWhere('razorpay_payment_id', 'like', "%{$term}%")
                  ->orWhere('razorpay_order_id', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhereHas('partner', function ($pq) use ($term) {
                      $pq->where('partner_id', 'like', "%{$term}%")
                         ->orWhere('partner_clinic_name', 'like', "%{$term}%")
                         ->orWhere('partner_contact_person_name', 'like', "%{$term}%")
                         ->orWhere('partner_mobile_number', 'like', "%{$term}%");
                  })
                  ->orWhereHas('inquiry', function ($iq) use ($term) {
                      $iq->where('user_name', 'like', "%{$term}%")
                         ->orWhere('user_mobile', 'like', "%{$term}%")
                         ->orWhere('clinic_name', 'like', "%{$term}%");
                  });
            });
        }

        // Date Range Filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Metrics
        $totalEarnings = (clone $query)->where('status', 'completed')->sum('amount');
        $totalSettled = WalletTransaction::where('transaction_type', 'credit')
            ->where('settlement_status', 'settled')
            ->sum('amount');
        $totalPending = WalletTransaction::where('transaction_type', 'credit')
            ->where('settlement_status', 'pending')
            ->sum('amount');
        $pendingCount = WalletTransaction::where('transaction_type', 'credit')
            ->where('settlement_status', 'pending')
            ->count();
        $settledCount = WalletTransaction::where('transaction_type', 'credit')
            ->where('settlement_status', 'settled')
            ->count();

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('superadmin.settlements.index', compact(
            'transactions',
            'totalEarnings',
            'totalSettled',
            'totalPending',
            'pendingCount',
            'settledCount',
            'status'
        ));
    }

    /**
     * Mark a partner wallet transaction as manually settled
     */
    public function settle(Request $request, $id)
    {
        $request->validate([
            'settlement_notes' => 'nullable|string|max:500',
            'utr_number' => 'nullable|string|max:100',
        ]);

        $transaction = WalletTransaction::findOrFail($id);

        if ($transaction->settlement_status === 'settled') {
            return back()->with('info', 'This payout is already marked as settled.');
        }

        $notes = $request->settlement_notes;
        if ($request->filled('utr_number')) {
            $notes = 'UTR: ' . $request->utr_number . ($notes ? ' | ' . $notes : '');
        }

        $transaction->update([
            'settlement_status' => 'settled',
            'settled_at' => now(),
            'settled_by' => Auth::id(),
            'settlement_notes' => $notes,
        ]);

        return back()->with('success', "Transaction #TX-" . str_pad($transaction->id, 6, '0', STR_PAD_LEFT) . " marked as Settled successfully.");
    }

    /**
     * Bulk settle selected transactions
     */
    public function bulkSettle(Request $request)
    {
        $request->validate([
            'transaction_ids' => 'required|array',
            'transaction_ids.*' => 'exists:wallet_transactions,id',
            'bulk_notes' => 'nullable|string|max:500',
        ]);

        $updated = WalletTransaction::whereIn('id', $request->transaction_ids)
            ->where('settlement_status', '!=', 'settled')
            ->update([
                'settlement_status' => 'settled',
                'settled_at' => now(),
                'settled_by' => Auth::id(),
                'settlement_notes' => $request->bulk_notes ?? 'Bulk settled by Admin',
            ]);

        return back()->with('success', "{$updated} transactions marked as Settled successfully.");
    }
}
