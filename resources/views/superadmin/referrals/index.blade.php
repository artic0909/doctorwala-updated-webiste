@extends('layouts.superadmin')

@section('title', 'Referral Registrations | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">Referral Registrations</h3>
            <p class="text-muted mb-0">Manage app referral accounts, payout details, and track referral networks.</p>
        </div>
        <div class="mt-2 mt-md-0 d-flex align-items-center gap-2">
            <a href="{{ route('superadmin.export.reffer', request()->query()) }}" class="btn btn-outline-success font-weight-bold shadow-sm d-flex align-items-center" style="border-radius: 8px;">
                <i class="fa-solid fa-file-excel mr-2 text-success"></i> Export Excel
            </a>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #0284c7 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Total Referrals</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $totalReferrals ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-gift fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #10b981 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Monthly Referrals</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $monthlyReferrals ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #dcfce7; color: #10b981;">
                        <i class="fa-solid fa-calendar-check fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #6366f1 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Unique (Total IP)</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $totalUniqueReferrals ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #ede9fe; color: #6366f1;">
                        <i class="fa-solid fa-network-wired fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #f43f5e !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Unique (Monthly IP)</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $monthlyUniqueReferrals ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #ffe4e6; color: #f43f5e;">
                        <i class="fa-solid fa-shield-virus fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('superadmin.super-all-reffer') }}" class="row align-items-center">
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="text-muted small font-weight-bold mb-1">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control" style="border-radius: 8px;">
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="text-muted small font-weight-bold mb-1">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control" style="border-radius: 8px;">
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <label class="text-muted small font-weight-bold mb-1">Search User / Phone / Code</label>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search name, phone, code..." class="form-control" style="border-radius: 8px;">
            </div>
            <div class="col-md-2 mt-md-4 pt-md-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary font-weight-bold w-100 shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>
                @if(request()->hasAny(['from_date', 'to_date', 'search']))
                <a href="{{ route('superadmin.super-all-reffer') }}" class="btn btn-light font-weight-bold ml-2" style="border-radius: 8px;" title="Reset">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">#</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Date Joined</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Name & Contact</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Referral Code</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Referred By</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Total Referred</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Medical Card</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">IP Address</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Proof</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($referrals as $ref)
                    <tr @if(isset($duplicateIps) && in_array($ref->ip_address, $duplicateIps)) style="background-color: #fff1f2;" @endif>
                        <td class="py-3 px-3 text-muted font-weight-bold" style="font-size: 0.85rem;">
                            {{ ($referrals->currentPage() - 1) * $referrals->perPage() + $loop->iteration }}
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $ref->created_at ? $ref->created_at->format('d M, Y') : 'N/A' }}
                            <div class="text-muted small">{{ $ref->created_at ? $ref->created_at->format('h:i A') : '' }}</div>
                        </td>
                        <td class="py-3 px-3">
                            <div class="font-weight-bold text-dark">{{ $ref->name }}</div>
                            <div class="text-muted small"><i class="fa-solid fa-phone mr-1"></i>{{ $ref->phone }}</div>
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-info px-2 py-1 font-weight-bold" style="font-size: 0.85rem; border-radius: 6px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                {{ $ref->referral_code }}
                            </span>
                        </td>
                        <td class="py-3 px-3">
                            @if($ref->referredBy)
                                <div class="font-weight-bold text-dark">{{ $ref->referredBy->name }}</div>
                                <div class="text-muted small">Code: {{ $ref->referredBy->referral_code }}</div>
                            @else
                                <span class="badge badge-secondary px-2 py-1" style="border-radius: 6px; font-size: 0.75rem;">Direct</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            <span class="badge badge-success px-3 py-1 font-weight-bold" style="border-radius: 20px; font-size: 0.85rem; background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;">
                                {{ $ref->referees_count }}
                            </span>
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $ref->medical_card_number ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3">
                            <span class="text-muted font-weight-bold" style="font-family: monospace;">{{ $ref->ip_address ?? 'N/A' }}</span>
                            @if(isset($duplicateIps) && in_array($ref->ip_address, $duplicateIps))
                                <span class="badge badge-danger ml-1" style="font-size: 0.65rem;">Duplicate</span>
                            @endif
                        </td>
                        <td class="py-3 px-3">
                            @if($ref->profile_screenshot)
                                <a href="{{ asset('storage/' . $ref->profile_screenshot) }}" target="_blank" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" style="border-radius: 6px; padding: 4px 8px; font-size: 0.75rem;">
                                    <i class="fa-solid fa-image mr-1"></i> Proof
                                </a>
                            @else
                                <span class="text-muted small">No Proof</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myDeleteModal{{$ref->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 10px;" title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <p class="mb-0 font-weight-bold">No referral records found matching your criteria.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Pagination Footer -->
    <div class="table-pagination-footer">
        <div class="text-muted small mb-2 mb-md-0 font-weight-bold">
            Showing {{ $referrals->firstItem() ?? 0 }} to {{ $referrals->lastItem() ?? 0 }} of {{ $referrals->total() }} records
        </div>
        <div>
            {{ $referrals->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach ($referrals as $ref)
<div class="modal fade" id="myDeleteModal{{$ref->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{route('superadmin.super-all-reffer.delete', $ref->id)}}" class="modal-body p-4 text-center" method="post">
                @csrf
                @method('DELETE')
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                    <i class="fa-solid fa-trash-can fa-2x"></i>
                </div>
                <h4 class="font-weight-bold text-dark">Confirm Deletion</h4>
                <p class="text-muted mb-4">Are you sure you want to delete referral record for <strong>{{ $ref->name }}</strong>? This action cannot be undone.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4 mr-2" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger px-4" style="border-radius: 8px;">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
