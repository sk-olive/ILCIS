<?php $currentUrl = $_SERVER['REQUEST_URI']; ?>
<style>
    .dropdown-item.text-white.fw-bold:hover {
        color: black !important;
    }
</style>
<!-- Contact navbar -->
<div class="navbar navbar-light border-bottom border-bottom-white border-opacity-10 d-none d-lg-block">
    <div class="container-fluid text-center d-flex justify-content-center">
        <ul class="nav align-items-center">
            <li class="nav-item me-4 fw-bold">
                <i class="ph-fill ph-map-pin"></i>
                <a class="text-black text-decoration-none" href="https://www.google.com/maps/place/Cavite+State+University+-+Trece+Martires+Campus/@14.2830989,120.8758131,17z/data=!4m6!3m5!1s0x33bd80655363e331:0xa4247d4e2b9cbce8!8m2!3d14.2833061!4d120.8760517!16s%2Fg%2F11xnygdgb?entry=ttu">Brgy. Gregorio, Trece Martires City, Cavite 4109</a>
            </li>
            <li class="nav-item me-4 fw-bold">
                <i class="ph-fill ph-envelope"></i>
                <a class="text-black text-decoration-none" href="mailto:cvsutrecemartires@cvsu.edu.ph">cvsutrecemartires@cvsu.edu.ph</a>
            </li>
            <li class="nav-item me-4 fw-bold">
                <i class="ph-fill ph-phone"></i>
                <a class="text-black text-decoration-none" href="tel:046-866-4981">(046) 866 4981</a>
            </li>
        </ul>
    </div>
</div>
<!-- /contact navbar -->

<!-- Main navbar -->
<div class="navbar navbar-dark py-2 mb-0" style="background-color: #0C4B05">
    <div class="container-fluid">
        <div class="navbar-brand">
            <div class="d-inline-block me-2">
                <img src="/public/assets/images/Cavite_State_University_(CvSU).png" style="height: 50px;" />
            </div>
            <div class="d-inline-block align-middle">
                <h6 class="mb-0 d-none d-lg-block">CAVITE STATE UNIVERSITY - TRECE MARTIRES CITY CAMPUS</h6>
                <h6 class="mb-0 d-lg-none d-block">CVSU - TRECE CAMPUS</h6>
                <p class="mb-0 d-lg-block d-none">INTERNATIONALIZATION LINKAGE AND COLLABORATION</p>
                <small class="mb-0 d-lg-none d-block">INTERNATIONALIZATION LINKAGE AND<br>COLLABORATION</small>
            </div>
        </div>

        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-end-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="d-lg-flex justify-content-end align-items-center ms-auto fw-bold d-none">
            <ul class="nav flex-row justify-content-end order-1 order-lg-2">
                <li class="nav-item">
                    <a href="/" class="navbar-nav-link navbar-nav-link-icon rounded ms-1 <?= ($currentUrl == '/') ? 'active' : '' ?>">
                        <div class="d-flex align-items-center">
                            <span class="d-none d-md-inline-block">Home</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href=" #" class="navbar-nav-link align-items-center rounded ms-1" data-bs-toggle="dropdown">
                    <div class="d-flex align-items-center">
                        <span class="d-none d-md-inline-block me-2">About</span>
                        <i class="ph ph-caret-down"></i>
                    </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end shadow-1" style="background: #0C4B05">
                        <a href="/about" class="dropdown-item text-white fw-bold">
                            Vision, Mission, Objectives
                        </a>
                        <a href="/news" class="dropdown-item text-white fw-bold">
                            News Updates
                        </a>
                        <a href="/events" class="dropdown-item text-white fw-bold">
                            Events
                        </a>
                        <a href="/pool_of_experts" class="dropdown-item text-white fw-bold">
                            Pool of Experts
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="/partnership" class="navbar-nav-link navbar-nav-link-icon rounded ms-1 <?= ($currentUrl == '/partnerships') ? 'active' : '' ?>">
                        <div class="d-flex align-items-center">
                            <span class="d-none d-md-inline-block">Partnerships</span>
                        </div>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="/contact" class="navbar-nav-link navbar-nav-link-icon rounded ms-1 <?= ($currentUrl == '/contact') ? 'active' : '' ?>">
                        <div class="d-flex align-items-center">
                            <span class="d-none d-md-inline-block">Contact</span>
                        </div>
                    </a>
                </li> -->
                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href=" #" class="navbar-nav-link align-items-center rounded ms-1" data-bs-toggle="dropdown">
                    <div class="d-flex align-items-center">
                        <span class="d-none d-md-inline-block me-2">Log In</span>
                        <i class="ph ph-caret-down"></i>
                    </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end shadow-1" style="background: #0C4B05">
                        <a href="/student/index" class="dropdown-item text-white fw-bold">
                            <i class="ph-student me-2"></i>
                            Student
                        </a>
                        <a href="/partner/index" class="dropdown-item text-white fw-bold">
                            <i class="ph ph-users me-2"></i>
                            External Partner
                        </a>
                        <a href="/admin/index" class="dropdown-item text-white fw-bold">
                            <i class="ph ph-keyhole me-2"></i>
                            Admin
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

    });
</script>
<!-- /main navbar -->