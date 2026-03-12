<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription - {{ $patient->user_name }}</title>
    <style>
        body {
            font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 40px;
        }
        .prescription-container {
            max-width: 850px;
            margin: 0 auto;
            background: #fff;
            padding: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-radius: 8px;
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .clinic-info h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 24px;
        }
        .patient-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
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
            font-weight: 700;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
            padding-left: 10px;
            margin: 30px 0 15px;
            text-transform: uppercase;
        }
        .vitals-grid {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .vital-chip {
            background: #eff6ff;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
        }
        .medicine-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .medicine-table th {
            text-align: left;
            background: #f8fafc;
            padding: 12px;
            font-size: 12px;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
        }
        .medicine-table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 12px;
        }
        @media print {
            body { background: #fff; padding: 0; }
            .prescription-container { box-shadow: none; padding: 20px; max-width: 100%; }
            .no-print { display: none; }
        }
        .download-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2563eb;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>
<body>
    <a href="javascript:void(0)" onclick="window.print()" class="download-btn no-print">Print / Save as PDF</a>

    <div class="prescription-container">
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
                <div class="meta-label">Age / Gender</div>
                <div style="font-weight: 600;">{{ $patient->user_age ?? 'N/A' }} / {{ $patient->user_gender ?? 'N/A' }}</div>
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

        @if($prescription->bp || $prescription->temperature || $prescription->weight)
            <div class="section-title">Vitals</div>
            <div class="vitals-grid">
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
            <table class="medicine-table">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Dose</th>
                        <th>Timing</th>
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
                            <td>{{ $med['dose'] ?? '-' }}</td>
                            <td>
                                {{ is_array($med['timing'] ?? null) ? implode(', ', $med['timing']) : ($med['timing'] ?? '-') }}<br>
                                <small>({{ $med['eating'] ?? '' }})</small>
                            </td>
                            <td>{{ $med['days'] ?? '-' }} Days</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if(!empty($prescription->recommended_tests))
            <div class="section-title">Recommended Tests</div>
            <ul style="padding-left: 20px;">
                @foreach($prescription->recommended_tests as $test)
                    <li style="margin-bottom: 5px;">
                        <b>{{ $test['name'] }}</b> 
                        @if(!empty($test['priority'])) <span style="color: #ef4444; font-size: 11px;">({{ strtoupper($test['priority']) }})</span> @endif
                        <br><small style="color: #64748b;">{{ $test['notes'] ?? '' }}</small>
                    </li>
                @endforeach
            </ul>
        @endif

        @if($prescription->medical_instructions || $prescription->diet_instructions)
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
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
                <div class="signature-line">Doctor's Signature</div>
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
