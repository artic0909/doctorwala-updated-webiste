<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Get Ticket</title>
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
        /* ── Select2 ── */
        .select2-container {
            width: 100% !important
        }

        .select2-container--default .select2-selection--single {
            height: 52px !important;
            border: 1px solid #ced4da !important;
            border-radius: 8px !important;
            display: flex;
            align-items: center;
            padding: 0 12px
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 52px !important;
            color: #495057;
            font-size: 14px;
            padding-left: 4px
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 52px !important;
            right: 10px
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #0077b6 !important;
            box-shadow: 0 0 0 3px rgba(0, 119, 182, .12) !important
        }

        .select2-dropdown {
            border-color: #b6dff0 !important;
            border-radius: 8px !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .12)
        }

        .select2-search__field {
            padding: 8px 10px !important;
            border-radius: 5px !important;
            border: 1px solid #cce4f0 !important;
            outline: none !important;
            font-size: 13.5px
        }

        .select2-results__option {
            padding: 10px 14px;
            font-size: 13.5px
        }

        .select2-results__option--highlighted[aria-selected] {
            background: #0077b6 !important
        }

        .select2-results__option[aria-selected=true] {
            background: #e0f2fe;
            color: #004e7a
        }

        /* ── Inputs ── */
        .ppr-wrap {
            position: relative
        }

        .ppr-ico {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            z-index: 4;
            pointer-events: none
        }

        .ppr-field {
            padding-left: 40px !important;
            height: 52px !important;
            border-radius: 8px !important
        }

        .ppr-field:focus {
            border-color: #0077b6 !important;
            box-shadow: 0 0 0 3px rgba(0, 119, 182, .12) !important
        }

        /* ── Button ── */
        #pprBtn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 10px;
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: #fff;
            border: none;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .18s;
            box-shadow: 0 4px 14px rgba(0, 119, 182, .3)
        }

        #pprBtn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 119, 182, .4)
        }

        #pprBtn:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none
        }

        /* ── Preview card ── */
        .ppr-card {
            border: 1.5px solid #b6dff0;
            border-radius: 16px;
            background: linear-gradient(135deg, #f0f9ff, #e6f4fb);
            overflow: hidden;
            animation: pprIn .3s ease
        }

        @keyframes pprIn {
            from {
                opacity: 0;
                transform: translateY(8px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .ppr-card__top {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: #fff
        }

        .ppr-card__av {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            background: rgba(255, 255, 255, .25);
            border: 2px solid rgba(255, 255, 255, .4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            flex-shrink: 0
        }

        .ppr-card__found {
            font-size: 14px;
            font-weight: 700
        }

        .ppr-card__sub {
            font-size: 11.5px;
            opacity: .8;
            margin-top: 2px
        }

        .ppr-card__badge {
            margin-left: auto;
            background: rgba(255, 255, 255, .2);
            border: 1.5px solid rgba(255, 255, 255, .4);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px
        }

        .ppr-card__grid {
            padding: 18px 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .ppr-row {
            display: flex;
            align-items: flex-start;
            gap: 10px
        }

        .ppr-row__ico {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 13px
        }

        .ppr-row__ico--b {
            background: #dbeafe;
            color: #1d4ed8
        }

        .ppr-row__ico--t {
            background: #cffafe;
            color: #0e7490
        }

        .ppr-row__ico--g {
            background: #dcfce7;
            color: #15803d
        }

        .ppr-row__ico--p {
            background: #f3e8ff;
            color: #7e22ce
        }

        .ppr-row__lbl {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #64748b
        }

        .ppr-row__val {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
            margin-top: 2px;
            letter-spacing: .05em
        }

        .ppr-card__foot {
            padding: 10px 20px;
            background: rgba(0, 0, 0, .03);
            border-top: 1px solid #c8e6f5;
            font-size: 12px;
            color: #64748b
        }

        /* ── Error ── */
        .ppr-err-box {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-radius: 12px;
            background: #fff5f5;
            border: 1.5px solid #fecaca;
            color: #991b1b;
            font-size: 13.5px;
            font-weight: 500;
            animation: pprIn .25s ease
        }

        @media(max-width:600px) {
            .ppr-card__grid {
                grid-template-columns: 1fr
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



                    @if(in_array('Doctor', $registrationTypes))
                    <!-- Doctors -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic1234" aria-expanded="false"
                            aria-controls="ui-basic1234">
                            <i class="fa fa-stethoscope" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Doctor</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic1234">
                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item"> <a class="nav-link" href="/partnerpanel/partner-doctors">Upload Doctor</a>
                                </li>



                            </ul>
                        </div>
                    </li>
                    @endif




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
                                    <h3 class="font-weight-bold">Request Patient Profile Access</h3>
                                    <h6 class="font-weight-normal mb-0">
                                        <span><i class="fa fa-shield text-info" aria-hidden="true"></i></span>&nbsp;
                                        Send a secure request to access your patient's medical profile &amp; history. The patient will be notified and must approve before any records are visible.
                                    </h6>
                                </div>
                            </div>


                            <div class="row m-auto">
                                <div class="col-12 mt-4">

                                    <form class="prof-view" action="{{ route('partner.patient.request.send') }}" method="POST">
                                        @csrf

                                        <div class="form-view row mt-3 g-3">

                                            {{-- ── 1. Doctor Select ── --}}
                                            <div class="col-12 form-group">
                                                <label style="font-weight:700;">
                                                    <i class="fa fa-user-md text-primary"></i>
                                                    Select Doctor &nbsp;<span class="text-danger">*</span>
                                                </label>
                                                <select id="pprDoctorSelect" name="doctor_id" style="width:100%" required>
                                                    <option value="" disabled selected>— Search and select a doctor —</option>
                                                    @forelse($doctors as $doc)
                                                    <option value="{{ $doc->id }}">
                                                        {{ $doc->doctor_name }}{{ $doc->doctor_designation ? ' · '.$doc->doctor_designation : '' }}{{ $doc->doctor_specialist ? ' ('.$doc->doctor_specialist.')' : '' }}
                                                    </option>
                                                    @empty
                                                    <option disabled>No doctors registered yet.</option>
                                                    @endforelse
                                                </select>
                                                <small class="text-muted">Only active doctors under your clinic are listed.</small>
                                            </div>

                                            {{-- ── 2. Medical ID ── --}}
                                            <div class="col-12 col-md-6 form-group">
                                                <label style="font-weight:700;">
                                                    <i class="fa fa-id-card text-info"></i>
                                                    Doctorwala Medical ID &nbsp;<span class="text-danger">*</span>
                                                </label>
                                                <div class="ppr-wrap">
                                                    <span class="ppr-ico"><i class="fa fa-id-badge" style="color:#0077b6"></i></span>
                                                    <input type="text" class="form-control ppr-field" id="pprMedId"
                                                        placeholder="e.g. DW26 7211 03" oninput="pprReset()" name="dw_medical_id">
                                                </div>
                                                <small class="text-muted">Patient's Doctorwala card number.</small>
                                            </div>

                                            {{-- ── 3. Member ID ── --}}
                                            <div class="col-12 col-md-6 form-group">
                                                <label style="font-weight:700;">
                                                    <i class="fa fa-hashtag text-success"></i>
                                                    Member ID &nbsp;<span class="text-danger">*</span>
                                                </label>
                                                <div class="ppr-wrap">
                                                    <span class="ppr-ico"><i class="fa fa-key" style="color:#10b981"></i></span>
                                                    <input type="text" class="form-control ppr-field" id="pprMemId"
                                                        placeholder="e.g. DW-2026-003" oninput="pprReset()" name="dw_member_id">
                                                </div>
                                                <small class="text-muted">Patient's Doctorwala member ID.</small>
                                            </div>

                                            {{-- ── 4. Button ── --}}
                                            <div class="col-12 form-group text-right">
                                                <button type="button" id="pprBtn" onclick="pprFetch()">
                                                    <i class="fa fa-search"></i>&nbsp; Show Patient Details
                                                </button>
                                            </div>

                                            {{-- ── 5. Preview ── --}}
                                            <div class="col-12 mb-2" id="pprPreview" style="display:none">
                                                <div class="ppr-card">
                                                    <div class="ppr-card__top">
                                                        <div class="ppr-card__av" id="pprAv">?</div>
                                                        <div>
                                                            <div class="ppr-card__found">Patient Found</div>
                                                            <div class="ppr-card__sub">Details partially masked for privacy</div>
                                                        </div>
                                                        <span class="ppr-card__badge" id="pprBadge" style="display:none">
                                                            <i class="fa fa-check-circle"></i> Verified
                                                        </span>
                                                    </div>
                                                    <div class="ppr-card__grid">
                                                        <div class="ppr-row">
                                                            <span class="ppr-row__ico ppr-row__ico--b"><i class="fa fa-user"></i></span>
                                                            <div>
                                                                <div class="ppr-row__lbl">Full Name</div>
                                                                <div class="ppr-row__val" id="pV-name">—</div>
                                                                <input type="hidden" class="ppr-row__val" id="pV-id" name="dw_user_id" value="">
                                                            </div>
                                                        </div>
                                                        <div class="ppr-row">
                                                            <span class="ppr-row__ico ppr-row__ico--t"><i class="fa fa-envelope"></i></span>
                                                            <div>
                                                                <div class="ppr-row__lbl">Email</div>
                                                                <div class="ppr-row__val" id="pV-email">—</div>
                                                            </div>
                                                        </div>
                                                        <div class="ppr-row">
                                                            <span class="ppr-row__ico ppr-row__ico--g"><i class="fa fa-phone"></i></span>
                                                            <div>
                                                                <div class="ppr-row__lbl">Mobile</div>
                                                                <div class="ppr-row__val" id="pV-mobile">—</div>
                                                            </div>
                                                        </div>
                                                        <div class="ppr-row">
                                                            <span class="ppr-row__ico ppr-row__ico--p"><i class="fa fa-id-card"></i></span>
                                                            <div>
                                                                <div class="ppr-row__lbl">Medical Card No.</div>
                                                                <div class="ppr-row__val" id="pV-card">—</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ppr-card__foot">
                                                        <i class="fa fa-info-circle"></i>&nbsp;
                                                        Full details visible only after the patient approves your access request.
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- ── 6. Error ── --}}
                                            <div class="col-12" id="pprErr" style="display:none">
                                                <div class="ppr-err-box">
                                                    <i class="fa fa-exclamation-triangle"></i>&nbsp;
                                                    <span id="pprErrMsg">No patient found.</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="d-flex justify-content-center w-100 mb-3 mt-3">
                                            <button type="submit" class="btn btn-lg btn-danger rounded" style="font-weight: 700;">SEND REQUEST</button>
                                        </div>


                                        <div class="from-view row mt-2">

                                            <div class="col-4 form-group">
                                                <label for="currently_loggedin_partner_id" style="font-weight: 700;"><i
                                                        class="fa fa-id-card text-primary" aria-hidden="true"></i>
                                                    Partner ID <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="currently_loggedin_partner_id" name="currently_loggedin_partner_id"
                                                    value="{{ $partner->partner_id }}" style="height: 55px;" readonly>
                                            </div>



                                            <div class="col-4 form-group">
                                                <label for="partner_clinic_name" style="font-weight: 700;"><i
                                                        class="fa-solid fa-house-medical text-primary"></i>
                                                    Clinic Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="partner_clinic_name" name="partner_clinic_name"
                                                    value="{{ $partner->partner_clinic_name }}" style="height: 55px;" readonly>
                                            </div>

                                            <div class="col-4 form-group">
                                                <label for="partner_contact_person_name" style="font-weight: 700;"><i
                                                        class="fa fa-user text-primary" aria-hidden="true"></i> Contact
                                                    Person Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="partner_contact_person_name" name="partner_contact_person_name"
                                                    value="{{ $partner->partner_contact_person_name }}" style="height: 55px;" readonly>
                                            </div>



                                            <div class="col-4 form-group">
                                                <label for="partner_mobile_number" style="font-weight: 700;"><i
                                                        class="fa fa-phone text-primary" aria-hidden="true"></i> Mobile
                                                    Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="partner_mobile_number" name="partner_mobile_number"
                                                    value="{{ $partner->partner_mobile_number }}" style="height: 55px;" readonly>
                                            </div>




                                            <div class="col-4 form-group">
                                                <label for="partner_email" style="font-weight: 700;"><i
                                                        class="fa fa-envelope text-primary" aria-hidden="true"></i>
                                                    Email Id <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="partner_email" name="partner_email"
                                                    value="{{ $partner->partner_email }}" style="height: 55px;" readonly>
                                            </div>





                                            <div class="col-4 form-group">
                                                <label for="partner_state" style="font-weight: 700;"><i
                                                        class="fa-solid fa-globe text-primary"></i>
                                                    State <span class="text-danger">*</span></label>
                                                <input type="text" id="partner_state" name="partner_state" class="form-control" style="height: 55px;" value="{{ $partner->partner_state }}" readonly>
                                            </div>





                                            <div class="col-4 form-group">
                                                <label for="partner_city" style="font-weight: 700;"><i
                                                        class="fa-solid fa-city text-primary"></i> City
                                                    <span class="text-danger">*</span></label>

                                                <input type="text" id="partner_city" name="partner_city" class="form-control" value="{{ $partner->partner_city }}" style="height: 55px;" readonly>
                                            </div>


                                            <div class="col-4 form-group">
                                                <label for="partner_landmark" style="font-weight: 700;"><i
                                                        class="fa fa-map-pin text-primary" aria-hidden="true"></i>
                                                    Landmark <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="partner_landmark" name="partner_landmark"
                                                    value="{{ $partner->partner_landmark }}" style="height: 55px;" readonly>
                                            </div>

                                            <div class="col-4 form-group">
                                                <label for="partner_pincode" style="font-weight: 700;"><i
                                                        class="fa fa-location-pin-lock text-primary" aria-hidden="true"></i>
                                                    Pin Code <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="partner_pincode" name="partner_pincode"
                                                    value="{{ $partner->partner_pincode }}" style="height: 55px;" readonly>
                                            </div>
                                        </div>
                                    </form>

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



    {{-- ════════ SCRIPTS ════════ --}}
    <script>
        // ── Init Select2 after jQuery is definitely ready ──────────
        function initPprSelect2() {
            if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
                // jQuery or Select2 not loaded yet — retry in 150ms
                setTimeout(initPprSelect2, 150);
                return;
            }
            $('#pprDoctorSelect').select2({
                placeholder: '— Search and select a doctor —',
                allowClear: true,
                width: '100%',
            });
        }

        // Inject Select2 JS once, then init
        (function() {
            if (typeof $.fn !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
                initPprSelect2();
                return;
            }
            var s = document.createElement('script');
            s.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
            s.onload = initPprSelect2;
            document.body.appendChild(s);
        })();

        // ── Mask helpers ────────────────────────────────────────
        function mName(n) {
            if (!n) return '—';
            return n.split(' ').map(function(w) {
                return w.length <= 2 ? w : w.slice(0, 3) + '*'.repeat(Math.max(2, w.length - 3));
            }).join(' ');
        }

        function mEmail(e) {
            if (!e) return '—';
            var p = e.split('@');
            if (p.length < 2) return e;
            return p[0].slice(0, 2) + '*'.repeat(Math.max(3, p[0].length - 2)) + '@' + p[1];
        }

        function mMob(m) {
            if (!m) return '—';
            var s = m.toString().replace(/\s/g, '');
            return s.slice(0, 3) + '*'.repeat(Math.max(4, s.length - 6)) + s.slice(-3);
        }

        function mCard(c) {
            if (!c) return '—';
            return c.toString().slice(0, 4) + ' **** ' + c.toString().slice(-2);
        }

        function inits(n) {
            if (!n) return '?';
            return n.split(' ').map(function(w) {
                return w[0] || '';
            }).slice(0, 2).join('').toUpperCase();
        }

        // ── Reset ───────────────────────────────────────────────
        function pprReset() {
            document.getElementById('pprPreview').style.display = 'none';
            document.getElementById('pprErr').style.display = 'none';
        }

        // ── Fetch ───────────────────────────────────────────────
        function pprFetch() {
            var medId = document.getElementById('pprMedId').value.trim();
            var memId = document.getElementById('pprMemId').value.trim();
            pprReset();

            if (!medId || !memId) {
                document.getElementById('pprErrMsg').textContent = 'Please enter both the Medical ID and Member ID.';
                document.getElementById('pprErr').style.display = 'block';
                return;
            }

            var btn = document.getElementById('pprBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>&nbsp; Searching…';

            var csrf = '{{ csrf_token() }}';

            fetch('{{ route("partner.patient.lookup") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        dw_medical_id: medId,
                        dw_member_id: memId
                    })
                })
                .then(function(r) {
                    if (r.status === 404) throw new Error('Route not found (404). Check route name partner.patient.lookup.');
                    if (r.status === 405) throw new Error('Method not allowed (405). Ensure route accepts POST.');
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.json();
                })
                .then(function(data) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa fa-search"></i>&nbsp; Show Patient Details';

                    if (data.found && data.patient) {
                        var p = data.patient;
                        document.getElementById('pprAv').textContent = inits(p.user_name);
                        document.getElementById('pV-name').textContent = mName(p.user_name);
                        document.getElementById('pV-id').value = p.id;
                        document.getElementById('pV-email').textContent = mEmail(p.user_email);
                        document.getElementById('pV-mobile').textContent = mMob(p.user_mobile);
                        document.getElementById('pV-card').textContent = mCard(p.medical_card_no);
                        document.getElementById('pprBadge').style.display = p.is_verified ? 'inline-flex' : 'none';
                        document.getElementById('pprPreview').style.display = 'block';
                    } else {
                        document.getElementById('pprErrMsg').textContent = data.message || 'No patient found. Please check the IDs.';
                        document.getElementById('pprErr').style.display = 'block';
                    }
                })
                .catch(function(err) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa fa-search"></i>&nbsp; Show Patient Details';
                    document.getElementById('pprErrMsg').textContent = 'Error: ' + err.message;
                    document.getElementById('pprErr').style.display = 'block';
                });
        }
    </script>
</body>

</html>