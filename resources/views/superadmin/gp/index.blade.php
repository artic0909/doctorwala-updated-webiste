@extends('layouts.superadmin')

@section('title', 'Ground Partner (GP) Management | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-users-gear text-success mr-2"></i>Ground Partner (GP) Management
            </h3>
            <p class="text-muted mb-0">Create, manage, and monitor Ground Partners linked under Executive Partners (EP).</p>
        </div>
        <div class="mt-2 mt-md-0 d-flex gap-2">
            <a href="{{ route('superadmin.super-ep') }}" class="btn btn-outline-primary font-weight-bold mr-2 shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-user-tie mr-1"></i> Manage EPs
            </a>
            <button type="button" class="btn btn-success font-weight-bold shadow-sm" style="border-radius: 8px;" data-toggle="modal" data-target="#addGpModal">
                <i class="fa fa-plus mr-1"></i> Add New GP
            </button>
        </div>
    </div>
</div>

<!-- KPIs Row -->
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #10b981 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Total GPs</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $totalCount ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #dcfce7; color: #10b981;">
                        <i class="fa-solid fa-users-gear fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #059669 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Active GPs</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $activeCount ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #d1fae5; color: #059669;">
                        <i class="fa-solid fa-circle-check fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #ef4444 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Inactive GPs</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $inactiveCount ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-circle-xmark fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #4f46e5 !important; background: #ffffff;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">EPs Represented</span>
                        <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $totalEpsWithGp ?? 0 }}</h3>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #ede9fe; color: #4f46e5;">
                        <i class="fa-solid fa-network-wired fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('superadmin.super-gp') }}">
            <div class="row align-items-end">
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="small font-weight-bold text-muted mb-1">Search Keywords</label>
                    <input type="text" name="search" class="form-control" placeholder="Name, Code, Mobile..." value="{{ request('search') }}" style="border-radius: 8px;">
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="small font-weight-bold text-muted mb-1">Assigned EP</label>
                    <select name="ep_id" class="form-control" style="border-radius: 8px;">
                        <option value="">All Executive Partners</option>
                        @foreach ($allEps as $ep)
                            <option value="{{ $ep->id }}" {{ request('ep_id') == $ep->id ? 'selected' : '' }}>
                                {{ $ep->name }} ({{ $ep->code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-4 mb-2">
                    <label class="small font-weight-bold text-muted mb-1">Status</label>
                    <select name="status" class="form-control" style="border-radius: 8px;">
                        <option value="">All Statuses</option>
                        <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4 mb-2">
                    <label class="small font-weight-bold text-muted mb-1">From Date</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control" style="border-radius: 8px;">
                </div>
                <div class="col-lg-2 col-md-4 mb-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary font-weight-bold w-100 shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa fa-filter mr-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'ep_id', 'status', 'from_date', 'to_date']))
                    <a href="{{ route('superadmin.super-gp') }}" class="btn btn-light font-weight-bold ml-2" style="border-radius: 8px;" title="Reset">
                        <i class="fa-solid fa-rotate-right"></i>
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Main Table Card -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            Ground Partners List
            <span class="badge badge-secondary ml-2">{{ $records->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 60px;">#</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">GP Code</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Name</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Assigned EP</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Mobile</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Users Linked</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Status</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Registered At</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $index => $item)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ $records->firstItem() + $index }}
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-light border font-weight-bold px-2 py-1" style="font-family: monospace; font-size: 0.85rem;">
                                {{ $item->code }}
                            </span>
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $item->name }}
                        </td>
                        <td class="py-3 px-3">
                            @if ($item->ep)
                                <div class="font-weight-bold text-dark">{{ $item->ep->name }}</div>
                                <span class="badge badge-light border" style="font-size: 0.72rem;">{{ $item->ep->code }}</span>
                            @else
                                <span class="text-muted small">No EP Linked</span>
                            @endif
                        </td>
                        <td class="py-3 px-3">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-phone text-muted mr-1 small"></i>
                                <a href="tel:{{ $item->mobile }}" class="text-dark font-weight-500 mr-2">{{ $item->mobile }}</a>
                                <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $item->mobile) }}" target="_blank"
                                    class="badge badge-success p-1" title="Chat on WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </div>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <a href="{{ route('superadmin.super-gp.users', $item->id) }}"
                               class="badge badge-success p-2 font-weight-bold"
                               style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; border-radius: 6px;"
                               title="Click to view users registered under this GP">
                                <i class="fa-solid fa-users mr-1"></i> {{ $item->users_count }} Users
                            </a>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <form action="{{ route('superadmin.super-gp.toggle-status', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="border-0 bg-transparent p-0" title="Click to toggle status">
                                    @if ($item->status === 'Active')
                                        <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 12px; border: 1px solid #bbf7d0;">
                                            <i class="fa fa-circle mr-1" style="font-size: 7px;"></i> Active
                                        </span>
                                    @else
                                        <span class="badge badge-danger px-2 py-1 font-weight-bold" style="background: #fee2e2; color: #b91c1c; border-radius: 12px; border: 1px solid #fecaca;">
                                            <i class="fa fa-circle mr-1" style="font-size: 7px;"></i> Inactive
                                        </span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-3 text-muted small">
                            {{ $item->created_at ? $item->created_at->format('d M Y, h:i A') : 'N/A' }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <a href="{{ route('superadmin.super-gp.users', $item->id) }}"
                               class="btn btn-sm btn-outline-info mr-1" style="border-radius: 6px; padding: 4px 8px;"
                               title="View Users registered under this GP">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-primary mr-1" style="border-radius: 6px; padding: 4px 8px;"
                                data-toggle="modal" data-target="#editGpModal{{ $item->id }}" title="Edit GP">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;"
                                data-toggle="modal" data-target="#deleteGpModal{{ $item->id }}" title="Delete GP">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-user-slash fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Ground Partners Found</h5>
                            <p class="text-muted small">Try modifying search filters or click "Add New GP" to create one.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($records->hasPages())
    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <span class="text-muted small">Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of {{ $records->total() }} entries</span>
        <div>{{ $records->links('pagination::bootstrap-4') }}</div>
    </div>
    @endif
</div>

<!-- Add GP Modal -->
<div class="modal fade" id="addGpModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-success text-white" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa-solid fa-users-gear mr-2"></i> Add New Ground Partner (GP)
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.super-gp.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-user-tie text-success mr-1"></i> Executive Partner (EP) <span class="text-danger">*</span></label>
                        <select class="form-control" name="ep_id" style="border-radius: 8px;" required>
                            <option value="">-- Select Parent EP --</option>
                            @foreach ($allEps as $ep)
                                <option value="{{ $ep->id }}" {{ old('ep_id') == $ep->id ? 'selected' : '' }}>
                                    {{ $ep->name }} ({{ $ep->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa fa-user text-success mr-1"></i> Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter GP full name" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa fa-phone text-success mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="10-digit mobile number" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">
                            <i class="fa fa-barcode text-success mr-1"></i> GP Code
                            <small class="text-muted font-italic">(Optional - auto-generated if blank)</small>
                        </label>
                        <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="Leave blank to auto-generate (e.g. GP839210)" style="border-radius: 8px;">
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark"><i class="fa fa-toggle-on text-success mr-1"></i> Initial Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="status" style="border-radius: 8px;" required>
                            <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                    <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold" style="border-radius: 8px;">
                        <i class="fa fa-check mr-1"></i> Save GP
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit GP Modals -->
@foreach ($records as $item)
<div class="modal fade" id="editGpModal{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-dark text-white" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit GP: {{ $item->name }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.super-gp.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-user-tie text-primary mr-1"></i> Parent Executive Partner (EP) <span class="text-danger">*</span></label>
                        <select class="form-control" name="ep_id" style="border-radius: 8px;" required>
                            @foreach ($allEps as $ep)
                                <option value="{{ $ep->id }}" {{ old('ep_id', $item->ep_id) == $ep->id ? 'selected' : '' }}>
                                    {{ $ep->name }} ({{ $ep->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa fa-user text-primary mr-1"></i> Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $item->name) }}" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="mobile" value="{{ old('mobile', $item->mobile) }}" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa fa-barcode text-primary mr-1"></i> GP Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="code" value="{{ old('code', $item->code) }}" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark"><i class="fa fa-toggle-on text-primary mr-1"></i> Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="status" style="border-radius: 8px;" required>
                            <option value="Active" {{ $item->status === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $item->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                    <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold" style="border-radius: 8px;">
                        <i class="fa fa-save mr-1"></i> Update Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete GP Modal -->
<div class="modal fade" id="deleteGpModal{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ route('superadmin.super-gp.delete', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 text-dark">Delete Ground Partner?</h4>
                    <p class="text-muted mb-3">
                        Are you sure you want to delete <strong>{{ $item->name }}</strong> ({{ $item->code }})?
                        <br><span class="text-danger small">This action cannot be undone.</span>
                    </p>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-light px-4 mr-2" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4 font-weight-bold" style="border-radius: 8px;">Confirm Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
