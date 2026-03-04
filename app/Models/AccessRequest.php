<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessRequest extends Model
{
    use HasFactory;

    protected $table = 'access_requests';

    protected $fillable = [
        // Patient
        'dw_user_id',

        // Doctor
        'doctor_id',

        // Partner snapshot
        'currently_loggedin_partner_id',
        'partner_clinic_name',
        'partner_contact_person_name',
        'partner_mobile_number',
        'partner_email',
        'partner_state',
        'partner_city',
        'partner_landmark',
        'partner_pincode',

        // Lookup fields
        'dw_medical_id',
        'dw_member_id',

        // Status
        'read_status',
        'req_status',
        'access_status',
    ];

    protected $attributes = [
        'read_status'   => 'unread',
        'req_status'    => 'pending',
        'access_status' => 'off',
    ];

    // ── Relationships ─────────────────────────────────────────

    /** The patient who received the request */
    public function patient()
    {
        return $this->belongsTo(DwUserModel::class, 'dw_user_id');
    }

    /** The doctor who made the request */
    public function doctor()
    {
        return $this->belongsTo(PartnerAllOPDDoctorModel::class, 'doctor_id');
    }

    // ── Helpers ───────────────────────────────────────────────

    public function isUnread(): bool
    {
        return $this->read_status   === 'unread';
    }
    public function isPending(): bool
    {
        return $this->req_status    === 'pending';
    }
    public function isAccepted(): bool
    {
        return $this->req_status    === 'accepted';
    }
    public function isRejected(): bool
    {
        return $this->req_status    === 'rejected';
    }
    public function hasAccess(): bool
    {
        return $this->access_status === 'on';
    }

    /** Mark as read */
    public function markRead(): void
    {
        $this->update(['read_status' => 'read']);
    }

    /** Accept request & grant access */
    public function accept(): void
    {
        $this->update([
            'req_status'    => 'accepted',
            'access_status' => 'on',
            'read_status'   => 'read',
        ]);
    }

    /** Reject request */
    public function reject(): void
    {
        $this->update([
            'req_status'    => 'rejected',
            'access_status' => 'off',
            'read_status'   => 'read',
        ]);
    }
}
