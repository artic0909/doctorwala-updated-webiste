@extends('layouts.partner')

@section('title', 'Patient Appointments | Partner Panel')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-calendar-check text-primary mr-2"></i>Patient Appointments & Consultation Bookings
            </h3>
            <p class="text-muted mb-0">Appointments and consultation bookings submitted by patients through the Doctorwala portal.</p>
        </div>
    </div>
</div>

<!-- Search & Date Filter Bar -->
<div class="card border-0 shadow-sm mb-4 filter-card" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('partner.patient.inquiry.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4 col-sm-12 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-search mr-1"></i> Search</label>
                <input type="text" name="search" class="form-control" placeholder="Patient name, mobile, email, message..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-hospital mr-1"></i> Type</label>
                <select name="clinic_type" class="form-control">
                    <option value="">All Types</option>
                    <option value="OPD" {{ request('clinic_type') == 'OPD' ? 'selected' : '' }}>OPD</option>
                    <option value="Pathology" {{ request('clinic_type') == 'Pathology' ? 'selected' : '' }}>Pathology</option>
                    <option value="Doctor" {{ request('clinic_type') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
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
            <div class="col-md-2 col-sm-12 d-flex">
                <button type="submit" class="btn btn-primary font-weight-bold flex-grow-1 mr-2" style="height: 42px; border-radius: 8px;">
                    <i class="fa fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('partner.patient.inquiry.index') }}" class="btn btn-light font-weight-bold" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1;" title="Reset filters">
                    <i class="fa fa-redo text-muted"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-calendar-check text-primary mr-2"></i>Appointments & Bookings Inbox
            <span class="badge badge-secondary ml-2">{{ $patientInquiries->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Service Type</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Patient Details</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Inquiry Message</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patientInquiries as $pi)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">{{ ($patientInquiries->currentPage() - 1) * $patientInquiries->perPage() + $loop->iteration }}</td>
                        <td class="py-3 px-3">
                            <span class="badge badge-info px-2 py-1 font-weight-bold" style="background: #e0f2fe; color: #0369a1; border-radius: 6px;">
                                {{ $pi->clinic_type }}
                            </span>
                        </td>
                        <td class="py-3 px-3">
                            <div class="font-weight-bold text-dark text-capitalize"><i class="fa-solid fa-user-circle text-muted mr-1"></i>{{ $pi->user_name }}</div>
                            @if($pi->user_mobile)
                                <div class="small text-muted"><i class="fa-solid fa-phone mr-1 text-success"></i>{{ $pi->user_mobile }}</div>
                            @endif
                            @if($pi->user_email)
                                <div class="small text-muted"><i class="fa-solid fa-envelope mr-1 text-primary"></i>{{ $pi->user_email }}</div>
                            @endif
                        </td>
                        <td class="py-3 px-3">
                            <div class="p-2 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 0.88rem; line-height: 1.5; color: #334155;">
                                {{ $pi->user_inquiry }}
                            </div>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <div class="d-flex justify-content-center" style="gap: 6px;">
                                @if($pi->user_email)
                                <a href="mailto:{{ $pi->user_email }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; padding: 4px 8px;" title="Reply by Email">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                                @endif
                                @if($pi->user_mobile)
                                <a href="tel:{{ $pi->user_mobile }}" class="btn btn-sm btn-outline-success" style="border-radius: 6px; padding: 4px 8px;" title="Call Patient">
                                    <i class="fa-solid fa-phone"></i>
                                </a>
                                @endif
                                <button type="button" data-target="#myDeleteModal{{ $pi->id }}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Inquiry">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-regular fa-comment-dots fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Inquiries Received</h5>
                            <p class="text-muted small mb-0">Patient queries about consultation timings and appointments will appear here.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="table-pagination-footer">
        <div class="text-muted small mb-2 mb-md-0 font-weight-bold">
            Showing {{ $patientInquiries->firstItem() ?? 0 }} to {{ $patientInquiries->lastItem() ?? 0 }} of {{ $patientInquiries->total() }} inquiries
        </div>
        <div>{{ $patientInquiries->links('pagination::bootstrap-4') }}</div>
    </div>
</div>

<!-- Delete Modals -->
@foreach($patientInquiries as $pi)
<div class="modal fade" id="myDeleteModal{{ $pi->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ route('partner.patient.inquiry.delete', $pi->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                    </div>
                    <h4 class="font-weight-bold text-dark">Delete Inquiry?</h4>
                    <p class="text-muted mb-4">Are you sure you want to remove this inquiry from <b>{{ $pi->user_name }}</b>?</p>
                    <div class="d-flex justify-content-center" style="gap: 12px;">
                        <button type="button" class="btn btn-light px-4 font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4 font-weight-bold" style="border-radius: 8px;">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
