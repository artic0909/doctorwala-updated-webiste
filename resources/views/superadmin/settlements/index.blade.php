@extends('layouts.superadmin')

@section('title', 'Partner Settlements & Payouts | Super Admin')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-money-bill-transfer text-primary mr-2"></i>Partner Settlements & Payouts
            </h3>
            <p class="text-muted mb-0">Manage and track consultation earnings for Doctor and Physiotherapy / Allied partners. Settle payouts manually to partner bank accounts.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <span class="badge badge-light border text-monospace font-weight-bold px-3 py-2 shadow-xs" style="border-radius: 8px; font-size: 0.9rem; color: #0284c7;">
                <i class="fa-solid fa-clock-rotate-left mr-1"></i> Pending Payouts: {{ $pendingCount }}
            </span>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
    <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert" style="border-radius: 10px;">
    <i class="fa-solid fa-circle-info mr-2"></i> {{ session('info') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Summary KPI Cards -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: #ffffff;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.8px;">Pending Settlement</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #fef3c7; color: #d97706;">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-weight-bold mb-1" style="font-size: 1.8rem; color: #d97706;">₹{{ number_format($totalPending, 2) }}</h3>
                    <small class="text-muted font-weight-medium">
                        <strong>{{ $pendingCount }}</strong> transactions awaiting bank payout
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: #ffffff;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.8px;">Total Settled</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #ecfdf5; color: #10b981;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-weight-bold mb-1" style="font-size: 1.8rem; color: #10b981;">₹{{ number_format($totalSettled, 2) }}</h3>
                    <small class="text-success font-weight-medium">
                        <i class="fa-solid fa-building-columns mr-1"></i> {{ $settledCount }} payouts successfully transferred
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-12 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: #ffffff;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.8px;">Filtered Earnings</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-weight-bold mb-1 text-dark" style="font-size: 1.8rem;">₹{{ number_format($totalEarnings, 2) }}</h3>
                    <small class="text-muted font-weight-medium">
                        Total consultation fee in current view
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <!-- Status Pills -->
        <div class="d-flex flex-wrap gap-2 mb-3 pb-2 border-bottom">
            <a href="{{ route('superadmin.settlements.index', array_merge(request()->except('status'), ['status' => 'all'])) }}" 
               class="btn btn-sm mr-2 mb-1 font-weight-bold {{ $status === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}" style="border-radius: 20px; padding: 6px 16px;">
                All ({{ $transactions->total() }})
            </a>
            <a href="{{ route('superadmin.settlements.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}" 
               class="btn btn-sm mr-2 mb-1 font-weight-bold {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }}" style="border-radius: 20px; padding: 6px 16px;">
                <i class="fa-solid fa-clock mr-1"></i> Pending Payouts ({{ $pendingCount }})
            </a>
            <a href="{{ route('superadmin.settlements.index', array_merge(request()->except('status'), ['status' => 'settled'])) }}" 
               class="btn btn-sm mr-2 mb-1 font-weight-bold {{ $status === 'settled' ? 'btn-success' : 'btn-outline-success' }}" style="border-radius: 20px; padding: 6px 16px;">
                <i class="fa-solid fa-circle-check mr-1"></i> Settled ({{ $settledCount }})
            </a>
        </div>

        <form method="GET" action="{{ route('superadmin.settlements.index') }}" class="row g-2 align-items-end">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-search mr-1"></i> Search</label>
                <input type="text" name="search" class="form-control" placeholder="Partner ID, Clinic name, Patient, Razorpay ID..." value="{{ request('search') }}" style="border-radius: 8px;">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-calendar-alt mr-1"></i> From</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" style="border-radius: 8px;">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-calendar-alt mr-1"></i> To</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" style="border-radius: 8px;">
            </div>
            <div class="col-md-3 col-sm-12 d-flex">
                <button type="submit" class="btn btn-primary font-weight-bold flex-grow-1 mr-2" style="height: 40px; border-radius: 8px;">
                    <i class="fa fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('superadmin.settlements.index') }}" class="btn btn-light font-weight-bold" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1;" title="Reset filters">
                    <i class="fa fa-redo text-muted"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Transactions Table -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            Consultation Settlements List
            <span class="badge badge-secondary ml-2">{{ $transactions->total() }}</span>
        </h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="thead-light">
                <tr style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th class="py-3 px-3">TX ID & Date</th>
                    <th class="py-3">Partner Details</th>
                    <th class="py-3">Bank Details for Payout</th>
                    <th class="py-3">Patient & Appointment</th>
                    <th class="py-3 text-right">Fee (₹)</th>
                    <th class="py-3 text-center">Settlement Status</th>
                    <th class="py-3 text-right px-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                @php
                    $partner = $tx->partner;
                    $primaryBank = $partner ? ($partner->primaryBankDetail ?? $partner->bankDetails->first()) : null;
                    $inquiry = $tx->inquiry;
                @endphp
                <tr>
                    <td class="py-3 px-3">
                        <div class="font-weight-bold text-primary font-monospace" style="font-size: 0.85rem;">
                            #TX-{{ str_pad($tx->id, 6, '0', STR_PAD_LEFT) }}
                        </div>
                        <small class="text-muted d-block">{{ $tx->created_at->format('d M Y, h:i A') }}</small>
                        @if($tx->razorpay_payment_id)
                        <span class="badge badge-light border text-muted font-monospace mt-1" style="font-size: 0.72rem;">
                            {{ $tx->razorpay_payment_id }}
                        </span>
                        @endif
                    </td>

                    <td class="py-3">
                        @if($partner)
                            <div class="font-weight-bold text-dark" style="font-size: 0.9rem;">
                                {{ $partner->partner_clinic_name ?: $partner->partner_contact_person_name }}
                            </div>
                            <div class="d-flex align-items-center mt-1">
                                <span class="badge badge-info mr-2" style="font-size: 0.72rem;">
                                    {{ $partner->partner_id }}
                                </span>
                                <small class="text-muted"><i class="fa-solid fa-phone mr-1"></i>{{ $partner->partner_mobile_number }}</small>
                            </div>
                        @else
                            <span class="text-muted">Partner #{{ $tx->dw_partner_id }}</span>
                        @endif
                    </td>

                    <td class="py-3">
                        @if($primaryBank)
                            <div class="font-weight-bold text-dark" style="font-size: 0.88rem;">
                                <i class="fa-solid fa-building-columns text-primary mr-1"></i> {{ $primaryBank->bank_name }}
                            </div>
                            <div class="small text-muted font-monospace">
                                A/C: <strong>{{ $primaryBank->account_no }}</strong>
                            </div>
                            <div class="small text-muted font-monospace">
                                IFSC: <strong>{{ $primaryBank->ifsc_code }}</strong>
                                @if($primaryBank->branch_name) · {{ $primaryBank->branch_name }} @endif
                            </div>
                            @if($primaryBank->account_holder_name)
                            <div class="small text-secondary">
                                Holder: {{ $primaryBank->account_holder_name }}
                            </div>
                            @endif
                        @else
                            <span class="badge badge-danger px-2 py-1" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-triangle-exclamation mr-1"></i> No Bank Account Linked
                            </span>
                        @endif
                    </td>

                    <td class="py-3">
                        @if($inquiry)
                            <div class="font-weight-bold text-dark" style="font-size: 0.88rem;">
                                <i class="fa-solid fa-user text-secondary mr-1"></i> {{ $inquiry->user_name }}
                            </div>
                            <small class="text-muted d-block">
                                <i class="fa-solid fa-mobile-screen mr-1"></i> {{ $inquiry->user_mobile }}
                            </small>
                            <small class="text-muted">
                                Slot: {{ $inquiry->booking_date }} {{ $inquiry->booking_time }}
                                <span class="badge badge-light border ml-1">{{ ucfirst($inquiry->visit_mode ?? 'online') }}</span>
                            </small>
                        @else
                            <div class="text-dark font-weight-medium" style="font-size: 0.85rem;">{{ $tx->description ?: 'Consultation fee' }}</div>
                        @endif
                    </td>

                    <td class="py-3 text-right">
                        <div class="font-weight-bold" style="font-size: 1.05rem; color: #10b981;">
                            ₹{{ number_format($tx->amount, 2) }}
                        </div>
                        <small class="text-success font-weight-bold"><i class="fa-solid fa-check-circle mr-1"></i> Paid</small>
                    </td>

                    <td class="py-3 text-center">
                        @if($tx->settlement_status === 'settled')
                            <span class="badge badge-success px-3 py-2 font-weight-bold shadow-xs" style="border-radius: 8px; font-size: 0.8rem;">
                                <i class="fa-solid fa-circle-check mr-1"></i> Settled
                            </span>
                            @if($tx->settled_at)
                            <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                {{ $tx->settled_at->format('d M Y') }}
                            </small>
                            @endif
                        @elseif($tx->settlement_status === 'rejected')
                            <span class="badge badge-danger px-3 py-2 font-weight-bold" style="border-radius: 8px; font-size: 0.8rem;">
                                <i class="fa-solid fa-circle-xmark mr-1"></i> Rejected
                            </span>
                        @else
                            <span class="badge badge-warning text-dark px-3 py-2 font-weight-bold shadow-xs" style="border-radius: 8px; font-size: 0.8rem; background: #fef3c7; color: #b45309 !important;">
                                <i class="fa-solid fa-clock mr-1"></i> Pending Payout
                            </span>
                        @endif
                    </td>

                    <td class="py-3 text-right px-3">
                        @if($tx->settlement_status === 'settled')
                            <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-toggle="modal" data-target="#settleModal{{ $tx->id }}" style="border-radius: 8px;">
                                <i class="fa-solid fa-eye mr-1"></i> View Payout
                            </button>
                        @else
                            <button type="button" class="btn btn-success btn-sm px-3 font-weight-bold shadow-xs" data-toggle="modal" data-target="#settleModal{{ $tx->id }}" style="border-radius: 8px;">
                                <i class="fa-solid fa-check mr-1"></i> Settle Now
                            </button>
                        @endif
                    </td>
                </tr>

                <!-- Settlement Modal -->
                <div class="modal fade" id="settleModal{{ $tx->id }}" tabindex="-1" role="dialog" aria-labelledby="settleModalLabel{{ $tx->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="border-radius: 16px; border: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title font-weight-bold text-dark" id="settleModalLabel{{ $tx->id }}">
                                    @if($tx->settlement_status === 'settled')
                                        <i class="fa-solid fa-circle-check text-success mr-2"></i> Payout Details
                                    @else
                                        <i class="fa-solid fa-money-bill-transfer text-primary mr-2"></i> Confirm Bank Settlement
                                    @endif
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body pt-3">
                                <!-- Summary Info Box -->
                                <div class="p-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small">Partner:</span>
                                        <span class="font-weight-bold text-dark small">{{ $partner ? ($partner->partner_clinic_name ?: $partner->partner_contact_person_name) : 'Partner' }} ({{ $partner->partner_id ?? '' }})</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small">Payable Amount:</span>
                                        <span class="font-weight-bold text-success" style="font-size: 1.1rem;">₹{{ number_format($tx->amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small">Bank Name:</span>
                                        <span class="font-weight-medium text-dark small">{{ $primaryBank ? $primaryBank->bank_name : 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small">Account No:</span>
                                        <span class="font-weight-bold font-monospace text-dark small">{{ $primaryBank ? $primaryBank->account_no : 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">IFSC Code:</span>
                                        <span class="font-weight-bold font-monospace text-primary small">{{ $primaryBank ? $primaryBank->ifsc_code : 'N/A' }}</span>
                                    </div>
                                    @if($primaryBank && $primaryBank->account_holder_name)
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="text-muted small">Beneficiary:</span>
                                        <span class="font-weight-bold text-dark small">{{ $primaryBank->account_holder_name }}</span>
                                    </div>
                                    @endif
                                </div>

                                @if($tx->settlement_status === 'settled')
                                    <div class="alert alert-success py-2 px-3 small" style="border-radius: 8px;">
                                        <strong>Settled At:</strong> {{ $tx->settled_at ? $tx->settled_at->format('d M, Y h:i A') : 'N/A' }}<br>
                                        @if($tx->settledByAdmin)
                                        <strong>Settled By:</strong> {{ $tx->settledByAdmin->name ?? 'Admin' }}<br>
                                        @endif
                                        @if($tx->settlement_notes)
                                        <strong>Notes / Reference:</strong> {{ $tx->settlement_notes }}
                                        @endif
                                    </div>
                                @else
                                    <form action="{{ route('superadmin.settlements.settle', $tx->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label class="small font-weight-bold text-muted">Bank UTR / Transaction Reference (Optional)</label>
                                            <input type="text" name="utr_number" class="form-control" placeholder="e.g. UTR12938475892" style="border-radius: 8px;">
                                            <small class="text-muted">Enter the bank transfer UTR or IMPS/NEFT reference number.</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold text-muted">Settlement Notes (Optional)</label>
                                            <textarea name="settlement_notes" class="form-control" rows="2" placeholder="e.g. Transferred via SBI Corporate Net Banking" style="border-radius: 8px;"></textarea>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="button" class="btn btn-light mr-2 font-weight-medium" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                                            <button type="submit" class="btn btn-success font-weight-bold px-4" style="border-radius: 8px;">
                                                <i class="fa-solid fa-check mr-1"></i> Confirm & Mark Settled
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px; background: #f1f5f9; color: #64748b;">
                            <i class="fa-solid fa-receipt fa-2x"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-1">No Consultation Transactions Found</h6>
                        <small class="text-muted">When patients book online consultations with Doctor or Others partners via Razorpay, settlement records will show up here.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
