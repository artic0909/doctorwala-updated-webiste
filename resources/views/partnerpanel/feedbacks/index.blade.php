@extends('layouts.partner')

@section('title', 'Patient Reviews | Partner Panel')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-star-half-stroke text-primary mr-2"></i>Patient Reviews & Ratings
            </h3>
            <p class="text-muted mb-0">Patient experience reviews and satisfaction scores submitted for your clinic services.</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-comments text-primary mr-2"></i>Patient Feedback Entries
            <span class="badge badge-secondary ml-2">{{ count($patientFeedbacks) }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Patient Name</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Patient Email</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 130px;">Score</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 120px;">Review</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patientFeedbacks as $pf)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">{{ $loop->iteration }}</td>
                        <td class="py-3 px-3 font-weight-bold text-dark text-capitalize">
                            <i class="fa-solid fa-user-circle text-muted mr-1"></i>{{ $pf->user_name }}
                        </td>
                        <td class="py-3 px-3 text-muted">
                            <i class="fa-solid fa-envelope mr-1 text-primary"></i>{{ $pf->user_email }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <span class="badge px-2 py-1 font-weight-bold" style="background: #fef3c7; color: #b45309; border-radius: 6px;">
                                <i class="fa-solid fa-star text-warning mr-1"></i>{{ $pf->rating }} / 5
                            </span>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myFeedbackShowModal{{ $pf->id }}" data-toggle="modal" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
                                <i class="fa-solid fa-comment-dots mr-1"></i> Read
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-regular fa-star fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Reviews Yet</h5>
                            <p class="text-muted small mb-0">Ratings and reviews from patients will show up here as they visit your clinic.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Feedback Modals -->
@foreach($patientFeedbacks as $pf)
<div class="modal fade" id="myFeedbackShowModal{{ $pf->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-heart text-danger mr-2"></i>Review from {{ $pf->user_name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div class="font-weight-bold text-dark">{{ $pf->user_name }}</div>
                    <span class="badge px-3 py-2 font-weight-bold" style="background: #fef3c7; color: #b45309; border-radius: 6px; font-size: 0.9rem;">
                        <i class="fa-solid fa-star text-warning mr-1"></i>{{ $pf->rating }} / 5
                    </span>
                </div>
                <div class="p-3 rounded text-dark" style="background: #ffffff; border: 1px solid #cbd5e1; font-size: 0.95rem; line-height: 1.6;">
                    {{ $pf->feedback }}
                </div>
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
