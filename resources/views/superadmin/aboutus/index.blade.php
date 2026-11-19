@extends('layouts.superadmin')

@section('title', 'About Us Management | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-circle-info text-primary mr-2"></i>About Doctorwala CMS
            </h3>
            <p class="text-muted mb-0">Manage company introduction, mission, vision, and corporate contact details shown on public portals.</p>
        </div>
        <div class="mt-2 mt-md-0">
            @if(!$hasAboutData)
            <button type="button" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;" data-toggle="modal" data-target="#myAddModal">
                <i class="fa-solid fa-plus mr-1"></i> Add About Details
            </button>
            @endif
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-file-lines text-primary mr-2"></i>About Us Content
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Cover Image</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Company & Contact Info</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Sections</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abouts as $about)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">{{ $loop->iteration }}</td>
                        <td class="py-3 px-3">
                            @if($about->about_image)
                                <img src="{{ asset('storage/' . $about->about_image) }}" alt="About" style="width: 120px; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 120px; height: 75px; border: 1px solid #e2e8f0;">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-3">
                            <h6 class="font-weight-bold text-dark mb-1">{{ $about->ab_title }}</h6>
                            <div class="text-primary font-weight-bold small mb-1">{{ $about->ab_b_txt }}</div>
                            <div class="small text-muted"><i class="fa-solid fa-phone mr-1 text-success"></i>{{ $about->number }}</div>
                            <div class="small text-muted"><i class="fa-solid fa-envelope mr-1 text-primary"></i>{{ $about->email }}</div>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <div class="d-flex justify-content-center" style="gap: 8px;">
                                <button type="button" data-target="#myDescModal{{ $about->id }}" data-toggle="modal" class="btn btn-sm btn-outline-info" style="border-radius: 6px;" title="View Description">
                                    <i class="fa-solid fa-paragraph mr-1"></i> Story
                                </button>
                                <button type="button" data-target="#myMissionModal{{ $about->id }}" data-toggle="modal" class="btn btn-sm btn-outline-success" style="border-radius: 6px;" title="View Mission">
                                    <i class="fa-solid fa-bullseye mr-1"></i> Mission
                                </button>
                                <button type="button" data-target="#myVisionModal{{ $about->id }}" data-toggle="modal" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;" title="View Vision">
                                    <i class="fa-solid fa-eye mr-1"></i> Vision
                                </button>
                            </div>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <div class="d-flex justify-content-center" style="gap: 8px;">
                                <button type="button" data-target="#myEditModal{{ $about->id }}" data-toggle="modal" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; padding: 4px 8px;" title="Edit About Us">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="button" data-target="#myDeleteModal{{ $about->id }}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-circle-info fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No About Us Content Created</h5>
                            <p class="text-muted small mb-0">Click the "Add About Details" button above to initialize company profile.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myAddModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-plus-circle text-primary mr-2"></i>Create About Us Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.super-aboutus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-image text-primary mr-1"></i> Cover Image</label>
                            <input type="file" class="form-control" name="about_image" accept="image/*" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-heading text-primary mr-1"></i> Section Title</label>
                            <input type="text" class="form-control" name="ab_title" placeholder="e.g. Revolutionizing Healthcare" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-bolt text-primary mr-1"></i> Bold Subtitle / Highlight</label>
                            <input type="text" class="form-control" name="ab_b_txt" placeholder="e.g. 24/7 Digital Health" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-phone text-primary mr-1"></i> Helpline Number</label>
                            <input type="text" class="form-control" name="number" placeholder="e.g. +91 9876543210" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-envelope text-primary mr-1"></i> Support Email</label>
                            <input type="email" class="form-control" name="email" placeholder="e.g. support@doctorwala.info" style="border-radius: 8px;">
                        </div>
                        <div class="col-12 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-file-lines text-primary mr-1"></i> Company Story / Description</label>
                            <textarea name="ab_desc" class="form-control" rows="4" placeholder="Overview of Doctorwala and what problems it solves..." style="border-radius: 8px;"></textarea>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-bullseye text-success mr-1"></i> Mission Statement</label>
                            <textarea name="ab_mission" class="form-control" rows="4" placeholder="Our purpose and mission..." style="border-radius: 8px;"></textarea>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-eye text-primary mr-1"></i> Vision Statement</label>
                            <textarea name="ab_vision" class="form-control" rows="4" placeholder="Future goals and aspirations..." style="border-radius: 8px;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 14px 14px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-save mr-1"></i> Save Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach($abouts as $about)
<div class="modal fade" id="myEditModal{{ $about->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-pen-to-square text-primary mr-2"></i>Edit About Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.super-aboutus.update', $about->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    @if($about->about_image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $about->about_image) }}" alt="Cover" style="max-height: 160px; width: auto; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="small text-muted mt-1">Current Cover Image</div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-image text-primary mr-1"></i> Replace Image</label>
                            <input type="file" class="form-control" name="about_image" accept="image/*" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-heading text-primary mr-1"></i> Section Title</label>
                            <input type="text" class="form-control" name="ab_title" value="{{ $about->ab_title }}" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-bolt text-primary mr-1"></i> Bold Subtitle / Highlight</label>
                            <input type="text" class="form-control" name="ab_b_txt" value="{{ $about->ab_b_txt }}" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-phone text-primary mr-1"></i> Helpline Number</label>
                            <input type="text" class="form-control" name="number" value="{{ $about->number }}" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-envelope text-primary mr-1"></i> Support Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $about->email }}" style="border-radius: 8px;">
                        </div>
                        <div class="col-12 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-file-lines text-primary mr-1"></i> Company Story / Description</label>
                            <textarea name="ab_desc" class="form-control" rows="4" style="border-radius: 8px;">{{ $about->ab_desc }}</textarea>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-bullseye text-success mr-1"></i> Mission Statement</label>
                            <textarea name="ab_mission" class="form-control" rows="4" style="border-radius: 8px;">{{ $about->ab_mission }}</textarea>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-eye text-primary mr-1"></i> Vision Statement</label>
                            <textarea name="ab_vision" class="form-control" rows="4" style="border-radius: 8px;">{{ $about->ab_vision }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 14px 14px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold" style="border-radius: 8px;">
                        <i class="fa-solid fa-check mr-1"></i> Update Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- View Description Modals -->
@foreach($abouts as $about)
<div class="modal fade" id="myDescModal{{ $about->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-paragraph text-primary mr-2"></i>Company Story & Description
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" style="line-height: 1.7; color: #334155;">
                {{ $about->ab_desc }}
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- View Mission Modals -->
@foreach($abouts as $about)
<div class="modal fade" id="myMissionModal{{ $about->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-bullseye text-success mr-2"></i>Mission Statement
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" style="line-height: 1.7; color: #334155;">
                {{ $about->ab_mission }}
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- View Vision Modals -->
@foreach($abouts as $about)
<div class="modal fade" id="myVisionModal{{ $about->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-eye text-primary mr-2"></i>Vision Statement
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" style="line-height: 1.7; color: #334155;">
                {{ $about->ab_vision }}
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Delete Modals -->
@foreach($abouts as $about)
<div class="modal fade" id="myDeleteModal{{ $about->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ route('superadmin.super-aboutus.delete', $about->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                    </div>
                    <h4 class="font-weight-bold text-dark">Delete About Us Entry?</h4>
                    <p class="text-muted mb-4">Are you sure you want to remove the About Us configuration? This cannot be undone.</p>
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
