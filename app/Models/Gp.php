<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gp extends Model
{
    use HasFactory;

    protected $table = 'gps';

    protected $fillable = [
        'ep_id',
        'name',
        'code',
        'mobile',
        'status',
    ];

    /**
     * Get the parent EP that this GP is assigned to.
     */
    public function ep()
    {
        return $this->belongsTo(Ep::class, 'ep_id');
    }

    /**
     * Get the users registered under this GP.
     */
    public function users()
    {
        return $this->hasMany(DwUserModel::class, 'gp_id');
    }

    /**
     * Get the referrals logged under this GP.
     */
    public function referrals()
    {
        return $this->hasMany(GpReferral::class, 'gp_id');
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeStatus($query, $status)
    {
        if (!empty($status)) {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope for filtering by parent EP.
     */
    public function scopeEp($query, $epId)
    {
        if (!empty($epId)) {
            return $query->where('ep_id', $epId);
        }
        return $query;
    }
}
