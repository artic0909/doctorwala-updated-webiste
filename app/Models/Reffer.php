<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reffer extends Model
{
    protected $table = 'reffers';

    protected $fillable = [
        'name',
        'phone',
        'upi',
        'medical_card_number',
        'profile_screenshot',
        'referral_code',
        'ip_address',
        'reffred',
        'referred_by',
    ];

    /**
     * Get the user who referred this user.
     */
    public function referredBy()
    {
        return $this->belongsTo(Reffer::class, 'referred_by');
    }

    /**
     * Get the users referred by this user.
     */
    public function referees()
    {
        return $this->hasMany(Reffer::class, 'referred_by');
    }
}
