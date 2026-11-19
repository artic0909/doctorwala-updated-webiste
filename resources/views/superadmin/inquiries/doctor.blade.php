@extends('layouts.superadmin')

@section('title', 'Doctor Inquiries | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-user-doctor text-primary mr-2"></i>Doctor Direct Inquiries
            </h3>
            <p class="text-muted mb-0">Direct consultation and appointment inquiries submitted for registered doctors.</p>
        </div>
    </div>
</div>

<!-- Search & Date Filter Bar -->
<div class="card border-0 shadow-sm mb-4 filter-card" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('superadmin.super-doc-inquiry') }}" class="row g-2 align-items-end">
            <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-search mr-1"></i> Search</label>
                <input type="text" name="search" class="form-control" placeholder="Patient name, mobile, email, message..." value="{{ request('search') }}">
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
                <a href="{{ route('superadmin.super-doc-inquiry') }}" class="btn btn-light font-weight-bold" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1;" title="Reset filters">
                    <i class="fa fa-redo text-muted"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            Doctor Inquiries List
            <span class="badge badge-secondary ml-2">{{ $inquiries->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Target Doctor</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Patient Name</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Mobile</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Email</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Inquiry Details</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ ($inquiries->currentPage() - 1) * $inquiries->perPage() + $loop->iteration }}
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-primary px-2 py-1 font-weight-bold" style="background: #e0f2fe; color: #0369a1; border-radius: 6px;">
                                {{ $inquiry->doc_name ?? ($inquiry->clinic_name ?? 'Doctor') }}
                            </span>
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $inquiry->user_name }}
                        </td>
                        <td class="py-3 px-3">
                            <a href="tel:{{ $inquiry->user_mobile }}" class="text-dark"><i class="fa-solid fa-phone text-muted mr-1"></i>{{ $inquiry->user_mobile }}</a>
                        </td>
                        <td class="py-3 px-3 text-muted">
                            {{ $inquiry->user_email ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myInquiryModal{{$inquiry->id}}" data-toggle="modal" class="btn btn-sm btn-outline-info font-weight-bold" style="border-radius: 6px; padding: 4px 10px;">
                                <i class="fa-solid fa-eye mr-1"></i> View Note
                            </button>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myDeleteModal{{$inquiry->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Record">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-user-doctor fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Doctor Inquiries Found</h5>
                            <p class="text-muted small mb-0">Patient consultation inquiries for individual doctors will appear here.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="table-pagination-footer">
        <div class="text-muted small mb-2 mb-md-0 font-weight-bold">
            Showing {{ $inquiries->firstItem() ?? 0 }} to {{ $inquiries->lastItem() ?? 0 }} of {{ $inquiries->total() }} entries
        </div>
        <div>{{ $inquiries->links('pagination::bootstrap-4') }}</div>
    </div>
</div>

<!-- Details & Delete Modals -->
@foreach($inquiries as $inquiry)
<div class="modal fade" id="myInquiryModal{{$inquiry->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-primary text-white" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa-solid fa-user-doctor mr-2"></i> Doctor Inquiry: {{ $inquiry->doc_name ?? $inquiry->clinic_name }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <span class="text-muted small font-weight-bold text-uppercase">Patient Information</span>
                    <h6 class="font-weight-bold text-dark mt-1">{{ $inquiry->user_name }} ({{ $inquiry->user_mobile }})</h6>
                    <div class="text-muted small">{{ $inquiry->user_email }}</div>
                </div>
                <div class="p-3 rounded bg-light border">
                    <span class="text-muted small font-weight-bold text-uppercase">Inquiry Description</span>
                    <p class="mb-0 text-dark mt-2" style="line-height: 1.5;">{{ $inquiry->inquiries ?? $inquiry->inquiry ?? 'No additional details provided.' }}</p>
                </div>
            </div>
            <div class="modal-footer bg-light" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myDeleteModal{{$inquiry->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ url('/superadmin/super-doc-inquiry/delete/' . $inquiry->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 text-dark">Delete Inquiry?</h4>
                    <p class="text-muted mb-4">Are you sure you want to delete this doctor inquiry? This action cannot be undone.</p>
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
