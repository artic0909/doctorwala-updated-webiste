<?php

namespace App\Exports;

use App\Models\Calling;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CallingsExport implements FromCollection, WithHeadings, WithStyles
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
        $query = Calling::query();

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('phone_number', 'like', "%{$search}%")
                  ->orWhere('provider_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('doctors_and_timings', 'like', "%{$search}%")
                  ->orWhere('tests_offered', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['provider_type'])) {
            $query->where('provider_type', 'like', "%{$this->filters['provider_type']}%");
        }

        if (!empty($this->filters['language'])) {
            $query->where('language', 'like', "%{$this->filters['language']}%");
        }

        if (!empty($this->filters['status'])) {
            $status = $this->filters['status'];
            if ($status === 'callback') {
                $query->where('callback_scheduled', true);
            } elseif ($status === 'dnd') {
                $query->where('is_dnd', true);
            } elseif ($status === 'link_sent') {
                $query->where('app_link_sent', true);
            } else {
                $query->where('call_status', $status);
            }
        }

        if (!empty($this->filters['from_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['from_date']);
        }

        if (!empty($this->filters['to_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['to_date']);
        }

        return $query->orderBy('id', 'desc')
            ->get()
            ->map(function ($call) {
                return [
                    'date' => $call->created_at ? $call->created_at->format('d-m-Y H:i:s') : '',
                    'phone_number' => $call->phone_number,
                    'provider_name' => $call->provider_name ?? 'N/A',
                    'provider_type' => $call->provider_type ?? 'N/A',
                    'location' => $call->location ?? 'N/A',
                    'doctors_and_timings' => $call->doctors_and_timings ?? 'N/A',
                    'consultation_modes' => $call->consultation_modes ?? 'N/A',
                    'doctor_fee_known' => $call->doctor_fee_known ?? 'N/A',
                    'tests_offered' => $call->tests_offered ?? 'N/A',
                    'rates_list_exists' => $call->rates_list_exists ?? 'N/A',
                    'language' => $call->language ?? 'N/A',
                    'duration' => $call->formatted_duration,
                    'app_link_sent' => $call->app_link_sent ? 'Yes' : 'No',
                    'callback_scheduled' => $call->callback_scheduled ? 'Yes' : 'No',
                    'callback_time' => $call->callback_time ?? '',
                    'callback_notes' => $call->callback_notes ?? '',
                    'is_dnd' => $call->is_dnd ? 'Yes' : 'No',
                    'call_status' => $call->call_status ?? 'completed',
                    'summary' => $call->summary ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Date & Time',
            'Phone Number',
            'Provider Name',
            'Provider Type',
            'Location',
            'Doctors & Timings',
            'Consultation Modes',
            'Doctor Fee Fixed',
            'Tests Offered',
            'Rates List Exists',
            'Language',
            'Call Duration',
            'App Link Sent',
            'Callback Scheduled',
            'Callback Time',
            'Callback Notes',
            'DND Marked',
            'Call Status',
            'AI Call Summary',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

