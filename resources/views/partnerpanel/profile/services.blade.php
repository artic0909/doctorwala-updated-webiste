@extends('layouts.partner')

@section('title', 'Clinic Services | Partner Panel')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-notes-medical text-primary mr-2"></i>Offered Healthcare Services
            </h3>
            <p class="text-muted mb-0">List specific services and facilities available at your clinic (e.g., 24/7 Pharmacy, Ambulance, ECG, ICU, Day Care).</p>
        </div>
    </div>
</div>

<!-- Add Service Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-body p-4">
        <h5 class="font-weight-bold text-dark mb-3">
            <i class="fa-solid fa-plus-circle text-primary mr-2"></i>Add New Service / Facility
        </h5>
        <form action="{{ route('partner.services.store') }}" method="POST" class="form-row align-items-center">
            @csrf
            <div class="col-md-9 mb-2 mb-md-0">
                <input type="text" class="form-control" name="service" id="service" placeholder="Enter service title (e.g. 24x7 Emergency, Ambulance, Oxygen Support, ECG)..." style="height: 48px; border-radius: 8px;" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm" style="height: 48px; border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-plus mr-1"></i> Add Service
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Services Grid -->
<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-list-check text-primary mr-2"></i>Active Clinic Services
            <span class="badge badge-secondary ml-2">{{ count($services) }}</span>
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="row">
            @forelse($services as $index => $service)
            <div class="col-md-4 mb-3">
                <div class="card border h-100 shadow-none" style="border-radius: 10px; border-color: #e2e8f0 !important; background: #f8fafc;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; background: #e0f2fe; color: #0284c7;">
                                <i class="fa-solid fa-stethoscope"></i>
                            </div>
                            <span class="font-weight-bold text-dark text-capitalize" style="font-size: 0.95rem;">{{ $service }}</span>
                        </div>
                        <div class="d-flex" style="gap: 6px;">
                            <button type="button" data-toggle="modal" data-target="#editServiceModal{{ $index }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; padding: 4px 8px;" title="Edit Service">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteServiceModal{{ $index }}" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Service">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editServiceModal{{ $index }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
                        <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                            <h5 class="modal-title font-weight-bold text-dark">
                                <i class="fa-solid fa-pen-to-square text-primary mr-2"></i>Edit Service Name
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('partner.services.update', $index) }}" method="POST">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark">Service Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="service" value="{{ $service }}" style="height: 48px; border-radius: 8px;" required>
                                </div>
                            </div>
                            <div class="modal-footer bg-light" style="border-radius: 0 0 14px 14px;">
                                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteServiceModal{{ $index }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
                        <div class="modal-body text-center p-4">
                            <div class="mb-3">
                                <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                            </div>
                            <h4 class="font-weight-bold text-dark">Remove Service?</h4>
                            <p class="text-muted mb-4">Are you sure you want to delete <b>"{{ $service }}"</b> from your clinic profile?</p>
                            <form action="{{ route('partner.services.delete', $index) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="d-flex justify-content-center" style="gap: 12px;">
                                    <button type="button" class="btn btn-light px-4 font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger px-4 font-weight-bold" style="border-radius: 8px;">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fa-solid fa-notes-medical fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                <h5 class="text-muted font-weight-bold">No Services Added Yet</h5>
                <p class="text-muted small mb-0">Use the form above to add healthcare services your clinic provides.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
