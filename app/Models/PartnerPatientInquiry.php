<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerPatientInquiry extends Model
{
    use HasFactory;

    public $fillable = [
        'dw_user_id',
        'doctor_id',
        'test_id',
        'booking_date',
        'booking_time',
        'visit_mode',
        'is_video',
        'video_channel',
        'video_status',
        'currently_loggedin_partner_id',
        'clinic_type',
        'clinic_name',
        'user_name',
        'user_mobile',
        'user_email',
        'user_inquiry',
        'status',
        'enquiry_serial',
    ];

    protected $casts = [
        'is_video' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($inquiry) {
            if ($inquiry->currently_loggedin_partner_id) {
                $max = static::where('currently_loggedin_partner_id', $inquiry->currently_loggedin_partner_id)->max('enquiry_serial');
                $inquiry->enquiry_serial = $max ? ($max + 1) : 1;
            } else {
                $max = static::whereNull('currently_loggedin_partner_id')->max('enquiry_serial');
                $inquiry->enquiry_serial = $max ? ($max + 1) : 1;
            }

            // Automatically set is_video if visit_mode is online/video
            if (in_array(strtolower($inquiry->visit_mode ?? ''), ['online', 'video'])) {
                $inquiry->is_video = true;
            }
        });
    }

    /**
     * Generate a unique non-guessable Agora RTC channel name
     */
    public function ensureVideoChannel(): string
    {
        if (empty($this->video_channel)) {
            $this->video_channel = 'dw_vc_' . \Illuminate\Support\Str::random(24);
            $this->video_status = $this->video_status ?? 'scheduled';
            $this->is_video = true;
            $this->save();
        }
        return $this->video_channel;
    }

    /**
     * Check if appointment is within video call window:
     * 10 minutes before scheduled start time to 60 minutes after.
     */
    public function isWithinVideoWindow(): bool
    {
        if (empty($this->booking_date) || empty($this->booking_time)) {
            // If date/time not specified, allow if confirmed
            return true;
        }

        try {
            $bookingTimeClean = date('H:i:s', strtotime($this->booking_time));
            $scheduledAt = \Carbon\Carbon::parse($this->booking_date . ' ' . $bookingTimeClean);
            $now = \Carbon\Carbon::now();

            $windowStart = $scheduledAt->copy()->subMinutes(10);
            $windowEnd = $scheduledAt->copy()->addMinutes(60);

            return $now->between($windowStart, $windowEnd);
        } catch (\Exception $e) {
            return true;
        }
    }

    /**
     * Get start of video window
     */
    public function getVideoWindowStart(): ?\Carbon\Carbon
    {
        if (empty($this->booking_date) || empty($this->booking_time)) {
            return null;
        }
        try {
            $bookingTimeClean = date('H:i:s', strtotime($this->booking_time));
            return \Carbon\Carbon::parse($this->booking_date . ' ' . $bookingTimeClean)->subMinutes(10);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function opdContact()
    {
        return $this->belongsTo(PartnerOPDContactModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }

    public function pathologyContact()
    {
        return $this->belongsTo(PartnerPathologyContactModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }

    public function doctorContact()
    {
        return $this->belongsTo(PartnerDoctorContactModel::class, 'currently_loggedin_partner_id', 'currently_loggedin_partner_id');
    }

    public function user()
    {
        return $this->belongsTo(DwUserModel::class, 'dw_user_id');
    }

    public function doctor()
    {
        return $this->belongsTo(
            PartnerAllOPDDoctorModel::class,
            'doctor_id'
        );
    }

    public function test()
    {
        return $this->belongsTo(PartnerAllPathologyTestModel::class, 'test_id');
    }
}
