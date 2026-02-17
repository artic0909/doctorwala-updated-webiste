<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'ip_address',
        'page_url',
        'referrer',
        'browser',
        'os',
        'device_type',
        'screen_size',
        'language',
        'timezone',
        'country',
        'city',
    ];
}