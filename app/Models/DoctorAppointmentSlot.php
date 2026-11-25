<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAppointmentSlot extends Model
{
    use HasFactory;

    protected $table = 'doctor_appointment_slots';

    protected $fillable = [
        'currently_loggedin_partner_id',
        'doctor_id',
        'clinic_type',
        'slot_date',
        'shift',
        'shift_name',
        'slot_number',
        'slot_name',
        'start_time',
        'end_time',
        'status',
        'dw_user_id',
        'patient_name',
        'patient_mobile',
        'patient_email',
        'inquiry_id',
        'payment_id',
    ];

    protected $casts = [
        'slot_date' => 'date',
        'slot_number' => 'integer',
    ];

    protected $appends = [
        'is_booked',
        'formatted_start_time',
        'formatted_end_time',
        'display_label',
    ];

    public function getIsBookedAttribute(): bool
    {
        return strtolower($this->status) === 'booked';
    }

    public function getFormattedStartTimeAttribute(): string
    {
        return $this->format12h($this->start_time);
    }

    public function getFormattedEndTimeAttribute(): string
    {
        return $this->format12h($this->end_time);
    }

    public function getDisplayLabelAttribute(): string
    {
        return "{$this->slot_name} ({$this->formatted_start_time} - {$this->formatted_end_time})";
    }

    public function inquiry()
    {
        return $this->belongsTo(PartnerPatientInquiry::class, 'inquiry_id');
    }

    public function user()
    {
        return $this->belongsTo(DwUserModel::class, 'dw_user_id');
    }

    public function partner()
    {
        return $this->belongsTo(DwPartnerModel::class, 'currently_loggedin_partner_id', 'id');
    }

    /**
     * Helper to format 24h HH:MM to 12h h:i A
     */
    public function format12h($timeStr): string
    {
        if (empty($timeStr)) return '';
        try {
            $parts = explode(':', trim($timeStr));
            $h = (int) ($parts[0] ?? 0);
            $m = str_pad($parts[1] ?? '00', 2, '0', STR_PAD_LEFT);
            $ampm = $h >= 12 ? 'PM' : 'AM';
            $h12 = $h % 12;
            if ($h12 === 0) $h12 = 12;
            return sprintf('%02d:%s %s', $h12, $m, $ampm);
        } catch (\Throwable $e) {
            return $timeStr;
        }
    }

    /**
     * Automatically generate 10-minute slots for a given doctor/partner on a specific date
     */
    public static function getOrGenerateSlots($partnerId, $doctorId = null, $date = null, $rawSchedule = null, $clinicType = 'Doctor')
    {
        if (empty($date)) {
            $date = Carbon::today()->format('Y-m-d');
        } else {
            $date = Carbon::parse($date)->format('Y-m-d');
        }

        $partner = DwPartnerModel::where('id', $partnerId)
            ->orWhere('partner_id', $partnerId)
            ->first();
        $partnerIds = array_values(array_unique(array_filter([
            (string) $partnerId,
            $partner?->id ? (string) $partner->id : null,
            $partner?->partner_id ? (string) $partner->partner_id : null,
        ])));
        $canonicalPartnerId = $partner ? (string) $partner->id : (string) $partnerId;
        $cleanDoctorId = (int) ($doctorId ?: 0);

        // 1. Check if slots already exist in the database for this date
        $existing = static::whereIn('currently_loggedin_partner_id', $partnerIds)
            ->where('doctor_id', $cleanDoctorId)
            ->whereDate('slot_date', $date)
            ->orderBy('start_time')
            ->get();

        if ($existing->isNotEmpty()) {
            return $existing;
        }

        // 2. Slots do not exist yet -> Automatic generation from doctor's schedule!
        if (empty($rawSchedule)) {
            // Try fetching from OPD doctor model or doctor contact model
            if ($cleanDoctorId > 0) {
                $opdDoc = PartnerAllOPDDoctorModel::find($cleanDoctorId);
                if ($opdDoc && !empty($opdDoc->visit_day_time)) {
                    $rawSchedule = $opdDoc->visit_day_time;
                }
            }
            if (empty($rawSchedule)) {
                $doc = PartnerDoctorContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->first();
                if ($doc) {
                    $rawSchedule = $doc->visit_day_time;
                }
            }
        }

        $normalized = PartnerDoctorContactModel::normalizeSchedule($rawSchedule);
        if (empty($normalized)) {
            // Fallback default shifts if no schedule configured: 10:00 to 13:00 Morning, 17:00 to 20:00 Evening
            $normalized = [
                [
                    'schedule_type' => 'day',
                    'day' => Carbon::parse($date)->format('l'),
                    'slots' => [
                        ['id' => 'morning', 'name' => 'Morning', 'start_time' => '10:00', 'end_time' => '13:00'],
                        ['id' => 'evening', 'name' => 'Evening', 'start_time' => '17:00', 'end_time' => '20:00'],
                    ]
                ]
            ];
        }

        $targetDateCarbon = Carbon::parse($date);
        $targetDayName = strtolower($targetDateCarbon->format('l'));

        // Find relevant schedule item for this date or day
        $matchedSlots = [];
        $dateMatched = false;
        foreach ($normalized as $item) {
            $sType = strtolower($item['schedule_type'] ?? $item['type'] ?? 'day');
            $iDate = $item['date'] ?? null;
            $iDay = strtolower(trim($item['day'] ?? ''));

            if ($sType === 'date' && !empty($iDate) && $iDate === $date) {
                $matchedSlots = array_merge($matchedSlots, $item['slots'] ?? []);
                $dateMatched = true;
            } elseif (!$dateMatched && ($sType === 'day' || empty($iDate))) {
                if ($iDay === 'all day' || $iDay === 'all days' || str_contains($iDay, $targetDayName) || str_contains($targetDayName, substr($iDay, 0, 3))) {
                    $matchedSlots = array_merge($matchedSlots, $item['slots'] ?? []);
                }
            }
        }

        if (empty($matchedSlots)) {
            // If still empty, check if any slot has start_time / end_time directly
            foreach ($normalized as $item) {
                if (!empty($item['slots'])) {
                    $matchedSlots = array_merge($matchedSlots, $item['slots']);
                    break;
                }
            }
        }

        // Fetch any existing bookings on this date to mark matching slots as booked
        $existingBookings = PartnerPatientInquiry::whereDate('booking_date', $date)
            ->where(function ($q) use ($partnerIds, $cleanDoctorId) {
                $q->whereIn('currently_loggedin_partner_id', $partnerIds);
                if ($cleanDoctorId > 0) {
                    $q->where('doctor_id', $cleanDoctorId);
                }
            })
            ->whereNotIn(\Illuminate\Support\Facades\DB::raw('LOWER(status)'), ['cancelled', 'rejected'])
            ->get();

        $bookedTimesMap = [];
        foreach ($existingBookings as $b) {
            $formattedTime = substr(trim($b->booking_time), 0, 5);
            if (!empty($formattedTime)) {
                $bookedTimesMap[$formattedTime] = $b;
            }
        }

        $createdSlots = [];

        foreach ($matchedSlots as $shift) {
            $shiftId = strtolower($shift['id'] ?? 'morning');
            $shiftName = $shift['name'] ?? ucfirst($shiftId);
            $start = $shift['start_time'] ?? $shift['start'] ?? null;
            $end = $shift['end_time'] ?? $shift['end'] ?? null;

            if (empty($start)) continue;

            $startParts = explode(':', $start);
            $startMin = (int) $startParts[0] * 60 + (int) ($startParts[1] ?? 0);

            if (!empty($end)) {
                $endParts = explode(':', $end);
                $endMin = (int) $endParts[0] * 60 + (int) ($endParts[1] ?? 0);
            } else {
                $endMin = $startMin + 60; // default 1 hour if no end time
            }

            if ($endMin <= $startMin) {
                $endMin = $startMin + 60;
            }

            $slotNum = 1;
            for ($m = $startMin; $m < $endMin; $m += 10) {
                $subStart = sprintf('%02d:%02d', floor($m / 60), $m % 60);
                $subEndMin = min($m + 10, $endMin);
                $subEnd = sprintf('%02d:%02d', floor($subEndMin / 60), $subEndMin % 60);

                $inquiry = $bookedTimesMap[$subStart] ?? null;
                $status = $inquiry ? 'booked' : 'available';

                $slotRecord = static::updateOrCreate(
                    [
                        'currently_loggedin_partner_id' => $canonicalPartnerId,
                        'doctor_id' => $cleanDoctorId,
                        'slot_date' => $date,
                        'shift' => $shiftId,
                        'slot_number' => $slotNum,
                    ],
                    [
                        'clinic_type' => $clinicType,
                        'shift_name' => $shiftName,
                        'slot_name' => "Slot {$slotNum}",
                        'start_time' => $subStart,
                        'end_time' => $subEnd,
                        'status' => $status,
                        'dw_user_id' => $inquiry?->dw_user_id,
                        'patient_name' => $inquiry?->user_name,
                        'patient_mobile' => $inquiry?->user_mobile,
                        'patient_email' => $inquiry?->user_email,
                        'inquiry_id' => $inquiry?->id,
                        'payment_id' => $inquiry?->razorpay_payment_id,
                    ]
                );

                $createdSlots[] = $slotRecord;
                $slotNum++;
            }
        }

        return static::whereIn('currently_loggedin_partner_id', $partnerIds)
            ->where('doctor_id', $cleanDoctorId)
            ->whereDate('slot_date', $date)
            ->orderBy('start_time')
            ->get();
    }
}
