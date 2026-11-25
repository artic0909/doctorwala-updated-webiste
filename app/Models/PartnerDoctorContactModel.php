<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PartnerDoctorContactModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'currently_loggedin_partner_id',
        'clinic_registration_type',
        'partner_doctor_name',
        'partner_doctor_specialist',
        'partner_doctor_designation',
        'partner_doctor_fees',
        'partner_doctor_mobile',
        'partner_doctor_email',
        'partner_doctor_landmark',
        'partner_doctor_pincode',
        'partner_doctor_google_map_link',
        'partner_doctor_state',
        'partner_doctor_city',
        'partner_doctor_address',
        'visit_day_time',
        'status',
        'slug',         // added
    ];

    protected $casts = [
        'visit_day_time' => 'array', //it contain fields like partner_doctor_visit_day, partner_doctor_visit_start_time, partner_doctor_visit_end_time
    ];

    // Auto-generate slug from partner_doctor_name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->status)) {
                $model->status = 'Active';
            }
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->partner_doctor_name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('partner_doctor_name')) {
                $model->slug = static::generateUniqueSlug($model->partner_doctor_name, $model->id);
            }
        });
    }

    public static function generateUniqueSlug($doctorName, $ignoreId = null)
    {
        $slug = Str::slug($doctorName);
        $original = $slug;
        $count = 1;

        while (true) {
            $query = static::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Normalize any visit_day_time data into standardized day-wise & date-wise items
     * with morning, afternoon, and evening slots.
     */
    public static function normalizeSchedule($raw)
    {
        if (empty($raw)) return [];
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $raw = $decoded;
            }
        }
        if (!is_array($raw)) return [];

        $normalized = [];
        foreach ($raw as $item) {
            if (!is_array($item)) continue;

            $type = $item['type'] ?? (!empty($item['date']) ? 'date' : 'day');
            $day = $item['day'] ?? $item['partner_doctor_visit_day'] ?? null;
            $date = $item['date'] ?? null;

            if ($type === 'date' && !empty($date)) {
                try {
                    $day = \Carbon\Carbon::parse($date)->format('l');
                } catch (\Exception $e) {}
            }

            // Morning
            $morningEnabled = !empty($item['morning_enabled']);
            $morningStart = $item['morning_start'] ?? null;
            $morningEnd = $item['morning_end'] ?? null;

            // Afternoon
            $afternoonEnabled = !empty($item['afternoon_enabled']);
            $afternoonStart = $item['afternoon_start'] ?? null;
            $afternoonEnd = $item['afternoon_end'] ?? null;

            // Evening
            $eveningEnabled = !empty($item['evening_enabled']);
            $eveningStart = $item['evening_start'] ?? null;
            $eveningEnd = $item['evening_end'] ?? null;

            // Legacy backward-compat: if no slot flags are explicitly defined, but start_time/end_time exist
            $legacyStart = $item['start_time'] ?? $item['partner_doctor_visit_start_time'] ?? null;
            $legacyEnd = $item['end_time'] ?? $item['partner_doctor_visit_end_time'] ?? null;

            if (!$morningEnabled && !$afternoonEnabled && !$eveningEnabled && ($legacyStart || $legacyEnd)) {
                $startHour = $legacyStart ? (int)explode(':', $legacyStart)[0] : 10;
                if ($startHour < 12) {
                    $morningEnabled = true;
                    $morningStart = $legacyStart;
                    $morningEnd = $legacyEnd;
                } elseif ($startHour < 16) {
                    $afternoonEnabled = true;
                    $afternoonStart = $legacyStart;
                    $afternoonEnd = $legacyEnd;
                } else {
                    $eveningEnabled = true;
                    $eveningStart = $legacyStart;
                    $eveningEnd = $legacyEnd;
                }
            }

            // Find earliest start & latest end for legacy compatibility
            $allStarts = array_filter([$morningEnabled ? $morningStart : null, $afternoonEnabled ? $afternoonStart : null, $eveningEnabled ? $eveningStart : null]);
            $allEnds = array_filter([$morningEnabled ? $morningEnd : null, $afternoonEnabled ? $afternoonEnd : null, $eveningEnabled ? $eveningEnd : null]);
            sort($allStarts);
            rsort($allEnds);

            $primaryStart = !empty($allStarts) ? reset($allStarts) : $legacyStart;
            $primaryEnd = !empty($allEnds) ? reset($allEnds) : $legacyEnd;

            $slots = [];
            if ($morningEnabled && ($morningStart || $morningEnd)) {
                $slots[] = [
                    'id' => 'morning',
                    'name' => 'Morning',
                    'start_time' => $morningStart,
                    'end_time' => $morningEnd,
                ];
            }
            if ($afternoonEnabled && ($afternoonStart || $afternoonEnd)) {
                $slots[] = [
                    'id' => 'afternoon',
                    'name' => 'Afternoon',
                    'start_time' => $afternoonStart,
                    'end_time' => $afternoonEnd,
                ];
            }
            if ($eveningEnabled && ($eveningStart || $eveningEnd)) {
                $slots[] = [
                    'id' => 'evening',
                    'name' => 'Evening',
                    'start_time' => $eveningStart,
                    'end_time' => $eveningEnd,
                ];
            }

            $normalized[] = [
                'type' => $type,
                'schedule_type' => $type,
                'day' => $day ?? 'Monday',
                'date' => $date,
                'slots' => $slots,
                'morning_enabled' => (bool)$morningEnabled,
                'morning_start' => $morningStart,
                'morning_end' => $morningEnd,
                'afternoon_enabled' => (bool)$afternoonEnabled,
                'afternoon_start' => $afternoonStart,
                'afternoon_end' => $afternoonEnd,
                'evening_enabled' => (bool)$eveningEnabled,
                'evening_start' => $eveningStart,
                'evening_end' => $eveningEnd,
                'start_time' => $primaryStart,
                'end_time' => $primaryEnd,
            ];
        }

        return $normalized;
    }

    /**
     * Get normalized schedule attribute
     */
    public function getNormalizedScheduleAttribute()
    {
        return static::normalizeSchedule($this->visit_day_time);
    }



    public function partner()
    {
        return $this->belongsTo(DwPartnerModel::class, 'currently_loggedin_partner_id');
    }

    public function banner()
    {
        return $this->hasOne(PartnerDoctorBannerModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }
}
