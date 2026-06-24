@guest
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
    <a href="/" class="navbar-brand p-0">
        <img class="m-0 nav-bar-logo" src="{{asset('img/logoo.png')}}" width="300" alt="DoctorWala">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">

            <a href="/" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>

            <a href="/about" class="nav-item nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->is('opd') || request()->is('doctor') || request()->is('pathology') ? 'active' : '' }}"
                    data-bs-toggle="dropdown">
                    Search
                </a>
                <div class="dropdown-menu m-0">
                    <a href="/opd" class="dropdown-item {{ request()->is('opd') ? 'active' : '' }}">OPD Doctors</a>
                    <a href="/pathology" class="dropdown-item {{ request()->is('pathology') ? 'active' : '' }}">Test Pathology</a>
                    <a href="/doctor" class="dropdown-item {{ request()->is('doctor') ? 'active' : '' }}">Direct to Doctors</a>
                </div>
            </div>

            <a href="/blog" class="nav-item nav-link {{ request()->is('blog') ? 'active' : '' }}">Blogs</a>

            <a href="/contact" class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>

            <a href="/privacy-policy" class="nav-item nav-link {{ request()->is('privacy-policy') ? 'active' : '' }}">Privacy Policy</a>

        </div>

        <a href="/appdownload" class="btn btn-success py-2 px-4 ms-3"><i class="fa fa-download me-2"></i>Download App</a>
        <button data-bs-toggle="modal" data-bs-target="#loginSelectionModal" class="btn btn-primary py-2 px-4 ms-3">Login</button>

    </div>
</nav>
<!-- Navbar End -->
@endguest



@auth
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
    <a href="/dw" class="navbar-brand p-0">
        <img class="m-0 nav-bar-logo" src="{{asset('img/logoo.png')}}" width="300" alt="DoctorWala">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">

            <a href="/dw" class="nav-item nav-link {{ request()->is('dw') ? 'active' : '' }}">Home</a>

            <a href="/dw/about" class="nav-item nav-link {{ request()->is('dw/about') ? 'active' : '' }}">About</a>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->is('dw/opd') || request()->is('dw/doctor') || request()->is('dw/pathology') ? 'active' : '' }}"
                    data-bs-toggle="dropdown">
                    Search
                </a>
                <div class="dropdown-menu m-0">
                    <a href="/dw/opd" class="dropdown-item {{ request()->is('dw/opd') ? 'active' : '' }}">OPD Doctors</a>
                    <a href="/dw/pathology" class="dropdown-item {{ request()->is('dw/pathology') ? 'active' : '' }}">Test Pathology</a>
                    <a href="/dw/doctor" class="dropdown-item {{ request()->is('dw/doctor') ? 'active' : '' }}">Direct to Doctors</a>
                </div>
            </div>

            <a href="/dw/blog" class="nav-item nav-link {{ request()->is('dw/blog') ? 'active' : '' }}">Blogs</a>

            <a href="/dw/contact" class="nav-item nav-link {{ request()->is('dw/contact') ? 'active' : '' }}">Contact</a>

            <a href="/dw/privacy-policy" class="nav-item nav-link {{ request()->is('dw/privacy-policy') ? 'active' : '' }}">Privacy Policy</a>

        </div>

        <a href="/appdownload" class="btn btn-success py-2 px-4 ms-3"><i class="fa fa-download me-2"></i>Download App</a>

        <a href="/dw/profile"class="btn btn-primary ms-3">
            <i class="fa fa-user" aria-hidden="true"></i>
        </a>

    </div>
</nav>
<!-- Navbar End -->
@endauth

<!-- Login Selection Modal -->
<div class="modal fade" id="loginSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4 bg-light">
                <h4 class="modal-title fw-bold text-dark">Welcome to Doctorwala</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <p class="text-muted text-center mb-4">Please select how you would like to proceed</p>
                <div class="row g-4">
                    <div class="col-md-6">
                        <a href="/dw/user-auth" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm rounded-4 text-center transition-all bg-white" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(13,110,253,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                                <div class="card-body p-4">
                                    <div class="rounded-circle d-inline-flex p-4 mb-3" style="background-color: rgba(13, 110, 253, 0.1);">
                                        <i class="fa fa-user fa-3x text-primary"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark mb-3">User or Patient</h4>
                                    <p class="text-muted mb-0" style="font-size: 0.95rem;">Login to find doctors, book appointments, schedule tests, and manage your medical records.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="/partner-register" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm rounded-4 text-center transition-all bg-white" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(25,135,84,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                                <div class="card-body p-4">
                                    <div class="rounded-circle d-inline-flex p-4 mb-3" style="background-color: rgba(25, 135, 84, 0.1);">
                                        <i class="fa fa-clinic-medical fa-3x text-success"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark mb-3">Partner</h4>
                                    <p class="text-muted mb-0" style="font-size: 0.95rem;">Doctor Chambers, Labs, Individual Doctors & all types of Healthcare Providers.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>