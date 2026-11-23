<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';

    protected $fillable = [
        'dw_partner_id',
        'balance',
        'currency',
        'status',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function partner()
    {
        return $this->belongsTo(DwPartnerModel::class, 'dw_partner_id');
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id')->orderBy('created_at', 'desc');
    }

    /**
     * Credit the wallet balance safely
     */
    public function credit(
        float $amount,
        string $source,
        ?string $referenceId = null,
        ?string $description = null,
        string $settlementStatus = 'pending',
        ?int $inquiryId = null,
        ?string $razorpayPaymentId = null,
        ?string $razorpayOrderId = null
    ): WalletTransaction {
        $opening = $this->balance;
        $closing = $opening + $amount;
        $this->balance = $closing;
        $this->save();

        return $this->transactions()->create([
            'dw_partner_id' => $this->dw_partner_id,
            'transaction_type' => 'credit',
            'source' => $source,
            'amount' => $amount,
            'opening_balance' => $opening,
            'closing_balance' => $closing,
            'reference_id' => $referenceId,
            'description' => $description,
            'status' => 'completed',
            'settlement_status' => $settlementStatus,
            'inquiry_id' => $inquiryId,
            'razorpay_payment_id' => $razorpayPaymentId,
            'razorpay_order_id' => $razorpayOrderId,
        ]);
    }

    /**
     * Debit the wallet balance safely
     */
    public function debit(float $amount, string $source, ?string $referenceId = null, ?string $description = null): WalletTransaction
    {
        if ($this->balance < $amount) {
            throw new \Exception("Insufficient wallet balance.");
        }

        $opening = $this->balance;
        $closing = $opening - $amount;
        $this->balance = $closing;
        $this->save();

        return $this->transactions()->create([
            'dw_partner_id' => $this->dw_partner_id,
            'transaction_type' => 'debit',
            'source' => $source,
            'amount' => $amount,
            'opening_balance' => $opening,
            'closing_balance' => $closing,
            'reference_id' => $referenceId,
            'description' => $description,
            'status' => 'completed',
        ]);
    }
}
