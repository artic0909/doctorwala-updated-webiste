<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PartnerPathologyContactModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'currently_loggedin_partner_id',
        'clinic_registration_type',
        'clinic_contact_person_name',
        'clinic_name',
        'clinic_gstin',
        'clinic_mobile_number',
        'clinic_email',
        'clinic_landmark',
        'clinic_pincode',
        'clinic_state',
        'clinic_city',
        'clinic_google_map_link',
        'clinic_address',
        'status',
        'slug',
    ];


    // Auto-generate slug from clinic_name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->clinic_name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('clinic_name')) {
                $model->slug = static::generateUniqueSlug($model->clinic_name, $model->id);
            }
        });
    }

    public static function generateUniqueSlug($clinicName, $ignoreId = null)
    {
        $slug = Str::slug($clinicName);
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
        return $this->hasOne(PartnerPathologyBannerModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }


    public function tests()
    {
        return $this->hasMany(PartnerAllPathologyTestModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }
}
