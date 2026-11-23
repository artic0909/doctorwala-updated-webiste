@extends('layouts.partner')

@section('title', 'Wallet & Earnings | Doctorwala')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-7 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-wallet fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Wallet & Payouts</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Track your consultation earnings, video consultations revenue and settlement history</p>
            </div>
        </div>
    </div>
    <div class="col-md-5 text-md-right">
        <a href="{{ route('partner.bank.details.index') }}" class="btn btn-outline-primary btn-sm px-3 py-2 mr-2 font-weight-medium" style="border-radius: 8px;">
            <i class="fa-solid fa-building-columns mr-1"></i> Bank Accounts ({{ $totalBankAccounts }})
        </a>
        <span class="badge badge-light border text-monospace font-weight-bold px-3 py-2 shadow-xs" style="border-radius: 8px; font-size: 0.88rem; color: #0284c7;">
            <i class="fa-solid fa-shield-halved mr-1"></i> Status: {{ ucfirst($wallet->status) }}
        </span>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
    <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
    <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- KPI Cards -->
<div class="row mb-4">
    <!-- Current Balance -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-white-50 text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.8px;">Available Balance</span>
                    <span class="badge badge-light text-primary font-weight-bold px-2 py-1" style="border-radius: 6px; font-size: 0.72rem;">{{ $wallet->currency }}</span>
                </div>
                <div>
                    <h2 class="font-weight-bolder mb-1" style="font-size: 2.2rem; letter-spacing: -0.5px;">₹{{ number_format($wallet->balance, 2) }}</h2>
                    <small class="text-white-50"><i class="fa-solid fa-clock mr-1"></i> Last updated {{ $wallet->updated_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Earned -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: #fff;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.8px;">Total Earned</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #ecfdf5; color: #10b981;">
                        <i class="fa-solid fa-arrow-down-left"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-weight-bold mb-1 text-dark" style="font-size: 1.7rem;">₹{{ number_format($totalEarned, 2) }}</h3>
                    <small class="text-success font-weight-medium"><i class="fa-solid fa-circle-check mr-1"></i> Completed consultations</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Withdrawn / Payouts -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: #fff;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.8px;">Total Settled</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-arrow-up-right"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-weight-bold mb-1 text-dark" style="font-size: 1.7rem;">₹{{ number_format($totalWithdrawn, 2) }}</h3>
                    <small class="text-muted"><i class="fa-solid fa-building-columns mr-1"></i> Transferred to bank</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Linked Bank Account Preview -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: #fff;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.8px;">Primary Bank</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #fef3c7; color: #d97706;">
                        <i class="fa-solid fa-landmark"></i>
                    </div>
                </div>
                <div>
                    @if($primaryBank)
                        <h5 class="font-weight-bold mb-0 text-dark text-truncate">{{ $primaryBank->bank_name }}</h5>
                        <p class="text-muted mb-0 font-weight-medium" style="font-size: 0.85rem;">A/C: {{ $primaryBank->masked_account_no }}</p>
                        <small class="text-primary font-weight-bold font-monospace">IFSC: {{ $primaryBank->ifsc_code }}</small>
                    @else
                        <h6 class="font-weight-bold text-muted mb-1">No Primary Account</h6>
                        <a href="{{ route('partner.bank.details.index') }}" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 0.78rem;">
                            + Add Account
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white border-0 py-3 d-flex flex-wrap align-items-center justify-content-between">
        <div>
            <h5 class="font-weight-bold mb-1 text-dark">Transaction Statement</h5>
            <p class="text-muted mb-0" style="font-size: 0.82rem;">Complete audit trail of all earnings, consultations, and settlements</p>
        </div>
        <form method="GET" action="{{ route('partner.wallet.index') }}" class="form-inline mt-2 mt-md-0">
            <div class="input-group input-group-sm mr-2 mb-2 mb-sm-0">
                <select name="type" class="custom-select custom-select-sm" onchange="this.form.submit()" style="border-radius: 6px;">
                    <option value="">All Types</option>
                    <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Credits (Earned)</option>
                    <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>Debits (Payouts)</option>
                </select>
            </div>
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control" placeholder="Search ref or info..." value="{{ request('search') }}" style="border-radius: 6px 0 0 6px;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" style="border-radius: 0 6px 6px 0;"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
            @if(request()->hasAny(['type', 'search']))
                <a href="{{ route('partner.wallet.index') }}" class="btn btn-link btn-sm text-muted ml-2">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="thead-light">
                <tr style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th class="py-3 px-4">TX ID / Ref</th>
                    <th class="py-3">Type & Source</th>
                    <th class="py-3">Description</th>
                    <th class="py-3 text-right">Amount</th>
                    <th class="py-3 text-right">Balance</th>
                    <th class="py-3 text-center">Status</th>
                    <th class="py-3 text-right px-4">Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td class="py-3 px-4">
                        <div class="font-weight-bold font-monospace" style="font-size: 0.84rem; color: #0284c7;">
                            #TX-{{ str_pad($tx->id, 6, '0', STR_PAD_LEFT) }}
                        </div>
                        @if($tx->reference_id)
                        <small class="text-muted font-monospace">Ref: {{ $tx->reference_id }}</small>
                        @endif
                    </td>
                    <td class="py-3">
                        <div class="d-flex align-items-center">
                            @if($tx->transaction_type === 'credit')
                                <span class="badge badge-pill badge-light mr-2" style="background: #ecfdf5; color: #10b981; padding: 6px 10px;">
                                    <i class="fa-solid fa-arrow-down-left mr-1"></i> Credit
                                </span>
                            @else
                                <span class="badge badge-pill badge-light mr-2" style="background: #eff6ff; color: #2563eb; padding: 6px 10px;">
                                    <i class="fa-solid fa-arrow-up-right mr-1"></i> Debit
                                </span>
                            @endif
                            <span class="text-capitalize font-weight-medium text-dark" style="font-size: 0.88rem;">{{ str_replace('_', ' ', $tx->source) }}</span>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="text-dark font-weight-medium" style="font-size: 0.86rem;">{{ $tx->description ?: 'Consultation fee credit' }}</div>
                    </td>
                    <td class="py-3 text-right">
                        <div class="font-weight-bold" style="font-size: 0.95rem; color: {{ $tx->transaction_type === 'credit' ? '#10b981' : '#dc2626' }};">
                            {{ $tx->transaction_type === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                        </div>
                    </td>
                    <td class="py-3 text-right">
                        <span class="font-weight-medium text-muted font-monospace" style="font-size: 0.85rem;">₹{{ number_format($tx->closing_balance, 2) }}</span>
                    </td>
                    <td class="py-3 text-center">
                        @if($tx->status === 'completed')
                            <span class="badge badge-success px-2 py-1" style="border-radius: 6px; font-size: 0.72rem;">Completed</span>
                        @elseif($tx->status === 'pending')
                            <span class="badge badge-warning px-2 py-1" style="border-radius: 6px; font-size: 0.72rem;">Pending</span>
                        @else
                            <span class="badge badge-secondary px-2 py-1" style="border-radius: 6px; font-size: 0.72rem;">{{ ucfirst($tx->status) }}</span>
                        @endif
                    </td>
                    <td class="py-3 text-right px-4">
                        <div class="text-dark font-weight-medium" style="font-size: 0.84rem;">{{ $tx->created_at->format('d M, Y') }}</div>
                        <small class="text-muted">{{ $tx->created_at->format('h:i A') }}</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-receipt fa-3x mb-3 text-black-50 d-block"></i>
                        <p class="font-weight-bold mb-1">No Transactions Found</p>
                        <small>When consultations and video appointments are completed, earnings will show up here automatically.</small>
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
