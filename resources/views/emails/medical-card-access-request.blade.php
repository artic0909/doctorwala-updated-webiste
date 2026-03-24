<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
        .container { max-width:600px; margin:30px auto; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg,#0077b6,#00b4d8); padding:24px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:20px; font-weight:800; }
        .header p  { color:#e0f7ff; margin:6px 0 0; font-size:13px; }
        .body { padding:30px; }
        .body p { color:#444; font-size:15px; line-height:1.6; }

        .section-label {
            font-size:11px; font-weight:800; text-transform:uppercase;
            letter-spacing:.08em; color:#0077b6; margin:20px 0 8px;
        }
        .info-box {
            background:#f0f6ff; border-left:4px solid #0077b6;
            border-radius:4px; padding:14px 18px; margin-bottom:14px;
        }
        .info-box p { margin:5px 0; font-size:13.5px; color:#333; }
        .info-box strong { color:#0077b6; min-width:140px; display:inline-block; }

        .doctor-box {
            background:#ecfdf5; border-left:4px solid #059669;
            border-radius:4px; padding:14px 18px; margin-bottom:14px;
        }
        .doctor-box p { margin:5px 0; font-size:13.5px; color:#333; }
        .doctor-box strong { color:#059669; min-width:140px; display:inline-block; }

        .btn {
            display:inline-block; margin-top:20px; padding:12px 28px;
            background:linear-gradient(135deg,#0077b6,#00b4d8);
            color:#fff; text-decoration:none; border-radius:6px; font-size:15px; font-weight:700;
        }
        .footer { background:#f4f4f4; text-align:center; padding:16px; font-size:12px; color:#999; }
        .badge-pending {
            display:inline-block; padding:3px 10px; border-radius:20px;
            background:#fffbeb; color:#b45309; border:1px solid #fde68a;
            font-size:12px; font-weight:700;
        }
    </style>
</head>
<body>
<div class="container">

    {{-- Header --}}
    <div class="header">
        <h1>🏥 Doctorwala</h1>
        <p>Medical Card Access Request Notification</p>
    </div>

    <div class="body">
        <p>Dear <strong>{{ $accessRequest->patient->user_name ?? 'Patient' }}</strong>,</p>
        <p>
            A healthcare partner has requested access to your <strong>Doctorwala Medical Card</strong>.
            Please review the details below and approve or reject the request from your account.
        </p>

        {{-- Doctor Details --}}
        <div class="section-label">🩺 Requesting Doctor</div>
        <div class="doctor-box">
            <p><strong>Doctor Name:</strong> {{ $accessRequest->doctor->doctor_name ?? 'N/A' }}</p>
            <p><strong>Specialization:</strong> {{ $accessRequest->doctor->doctor_specialist ?? $accessRequest->doctor->doctor_designation ?? 'N/A' }}</p>
        </div>

        {{-- Clinic / Partner Details --}}
        <div class="section-label">🏢 Clinic Details</div>
        <div class="info-box">
            <p><strong>Clinic Name:</strong> {{ $accessRequest->partner_clinic_name }}</p>
            <p><strong>Contact Person:</strong> {{ $accessRequest->partner_contact_person_name }}</p>
            <p><strong>Mobile:</strong> {{ $accessRequest->partner_mobile_number }}</p>
            <p><strong>Email:</strong> {{ $accessRequest->partner_email }}</p>
            <p><strong>Location:</strong>
                {{ $accessRequest->partner_landmark }},
                {{ $accessRequest->partner_city }},
                {{ $accessRequest->partner_state }} — {{ $accessRequest->partner_pincode }}
            </p>
        </div>

        {{-- Patient Card Details --}}
        <div class="section-label">🪪 Your Card Details</div>
        <div class="info-box">
            <p><strong>DW Medical ID:</strong> {{ $accessRequest->dw_medical_id }}</p>
            <p><strong>DW Member ID:</strong> {{ $accessRequest->dw_member_id }}</p>
            <p><strong>Request Status:</strong> <span class="badge-pending">⏳ Pending</span></p>
            <p><strong>Requested On:</strong> {{ \Carbon\Carbon::parse($accessRequest->created_at)->format('d M Y, h:i A') }}</p>
        </div>

        <p style="color:#64748b;font-size:13.5px">
            ⚠️ If you did not expect this request, you can safely ignore this email or contact
            <a href="https://doctorwala.info" style="color:#0077b6">Doctorwala Support</a>.
        </p>

        <a href="{{ url('/patient/access-requests') }}" class="btn">View &amp; Respond to Request</a>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Doctorwala. All rights reserved.<br>
        This is an automated email. Please do not reply directly.
    </div>

</div>
</body>
</html>