@extends('layouts.partner')

@section('title', 'Requested Patient Profiles | Doctorwala')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-7 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-hospital-user fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Patient Health Records & Access</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Securely view authorized patient medical history, vital signs and digital prescriptions</p>
            </div>
        </div>
    </div>
    <div class="col-md-5 text-md-right">
        <a href="/partnerpanel/partner-patient-profile-request" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-paper-plane mr-2"></i>Send New Access Request
        </a>
    </div>
</div>

<!-- Summary KPI Grid -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3 mb-2">
        <div class="doc-stat-card">
            <div class="doc-stat-label">Total Requests</div>
            <div class="doc-stat-val text-primary">{{ $allRequestsCount->count() ?? $requests->total() }}</div>
            <small class="text-muted">Access Attempts</small>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-2">
        <div class="doc-stat-card">
            <div class="doc-stat-label">Pending Approval</div>
            <div class="doc-stat-val text-warning">{{ $pendingCount ?? 0 }}</div>
            <small class="text-muted">Awaiting Patient Consent</small>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-2">
        <div class="doc-stat-card">
            <div class="doc-stat-label">Authorized Access</div>
            <div class="doc-stat-val text-success">{{ $acceptedCount ?? 0 }}</div>
            <small class="text-muted">Active Health Records</small>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-2">
        <div class="doc-stat-card">
            <div class="doc-stat-label">Declined</div>
            <div class="doc-stat-val text-danger">{{ $rejectedCount ?? 0 }}</div>
            <small class="text-muted">Consent Rejected</small>
        </div>
    </div>
</div>

<!-- Search & Date Filter Bar -->
<div class="card border-0 shadow-sm mb-4 filter-card" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('partner.patient.profile.all.request') }}" class="row g-2 align-items-end">
            <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-search mr-1"></i> Search</label>
                <input type="text" name="search" class="form-control" placeholder="Patient name, mobile, card ID..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-toggle-on mr-1"></i> Status</label>
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-calendar-alt mr-1"></i> From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-calendar-alt mr-1"></i> To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-3 col-sm-12 d-flex">
                <button type="submit" class="btn btn-primary font-weight-bold flex-grow-1 mr-2" style="height: 42px; border-radius: 8px;">
                    <i class="fa fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('partner.patient.profile.all.request') }}" class="btn btn-light font-weight-bold" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1;" title="Reset filters">
                    <i class="fa fa-redo text-muted"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Patient Access Table Card -->
<div class="doc-card">
    <div class="doc-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="doc-card-title mb-0">Authorized Patient Profile Requests</h5>
            <small class="text-muted">Records with accepted consent reveal unmasked phone, email and medical IDs</small>
        </div>
        <span class="badge badge-secondary">{{ $requests->total() }}</span>
    </div>

    <div class="table-responsive">
        <table class="table doc-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">SL</th>
                    <th>Patient</th>
                    <th>Assigned Doctor</th>
                    <th>Medical Card</th>
                    <th>Request Status</th>
                    <th>Access</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $i => $req)
                @php
                    $accepted = $req->req_status === 'accepted';
                    $patient = $req->patient;

                    $rawName = $patient->user_name ?? '—';
                    $rawEmail = $patient->user_email ?? '—';
                    $rawMobile = $patient->user_mobile ?? '—';
                    $rawCard = $req->dw_medical_id ?? '—';

                    if (!$accepted) {
                        $dispName = implode(' ', array_map(function($w) {
                            return strlen($w) <= 2 ? $w : substr($w,0,3).str_repeat('*', max(2, strlen($w)-3));
                        }, explode(' ', $rawName)));

                        $eParts = explode('@', $rawEmail);
                        $dispEmail = count($eParts) === 2
                            ? substr($eParts[0],0,2).str_repeat('*', max(3, strlen($eParts[0])-2)).'@'.$eParts[1]
                            : $rawEmail;

                        $m = preg_replace('/\s+/','',$rawMobile);
                        $dispMobile = strlen($m) > 6
                            ? substr($m,0,3).str_repeat('*', max(4, strlen($m)-6)).substr($m,-3)
                            : $rawMobile;

                        $dispCard = substr($rawCard,0,4).' **** '.substr($rawCard,-2);
                    } else {
                        $dispName = $rawName;
                        $dispEmail = $rawEmail;
                        $dispMobile = $rawMobile;
                        $dispCard = $rawCard;
                    }
                @endphp
                <tr>
                    <td class="font-weight-bold text-muted" style="font-size: 0.85rem;">
                        {{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <div class="mr-2 d-flex align-items-center justify-content-center rounded-circle font-weight-bold text-white" style="width: 36px; height: 36px; background: {{ $accepted ? 'linear-gradient(135deg, #0284c7, #0d9488)' : '#94a3b8' }}; font-size: 0.85rem;">
                                {{ strtoupper(substr($rawName, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-weight-bold text-dark" style="font-size: 0.92rem;">
                                    {{ $dispName }}
                                </div>
                                <small class="text-muted d-block"><i class="fa-solid fa-phone mr-1"></i>{{ $dispMobile }}</small>
                                <small class="text-muted d-block"><i class="fa-solid fa-envelope mr-1"></i>{{ $dispEmail }}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        @if($req->doctor)
                            <div class="font-weight-bold text-dark" style="font-size: 0.88rem;">
                                <i class="fa-solid fa-user-doctor text-primary mr-1"></i>{{ $req->doctor->doctor_name }}
                            </div>
                            <small class="text-muted">{{ $req->doctor->doctor_specialist ?? $req->doctor->doctor_designation ?? '—' }}</small>
                        @else
                            <span class="text-muted small">General Facility</span>
                        @endif
                    </td>

                    <td>
                        <span class="badge badge-light border text-monospace font-weight-bold" style="font-size: 0.82rem; color: {{ $accepted ? '#0284c7' : '#64748b' }};">
                            <i class="fa-solid fa-id-card mr-1"></i>{{ $dispCard }}
                        </span>
                    </td>

                    <td>
                        @if($req->req_status === 'pending')
                            <span class="badge badge-warning px-2 py-1 text-white shadow-xs" style="font-size: 0.78rem;">
                                <i class="fa-solid fa-clock-rotate-left mr-1"></i>Pending
                            </span>
                        @elseif($req->req_status === 'accepted')
                            <span class="badge badge-success px-2 py-1 shadow-xs" style="font-size: 0.78rem;">
                                <i class="fa-solid fa-circle-check mr-1"></i>Accepted
                            </span>
                        @else
                            <span class="badge badge-danger px-2 py-1 shadow-xs" style="font-size: 0.78rem;">
                                <i class="fa-solid fa-circle-xmark mr-1"></i>Rejected
                            </span>
                        @endif
                    </td>

                    <td>
                        @if($req->access_status === 'on')
                            <span class="badge badge-light border text-success font-weight-bold px-2 py-1" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-lock-open mr-1"></i>Live Access
                            </span>
                        @else
                            <span class="badge badge-light border text-muted px-2 py-1" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-lock mr-1"></i>Locked
                            </span>
                        @endif
                    </td>

                    <td>
                        <span class="text-dark font-weight-bold" style="font-size: 0.82rem;">
                            {{ \Carbon\Carbon::parse($req->created_at)->format('d M, Y') }}
                        </span>
                        <br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($req->created_at)->format('h:i A') }}</small>
                    </td>

                    <td>
                        <a href="{{ route('partner.patient.profile', ['encryptedId' => Crypt::encryptString($req->dw_user_id)]) }}" 
                           class="btn btn-sm {{ $accepted ? 'btn-primary' : 'btn-outline-secondary' }} font-weight-bold" 
                           target="_blank" style="border-radius: 6px; padding: 5px 12px; font-size: 0.82rem;">
                            <i class="fa-solid fa-eye mr-1"></i> {{ $accepted ? 'View Full Health Profile' : 'View Details' }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                            <h5>No Patient Requests</h5>
                            <p class="small mb-0">No health profile access requests submitted yet.</p>
                            <a href="/partnerpanel/partner-patient-profile-request" class="btn btn-sm btn-primary mt-3">
                                <i class="fa-solid fa-paper-plane mr-1"></i> Send Patient Request
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="table-pagination-footer">
        <div class="text-muted small mb-2 mb-md-0 font-weight-bold">
            Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of {{ $requests->total() }} requests
        </div>
        <div>
            {{ $requests->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
