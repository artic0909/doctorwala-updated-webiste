<?php

namespace App\Exports;

use App\Models\PartnerDoctorContactModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OthersExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PartnerDoctorContactModel::where('clinic_registration_type', 'Others')
            ->select(
                'clinic_registration_type',
                'partner_doctor_name',
                'partner_doctor_specialist',
                'partner_doctor_designation',
                'partner_doctor_fees',
                'partner_doctor_mobile',
                'partner_doctor_email',
                'partner_doctor_landmark',
                'partner_doctor_pincode',
                'partner_doctor_state',
                'partner_doctor_city',
                'partner_doctor_google_map_link',
                'partner_doctor_address',
                'visit_day_time',
                'status'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Registration Type',
            'Provider / Specialist Name',
            'Specialization',
            'Designation',
            'Consultation Fees',
            'Mobile',
            'Email',
            'Landmark',
            'Pincode',
            'State',
            'City',
            'Google Maps Link',
            'Full Address',
            'Visiting Days/Time',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1  => ['font' => ['bold' => true]],
        ];
    }
}
