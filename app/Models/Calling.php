<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calling extends Model
{
    use HasFactory;

    protected $table = 'callings';

    protected $guarded = ['id'];

    protected $casts = [
        'callback_scheduled' => 'boolean',
        'is_dnd' => 'boolean',
        'app_link_sent' => 'boolean',
        'duration_seconds' => 'integer',
        'raw_payload' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Format duration seconds to human readable (e.g. 2m 15s)
     */
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration_seconds) {
            return '0s';
        }
        $minutes = floor($this->duration_seconds / 60);
        $seconds = $this->duration_seconds % 60;
        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }
        return "{$seconds}s";
    }

    /**
     * Clean phone number for tel: or wa.me links
     */
    public function getCleanPhoneAttribute(): string
    {
        $clean = preg_replace('/[^0-9]/', '', (string)$this->phone_number);
        return $clean ?? '';
    }
}

