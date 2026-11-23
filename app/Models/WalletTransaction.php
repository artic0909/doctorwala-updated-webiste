<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'wallet_id',
        'dw_partner_id',
        'dw_user_id',
        'transaction_type', // credit, debit
        'source',           // consultation, video_call, appointment, withdrawal, payout, refund, bonus, manual
        'amount',
        'opening_balance',
        'closing_balance',
        'reference_id',
        'description',
        'status',           // completed, pending, failed, cancelled
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function partner()
    {
        return $this->belongsTo(DwPartnerModel::class, 'dw_partner_id');
    }

    public function user()
    {
        return $this->belongsTo(DwUserModel::class, 'dw_user_id');
    }
}
