<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $table = 'medical_histories';

    protected $fillable = [
        'dw_user_id',
        'type',
        'date_of_report',
        'heading',
        'images',
    ];

    protected $casts = [
        'images'         => 'array',
        'date_of_report' => 'date',
    ];

    /** Relationship back to the user */
    public function user()
    {
        return $this->belongsTo(\App\Models\DwUserModel::class, 'dw_user_id');
    }
}
