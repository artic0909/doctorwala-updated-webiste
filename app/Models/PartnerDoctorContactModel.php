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



    public function partner()
    {
        return $this->belongsTo(DwPartnerModel::class, 'currently_loggedin_partner_id');
    }

    public function banner()
    {
        return $this->hasOne(PartnerDoctorBannerModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }
}
