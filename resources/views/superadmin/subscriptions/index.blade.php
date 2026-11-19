@extends('layouts.superadmin')

@section('title', 'Subscription Plans | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-shield-halved text-primary mr-2"></i>Subscription Plans
            </h3>
            <p class="text-muted mb-0">Manage partner membership plans, toggle status, and inspect included features.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('superadmin.super-subs.index') }}" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                <i class="fa-solid fa-plus mr-1"></i> Add New Plan
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            All Subscription Plans
            <span class="badge badge-secondary ml-2">{{ count($subscriptions) }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 60px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Plan Badge / Image</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Title</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Amount</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Opening Date</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Validity / Closing</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Features</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Status</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ $loop->iteration }}
                        </td>
                        <td class="py-3 px-3">
                            @if($sub->subs_image)
                            <img src="{{ asset('storage/' . $sub->subs_image) }}" alt="Plan Badge"
                                 style="width: 90px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                            @else
                            <div class="rounded d-flex align-items-center justify-content-center bg-light text-muted" style="width: 90px; height: 50px;">
                                <i class="fa-solid fa-image"></i>
                            </div>
                            @endif
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $sub->subs_title }}
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-success" style="font-size: 1rem;">
                            ₹ {{ number_format($sub->subs_amount, 2) }}
                        </td>
                        <td class="py-3 px-3 text-muted">
                            <i class="fa-solid fa-calendar-check text-primary mr-1"></i> {{ $sub->subs_open_date ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-danger">
                            <i class="fa-solid fa-clock mr-1"></i> {{ $sub->subs_close_date ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myFeaturesModal{{$sub->id}}" data-toggle="modal" class="btn btn-sm btn-outline-info font-weight-bold" style="border-radius: 6px; padding: 4px 10px;">
                                <i class="fa-solid fa-list-check mr-1"></i> Features
                            </button>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myActiveInactiveModal{{$sub->id}}" data-toggle="modal" class="border-0 bg-transparent p-0" title="Click to change status">
                                @if(strtolower($sub->status) == 'active')
                                    <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 12px; border: 1px solid #bbf7d0;">
                                        <i class="fa fa-circle mr-1" style="font-size: 7px;"></i> Active
                                    </span>
                                @else
                                    <span class="badge badge-danger px-2 py-1 font-weight-bold" style="background: #fee2e2; color: #b91c1c; border-radius: 12px; border: 1px solid #fecaca;">
                                        <i class="fa fa-circle mr-1" style="font-size: 7px;"></i> Inactive
                                    </span>
                                @endif
                            </button>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myDeleteModal{{$sub->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 10px;" title="Delete Plan">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-shield-halved fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Subscription Plans Available</h5>
                            <p class="text-muted small">Click "Add New Plan" above to create subscription packages for partners.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Features Modals -->
@foreach($subscriptions as $sub)
<div class="modal fade" id="myFeaturesModal{{$sub->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-primary text-white" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa-solid fa-shield-halved mr-2"></i> {{ $sub->subs_title }} Features
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <ul class="list-group list-group-flush">
                    @if(is_array($sub->features) || $sub->features instanceof \Traversable)
                        @forelse($sub->features as $feature)
                        <li class="list-group-item d-flex align-items-center px-0 py-2 border-0">
                            <i class="fa-solid fa-circle-check text-success mr-2"></i>
                            <span class="font-weight-500 text-dark">{{ $feature }}</span>
                        </li>
                        @empty
                        <li class="list-group-item px-0 py-2 border-0 text-muted">No features added to this plan.</li>
                        @endforelse
                    @else
                        <li class="list-group-item px-0 py-2 border-0 text-muted">No features available.</li>
                    @endif
                </ul>
            </div>
            <div class="modal-footer bg-light" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Status Modals -->
<div class="modal fade" id="myActiveInactiveModal{{$sub->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-toggle-on text-primary mr-2"></i> Change Plan Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadmin.super-subs.update.status', $sub->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">Update visibility status for <strong>{{ $sub->subs_title }}</strong>:</p>
                    <div class="form-group mb-0">
                        <select name="status" class="form-control" style="border-radius: 8px;" required>
                            <option value="Active" {{ strtolower($sub->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ strtolower($sub->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px;">Save Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modals -->
<div class="modal fade" id="myDeleteModal{{$sub->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ route('superadmin.super-subs.delete', $sub->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 text-dark">Delete Subscription Plan?</h4>
                    <p class="text-muted mb-4">Are you sure you want to delete <strong>{{ $sub->subs_title }}</strong>? This action cannot be undone.</p>
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
