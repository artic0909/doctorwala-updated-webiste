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
                    <a href="/opd" class="dropdown-item {{ request()->is('opd') ? 'active' : '' }}">OPD Details</a>
                    <a href="/doctor" class="dropdown-item {{ request()->is('doctor') ? 'active' : '' }}">Doctor Details</a>
                    <a href="/pathology" class="dropdown-item {{ request()->is('pathology') ? 'active' : '' }}">Pathology Details</a>
                </div>
            </div>

            <a href="/blog" class="nav-item nav-link {{ request()->is('blog') ? 'active' : '' }}">Blogs</a>

            <a href="/contact" class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>

            <a href="/privacy-policy" class="nav-item nav-link {{ request()->is('privacy-policy') ? 'active' : '' }}">Privacy Policy</a>

        </div>

        <a href="/dw/user-auth" class="btn btn-primary py-2 px-4 ms-3">Login</a>

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
                    <a href="/dw/opd" class="dropdown-item {{ request()->is('dw/opd') ? 'active' : '' }}">OPD Details</a>
                    <a href="/dw/doctor" class="dropdown-item {{ request()->is('dw/doctor') ? 'active' : '' }}">Doctor Details</a>
                    <a href="/dw/pathology" class="dropdown-item {{ request()->is('dw/pathology') ? 'active' : '' }}">Pathology Details</a>
                </div>
            </div>

            <a href="/dw/blog" class="nav-item nav-link {{ request()->is('dw/blog') ? 'active' : '' }}">Blogs</a>

            <a href="/dw/contact" class="nav-item nav-link {{ request()->is('dw/contact') ? 'active' : '' }}">Contact</a>

            <a href="/dw/privacy-policy" class="nav-item nav-link {{ request()->is('dw/privacy-policy') ? 'active' : '' }}">Privacy Policy</a>

        </div>

        <a href="/dw/profile"class="btn btn-primary ms-3">
            <i class="fa fa-user" aria-hidden="true"></i>
        </a>

    </div>
</nav>
<!-- Navbar End -->
@endauth