<div class="sidebar sidebar-dark sidebar-end sidebar-expand-lg d-lg-none d-block" style="background-color: #0C4B05">

    <!-- Expand button -->
    <button type="button" class="btn btn-sidebar-expand sidebar-control sidebar-end-toggle h-100">
        <i class="ph-caret-left"></i>
    </button>
    <!-- /expand button -->


    <!-- Sidebar content -->
    <div class="sidebar-content text-white">

        <!-- Header -->
        <div class="sidebar-section sidebar-section-body d-flex align-items-center pb-2">
            <h5 class="mb-0">Navigation</h5>
            <div class="ms-auto">
                <button type="button" class="text-white btn border-transparent btn-icon btn-sm sidebar-mobile-end-toggle d-lg-none">
                    <i class="ph-x"></i>
                </button>
            </div>
        </div>
        <!-- /header -->

        <!-- Sub navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar mt-2" data-nav-type="accordion">
                <li class="nav-item">
                    <a href="/" class="nav-link fw-bold rounded ms-1 <?= ($currentUrl == '/') ? 'active' : '' ?>">
                        <div class="d-flex align-items-center">
                            <span class="d-inline-block">Home</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link fw-bold align-items-center rounded ms-1">
                        <div class="d-flex align-items-center">
                            <span class="d-inline-block me-2">About</span>
                        </div>
                    </a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a href="/about" class="nav-link text-white fw-bold">
                                Vision, Mission, Objectives
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/news" class="nav-link text-white fw-bold">
                               News Updates
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/events" class="nav-link text-white fw-bold">
                                Events
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/pool_of_experts" class="nav-link text-white fw-bold">
                                Pool of Experts
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/partnerships" class="nav-link fw-bold rounded ms-1 <?= ($currentUrl == '/partnerships') ? 'active' : '' ?>">
                        <div class="d-flex align-items-center">
                            <span class="d-inline-block">Partnerships</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/contact" class="nav-link fw-bold rounded ms-1 <?= ($currentUrl == '/contact') ? 'active' : '' ?>">
                        <div class="d-flex align-items-center">
                            <span class="d-inline-block">Contact</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link fw-bold align-items-center rounded ms-1">
                        <div class="d-flex align-items-center">
                            <span class="d-inline-block me-2">Log In</span>
                        </div>
                    </a>


                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a href="/student/index" class="nav-link text-white fw-bold">
                                <i class="ph-student me-2"></i>
                                Student
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/partner/index" class="nav-link text-white fw-bold">
                                <i class="ph ph-users me-2"></i>
                                External Partner
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/index" class="nav-link text-white fw-bold">
                                <i class="ph ph-keyhole me-2"></i>
                                Admin
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /sub navigation -->

    </div>
    <!-- /sidebar content -->

</div>