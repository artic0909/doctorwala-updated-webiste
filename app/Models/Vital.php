<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    protected $table = 'vitals';

    protected $fillable = [
        'dw_user_id',
        'heart_rate',
        'blood_pressure',
        'temparature',
        'spo',
        'blood_sugar',
        'weight',
        'height',
        'bmi',
        'blood_group',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'dw_user_id');
    }
}
