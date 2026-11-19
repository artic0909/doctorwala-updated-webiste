@extends('layouts.superadmin')

@section('title', 'Partners under ' . $ep->name . ' | Super Admin')

@section('content')
<div class="row mb-3">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-2">
                <li class="breadcrumb-item"><a href="/superadmin/super-dashboard" class="text-muted"><i class="fa fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.super-ep') }}" class="text-muted">Executive Partners</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">{{ $ep->name }}</li>
            </ol>
        </nav>
        <a href="{{ route('superadmin.super-ep') }}" class="btn btn-outline-secondary btn-sm px-3 font-weight-bold shadow-sm" style="border-radius: 8px;">
            <i class="fa fa-arrow-left mr-1"></i> Back to EP List
        </a>
    </div>
</div>

<!-- Header Banner -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-left: 5px solid #4f46e5 !important; background: #ffffff;">
    <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="rounded-circle p-3 mr-3 text-white d-flex align-items-center justify-content-center"
                 style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); width: 52px; height: 52px;">
                <i class="fa-solid fa-handshake fa-lg"></i>
            </div>
            <div>
                <span class="badge badge-info px-2 py-1 mb-1 font-weight-bold" style="background: #ede9fe; color: #4f46e5; border-radius: 6px;">
                    <i class="fa-solid fa-user-tie mr-1"></i> Executive Partner
                </span>
                <h3 class="font-weight-bold text-dark mb-1">
                    Partners under: <span class="text-primary">{{ $ep->name }}</span>
                    <span class="badge badge-light border ml-2" style="font-family: monospace;">{{ $ep->code }}</span>
                </h3>
                <p class="text-muted mb-0 small">
                    All medical providers registered using EP Code <strong>{{ $ep->code }}</strong>.
                </p>
            </div>
        </div>
        <div class="mt-3 mt-md-0 d-flex align-items-center">
            <div class="p-2 px-3 border rounded text-right" style="background: #f8fafc;">
                <div class="small text-muted font-weight-bold text-uppercase" style="font-size: 0.68rem;">EP Contact & Status</div>
                <div class="font-weight-bold text-dark d-flex align-items-center justify-content-end">
                    <a href="tel:{{ $ep->mobile }}" class="text-dark mr-2"><i class="fa fa-phone text-muted mr-1"></i>{{ $ep->mobile }}</a>
                    @if ($ep->status === 'Active')
                        <span class="badge badge-success" style="background: #dcfce7; color: #15803d; border-radius: 10px;">Active</span>
                    @else
                        <span class="badge badge-danger" style="background: #fee2e2; color: #b91c1c; border-radius: 10px;">Inactive</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KPIs Row -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #4f46e5 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Total Partners</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $totalPartners ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #ede9fe; color: #4f46e5;">
                        <i class="fa-solid fa-handshake fa-lg"></i>
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
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Active Partners</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $activePartners ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #dcfce7; color: #10b981;">
                        <i class="fa-solid fa-circle-check fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #0284c7 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">This Month</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $thisMonthPartners ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-calendar-check fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #f59e0b !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Registered Today</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $todayPartners ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fef3c7; color: #f59e0b;">
                        <i class="fa-solid fa-clock fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Partners Table Card -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            Registered Partners
            <span class="badge badge-secondary ml-2">{{ $partners->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 60px;">#</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Partner Details</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Partner ID</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Service Type</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">City / Location</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Status</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($partners as $index => $partner)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ $partners->firstItem() + $index }}
                        </td>
                        <td class="py-3 px-3">
                            <div class="font-weight-bold text-dark">{{ $partner->company_name ?? $partner->name }}</div>
                            <div class="text-muted small"><i class="fa-solid fa-phone mr-1"></i>{{ $partner->phone }}</div>
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-light border font-weight-bold" style="font-family: monospace;">{{ $partner->partner_id ?? 'N/A' }}</span>
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-primary px-2 py-1 font-weight-bold" style="background: #e0f2fe; color: #0369a1; border-radius: 6px;">
                                {{ is_array($partner->registration_type) ? implode(', ', $partner->registration_type) : ($partner->registration_type ?? 'Medical Provider') }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-muted">
                            {{ $partner->city ?? 'N/A' }}, {{ $partner->state ?? '' }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if (($partner->status ?? '') === 'Active' || ($partner->is_active ?? 0) == 1)
                                <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 12px;">Active</span>
                            @else
                                <span class="badge badge-danger px-2 py-1 font-weight-bold" style="background: #fee2e2; color: #b91c1c; border-radius: 12px;">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-muted small">
                            {{ $partner->created_at ? $partner->created_at->format('d M Y, h:i A') : 'N/A' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-handshake-slash fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Partners Registered Under This EP</h5>
                            <p class="text-muted small mb-0">When partners register with EP Code {{ $ep->code }}, they will show up here.</p>
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
            Showing {{ $partners->firstItem() ?? 0 }} to {{ $partners->lastItem() ?? 0 }} of {{ $partners->total() }} entries
        </div>
        <div>
            {{ $partners->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
