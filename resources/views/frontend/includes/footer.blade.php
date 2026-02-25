    <!-- marquee text start -->
    <marquee id="marqueeText"
        style="background: #051225; color: white; padding: 10px; position: fixed; bottom: 0; width: 100%; z-index: 1000;">
        Welcome to <b>Doctorwala.info</b> !! In addition
        to doctors, we also connect you with pathologists and OPDs. If you require diagnostic services or need to visit
        an OPD for consultation, DoctorWala.info is your go-to platform. We collaborate with trusted pathologists and
        OPDs to ensure that you receive accurate and timely medical tests and consultations. for more information feel
        free to call us or write us directly at <b>info.doctorwala@gmail.com</b>
    </marquee>
    <!-- marquee text end -->


    <!-- Footer Start -->
    <div class="container-fluid text-light py-4 footer-content"
        style="background: #051225; position: relative; z-index: 1001;">
        <div class="">
            <div class="footer-content-inner">

                <div class="text-center text-md-start">
                    <p class="mb-md-0">&copy; <a class="text-white border-bottom"
                            href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" target="_blank">DoctorWala.info</a>. All
                        Rights Reserved.</p>
                </div>

                <!-- <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Designed by <a class="text-white border-bottom" href="https://htmlcodex.com">HTML
                            Codex</a><br>
                        Distributed by <a class="text-white border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </p>
                </div> -->

                <div class="">
                    <div class="d-flex">
                        <a class="btn btn-lg btn-dark btn-lg-square rounded me-2 btn-footer" href="#"><i
                                class="fab fa-twitter fw-normal"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square rounded me-2 btn-footer" href="#"><i
                                class="fab fa-facebook-f fw-normal"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square rounded me-2 btn-footer" href="#"><i
                                class="fab fa-linkedin-in fw-normal"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square rounded btn-footer" href="#"><i
                                class="fab fa-instagram fw-normal"></i></a>
                    </div>
                </div>


                <div class="login-partner">
                    @guest
                    <a href="/partner-login" class="btn btn-dark btn-lg rounded me-2">Login As Partner</a>
                    @endguest

                    @auth
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <a class="btn btn-dark btn-lg rounded me-2" :href="route('user.logout')"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            Logout
                        </a>
                    </form>
                    @endauth
                </div>


            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Global Search Section========================================================================================= -->
    <!-- ── Floating Search FAB ── -->
    <button class="gs-fab" id="gsOpenBtn" title="Search Everything">
        <i class="bi bi-search"></i>
        <span class="gs-fab-ring"></span>
    </button>

    <!-- ── Global Search Modal Overlay ── -->
    <div class="gs-overlay" id="gsOverlay">
        <div class="gs-modal" id="gsModal" role="dialog" aria-modal="true" aria-label="Global Search">

            <!-- Header -->
            <div class="gs-modal-header">
                <div class="gs-modal-icon">
                    <i class="bi bi-search"></i>
                </div>
                <div class="gs-modal-title">
                    <h4>Search Your Nearby Doctors</h4>
                    <p>Doctor's name · Clinic's Name · Using Location</p>
                </div>
                <button class="gs-modal-close" id="gsCloseBtn" aria-label="Close">
                    <i class="bi bi-x-lg">X</i>
                </button>
            </div>

            <!-- Search Form — submits to search-result page -->
            @guest
            <form action="{{ route('search.result') }}" method="GET" class="gs-form" id="gsForm">
                <div class="gs-input-group">
                    <i class="bi bi-search gs-input-icon"></i>
                    <input
                        type="text"
                        name="query"
                        id="gsInput"
                        class="gs-input"
                        placeholder="Type doctor name, clinic, test, city..."
                        autocomplete="off"
                        spellcheck="false"
                        required />
                    <button type="submit" class="gs-search-btn">
                        <i class="bi bi-arrow-right-circle-fill"></i>
                    </button>
                </div>

                <!-- Category chips -->
                <div class="gs-chips-row">
                    <span class="gs-chip-label">Filter:</span>
                    <label class="gs-chip gs-chip-all active-chip">
                        <input type="radio" name="category" value="all" checked hidden> All
                    </label>
                    <label class="gs-chip gs-chip-doc">
                        <input type="radio" name="category" value="doctor" hidden>
                        <i class="bi bi-person-heart-fill"></i> Direct to Doctors
                    </label>
                    <label class="gs-chip gs-chip-opd">
                        <input type="radio" name="category" value="opd" hidden>
                        <i class="bi bi-hospital-fill"></i> OPD Doctors
                    </label>
                    <label class="gs-chip gs-chip-path">
                        <input type="radio" name="category" value="pathology" hidden>
                        <i class="bi bi-flask-fill"></i> Test Pathology
                    </label>
                </div>
            </form>
            @endguest
            @auth
            <form action="{{ route('dw.search.result') }}" method="GET" class="gs-form" id="gsForm">
                <div class="gs-input-group">
                    <i class="bi bi-search gs-input-icon"></i>
                    <input
                        type="text"
                        name="query"
                        id="gsInput"
                        class="gs-input"
                        placeholder="Type doctor name, clinic, test, city..."
                        autocomplete="off"
                        spellcheck="false"
                        required />
                    <button type="submit" class="gs-search-btn">
                        <i class="bi bi-arrow-right-circle-fill"></i>
                    </button>
                </div>

                <!-- Category chips -->
                <div class="gs-chips-row">
                    <span class="gs-chip-label">Filter:</span>
                    <label class="gs-chip gs-chip-all active-chip">
                        <input type="radio" name="category" value="all" checked hidden> All
                    </label>
                    <label class="gs-chip gs-chip-doc">
                        <input type="radio" name="category" value="doctor" hidden>
                        <i class="bi bi-person-heart-fill"></i> Doctors
                    </label>
                    <label class="gs-chip gs-chip-opd">
                        <input type="radio" name="category" value="opd" hidden>
                        <i class="bi bi-hospital-fill"></i> OPD
                    </label>
                    <label class="gs-chip gs-chip-path">
                        <input type="radio" name="category" value="pathology" hidden>
                        <i class="bi bi-flask-fill"></i> Pathology
                    </label>
                </div>
            </form>
            @endauth

            <!-- Quick tags -->
            <div class="gs-quick-tags">
                <span class="gs-quick-label">Popular:</span>
                <button type="button" class="gs-quick-tag" data-val="Cardiologist">Cardiologist</button>
                <button type="button" class="gs-quick-tag" data-val="Blood Test">Blood Test</button>
                <button type="button" class="gs-quick-tag" data-val="Urine Test">Urine Test</button>
                <button type="button" class="gs-quick-tag" data-val="Eye Specialist">Eye Specialist</button>
                <button type="button" class="gs-quick-tag" data-val="X-Ray">X-Ray</button>
                <button type="button" class="gs-quick-tag" data-val="Skin">Skin Doctor</button>
                <button type="button" class="gs-quick-tag" data-val="Dentist">Dentist</button>
                <button type="button" class="gs-quick-tag" data-val="Orthopedic">Orthopedic</button>
                <button type="button" class="gs-quick-tag" data-val="Pediatrician">Pediatrician</button>
                <button type="button" class="gs-quick-tag" data-val="General Physician">General Physician</button>
                <button type="button" class="gs-quick-tag" data-val="General Surgeon">General Surgeon</button>
                <button type="button" class="gs-quick-tag" data-val="Gynecologist">Gynecologist</button>

            </div>

            <!-- ESC hint -->
            <p class="gs-esc-hint">Press <kbd>ESC</kbd> to close &nbsp;·&nbsp; <kbd>Enter</kbd> to search</p>


            <!-- Branding logo -->
            <div class="gs-brand-logo">
                <img src="{{asset('../img/logoo.png')}}" alt="Logo" class="gs-brand-img">
            </div>
        </div>
    </div>
    <!-- Global Search Section========================================================================================= -->




    <!-- PARTNER REGISTER BUTTON -->
    @guest
    <a href="/partner-register" class="btn btn-lg btn-dark2 btn-lg-square rounded partner-login">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <span class="showing-text"> Partner Register</span>
    </a>
    @endguest
    @auth
    @endauth




    @if(session('password_update_status') == 'success')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = new bootstrap.Modal(document.getElementById('passwordUpdateSuccessModal'));
            successModal.show();
        });
    </script>
    @elseif(session('password_update_status') == 'failure')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const failureModal = new bootstrap.Modal(document.getElementById('passwordUpdateUnsuccessModal'));
            failureModal.show();
        });
    </script>
    @endif

    @if(session('profile_update_status') == 'success')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = new bootstrap.Modal(document.getElementById('profileUpdateSuccessModal'));
            successModal.show();
        });
    </script>
    @elseif(session('profile_update_status') == 'failure')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const failureModal = new bootstrap.Modal(document.getElementById('profileUpdateUnsuccessModal'));
            failureModal.show();
        });
    </script>
    @endif