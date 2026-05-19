<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    protected $table = 'followups';

    protected $fillable = [
        'dw_partner_id',
        'type',
        'remarks',
        'date'
    ];

    /**
     * Get the partner associated with the followup.
     */
    public function partner()
    {
        return $this->belongsTo(DwPartnerModel::class, 'dw_partner_id');
    }
}
