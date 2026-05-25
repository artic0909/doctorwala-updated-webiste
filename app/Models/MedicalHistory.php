<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $table = 'medical_histories';

    protected $fillable = [
        'dw_user_id',
        'partner_id',
        'clinic_name',
        'opd_doctor_id',
        'doctor_name',
        'type',
        'date_of_report',
        'heading',
        'images',
    ];

    protected $casts = [
        'images'         => 'array',
        'date_of_report' => 'date:Y-m-d',
    ];

    /** Relationship back to the user */
    public function user()
    {
        return $this->belongsTo(\App\Models\DwUserModel::class, 'dw_user_id');
    }

    public function doctor()
    {
        return $this->belongsTo(PartnerAllOPDDoctorModel::class, 'opd_doctor_id');
    }

    public function opd()
    {
        return $this->belongsTo(DwPartnerModel::class, 'partner_id');
    }
}
