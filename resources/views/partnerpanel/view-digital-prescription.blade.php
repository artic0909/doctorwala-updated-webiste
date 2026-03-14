<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription - {{ $patient->user_name }}</title>
    <link href="{{ asset('fav5.png') }}" rel="icon">
    <style>
        body {
            font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 40px 20px;
        }
        .prescription-container {
            max-width: 850px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-radius: 12px;
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
            gap: 20px;
        }
        .clinic-info h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 24px;
            line-height: 1.2;
        }
        .patient-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .meta-item {
            font-size: 14px;
        }
        .meta-label {
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            font-size: 11px;
            margin-bottom: 4px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 800;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
            padding-left: 12px;
            margin: 32px 0 16px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .vitals-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }
        .vital-chip {
            background: #eff6ff;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            border: 1px solid #dbeafe;
            color: #1e40af;
        }
        .medicine-table-wrapper {
            overflow-x: auto;
            margin: 0 -5px;
            padding: 0 5px;
        }
        .medicine-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            min-width: 500px;
        }
        .medicine-table th {
            text-align: left;
            background: #f8fafc;
            padding: 14px;
            font-size: 12px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }
        .medicine-table td {
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            vertical-align: top;
        }
        .footer {
            margin-top: 60px;
            padding-top: 24px;
            border-top: 2px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 30px;
        }
        .signature-box {
            text-align: center;
            min-width: 180px;
        }
        .signature-line {
            border-top: 1.5px solid #1e293b;
            margin-top: 40px;
            padding-top: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
        }

        /* Responsive Adjustments */
        @media screen and (max-width: 768px) {
            body { padding: 15px; }
            .prescription-container { padding: 25px; border-radius: 0; }
            .header { flex-direction: column; text-align: left !important; }
            .doc-meta { text-align: left !important; margin-top: 10px; border-top: 1px dashed #cbd5e1; padding-top: 15px; width: 100%; }
            .patient-meta { grid-template-columns: 1fr; gap: 15px; padding: 15px; }
            .instruction-grid { grid-template-columns: 1fr !important; gap: 20px !important; }
            .footer { flex-direction: column; align-items: flex-start; gap: 40px; }
            .signature-box { width: 100%; text-align: left; }
            .signature-line { width: fit-content; min-width: 150px; }
        }

        @media print {
            body { background: #fff; padding: 0; }
            .prescription-container { box-shadow: none; padding: 30px; max-width: 100%; }
            .no-print { display: none; }
            .download-btn { display: none; }
            .medicine-table { min-width: auto; }
        }

        .download-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            background: #2563eb;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            transition: all 0.2s;
        }
        .download-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
        }
        @media screen and (max-width: 768px) {
            .download-btn { 
                position: static; 
                display: block; 
                width: calc(100% - 40px); 
                margin: 0 auto 20px; 
                text-align: center;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <a href="javascript:void(0)" onclick="window.print()" class="download-btn no-print">Print / Save as PDF</a>

    <div class="prescription-container">
        <h4><span style="color: green;">Doctorwala</span>| Your Medical Ecosystem</h4>
        <div class="header">
            <div class="clinic-info">
                <h1>{{ $partner->partner_clinic_name }}</h1>
                <p style="margin: 5px 0; color: #64748b;">{{ $partner->partner_address }}</p>
                <p style="margin: 0; color: #64748b;">Contact: {{ $partner->partner_mobile_number }}</p>
            </div>
            <div class="doc-meta" style="text-align: right;">
                <p style="font-weight: 700; margin: 0; color: #1e3a8a;">Dr. {{ $prescription->doctor_name }}</p>
                <p style="margin: 5px 0; color: #64748b;">Date: {{ \Carbon\Carbon::parse($prescription->prescription_date)->format('d-M-Y') }}</p>
            </div>
        </div>

        <div class="patient-meta">
            <div class="meta-item">
                <div class="meta-label">Patient Name</div>
                <div style="font-weight: 600;">{{ $patient->user_name }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Prescription Heading</div>
                <div style="font-weight: 600;">{{ $prescription->heading ?? 'General Checkup' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Age / Gender</div>
                <div style="font-weight: 600;">
                    {{ $prescription->user_age ?? ($patient->dob ? \Carbon\Carbon::parse($patient->dob)->age . ' Yrs' : 'N/A') }} /
                    {{ $prescription->user_gender ?? ($patient->gender ?? 'N/A') }}
                </div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Contact</div>
                <div style="font-weight: 600;">{{ $patient->user_mobile }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">ID</div>
                <div style="font-weight: 600;">{{ $patient->medical_card_no }}</div>
            </div>
        </div>

        @if($prescription->blood_group || $prescription->bp || $prescription->temperature || $prescription->weight)
            <div class="section-title">Health Parameters</div>
            <div class="vitals-grid">
                @if($prescription->blood_group) <div class="vital-chip"><b>Blood Group:</b> {{ $prescription->blood_group }}</div> @endif
                @if($prescription->bp) <div class="vital-chip"><b>BP:</b> {{ $prescription->bp }} mmHg</div> @endif
                @if($prescription->temperature) <div class="vital-chip"><b>Temp:</b> {{ $prescription->temperature }} °C</div> @endif
                @if($prescription->weight) <div class="vital-chip"><b>Weight:</b> {{ $prescription->weight }} kg</div> @endif
                @if($prescription->spo2) <div class="vital-chip"><b>SpO2:</b> {{ $prescription->spo2 }} %</div> @endif
            </div>
        @endif

        @if(!empty($prescription->symptoms))
            <div class="section-title">Symptoms</div>
            <div style="list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach($prescription->symptoms as $symptom)
                    <span style="background: #f1f5f9; padding: 5px 12px; border-radius: 20px; font-size: 13px;">{{ $symptom }}</span>
                @endforeach
            </div>
        @endif

        @if(!empty($prescription->medicines))
            <div class="section-title">Medicines</div>
            <div class="medicine-table-wrapper">
                <table class="medicine-table">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Frequency (How Many Times a Day)</th>
                            <th>Time & Relation to Meals</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->medicines as $med)
                            <tr>
                                <td>
                                    <b>{{ $med['name'] }}</b><br>
                                    <small style="color: #64748b;">{{ $med['chemical'] ?? '' }}</small>
                                </td>
                                <td>
                                    {{ is_array($med['timing'] ?? null) ? implode(', ', $med['timing']) : ($med['timing'] ?? '-') }}
                                </td>
                                <td>
                                    {{ is_array($med['eating'] ?? null) ? implode(', ', $med['eating']) : ($med['eating'] ?? '-') }}
                                </td>
                                <td>{{ $med['days'] ?? '-' }} Days</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if(!empty($prescription->recommended_tests))
            <div class="section-title">Recommended Tests</div>
            <ul style="padding-left: 20px;">
                @foreach($prescription->recommended_tests as $test)
                    <li style="margin-bottom: 8px;">
                        <b>{{ $test['name'] }}</b> 
                        @if(!empty($test['priority'])) <span style="color: #ef4444; font-size: 11px;">({{ strtoupper($test['priority']) }})</span> @endif
                        <br><small style="color: #64748b;">{{ $test['notes'] ?? '' }}</small>
                    </li>
                @endforeach
            </ul>
        @endif

        @if($prescription->medical_instructions || $prescription->diet_instructions)
            <div class="instruction-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
                @if($prescription->medical_instructions)
                    <div>
                        <div class="section-title">Advice / Instructions</div>
                        <p style="font-size: 13px; line-height: 1.6; white-space: pre-line;">{{ $prescription->medical_instructions }}</p>
                    </div>
                @endif
                @if($prescription->diet_instructions)
                    <div>
                        <div class="section-title">Diet Plan</div>
                        <p style="font-size: 13px; line-height: 1.6; white-space: pre-line;">{{ $prescription->diet_instructions }}</p>
                    </div>
                @endif
            </div>
        @endif

        <div class="footer">
            <div class="next-visit">
                @if($prescription->next_visit_date)
                    <p style="margin: 0; font-size: 14px;"><b>Next Visit:</b> {{ \Carbon\Carbon::parse($prescription->next_visit_date)->format('d-M-Y') }}</p>
                @endif
            </div>
            <div class="signature-box">
                <div class="signature-line">Generated From Doctorwala</div>
            </div>
        </div>
    </div>

    <script>
        // Auto trigger print
        window.onload = function() {
            // setTimeout(() => window.print(), 1000);
        }
    </script>
</body>
</html>
