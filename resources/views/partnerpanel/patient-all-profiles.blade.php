<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>All Requested Patient Profiles</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../partner-assets">
    <link rel="stylesheet" href="../partner-assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../partner-assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../partner-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../partner-assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../partner-assets/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../partner-assets/css/vertical-layout-light/style.css">
    <!-- endinject -->

    <link href="{{asset('fav5.png')}}" rel="icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">



    <style>
        /* Summary pills */
        .arp-summary {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .arp-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .arp-pill span {
            font-size: 16px;
            font-weight: 800;
        }

        .arp-pill--total {
            background: #f0f4ff;
            color: #4361ee;
            border: 1.5px solid #c7d2fe;
        }

        .arp-pill--pending {
            background: #fffbeb;
            color: #b45309;
            border: 1.5px solid #fde68a;
        }

        .arp-pill--accepted {
            background: #ecfdf5;
            color: #065f46;
            border: 1.5px solid #6ee7b7;
        }

        .arp-pill--rejected {
            background: #fff1f2;
            color: #9f1239;
            border: 1.5px solid #fecdd3;
        }

        /* Table wrap */
        .arp-table-wrap {
            overflow-x: auto;
            border-radius: 14px;
            border: 1.5px solid #e2eaf3;
            box-shadow: 0 2px 16px rgba(0, 119, 182, .06);
        }

        .arp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            font-family: inherit;
        }

        .arp-table thead tr {
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: #fff;
        }

        .arp-table thead th {
            padding: 13px 14px;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .05em;
            white-space: nowrap;
        }

        .arp-table thead th:first-child {
            border-radius: 12px 0 0 0;
        }

        .arp-table thead th:last-child {
            border-radius: 0 12px 0 0;
        }

        .arp-tr {
            border-bottom: 1px solid #f1f5f9;
            background: #fff;
            transition: background .15s;
        }

        .arp-tr:hover {
            background: #f8fbff;
        }

        .arp-tr--unread {
            background: #fefce8;
        }

        .arp-tr--unread:hover {
            background: #fef9c3;
        }

        .arp-tr:last-child {
            border-bottom: none;
        }

        .arp-td {
            padding: 13px 14px;
            vertical-align: middle;
        }

        .arp-td--num {
            font-weight: 700;
            color: #94a3b8;
            text-align: center;
            width: 40px;
        }

        .arp-td--date {
            font-size: 12.5px;
            color: #475569;
            white-space: nowrap;
        }

        /* Patient cell */
        .arp-patient {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .arp-avatar {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 800;
            color: #fff;
        }

        .arp-patient__name {
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
        }

        .arp-patient__email {
            font-size: 11.5px;
            color: #64748b;
            margin-top: 1px;
        }

        .arp-patient__mobile {
            font-size: 11.5px;
            color: #64748b;
        }

        /* Doctor cell */
        .arp-doctor__name {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
        }

        .arp-doctor__spec {
            font-size: 11.5px;
            color: #64748b;
            margin-top: 2px;
        }

        /* ID chips */
        .arp-id-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .arp-id-chip--masked {
            background: #f1f5f9;
            color: #94a3b8;
            border: 1px solid #e2e8f0;
        }

        .arp-id-chip--clear {
            background: #e0f2fe;
            color: #0077b6;
            border: 1px solid #bae6fd;
        }

        /* Badges */
        .arp-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .arp-badge--pending {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .arp-badge--accepted {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .arp-badge--rejected {
            background: #fff1f2;
            color: #9f1239;
            border: 1px solid #fecdd3;
        }

        .arp-badge--access-on {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .arp-badge--access-off {
            background: #f8fafc;
            color: #94a3b8;
            border: 1px solid #e2e8f0;
        }

        .arp-badge--unread {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
        }

        .arp-badge--read {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .arp-badge__dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
        }

        .arp-badge__dot--pulse {
            animation: arpPulse 2s infinite;
        }

        @keyframes arpPulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .4
            }
        }

        /* View button */
        .arp-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            border: 1.5px solid #e2eaf3;
            background: #f8fafc;
            color: #475569;
            transition: all .16s;
            white-space: nowrap;
        }

        .arp-view-btn:hover {
            background: yellow;
            border-color: yellow;
            color: black !important;
            text-decoration: none;
        }

        .arp-view-btn--active {
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: #fff !important;
            border-color: transparent;
            box-shadow: 0 3px 12px rgba(0, 119, 182, .25);
        }

        .arp-view-btn--active:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(0, 119, 182, .35);
        }

        /* Empty state */
        .arp-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 24px;
            gap: 10px;
        }

        .arp-empty__ico {
            font-size: 44px;
        }

        .arp-empty__title {
            font-size: 16px;
            font-weight: 700;
            color: #94a3b8;
        }

        .arp-empty__sub {
            font-size: 13px;
            color: #cbd5e1;
        }

        @media(max-width:768px) {
            .arp-table {
                font-size: 12px;
            }

            .arp-td {
                padding: 10px 10px;
            }
        }
    </style>
</head>

<body>


    <div class="container-scroller">



        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="/partnerpanel/partner-dashboard" style="font-weight: 900;"><img
                        src="{{asset('../img/logo3.png')}}" alt="logo"></a>
                <a class="navbar-brand brand-logo-mini" href="/partnerpanel/partner-dashboard"><img src="{{asset('fav5.png')}}"
                        alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="{{asset('fav5.png')}}" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="/partnerpanel/partner-profile">
                                <i class="ti-settings text-primary"></i>
                                Settings
                            </a>


                            <form method="POST" action="{{ route('partner.logout') }}">
                                @csrf
                                <a class="dropdown-item" :href="route('partner.logout')"
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



                    <!-- dasboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="/partnerpanel/partner-dashboard">
                            <i class="fa-solid fa-chart-pie"></i>&nbsp; <span class="menu-title">Dashboard</span>
                        </a>
                    </li>



                    <!-- partner-profile -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                            aria-controls="ui-basic">
                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Profile</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-profile">Partner
                                        Profile</a></li>
                                @if(in_array('OPD', $registrationTypes))
                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-opd-contact">OPD
                                        Contact</a></li>
                                @endif

                                @if(in_array('Pathology', $registrationTypes))
                                <li class="nav-item"> <a class="nav-link"
                                        href="/partnerpanel/partner-pathology-contact">Pathology Contact</a></li>
                                @endif

                                @if(in_array('Doctor', $registrationTypes))
                                <li class="nav-item"> <a class="nav-link"
                                        href="/partnerpanel/partner-doctors">List Myself</a></li>
                                @endif
                            </ul>
                        </div>
                    </li>


                    <!-- partner-profile-banner -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basicuy" aria-expanded="false"
                            aria-controls="ui-basicuy">
                            <i class="fa fa-panorama" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Profile Banner</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basicuy">

                            <ul class="nav flex-column sub-menu">

                                @if(in_array('OPD', $registrationTypes))
                                <li class="nav-item"> <a class="nav-link" href="#" data-toggle="modal" data-target="#myOPDBanner">OPD Banner</a></li>
                                @endif

                                @if(in_array('Pathology', $registrationTypes))
                                <li class="nav-item"> <a class="nav-link" href="#" data-toggle="modal" data-target="#myPathologyBanner">Pathology Banner</a></li>
                                @endif


                                @if(in_array('Doctor', $registrationTypes))
                                <li class="nav-item"> <a class="nav-link" href="#" data-toggle="modal" data-target="#myDoctorBanner">Doctor Banner</a></li>
                                @endif

                            </ul>
                        </div>
                    </li>





                    <!-- partner about clinic -->
                    <li class="nav-item">
                        <a class="nav-link" href="/partnerpanel/partner-about-clinic">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; <span class="menu-title">About
                                Clinic</span>
                        </a>
                    </li>





                    <!-- partner service lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/partnerpanel/partner-service-lists">
                            <i class="fa fa-ambulance" aria-hidden="true"></i>&nbsp; <span class="menu-title">Service
                                Lists</span>
                        </a>
                    </li>




                    <!-- gallery -->
                    <li class="nav-item">
                        <a class="nav-link" href="/partnerpanel/partner-gallery">
                            <i class="fa-solid fa-image"></i>&nbsp; <span class="menu-title">Gallery</span>
                        </a>
                    </li>





                    @if(in_array('OPD', $registrationTypes))
                    <!-- OPD -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic12" aria-expanded="false"
                            aria-controls="ui-basic12">
                            <i class="fa fa-user-doctor" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">OPD</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic12">
                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-opd">Upload OPD</a></li>

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-opd-show">Show OPD</a></li>

                            </ul>
                        </div>
                    </li>
                    @endif




                    @if(in_array('Pathology', $registrationTypes))
                    <!-- Pathology -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic123" aria-expanded="false"
                            aria-controls="ui-basic123">
                            <i class="fa fa-syringe" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Pathology</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic123">
                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-pathology">Upload Path</a>
                                </li>

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-pathology-show">Show
                                        Path</a></li>

                            </ul>
                        </div>
                    </li>
                    @endif



                    

                    <!-- Patient profile management -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-req" aria-expanded="false"
                            aria-controls="ui-req">
                            <i class="fa-solid fa-ticket"></i>&nbsp; <span class="menu-title">Patient Profile</span><i
                                class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-req">
                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-patient-profile-request">Send Request</a></li>

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/patient-profile-all-request">All Profiles</a>
                                </li>

                            </ul>
                        </div>
                    </li>




                    <!-- Inquiry from patients/user -->
                    <li class="nav-item">
                        <a class="nav-link" href="/partnerpanel/partner-inquiry-from-patients">
                            <i class="fa-solid fa-hand-holding-medical"></i>&nbsp; <span
                                class="menu-title">Inquiries</span>
                        </a>
                    </li>








                    <!-- Subsription management -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic11" aria-expanded="false"
                            aria-controls="ui-basic11">
                            <i class="fa-solid fa-indian-rupee-sign"></i>&nbsp; <span
                                class="menu-title">Subsription</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic11">
                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-get-subscription">Get
                                        Subsription</a></li>

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-show-invoice">Invoice</a>
                                </li>

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

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-get-ticket">Get
                                        Ticket</a></li>

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-show-ticket">My Tickets</a>
                                </li>

                            </ul>
                        </div>
                    </li>




                </ul>


            </nav>





            <!-- partial -->
            <div class="main-panel">






                <div class="content-wrapper">



                    <div class="row">
                        <div class="col-md-12 grid-margin">

                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">All Requested Patient Profiles</h3>
                                    <h6 class="font-weight-normal mb-0">
                                        <span><i class="fa fa-shield text-info" aria-hidden="true"></i></span>&nbsp;
                                        Send a secure request to access your patient's medical profile &amp; history.
                                        The patient will be notified and must approve before any records are visible.
                                    </h6>
                                </div>
                            </div>

                            <div class="row m-auto">
                                <div class="col-12 mt-4">

                                    @if($requests->isEmpty())
                                    <div class="arp-empty">
                                        <div class="arp-empty__ico">📋</div>
                                        <div class="arp-empty__title">No requests yet</div>
                                        <div class="arp-empty__sub">Patient profile access requests will appear here.</div>
                                    </div>
                                    @else

                                    {{-- ── Summary Pills ── --}}
                                    <div class="arp-summary">
                                        <div class="arp-pill arp-pill--total">
                                            <span>{{ $requests->count() }}</span> Total
                                        </div>
                                        <div class="arp-pill arp-pill--pending">
                                            <span>{{ $requests->where('req_status','pending')->count() }}</span> Pending
                                        </div>
                                        <div class="arp-pill arp-pill--accepted">
                                            <span>{{ $requests->where('req_status','accepted')->count() }}</span> Accepted
                                        </div>
                                        <div class="arp-pill arp-pill--rejected">
                                            <span>{{ $requests->where('req_status','rejected')->count() }}</span> Rejected
                                        </div>
                                    </div>

                                    {{-- ── Table ── --}}
                                    <div class="arp-table-wrap">
                                        <table class="arp-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Patient</th>
                                                    <th>Doctor</th>
                                                    <th>Medical ID</th>
                                                    <th>Member ID</th>
                                                    <th>Request Status</th>
                                                    <th>Access</th>
                                                    <th>Read</th>
                                                    <th>Requested On</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($requests as $i => $req)
                                                @php
                                                $accepted = $req->req_status === 'accepted';
                                                $patient = $req->patient; // relation


                                                $rawName = $patient->user_name ?? '—';
                                                $rawEmail = $patient->user_email ?? '—';
                                                $rawMobile = $patient->user_mobile ?? '—';
                                                $rawCard = $req->dw_medical_id ?? '—';
                                                $rawMem = $req->dw_member_id ?? '—';

                                                if (!$accepted) {

                                                $dispName = implode(' ', array_map(function($w) {
                                                return strlen($w) <= 2 ? $w : substr($w,0,3).str_repeat('*', max(2, strlen($w)-3));
                                                    }, explode(' ', $rawName)));

                               
                                    $eParts   = explode(' @', $rawEmail);
                                                    $dispEmail=count($eParts)===2
                                                    ? substr($eParts[0],0,2).str_repeat('*', max(3, strlen($eParts[0])-2)).'@'.$eParts[1]
                                                    : $rawEmail;

                                                    // Mask mobile: "9876543210" → "987****210"
                                                    $m=preg_replace('/\s+/','',$rawMobile);
                                                    $dispMobile=strlen($m)> 6
                                                    ? substr($m,0,3).str_repeat('*', max(4, strlen($m)-6)).substr($m,-3)
                                                    : $rawMobile;


                                                    $dispCard = substr($rawCard,0,4).' **** '.substr($rawCard,-2);
                                                    $dispMem = substr($rawMem,0,3).str_repeat('*', max(3, strlen($rawMem)-5)).substr($rawMem,-2);
                                                    } else {
                                                    $dispName = $rawName;
                                                    $dispEmail = $rawEmail;
                                                    $dispMobile = $rawMobile;
                                                    $dispCard = $rawCard;
                                                    $dispMem = $rawMem;
                                                    }
                                                    @endphp
                                                    <tr class="arp-tr {{ $req->read_status === 'unread' ? 'arp-tr--unread' : '' }}">

                                                        {{-- # --}}
                                                        <td class="arp-td arp-td--num">{{ $i + 1 }}</td>

                                                        {{-- Patient --}}
                                                        <td class="arp-td">
                                                            <div class="arp-patient">
                                                                <div class="arp-avatar" style="background:{{ $accepted ? 'linear-gradient(135deg,#0077b6,#00b4d8)' : '#94a3b8' }}">
                                                                    {{ strtoupper(substr($rawName,0,1)) }}
                                                                </div>
                                                                <div>
                                                                    <div class="arp-patient__name">{{ $dispName }}</div>
                                                                    <div class="arp-patient__email">{{ $dispEmail }}</div>
                                                                    <div class="arp-patient__mobile">{{ $dispMobile }}</div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        {{-- Doctor --}}
                                                        <td class="arp-td">
                                                            @if($req->doctor)
                                                            <div class="arp-doctor__name">{{ $req->doctor->doctor_name }}</div>
                                                            <div class="arp-doctor__spec">{{ $req->doctor->doctor_specialist ?? $req->doctor->doctor_designation ?? '—' }}</div>
                                                            @else
                                                            <span class="text-muted">—</span>
                                                            @endif
                                                        </td>

                                                        {{-- Medical ID --}}
                                                        <td class="arp-td">
                                                            <span class="arp-id-chip {{ $accepted ? 'arp-id-chip--clear' : 'arp-id-chip--masked' }}">
                                                                <i class="fa fa-id-card"></i> {{ $dispCard }}
                                                            </span>
                                                        </td>

                                                        {{-- Member ID --}}
                                                        <td class="arp-td">
                                                            <span class="arp-id-chip {{ $accepted ? 'arp-id-chip--clear' : 'arp-id-chip--masked' }}">
                                                                <i class="fa fa-hashtag"></i> {{ $dispMem }}
                                                            </span>
                                                        </td>

                                                        {{-- Request Status --}}
                                                        <td class="arp-td">
                                                            @if($req->req_status === 'pending')
                                                            <span class="arp-badge arp-badge--pending">
                                                                <span class="arp-badge__dot"></span> Pending
                                                            </span>
                                                            @elseif($req->req_status === 'accepted')
                                                            <span class="arp-badge arp-badge--accepted">
                                                                <i class="fa fa-check-circle"></i> Accepted
                                                            </span>
                                                            @else
                                                            <span class="arp-badge arp-badge--rejected">
                                                                <i class="fa fa-times-circle"></i> Rejected
                                                            </span>
                                                            @endif
                                                        </td>

                                                        {{-- Access Status --}}
                                                        <td class="arp-td">
                                                            @if($req->access_status === 'on')
                                                            <span class="arp-badge arp-badge--access-on">
                                                                <i class="fa fa-unlock"></i> ON
                                                            </span>
                                                            @else
                                                            <span class="arp-badge arp-badge--access-off">
                                                                <i class="fa fa-lock"></i> OFF
                                                            </span>
                                                            @endif
                                                        </td>

                                                        {{-- Read Status --}}
                                                        <td class="arp-td">
                                                            @if($req->read_status === 'unread')
                                                            <span class="arp-badge arp-badge--unread">
                                                                <span class="arp-badge__dot arp-badge__dot--pulse"></span> Unread
                                                            </span>
                                                            @else
                                                            <span class="arp-badge arp-badge--read">
                                                                <i class="fa fa-check"></i> Read
                                                            </span>
                                                            @endif
                                                        </td>

                                                        {{-- Requested On --}}
                                                        <td class="arp-td arp-td--date">
                                                            {{ \Carbon\Carbon::parse($req->created_at)->format('d M Y') }}<br>
                                                            <span style="font-size:11px;color:#94a3b8">{{ \Carbon\Carbon::parse($req->created_at)->format('h:i A') }}</span>
                                                        </td>

                                                        {{-- Action --}}
                                                        <td class="arp-td">
                                                            <a href="{{ route('partner.patient.profile', ['encryptedId' => Crypt::encryptString($req->dw_user_id)]) }}"
                                                                class="arp-view-btn {{ $accepted ? 'arp-view-btn--active' : '' }}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                {{ $accepted ? 'View Profile' : 'View Details' }}
                                                            </a>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

















                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024. <a
                                href="https://doctorwala.info/" target="_blank">Doctorwala.info</a> -
                            All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Easy-To-Use & made with
                            <i class="ti-heart text-danger ml-1"></i></span>
                    </div>
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Developed by <a
                                href="https://github.com/artic0909" target="_blank">SaklinMustak</a></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->






        <!-- OPD Banner Upload Edit & Show Modal -->
        <div class="modal fade" id="myOPDBanner" tabindex="-1" role="dialog" aria-labelledby="myOPDBannerLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h3 class="text-center text-primary" id="myOPDBannerLabel" style="font-weight: 700; font-size: 1.8rem;"><span class="text-danger">+</span> Upload OPD Banner <span class="text-danger">+</span></h3>

                        <!-- Display Uploaded Image (Dynamically) -->

                        <div class="img-b d-flex justify-content-center align-items-center mt-4">
                            @if($opdBanner && isset($opdBanner->opdbanner))
                            <!-- Show the uploaded OPD banner -->
                            <img src="{{ asset('storage/' . $opdBanner->opdbanner) }}" alt="OPD Banner" class="img-fluid">
                            @else
                            <!-- Show placeholder if no OPD banner exists -->
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDVuaQbojYLTlYezNW7HPVIYO6QiLZsd8RFP86jMuySoBlJ369aVAK0Mtzo7La2hyVcxU&usqp=CAU" class="img-fluid" alt="Placeholder OPD Banner">
                            @endif
                        </div>


                        <form action="{{ route('partner.opd.banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-4">
                                <label for="opdbanner" class="form-label" style="font-weight: 700;"><i class="fa fa-image text-danger" aria-hidden="true"></i> Upload OPD Banner <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="opdbanner" name="opdbanner">
                            </div>
                            <div class="modal-foote d-flex justify-content-between align-items-center" style="gap: 15px;">
                                <button type="button" class="btn btn-danger rounded w-100" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded w-100">Save Changes</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>


        <!-- Pathology Banner Upload Edit & Show Modal -->
        <div class="modal fade" id="myPathologyBanner" tabindex="-1" role="dialog" aria-labelledby="myPathologyBannerLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h3 class="text-center text-primary" id="myPathologyBannerLabel" style="font-weight: 700; font-size: 1.8rem;"><span class="text-danger">+</span> Upload Pathology Banner <span class="text-danger">+</span></h3>

                        <div class="img-b d-flex justify-content-center align-items-center mt-4">
                            @if($pathologyBanner && isset($pathologyBanner->pathologybanner))
                            <!-- Show the uploaded OPD banner -->
                            <img src="{{ asset('storage/' . $pathologyBanner->pathologybanner) }}" alt="Pathology Banner" class="img-fluid">
                            @else
                            <!-- Show placeholder if no OPD banner exists -->
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDVuaQbojYLTlYezNW7HPVIYO6QiLZsd8RFP86jMuySoBlJ369aVAK0Mtzo7La2hyVcxU&usqp=CAU" class="img-fluid" alt="Placeholder OPD Banner">
                            @endif
                        </div>


                        <form action="{{ route('partner.pathology.banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-4">
                                <label for="pathologybanner" class="form-label" style="font-weight: 700;"><i class="fa fa-image text-danger" aria-hidden="true"></i> Upload Pathology Banner <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="pathologybanner" name="pathologybanner">
                            </div>
                            <div class="modal-foote d-flex justify-content-between align-items-center" style="gap: 15px;">
                                <button type="button" class="btn btn-danger rounded w-100" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded w-100">Save Changes</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>



        <!-- Doctor Banner Upload Edit & Show Modal -->
        <div class="modal fade" id="myDoctorBanner" tabindex="-1" role="dialog" aria-labelledby="myDoctorBannerLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h3 class="text-center text-primary" id="myDoctorBannerLabel" style="font-weight: 700; font-size: 1.8rem;"><span class="text-danger">+</span> Upload Docotor Banner <span class="text-danger">+</span></h3>

                        <div class="img-b d-flex justify-content-center align-items-center mt-4">
                            @if($doctorBanner && isset($doctorBanner->doctorbanner))
                            <!-- Show the uploaded OPD banner -->
                            <img src="{{ asset('storage/' . $doctorBanner->doctorbanner) }}" alt="Doctor Banner" class="img-fluid">
                            @else
                            <!-- Show placeholder if no OPD banner exists -->
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDVuaQbojYLTlYezNW7HPVIYO6QiLZsd8RFP86jMuySoBlJ369aVAK0Mtzo7La2hyVcxU&usqp=CAU" class="img-fluid" alt="Placeholder OPD Banner">
                            @endif
                        </div>


                        <form action="{{ route('partner.doctor.banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-4">
                                <label for="doctorbanner" class="form-label" style="font-weight: 700;"><i class="fa fa-image text-danger" aria-hidden="true"></i> Upload Doctor Banner <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="doctorbanner" name="doctorbanner">
                            </div>
                            <div class="modal-foote d-flex justify-content-between align-items-center" style="gap: 15px;">
                                <button type="button" class="btn btn-danger rounded w-100" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded w-100">Save Changes</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>


        <!-- OPD Banner Upload Edit & Show Modal -->
        <div class="modal fade" id="myOPDBanner" tabindex="-1" role="dialog" aria-labelledby="myOPDBannerLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h3 class="text-center text-primary" id="myOPDBannerLabel" style="font-weight: 700; font-size: 1.8rem;"><span class="text-danger">+</span> Upload OPD Banner <span class="text-danger">+</span></h3>

                        <!-- Display Uploaded Image (Dynamically) -->

                        <div class="img-b d-flex justify-content-center align-items-center mt-4">
                            @if($opdBanner && isset($opdBanner->opdbanner))
                            <!-- Show the uploaded OPD banner -->
                            <img src="{{ asset('storage/' . $opdBanner->opdbanner) }}" alt="OPD Banner" class="img-fluid">
                            @else
                            <!-- Show placeholder if no OPD banner exists -->
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDVuaQbojYLTlYezNW7HPVIYO6QiLZsd8RFP86jMuySoBlJ369aVAK0Mtzo7La2hyVcxU&usqp=CAU" class="img-fluid" alt="Placeholder OPD Banner">
                            @endif
                        </div>


                        <form action="{{ route('partner.opd.banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-4">
                                <label for="opdbanner" class="form-label" style="font-weight: 700;"><i class="fa fa-image text-danger" aria-hidden="true"></i> Upload OPD Banner <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="opdbanner" name="opdbanner">
                            </div>
                            <div class="modal-foote d-flex justify-content-between align-items-center" style="gap: 15px;">
                                <button type="button" class="btn btn-danger rounded w-100" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded w-100">Save Changes</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>


        <!-- Pathology Banner Upload Edit & Show Modal -->
        <div class="modal fade" id="myPathologyBanner" tabindex="-1" role="dialog" aria-labelledby="myPathologyBannerLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h3 class="text-center text-primary" id="myPathologyBannerLabel" style="font-weight: 700; font-size: 1.8rem;"><span class="text-danger">+</span> Upload Pathology Banner <span class="text-danger">+</span></h3>

                        <div class="img-b d-flex justify-content-center align-items-center mt-4">
                            @if($pathologyBanner && isset($pathologyBanner->pathologybanner))
                            <!-- Show the uploaded OPD banner -->
                            <img src="{{ asset('storage/' . $pathologyBanner->pathologybanner) }}" alt="Pathology Banner" class="img-fluid">
                            @else
                            <!-- Show placeholder if no OPD banner exists -->
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDVuaQbojYLTlYezNW7HPVIYO6QiLZsd8RFP86jMuySoBlJ369aVAK0Mtzo7La2hyVcxU&usqp=CAU" class="img-fluid" alt="Placeholder OPD Banner">
                            @endif
                        </div>


                        <form action="{{ route('partner.pathology.banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-4">
                                <label for="pathologybanner" class="form-label" style="font-weight: 700;"><i class="fa fa-image text-danger" aria-hidden="true"></i> Upload Pathology Banner <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="pathologybanner" name="pathologybanner">
                            </div>
                            <div class="modal-foote d-flex justify-content-between align-items-center" style="gap: 15px;">
                                <button type="button" class="btn btn-danger rounded w-100" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded w-100">Save Changes</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>



        <!-- Doctor Banner Upload Edit & Show Modal -->
        <div class="modal fade" id="myDoctorBanner" tabindex="-1" role="dialog" aria-labelledby="myDoctorBannerLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h3 class="text-center text-primary" id="myDoctorBannerLabel" style="font-weight: 700; font-size: 1.8rem;"><span class="text-danger">+</span> Upload Docotor Banner <span class="text-danger">+</span></h3>

                        <div class="img-b d-flex justify-content-center align-items-center mt-4">
                            @if($doctorBanner && isset($doctorBanner->doctorbanner))
                            <!-- Show the uploaded OPD banner -->
                            <img src="{{ asset('storage/' . $doctorBanner->doctorbanner) }}" alt="Doctor Banner" class="img-fluid">
                            @else
                            <!-- Show placeholder if no OPD banner exists -->
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDVuaQbojYLTlYezNW7HPVIYO6QiLZsd8RFP86jMuySoBlJ369aVAK0Mtzo7La2hyVcxU&usqp=CAU" class="img-fluid" alt="Placeholder OPD Banner">
                            @endif
                        </div>


                        <form action="{{ route('partner.doctor.banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-4">
                                <label for="doctorbanner" class="form-label" style="font-weight: 700;"><i class="fa fa-image text-danger" aria-hidden="true"></i> Upload Doctor Banner <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="doctorbanner" name="doctorbanner">
                            </div>
                            <div class="modal-foote d-flex justify-content-between align-items-center" style="gap: 15px;">
                                <button type="button" class="btn btn-danger rounded w-100" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded w-100">Save Changes</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>



    </div>



    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <!-- plugins:js -->
    <script src="../partner-assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../partner-assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../partner-assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="../partner-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="../partner-assets/js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../partner-assets/js/off-canvas.js"></script>
    <script src="../partner-assets/js/hoverable-collapse.js"></script>
    <script src="../partner-assets/js/template.js"></script>
    <script src="../partner-assets/js/settings.js"></script>
    <script src="../partner-assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../partner-assets/js/dashboard.js"></script>
    <script src="../partner-assets/js/Chart.roundedBarCharts.js"></script>
    <!-- End custom js for this page-->

</body>

</html>