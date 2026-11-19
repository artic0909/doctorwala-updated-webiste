@extends('layouts.partner')

@section('title', 'Partner Dashboard | Doctorwala Medical Ecosystem')

@push('styles')
<style>
    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
        height: 100%;
        text-decoration: none !important;
    }
    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(2, 132, 199, 0.12);
        border-color: #7dd3fc;
    }
    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: transparent;
        transition: all 0.25s ease;
    }
    .kpi-card:hover::before {
        background: #0284c7;
    }
    .kpi-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .kpi-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        letter-spacing: -0.5px;
        margin-top: 6px;
    }
    .kpi-label {
        font-size: 0.84rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .hub-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04);
        height: 100%;
    }
    .hub-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(2, 132, 199, 0.15);
        border-color: #7dd3fc;
    }
    .hub-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        flex-shrink: 0;
        font-size: 1.3rem;
    }
    .hub-content h6 {
        font-weight: 700;
        margin-bottom: 2px;
        color: #0f172a;
        font-size: 0.95rem;
    }
    .hub-content p {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 0;
    }
    .hub-counter-badge {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        margin-left: auto;
    }

    /* Activity Preview Cards & Empty States */
    .preview-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
        overflow: hidden !important;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .preview-card-header {
        background: #ffffff !important;
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 16px 20px !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .preview-card-body {
        padding: 0 !important;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background: #ffffff !important;
    }
    .empty-state-box {
        padding: 36px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-grow: 1;
        background: #ffffff;
    }
    .empty-state-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        margin-bottom: 12px;
    }

    /* Promotional Banner Upload Dropzone Box */
    .banner-upload-box {
        background: #ffffff;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 24px 18px;
        text-align: center;
        transition: all 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .banner-upload-box:hover {
        border-color: #0284c7;
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(2, 132, 199, 0.08);
    }
</style>
@endpush

@section('content')
<!-- Welcome Header Banner -->
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-8">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle shadow-xs" style="width: 56px; height: 56px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-user-doctor fa-2x"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">
                    Welcome back, {{ $partnerName ?? Auth::guard('partner')->user()->partner_contact_person_name ?? 'Partner' }}!
                </h3>
                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <span class="font-weight-bold text-primary" style="font-size: 0.95rem;">
                        <i class="fa-solid fa-hospital mr-1"></i> {{ $clinicName ?? Auth::guard('partner')->user()->partner_clinic_name ?? 'Medical Facility' }}
                    </span>
                    <span class="badge badge-light border text-dark font-weight-bold px-2 py-1" style="font-size: 0.78rem;">
                        {{ $partnerCode ?? '#DWPTR' . Auth::guard('partner')->id() }}
                    </span>
                    @if(!empty($registrationTypes))
                        @foreach($registrationTypes as $type)
                            <span class="badge badge-info px-2 py-1" style="font-size: 0.75rem;">
                                {{ $type }}
                            </span>
                        @endforeach
                    @endif
                    <span class="badge badge-success px-2 py-1" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-circle-check mr-1"></i>Active Partner
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 text-md-right mt-3 mt-md-0 d-flex justify-content-md-end align-items-center flex-wrap" style="gap: 10px;">
        <span class="badge badge-light border px-3 py-2 font-weight-bold shadow-xs" style="font-size: 0.85rem; border-radius: 8px; color: #0f172a;">
            <i class="fa-solid fa-calendar-check text-primary mr-1"></i> <span id="currentDate"></span>
        </span>
        <a href="/partnerpanel/partner-profile" class="btn btn-sm btn-outline-primary font-weight-bold shadow-xs" style="border-radius: 8px; padding: 7px 14px;">
            <i class="fa-solid fa-gear mr-1"></i> Settings
        </a>
    </div>
</div>

<!-- ==================== KPI STATS OVERVIEW ROW ==================== -->
<div class="row g-3 mb-4">
    <!-- Stat 1: OPD Doctors -->
    @if(in_array('OPD', $registrationTypes ?? []) || in_array('Doctor', $registrationTypes ?? []))
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <a href="/partnerpanel/partner-opd-show" class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="kpi-label">OPD Doctors</span>
                    <div class="kpi-value">{{ number_format($totalDoctors ?? 0) }}</div>
                </div>
                <div class="kpi-icon-wrap" style="background: #e0f2fe; color: #0284c7;">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
            </div>
            <div class="mt-3 d-flex align-items-center justify-content-between pt-2 border-top">
                <span class="badge badge-light text-success font-weight-bold" style="font-size: 0.76rem;">
                    <i class="fa-solid fa-circle-check mr-1"></i>{{ $availableDoctors ?? 0 }} Available
                </span>
                <span class="small font-weight-bold text-primary">Manage <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </div>
        </a>
    </div>
    @endif

    <!-- Stat 2: Pathology Tests -->
    @if(in_array('Pathology', $registrationTypes ?? []))
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <a href="/partnerpanel/partner-pathology-show" class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="kpi-label">Diagnostic Tests</span>
                    <div class="kpi-value">{{ number_format($totalTests ?? 0) }}</div>
                </div>
                <div class="kpi-icon-wrap" style="background: #fef3c7; color: #d97706;">
                    <i class="fa-solid fa-flask-vial"></i>
                </div>
            </div>
            <div class="mt-3 d-flex align-items-center justify-content-between pt-2 border-top">
                <span class="badge badge-light text-warning font-weight-bold" style="font-size: 0.76rem;">
                    <i class="fa-solid fa-vial mr-1"></i>{{ $availableTests ?? 0 }} Active
                </span>
                <span class="small font-weight-bold text-warning">Test Catalog <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </div>
        </a>
    </div>
    @endif

    <!-- Stat 3: Appointments / Bookings -->
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <a href="/partnerpanel/partner-inquiry-from-patients" class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="kpi-label">Appointments</span>
                    <div class="kpi-value">{{ number_format($totalInquiries ?? 0) }}</div>
                </div>
                <div class="kpi-icon-wrap" style="background: #fee2e2; color: #dc2626;">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
            <div class="mt-3 d-flex align-items-center justify-content-between pt-2 border-top">
                <span class="badge badge-light text-danger font-weight-bold" style="font-size: 0.76rem;">
                    <i class="fa-solid fa-bolt mr-1"></i>{{ $todayInquiries ?? 0 }} Today
                </span>
                <span class="small font-weight-bold text-danger">Appointments <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </div>
        </a>
    </div>

    <!-- Stat 4: Medical Health Records Access -->
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <a href="/partnerpanel/patient-profile-all-request" class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="kpi-label">Patient Records</span>
                    <div class="kpi-value">{{ number_format($totalRequests ?? 0) }}</div>
                </div>
                <div class="kpi-icon-wrap" style="background: #ede9fe; color: #7c3aed;">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
            </div>
            <div class="mt-3 d-flex align-items-center justify-content-between pt-2 border-top">
                <span class="badge badge-light text-info font-weight-bold" style="font-size: 0.76rem;">
                    <i class="fa-solid fa-check-double mr-1"></i>{{ $acceptedRequests ?? 0 }} Approved
                </span>
                <span class="small font-weight-bold text-info">
                    @if(($pendingRequests ?? 0) > 0)
                        <span class="badge badge-warning text-dark font-weight-bold mr-1">{{ $pendingRequests }} Pending</span>
                    @endif
                    Access <i class="fa-solid fa-arrow-right ml-1"></i>
                </span>
            </div>
        </a>
    </div>

    <!-- Stat 5: Patient Feedback & Rating -->
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <a href="/partnerpanel/partner-feedbacks" class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="kpi-label">Rating & Reviews</span>
                    <div class="kpi-value">
                        {{ number_format($avgRating ?? 5.0, 1) }}
                        <span style="font-size: 1.1rem; color: #f59e0b;"><i class="fa-solid fa-star"></i></span>
                    </div>
                </div>
                <div class="kpi-icon-wrap" style="background: #fef9c3; color: #ca8a04;">
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>
            </div>
            <div class="mt-3 d-flex align-items-center justify-content-between pt-2 border-top">
                <span class="badge badge-light text-secondary font-weight-bold" style="font-size: 0.76rem;">
                    <i class="fa-solid fa-comment-dots mr-1"></i>{{ $totalFeedbacks ?? 0 }} Patient Reviews
                </span>
                <span class="small font-weight-bold text-secondary">Feedback <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </div>
        </a>
    </div>

    <!-- Stat 6: Active Status -->
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <a href="/partnerpanel/partnerpanel/partner-profile" class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="kpi-label">Account Status</span>
                    <div class="font-weight-bold text-success mt-1" style="font-size: 1.15rem; line-height: 1.3;">
                        <i class="fa-solid fa-circle-check mr-1"></i> Active Partner
                    </div>
                </div>
                <div class="kpi-icon-wrap" style="background: #dcfce7; color: #16a34a;">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>
            <div class="mt-3 d-flex align-items-center justify-content-between pt-2 border-top">
                <span class="badge badge-light border text-success font-weight-bold" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-check-double mr-1"></i>Full Access
                </span>
                <span class="small font-weight-bold text-success">Profile <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </div>
        </a>
    </div>

    <!-- Stat 7: Support Tickets -->
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <a href="/partnerpanel/partner-show-ticket" class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="kpi-label">Support Tickets</span>
                    <div class="kpi-value">{{ number_format($totalTickets ?? 0) }}</div>
                </div>
                <div class="kpi-icon-wrap" style="background: #f3e8ff; color: #9333ea;">
                    <i class="fa-solid fa-headset"></i>
                </div>
            </div>
            <div class="mt-3 d-flex align-items-center justify-content-between pt-2 border-top">
                <span class="badge badge-light {{ ($pendingTickets ?? 0) > 0 ? 'text-warning' : 'text-success' }} font-weight-bold" style="font-size: 0.76rem;">
                    <i class="fa-solid fa-circle-info mr-1"></i>{{ $pendingTickets ?? 0 }} Pending Reply
                </span>
                <span class="small font-weight-bold text-purple" style="color: #9333ea;">Helpdesk <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </div>
        </a>
    </div>
</div>

<!-- ==================== MAIN ROW: TUTORIAL VIDEO & QUICK ACTIONS ==================== -->
<div class="row mb-4">
    <!-- Tutorial Video Card -->
    <div class="col-lg-5 mb-4 mb-lg-0">
        <div class="doc-card h-100">
            <div class="doc-card-header d-flex justify-content-between align-items-center">
                <h5 class="doc-card-title mb-0">
                    <i class="fa-solid fa-circle-play text-danger mr-2"></i>Partner Tutorial Guide
                </h5>
                <span class="badge badge-danger px-2 py-1 small">Video Guide</span>
            </div>
            <div class="doc-card-body p-0 d-flex flex-column" style="min-height: 290px;">
                <iframe class="w-100 h-100 border-0 flex-grow-1" 
                    src="https://www.youtube.com/embed/rtWdQz1Kmjk?si=lUWDuibF2wXeHp8s&autoplay=0&mute=0" 
                    title="YouTube video player" 
                    style="min-height: 290px; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Quick Management Hub Cards -->
    <div class="col-lg-7">
        <div class="row g-3">
            <!-- Profile Edit -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-profile" class="hub-card">
                    <div class="hub-icon-box" style="background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Profile Settings</h6>
                        <p>Facility details & contacts</p>
                    </div>
                    <span class="hub-counter-badge badge-light border text-primary">Edit</span>
                </a>
            </div>

            <!-- Support Tickets -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-get-ticket" class="hub-card">
                    <div class="hub-icon-box" style="background: #e0e7ff; color: #4338ca;">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Helpdesk & Support</h6>
                        <p>Open ticket or query</p>
                    </div>
                    <span class="hub-counter-badge badge-light border text-primary">Support</span>
                </a>
            </div>

            @if(in_array('OPD', $registrationTypes ?? []))
            <!-- OPD Chambers -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-opd-show" class="hub-card">
                    <div class="hub-icon-box" style="background: #ccfbf1; color: #0d9488;">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                    <div class="hub-content">
                        <h6>OPD Chambers</h6>
                        <p>Doctor timings & schedules</p>
                    </div>
                    <span class="hub-counter-badge badge-light border text-teal font-weight-bold" style="color: #0d9488;">{{ $totalDoctors ?? 0 }} Docs</span>
                </a>
            </div>
            @endif

            @if(in_array('Doctor', $registrationTypes ?? []))
            <!-- Doctor Details -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-doctors" class="hub-card">
                    <div class="hub-icon-box" style="background: #e0e7ff; color: #4338ca;">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Doctor Profile</h6>
                        <p>Consultations & timings</p>
                    </div>
                    <span class="hub-counter-badge badge-light border text-indigo font-weight-bold" style="color: #4338ca;">Profile</span>
                </a>
            </div>
            @endif

            @if(in_array('Pathology', $registrationTypes ?? []))
            <!-- Pathology -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-pathology-show" class="hub-card">
                    <div class="hub-icon-box" style="background: #fef3c7; color: #d97706;">
                        <i class="fa-solid fa-flask-vial"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Pathology Lab</h6>
                        <p>Tests, packages & rates</p>
                    </div>
                    <span class="hub-counter-badge badge-light border text-warning font-weight-bold">{{ $totalTests ?? 0 }} Tests</span>
                </a>
            </div>
            @endif

            <!-- Patient Appointments -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-inquiry-from-patients" class="hub-card">
                    <div class="hub-icon-box" style="background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Appointments</h6>
                        <p>Patient bookings & consults</p>
                    </div>
                    <span class="hub-counter-badge badge-light border text-danger font-weight-bold">{{ $totalInquiries ?? 0 }} Appts</span>
                </a>
            </div>

            <!-- Medical Records Request -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/patient-profile-all-request" class="hub-card">
                    <div class="hub-icon-box" style="background: #ede9fe; color: #7c3aed;">
                        <i class="fa-solid fa-file-medical"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Health Records</h6>
                        <p>Patient reports & history</p>
                    </div>
                    <span class="hub-counter-badge badge-light border font-weight-bold" style="color: #7c3aed;">{{ $totalRequests ?? 0 }} Records</span>
                </a>
            </div>

            <!-- Support Tickets -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-show-ticket" class="hub-card">
                    <div class="hub-icon-box" style="background: #f3e8ff; color: #9333ea;">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Help & Support</h6>
                        <p>Raise support tickets</p>
                    </div>
                    <span class="hub-counter-badge badge-light border font-weight-bold" style="color: #9333ea;">{{ $totalTickets ?? 0 }} Tickets</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ==================== RECENT ACTIVITY FEEDS ==================== -->
<div class="row mb-4">
    <!-- Recent Appointments Preview -->
    <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="preview-card">
            <div class="preview-card-header">
                <div class="d-flex align-items-center">
                    <div class="mr-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold mb-0 text-dark">Recent Appointments</h6>
                        <small class="text-muted">Direct bookings from patients</small>
                    </div>
                </div>
                <a href="/partnerpanel/partner-inquiry-from-patients" class="btn btn-sm btn-outline-danger font-weight-bold px-3" style="border-radius: 6px; font-size: 0.78rem;">
                    View All ({{ $totalInquiries ?? 0 }})
                </a>
            </div>
            <div class="preview-card-body">
                @if(isset($recentInquiries) && count($recentInquiries) > 0)
                <div class="table-responsive">
                    <table class="table doc-table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Contact</th>
                                <th>Reason / Note</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentInquiries as $inq)
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-dark" style="font-size: 0.88rem;">{{ $inq->user_name ?? 'Anonymous' }}</div>
                                    <span class="badge badge-light border text-primary" style="font-size: 0.7rem;">{{ $inq->clinic_type ?? 'OPD' }}</span>
                                </td>
                                <td>
                                    <a href="tel:{{ $inq->user_mobile }}" class="text-primary font-weight-bold small">
                                        <i class="fa-solid fa-phone mr-1"></i>{{ $inq->user_mobile ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>
                                    <div class="text-truncate text-muted small" style="max-width: 160px;" title="{{ $inq->user_inquiry }}">
                                        {{ $inq->user_inquiry ?? 'Consultation Appointment' }}
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted font-weight-bold">
                                        {{ $inq->created_at ? \Carbon\Carbon::parse($inq->created_at)->diffForHumans() : 'Recently' }}
                                    </small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state-box">
                    <div class="empty-state-icon" style="background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-1">No Appointments Yet</h6>
                    <p class="text-muted small mb-3" style="max-width: 320px;">When patients book consultations or clinic visits, they will show up here in real time.</p>
                    <a href="/partnerpanel/partner-inquiry-from-patients" class="btn btn-sm btn-outline-danger font-weight-bold px-3" style="border-radius: 8px;">
                        <i class="fa-solid fa-calendar-days mr-1"></i> Open Appointments Inbox
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Medical Access Requests -->
    <div class="col-lg-6">
        <div class="preview-card">
            <div class="preview-card-header">
                <div class="d-flex align-items-center">
                    <div class="mr-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: #ede9fe; color: #7c3aed;">
                        <i class="fa-solid fa-file-medical"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold mb-0 text-dark">Patient Health Records</h6>
                        <small class="text-muted">Access to digital medical records</small>
                    </div>
                </div>
                <a href="/partnerpanel/patient-profile-all-request" class="btn btn-sm btn-outline-primary font-weight-bold px-3" style="border-radius: 6px; font-size: 0.78rem;">
                    View All ({{ $totalRequests ?? 0 }})
                </a>
            </div>
            <div class="preview-card-body">
                @if(isset($recentRequests) && count($recentRequests) > 0)
                <div class="table-responsive">
                    <table class="table doc-table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Card No</th>
                                <th>Patient Name</th>
                                <th>Status</th>
                                <th>Requested</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRequests as $req)
                            <tr>
                                <td>
                                    <span class="badge badge-light border font-weight-bold text-dark px-2 py-1" style="font-size: 0.78rem;">
                                        {{ $req->dw_medical_id ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="font-weight-bold text-dark" style="font-size: 0.88rem;">
                                        {{ $req->patient->user_name ?? $req->partner_contact_person_name ?? 'Patient' }}
                                    </div>
                                    <small class="text-muted">{{ $req->patient->user_mobile ?? '' }}</small>
                                </td>
                                <td>
                                    @if($req->req_status == 'accepted')
                                        <span class="badge badge-success px-2 py-1 shadow-xs" style="font-size: 0.74rem;">
                                            <i class="fa-solid fa-circle-check mr-1"></i>Approved
                                        </span>
                                    @elseif($req->req_status == 'rejected')
                                        <span class="badge badge-danger px-2 py-1 shadow-xs" style="font-size: 0.74rem;">
                                            <i class="fa-solid fa-circle-xmark mr-1"></i>Rejected
                                        </span>
                                    @else
                                        <span class="badge badge-warning text-dark px-2 py-1 shadow-xs" style="font-size: 0.74rem;">
                                            <i class="fa-solid fa-clock mr-1"></i>Pending
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted font-weight-bold">
                                        {{ $req->created_at ? \Carbon\Carbon::parse($req->created_at)->diffForHumans() : 'Recently' }}
                                    </small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state-box">
                    <div class="empty-state-icon" style="background: #ede9fe; color: #7c3aed;">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-1">No Medical Records Requested</h6>
                    <p class="text-muted small mb-3" style="max-width: 320px;">Lookup patient medical cards to view prescriptions, lab reports and clinical vitals.</p>
                    <a href="/partnerpanel/partner-patient-profile-request" class="btn btn-sm btn-primary font-weight-bold px-3" style="border-radius: 8px;">
                        <i class="fa-solid fa-paper-plane mr-1"></i> Request Patient Access
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ==================== FACILITY BRANDING & PROMOTIONAL BANNERS ==================== -->
<div class="card mb-4 border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h6 class="font-weight-bold mb-0 text-dark" style="font-size: 1rem;">
                <i class="fa-solid fa-panorama text-primary mr-2"></i>Profile & Promotional Banners
            </h6>
            <small class="text-muted">Upload high-resolution promotional banners to showcase your facility to patients on the Doctorwala app</small>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            @if(in_array('OPD', $registrationTypes ?? []))
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="banner-upload-box">
                    @if($opdBanner && isset($opdBanner->opdbanner))
                        <div class="w-100 mb-3 rounded overflow-hidden shadow-xs" style="height: 150px;">
                            <img src="{{ asset('storage/' . $opdBanner->opdbanner) }}" alt="OPD Banner" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-stethoscope text-info mr-1"></i> OPD Chamber Banner</div>
                        <span class="badge badge-success px-2 py-1 small mb-3"><i class="fa-solid fa-circle-check mr-1"></i>Live on App</span>
                        <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold w-100" data-toggle="modal" data-target="#myOPDBanner" style="border-radius: 8px;">
                            <i class="fa-solid fa-pen mr-1"></i> Change Banner
                        </button>
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7; font-size: 1.25rem;">
                            <i class="fa-solid fa-stethoscope"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-1">OPD Chamber Banner</h6>
                        <p class="text-muted small mb-3">Upload clinic / chamber photo for doctor listings (1200x500)</p>
                        <button type="button" class="btn btn-sm btn-primary font-weight-bold px-3" data-toggle="modal" data-target="#myOPDBanner" style="border-radius: 8px;">
                            <i class="fa-solid fa-upload mr-1"></i> Upload OPD Banner
                        </button>
                    @endif
                </div>
            </div>
            @endif

            @if(in_array('Pathology', $registrationTypes ?? []))
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="banner-upload-box">
                    @if($pathologyBanner && isset($pathologyBanner->pathologybanner))
                        <div class="w-100 mb-3 rounded overflow-hidden shadow-xs" style="height: 150px;">
                            <img src="{{ asset('storage/' . $pathologyBanner->pathologybanner) }}" alt="Pathology Banner" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-flask-vial text-warning mr-1"></i> Pathology Lab Banner</div>
                        <span class="badge badge-success px-2 py-1 small mb-3"><i class="fa-solid fa-circle-check mr-1"></i>Live on App</span>
                        <button type="button" class="btn btn-sm btn-outline-warning font-weight-bold w-100" data-toggle="modal" data-target="#myPathologyBanner" style="border-radius: 8px;">
                            <i class="fa-solid fa-pen mr-1"></i> Change Banner
                        </button>
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 48px; height: 48px; background: #fef3c7; color: #d97706; font-size: 1.25rem;">
                            <i class="fa-solid fa-flask-vial"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-1">Pathology Lab Banner</h6>
                        <p class="text-muted small mb-3">Upload laboratory banner for diagnostic test listings (1200x500)</p>
                        <button type="button" class="btn btn-sm btn-warning text-white font-weight-bold px-3" data-toggle="modal" data-target="#myPathologyBanner" style="border-radius: 8px;">
                            <i class="fa-solid fa-upload mr-1"></i> Upload Lab Banner
                        </button>
                    @endif
                </div>
            </div>
            @endif

            @if(in_array('Doctor', $registrationTypes ?? []))
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="banner-upload-box">
                    @if($doctorBanner && isset($doctorBanner->doctorbanner))
                        <div class="w-100 mb-3 rounded overflow-hidden shadow-xs" style="height: 150px;">
                            <img src="{{ asset('storage/' . $doctorBanner->doctorbanner) }}" alt="Doctor Banner" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Doctor Profile Banner</div>
                        <span class="badge badge-success px-2 py-1 small mb-3"><i class="fa-solid fa-circle-check mr-1"></i>Live on App</span>
                        <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold w-100" data-toggle="modal" data-target="#myDoctorBanner" style="border-radius: 8px;">
                            <i class="fa-solid fa-pen mr-1"></i> Change Banner
                        </button>
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 48px; height: 48px; background: #e0e7ff; color: #4338ca; font-size: 1.25rem;">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-1">Doctor Profile Banner</h6>
                        <p class="text-muted small mb-3">Upload practitioner consulting profile header banner (1200x500)</p>
                        <button type="button" class="btn btn-sm btn-primary font-weight-bold px-3" data-toggle="modal" data-target="#myDoctorBanner" style="border-radius: 8px;">
                            <i class="fa-solid fa-upload mr-1"></i> Upload Doctor Banner
                        </button>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ==================== BANNER MODALS ==================== -->

<!-- OPD Banner Modal -->
<div class="modal fade" id="myOPDBanner" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-dark" style="font-size: 1.05rem;">
                    <i class="fa-solid fa-image text-primary mr-2"></i>Upload OPD Banner
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('partner.opd.banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold small text-dark">Select Banner Image</label>
                        <input class="form-control" type="file" name="opdbanner" required style="height: 44px; border-radius: 8px;">
                        <small class="text-muted">Recommended: 1200x500 JPG/PNG. Max size: 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-secondary font-weight-bold px-3" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4" style="border-radius: 8px;">Save OPD Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Pathology Banner Modal -->
<div class="modal fade" id="myPathologyBanner" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-dark" style="font-size: 1.05rem;">
                    <i class="fa-solid fa-image text-warning mr-2"></i>Upload Pathology Banner
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('partner.pathology.banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold small text-dark">Select Banner Image</label>
                        <input class="form-control" type="file" name="pathologybanner" required style="height: 44px; border-radius: 8px;">
                        <small class="text-muted">Recommended: 1200x500 JPG/PNG. Max size: 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-secondary font-weight-bold px-3" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4" style="border-radius: 8px;">Save Pathology Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Doctor Banner Modal -->
<div class="modal fade" id="myDoctorBanner" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-dark" style="font-size: 1.05rem;">
                    <i class="fa-solid fa-image text-primary mr-2"></i>Upload Doctor Banner
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('partner.doctor.banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold small text-dark">Select Banner Image</label>
                        <input class="form-control" type="file" name="doctorbanner" required style="height: 44px; border-radius: 8px;">
                        <small class="text-muted">Recommended: 1200x500 JPG/PNG. Max size: 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-secondary font-weight-bold px-3" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4" style="border-radius: 8px;">Save Doctor Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function updateCurrentDate() {
        const now = new Date();
        const options = {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        };
        const el = document.getElementById('currentDate');
        if (el) el.textContent = now.toLocaleDateString('en-GB', options);
    }
    document.addEventListener('DOMContentLoaded', updateCurrentDate);
</script>
@endpush
