<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Super | Partner Importer</title>

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
                    <!-- dashboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-dashboard">
                            <i class="fa-solid fa-chart-pie"></i>&nbsp; <span class="menu-title">Dashboard</span>
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
                                        
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ route('superadmin.importer.index') }}">CSV Importer</a></li>

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
                                <div class="col-12">
                                    <h3 class="font-weight-bold">Partner CSV Importer</h3>
                                    
                                    @if(session('success'))
                                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                                    @endif
                                    @if(session('error'))
                                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                                    @endif
                                    @if($errors->any())
                                        <div class="alert alert-danger mt-3">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-4">
                                                <h4 class="card-title mb-0">Upload CSV File</h4>
                                                <a href="{{ route('superadmin.importer.template') }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fa-solid fa-download"></i> Download Template
                                                </a>
                                            </div>
                                            
                                            <p class="text-muted">
                                                Upload a CSV file to mass-register partners. The system will automatically create the Partner profiles, OPD/Pathology contact profiles, assign the default coupon code (<b>DWCPNFREE01</b>), and send a WhatsApp welcome message to each successfully imported partner.
                                            </p>
                                            
                                            <form action="{{ route('superadmin.importer.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group mt-3">
                                                    <label for="csv_file" class="font-weight-bold">Select CSV File <span class="text-danger">*</span></label>
                                                    <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required style="height: auto; padding: 10px;">
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary mt-3 font-weight-bold">
                                                    <i class="fa-solid fa-upload"></i> Start Import
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    @if(session('results'))
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Import Status Report</h4>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th style="font-weight: bold;">Row #</th>
                                                            <th style="font-weight: bold;">Clinic Name</th>
                                                            <th style="font-weight: bold;">Status</th>
                                                            <th style="font-weight: bold;">Message / Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach(session('results') as $res)
                                                        <tr>
                                                            <td>{{ $res['row'] }}</td>
                                                            <td>{{ $res['clinic'] }}</td>
                                                            <td>
                                                                @if($res['status'] === 'Success')
                                                                    <span class="badge badge-success text-white px-3 py-2"><i class="fa-solid fa-check"></i> Success</span>
                                                                @elseif($res['status'] === 'Warning')
                                                                    <span class="badge badge-warning text-dark px-3 py-2"><i class="fa-solid fa-triangle-exclamation"></i> Skipped</span>
                                                                @else
                                                                    <span class="badge badge-danger text-white px-3 py-2"><i class="fa-solid fa-circle-xmark"></i> Error</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $res['message'] }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
    <script src="{{asset('../partner-assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('../partner-assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('../partner-assets/js/template.js')}}"></script>
</body>
</html>
