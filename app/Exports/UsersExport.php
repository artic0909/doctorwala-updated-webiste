<?php

namespace App\Exports;

use App\Models\DwUserModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = DwUserModel::query();

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('user_mobile', 'like', "%{$search}%")
                  ->orWhere('user_city', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['start_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['start_date']);
        }

        if (!empty($this->filters['end_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['end_date']);
        }

        return $query->orderBy('id', 'desc')
            ->select('user_name', 'user_mobile', 'user_email', 'user_city', 'created_at')
            ->get()
            ->map(function ($user) {
                return [
                    'user_name' => $user->user_name,
                    'user_mobile' => $user->user_mobile,
                    'user_email' => $user->user_email,
                    'user_city' => $user->user_city,
                    'registration_date' => $user->created_at ? $user->created_at->format('d-m-Y') : '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'User Name',
            'User Mobile',
            'User Email',
            'User City',
            'Registration Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1  => ['font' => ['bold' => true]], // Make the first row (header) bold
        ];
    }
}
