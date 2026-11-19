@extends('layouts.partner')

@section('title', 'Partner Dashboard | Doctorwala Medical Ecosystem')

@push('styles')
<style>
    .hub-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    .hub-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(2, 132, 199, 0.15);
        border-color: #7dd3fc;
    }
    .hub-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        flex-shrink: 0;
        font-size: 1.4rem;
    }
    .hub-content h6 {
        font-weight: 700;
        margin-bottom: 2px;
        color: #0f172a;
        font-size: 0.96rem;
    }
    .hub-content p {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 0;
    }
</style>
@endpush

@section('content')
<!-- Welcome Header Banner -->
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-8">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 52px; height: 52px; background: #e0f2fe; color: #0284c7;">
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
                    <span class="text-muted small">&bull; Partner Management Portal</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 text-md-right mt-3 mt-md-0">
        <span class="badge badge-light border px-3 py-2 font-weight-bold shadow-xs" style="font-size: 0.85rem; border-radius: 8px; color: #0f172a;">
            <i class="fa-solid fa-calendar-check text-primary mr-1"></i> <span id="currentDate"></span>
        </span>
    </div>
</div>

<!-- Main Row: Tutorial Video & Quick Action Hub -->
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
            <div class="doc-card-body p-0 d-flex flex-column" style="min-height: 280px;">
                <iframe class="w-100 h-100 border-0 flex-grow-1" 
                    src="https://www.youtube.com/embed/rtWdQz1Kmjk?si=lUWDuibF2wXeHp8s&autoplay=0&mute=0" 
                    title="YouTube video player" 
                    style="min-height: 280px; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;"
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
                </a>
            </div>

            <!-- Subscription -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-get-subscription" class="hub-card">
                    <div class="hub-icon-box" style="background: #dcfce7; color: #16a34a;">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Subscription Plan</h6>
                        <p>Validity & billing invoices</p>
                    </div>
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
                </a>
            </div>
            @endif

            <!-- Patient Inquiries -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-inquiry-from-patients" class="hub-card">
                    <div class="hub-icon-box" style="background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-comment-medical"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Patient Inquiries</h6>
                        <p>Direct patient leads & queries</p>
                    </div>
                </a>
            </div>

            <!-- Service Lists -->
            <div class="col-sm-6 mb-3">
                <a href="/partnerpanel/partner-service-lists" class="hub-card">
                    <div class="hub-icon-box" style="background: #f1f5f9; color: #475569;">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div class="hub-content">
                        <h6>Services Offered</h6>
                        <p>List medical facilities</p>
                    </div>
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
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Facility Branding & Promotional Banner Management -->
<div class="doc-card mb-4">
    <div class="doc-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="doc-card-title mb-0">
                <i class="fa-solid fa-panorama text-primary mr-2"></i>Profile & Promotional Banners
            </h5>
            <small class="text-muted">Upload high-resolution promotional banners to display to patients on the Doctorwala app</small>
        </div>
    </div>
    <div class="doc-card-body">
        <div class="row g-3">
            @if(in_array('OPD', $registrationTypes ?? []))
            <div class="col-md-4 mb-3">
                <div class="border rounded p-3 text-center" style="background: #f8fafc;">
                    <div class="font-weight-bold text-dark mb-2"><i class="fa-solid fa-stethoscope text-info mr-1"></i> OPD Chamber Banner</div>
                    <div class="mb-3 d-flex align-items-center justify-content-center bg-white border rounded overflow-hidden" style="height: 140px;">
                        @if($opdBanner && isset($opdBanner->opdbanner))
                            <img src="{{ asset('storage/' . $opdBanner->opdbanner) }}" alt="OPD Banner" class="img-fluid h-100 w-100" style="object-fit: cover;">
                        @else
                            <div class="text-muted small"><i class="fa-regular fa-image fa-2x mb-1 d-block opacity-50"></i>No Banner Uploaded</div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold w-100" data-toggle="modal" data-target="#myOPDBanner" style="border-radius: 6px;">
                        <i class="fa-solid fa-upload mr-1"></i> Update OPD Banner
                    </button>
                </div>
            </div>
            @endif

            @if(in_array('Pathology', $registrationTypes ?? []))
            <div class="col-md-4 mb-3">
                <div class="border rounded p-3 text-center" style="background: #f8fafc;">
                    <div class="font-weight-bold text-dark mb-2"><i class="fa-solid fa-flask-vial text-warning mr-1"></i> Pathology Lab Banner</div>
                    <div class="mb-3 d-flex align-items-center justify-content-center bg-white border rounded overflow-hidden" style="height: 140px;">
                        @if($pathologyBanner && isset($pathologyBanner->pathologybanner))
                            <img src="{{ asset('storage/' . $pathologyBanner->pathologybanner) }}" alt="Pathology Banner" class="img-fluid h-100 w-100" style="object-fit: cover;">
                        @else
                            <div class="text-muted small"><i class="fa-regular fa-image fa-2x mb-1 d-block opacity-50"></i>No Banner Uploaded</div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-warning font-weight-bold w-100" data-toggle="modal" data-target="#myPathologyBanner" style="border-radius: 6px;">
                        <i class="fa-solid fa-upload mr-1"></i> Update Pathology Banner
                    </button>
                </div>
            </div>
            @endif

            @if(in_array('Doctor', $registrationTypes ?? []))
            <div class="col-md-4 mb-3">
                <div class="border rounded p-3 text-center" style="background: #f8fafc;">
                    <div class="font-weight-bold text-dark mb-2"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Doctor Profile Banner</div>
                    <div class="mb-3 d-flex align-items-center justify-content-center bg-white border rounded overflow-hidden" style="height: 140px;">
                        @if($doctorBanner && isset($doctorBanner->doctorbanner))
                            <img src="{{ asset('storage/' . $doctorBanner->doctorbanner) }}" alt="Doctor Banner" class="img-fluid h-100 w-100" style="object-fit: cover;">
                        @else
                            <div class="text-muted small"><i class="fa-regular fa-image fa-2x mb-1 d-block opacity-50"></i>No Banner Uploaded</div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold w-100" data-toggle="modal" data-target="#myDoctorBanner" style="border-radius: 6px;">
                        <i class="fa-solid fa-upload mr-1"></i> Update Doctor Banner
                    </button>
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
