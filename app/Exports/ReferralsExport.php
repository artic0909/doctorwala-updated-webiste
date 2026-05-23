<?php

namespace App\Exports;

use App\Models\Reffer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReferralsExport implements FromCollection, WithHeadings, WithStyles
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Reffer::with('referredBy')->withCount('referees');

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('referral_code', 'like', "%{$search}%")
                  ->orWhere('upi', 'like', "%{$search}%")
                  ->orWhere('medical_card_number', 'like', "%{$search}%");
            });
        }

        $referrals = $query->orderBy('id', 'desc')->get();

        return $referrals->map(function ($ref) {
            return [
                'date_joined' => $ref->created_at ? $ref->created_at->format('d-m-Y') : '',
                'name' => $ref->name,
                'phone' => $ref->phone,
                'referral_code' => $ref->referral_code,
                'people_referred' => $ref->referees_count,
                'upi' => $ref->upi,
                'medical_card_number' => $ref->medical_card_number,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Date Joined',
            'Name',
            'Contact (Mobile)',
            'Referral Code',
            'People Referred',
            'UPI ID / Bank Payout',
            'Medical Card',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Bold the header row
        ];
    }
}
