<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ep extends Model
{
    use HasFactory;

    protected $table = 'eps';

    protected $fillable = [
        'name',
        'code',
        'mobile',
        'status',
    ];

    /**
     * Get the GPs linked under this EP.
     */
    public function gps()
    {
        return $this->hasMany(Gp::class, 'ep_id');
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
}
