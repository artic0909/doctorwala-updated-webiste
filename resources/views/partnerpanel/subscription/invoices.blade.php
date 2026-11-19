@extends('layouts.partner')

@section('title', 'Subscription Invoices | Partner Panel')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-7 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #dcfce7; color: #16a34a;">
                <i class="fa-solid fa-receipt fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Billing & Subscription Invoices</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Review past payment receipts, transaction details, and active billing plans</p>
            </div>
        </div>
    </div>
    <div class="col-md-5 text-md-right">
        <a href="/partnerpanel/partner-get-subscription" class="btn btn-outline-success font-weight-bold shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-shield-halved mr-1"></i> Subscription Plans
        </a>
    </div>
</div>

<!-- Filter Bar Card -->
<div class="filter-card">
    <form action="{{ route('partnerpanel.partner-invoice') }}" method="GET" class="row align-items-end g-2">
        <div class="col-12 col-md-5 mb-2">
            <label><i class="fa-solid fa-magnifying-glass text-success mr-1"></i> Search Invoice</label>
            <input type="text" name="search" class="form-control" placeholder="Plan title, transaction id..." value="{{ request('search') }}">
        </div>
        <div class="col-6 col-md-2 mb-2">
            <label><i class="fa-regular fa-calendar text-success mr-1"></i> From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
        <div class="col-6 col-md-2 mb-2">
            <label><i class="fa-regular fa-calendar text-success mr-1"></i> To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
        <div class="col-12 col-md-3 mb-2 d-flex">
            <button type="submit" class="btn btn-success flex-grow-1 mr-1 font-weight-bold" style="border-radius: 8px;">
                <i class="fa-solid fa-filter mr-1"></i> Filter
            </button>
            <a href="{{ route('partnerpanel.partner-invoice') }}" class="btn btn-outline-secondary font-weight-bold" style="border-radius: 8px;" title="Reset Filters">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </form>
</div>

<!-- Invoice History Card -->
<div class="doc-card">
    <div class="doc-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="doc-card-title mb-0">Billing & Payment Records</h5>
            @if(isset($invoices) && $invoices->total() > 0)
                <small class="text-muted">Showing {{ $invoices->firstItem() ?? 0 }} - {{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }} invoice records</small>
            @endif
        </div>
        <div>
            <span class="badge badge-light border text-dark font-weight-bold px-3 py-2 shadow-xs" style="border-radius: 8px; font-size: 0.85rem;">
                <i class="fa-solid fa-hospital text-success mr-1"></i> {{ $partner->partner_clinic_name ?? 'My Medical Facility' }}
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table doc-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">SL</th>
                    <th>Status</th>
                    <th>Plan / Subscription</th>
                    <th>Txn ID</th>
                    <th>Amount Paid</th>
                    <th>Valid From</th>
                    <th>Valid Until</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($invoices) && count($invoices) > 0)
                    @foreach($invoices as $inv)
                    <tr>
                        <td class="font-weight-bold text-muted" style="font-size: 0.85rem;">
                            {{ ($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <span class="badge badge-success px-2 py-1 shadow-xs" style="font-size: 0.78rem;">
                                <i class="fa-solid fa-circle-check mr-1"></i>Paid & Active
                            </span>
                        </td>
                        <td>
                            <div class="font-weight-bold text-dark" style="font-size: 0.92rem;">
                                <i class="fa-solid fa-shield-halved text-success mr-1"></i>
                                {{ $inv->subscription_title ?? 'Partner Subscription' }}
                            </div>
                        </td>
                        <td>
                            <code class="text-dark font-weight-bold" style="font-size: 0.85rem;">
                                {{ $inv->transaction_id ?? 'TXN-N/A' }}
                            </code>
                        </td>
                        <td>
                            <span class="font-weight-bold text-success" style="font-size: 0.95rem;">
                                ₹ {{ number_format($inv->subscription_amount ?? 0, 2) }}
                            </span>
                        </td>
                        <td>
                            <span class="text-dark font-weight-bold" style="font-size: 0.82rem;">
                                {{ $inv->current_holding_date ? \Carbon\Carbon::parse($inv->current_holding_date)->format('d M, Y') : ($inv->created_at ? \Carbon\Carbon::parse($inv->created_at)->format('d M, Y') : 'N/A') }}
                            </span>
                        </td>
                        <td>
                            <span class="text-dark font-weight-bold" style="font-size: 0.82rem;">
                                {{ $inv->close_date ? \Carbon\Carbon::parse($inv->close_date)->format('d M, Y') : 'N/A' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fa-solid fa-receipt fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                                <h5>No Billing Invoices Found</h5>
                                <p class="small mb-0">Whenever you subscribe or renew your partner membership, official invoices will appear here.</p>
                                <a href="/partnerpanel/partner-get-subscription" class="btn btn-sm btn-success mt-3 font-weight-bold" style="border-radius: 8px;">
                                    <i class="fa-solid fa-shield-halved mr-1"></i> View Subscription Plans
                                </a>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if(isset($invoices) && $invoices->total() > 0)
    <!-- Pagination Footer -->
    <div class="table-pagination-footer d-flex justify-content-between align-items-center flex-wrap">
        <div class="text-muted small mb-2 mb-md-0">
            Showing <b>{{ $invoices->firstItem() ?? 0 }}</b> to <b>{{ $invoices->lastItem() ?? 0 }}</b> of <b>{{ $invoices->total() }}</b> records
        </div>
        <div>
            {{ $invoices->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif
</div>
@endsection
