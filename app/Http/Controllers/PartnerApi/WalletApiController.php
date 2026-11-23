<?php

namespace App\Http\Controllers\PartnerApi;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WalletApiController extends Controller
{
    /**
     * Check if partner has Doctor or Others in registration_type
     */
    protected function isEligible($partner): bool
    {
        $types = $partner->registration_type;
        if (is_string($types)) {
            $types = json_decode($types, true) ?: explode(',', $types);
        }
        $types = is_array($types) ? $types : [];

        return in_array('Doctor', $types) || in_array('Others', $types);
    }

    /**
     * Get wallet overview, summary, primary bank and recent transactions
     */
    public function getWallet(Request $request)
    {
        $partner = $request->user();

        if (!$this->isEligible($partner)) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet and bank details are exclusively available for Doctor and Physiotherapy / Allied Care partners.',
            ], 403);
        }

        $wallet = Wallet::firstOrCreate(
            ['dw_partner_id' => $partner->id],
            [
                'balance' => 0.00,
                'currency' => 'INR',
                'status' => 'active',
            ]
        );

        $totalEarned = (float) WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');

        $totalWithdrawn = (float) WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'debit')
            ->where('status', 'completed')
            ->sum('amount');

        $pendingPayout = (float) WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'debit')
            ->where('status', 'pending')
            ->sum('amount');

        $pendingSettlement = (float) WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'credit')
            ->where('settlement_status', 'pending')
            ->sum('amount');

        $totalSettled = (float) WalletTransaction::where('wallet_id', $wallet->id)
            ->where('transaction_type', 'credit')
            ->where('settlement_status', 'settled')
            ->sum('amount');

        $primaryBank = BankDetail::where('dw_partner_id', $partner->id)
            ->where('is_primary', true)
            ->first();

        $recentTransactions = WalletTransaction::where('wallet_id', $wallet->id)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $bankAccountsCount = BankDetail::where('dw_partner_id', $partner->id)->count();

        return response()->json([
            'success' => true,
            'wallet' => [
                'id' => $wallet->id,
                'balance' => (float) $wallet->balance,
                'currency' => $wallet->currency,
                'status' => $wallet->status,
                'updated_at' => $wallet->updated_at ? $wallet->updated_at->toIso8601String() : null,
            ],
            'summary' => [
                'balance' => (float) $wallet->balance,
                'total_earned' => $totalEarned,
                'total_withdrawn' => $totalWithdrawn,
                'pending_payout' => $pendingPayout,
                'pending_settlement' => $pendingSettlement,
                'total_settled' => $totalSettled,
                'bank_accounts_count' => $bankAccountsCount,
            ],
            'primary_bank' => $primaryBank ? [
                'id' => $primaryBank->id,
                'bank_name' => $primaryBank->bank_name,
                'account_no' => $primaryBank->account_no,
                'masked_account_no' => $primaryBank->masked_account_no,
                'ifsc_code' => $primaryBank->ifsc_code,
                'branch_name' => $primaryBank->branch_name,
                'account_holder_name' => $primaryBank->account_holder_name,
                'upi_id' => $primaryBank->upi_id,
                'is_primary' => true,
            ] : null,
            'recent_transactions' => $recentTransactions,
        ]);
    }

    /**
     * Get paginated transaction history
     */
    public function getTransactions(Request $request)
    {
        $partner = $request->user();

        if (!$this->isEligible($partner)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        $wallet = Wallet::firstOrCreate(['dw_partner_id' => $partner->id]);

        $query = WalletTransaction::where('wallet_id', $wallet->id);

        if ($request->filled('type') && in_array($request->type, ['credit', 'debit'])) {
            $query->where('transaction_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('settlement_status') && in_array($request->settlement_status, ['pending', 'settled', 'rejected'])) {
            $query->where('settlement_status', $request->settlement_status);
        }

        $perPage = (int) $request->get('per_page', 10);
        $transactions = $query->orderBy('id', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'transactions' => $transactions->items(),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }

    /**
     * List all bank accounts
     */
    public function getBankDetails(Request $request)
    {
        $partner = $request->user();

        if (!$this->isEligible($partner)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        $bankAccounts = BankDetail::where('dw_partner_id', $partner->id)
            ->orderBy('is_primary', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($bank) {
                return [
                    'id' => $bank->id,
                    'bank_name' => $bank->bank_name,
                    'account_no' => $bank->account_no,
                    'masked_account_no' => $bank->masked_account_no,
                    'ifsc_code' => $bank->ifsc_code,
                    'branch_name' => $bank->branch_name,
                    'account_holder_name' => $bank->account_holder_name,
                    'upi_id' => $bank->upi_id,
                    'is_primary' => (bool) $bank->is_primary,
                    'status' => $bank->status,
                    'created_at' => $bank->created_at ? $bank->created_at->toIso8601String() : null,
                ];
            });

        return response()->json([
            'success' => true,
            'bank_accounts' => $bankAccounts,
        ]);
    }

    /**
     * Add new bank account
     */
    public function storeBankDetail(Request $request)
    {
        $partner = $request->user();

        if (!$this->isEligible($partner)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:150',
            'account_no' => 'required|string|max:50',
            'ifsc_code' => 'required|string|max:50',
            'branch_name' => 'nullable|string|max:150',
            'account_holder_name' => 'nullable|string|max:150',
            'upi_id' => 'nullable|string|max:100',
            'is_primary' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $existingCount = BankDetail::where('dw_partner_id', $partner->id)->count();
        $isPrimary = $request->boolean('is_primary') || $existingCount === 0;

        $bankDetail = DB::transaction(function () use ($partner, $request, $isPrimary) {
            if ($isPrimary) {
                BankDetail::where('dw_partner_id', $partner->id)->update(['is_primary' => false]);
            }

            return BankDetail::create([
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

        return response()->json([
            'success' => true,
            'message' => 'Bank account added successfully.',
            'bank_account' => [
                'id' => $bankDetail->id,
                'bank_name' => $bankDetail->bank_name,
                'account_no' => $bankDetail->account_no,
                'masked_account_no' => $bankDetail->masked_account_no,
                'ifsc_code' => $bankDetail->ifsc_code,
                'branch_name' => $bankDetail->branch_name,
                'account_holder_name' => $bankDetail->account_holder_name,
                'upi_id' => $bankDetail->upi_id,
                'is_primary' => (bool) $bankDetail->is_primary,
                'status' => $bankDetail->status,
            ],
        ], 201);
    }

    /**
     * Update bank account
     */
    public function updateBankDetail(Request $request, $id)
    {
        $partner = $request->user();

        $bankDetail = BankDetail::where('id', $id)
            ->where('dw_partner_id', $partner->id)
            ->first();

        if (!$bankDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Bank account not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:150',
            'account_no' => 'required|string|max:50',
            'ifsc_code' => 'required|string|max:50',
            'branch_name' => 'nullable|string|max:150',
            'account_holder_name' => 'nullable|string|max:150',
            'upi_id' => 'nullable|string|max:100',
            'is_primary' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $isPrimary = $request->boolean('is_primary');

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

        return response()->json([
            'success' => true,
            'message' => 'Bank account updated successfully.',
            'bank_account' => [
                'id' => $bankDetail->id,
                'bank_name' => $bankDetail->bank_name,
                'account_no' => $bankDetail->account_no,
                'masked_account_no' => $bankDetail->masked_account_no,
                'ifsc_code' => $bankDetail->ifsc_code,
                'branch_name' => $bankDetail->branch_name,
                'account_holder_name' => $bankDetail->account_holder_name,
                'upi_id' => $bankDetail->upi_id,
                'is_primary' => (bool) $bankDetail->is_primary,
                'status' => $bankDetail->status,
            ],
        ]);
    }

    /**
     * Delete bank account
     */
    public function deleteBankDetail(Request $request, $id)
    {
        $partner = $request->user();

        $bankDetail = BankDetail::where('id', $id)
            ->where('dw_partner_id', $partner->id)
            ->first();

        if (!$bankDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Bank account not found.',
            ], 404);
        }

        $wasPrimary = $bankDetail->is_primary;
        $bankDetail->delete();

        if ($wasPrimary) {
            $next = BankDetail::where('dw_partner_id', $partner->id)->first();
            if ($next) {
                $next->update(['is_primary' => true]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Bank account deleted successfully.',
        ]);
    }

    /**
     * Set bank account as primary
     */
    public function setPrimaryBankDetail(Request $request, $id)
    {
        $partner = $request->user();

        $bankDetail = BankDetail::where('id', $id)
            ->where('dw_partner_id', $partner->id)
            ->first();

        if (!$bankDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Bank account not found.',
            ], 404);
        }

        DB::transaction(function () use ($partner, $bankDetail) {
            BankDetail::where('dw_partner_id', $partner->id)->update(['is_primary' => false]);
            $bankDetail->update(['is_primary' => true]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Primary bank account updated successfully.',
            'bank_account' => [
                'id' => $bankDetail->id,
                'bank_name' => $bankDetail->bank_name,
                'account_no' => $bankDetail->account_no,
                'masked_account_no' => $bankDetail->masked_account_no,
                'ifsc_code' => $bankDetail->ifsc_code,
                'is_primary' => true,
            ],
        ]);
    }
}
