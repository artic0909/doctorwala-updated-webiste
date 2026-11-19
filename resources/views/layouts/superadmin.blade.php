<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin Console | Doctorwala')</title>

    <!-- Favicon -->
    <link href="{{ asset('fav5.png') }}" rel="icon">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Themify Icons -->
    <link rel="stylesheet" href="{{ asset('partner-assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('partner-assets/vendors/css/vendor.bundle.base.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('partner-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('partner-assets/js/select.dataTables.min.css') }}">

    <!-- Base Framework CSS -->
    <link rel="stylesheet" href="{{ asset('partner-assets/css/vertical-layout-light/style.css') }}?v={{ file_exists(public_path('partner-assets/css/vertical-layout-light/style.css')) ? filemtime(public_path('partner-assets/css/vertical-layout-light/style.css')) : time() }}">

    <!-- Modern Doctor Vibe White Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/doctor-theme.css') }}?v={{ file_exists(public_path('css/doctor-theme.css')) ? filemtime(public_path('css/doctor-theme.css')) : time() }}">

    @stack('styles')
</head>

<body class="sidebar-fixed">
    <div class="container-scroller">
        <!-- Top Navbar -->
        @include('superadmin.includes._navbar')

        <div class="container-fluid page-body-wrapper">
            <!-- Centralized Sidebar -->
            @include('superadmin.includes._sidebar')

            <!-- Main Panel -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Global Session Alerts -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px; background: #dcfce7; color: #15803d; border-left: 4px solid #10b981 !important;">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-check mr-2 fa-lg"></i>
                            <div>
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                        </div>
                        <button type="button" class="close text-success" data-dismiss="alert" aria-label="Close" style="opacity: 0.8;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px; background: #fee2e2; color: #b91c1c; border-left: 4px solid #ef4444 !important;">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-exclamation mr-2 fa-lg"></i>
                            <div>
                                <strong>Error!</strong> {{ session('error') }}
                            </div>
                        </div>
                        <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close" style="opacity: 0.8;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(isset($errors) && $errors->any())
                    <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px; background: #fef3c7; color: #b45309; border-left: 4px solid #f59e0b !important;">
                        <div class="d-flex align-items-start">
                            <i class="fa-solid fa-triangle-exclamation mr-2 mt-1"></i>
                            <div>
                                <strong>Please check the following:</strong>
                                <ul class="mb-0 pl-3 mt-1">
                                    @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="close text-warning" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <!-- Dynamic Page Content -->
                    @yield('content')
                </div>

                <!-- Footer -->
                @include('superadmin.includes._footer')
            </div>
        </div>
    </div>

    <!-- Core Scripts -->
    <script src="{{ asset('partner-assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('partner-assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('partner-assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('partner-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('partner-assets/js/dataTables.select.min.js') }}"></script>

    <script src="{{ asset('partner-assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('partner-assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('partner-assets/js/template.js') }}"></script>
    <script src="{{ asset('partner-assets/js/settings.js') }}"></script>
    <script src="{{ asset('partner-assets/js/todolist.js') }}"></script>

    @stack('scripts')
</body>

</html>
