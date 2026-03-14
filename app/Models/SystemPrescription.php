<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemPrescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'dw_user_id',
        'partner_id',
        'opd_doctor_id',
        'doctor_name',
        'prescription_date',
        'user_age',
        'user_gender',
        'blood_group',
        'bp',
        'pulse',
        'spo2',
        'temperature',
        'weight',
        'symptoms',
        'recommended_tests',
        'medicines',
        'medical_instructions',
        'diet_instructions',
        'next_visit_date',
        'repeat_tests_required',
        'emergency_note',
    ];

    protected $casts = [
        'symptoms' => 'array',
        'recommended_tests' => 'array',
        'medicines' => 'array',
        'repeat_tests_required' => 'boolean',
        'prescription_date' => 'date',
        'next_visit_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(DwUserModel::class, 'dw_user_id');
    }

    public function opd()
    {
        return $this->belongsTo(DwPartnerModel::class, 'partner_id', 'partner_id');
    }

    public function doctor()
    {
        return $this->belongsTo(PartnerAllOPDDoctorModel::class, 'opd_doctor_id');
    }
}
