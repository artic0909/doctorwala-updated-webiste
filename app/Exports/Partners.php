<?php

namespace App\Exports;

use App\Models\DwPartnerModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Partners implements FromQuery, WithHeadings, WithStyles
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = DwPartnerModel::query();

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('partner_clinic_name', 'like', "%{$search}%")
                    ->orWhere('partner_contact_person_name', 'like', "%{$search}%")
                    ->orWhere('partner_email', 'like', "%{$search}%")
                    ->orWhere('partner_mobile_number', 'like', "%{$search}%")
                    ->orWhere('partner_state', 'like', "%{$search}%")
                    ->orWhere('partner_city', 'like', "%{$search}%")
                    ->orWhere('partner_id', 'like', "%{$search}%")
                    ->orWhere('registration_type', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['date'])) {
            $query->whereDate('created_at', $this->filters['date']);
        }

        $sort = $this->filters['sort'] ?? 'newest';
        if ($sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->select('registration_type', 'partner_id', 'partner_clinic_name', 'partner_contact_person_name', 'partner_mobile_number', 'partner_email', 'partner_landmark', 'partner_pincode', 'partner_state', 'partner_city', 'partner_address', 'status');
    }

    public function headings(): array
    {
        return [
            'Type',
            'Partner ID',
            'Clinic Name',
            'Contact Person Name',
            'Mobile',
            'Email',
            'Landmark',
            'Pincode',
            'State',
            'City',
            'Address',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1  => ['font' => ['bold' => true]], // Make the first row (header) bold
        ];
    }
}
