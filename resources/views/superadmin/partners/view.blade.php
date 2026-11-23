@extends('layouts.superadmin')

@section('title', 'Partner Details - ' . ($partner->partner_clinic_name ?: $partner->partner_contact_person_name) . ' | Super Admin')

@push('styles')
<style>
    .partner-detail-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .partner-detail-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .partner-detail-body {
        padding: 24px;
    }
    .info-label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
    }
    .login-direct-box {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: #ffffff;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Top Action Bar -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
            <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                <a href="{{ route('superadmin.super-all-partner.get') }}" class="btn btn-light border font-weight-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back to Partners
                </a>
                <h4 class="font-weight-bold text-dark mb-0">
                    {{ $partner->partner_clinic_name ?: $partner->partner_contact_person_name }}
                </h4>
                <span class="badge badge-light border text-monospace font-weight-bold" style="font-size: 0.9rem; color: #0284c7;">
                    #{{ $partner->partner_id ?? $partner->id }}
                </span>
                @if(strtolower($partner->status ?? '') == 'active')
                    <span class="badge badge-success px-2 py-1"><i class="fa-solid fa-circle-check mr-1"></i>Active</span>
                @else
                    <span class="badge badge-danger px-2 py-1"><i class="fa-solid fa-circle-xmark mr-1"></i>Inactive</span>
                @endif
            </div>
        </div>

        <div class="col-md-6 text-md-right d-flex justify-content-md-end align-items-center flex-wrap" style="gap: 10px;">
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', $partner->partner_mobile_number);
                if(strlen($cleanPhone) == 10) {
                    $cleanPhone = '91' . $cleanPhone;
                }
                $waUrl = "https://wa.me/" . $cleanPhone;
            @endphp
            <a href="{{ $waUrl }}" target="_blank" class="btn btn-outline-success font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp
            </a>

            <!-- Direct Login Button as Partner -->
            <a href="{{ route('superadmin.partner.login-direct', $partner->id) }}" target="_blank" class="btn btn-success font-weight-bold shadow-sm px-3 py-2" style="border-radius: 8px; font-size: 0.95rem;">
                <i class="fa-solid fa-right-to-bracket mr-2"></i> Login to Partner Panel
            </a>
        </div>
    </div>

    <!-- Quick Stat Overview -->
    <div class="row mb-4">
        <div class="col-6 col-md-4 col-xl-2 mb-2">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px;">
                <span class="info-label">Account Status</span>
                <div class="d-flex align-items-center mt-1">
                    <span class="badge {{ strtolower($partner->status ?? '') == 'active' ? 'badge-success' : 'badge-danger' }} px-2 py-1">
                        {{ ucfirst($partner->status ?? 'Active') }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-2">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px;">
                <span class="info-label">Registration Types</span>
                <div class="mt-1">
                    @if(is_array($partner->registration_type))
                        @foreach($partner->registration_type as $type)
                            <span class="badge badge-info px-2 py-1 mb-1">{{ $type }}</span>
                        @endforeach
                    @else
                        <span class="badge badge-secondary">N/A</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-2">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px;">
                <span class="info-label">Appointments</span>
                <div class="font-weight-bold text-primary mt-1" style="font-size: 1.15rem;">
                    <i class="fa-solid fa-calendar-check mr-1"></i> {{ $inquiriesCount ?? 0 }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-2">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px;">
                <span class="info-label">Total Earned</span>
                <div class="font-weight-bold text-dark mt-1" style="font-size: 1.15rem;">
                    ₹{{ number_format($totalEarned, 2) }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-2">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background: #ecfdf5; border-left: 4px solid #10b981 !important;">
                <span class="info-label" style="color: #065f46;">Total Settled</span>
                <div class="font-weight-bold mt-1" style="font-size: 1.15rem; color: #059669;">
                    <i class="fa-solid fa-circle-check mr-1"></i> ₹{{ number_format($effectiveSettled, 2) }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-2">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background: #fffbeb; border-left: 4px solid #f59e0b !important;">
                <span class="info-label" style="color: #92400e;">Pending Payout</span>
                <div class="font-weight-bold mt-1" style="font-size: 1.15rem; color: #d97706;">
                    <i class="fa-solid fa-clock mr-1"></i> ₹{{ number_format($pendingSettlement, 2) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row">
        <!-- Left: Account Details -->
        <div class="col-lg-8">
            <!-- Partner Details Card -->
            <div class="partner-detail-card">
                <div class="partner-detail-header">
                    <h5 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-id-card text-primary mr-2"></i> Partner Account Details
                    </h5>
                    <button type="button" data-toggle="modal" data-target="#editPartnerModal" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Info
                    </button>
                </div>
                <div class="partner-detail-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-label">Partner Code / ID</div>
                            <div class="info-value text-primary font-weight-bold">
                                #{{ $partner->partner_id ?? ('DWPTR' . $partner->id) }}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Mobile Number</div>
                            <div class="info-value">
                                <a href="tel:{{ $partner->partner_mobile_number }}" class="text-dark font-weight-bold">
                                    <i class="fa-solid fa-phone text-success mr-1"></i> {{ $partner->partner_mobile_number }}
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Facility / Clinic Name</div>
                            <div class="info-value">
                                <i class="fa-solid fa-hospital text-muted mr-1"></i> {{ $partner->partner_clinic_name ?: 'N/A' }}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Contact Person Name</div>
                            <div class="info-value">
                                <i class="fa-solid fa-user text-muted mr-1"></i> {{ $partner->partner_contact_person_name ?: 'N/A' }}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">
                                @if($partner->partner_email)
                                    <a href="mailto:{{ $partner->partner_email }}" class="text-dark">
                                        <i class="fa-solid fa-envelope text-primary mr-1"></i> {{ $partner->partner_email }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Executive Partner (EP)</div>
                            <div class="info-value">
                                @if($partner->ep)
                                    <span class="badge badge-light border text-dark font-weight-bold">
                                        <i class="fa-solid fa-user-tie text-info mr-1"></i> {{ $partner->ep->code }} - {{ $partner->ep->name }}
                                    </span>
                                @else
                                    <span class="text-muted">Direct (No EP)</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">City & State</div>
                            <div class="info-value">
                                {{ $partner->partner_city ?? 'N/A' }}, {{ $partner->partner_state ?? 'N/A' }} (PIN: {{ $partner->partner_pincode ?? 'N/A' }})
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Landmark</div>
                            <div class="info-value">
                                {{ $partner->partner_landmark ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-label">Full Address</div>
                            <div class="info-value">
                                <i class="fa-solid fa-location-dot text-danger mr-1"></i> {{ $partner->partner_address ?? 'N/A' }}
                            </div>
                        </div>

                        @if($partner->clinic_google_map_link)
                        <div class="col-12">
                            <div class="info-label">Google Maps Location</div>
                            <div class="info-value">
                                <a href="{{ $partner->clinic_google_map_link }}" target="_blank" class="btn btn-sm btn-outline-info" style="border-radius: 6px;">
                                    <i class="fa-solid fa-map-location-dot mr-1"></i> View on Google Maps
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Details for Associated Services -->
            @if($opd)
            <div class="partner-detail-card">
                <div class="partner-detail-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">
                            <i class="fa-solid fa-stethoscope text-info mr-2"></i> OPD Chamber Profile
                        </h5>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <span class="badge badge-info px-2 py-1">OPD Active</span>
                        @if($doctorsList->count() > 0)
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#partnerDoctorsModal" style="border-radius: 6px;">
                                <i class="fa-solid fa-user-doctor mr-1"></i> All Doctors Modal ({{ $doctorsList->count() }})
                            </button>
                        @endif
                    </div>
                </div>
                <div class="partner-detail-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <div class="info-label">Chamber / OPD Name</div>
                            <div class="info-value">{{ $opd->clinic_name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">OPD Mobile Number</div>
                            <div class="info-value">{{ $opd->clinic_mobile_number }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Doctors Listed</div>
                            <div class="info-value">
                                <span class="badge badge-primary">{{ $doctorsList->count() }} Doctors</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="badge badge-success">{{ $opd->status ?? 'Active' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Doctors Table Preview -->
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="font-weight-bold text-dark mb-0"><i class="fa-solid fa-stethoscope mr-1 text-primary"></i> Doctors in Chamber ({{ $doctorsList->count() }})</h6>
                        </div>
                        @if($doctorsList->count() > 0)
                        <div class="table-responsive" style="max-height: 280px;">
                            <table class="table table-sm table-hover border">
                                <thead class="thead-light">
                                    <tr style="font-size: 0.8rem;">
                                        <th>Doctor Name</th>
                                        <th>Specialist / Degree</th>
                                        <th>Fee (₹)</th>
                                        <th>Schedule / Days</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctorsList as $doc)
                                    <tr style="font-size: 0.88rem;">
                                        <td class="font-weight-bold text-dark">{{ $doc->doctor_name }}</td>
                                        <td>
                                            <span class="text-primary font-weight-bold">{{ $doc->doctor_specialist ?? 'Physician' }}</span>
                                            <small class="text-muted d-block">{{ $doc->doctor_designation }}</small>
                                        </td>
                                        <td class="font-weight-bold text-success">₹{{ $doc->doctor_fees ?? '0' }}</td>
                                        <td>
                                            @if(!empty($doc->visit_day_time) && is_array($doc->visit_day_time))
                                                @foreach(array_slice($doc->visit_day_time, 0, 2) as $s)
                                                    <span class="badge badge-light border mb-1">
                                                        {{ $s['doctor_visit_day'] ?? '' }}: {{ $s['doctor_visit_start_time'] ?? '' }}-{{ $s['doctor_visit_end_time'] ?? '' }}
                                                    </span><br>
                                                @endforeach
                                                @if(count($doc->visit_day_time) > 2)
                                                    <small class="text-primary font-weight-bold">+{{ count($doc->visit_day_time) - 2 }} more</small>
                                                @endif
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ strtolower($doc->status ?? '') == 'inactive' ? 'badge-secondary' : 'badge-success' }}">
                                                {{ $doc->status ?? 'Active' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <p class="text-muted small mb-0">No doctors listed under this chamber yet.</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if($pathology)
            <div class="partner-detail-card">
                <div class="partner-detail-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">
                            <i class="fa-solid fa-microscope text-warning mr-2"></i> Pathology Lab Profile
                        </h5>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <span class="badge badge-warning text-white px-2 py-1">Pathology Active</span>
                        @if($testsList->count() > 0)
                            <button type="button" class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#partnerTestsModal" style="border-radius: 6px;">
                                <i class="fa-solid fa-vial mr-1"></i> All Tests Modal ({{ $testsList->count() }})
                            </button>
                        @endif
                    </div>
                </div>
                <div class="partner-detail-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <div class="info-label">Lab Name</div>
                            <div class="info-value">{{ $pathology->clinic_name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Lab Mobile Number</div>
                            <div class="info-value">{{ $pathology->clinic_mobile_number }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Diagnostic Tests Listed</div>
                            <div class="info-value">
                                <span class="badge badge-warning text-white">{{ $testsList->count() }} Tests</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="badge badge-success">{{ $pathology->status ?? 'Active' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tests Table Preview -->
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="font-weight-bold text-dark mb-0"><i class="fa-solid fa-vials mr-1 text-warning"></i> Tests Catalog ({{ $testsList->count() }})</h6>
                        </div>
                        @if($testsList->count() > 0)
                        <div class="table-responsive" style="max-height: 280px;">
                            <table class="table table-sm table-hover border">
                                <thead class="thead-light">
                                    <tr style="font-size: 0.8rem;">
                                        <th>Test Name</th>
                                        <th>Category / Type</th>
                                        <th>Price (₹)</th>
                                        <th>Timings / Days</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($testsList as $t)
                                    <tr style="font-size: 0.88rem;">
                                        <td class="font-weight-bold text-dark">{{ $t->test_name }}</td>
                                        <td><span class="badge badge-light border">{{ $t->test_type ?? 'Diagnostic' }}</span></td>
                                        <td class="font-weight-bold text-success">₹{{ $t->test_price ?? '0' }}</td>
                                        <td>
                                            @if(!empty($t->test_day_time) && is_array($t->test_day_time))
                                                @foreach(array_slice($t->test_day_time, 0, 2) as $s)
                                                    <span class="badge badge-light border mb-1">
                                                        {{ $s['doctor_visit_day'] ?? '' }}: {{ $s['doctor_visit_start_time'] ?? '' }}-{{ $s['doctor_visit_end_time'] ?? '' }}
                                                    </span><br>
                                                @endforeach
                                                @if(count($t->test_day_time) > 2)
                                                    <small class="text-primary font-weight-bold">+{{ count($t->test_day_time) - 2 }} more</small>
                                                @endif
                                            @else
                                                <span class="text-muted">All Days</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ strtolower($t->status ?? '') == 'inactive' ? 'badge-secondary' : 'badge-success' }}">
                                                {{ $t->status ?? 'Active' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <p class="text-muted small mb-0">No pathology tests listed under this lab yet.</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if($doctor)
            <div class="partner-detail-card">
                <div class="partner-detail-header bg-light">
                    <h5 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-user-doctor text-primary mr-2"></i> Doctor Practitioner Profile
                    </h5>
                    <span class="badge badge-primary px-2 py-1">Doctor Active</span>
                </div>
                <div class="partner-detail-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-label">Doctor Name</div>
                            <div class="info-value font-weight-bold text-primary">{{ $doctor->partner_doctor_name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Specialist</div>
                            <div class="info-value">{{ $doctor->partner_doctor_specialist ?? 'General Physician' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Designation / Degree</div>
                            <div class="info-value">{{ $doctor->partner_doctor_designation ?? 'Doctor' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Consultation Fees</div>
                            <div class="info-value text-success font-weight-bold" style="font-size: 1.1rem;">₹ {{ $doctor->partner_doctor_fees ?? '500' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Partner Financials & Payout Settlements Section -->
            <div class="partner-detail-card">
                <div class="partner-detail-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-wallet text-success mr-2"></i> Financial Overview & Payout Settlements
                    </h5>
                    <a href="{{ route('superadmin.settlements.index', ['search' => $partner->partner_id ?? $partner->id]) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Settlements Page
                    </a>
                </div>
                <div class="partner-detail-body">
                    <!-- Metric Tiles -->
                    <div class="row mb-4">
                        <div class="col-6 col-md-3 mb-2">
                            <div class="p-3 rounded border" style="background: #f8fafc;">
                                <div class="text-uppercase small font-weight-bold text-muted">Total Earned</div>
                                <div class="h4 font-weight-bold text-dark mb-0 mt-1">₹{{ number_format($totalEarned, 2) }}</div>
                                <small class="text-muted">Completed inquiries</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="p-3 rounded border" style="background: #ecfdf5; border-color: #a7f3d0 !important;">
                                <div class="text-uppercase small font-weight-bold text-success">Total Settled</div>
                                <div class="h4 font-weight-bold text-success mb-0 mt-1">₹{{ number_format($effectiveSettled, 2) }}</div>
                                <small class="text-success"><i class="fa-solid fa-check mr-1"></i> Paid to Bank</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="p-3 rounded border" style="background: #fffbeb; border-color: #fde68a !important;">
                                <div class="text-uppercase small font-weight-bold text-warning" style="color: #d97706 !important;">Pending Payout</div>
                                <div class="h4 font-weight-bold mb-0 mt-1" style="color: #d97706;">₹{{ number_format($pendingSettlement, 2) }}</div>
                                <small class="text-muted"><i class="fa-solid fa-clock mr-1"></i> Awaiting transfer</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="p-3 rounded border" style="background: #eff6ff; border-color: #bfdbfe !important;">
                                <div class="text-uppercase small font-weight-bold text-primary">Wallet Balance</div>
                                <div class="h4 font-weight-bold text-primary mb-0 mt-1">₹{{ number_format($availableBalance, 2) }}</div>
                                <small class="text-muted">Available to settle</small>
                            </div>
                        </div>
                    </div>

                    <!-- Linked Bank Account Info -->
                    <div class="p-3 rounded border mb-4" style="background: #ffffff;">
                        <h6 class="font-weight-bold text-dark mb-2"><i class="fa-solid fa-landmark text-primary mr-1"></i> Registered Bank Account (For Payouts)</h6>
                        @if($primaryBank)
                        <div class="row" style="font-size: 0.9rem;">
                            <div class="col-sm-4 mb-1"><strong>Bank:</strong> {{ $primaryBank->bank_name }}</div>
                            <div class="col-sm-4 mb-1"><strong>Account No:</strong> {{ $primaryBank->account_no }}</div>
                            <div class="col-sm-4 mb-1"><strong>IFSC:</strong> {{ $primaryBank->ifsc_code }}</div>
                            <div class="col-sm-4 mb-1"><strong>Account Holder:</strong> {{ $primaryBank->account_holder_name ?: 'N/A' }}</div>
                            <div class="col-sm-4 mb-1"><strong>Branch:</strong> {{ $primaryBank->branch_name ?: 'N/A' }}</div>
                            <div class="col-sm-4 mb-1"><span class="badge badge-success px-2 py-1">Primary Payout Account</span></div>
                        </div>
                        @else
                        <div class="text-muted small">No primary bank account registered by this partner yet.</div>
                        @endif
                    </div>

                    <!-- Wallet & Settlement Transactions Table -->
                    <h6 class="font-weight-bold text-dark mb-2"><i class="fa-solid fa-receipt text-primary mr-1"></i> Settlement Transactions History ({{ $walletTransactions->count() }})</h6>
                    @if($walletTransactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover border">
                            <thead class="thead-light">
                                <tr style="font-size: 0.8rem;">
                                    <th>TX ID / Date</th>
                                    <th>Patient & Inquiry</th>
                                    <th>Fee Amount</th>
                                    <th>Status</th>
                                    <th>Settlement Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($walletTransactions as $tx)
                                <tr style="font-size: 0.88rem;">
                                    <td>
                                        <span class="font-weight-bold text-primary font-monospace">#TX-{{ str_pad($tx->id, 6, '0', STR_PAD_LEFT) }}</span>
                                        <small class="text-muted d-block">{{ $tx->created_at ? $tx->created_at->format('d M, Y h:i A') : '' }}</small>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-dark">{{ $tx->description ?: ($tx->inquiry->user_name ?? 'Consultation') }}</span>
                                        @if($tx->razorpay_payment_id)
                                            <small class="text-muted font-monospace d-block">{{ $tx->razorpay_payment_id }}</small>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold {{ $tx->transaction_type == 'credit' ? 'text-success' : 'text-danger' }}">
                                        {{ $tx->transaction_type == 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $tx->status == 'completed' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($tx->status) }}</span>
                                    </td>
                                    <td>
                                        @if($tx->settlement_status == 'settled')
                                            <span class="badge badge-success px-2 py-1"><i class="fa-solid fa-check-circle mr-1"></i>Settled</span>
                                            @if($tx->settled_at)
                                                <small class="text-muted d-block">{{ $tx->settled_at->format('d M, Y') }}</small>
                                            @endif
                                            @if($tx->settlement_notes)
                                                <small class="text-muted d-block text-truncate" style="max-width: 140px;">{{ $tx->settlement_notes }}</small>
                                            @endif
                                        @else
                                            <span class="badge badge-warning text-dark px-2 py-1"><i class="fa-solid fa-clock mr-1"></i>Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($tx->settlement_status != 'settled' && $tx->transaction_type == 'credit')
                                            <button type="button" class="btn btn-xs btn-success font-weight-bold btn-settle-action"
                                                data-id="{{ $tx->id }}"
                                                data-tx="#TX-{{ str_pad($tx->id, 6, '0', STR_PAD_LEFT) }}"
                                                data-amount="₹{{ number_format($tx->amount, 2) }}"
                                                style="border-radius: 4px; font-size: 0.78rem;">
                                                <i class="fa-solid fa-money-bill-transfer mr-1"></i> Settle
                                            </button>
                                        @else
                                            <span class="text-muted small"><i class="fa-solid fa-check text-success"></i> Done</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p class="text-muted small mb-0">No settlement transactions found for this partner.</p>
                    @endif
                </div>
            </div>

            <!-- Appointments & Consultations Section -->
            <div class="partner-detail-card">
                <div class="partner-detail-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">
                            <i class="fa-solid fa-calendar-check text-primary mr-2"></i> All Appointments & Consultations ({{ $appointments->count() }})
                        </h5>
                    </div>
                    @if($appointments->count() > 0)
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#partnerAppointmentsModal" style="border-radius: 6px;">
                            <i class="fa-solid fa-list mr-1"></i> View in Modal ({{ $appointments->count() }})
                        </button>
                    @endif
                </div>
                <div class="partner-detail-body">
                    @if($appointments->count() > 0)
                    <div class="table-responsive" style="max-height: 380px;">
                        <table class="table table-sm table-hover border">
                            <thead class="thead-light">
                                <tr style="font-size: 0.8rem;">
                                    <th>Token / Date</th>
                                    <th>Patient Details</th>
                                    <th>Doctor / Test Service</th>
                                    <th>Mode</th>
                                    <th>Fee</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appt)
                                <tr style="font-size: 0.88rem;">
                                    <td>
                                        <span class="font-weight-bold text-primary font-monospace">
                                            #{{ $appt->enquiry_serial ?: ('APT-' . $appt->id) }}
                                        </span>
                                        <small class="text-muted d-block">
                                            {{ $appt->booking_date ?? ($appt->created_at ? $appt->created_at->format('d M, Y') : 'N/A') }}
                                            @if($appt->booking_time) • {{ $appt->booking_time }} @endif
                                        </small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $appt->user_name ?: 'N/A' }}</div>
                                        <small class="text-muted"><i class="fa-solid fa-phone mr-1"></i> {{ $appt->user_mobile ?: 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-dark">{{ $appt->resolved_service_name ?? 'Consultation' }}</span>
                                        <small class="text-muted d-block">{{ ucfirst($appt->clinic_type ?? 'OPD') }}</small>
                                    </td>
                                    <td>
                                        @if(strtolower($appt->visit_mode ?? '') == 'online' || $appt->is_video)
                                            <span class="badge badge-info"><i class="fa-solid fa-video mr-1"></i> Online</span>
                                        @else
                                            <span class="badge badge-light border"><i class="fa-solid fa-hospital mr-1"></i> Clinic</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-success">₹{{ number_format($appt->payment_amount ?? 0, 2) }}</span>
                                        <small class="badge badge-light border d-block mt-1">{{ ucfirst($appt->payment_status ?? 'Paid') }}</small>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $st = strtolower($appt->status ?? '');
                                            $badgeClass = 'badge-primary';
                                            if($st == 'completed') $badgeClass = 'badge-success';
                                            elseif($st == 'cancelled') $badgeClass = 'badge-danger';
                                            elseif($st == 'confirmed') $badgeClass = 'badge-info';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} px-2 py-1">{{ ucfirst($appt->status ?? 'Upcoming') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p class="text-muted small mb-0">No patient appointments booked for this partner yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Actions & Direct Login -->
        <div class="col-lg-4">
            <!-- Direct Login Box -->
            <div class="login-direct-box">
                <h5 class="font-weight-bold mb-2">
                    <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Direct Admin Login
                </h5>
                <p class="mb-3 text-white-50" style="font-size: 0.88rem; line-height: 1.5;">
                    Sign in to this partner's dashboard directly from Super Admin without needing their password.
                </p>
                <a href="{{ route('superadmin.partner.login-direct', $partner->id) }}" target="_blank" class="btn btn-light btn-block font-weight-bold text-success shadow py-2" style="border-radius: 8px; font-size: 1rem;">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Login to Partner Panel
                </a>
            </div>

            <!-- Status Card -->
            <div class="partner-detail-card">
                <div class="partner-detail-header">
                    <h6 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-toggle-on text-primary mr-2"></i> Status Management
                    </h6>
                </div>
                <div class="partner-detail-body">
                    <p class="text-muted small mb-3">Set active or inactive state for this partner account:</p>
                    <form action="{{ route('superadmin.status.edit', $partner->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <select name="status" class="form-control" style="border-radius: 8px;">
                                <option value="Active" {{ strtolower($partner->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ strtolower($partner->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="border-radius: 8px;">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Follow-up Tracking -->
            <div class="partner-detail-card">
                <div class="partner-detail-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-phone-volume text-info mr-2"></i> Follow-up Logs
                    </h6>
                    <a href="{{ route('superadmin.followup.index', ['dw_partner_id' => $partner->id]) }}" class="btn btn-xs btn-outline-info" style="border-radius: 6px; font-size: 0.78rem;">
                        View All ({{ $partner->followups ? $partner->followups->count() : 0 }})
                    </a>
                </div>
                <div class="partner-detail-body p-3">
                    @if($partner->followups && $partner->followups->count() > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach($partner->followups->take(3) as $followup)
                                <li class="mb-2 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="font-weight-bold text-dark">{{ $followup->created_at ? $followup->created_at->format('d M, Y') : '' }}</small>
                                        <span class="badge badge-light border">{{ $followup->status ?? 'Logged' }}</span>
                                    </div>
                                    <small class="text-muted d-block mt-1">{{ Str::limit($followup->note ?? 'Follow-up call recorded', 60) }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted small mb-0">No follow-ups tracked yet.</p>
                    @endif
                    <a href="{{ route('superadmin.followup.index', ['dw_partner_id' => $partner->id]) }}" class="btn btn-light btn-sm btn-block mt-3 border font-weight-bold" style="border-radius: 8px;">
                        <i class="fa-solid fa-plus mr-1"></i> Add Follow-up
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Partner Modal -->
<div class="modal fade" id="editPartnerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 580px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-0 pb-0 pt-4 px-4 bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 42px; height: 42px; background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.05rem;">Edit Partner Profile</h5>
                        <small class="text-muted font-weight-500">{{ $partner->partner_clinic_name }}</small>
                    </div>
                </div>
                <button type="button" class="close text-muted p-2" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true" style="font-size: 1.4rem;">&times;</span>
                </button>
            </div>

            <form action="{{ route('superadmin.update.partner', $partner->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    <!-- Service Type Checkboxes -->
                    <div class="p-3 rounded mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <label class="font-weight-bold text-dark small mb-2 d-block">
                            <i class="fa-solid fa-sitemap text-primary mr-1"></i> Registration Type <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex align-items-center flex-wrap" style="gap: 16px;">
                            @php
                                $regTypes = is_array($partner->registration_type) ? $partner->registration_type : (json_decode($partner->registration_type, true) ?? []);
                            @endphp
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="view_opd" value="OPD" {{ in_array('OPD', $regTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="view_opd">OPD Chamber</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="view_path" value="Pathology" {{ in_array('Pathology', $regTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="view_path">Pathology Lab</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="view_doc" value="Doctor" {{ in_array('Doctor', $regTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="view_doc">Doctor</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa fa-hospital text-primary mr-1"></i> Clinic / Facility <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_clinic_name" value="{{ $partner->partner_clinic_name }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-user text-primary mr-1"></i> Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_contact_person_name" value="{{ $partner->partner_contact_person_name }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_mobile_number" value="{{ $partner->partner_mobile_number }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-envelope text-primary mr-1"></i> Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm" name="partner_email" value="{{ $partner->partner_email }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-globe text-primary mr-1"></i> State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_state" value="{{ $partner->partner_state }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-city text-primary mr-1"></i> City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_city" value="{{ $partner->partner_city }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-map-pin text-primary mr-1"></i> Landmark</label>
                            <input type="text" class="form-control form-control-sm" name="partner_landmark" value="{{ $partner->partner_landmark }}" style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-location-pin-lock text-primary mr-1"></i> Pin Code</label>
                            <input type="text" class="form-control form-control-sm" name="partner_pincode" value="{{ $partner->partner_pincode }}" style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-location-dot text-primary mr-1"></i> Full Address <span class="text-danger">*</span></label>
                            <textarea name="partner_address" class="form-control form-control-sm" rows="2" style="border-radius: 8px;">{{ $partner->partner_address }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 py-3 bg-light d-flex justify-content-end" style="gap: 10px;">
                    <button type="button" class="btn btn-light font-weight-bold px-3 py-2" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-check mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Partner All Doctors Modal -->
<div class="modal fade" id="partnerDoctorsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; background: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">All OPD Chamber Doctors ({{ count($doctorsList) }})</h5>
                        <small class="text-muted">{{ $partner->partner_clinic_name }}</small>
                    </div>
                </div>
                <button type="button" class="close p-2" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                @if(count($doctorsList) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="thead-light">
                            <tr style="font-size: 0.82rem;">
                                <th>#</th>
                                <th>Doctor Name</th>
                                <th>Specialist</th>
                                <th>Designation / Degree</th>
                                <th>Consultation Fee</th>
                                <th>Visiting Schedule</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctorsList as $idx => $doc)
                            <tr style="font-size: 0.9rem;">
                                <td>{{ $idx + 1 }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $doc->doctor_name }}</div>
                                    @if($doc->doctor_more)
                                        <small class="text-muted">{{ Str::limit($doc->doctor_more, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info px-2 py-1">{{ $doc->doctor_specialist ?: 'General' }}</span>
                                </td>
                                <td>{{ $doc->doctor_designation ?: 'N/A' }}</td>
                                <td class="font-weight-bold text-success">₹{{ number_format($doc->doctor_fees ?? 0, 2) }}</td>
                                <td>
                                    @if(is_array($doc->visit_day_time) && count($doc->visit_day_time) > 0)
                                        @foreach($doc->visit_day_time as $slot)
                                            <div class="small text-muted">
                                                <i class="fa-regular fa-clock text-primary mr-1"></i>
                                                <strong>{{ $slot['doctor_visit_day'] ?? 'Day' }}:</strong>
                                                {{ $slot['doctor_visit_start_time'] ?? '' }} - {{ $slot['doctor_visit_end_time'] ?? '' }}
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">Not specified</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ strtolower($doc->status ?? '') == 'active' ? 'badge-success' : 'badge-secondary' }} px-2 py-1">
                                        {{ ucfirst($doc->status ?? 'Active') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-user-doctor fa-3x mb-2 text-muted"></i>
                    <p class="mb-0">No OPD doctors added by this partner yet.</p>
                </div>
                @endif
            </div>
            <div class="modal-footer bg-light border-0 py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm font-weight-bold px-3" data-dismiss="modal" style="border-radius: 6px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Partner All Tests Modal -->
<div class="modal fade" id="partnerTestsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; background: #faf5ff; color: #9333ea;">
                        <i class="fa-solid fa-vial-virus"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">All Pathology Lab Tests ({{ count($testsList) }})</h5>
                        <small class="text-muted">{{ $partner->partner_clinic_name }}</small>
                    </div>
                </div>
                <button type="button" class="close p-2" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                @if(count($testsList) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="thead-light">
                            <tr style="font-size: 0.82rem;">
                                <th>#</th>
                                <th>Test Name</th>
                                <th>Category / Sample Type</th>
                                <th>Test Price</th>
                                <th>Timing / Schedule</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testsList as $idx => $test)
                            <tr style="font-size: 0.9rem;">
                                <td>{{ $idx + 1 }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $test->test_name }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-primary px-2 py-1">{{ $test->test_type ?: 'General' }}</span>
                                </td>
                                <td class="font-weight-bold text-success">₹{{ number_format($test->test_price ?? 0, 2) }}</td>
                                <td>
                                    @if(is_array($test->test_day_time) && count($test->test_day_time) > 0)
                                        @foreach($test->test_day_time as $slot)
                                            <div class="small text-muted">
                                                <i class="fa-regular fa-clock text-primary mr-1"></i>
                                                <strong>{{ $slot['doctor_visit_day'] ?? ($slot['test_day'] ?? 'Day') }}:</strong>
                                                {{ $slot['doctor_visit_start_time'] ?? ($slot['test_start_time'] ?? '') }} - {{ $slot['doctor_visit_end_time'] ?? ($slot['test_end_time'] ?? '') }}
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">Standard Hours</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ strtolower($test->status ?? '') == 'active' ? 'badge-success' : 'badge-secondary' }} px-2 py-1">
                                        {{ ucfirst($test->status ?? 'Active') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-vial-virus fa-3x mb-2 text-muted"></i>
                    <p class="mb-0">No pathology tests added by this partner yet.</p>
                </div>
                @endif
            </div>
            <div class="modal-footer bg-light border-0 py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm font-weight-bold px-3" data-dismiss="modal" style="border-radius: 6px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Partner All Appointments Modal -->
<div class="modal fade" id="partnerAppointmentsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">All Partner Appointments & Consultations ({{ $appointments->count() }})</h5>
                        <small class="text-muted">{{ $partner->partner_clinic_name }}</small>
                    </div>
                </div>
                <button type="button" class="close p-2" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                @if($appointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="thead-light">
                            <tr style="font-size: 0.82rem;">
                                <th>#</th>
                                <th>Token / ID</th>
                                <th>Date & Time</th>
                                <th>Patient Name & Mobile</th>
                                <th>Service / Doctor / Test</th>
                                <th>Type & Mode</th>
                                <th>Amount & Payment</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $idx => $appt)
                            <tr style="font-size: 0.88rem;">
                                <td>{{ $idx + 1 }}</td>
                                <td>
                                    <span class="font-weight-bold text-primary font-monospace">
                                        #{{ $appt->enquiry_serial ?: ('APT-' . $appt->id) }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $appt->booking_date ?? ($appt->created_at ? $appt->created_at->format('d M, Y') : 'N/A') }}</div>
                                    <small class="text-muted">{{ $appt->booking_time ?: '' }}</small>
                                </td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $appt->user_name ?: 'N/A' }}</div>
                                    <small class="text-muted"><i class="fa-solid fa-phone mr-1"></i> {{ $appt->user_mobile ?: 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="font-weight-bold text-dark">{{ $appt->resolved_service_name ?? 'Consultation' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-light border">{{ ucfirst($appt->clinic_type ?? 'OPD') }}</span>
                                    @if(strtolower($appt->visit_mode ?? '') == 'online' || $appt->is_video)
                                        <span class="badge badge-info ml-1"><i class="fa-solid fa-video mr-1"></i> Online</span>
                                    @else
                                        <span class="badge badge-secondary ml-1"><i class="fa-solid fa-hospital mr-1"></i> Clinic</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-weight-bold text-success">₹{{ number_format($appt->payment_amount ?? 0, 2) }}</div>
                                    <small class="badge badge-light border">{{ ucfirst($appt->payment_status ?? 'Paid') }}</small>
                                </td>
                                <td class="text-center">
                                    @php
                                        $st = strtolower($appt->status ?? '');
                                        $badgeClass = 'badge-primary';
                                        if($st == 'completed') $badgeClass = 'badge-success';
                                        elseif($st == 'cancelled') $badgeClass = 'badge-danger';
                                        elseif($st == 'confirmed') $badgeClass = 'badge-info';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-2 py-1">{{ ucfirst($appt->status ?? 'Upcoming') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-calendar-xmark fa-3x mb-2 text-muted"></i>
                    <p class="mb-0">No appointments recorded for this partner.</p>
                </div>
                @endif
            </div>
            <div class="modal-footer bg-light border-0 py-2 px-4">
                <button type="button" class="btn btn-secondary btn-sm font-weight-bold px-3" data-dismiss="modal" style="border-radius: 6px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Settle Payout Modal -->
<div class="modal fade" id="settlePayoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; border: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header border-0 pb-0 pt-4 px-4 bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 42px; height: 42px; background: #ecfdf5; color: #059669;">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark mb-0">Confirm Bank Settlement</h5>
                        <small class="text-muted" id="settleModalTxCode"></small>
                    </div>
                </div>
                <button type="button" class="close text-muted p-2" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="settlePayoutForm" method="POST" action="">
                @csrf
                <div class="modal-body px-4 py-3">
                    <!-- Summary Info Box -->
                    <div class="p-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Partner:</span>
                            <span class="font-weight-bold text-dark small">{{ $partner->partner_clinic_name ?: $partner->partner_contact_person_name }} ({{ $partner->partner_id ?? $partner->id }})</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Payable Amount:</span>
                            <span class="font-weight-bold text-success" id="settleModalAmount" style="font-size: 1.15rem;"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Bank Name:</span>
                            <span class="font-weight-medium text-dark small">{{ $primaryBank ? $primaryBank->bank_name : 'No Bank Added' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Account No:</span>
                            <span class="font-weight-bold font-monospace text-dark small">{{ $primaryBank ? $primaryBank->account_no : 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">IFSC Code:</span>
                            <span class="font-weight-bold font-monospace text-dark small">{{ $primaryBank ? $primaryBank->ifsc_code : 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark small mb-1">
                            <i class="fa-solid fa-hashtag text-primary mr-1"></i> Bank UTR / Reference No.
                        </label>
                        <input type="text" name="utr_number" class="form-control" placeholder="e.g. UTR1234567890 or NEFT/IMPS ref" style="border-radius: 8px;">
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark small mb-1">
                            <i class="fa-solid fa-notes-medical text-primary mr-1"></i> Settlement Notes / Remarks
                        </label>
                        <textarea name="settlement_notes" class="form-control" rows="2" placeholder="e.g. Transferred via SBI NetBanking" style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3 bg-light d-flex justify-content-end" style="gap: 10px;">
                    <button type="button" class="btn btn-light font-weight-bold px-3 py-2" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold px-4 py-2" style="border-radius: 8px;">
                        <i class="fa-solid fa-check mr-1"></i> Confirm & Mark Settled
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $(document).on('click', '.btn-settle-action', function() {
        var txId = $(this).data('id');
        var txCode = $(this).data('tx');
        var txAmount = $(this).data('amount');
        $('#settleModalTxCode').text(txCode);
        $('#settleModalAmount').text(txAmount);
        $('#settlePayoutForm').attr('action', '/superadmin/settlements/' + txId + '/settle');
        $('#settlePayoutModal').modal('show');
    });
});
</script>
@endpush
@endsection
