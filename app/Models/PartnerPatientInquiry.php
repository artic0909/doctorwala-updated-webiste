<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerPatientInquiry extends Model
{
    use HasFactory;

    public $fillable = [
        'dw_user_id',
        'doctor_id',
        'test_id',
        'booking_date',
        'booking_time',
        'visit_mode',
        'currently_loggedin_partner_id',
        'clinic_type',
        'clinic_name',
        'user_name',
        'user_mobile',
        'user_email',
        'user_inquiry',
        'status',
        'enquiry_serial',
    ];

    protected static function booted()
    {
        static::creating(function ($inquiry) {
            if ($inquiry->currently_loggedin_partner_id) {
                $max = static::where('currently_loggedin_partner_id', $inquiry->currently_loggedin_partner_id)->max('enquiry_serial');
                $inquiry->enquiry_serial = $max ? ($max + 1) : 1;
            } else {
                $max = static::whereNull('currently_loggedin_partner_id')->max('enquiry_serial');
                $inquiry->enquiry_serial = $max ? ($max + 1) : 1;
            }
        });
    }

    public function opdContact()
    {
        return $this->belongsTo(PartnerOPDContactModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }

    public function pathologyContact()
    {
        return $this->belongsTo(PartnerPathologyContactModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }

    public function doctorContact()
    {
        return $this->belongsTo(PartnerDoctorContactModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }

    public function user()
    {
        return $this->belongsTo(DwUserModel::class, 'dw_user_id');
    }

    public function doctor()
    {
        return $this->belongsTo(
            PartnerAllOPDDoctorModel::class,
            'doctor_id'
        );
    }

    public function test()
    {
        return $this->belongsTo(PartnerAllPathologyTestModel::class, 'test_id');
    }
}
