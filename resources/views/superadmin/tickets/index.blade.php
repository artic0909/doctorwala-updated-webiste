@extends('layouts.superadmin')

@section('title', 'Partner Support Tickets | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-ticket text-primary mr-2"></i>Partner Support Tickets
            </h3>
            <p class="text-muted mb-0">Active inquiries, operational problems, and technical issues raised by partner clinics.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('superadmin.super-ticket-replies') }}" class="btn btn-outline-success font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-circle-check mr-1"></i> View Resolved / Replied Tickets
            </a>
        </div>
    </div>
</div>

<!-- Search & Date Filter Bar -->
<div class="card border-0 shadow-sm mb-4 filter-card" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('superadmin.super-all-tickets') }}" class="row g-2 align-items-end">
            <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-search mr-1"></i> Search</label>
                <input type="text" name="search" class="form-control" placeholder="Ticket ID, clinic, person, city..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-toggle-on mr-1"></i> Status</label>
                <select name="status" class="form-control">
                    <option value="">All Tickets</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Open / Pending</option>
                    <option value="Replied" {{ request('status') == 'Replied' ? 'selected' : '' }}>Replied</option>
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
                <a href="{{ route('superadmin.super-all-tickets') }}" class="btn btn-light font-weight-bold" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1;" title="Reset filters">
                    <i class="fa fa-redo text-muted"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            Incoming Tickets
            <span class="badge badge-secondary ml-2">{{ $tickets->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 100px;">Ticket ID</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Timestamps</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Partner Clinic</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Contact Person</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Location</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Status</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ ($tickets->currentPage() - 1) * $tickets->perPage() + $loop->iteration }}
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-light border font-weight-bold px-2 py-1" style="font-family: monospace; font-size: 0.85rem;">
                                {{ $ticket->ticket_id }}
                            </span>
                        </td>
                        <td class="py-3 px-3">
                            <div class="font-weight-bold text-dark">
                                <i class="fa-regular fa-clock text-primary mr-1"></i> Raised: {{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y, h:i A') }}
                            </div>
                            @if (!empty($ticket->partner_problem_reply))
                                <div class="text-success small"><i class="fa-solid fa-check-double mr-1"></i> Replied: {{ \Carbon\Carbon::parse($ticket->updated_at)->format('d M Y') }}</div>
                            @else
                                <div class="text-danger small font-weight-bold"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Pending Reply</div>
                            @endif
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $ticket->partner_clinic_name }}
                        </td>
                        <td class="py-3 px-3">
                            <div class="font-weight-bold text-dark">{{ $ticket->partner_contact_person_name }}</div>
                            <div class="text-muted small"><i class="fa-solid fa-phone mr-1"></i>{{ $ticket->partner_mobile_number }}</div>
                            <div class="text-muted small"><i class="fa-solid fa-envelope mr-1"></i>{{ $ticket->partner_email }}</div>
                        </td>
                        <td class="py-3 px-3 text-muted">
                            {{ $ticket->partner_city ?? 'N/A' }}, {{ $ticket->partner_state ?? '' }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if(!empty($ticket->partner_problem_reply))
                                <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 12px;">Replied</span>
                            @else
                                <span class="badge badge-danger px-2 py-1 font-weight-bold" style="background: #fee2e2; color: #b91c1c; border-radius: 12px;">Open</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myDescModal{{ $ticket->id }}" data-toggle="modal" class="btn btn-sm btn-primary font-weight-bold" style="border-radius: 6px; padding: 4px 12px; background: #0284c7; border-color: #0284c7;">
                                <i class="fa-solid fa-reply mr-1"></i> Respond
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-ticket fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Open Tickets Found</h5>
                            <p class="text-muted small mb-0">All partner tickets have been responded to or no tickets are currently pending.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="table-pagination-footer">
        <div class="text-muted small mb-2 mb-md-0 font-weight-bold">
            Showing {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }} of {{ $tickets->total() }} tickets
        </div>
        <div>{{ $tickets->links('pagination::bootstrap-4') }}</div>
    </div>
</div>

<!-- Reply Modals -->
@foreach ($tickets as $ticket)
<div class="modal fade" id="myDescModal{{ $ticket->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 560px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-0 pb-0 pt-4 px-4 bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 42px; height: 42px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.05rem;">Ticket #{{ $ticket->ticket_id }}</h5>
                        <small class="text-muted font-weight-500">{{ $ticket->partner_clinic_name }}</small>
                    </div>
                </div>
                <button type="button" class="close text-muted p-2" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true" style="font-size: 1.4rem;">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.super-ticket-reply', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 0.85rem;">
                        <div>
                            <span class="text-muted font-weight-bold">Contact:</span> {{ $ticket->partner_contact_person_name }} ({{ $ticket->partner_mobile_number }})
                        </div>
                        <div class="text-muted">
                            {{ \Carbon\Carbon::parse($ticket->created_at)->format('d M, h:i A') }}
                        </div>
                    </div>

                    <div class="p-3 rounded mb-3" style="background: #fff1f2; border-left: 4px solid #ef4444;">
                        <span class="font-weight-bold text-danger small"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Partner Issue:</span>
                        <p class="text-dark mt-1 mb-0" style="line-height: 1.5; font-size: 0.88rem;">{{ $ticket->partner_problem }}</p>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-reply text-primary mr-1"></i> Admin Resolution / Reply Message <span class="text-danger">*</span></label>
                        <textarea name="partner_problem_reply" class="form-control form-control-sm" rows="4" placeholder="Type resolution message to send to partner..." style="border-radius: 8px;" required>{{ $ticket->partner_problem_reply }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 py-3 bg-light d-flex justify-content-end" style="gap: 10px;">
                    <button type="button" class="btn btn-light font-weight-bold px-3 py-2" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-paper-plane mr-1"></i> Send Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
