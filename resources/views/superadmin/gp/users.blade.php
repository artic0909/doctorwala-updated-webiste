@extends('layouts.superadmin')

@section('title', 'Users under ' . $gp->name . ' | Super Admin')

@section('content')
<div class="row mb-3">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-2">
                <li class="breadcrumb-item"><a href="/superadmin/super-dashboard" class="text-muted"><i class="fa fa-home mr-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.super-gp') }}" class="text-muted">Ground Partners</a></li>
                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">{{ $gp->name }}</li>
            </ol>
        </nav>
        <a href="{{ route('superadmin.super-gp') }}" class="btn btn-outline-secondary btn-sm px-3 font-weight-bold shadow-sm" style="border-radius: 8px;">
            <i class="fa fa-arrow-left mr-1"></i> Back to GP List
        </a>
    </div>
</div>

<!-- Header Banner -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-left: 5px solid #10b981 !important; background: #ffffff;">
    <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="rounded-circle p-3 mr-3 text-white d-flex align-items-center justify-content-center"
                 style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); width: 52px; height: 52px;">
                <i class="fa-solid fa-users fa-lg"></i>
            </div>
            <div>
                <span class="badge badge-success px-2 py-1 mb-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 6px;">
                    <i class="fa-solid fa-users-gear mr-1"></i> Ground Partner
                </span>
                <h3 class="font-weight-bold text-dark mb-1">
                    Users under: <span class="text-success">{{ $gp->name }}</span>
                    <span class="badge badge-light border ml-2" style="font-family: monospace;">{{ $gp->code }}</span>
                </h3>
                <p class="text-muted mb-0 small">
                    All patient accounts registered using GP Code <strong>{{ $gp->code }}</strong>.
                </p>
            </div>
        </div>
        <div class="mt-3 mt-md-0 d-flex align-items-center">
            @if ($gp->ep)
            <div class="p-2 px-3 border rounded text-right mr-2" style="background: #f8fafc;">
                <div class="small text-muted font-weight-bold text-uppercase" style="font-size: 0.68rem;">Assigned EP</div>
                <div class="font-weight-bold text-dark">{{ $gp->ep->name }} ({{ $gp->ep->code }})</div>
            </div>
            @endif
            <div class="p-2 px-3 border rounded text-right" style="background: #f8fafc;">
                <div class="small text-muted font-weight-bold text-uppercase" style="font-size: 0.68rem;">GP Status</div>
                <div class="font-weight-bold text-dark">
                    @if ($gp->status === 'Active')
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
    <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #10b981 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Total Users</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $totalUsers ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #dcfce7; color: #10b981;">
                        <i class="fa-solid fa-users fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #4f46e5 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Registered This Month</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $thisMonthUsers ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #ede9fe; color: #4f46e5;">
                        <i class="fa-solid fa-calendar-check fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #0284c7 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Registered Today</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $todayUsers ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-clock fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table Card -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            Registered Users List
            <span class="badge badge-secondary ml-2">{{ $users->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 60px;">#</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">User Name</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Mobile</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Email</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Medical Card No.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $u)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ $users->firstItem() + $index }}
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $u->name }}
                        </td>
                        <td class="py-3 px-3">
                            <a href="tel:{{ $u->phone }}" class="text-dark"><i class="fa-solid fa-phone text-muted mr-1"></i>{{ $u->phone }}</a>
                        </td>
                        <td class="py-3 px-3 text-muted">
                            {{ $u->email ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-light border font-weight-bold" style="font-family: monospace;">
                                {{ $u->medical_card_no ?? ($u->medical_card_number ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-muted small">
                            {{ $u->created_at ? $u->created_at->format('d M Y, h:i A') : 'N/A' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-user-slash fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Users Registered Under This GP</h5>
                            <p class="text-muted small mb-0">When users register with GP Code {{ $gp->code }}, they will show up here.</p>
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
            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
        </div>
        <div>
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
