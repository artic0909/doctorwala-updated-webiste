@extends('layouts.superadmin')

@section('title', 'General User Inquiries | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-headset text-primary mr-2"></i>General User Inquiries
            </h3>
            <p class="text-muted mb-0">Review incoming questions, support requests, and contact submissions from patients.</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            Inquiry Messages
            <span class="badge badge-secondary ml-2">{{ $inquiries->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 60px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">User Name</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Email</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Subject</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Inquiry Message</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $item)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ $inquiries->firstItem() + $loop->index }}
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $item->name }}
                        </td>
                        <td class="py-3 px-3">
                            <a href="mailto:{{ $item->email }}" class="text-primary"><i class="fa-solid fa-envelope mr-1"></i>{{ $item->email }}</a>
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $item->subject ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3 text-muted">
                            <div style="line-height: 1.4; max-width: 380px;">{{ $item->msg ?? $item->inquiry }}</div>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myDeleteModal{{$item->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Inquiry">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Inquiries Found</h5>
                            <p class="text-muted small mb-0">There are no pending user support inquiries at this time.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($inquiries->hasPages())
    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <span class="text-muted small">Showing {{ $inquiries->firstItem() }} to {{ $inquiries->lastItem() }} of {{ $inquiries->total() }} entries</span>
        <div>{{ $inquiries->links('pagination::bootstrap-4') }}</div>
    </div>
    @endif
</div>

<!-- Delete Modals -->
@foreach($inquiries as $item)
<div class="modal fade" id="myDeleteModal{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ url('/superadmin/super-user-inquiry/delete/' . $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 text-dark">Delete Inquiry?</h4>
                    <p class="text-muted mb-4">Are you sure you want to remove this message from <strong>{{ $item->name }}</strong>?</p>
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
