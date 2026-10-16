<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\Model;

class DwUserModel extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'dw_user_models';

    protected $fillable = [
        'user_name',
        'user_mobile',
        'user_city',
        'user_email',
        'image',
        'user_password',
        'api_token',
        'dob',
        'memberid',
        'medical_card_no',
        'blood_group',
        'address',
        'gender',
        'height',
        'weight',
        'emergency_contact',
        'allergies',
        'chronic_conditions',
        'ep_id',
        'gp_id',
    ];

    protected $hidden = [
        'partner_password',
        'remember_token',
    ];

    // Specify custom attribute for password field
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function patientInquiries()
    {
        return $this->hasMany(PartnerPatientInquiry::class, 'dw_user_id');
    }

    public function gp()
    {
        return $this->belongsTo(Gp::class, 'gp_id');
    }

    public function ep()
    {
        return $this->belongsTo(Ep::class, 'ep_id');
    }

    public function gpReferrals()
    {
        return $this->hasMany(GpReferral::class, 'dw_user_id');
    }
}
