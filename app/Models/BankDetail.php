<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $table = 'bank_details';

    protected $fillable = [
        'dw_partner_id',
        'account_no',
        'ifsc_code',
        'bank_name',
        'branch_name',
        'account_holder_name',
        'upi_id',
        'is_primary',
        'status',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function partner()
    {
        return $this->belongsTo(DwPartnerModel::class, 'dw_partner_id');
    }

    public function getMaskedAccountNoAttribute()
    {
        $len = strlen($this->account_no);
        if ($len <= 4) {
            return $this->account_no;
        }
        return str_repeat('X', max(0, $len - 4)) . substr($this->account_no, -4);
    }
}
