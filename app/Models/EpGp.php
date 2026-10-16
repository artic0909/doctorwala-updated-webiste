<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpGp extends Model
{
    use HasFactory;

    protected $table = 'ep_gps';

    protected $fillable = [
        'name',
        'code',
        'mobile',
        'role',
        'status',
    ];

    /**
     * Scope for filtering by role.
     */
    public function scopeRole($query, $role)
    {
        if (!empty($role)) {
            return $query->where('role', $role);
        }
        return $query;
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
