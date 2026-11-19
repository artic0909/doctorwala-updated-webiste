@extends('layouts.superadmin')

@section('title', 'Ticket Replies & History | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-clock-rotate-left text-success mr-2"></i>Replied Tickets History
            </h3>
            <p class="text-muted mb-0">Review resolved support communications and partner responses.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('superadmin.super-all-tickets') }}" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to Open Tickets
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            Resolved / Replied Tickets
            <span class="badge badge-success ml-2">{{ $repliedTickets->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 100px;">Ticket ID</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Timestamps</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Partner Clinic</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Contact Person</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Partner Issue</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Admin Reply</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($repliedTickets as $ticket)
                    <tr>
                        <td class="py-3 px-3">
                            <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 6px; font-family: monospace;">
                                {{ $ticket->ticket_id }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-muted small">
                            <div><i class="fa-regular fa-clock mr-1"></i> Raised: {{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y') }}</div>
                            <div class="text-success font-weight-bold"><i class="fa-solid fa-check-double mr-1"></i> Replied: {{ \Carbon\Carbon::parse($ticket->updated_at)->format('d M Y') }}</div>
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $ticket->partner_clinic_name }}
                        </td>
                        <td class="py-3 px-3">
                            <div class="font-weight-bold text-dark">{{ $ticket->partner_contact_person_name }}</div>
                            <div class="text-muted small"><i class="fa-solid fa-phone mr-1"></i>{{ $ticket->partner_mobile_number }}</div>
                        </td>
                        <td class="py-3 px-3 text-muted">
                            <div style="max-width: 200px; line-height: 1.4;">{{ Str::limit($ticket->partner_problem, 70) }}</div>
                        </td>
                        <td class="py-3 px-3">
                            <div class="text-dark font-weight-500" style="max-width: 240px; line-height: 1.4;">{{ Str::limit($ticket->partner_problem_reply, 80) }}</div>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myDeleteModal{{$ticket->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Ticket">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-ticket fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Replied Tickets Found</h5>
                            <p class="text-muted small mb-0">Tickets that you have resolved and replied to will appear here.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($repliedTickets->hasPages())
    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <span class="text-muted small">Showing {{ $repliedTickets->firstItem() }} to {{ $repliedTickets->lastItem() }} of {{ $repliedTickets->total() }} entries</span>
        <div>{{ $repliedTickets->links('pagination::bootstrap-4') }}</div>
    </div>
    @endif
</div>

<!-- Delete Modals -->
@foreach($repliedTickets as $ticket)
<div class="modal fade" id="myDeleteModal{{$ticket->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ url('/superadmin/super-ticket-replies/delete/' . $ticket->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 text-dark">Delete Ticket Record?</h4>
                    <p class="text-muted mb-4">Are you sure you want to permanently delete Ticket <strong>#{{ $ticket->ticket_id }}</strong>?</p>
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
