<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Super | Partners under {{ $ep->name }} ({{ $ep->code }})</title>

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
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
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
        .status-badge-pending {
            background-color: #fff8e1;
            color: #f57f17;
            border: 1px solid #ffe082;
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
        .card-pill {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-family: monospace;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            border: 1px solid #bfdbfe;
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
        .table th, .table td {
            vertical-align: middle !important;
        }
        .type-badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 4px;
            display: inline-block;
            margin-right: 3px;
            margin-bottom: 2px;
        }
        .type-opd { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .type-path { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .type-doc { background-color: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
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

                <form method="GET" action="{{ route('superadmin.super-ep.partners', $ep->id) }}" class="d-flex w-100 align-items-center ml-3">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search partners by clinic, person, mobile, email, ID..." class="form-control mr-2 w-100">
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
                            <i class="fa fa-gifts" aria-hidden="true"></i>&nbsp; <span
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
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false"
                            aria-controls="ui-basic2">
                            <i class="fa fa-coins" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Subscription</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic2">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-add-subscriptions">Add Subscriptions</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-show-subscription">Show Subscriptions</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- ticket system -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic11" aria-expanded="false"
                            aria-controls="ui-basic11">
                            <i class="fa fa-ticket" aria-hidden="true"></i>&nbsp; <span class="menu-title">Tickets</span><i
                                class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic11">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-all-tickets">All Tickets</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-ticket-replies">Ticket Replies</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- bulk broadcast -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('superadmin.bulkmessage.index') }}">
                            <i class="fa-brands fa-whatsapp"></i>&nbsp; <span class="menu-title">Bulk Broadcast</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- main-panel -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- Breadcrumb & Back Button -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-2">
                                <li class="breadcrumb-item"><a href="/superadmin/super-dashboard" class="text-muted"><i class="fa fa-home mr-1"></i>Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('superadmin.super-ep') }}" class="text-muted">Executive Partners</a></li>
                                <li class="breadcrumb-item active text-primary font-weight-bold" aria-current="page">Partners under {{ $ep->name }}</li>
                            </ol>
                        </nav>
                        <a href="{{ route('superadmin.super-ep') }}" class="btn btn-outline-secondary btn-sm px-3 font-weight-bold rounded shadow-sm mb-2">
                            <i class="fa fa-arrow-left mr-1"></i> Back to EP List
                        </a>
                    </div>

                    <!-- Header Banner -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap bg-white p-4 shadow-sm" style="border-radius: 14px; border-left: 5px solid #4f46e5;">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle p-3 mr-3 text-white d-flex align-items-center justify-content-center"
                                 style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); width: 56px; height: 56px;">
                                <i class="fa-solid fa-handshake fa-2x"></i>
                            </div>
                            <div>
                                <span class="role-badge-ep mb-1">
                                    <i class="fa-solid fa-user-tie mr-1"></i> Executive Partner
                                </span>
                                <h3 class="font-weight-bold text-dark mb-1 d-flex align-items-center flex-wrap">
                                    <span>Registered Partners under:</span>
                                    <span class="text-primary ml-2 font-weight-bold">{{ $ep->name }}</span>
                                    <span class="code-pill ml-2">{{ $ep->code }}</span>
                                </h3>
                                <p class="text-muted mb-0 small">
                                    Displaying all clinics, hospitals, pathology labs, and doctors registered using EP Code <strong>{{ $ep->code }}</strong>.
                                </p>
                            </div>
                        </div>

                        <!-- EP Contact Details Card -->
                        <div class="mt-2 mt-md-0">
                            <div class="card p-2 px-3 shadow-sm bg-white" style="border-radius: 10px; border-left: 4px solid #4f46e5;">
                                <div class="small text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">EP Contact & Status</div>
                                <div class="font-weight-bold text-dark d-flex align-items-center">
                                    <i class="fa fa-phone text-muted mr-1 small"></i>
                                    <a href="tel:{{ $ep->mobile }}" class="text-dark font-weight-500 mr-2">{{ $ep->mobile }}</a>
                                    @if ($ep->status === 'Active')
                                        <span class="status-badge-active"><i class="fa fa-circle text-success mr-1" style="font-size: 8px;"></i> Active</span>
                                    @else
                                        <span class="status-badge-inactive"><i class="fa fa-circle text-danger mr-1" style="font-size: 8px;"></i> Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KPIs Row -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Total Partners</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $totalPartners ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-handshake fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Active Partners</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $activePartners ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-circle-check fa-2x text-white"></i>
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
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Registered This Month</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $thisMonthPartners ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-calendar-check fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Registered Today</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $todayPartners ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-clock fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Card -->
                    <div class="card mb-4 shadow-sm" style="border-radius: 12px; border: none;">
                        <div class="card-body py-3">
                            <form method="GET" action="{{ route('superadmin.super-ep.partners', $ep->id) }}">
                                <div class="row align-items-end">
                                    <!-- Search -->
                                    <div class="col-lg-3 col-md-6 col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">
                                            <i class="fa fa-search text-muted mr-1"></i> Search Keywords
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="Clinic, person, mobile, ID..." value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">
                                            <i class="fa fa-toggle-on text-muted mr-1"></i> Status
                                        </label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="">All Statuses</option>
                                            <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
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
                                    <div class="col-lg-3 col-md-6 col-12 mb-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-sm px-3 mr-2 font-weight-bold rounded shadow-sm" style="min-width: 85px;">
                                            <i class="fa fa-filter mr-1"></i> Filter
                                        </button>
                                        <a href="{{ route('superadmin.super-ep.partners', $ep->id) }}" class="btn btn-outline-secondary btn-sm px-3 font-weight-bold rounded" title="Clear Filters">
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
                                <i class="fa-solid fa-handshake text-primary mr-2"></i>Registered Partners List
                                <span class="badge badge-secondary ml-2">{{ $partners->total() }}</span>
                            </h5>
                            <span class="small text-muted font-weight-bold">
                                EP: <span class="text-primary">{{ $ep->name }}</span> ({{ $ep->code }})
                            </span>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 60px;">#</th>
                                            <th>Partner ID</th>
                                            <th>Clinic & Contact Person</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Location</th>
                                            <th>Types</th>
                                            <th class="text-center">Status</th>
                                            <th>Registered At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($partners as $index => $partner)
                                        <tr>
                                            <td class="text-center text-muted font-weight-bold">
                                                {{ $partners->firstItem() + $index }}
                                            </td>

                                            <td>
                                                <span class="card-pill">{{ $partner->partner_id ?? 'N/A' }}</span>
                                            </td>

                                            <td>
                                                <div class="font-weight-bold text-dark">{{ $partner->partner_clinic_name }}</div>
                                                <small class="text-muted d-block">
                                                    <i class="fa-regular fa-user mr-1"></i>{{ $partner->partner_contact_person_name }}
                                                </small>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-phone text-muted mr-1 small"></i>
                                                    <a href="tel:{{ $partner->partner_mobile_number }}" class="text-dark font-weight-500 mr-2">
                                                        {{ $partner->partner_mobile_number }}
                                                    </a>
                                                    <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $partner->partner_mobile_number) }}" target="_blank"
                                                        class="badge badge-success p-1" title="Chat on WhatsApp">
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                    </a>
                                                </div>
                                            </td>

                                            <td>
                                                @if ($partner->partner_email)
                                                    <a href="mailto:{{ $partner->partner_email }}" class="text-muted small">
                                                        <i class="fa fa-envelope mr-1 text-primary"></i> {{ $partner->partner_email }}
                                                    </a>
                                                @else
                                                    <span class="text-muted font-italic small">N/A</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="badge badge-light border text-dark font-weight-500">
                                                    <i class="fa fa-location-dot text-danger mr-1"></i> {{ $partner->partner_city ?? 'N/A' }}
                                                </span>
                                                @if ($partner->partner_state)
                                                    <small class="text-muted d-block mt-1">{{ $partner->partner_state }}</small>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $types = $partner->registration_type;
                                                    if (is_string($types)) {
                                                        $types = json_decode($types, true) ?? [$types];
                                                    }
                                                    $types = (array) $types;
                                                @endphp
                                                @forelse ($types as $t)
                                                    @if ($t === 'OPD')
                                                        <span class="type-badge type-opd">OPD</span>
                                                    @elseif ($t === 'Pathology' || $t === 'Path')
                                                        <span class="type-badge type-path">Pathology</span>
                                                    @elseif ($t === 'Doctor')
                                                        <span class="type-badge type-doc">Doctor</span>
                                                    @else
                                                        <span class="type-badge badge-secondary">{{ $t }}</span>
                                                    @endif
                                                @empty
                                                    <span class="text-muted small">N/A</span>
                                                @endforelse
                                            </td>

                                            <td class="text-center">
                                                @if ($partner->status === 'Active')
                                                    <span class="status-badge-active"><i class="fa fa-circle text-success mr-1" style="font-size: 8px;"></i> Active</span>
                                                @elseif ($partner->status === 'Pending')
                                                    <span class="status-badge-pending"><i class="fa fa-circle text-warning mr-1" style="font-size: 8px;"></i> Pending</span>
                                                @else
                                                    <span class="status-badge-inactive"><i class="fa fa-circle text-danger mr-1" style="font-size: 8px;"></i> Inactive</span>
                                                @endif
                                            </td>

                                            <td class="text-muted small">
                                                <i class="fa-regular fa-clock text-muted mr-1"></i>
                                                {{ $partner->created_at ? $partner->created_at->format('d M Y, h:i A') : 'N/A' }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <div class="py-4">
                                                    <i class="fa-solid fa-handshake-slash fa-3x text-muted mb-3 d-block"></i>
                                                    <h5 class="text-muted font-weight-bold">No Partners Found for this EP</h5>
                                                    <p class="text-muted small">No partners have registered using EP Code <strong>{{ $ep->code }}</strong> yet.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination Footer -->
                        @if ($partners->hasPages())
                        <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap py-3">
                            <div class="small text-muted mb-2 mb-md-0">
                                Showing {{ $partners->firstItem() }} to {{ $partners->lastItem() }} of {{ $partners->total() }} entries
                            </div>
                            <div>
                                {{ $partners->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        @endif
                    </div>

                </div>

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
