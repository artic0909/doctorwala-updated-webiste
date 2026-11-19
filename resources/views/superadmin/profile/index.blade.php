@extends('layouts.superadmin')

@section('title', 'Admin Profile & Security | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-user-gear text-primary mr-2"></i>Admin Profile & Security
            </h3>
            <p class="text-muted mb-0">Manage your administrative credentials, official email address, and account password.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/superadmin/super-dashboard" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-chart-pie mr-1"></i> Go to Dashboard
            </a>
        </div>
    </div>
</div>

{{-- Top Profile Summary Banner --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: #ffffff;">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 72px; height: 72px; background: #e0f2fe; color: #0284c7; border: 3px solid #bae6fd;">
                    <i class="fa-solid fa-user-shield fa-2x"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                        <h4 class="font-weight-bold text-dark mb-0">{{ $user->name }}</h4>
                        <span class="badge badge-primary px-2 py-1 font-weight-bold" style="background: #e0f2fe; color: #0369a1; border-radius: 6px; font-size: 0.75rem;">
                            <i class="fa-solid fa-crown text-warning mr-1"></i> Super Admin
                        </span>
                    </div>
                    <div class="text-muted small mt-1">
                        <i class="fa-solid fa-envelope mr-1 text-primary"></i> {{ $user->email }}
                        <span class="mx-2">&bull;</span>
                        <i class="fa-regular fa-clock mr-1 text-muted"></i> Account Created: {{ $user->created_at ? $user->created_at->format('d M, Y') : 'N/A' }}
                    </div>
                </div>
            </div>

            <div class="mt-3 mt-md-0">
                <span class="badge badge-light px-3 py-2 text-muted font-weight-bold" style="border: 1px solid #e2e8f0; border-radius: 8px;">
                    <i class="fa-solid fa-shield-halved text-success mr-1"></i> Two-Step Security Ready
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Card 1: Account Information --}}
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fa-solid fa-address-card text-primary mr-2"></i>Account Information
                </h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('superadmin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-user text-primary mr-1"></i> Administrator Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" style="height: 48px; border-radius: 8px;" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-envelope text-primary mr-1"></i> Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" style="height: 48px; border-radius: 8px;" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted mt-1 d-block">Used for login, system alerts, and critical admin notifications.</small>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-2 border-top">
                        <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2 shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                            <i class="fa-solid fa-check mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Card 2: Security & Password --}}
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fa-solid fa-lock text-primary mr-2"></i>Change Password
                </h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('superadmin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-key text-muted mr-1"></i> Current Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Enter current active password" style="height: 48px; border-radius: 8px;" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-shield-halved text-primary mr-1"></i> New Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 characters" style="height: 48px; border-radius: 8px;" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-check-double text-success mr-1"></i> Confirm New Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type new password" style="height: 48px; border-radius: 8px;" required>
                    </div>

                    <div class="p-3 mb-4 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <span class="small font-weight-bold text-muted text-uppercase d-block mb-1" style="font-size: 0.72rem;">Security Recommendations</span>
                        <ul class="small text-muted pl-3 mb-0" style="line-height: 1.5;">
                            <li>Use at least 8 characters with a mix of letters and numbers.</li>
                            <li>Avoid reusing passwords from personal or external accounts.</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-2 border-top">
                        <button type="submit" class="btn btn-danger font-weight-bold px-4 py-2 shadow-sm" style="border-radius: 8px;">
                            <i class="fa-solid fa-lock mr-1"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
