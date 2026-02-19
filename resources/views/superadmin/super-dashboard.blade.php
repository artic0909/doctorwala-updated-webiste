<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Super Admin Dashboard</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('../partner-assets')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('../partner-assets/js/select.dataTables.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('../partner-assets/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->

    <link href="{{asset('fav5.png')}}" rel="icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        .card_green {
            background-color: #0d7c34;
            color: white;
            cursor: pointer;
            transition: all 200ms ease-in-out;

            img {
                transition: all 160ms ease-in-out;
            }

            &:hover {
                color: white;
                background-color: #0d662b;

                img {
                    scale: 1.08;
                }
            }
        }


        .card_blue {
            background-color: #2697d8;
            color: white;
            cursor: pointer;
            transition: all 200ms ease-in-out;

            img {
                transition: all 160ms ease-in-out;
            }

            &:hover {
                color: white;
                background-color: #246bad;

                img {
                    scale: 1.08;
                }
            }
        }


        .card_red {
            background-color: #dd2923;
            color: white;
            cursor: pointer;
            transition: all 200ms ease-in-out;

            img {
                transition: all 160ms ease-in-out;
            }

            &:hover {
                color: white;
                background-color: #bb211b;

                img {
                    scale: 1.08;
                }
            }
        }


        .card_orange {
            background-color: #f07934;
            color: white;
            cursor: pointer;
            transition: all 200ms ease-in-out;

            img {
                transition: all 160ms ease-in-out;
            }

            &:hover {
                color: white;
                background-color: #e76519;

                img {
                    scale: 1.08;
                }
            }
        }



        .card_purple {
            background-color: #6757fc;
            color: white;
            cursor: pointer;
            transition: all 200ms ease-in-out;

            img {
                transition: all 160ms ease-in-out;
            }

            &:hover {
                color: white;
                background-color: #4b38f1;

                img {
                    scale: 1.08;
                }
            }
        }

        .card_dark_blue {
            background-color: #24378f;
            color: white;
            cursor: pointer;
            transition: all 200ms ease-in-out;

            img {
                transition: all 160ms ease-in-out;
            }

            &:hover {
                color: white;
                background-color: #13277e;

                img {
                    scale: 1.08;
                }
            }
        }

        .card_ash_tyran {
            background-color: #8d1b4e;
            color: white;
            cursor: pointer;
            transition: all 200ms ease-in-out;

            img {
                transition: all 160ms ease-in-out;
            }

            &:hover {
                color: white;
                background-color: #5f082f;

                img {
                    scale: 1.08;
                }
            }
        }

        .card_dim_blue {
            background-color: #0FA3B1;
            color: white;
            cursor: pointer;
            transition: all 200ms ease-in-out;

            img {
                transition: all 160ms ease-in-out;
            }

            &:hover {
                color: white;
                background-color: #00565e;

                img {
                    scale: 1.08;
                }
            }
        }

        /* ── Stat Cards ── */
        .va-stat-card {
            border-radius: 16px;
            padding: 22px 20px 20px;
            position: relative;
            overflow: hidden;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.10);
        }

        .va-stat-blue {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }

        .va-stat-green {
            background: linear-gradient(135deg, #0d9e5c 0%, #07814a 100%);
        }

        .va-stat-purple {
            background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
        }

        .va-stat-orange {
            background: linear-gradient(135deg, #fd7c0d 0%, #ca6008 100%);
        }

        .va-stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
            backdrop-filter: blur(4px);
        }

        .va-stat-body {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .va-stat-body h3 {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0 0 2px;
            line-height: 1;
        }

        .va-stat-body p {
            font-size: 0.78rem;
            margin: 0;
            opacity: 0.8;
            font-weight: 500;
        }

        .va-trend {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 8px;
            border-radius: 10px;
            margin-top: 5px;
        }

        .va-stat-wave {
            position: absolute;
            right: -20px;
            bottom: -20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
        }

        .va-stat-wave::before {
            content: '';
            position: absolute;
            inset: 18px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        /* ── Chart Cards ── */
        .va-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px 22px 18px;
            box-shadow: 0 3px 18px rgba(0, 0, 0, 0.07);
            border: 1px solid rgba(0, 0, 0, 0.04);
            height: 100%;
        }

        .va-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .va-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .va-card-title>i {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #f0f4ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .va-card-title h5 {
            font-size: 0.92rem;
            font-weight: 800;
            color: #0d1e3a;
            margin: 0 0 2px;
        }

        .va-card-title p {
            font-size: 0.7rem;
            color: #94a3b8;
            margin: 0;
        }

        .va-badge {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .va-badge-blue {
            background: #e9f0ff;
            color: #0d6efd;
        }

        .va-badge-green {
            background: #e0f7ef;
            color: #0d9e5c;
        }

        .va-badge-purple {
            background: #ede5ff;
            color: #6f42c1;
        }

        .va-chart-wrap {
            position: relative;
            width: 100%;
        }

        /* ── Legend ── */
        .va-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
            justify-content: center;
        }

        .va-legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            font-weight: 600;
            color: #555;
        }

        .va-legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        /* ── Top Pages Table ── */
        .va-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.84rem;
        }

        .va-table thead th {
            padding: 10px 14px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #94a3b8;
            border-bottom: 2px solid #f0f4ff;
            background: #f9faff;
        }

        .va-table tbody td {
            padding: 11px 14px;
            border-bottom: 1px solid #f4f7ff;
            color: #333;
            vertical-align: middle;
        }

        .va-table tbody tr:last-child td {
            border-bottom: none;
        }

        .va-table tbody tr:hover td {
            background: #f9faff;
        }

        .va-rank {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            background: #f0f4ff;
            color: #0d6efd;
            font-size: 0.72rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .va-page-url {
            color: #0d6efd;
            text-decoration: none;
            font-size: 0.8rem;
            transition: color 0.2s;
        }

        .va-page-url:hover {
            color: #0a58ca;
            text-decoration: underline;
        }

        .va-page-url i {
            font-size: 0.65rem;
            margin-right: 4px;
        }

        .va-progress-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 140px;
        }

        .va-progress-bar {
            height: 6px;
            border-radius: 6px;
            background: linear-gradient(90deg, #0d6efd, #00c9a7);
            flex-shrink: 0;
            min-width: 4px;
            transition: width 0.4s ease;
        }

        .va-progress-wrap span {
            font-size: 0.72rem;
            font-weight: 700;
            color: #0d6efd;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .va-stat-body h3 {
                font-size: 1.4rem;
            }

            .va-card {
                padding: 16px;
            }
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

                <input type="search" id="search" placeholder="Search Here ........" name="search"
                    class="form-control mx-4 w-100">

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



                    <!-- dasboard -->
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


                            </ul>
                        </div>
                    </li>





                    <!-- all user lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-user">
                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp; <span class="menu-title">All User</span>
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
                            <i class="fa fa-user-doctor" aria-hidden="true"></i>&nbsp; <span class="menu-title">All
                                OPD</span>
                        </a>
                    </li>


                    <!-- all pathology lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-pathology">
                            <i class="fa fa-syringe" aria-hidden="true"></i>&nbsp; <span class="menu-title">All
                                Pathology</span>
                        </a>
                    </li>


                    <!-- all doctor lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-doctors">
                            <i class="fa fa-stethoscope" aria-hidden="true"></i>&nbsp; <span class="menu-title">All
                                Doctors</span>
                        </a>
                    </li>



                    <!-- about us -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-aboutus">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; <span class="menu-title">About
                                Us</span>
                        </a>
                    </li>



                    <!-- blogs -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-blogs">
                            <i class="fa fa-blog" aria-hidden="true"></i>&nbsp; <span class="menu-title">Add
                                Blogs</span>
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
                                        href="/superadmin/super-add-subscriptions">Add Subscriptions</a>
                                </li>

                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-show-subscription">Show
                                        Subscriptions</a></li>

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

                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-opd-inquiry">All OPD Inq</a></li>

                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-path-inquiry">All Path Inq</a></li>


                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-doc-inquiry">All Doc Inq</a></li>


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

                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-all-tickets">All
                                        Tickets</a></li>

                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-ticket-replies">Replies</a>
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
                                    <h3 class="font-weight-bold">Welcome Back Super Admin</h3>

                                    <h6 class="font-weight-normal mb-0"><i
                                            class="fa-solid fa-heart text-danger"></i>&nbsp;It's Your Place sir! Manage
                                        everything you want.</h6>

                                </div>
                                <div class="col-12 col-xl-4">
                                    <div class="justify-content-end d-flex">
                                        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                            <button class="btn btn-sm btn-light bg-white" type="button">
                                                <i class="fa-solid fa-calendar-days"></i> Today ( <span id="currentDate"></span> )
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-4 grid-margin stretch-card">
                            <div class="card tale-bg">
                                <div class="card-people mt-auto">
                                    <img src="{{asset('../img/doc.jpg')}}" alt="people">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-7 grid-margin transparent">

                            <div class="row">


                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-add-partners" class="card card_green"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/add-user.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">Add
                                                    Partners</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-add-coupons" class="card card_blue"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/add-coupon.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">Add
                                                    Coupons</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-add-subscriptions" class="card card_orange"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/pay.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">Add
                                                    Subscription</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-all-tickets" class="card card_red"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/ticket.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">Ticket
                                                    Manage</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-all-doctors" class="card card_dim_blue"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/doctors.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">
                                                    All Doctor</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>



                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-all-pathology" class="card card_purple"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/tests.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">
                                                    All Pathology</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-all-opd" class="card card_dim_blue"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/5.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">
                                                    All OPD</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-all-user" class="card card_purple"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/2.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">
                                                    All Users</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>




                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-user-inquiry" class="card card_dark_blue"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/3.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">
                                                    User Inquiries</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-blogs" class="card card_ash_tyran"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/blog-post.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">
                                                    Blogs</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-opd-inquiry" class="card card_orange"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/4.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">
                                                    OPD Inquiries</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>



                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-path-inquiry" class="card card_green"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/6.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">
                                                    Path Inquiries</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-doc-inquiry" class="card card_purple"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/1.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">
                                                    Doc Inquiries</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-aboutus" class="card card_red"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/about.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">About Us</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>





                                <div class="col-md-4 mb-4 stretch-card transparent">
                                    <a href="/superadmin/super-all-feedback" class="card card_blue"
                                        style="cursor: pointer; text-decoration: none;">
                                        <div class="card-body">
                                            <div class="prof d-flex align-items-center">
                                                <img src="{{asset('../img/gif/feed.gif')}}" class="rounded" width="50" alt="">
                                                <p class="fs-30 m-0 p-0 ml-2 text-uppercase"
                                                    style="font-weight: 700; cursor: pointer; font-size: 1.1rem;">All Feedbacks</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>




                            </div>





                        </div>
                    </div>




                </div>


                <!-- Analitics in barchart -->
                {{-- ── Summary Stat Cards ── --}}
                <div class="row g-3 mb-4">

                    <div class="col-xl-3 col-md-6">
                        <div class="va-stat-card va-stat-blue">
                            <div class="va-stat-icon"><i class="fa-solid fa-users"></i></div>
                            <div class="va-stat-body">
                                <h3>{{ number_format($totalVisitors) }}</h3>
                                <p>Total Visitors</p>
                            </div>
                            <div class="va-stat-wave"></div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="va-stat-card va-stat-green">
                            <div class="va-stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
                            <div class="va-stat-body">
                                <h3>{{ number_format($todayVisitors) }}</h3>
                                <p>Today's Visitors</p>
                                @if($yesterdayCount > 0)
                                @php $change = round((($todayVisitors - $yesterdayCount) / $yesterdayCount) * 100, 1); @endphp
                                <span class="va-trend {{ $change >= 0 ? 'va-trend-up' : 'va-trend-down' }}">
                                    <i class="bi bi-arrow-{{ $change >= 0 ? 'up' : 'down' }}-right-circle-fill"></i>
                                    {{ abs($change) }}% vs yesterday
                                </span>
                                @endif
                            </div>
                            <div class="va-stat-wave"></div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="va-stat-card va-stat-purple">
                            <div class="va-stat-icon"><i class="fa-solid fa-fingerprint"></i></div>
                            <div class="va-stat-body">
                                <h3>{{ number_format($uniqueIPs) }}</h3>
                                <p>Unique IP Addresses</p>
                            </div>
                            <div class="va-stat-wave"></div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="va-stat-card va-stat-orange">
                            <div class="va-stat-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                            <div class="va-stat-body">
                                <h3>{{ number_format($yesterdayCount) }}</h3>
                                <p>Yesterday's Visitors</p>
                            </div>
                            <div class="va-stat-wave"></div>
                        </div>
                    </div>

                </div>

                {{-- ── Row 1: Daily Line Chart + Device Doughnut ── --}}
                <div class="row g-3 mb-4">

                    {{-- Daily Visitors – Last 30 Days --}}
                    <div class="col-xl-8 col-md-12">
                        <div class="va-card">
                            <div class="va-card-header">
                                <div class="va-card-title">
                                    <i class="fa-solid fa-arrow-trend-up"></i>
                                    <div>
                                        <h5>Daily Visitors</h5>
                                        <p>Last 30 days traffic overview</p>
                                    </div>
                                </div>
                                <span class="va-badge va-badge-blue">30 Days</span>
                            </div>
                            <div class="va-chart-wrap" style="height:260px">
                                <canvas id="dailyVisitorsChart"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Device Breakdown --}}
                    <div class="col-xl-4 col-md-12">
                        <div class="va-card">
                            <div class="va-card-header">
                                <div class="va-card-title">
                                    <i class="fa-solid fa-mobile-screen"></i>
                                    <div>
                                        <h5>Device Types</h5>
                                        <p>Desktop · Mobile · Tablet</p>
                                    </div>
                                </div>
                            </div>
                            <div class="va-chart-wrap" style="height:220px">
                                <canvas id="deviceChart"></canvas>
                            </div>
                            <div class="va-legend" id="deviceLegend"></div>
                        </div>
                    </div>

                </div>

                {{-- ── Row 2: Hourly Today + Browser + OS ── --}}
                <div class="row g-3 mb-4">

                    {{-- Hourly Today --}}
                    <div class="col-xl-5 col-md-12">
                        <div class="va-card">
                            <div class="va-card-header">
                                <div class="va-card-title">
                                    <i class="fa-solid fa-clock"></i>
                                    <div>
                                        <h5>Hourly Traffic</h5>
                                        <p>Today's visits by hour</p>
                                    </div>
                                </div>
                                <span class="va-badge va-badge-green">Today</span>
                            </div>
                            <div class="va-chart-wrap" style="height:220px">
                                <canvas id="hourlyChart"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Browser Breakdown --}}
                    <div class="col-xl-4 col-md-7">
                        <div class="va-card">
                            <div class="va-card-header">
                                <div class="va-card-title">
                                    <i class="fa-brands fa-chrome"></i>
                                    <div>
                                        <h5>Browsers</h5>
                                        <p>Top browsers used</p>
                                    </div>
                                </div>
                            </div>
                            <div class="va-chart-wrap" style="height:220px">
                                <canvas id="browserChart"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- OS Breakdown --}}
                    <div class="col-xl-3 col-md-5">
                        <div class="va-card">
                            <div class="va-card-header">
                                <div class="va-card-title">
                                    <i class="fa-solid fa-tv"></i>
                                    <div>
                                        <h5>OS</h5>
                                        <p>Operating systems</p>
                                    </div>
                                </div>
                            </div>
                            <div class="va-chart-wrap" style="height:220px">
                                <canvas id="osChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ── Row 3: Top Pages Table ── --}}
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <div class="va-card">
                            <div class="va-card-header">
                                <div class="va-card-title">
                                    <i class="fa-solid fa-link"></i>
                                    <div>
                                        <h5>Top Pages</h5>
                                        <p>Most visited URLs</p>
                                    </div>
                                </div>
                                <span class="va-badge va-badge-purple">Top 8</span>
                            </div>
                            <div class="table-responsive">
                                <table class="va-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Page URL</th>
                                            <th>Visits</th>
                                            <th>Share</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topPages as $i => $page)
                                        @php
                                        $share = $totalVisitors > 0 ? round(($page->total / $totalVisitors) * 100, 1) : 0;
                                        $shortUrl = strlen($page->page_url) > 60 ? substr($page->page_url, 0, 60) . '…' : $page->page_url;
                                        @endphp
                                        <tr>
                                            <td><span class="va-rank">{{ $i + 1 }}</span></td>
                                            <td>
                                                <a href="{{ $page->page_url }}" target="_blank" class="va-page-url" title="{{ $page->page_url }}">
                                                    <i class="bi bi-box-arrow-up-right"></i> {{ $shortUrl }}
                                                </a>
                                            </td>
                                            <td><strong>{{ number_format($page->total) }}</strong></td>
                                            <td>
                                                <div class="va-progress-wrap">
                                                    <div class="va-progress-bar" style="width: {{ $share }}%"></div>
                                                    <span>{{ $share }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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













    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{asset('../partner-assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('../partner-assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('../partner-assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('../partner-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('../partner-assets/js/dataTables.select.min.js')}}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('../partner-assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('../partner-assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('../partner-assets/js/template.js')}}"></script>
    <script src="{{asset('../partner-assets/js/settings.js')}}"></script>
    <script src="{{asset('../partner-assets/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{asset('../partner-assets/js/dashboard.js')}}"></script>
    <script src="{{asset('../partner-assets/js/Chart.roundedBarCharts.js')}}"></script>
    <!-- End custom js for this page-->


    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        (function() {

            // ── Shared palette ──────────────────────────────────────────
            const PALETTE = [
                '#0d6efd', '#0d9e5c', '#6f42c1', '#fd7c0d',
                '#dc3545', '#0d6e6e', '#e91e8c', '#ff9800',
                '#00bcd4', '#9c27b0'
            ];

            // ── Helper: fill missing dates in last 30 days ─────────────
            function buildDailyLabels() {
                const labels = [],
                    vals = [];
                for (let i = 29; i >= 0; i--) {
                    const d = new Date();
                    d.setDate(d.getDate() - i);
                    labels.push(d.toISOString().slice(0, 10));
                    vals.push(0);
                }
                return {
                    labels,
                    vals
                };
            }

            // ── 1. Daily Visitors Line Chart ───────────────────────────
            (function() {
                const {
                    labels,
                    vals
                } = buildDailyLabels();
                const raw = @json($dailyVisitors);

                raw.forEach(r => {
                    const idx = labels.indexOf(r.date);
                    if (idx !== -1) vals[idx] = r.total;
                });

                const shortLabels = labels.map(d => {
                    const dt = new Date(d);
                    return dt.toLocaleDateString('en-IN', {
                        month: 'short',
                        day: 'numeric'
                    });
                });

                new Chart(document.getElementById('dailyVisitorsChart'), {
                    type: 'line',
                    data: {
                        labels: shortLabels,
                        datasets: [{
                            label: 'Visitors',
                            data: vals,
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13,110,253,0.08)',
                            fill: true,
                            tension: 0.42,
                            pointBackgroundColor: '#0d6efd',
                            pointRadius: 3,
                            pointHoverRadius: 6,
                            borderWidth: 2.5,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0d1e3a',
                                titleFont: {
                                    weight: '800'
                                },
                                callbacks: {
                                    title: ctx => labels[ctx[0].dataIndex],
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 10,
                                    font: {
                                        size: 10
                                    },
                                    color: '#94a3b8',
                                    maxRotation: 0,
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f0f4ff'
                                },
                                ticks: {
                                    font: {
                                        size: 10
                                    },
                                    color: '#94a3b8',
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            })();

            // ── 2. Device Doughnut Chart ───────────────────────────────
            (function() {
                const raw = @json($deviceBreakdown);
                const labels = raw.map(r => r.device_type ?? 'Unknown');
                const data = raw.map(r => r.total);
                const colors = PALETTE.slice(0, labels.length);

                new Chart(document.getElementById('deviceChart'), {
                    type: 'doughnut',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            backgroundColor: colors,
                            borderWidth: 2,
                            borderColor: '#fff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0d1e3a'
                            }
                        }
                    }
                });

                // Custom legend
                const legend = document.getElementById('deviceLegend');
                labels.forEach((l, i) => {
                    legend.innerHTML += `<div class="va-legend-item">
                <div class="va-legend-dot" style="background:${colors[i]}"></div>${l} (${data[i]})
            </div>`;
                });
            })();

            // ── 3. Hourly Bar Chart (Today) ────────────────────────────
            (function() {
                const raw = @json($hourlyToday);
                const hours = Array.from({
                    length: 24
                }, (_, i) => i);
                const counts = hours.map(h => {
                    const found = raw.find(r => r.hour == h);
                    return found ? found.total : 0;
                });
                const labels = hours.map(h => h.toString().padStart(2, '0') + ':00');

                new Chart(document.getElementById('hourlyChart'), {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Visits',
                            data: counts,
                            backgroundColor: counts.map((_, i) => {
                                const now = new Date().getHours();
                                return i === now ? '#0d6efd' : 'rgba(13,110,253,0.18)';
                            }),
                            borderRadius: 6,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0d1e3a'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 8,
                                    font: {
                                        size: 9
                                    },
                                    color: '#94a3b8',
                                    maxRotation: 0
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f0f4ff'
                                },
                                ticks: {
                                    font: {
                                        size: 9
                                    },
                                    color: '#94a3b8',
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            })();

            // ── 4. Browser Horizontal Bar Chart ───────────────────────
            (function() {
                const raw = @json($browserBreakdown);
                const labels = raw.map(r => r.browser ?? 'Unknown');
                const data = raw.map(r => r.total);

                new Chart(document.getElementById('browserChart'), {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Users',
                            data,
                            backgroundColor: PALETTE.slice(0, labels.length),
                            borderRadius: 6,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0d1e3a'
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f0f4ff'
                                },
                                ticks: {
                                    font: {
                                        size: 9
                                    },
                                    color: '#94a3b8',
                                    precision: 0
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 10
                                    },
                                    color: '#333'
                                }
                            }
                        }
                    }
                });
            })();

            // ── 5. OS Polar Area Chart ─────────────────────────────────
            (function() {
                const raw = @json($osBreakdown);
                const labels = raw.map(r => r.os ?? 'Unknown');
                const data = raw.map(r => r.total);
                const colors = PALETTE.slice(0, labels.length);

                new Chart(document.getElementById('osChart'), {
                    type: 'polarArea',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            backgroundColor: colors.map(c => c + 'cc'),
                            borderColor: colors,
                            borderWidth: 1.5,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 9
                                    },
                                    padding: 8,
                                    boxWidth: 10
                                }
                            },
                            tooltip: {
                                backgroundColor: '#0d1e3a'
                            }
                        },
                        scales: {
                            r: {
                                ticks: {
                                    font: {
                                        size: 8
                                    },
                                    color: '#94a3b8',
                                    backdropColor: 'transparent'
                                },
                                grid: {
                                    color: '#f0f4ff'
                                }
                            }
                        }
                    }
                });
            })();

        })();
    </script>


    <script>
        function updateCurrentDate() {
            const today = new Date();
            const options = {
                year: 'numeric',
                month: 'short',
                day: '2-digit'
            };
            const formattedDate = today.toLocaleDateString('en-US', options);


            document.getElementById('currentDate').textContent = formattedDate;
        }


        updateCurrentDate();
    </script>
</body>

</html>