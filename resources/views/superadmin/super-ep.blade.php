<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Super | EP Management</title>

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

                <form method="GET" action="{{ route('superadmin.super-ep') }}" class="d-flex w-100 align-items-center ml-3">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search EP by Name, Code, or Mobile..." class="form-control mr-2 w-100">
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
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
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
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-home-banner">Home Banner</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-others-banner">Others Banner</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-partner-carousel">Partner Carousel</a></li>
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

                    <!-- EP Management (Active) -->
                    <li class="nav-item active">
                        <a class="nav-link" href="/superadmin/super-ep">
                            <i class="fa-solid fa-user-tie" aria-hidden="true"></i>&nbsp; <span class="menu-title">EP Management</span>
                        </a>
                    </li>

                    <!-- GP Management -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-gp">
                            <i class="fa-solid fa-users-gear" aria-hidden="true"></i>&nbsp; <span class="menu-title">GP Management</span>
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
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-add-partners">Add Partners</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-all-partner">All Partners</a></li>
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

                    <!-- blogs -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-blogs">
                            <i class="fa fa-blog" aria-hidden="true"></i>&nbsp; <span class="menu-title">Blogs</span>
                        </a>
                    </li>

                    <!-- coupons -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false"
                            aria-controls="ui-basic1">
                            <i class="fa fa-tag" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Coupons</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic1">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-add-coupons">Add Coupons</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-show-coupons">Show Coupons</a></li>
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
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-add-subscriptions">Add Subscriptions</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-show-subscription">Show Subscriptions</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Inquiries -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic132" aria-expanded="false"
                            aria-controls="ui-basic132">
                            <i class="fa fa-hand-holding-medical" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Inquiries</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic132">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-opd-inquiry">All OPD Inq</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-path-inquiry">All Path Inq</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-doc-inquiry">All Doc Inq</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Tickets -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic111" aria-expanded="false"
                            aria-controls="ui-basic111">
                            <i class="fa-solid fa-ticket"></i>&nbsp; <span class="menu-title">Tickets</span><i
                                class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic111">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-all-tickets">All Tickets</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-ticket-replies">Replies</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- main-panel -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- Alert messages -->
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert" style="border-radius: 10px;">
                        <i class="fa-solid fa-circle-check fa-lg mr-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 10px;">
                        <div class="d-flex align-items-center mb-1 font-weight-bold">
                            <i class="fa-solid fa-circle-exclamation fa-lg mr-2"></i>
                            Please check the following errors:
                        </div>
                        <ul class="mb-0 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <!-- Header & Quick Action -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                        <div>
                            <h3 class="font-weight-bold text-dark mb-1">
                                <i class="fa-solid fa-user-tie text-primary mr-2"></i>Executive Partner (EP) Management
                            </h3>
                            <p class="text-muted mb-0">Create, manage, and monitor all Executive Partners and their linked Gram Panchayats (GP).</p>
                        </div>
                        <div class="mt-2 mt-md-0 d-flex">
                            <a href="{{ route('superadmin.super-gp') }}" class="btn btn-outline-info mr-2 rounded font-weight-bold">
                                <i class="fa-solid fa-users-gear mr-1"></i> View All GPs
                            </a>
                            <button type="button" class="btn btn-primary rounded font-weight-bold shadow-sm" data-toggle="modal" data-target="#addEpModal">
                                <i class="fa fa-plus mr-1"></i> Add New EP
                            </button>
                        </div>
                    </div>

                    <!-- KPIs Row -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #392C70 0%, #4747A1 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Total EPs</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $totalCount ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-user-tie fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Active EPs</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $activeCount ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-user-check fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Inactive EPs</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $inactiveCount ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-user-xmark fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Total GPs Linked</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $totalGpsCount ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-users-gear fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Card -->
                    <div class="card mb-4 shadow-sm" style="border-radius: 12px; border: none;">
                        <div class="card-body py-3">
                            <form method="GET" action="{{ route('superadmin.super-ep') }}">
                                <div class="row align-items-end">
                                    <!-- Search -->
                                    <div class="col-lg-3 col-md-6 col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">
                                            <i class="fa fa-search text-muted mr-1"></i> Search Keywords
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="Name, Code, or Mobile..." value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-lg-3 col-md-6 col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">
                                            <i class="fa fa-toggle-on text-muted mr-1"></i> Status
                                        </label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="">All Statuses</option>
                                            <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <!-- From Date -->
                                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">
                                            <i class="fa fa-calendar text-muted mr-1"></i> From Date
                                        </label>
                                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control form-control-sm">
                                    </div>

                                    <!-- To Date -->
                                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">
                                            <i class="fa fa-calendar text-muted mr-1"></i> To Date
                                        </label>
                                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control form-control-sm">
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="col-lg-2 col-md-4 col-12 mb-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-sm px-3 mr-2 font-weight-bold rounded shadow-sm" style="min-width: 85px;">
                                            <i class="fa fa-filter mr-1"></i> Filter
                                        </button>
                                        <a href="{{ route('superadmin.super-ep') }}" class="btn btn-outline-secondary btn-sm px-3 font-weight-bold rounded" title="Clear Filters">
                                            <i class="fa fa-rotate-left mr-1"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Main Table Card -->
                    <div class="card shadow-sm" style="border-radius: 12px; border: none; overflow: hidden;">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap">
                            <h5 class="mb-0 font-weight-bold text-dark">
                                <i class="fa-solid fa-list-check text-primary mr-2"></i>Executive Partners List
                                <span class="badge badge-secondary ml-2">{{ $records->total() }}</span>
                            </h5>
                            <button type="button" class="btn btn-sm btn-success font-weight-bold rounded" data-toggle="modal" data-target="#addEpModal">
                                <i class="fa fa-user-plus mr-1"></i> Add EP
                            </button>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 60px;">#</th>
                                            <th>EP Code</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th class="text-center">Linked GPs</th>
                                            <th class="text-center">Status</th>
                                            <th>Registered At</th>
                                            <th class="text-center" style="width: 140px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($records as $index => $item)
                                        <tr>
                                            <td class="text-center text-muted font-weight-bold">
                                                {{ $records->firstItem() + $index }}
                                            </td>

                                            <td>
                                                <span class="code-pill">{{ $item->code }}</span>
                                            </td>

                                            <td>
                                                <span class="font-weight-bold text-dark">{{ $item->name }}</span>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-phone text-muted mr-1 small"></i>
                                                    <a href="tel:{{ $item->mobile }}" class="text-dark font-weight-500 mr-2">
                                                        {{ $item->mobile }}
                                                    </a>
                                                    <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $item->mobile) }}" target="_blank"
                                                        class="badge badge-success p-1" title="Chat on WhatsApp">
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('superadmin.super-gp', ['ep_id' => $item->id]) }}"
                                                   class="badge badge-info p-2 font-weight-bold"
                                                   title="Click to view GPs linked with this EP">
                                                    <i class="fa-solid fa-users-gear mr-1"></i> {{ $item->gps_count }} GPs
                                                </a>
                                            </td>

                                            <td class="text-center">
                                                <form action="{{ route('superadmin.super-ep.toggle-status', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="border-0 bg-transparent p-0" title="Click to toggle status">
                                                        @if ($item->status === 'Active')
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
                                                <button type="button" class="btn btn-inverse-primary btn-sm p-2 mr-1"
                                                    data-toggle="modal" data-target="#editEpModal{{ $item->id }}" title="Edit EP">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-inverse-danger btn-sm p-2"
                                                    data-toggle="modal" data-target="#deleteEpModal{{ $item->id }}" title="Delete EP">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="py-4">
                                                    <i class="fa-solid fa-user-slash fa-3x text-muted mb-3 d-block"></i>
                                                    <h5 class="text-muted font-weight-bold">No Executive Partners Found</h5>
                                                    <p class="text-muted small">Try modifying search filters or click "Add New EP" to create one.</p>
                                                    <button type="button" class="btn btn-primary btn-sm mt-2 rounded" data-toggle="modal" data-target="#addEpModal">
                                                        <i class="fa fa-plus mr-1"></i> Add First EP
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination Footer -->
                        @if ($records->hasPages())
                        <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap py-3">
                            <div class="small text-muted mb-2 mb-md-0">
                                Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of {{ $records->total() }} entries
                            </div>
                            <div>
                                {{ $records->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        @endif
                    </div>

                </div>

                <!-- Floating Add Button -->
                <button type="button" class="btn btn-primary floating-btnn" data-toggle="modal" data-target="#addEpModal" title="Add New EP">
                    <i class="fa fa-plus fa-lg"></i>
                </button>

                <!-- Add EP Modal -->
                <div class="modal fade" id="addEpModal" tabindex="-1" role="dialog" aria-labelledby="addEpModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title font-weight-bold" id="addEpModalLabel">
                                    <i class="fa-solid fa-user-tie mr-2"></i> Add New Executive Partner (EP)
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('superadmin.super-ep.store') }}" method="POST">
                                @csrf
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-user text-primary mr-1"></i> Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter EP full name" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="10-digit mobile number" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            <i class="fa fa-barcode text-primary mr-1"></i> EP Code
                                            <small class="text-muted font-italic">(Optional - auto-generated if left blank)</small>
                                        </label>
                                        <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="Leave blank to auto-generate (e.g. EP729104)">
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-toggle-on text-primary mr-1"></i> Initial Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary rounded px-4 font-weight-bold">
                                        <i class="fa fa-check mr-1"></i> Save EP
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit EP Modals -->
                @foreach ($records as $item)
                <div class="modal fade" id="editEpModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editEpModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title font-weight-bold" id="editEpModalLabel{{ $item->id }}">
                                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit EP: {{ $item->name }}
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('superadmin.super-ep.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-user text-primary mr-1"></i> Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $item->name) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="mobile" value="{{ old('mobile', $item->mobile) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-barcode text-primary mr-1"></i> EP Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="code" value="{{ old('code', $item->code) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fa fa-toggle-on text-primary mr-1"></i> Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="Active" {{ $item->status === 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $item->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
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

                <!-- Delete EP Modals -->
                @foreach ($records as $item)
                <div class="modal fade" id="deleteEpModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteEpModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            <form action="{{ route('superadmin.super-ep.delete', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                                    </div>
                                    <h4 class="font-weight-bold mb-2">Delete Executive Partner?</h4>
                                    <p class="text-muted mb-3">
                                        Are you sure you want to delete <strong>{{ $item->name }}</strong> ({{ $item->code }})?
                                        @if ($item->gps_count > 0)
                                            <br><span class="text-danger font-weight-bold">Warning: This EP has {{ $item->gps_count }} linked GP(s) that will also be removed!</span>
                                        @else
                                            <br><span class="text-danger small">This action cannot be undone.</span>
                                        @endif
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
