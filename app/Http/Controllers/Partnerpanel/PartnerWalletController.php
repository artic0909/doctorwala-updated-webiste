<?php

namespace App\Http\Controllers\Partnerpanel;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartnerWalletController extends Controller
{
    /**
     * Check if partner has Doctor or Others in registration_type
     */
    protected function checkEligibility($partner)
    {
        $types = $partner->registration_type;
        if (is_string($types)) {
            $types = json_decode($types, true) ?: explode(',', $types);
        }
        $types = is_array($types) ? $types : [];

        return in_array('Doctor', $types) || in_array('Others', $types);
    }

    /**
     * Display the wallet overview & transactions
     */
    public function walletView(Request $request)
    {
        $partner = Auth::guard('partner')->user();

        if (!$this->checkEligibility($partner)) {
            return redirect()->route('partnerpanel.partner-dashboard')
                ->with('error', 'Wallet is exclusively available for Doctor and Physiotherapy & Allied Care partners.');
        }

        // Get or initialize wallet
        $wallet = Wallet::firstOrCreate(
            ['dw_partner_id' => $partner->id],
            [
                'balance' => 0.00,
                'currency' => 'INR',
                'status' => 'active',
            ]
        );

        // Calculate summary metrics
        $totalEarned = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');

        $totalWithdrawn = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'debit')
            ->where('status', 'completed')
            ->sum('amount');

        $pendingPayout = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'debit')
            ->where('status', 'pending')
            ->sum('amount');

        // Settlement breakdown for earnings
        $pendingSettlement = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'credit')
            ->where('settlement_status', 'pending')
            ->sum('amount');

        $totalSettled = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'credit')
            ->where('settlement_status', 'settled')
            ->sum('amount');

        // Transactions query with filters
        $txQuery = WalletTransaction::where('wallet_id', $wallet->id);

        if ($request->filled('type') && in_array($request->type, ['credit', 'debit'])) {
            $txQuery->where('transaction_type', $request->type);
        }

        if ($request->filled('status')) {
            $txQuery->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $txQuery->where(function ($q) use ($search) {
                $q->where('reference_id', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('source', 'like', "%{$search}%");
            });
        }

        $transactions = $txQuery->orderBy('id', 'desc')->paginate(15)->withQueryString();

        // Primary bank account
        $primaryBank = BankDetail::where('dw_partner_id', $partner->id)
            ->where('is_primary', true)
            ->first();

        $totalBankAccounts = BankDetail::where('dw_partner_id', $partner->id)->count();

        return view('partnerpanel.wallet.index', compact(
            'partner',
            'wallet',
            'totalEarned',
            'totalWithdrawn',
            'pendingPayout',
            'pendingSettlement',
            'totalSettled',
            'transactions',
            'primaryBank',
            'totalBankAccounts'
        ));
    }

    /**
     * Display list of bank accounts
     */
    public function bankDetailsView()
    {
        $partner = Auth::guard('partner')->user();

        if (!$this->checkEligibility($partner)) {
            return redirect()->route('partnerpanel.partner-dashboard')
                ->with('error', 'Bank Details management is exclusively available for Doctor and Physiotherapy & Allied Care partners.');
        }

        $bankAccounts = BankDetail::where('dw_partner_id', $partner->id)
            ->orderBy('is_primary', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('partnerpanel.wallet.bank-details', compact('partner', 'bankAccounts'));
    }

    /**
     * Store a new bank account
     */
    public function storeBankDetails(Request $request)
    {
        $partner = Auth::guard('partner')->user();

        if (!$this->checkEligibility($partner)) {
            return redirect()->route('partnerpanel.partner-dashboard')
                ->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'bank_name' => 'required|string|max:150',
            'account_no' => 'required|string|max:50',
            'ifsc_code' => 'required|string|max:50',
            'branch_name' => 'nullable|string|max:150',
            'account_holder_name' => 'nullable|string|max:150',
            'upi_id' => 'nullable|string|max:100',
        ]);

        $existingCount = BankDetail::where('dw_partner_id', $partner->id)->count();
        $isPrimary = $request->has('is_primary') || $existingCount === 0;

        DB::transaction(function () use ($partner, $request, $isPrimary) {
            if ($isPrimary) {
                BankDetail::where('dw_partner_id', $partner->id)->update(['is_primary' => false]);
            }

            BankDetail::create([
                'dw_partner_id' => $partner->id,
                'bank_name' => trim($request->bank_name),
                'account_no' => trim($request->account_no),
                'ifsc_code' => strtoupper(trim($request->ifsc_code)),
                'branch_name' => $request->branch_name ? trim($request->branch_name) : null,
                'account_holder_name' => $request->account_holder_name ? trim($request->account_holder_name) : $partner->partner_contact_person_name,
                'upi_id' => $request->upi_id ? trim($request->upi_id) : null,
                'is_primary' => $isPrimary,
                'status' => 'active',
            ]);
        });

        return redirect()->route('partner.bank.details.index')
            ->with('success', 'Bank account added successfully.');
    }

    /**
     * Update an existing bank account
     */
    public function updateBankDetails(Request $request, $id)
    {
        $partner = Auth::guard('partner')->user();

        $bankDetail = BankDetail::where('id', $id)
            ->where('dw_partner_id', $partner->id)
            ->firstOrFail();

        $request->validate([
            'bank_name' => 'required|string|max:150',
            'account_no' => 'required|string|max:50',
            'ifsc_code' => 'required|string|max:50',
            'branch_name' => 'nullable|string|max:150',
            'account_holder_name' => 'nullable|string|max:150',
            'upi_id' => 'nullable|string|max:100',
        ]);

        $isPrimary = $request->has('is_primary');

        DB::transaction(function () use ($partner, $bankDetail, $request, $isPrimary) {
            if ($isPrimary) {
                BankDetail::where('dw_partner_id', $partner->id)
                    ->where('id', '!=', $bankDetail->id)
                    ->update(['is_primary' => false]);
            }

            $bankDetail->update([
                'bank_name' => trim($request->bank_name),
                'account_no' => trim($request->account_no),
                'ifsc_code' => strtoupper(trim($request->ifsc_code)),
                'branch_name' => $request->branch_name ? trim($request->branch_name) : null,
                'account_holder_name' => $request->account_holder_name ? trim($request->account_holder_name) : $bankDetail->account_holder_name,
                'upi_id' => $request->upi_id ? trim($request->upi_id) : null,
                'is_primary' => $isPrimary ? true : $bankDetail->is_primary,
            ]);
        });

        return redirect()->route('partner.bank.details.index')
            ->with('success', 'Bank account details updated successfully.');
    }

    /**
     * Delete a bank account
     */
    public function deleteBankDetails($id)
    {
        $partner = Auth::guard('partner')->user();

        $bankDetail = BankDetail::where('id', $id)
            ->where('dw_partner_id', $partner->id)
            ->firstOrFail();

        $wasPrimary = $bankDetail->is_primary;
        $bankDetail->delete();

        // If primary was deleted, promote another account if exists
        if ($wasPrimary) {
            $next = BankDetail::where('dw_partner_id', $partner->id)->first();
            if ($next) {
                $next->update(['is_primary' => true]);
            }
        }

        return redirect()->route('partner.bank.details.index')
            ->with('success', 'Bank account removed successfully.');
    }

    /**
     * Set a bank account as primary
     */
    public function setPrimaryBankDetails($id)
    {
        $partner = Auth::guard('partner')->user();

        $bankDetail = BankDetail::where('id', $id)
            ->where('dw_partner_id', $partner->id)
            ->firstOrFail();

        DB::transaction(function () use ($partner, $bankDetail) {
            BankDetail::where('dw_partner_id', $partner->id)->update(['is_primary' => false]);
            $bankDetail->update(['is_primary' => true]);
        });

        return redirect()->back()
            ->with('success', "{$bankDetail->bank_name} account set as primary payout destination.");
    }
}
