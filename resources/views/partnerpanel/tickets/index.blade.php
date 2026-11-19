@extends('layouts.partner')

@section('title', 'Support Tickets History | Partner Panel')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-headset text-primary mr-2"></i>Support Tickets & Inquiries
            </h3>
            <p class="text-muted mb-0">Track submitted requests, resolution status, and view official replies from the Doctorwala administrative team.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/partnerpanel/partner-get-ticket" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                <i class="fa-solid fa-plus mr-1"></i> Open New Ticket
            </a>
        </div>
    </div>
</div>

<!-- Search & Date Filter Bar -->
<div class="card border-0 shadow-sm mb-4 filter-card" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('partner.inquiries.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-search mr-1"></i> Search</label>
                <input type="text" name="search" class="form-control" placeholder="Ticket ID, problem note..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-toggle-on mr-1"></i> Status</label>
                <select name="status" class="form-control">
                    <option value="">All Tickets</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>In Review / Pending</option>
                    <option value="Replied" {{ request('status') == 'Replied' ? 'selected' : '' }}>Resolved</option>
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
                <a href="{{ route('partner.inquiries.index') }}" class="btn btn-light font-weight-bold" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1;" title="Reset filters">
                    <i class="fa fa-redo text-muted"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-list-check text-primary mr-2"></i>My Tickets
            <span class="badge badge-secondary ml-2">{{ $inquiries->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Ticket ID</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Timeline</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Status</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Problem</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Admin Reply</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inquiries as $ticket)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">{{ ($inquiries->currentPage() - 1) * $inquiries->perPage() + $loop->iteration }}</td>
                        <td class="py-3 px-3">
                            <span class="badge badge-light px-2 py-1 font-weight-bold" style="border: 1px solid #cbd5e1; font-family: monospace; font-size: 0.85rem;">
                                #{{ $ticket->ticket_id }}
                            </span>
                        </td>
                        <td class="py-3 px-3">
                            <div class="small text-dark font-weight-bold">
                                <i class="fa-regular fa-calendar-plus text-primary mr-1"></i>Raised: {{ \Carbon\Carbon::parse($ticket->created_at)->format('d M, Y - h:i A') }}
                            </div>
                            @if (!empty($ticket->partner_problem_reply))
                                <div class="small text-success mt-1">
                                    <i class="fa-solid fa-check-double mr-1"></i>Replied: {{ \Carbon\Carbon::parse($ticket->updated_at)->format('d M, Y - h:i A') }}
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if (!empty($ticket->partner_problem_reply))
                                <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 6px;">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Resolved
                                </span>
                            @else
                                <span class="badge badge-warning px-2 py-1 font-weight-bold" style="background: #fef3c7; color: #b45309; border-radius: 6px;">
                                    <i class="fa-solid fa-clock mr-1"></i> In Review
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myTicketViewModal{{ $ticket->id }}" data-toggle="modal" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
                                <i class="fa-solid fa-eye mr-1"></i> View Issue
                            </button>
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if (!empty($ticket->partner_problem_reply))
                                <button type="button" data-target="#myReplyViewModal{{ $ticket->id }}" data-toggle="modal" class="btn btn-sm btn-outline-success font-weight-bold" style="border-radius: 6px;">
                                    <i class="fa-solid fa-reply mr-1"></i> Read Reply
                                </button>
                            @else
                                <span class="text-muted small">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-ticket-simple fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Support Tickets Raised</h5>
                            <p class="text-muted small mb-0">If you ever need technical help or have billing inquiries, click "Open New Ticket" above.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="table-pagination-footer">
        <div class="text-muted small mb-2 mb-md-0 font-weight-bold">
            Showing {{ $inquiries->firstItem() ?? 0 }} to {{ $inquiries->lastItem() ?? 0 }} of {{ $inquiries->total() }} tickets
        </div>
        <div>{{ $inquiries->links('pagination::bootstrap-4') }}</div>
    </div>
</div>

<!-- Ticket Modals -->
@foreach ($inquiries as $ticket)
<div class="modal fade" id="myTicketViewModal{{ $ticket->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-ticket text-primary mr-2"></i>Ticket #{{ $ticket->ticket_id }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="small text-muted font-weight-bold mb-2">SUBMITTED PROBLEM</div>
                <div class="p-3 rounded text-dark" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 0.95rem; line-height: 1.6;">
                    {{ $ticket->partner_problem }}
                </div>
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@if (!empty($ticket->partner_problem_reply))
<div class="modal fade" id="myReplyViewModal{{ $ticket->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-reply text-success mr-2"></i>Doctorwala Support Response
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="small text-muted font-weight-bold mb-2">RESPONSE FOR TICKET #{{ $ticket->ticket_id }}</div>
                <div class="p-3 rounded text-dark" style="background: #f0fdf4; border: 1px solid #bbf7d0; font-size: 0.95rem; line-height: 1.6;">
                    {{ $ticket->partner_problem_reply }}
                </div>
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection
