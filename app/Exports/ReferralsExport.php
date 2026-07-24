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
    protected $duplicateRows = [];

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

        if (!empty($this->filters['from_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['from_date']);
        }

        if (!empty($this->filters['to_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['to_date']);
        }

        $referrals = $query->orderBy('id', 'desc')->get();

        // Identify duplicate IPs across all records to highlight them
        $duplicateIps = Reffer::select('ip_address')
            ->whereNotNull('ip_address')
            ->groupBy('ip_address')
            ->havingRaw('COUNT(id) > 1')
            ->pluck('ip_address')
            ->toArray();

        $rowNumber = 2; // Start from 2 because row 1 is headings
        return $referrals->map(function ($ref) use (&$rowNumber, $duplicateIps) {
            if (in_array($ref->ip_address, $duplicateIps)) {
                $this->duplicateRows[] = $rowNumber;
            }
            $rowNumber++;

            return [
                'date_joined' => $ref->created_at ? $ref->created_at->format('d-m-Y') : '',
                'name' => $ref->name,
                'phone' => $ref->phone,
                'referral_code' => $ref->referral_code,
                'people_referred' => $ref->referees_count,
                'upi' => $ref->upi,
                'medical_card_number' => $ref->medical_card_number,
                'ip_address' => $ref->ip_address,
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
            'IP Address',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            1 => ['font' => ['bold' => true]], // Bold the header row
        ];

        foreach ($this->duplicateRows as $row) {
            $styles[$row] = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFCCCC'], // Light red background
                ]
            ];
        }

        return $styles;
    }
}
