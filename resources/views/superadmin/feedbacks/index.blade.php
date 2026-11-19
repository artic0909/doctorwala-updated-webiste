@extends('layouts.superadmin')

@section('title', 'Patient Feedbacks | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-star-half-stroke text-primary mr-2"></i>Patient & Partner Feedbacks
            </h3>
            <p class="text-muted mb-0">Review service ratings, patient satisfaction comments, and provider experience reviews.</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-comments text-primary mr-2"></i>All Feedbacks
            <span class="badge badge-secondary ml-2">{{ $feedbacks->total() }}</span>
        </h5>
        <div class="mt-2 mt-md-0">
            {{ $feedbacks->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Clinic Type</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Clinic Name</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">User Name</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">User Email</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Rating</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Feedback</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ $loop->iteration + ($feedbacks->currentPage() - 1) * $feedbacks->perPage() }}
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-info text-capitalize px-2 py-1 font-weight-bold" style="background: #e0f2fe; color: #0369a1; border-radius: 6px;">
                                {{ $feedback->clinic_type }}
                            </span>
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark text-capitalize">
                            {{ $feedback->clinic_name }}
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark text-capitalize">
                            <i class="fa-solid fa-user-circle text-muted mr-1"></i>{{ $feedback->user_name }}
                        </td>
                        <td class="py-3 px-3 text-muted">
                            <i class="fa-solid fa-envelope mr-1 text-primary"></i>{{ $feedback->user_email }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <span class="badge px-2 py-1 font-weight-bold" style="background: #fef3c7; color: #b45309; border-radius: 6px;">
                                <i class="fa-solid fa-star text-warning mr-1"></i>{{ $feedback->rating }}/5
                            </span>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myInquiryModal{{ $feedback->id }}" data-toggle="modal" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;" title="View Feedback">
                                <i class="fa-solid fa-comment-dots mr-1"></i> Read
                            </button>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myDeleteModal{{ $feedback->id }}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Feedback">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fa-regular fa-star fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Feedbacks Found</h5>
                            <p class="text-muted small mb-0">Patient reviews and clinic feedbacks will appear here once submitted.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($feedbacks->hasPages())
    <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
        {{ $feedbacks->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

<!-- View Feedback Modals -->
@foreach ($feedbacks as $feedback)
<div class="modal fade" id="myInquiryModal{{ $feedback->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-comment-dots text-primary mr-2"></i>Feedback from {{ $feedback->user_name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3 d-flex align-items-center justify-content-between p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div>
                        <div class="small text-muted font-weight-bold">CLINIC / PROVIDER</div>
                        <div class="font-weight-bold text-dark text-capitalize">{{ $feedback->clinic_name }} ({{ $feedback->clinic_type }})</div>
                    </div>
                    <div>
                        <span class="badge px-3 py-2 font-weight-bold" style="background: #fef3c7; color: #b45309; border-radius: 6px; font-size: 0.9rem;">
                            <i class="fa-solid fa-star text-warning mr-1"></i>{{ $feedback->rating }} / 5
                        </span>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="font-weight-bold text-muted small text-uppercase">Feedback Message</label>
                    <div class="p-3 rounded text-dark" style="background: #ffffff; border: 1px solid #cbd5e1; font-size: 0.95rem; line-height: 1.6;">
                        {{ $feedback->feedback }}
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Delete Modals -->
@foreach ($feedbacks as $feedback)
<div class="modal fade" id="myDeleteModal{{ $feedback->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ route('superadmin.feedback.delete', $feedback->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                    </div>
                    <h4 class="font-weight-bold text-dark">Delete Feedback?</h4>
                    <p class="text-muted mb-4">Are you sure you want to delete this feedback from <b>{{ $feedback->user_name }}</b>? This action cannot be undone.</p>
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
