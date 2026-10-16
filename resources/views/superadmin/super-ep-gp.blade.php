<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Super | EP & GP Management</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('../partner-assets')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('../partner-assets/css/vertical-layout-light/style.css')}}">

    <link href="{{asset('fav5.png')}}" rel="icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .role-badge-ep {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff !important;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            display: inline-block;
        }
        .role-badge-gp {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: #fff !important;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            display: inline-block;
        }
        .status-badge-active {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
            padding: 4px 10px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .status-badge-inactive {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
            padding: 4px 10px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .code-pill {
            background-color: #f3f4f6;
            color: #1f2937;
            font-family: monospace;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px dashed #cbd5e1;
            font-size: 0.85rem;
        }
        .kpi-card {
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        .floating-btnn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px !important;
            height: 56px !important;
            border-radius: 50% !important;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
            z-index: 999;
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="/superadmin/super-dashboard" style="font-weight: 900;"><img
                        src="{{asset('../img/logo3.png')}}" alt="logo"></a>
                <a class="navbar-brand brand-logo-mini" href="/superadmin/super-dashboard"><img src="{{asset('fav5.png')}}"
                        alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <form method="GET" action="{{ route('superadmin.super-ep-gp') }}" class="d-flex w-100 align-items-center ml-3">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search by Name, Code, or Mobile..." class="form-control mr-2 w-100">
                    <button type="submit" class="btn btn-primary" style="height: 38px; white-space: nowrap;">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="{{asset('fav5.png')}}" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="ti-power-off text-primary"></i>
                                    Logout
                                </a>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <!-- dashboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-dashboard">
                            <i class="fa-solid fa-chart-pie"></i>&nbsp; <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <!-- banners -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                            aria-controls="ui-basic">
                            <i class="fa fa-image" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Banners</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-home-banner">Home Banner</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-others-banner">Others Banner</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-partner-carousel">Partner Carousel</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- all user lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-user">
                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp; <span class="menu-title">All User</span>
                        </a>
                    </li>

                    <!-- referrals -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-reffer">
                            <i class="fa fa-gift" aria-hidden="true"></i>&nbsp; <span class="menu-title">Referrals</span>
                        </a>
                    </li>

                    <!-- EP & GP (Active) -->
                    <li class="nav-item active">
                        <a class="nav-link" href="/superadmin/super-ep-gp" style="background: #eef2ff; color: #4b49ac; font-weight: bold;">
                            <i class="fa-solid fa-address-card"></i>&nbsp; <span class="menu-title">EP & GP</span>
                        </a>
                    </li>

                    <!-- all partners lists -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic12t" aria-expanded="false"
                            aria-controls="ui-basic12t">
                            <i class="fa fa-users" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Partners</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic12t">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-add-partners">Add Partners</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-all-partner">All Partners</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- all OPD lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-opd">
                            <i class="fa fa-user-doctor" aria-hidden="true"></i>&nbsp; <span class="menu-title">All OPD</span>
                        </a>
                    </li>

                    <!-- all pathology lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-pathology">
                            <i class="fa fa-syringe" aria-hidden="true"></i>&nbsp; <span class="menu-title">All Pathology</span>
                        </a>
                    </li>

                    <!-- all doctor lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-doctors">
                            <i class="fa fa-stethoscope" aria-hidden="true"></i>&nbsp; <span class="menu-title">All Doctors</span>
                        </a>
                    </li>

                    <!-- about us -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-aboutus">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; <span class="menu-title">About Us</span>
                        </a>
                    </li>

                    <!-- blogs -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-blogs">
                            <i class="fa fa-blog" aria-hidden="true"></i>&nbsp; <span class="menu-title">Add Blogs</span>
                        </a>
                    </li>

                    <!-- user inquiry -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-user-inquiry">
                            <i class="fa-solid fa-comment"></i>&nbsp; <span class="menu-title">User Inquiry</span>
                        </a>
                    </li>

                    <!-- coupon -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic12" aria-expanded="false"
                            aria-controls="ui-basic12">
                            <i class="fa fa-gifts" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Coupons</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic12">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-add-coupons">Add Coupons</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-show-coupons">Show Coupons</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- subscription -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic123" aria-expanded="false"
                            aria-controls="ui-basic123">
                            <i class="fa fa-coins" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Subscription</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic123">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-add-subscriptions">Add Subscriptions</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-show-subscription">Show Subscriptions</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Inquiry from patients/user -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic132" aria-expanded="false"
                            aria-controls="ui-basic132">
                            <i class="fa fa-hand-holding-medical" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Inquiries</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic132">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-opd-inquiry">All OPD Inq</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-path-inquiry">All Path Inq</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-doc-inquiry">All Doc Inq</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Ticket management -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic111" aria-expanded="false"
                            aria-controls="ui-basic111">
                            <i class="fa-solid fa-ticket"></i>&nbsp; <span class="menu-title">Tickets</span><i
                                class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic111">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-all-tickets">All Tickets</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/superadmin/super-ticket-replies">Replies</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- Header Title & Action -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                        <div>
                            <h3 class="font-weight-bold mb-1">EP & GP Management</h3>
                            <p class="text-muted mb-0">Create, view, update and manage Executive Partners (EP) and General Partners (GP)</p>
                        </div>
                        <button type="button" class="btn btn-primary btn-icon-text mt-2 mt-sm-0" data-toggle="modal" data-target="#addEpGpModal">
                            <i class="fa fa-plus mr-2"></i> Add New EP / GP
                        </button>
                    </div>

                    <!-- Alerts -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-exclamation-circle mr-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><i class="fa fa-triangle-exclamation mr-1"></i> Please check the form errors:</strong>
                            <ul class="mb-0 mt-2 pl-3">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- KPIs Row -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-sm-6 mb-3 stretch-card">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #4b49ac 0%, #3f3da0 100%); color: white;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; opacity: 0.9;">Total Members</p>
                                            <h2 class="mb-0 font-weight-bold" style="font-size: 2rem;">{{ $totalCount ?? 0 }}</h2>
                                        </div>
                                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-users fa-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3 stretch-card">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #7978e9 0%, #6867d4 100%); color: white;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; opacity: 0.9;">Total EP</p>
                                            <h2 class="mb-0 font-weight-bold" style="font-size: 2rem;">{{ $epCount ?? 0 }}</h2>
                                        </div>
                                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-briefcase fa-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3 stretch-card">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%); color: white;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; opacity: 0.9;">Total GP</p>
                                            <h2 class="mb-0 font-weight-bold" style="font-size: 2rem;">{{ $gpCount ?? 0 }}</h2>
                                        </div>
                                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-user-tie fa-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3 stretch-card">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #28a745 0%, #208738 100%); color: white;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; opacity: 0.9;">Active Members</p>
                                            <h2 class="mb-0 font-weight-bold" style="font-size: 2rem;">{{ $activeCount ?? 0 }}</h2>
                                        </div>
                                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-user-check fa-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters & Search Card -->
                    <div class="card mb-4" style="border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.04);">
                        <div class="card-body p-3 p-md-4">
                            <form method="GET" action="{{ route('superadmin.super-ep-gp') }}">
                                <div class="row align-items-end">
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <label class="small text-muted font-weight-bold">Search</label>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Search Name, Code, Mobile" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-2">
                                        <label class="small text-muted font-weight-bold">Role</label>
                                        <select name="role" class="form-control form-control-sm">
                                            <option value="">All Roles</option>
                                            <option value="EP" {{ request('role') == 'EP' ? 'selected' : '' }}>EP (Executive)</option>
                                            <option value="GP" {{ request('role') == 'GP' ? 'selected' : '' }}>GP (General)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-2">
                                        <label class="small text-muted font-weight-bold">Status</label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="">All Status</option>
                                            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <label class="small text-muted font-weight-bold">Date Range</label>
                                        <div class="d-flex">
                                            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control form-control-sm mr-1">
                                            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-2 d-flex">
                                        <button type="submit" class="btn btn-primary btn-sm btn-block mr-1" style="height: 38px;">
                                            <i class="fa fa-filter mr-1"></i> Filter
                                        </button>
                                        <a href="{{ route('superadmin.super-ep-gp') }}" class="btn btn-outline-secondary btn-sm" style="height: 38px; display: flex; align-items: center;" title="Reset Filters">
                                            <i class="fa fa-rotate-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Main Data Table Card -->
                    <div class="card" style="border-radius: 14px; box-shadow: 0 4px 14px rgba(0,0,0,0.05);">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                <h4 class="card-title mb-0">EP & GP Members List ({{ $records->total() }})</h4>
                                <div class="text-muted small">
                                    Showing {{ $records->firstItem() ?? 0 }} to {{ $records->lastItem() ?? 0 }} of {{ $records->total() }} entries
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Role</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Joined Date</th>
                                            <th class="text-center" style="width: 130px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($records as $index => $item)
                                            <tr>
                                                <td class="font-weight-bold text-muted">
                                                    {{ $records->firstItem() + $index }}
                                                </td>
                                                <td>
                                                    @if($item->role === 'EP')
                                                        <span class="role-badge-ep"><i class="fa-solid fa-briefcase mr-1"></i> EP</span>
                                                    @else
                                                        <span class="role-badge-gp"><i class="fa-solid fa-user-tie mr-1"></i> GP</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-2" style="width: 34px; height: 34px; border-radius: 50%; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                                        </div>
                                                        <span class="font-weight-bold">{{ $item->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="code-pill">
                                                        <i class="fa fa-hashtag text-muted mr-1"></i>{{ $item->code }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="tel:{{ $item->mobile }}" class="text-dark font-weight-bold" style="text-decoration: none;">
                                                        <i class="fa fa-phone text-primary mr-1"></i> {{ $item->mobile }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('superadmin.super-ep-gp.toggle-status', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-link p-0 text-decoration-none" title="Click to toggle status">
                                                            @if($item->status === 'Active')
                                                                <span class="status-badge-active"><i class="fa fa-circle text-success mr-1" style="font-size: 8px;"></i> Active</span>
                                                            @else
                                                                <span class="status-badge-inactive"><i class="fa fa-circle text-danger mr-1" style="font-size: 8px;"></i> Inactive</span>
                                                            @endif
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="text-muted small">
                                                    {{ $item->created_at ? $item->created_at->format('d M Y, h:i A') : 'N/A' }}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-inverse-primary btn-sm btn-icon mr-1"
                                                        data-toggle="modal" data-target="#editEpGpModal{{ $item->id }}" title="Edit Details">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-inverse-danger btn-sm btn-icon"
                                                        data-toggle="modal" data-target="#deleteEpGpModal{{ $item->id }}" title="Delete Record">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5">
                                                    <div class="py-4">
                                                        <i class="fa-solid fa-folder-open text-muted fa-3x mb-3" style="opacity: 0.5;"></i>
                                                        <h5 class="text-muted">No EP / GP records found</h5>
                                                        <p class="text-muted small">Try adjusting your search criteria or add a new EP / GP member.</p>
                                                        <button type="button" class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#addEpGpModal">
                                                            <i class="fa fa-plus mr-1"></i> Add Member
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($records->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                                    <div class="text-muted small mb-2 mb-md-0">
                                        Page {{ $records->currentPage() }} of {{ $records->lastPage() }}
                                    </div>
                                    <div>
                                        <ul class="pagination pagination-sm mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($records->onFirstPage())
                                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $records->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($records->links()->elements as $element)
                                                @if (is_string($element))
                                                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                                @endif

                                                @if (is_array($element))
                                                    @foreach ($element as $page => $url)
                                                        @if ($page == $records->currentPage())
                                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                                        @else
                                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($records->hasMorePages())
                                                <li class="page-item"><a class="page-link" href="{{ $records->nextPageUrl() }}" rel="next">&raquo;</a></li>
                                            @else
                                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>

                <!-- Floating Add Button -->
                <button type="button" class="btn btn-primary floating-btnn" data-toggle="modal" data-target="#addEpGpModal" title="Add New Member">
                    <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                </button>

                <!-- Add Modal -->
                <div class="modal fade" id="addEpGpModal" tabindex="-1" role="dialog" aria-labelledby="addEpGpModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title font-weight-bold" id="addEpGpModalLabel">
                                    <i class="fa fa-user-plus mr-2"></i> Add New EP / GP Member
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('superadmin.super-ep-gp.store') }}" method="POST">
                                @csrf
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-id-badge text-primary mr-1"></i> Role <span class="text-danger">*</span></label>
                                        <select class="form-control" name="role" required>
                                            <option value="">Select Role</option>
                                            <option value="EP" {{ old('role') == 'EP' ? 'selected' : '' }}>EP (Executive Partner)</option>
                                            <option value="GP" {{ old('role') == 'GP' ? 'selected' : '' }}>GP (General Partner)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-user text-primary mr-1"></i> Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="10-digit mobile number" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            <i class="fa fa-barcode text-primary mr-1"></i> Member Code 
                                            <small class="text-muted font-weight-normal">(Optional - auto-generated if left empty)</small>
                                        </label>
                                        <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="e.g. EP1001, GP2001 or leave empty">
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-toggle-on text-primary mr-1"></i> Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary rounded px-4 font-weight-bold">
                                        <i class="fa fa-check mr-1"></i> Save Member
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modals -->
                @foreach ($records as $item)
                <div class="modal fade" id="editEpGpModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editEpGpModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title font-weight-bold" id="editEpGpModalLabel{{ $item->id }}">
                                    <i class="fa fa-pen-to-square mr-2 text-warning"></i> Edit Member: {{ $item->name }}
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('superadmin.super-ep-gp.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-id-badge text-primary mr-1"></i> Role <span class="text-danger">*</span></label>
                                        <select class="form-control" name="role" required>
                                            <option value="EP" {{ $item->role == 'EP' ? 'selected' : '' }}>EP (Executive Partner)</option>
                                            <option value="GP" {{ $item->role == 'GP' ? 'selected' : '' }}>GP (General Partner)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-user text-primary mr-1"></i> Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $item->name) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="mobile" value="{{ old('mobile', $item->mobile) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-barcode text-primary mr-1"></i> Member Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="code" value="{{ old('code', $item->code) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-toggle-on text-primary mr-1"></i> Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="Active" {{ $item->status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $item->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success rounded px-4 font-weight-bold">
                                        <i class="fa fa-save mr-1"></i> Update Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Delete Modals -->
                @foreach ($records as $item)
                <div class="modal fade" id="deleteEpGpModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteEpGpModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            <form action="{{ route('superadmin.super-ep-gp.delete', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                                    </div>
                                    <h4 class="font-weight-bold mb-2">Delete Member?</h4>
                                    <p class="text-muted mb-3">
                                        Are you sure you want to delete <strong>{{ $item->name }}</strong> ({{ $item->role }} - {{ $item->code }})?
                                        <br><span class="text-danger small">This action cannot be undone.</span>
                                    </p>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary rounded px-4 mr-2" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger rounded px-4 font-weight-bold">
                                            <i class="fa fa-trash-can mr-1"></i> Confirm Delete
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024. <a
                                href="https://doctorwala.info/" target="_blank">Doctorwala.info</a> - All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Easy-To-Use & made with
                            <i class="ti-heart text-danger ml-1"></i></span>
                    </div>
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Developed by <a
                                href="https://github.com/artic0909" target="_blank">SaklinMustak</a></span>
                    </div>
                </footer>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{asset('../partner-assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('../partner-assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('../partner-assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('../partner-assets/js/template.js')}}"></script>
    <script src="{{asset('../partner-assets/js/settings.js')}}"></script>
    <script src="{{asset('../partner-assets/js/todolist.js')}}"></script>
</body>

</html>
