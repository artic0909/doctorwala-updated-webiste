@extends('layouts.superadmin')

@section('title', 'All Patients & Users | Doctorwala Super Admin')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-users fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Patient & User Directory</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Registered healthcare consumers, patients and app users</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 text-md-right d-flex justify-content-md-end align-items-center flex-wrap" style="gap: 10px;">
        <span class="badge badge-light border font-weight-bold px-3 py-2 shadow-xs" style="border-radius: 8px; font-size: 0.88rem; color: #0284c7;">
            <i class="fa-solid fa-heart-pulse text-danger mr-1"></i> Total Users: {{ number_format($users->total()) }}
        </span>
        <a href="{{ route('superadmin.export.user', request()->query()) }}" class="btn btn-outline-success font-weight-bold shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-file-excel mr-2"></i>Export Excel
        </a>
    </div>
</div>

<!-- Filter Bar Card -->
<div class="doc-card mb-4 p-3">
    <form action="{{ route('superadmin.super-all-user') }}" method="GET" class="row align-items-center g-2">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <div class="col-12 col-md-4 mb-2 mb-md-0">
            <label class="small text-muted font-weight-bold mb-1"><i class="fa-solid fa-calendar-day text-primary mr-1"></i> Registered From</label>
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="height: 42px; border-radius: 8px; font-size: 0.88rem;">
        </div>

        <div class="col-12 col-md-4 mb-2 mb-md-0">
            <label class="small text-muted font-weight-bold mb-1"><i class="fa-solid fa-calendar-check text-primary mr-1"></i> Registered To</label>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="height: 42px; border-radius: 8px; font-size: 0.88rem;">
        </div>

        <div class="col-12 col-md-4 d-flex align-items-end mt-2 mt-md-0 pt-md-4">
            <button type="submit" class="btn btn-primary font-weight-bold w-100 mr-2" style="height: 42px; border-radius: 8px;" title="Apply Date Filter">
                <i class="fa fa-filter mr-1"></i> Filter Dates
            </button>
            @if(request('start_date') || request('end_date') || request('search'))
                <a href="{{ route('superadmin.super-all-user') }}" class="btn btn-light border" style="height: 42px; border-radius: 8px; padding: 8px 14px;" title="Reset Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- User Table Card -->
<div class="doc-card">
    <div class="doc-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="doc-card-title mb-0">Registered Patients & Users</h5>
            <small class="text-muted">Showing {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users</small>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table doc-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">SL</th>
                    <th>Actions</th>
                    <th>Reg. Date</th>
                    <th>Patient / User</th>
                    <th>Email Address</th>
                    <th>Phone / Mobile</th>
                    <th>City / Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td class="font-weight-bold text-muted" style="font-size: 0.85rem;">
                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                    </td>

                    <td>
                        <a href="javascript:void(0)" data-target="#myDeleteModal{{$user->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" title="Delete User" style="border-radius: 6px; padding: 4px 8px;">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    </td>

                    <td>
                        <span class="text-dark font-weight-bold" style="font-size: 0.85rem;">
                            {{ $user->created_at ? $user->created_at->format('d M, Y') : 'N/A' }}
                        </span>
                        <br>
                        <small class="text-muted">{{ $user->created_at ? $user->created_at->format('h:i A') : '' }}</small>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <div class="mr-2 d-flex align-items-center justify-content-center rounded-circle font-weight-bold" style="width: 36px; height: 36px; background: #e0f2fe; color: #0284c7; font-size: 0.85rem;">
                                {{ strtoupper(substr($user->user_name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-weight-bold text-dark" style="font-size: 0.92rem;">
                                    {{ $user->user_name }}
                                </div>
                                <small class="text-muted">ID: #{{ $user->id }}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        @if($user->user_email)
                            <a href="mailto:{{ $user->user_email }}" class="text-dark font-weight-bold" style="font-size: 0.88rem; text-decoration: none;">
                                <i class="fa-solid fa-envelope text-primary mr-1" style="font-size: 0.8rem;"></i>
                                {{ $user->user_email }}
                            </a>
                        @else
                            <span class="text-muted small">N/A</span>
                        @endif
                    </td>

                    <td>
                        @if($user->user_mobile)
                            <a href="tel:{{ $user->user_mobile }}" class="text-dark font-weight-bold" style="font-size: 0.88rem; text-decoration: none;">
                                <i class="fa-solid fa-phone text-success mr-1" style="font-size: 0.8rem;"></i>
                                {{ $user->user_mobile }}
                            </a>
                        @else
                            <span class="text-muted small">N/A</span>
                        @endif
                    </td>

                    <td>
                        <span class="text-dark font-weight-bold" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-location-dot text-danger mr-1" style="font-size: 0.8rem;"></i>
                            {{ $user->user_city ?? 'N/A' }}
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-success px-2 py-1 shadow-xs" style="font-size: 0.78rem;">
                            <i class="fa-solid fa-shield-check mr-1"></i>Verified
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fa-solid fa-users-slash fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                            <h5>No Users Found</h5>
                            <p class="small mb-0">No registered patients or users match your selected date filter.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="doc-card-footer d-flex justify-content-between align-items-center flex-wrap">
        <div class="text-muted small mb-2 mb-md-0">
            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
        </div>
        <div>
            {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach ($users as $user)
<div class="modal fade" id="myDeleteModal{{$user->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="{{route('superadmin.super-all-user.delete', $user->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Delete User Account?</h5>
                    <p class="text-muted small mb-1">Are you sure you want to delete <strong>{{ $user->user_name }}</strong> ({{ $user->user_mobile }})?</p>
                    <p class="text-danger small mb-0 font-weight-bold">This will remove their patient record and history permanently.</p>
                </div>
                <div class="modal-footer bg-light border-0 py-3 justify-content-center">
                    <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-4" style="border-radius: 8px;">Confirm Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
