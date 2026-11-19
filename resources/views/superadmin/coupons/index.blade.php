@extends('layouts.superadmin')

@section('title', 'Coupons Management | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-ticket-simple text-primary mr-2"></i>Coupons Management
            </h3>
            <p class="text-muted mb-0">Active discount coupons, promotional validity, and redemption status.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('superadmin.super-coupon.index') }}" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                <i class="fa-solid fa-plus mr-1"></i> Add New Coupon
            </a>
        </div>
    </div>
</div>

<!-- Search & Date Filter Bar -->
<div class="card border-0 shadow-sm mb-4 filter-card" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('superadmin.super-coupon.show') }}" class="row g-2 align-items-end">
            <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-search mr-1"></i> Search</label>
                <input type="text" name="search" class="form-control" placeholder="Code or amount..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-toggle-on mr-1"></i> Status</label>
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
                <a href="{{ route('superadmin.super-coupon.show') }}" class="btn btn-light font-weight-bold" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1;" title="Reset filters">
                    <i class="fa fa-redo text-muted"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            All Coupons
            <span class="badge badge-secondary ml-2">{{ $coupons->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 60px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Artwork</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Coupon Code</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Discount Value</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Start Date</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Expiry Date</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Status</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ ($coupons->currentPage() - 1) * $coupons->perPage() + $loop->iteration }}
                        </td>
                        <td class="py-3 px-3">
                            @if($coupon->coupon_image)
                            <img src="{{ asset('storage/' . $coupon->coupon_image) }}" alt="Coupon Artwork"
                                 style="width: 90px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                            @else
                            <div class="rounded d-flex align-items-center justify-content-center bg-light text-muted" style="width: 90px; height: 50px;">
                                <i class="fa-solid fa-image"></i>
                            </div>
                            @endif
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-light border font-weight-bold px-2 py-1" style="font-family: monospace; font-size: 0.9rem; letter-spacing: 0.5px;">
                                {{ $coupon->coupon_code }}
                            </span>
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-success" style="font-size: 0.95rem;">
                            ₹ {{ number_format($coupon->coupon_amount, 2) }}
                        </td>
                        <td class="py-3 px-3 text-muted">
                            <i class="fa-solid fa-calendar-check text-primary mr-1"></i> {{ $coupon->coupon_start_date ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-danger">
                            <i class="fa-solid fa-calendar-xmark mr-1"></i> {{ $coupon->coupon_end_date ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myActiveInactiveModal{{$coupon->id}}" data-toggle="modal" class="border-0 bg-transparent p-0" title="Click to change status">
                                @if(strtolower($coupon->status) == 'active')
                                    <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 12px; border: 1px solid #bbf7d0;">
                                        <i class="fa fa-circle mr-1" style="font-size: 7px;"></i> Active
                                    </span>
                                @else
                                    <span class="badge badge-danger px-2 py-1 font-weight-bold" style="background: #fee2e2; color: #b91c1c; border-radius: 12px; border: 1px solid #fecaca;">
                                        <i class="fa fa-circle mr-1" style="font-size: 7px;"></i> Inactive
                                    </span>
                                @endif
                            </button>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myEditModal{{$coupon->id}}" data-toggle="modal" class="btn btn-sm btn-outline-primary mr-1" style="border-radius: 6px; padding: 4px 8px;" title="Edit Coupon">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" data-target="#myDeleteModal{{$coupon->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Coupon">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-ticket-simple fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Coupons Available</h5>
                            <p class="text-muted small">Click "Add New Coupon" above to launch promotional discounts.</p>
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
            Showing {{ $coupons->firstItem() ?? 0 }} to {{ $coupons->lastItem() ?? 0 }} of {{ $coupons->total() }} coupons
        </div>
        <div>
            {{ $coupons->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach ($coupons as $coupon)
<div class="modal fade" id="myEditModal{{$coupon->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-dark text-white" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Coupon: {{ $coupon->coupon_code }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.super-coupon.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-barcode text-primary mr-1"></i> Coupon Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="coupon_code" value="{{ old('coupon_code', $coupon->coupon_code) }}" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa fa-indian-rupee-sign text-primary mr-1"></i> Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="coupon_amount" value="{{ old('coupon_amount', $coupon->coupon_amount) }}" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-image text-primary mr-1"></i> Update Image <small class="text-muted">(Optional)</small></label>
                        <input type="file" class="form-control" name="coupon_image" style="border-radius: 8px;">
                    </div>
                    <div class="row">
                        <div class="col-6 form-group mb-0">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-calendar-days text-primary mr-1"></i> Opening Date</label>
                            <input type="date" class="form-control" name="coupon_start_date" value="{{ old('coupon_start_date', $coupon->coupon_start_date) }}" style="border-radius: 8px;">
                        </div>
                        <div class="col-6 form-group mb-0">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-calendar-xmark text-primary mr-1"></i> Closing Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="coupon_end_date" value="{{ old('coupon_end_date', $coupon->coupon_end_date) }}" style="border-radius: 8px;" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                    <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold" style="border-radius: 8px;">Update Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Status Modals -->
<div class="modal fade" id="myActiveInactiveModal{{$coupon->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-toggle-on text-primary mr-2"></i> Update Coupon Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.super-coupon.update.status', $coupon->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">Set active status for coupon <strong>{{ $coupon->coupon_code }}</strong>:</p>
                    <div class="form-group mb-0">
                        <select name="status" class="form-control" style="border-radius: 8px;" required>
                            <option value="Active" {{ strtolower($coupon->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ strtolower($coupon->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px;">Save Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modals -->
<div class="modal fade" id="myDeleteModal{{$coupon->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{route('superadmin.super-coupon.delete', $coupon->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 text-dark">Delete Coupon?</h4>
                    <p class="text-muted mb-4">Are you sure you want to delete coupon <strong>{{ $coupon->coupon_code }}</strong>? This action cannot be undone.</p>
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
