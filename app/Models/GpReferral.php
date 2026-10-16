<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpReferral extends Model
{
    use HasFactory;

    protected $table = 'gp_refferals';

    protected $fillable = [
        'dw_user_id',
        'gp_id',
        'ep_id',
        'gp_code',
    ];

    /**
     * The user who registered using this GP code.
     */
    public function user()
    {
        return $this->belongsTo(DwUserModel::class, 'dw_user_id');
    }

    /**
     * The GP associated with this referral.
     */
    public function gp()
    {
        return $this->belongsTo(Gp::class, 'gp_id');
    }

    /**
     * The EP associated with this referral.
     */
    public function ep()
    {
        return $this->belongsTo(Ep::class, 'ep_id');
    }
}
