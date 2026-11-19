@extends('layouts.partner')

@section('title', 'Subscription Invoices | Partner Panel')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-receipt text-primary mr-2"></i>Billing & Subscription Invoices
            </h3>
            <p class="text-muted mb-0">Review past payment receipts, applied coupon discounts, and invoice history for your partner account.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/partnerpanel/partner-get-subscription" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-shield-halved mr-1"></i> Subscription Plans
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-file-invoice text-primary mr-2"></i>Invoice History
        </h5>
        <div>
            <span class="badge badge-light px-3 py-2 font-weight-bold" style="border: 1px solid #e2e8f0;">
                Partner: <b class="text-primary">{{ $partner->partner_clinic_name ?? 'My Clinic' }}</b>
            </span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">#</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Invoice ID</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Final Amount</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Applied Coupon</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Coupon Discount</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 140px;">Bill / PDF</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-file-invoice fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Billing Invoices Generated Yet</h5>
                            <p class="text-muted small mb-0">Whenever you subscribe or renew your partner membership, official invoices will appear here.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
