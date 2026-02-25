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

        <a href="" data-bs-toggle="modal" data-bs-target="#userProfileModal" class="btn btn-primary ms-3">
            <i class="fa fa-user" aria-hidden="true"></i>
        </a>

    </div>
</nav>
<!-- Navbar End -->
@endauth

@auth
<!-- User Profile & Password Edit Modal -->
<div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body position-relative">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>



                <form class="text-center" method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    <h4 class="modal-title" id="userProfileModalLabel">User Profile</h4>
                    <p class="mb-4">Update your profile details</p>
                    <div class="row">


                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="user_name" name="user_name"
                                    value="{{ $user->user_name }}">
                                <label for="user_name">Name</label>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="user_email" name="user_email"
                                    value="{{ $user->user_email }}">
                                <label for="user_email">Email</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="user_mobile" name="user_mobile"
                                    value="{{ $user->user_mobile }}">
                                <label for="user_mobile">Mobile</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="user_city" name="user_city"
                                    value="{{ $user->user_city }}">
                                <label for="user_city">City</label>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <button type="submit" class="btn btn-primary py-3 col-md-12">Update Profile</button>
                            </div>
                        </div>



                    </div>
                </form>



                <form class="text-center form password-update" method="POST" action="{{ route('user.password.update') }}">
                    @csrf
                    <h4 class="modal-title" id="userProfileModalLabel">Security Privacy</h4>
                    <p class="mb-4">Update your account password</p>
                    <div class="row">


                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="user_old_password"
                                    value="*************">
                                <label for="user_old_password">Existing Password</label>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="user_password"
                                    name="user_password" placeholder="New Password">
                                <label for="user_password">New Password</label>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                <label for="user_password">Confirm Password</label>
                            </div>
                        </div>







                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <button type="submit" class="btn btn-primary py-3 col-md-12">Save Changes</button>
                            </div>
                        </div>



                    </div>
                </form>


                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <form method="POST" action="{{ route('user.logout') }}">
                            @csrf
                            <a class="btn btn-danger py-3 col-md-12" :href="route('user.logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Logout
                            </a>
                        </form>

                    </div>
                </div>






            </div>

        </div>
    </div>
</div>
@endauth

<!-- profile update success modal start -->
<div class="modal fade" id="profileUpdateSuccessModal" tabindex="-1" aria-labelledby="profileUpdateSuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                <h2 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> SUCCESS <span class="text-primary">+</span></h2>
                <h2 class="text-primary">Profile Updated Successfully</h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<!-- profile update success modal end -->
<!-- profile update Unsuccess modal start -->
<div class="modal fade" id="profileUpdateUnsuccessModal" tabindex="-1" aria-labelledby="profileUpdateUnsuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> ERROR <span class="text-primary">+</span></h3>
                <h4 class="text-danger">Profile Is Not Updated</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<!-- profile update Unsuccess modal end -->
<!-- password update success modal start -->
<div class="modal fade" id="passwordUpdateSuccessModal" tabindex="-1" aria-labelledby="passwordUpdateSuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> SUCCESS <span class="text-primary">+</span></h3>
                <h4 class="text-primary">Password Updated Successfully</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<!-- password update success modal end -->
<!-- password update Unsuccess modal start -->
<div class="modal fade" id="passwordUpdateUnsuccessModal" tabindex="-1" aria-labelledby="passwordUpdateUnsuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> ERROR <span class="text-primary">+</span></h3>
                <h4 class="text-danger">Password Is Not Updated</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<!-- password update Unsuccess modal end -->