<?php $currentUrl = $_SERVER['REQUEST_URI']; ?>

<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-1">Administrator</h5>

                <div>
                    <button type="button" class="btn btn-flat-black btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button" class="btn btn-flat-black btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
            <hr class="m-0 p-0">
            <div class="container-fluid d-flex flex-column mt-3 pb-2 mb-2">
                <div class="navbar-brand flex-1 flex-lg-0">
                    <a class="d-inline-flex justify-content-center">
                        <img src="/public/assets/images/user.png" alt="" style="width: 35px; height: 35px">
                    </a>
                    <div class="d-sm-inline-block ms-3">
                        <p class="mb-0 fw-bold text-uppercase" style="font-size: 15px">Admin</p>
                        <p class="mb-0"><?=substr($_SESSION['user_email'], 0, 30) . "<br>" . substr($_SESSION['user_email'], 30)?></p>
                    </div>
                </div>
            </div>
            <hr class="m-0 p-0">
        </div>
        <!-- /sidebar header -->

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide fw-bold">General</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                <li class="nav-item mb-1">
                    <a href="/admin/dashboard" class="nav-link <?= ($currentUrl == '/admin/dashboard') ? 'active fw-bold' : '' ?>">
                        <i class="ph ph-house"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                <!-- <li class="nav-item mb-1">
                    <a href="/admin/messages" class="nav-link <?= ($currentUrl == '/admin/messages') ? 'active fw-bold' : ''; ?>">
                        <i class="ph-fill ph-chat"></i>
                        <span>
                            Messages
                        </span>
                    </a>
                </li> -->
                <li class="nav-item mb-1">
                    <a href="/admin/students" class="nav-link <?= ($currentUrl == '/admin/students') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-user-list"></i>
                        <span>
                            List of Students
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin/partners" class="nav-link <?= ($currentUrl == '/admin/partners') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-user-list"></i>
                        <span>
                            List of External Partners
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin/confidential_document" class="nav-link <?= ($currentUrl == '/admin/confidential_document') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-file-lock"></i>
                        <span>
                            Confidential Document
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu <?= ($currentUrl == '/admin/for_approvals' || $currentUrl == '/admin/announcements' || $currentUrl == '/admin/events' || $currentUrl == '/admin/news') ? 'nav-item-open' : '' ?>">
                    <a href="#" class="nav-link">
                        <i class="ph ph-pencil-line"></i>
                        <span>Content Management</span>
                    </a>
                    <ul class="nav-group-sub collapse <?= ($currentUrl == '/admin/for_approvals' || $currentUrl == '/admin/announcements' || $currentUrl == '/admin/events' || $currentUrl == '/admin/news') ? 'show' : '' ?>" id="content">
                        <li class="nav-item">
                            <a href="/admin/for_approvals" class="nav-link <?= ($currentUrl == '/admin/for_approvals') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-check-circle"></i>
                                Post Approval
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="/admin/announcements" class="nav-link <?= ($currentUrl == '/admin/announcements') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-megaphone"></i>
                                Announcement
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="/admin/events" class="nav-link <?= ($currentUrl == '/admin/events') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-calendar-dots"></i>
                                Events
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/news" class="nav-link <?= ($currentUrl == '/admin/news') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-newspaper"></i>
                                News and Updates
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu <?= ($currentUrl == '/admin/linkage_and_partners' || $currentUrl == '/admin/ojt_partners' || $currentUrl == '/admin/institutional_membership') ? 'nav-item-open' : '' ?>" id="partners">
                    <a href="#" class="nav-link">
                        <i class="ph ph-handshake"></i>
                        <span>Partners</span>
                    </a>
                    <ul class="nav-group-sub collapse <?= ($currentUrl == '/admin/linkage_and_partners' || $currentUrl == '/admin/ojt_partners') ? 'show' : '' ?>">
                        <li class="nav-item">
                            <a href="/admin/linkage_and_partners" class="nav-link <?= ($currentUrl == '/admin/linkage_and_partners') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-handshake"></i>
                                Linkage and Partners
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/institutional_membership" class="nav-link <?= ($currentUrl == '/admin/institutional_membership') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-users-four"></i>
                                Institutional Membership
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/ojt_partners" class="nav-link <?= ($currentUrl == '/admin/ojt_partners') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-users-three"></i>
                                OJT Partners
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/ojt_partners" class="nav-link <?= ($currentUrl == '/admin/ojt_partners') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-users-three"></i>
                                In-Active Partners
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin/pool_of_experts" class="nav-link <?= ($currentUrl == '/admin/pool_of_experts') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-users-three"></i>
                        <span>
                            Pool of Expert
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin/appointments" class="nav-link <?= ($currentUrl == '/student/messages') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-calendar-dots"></i>
                        <span>
                            Appointments
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin/inquiry" class="nav-link <?= ($currentUrl == '/admin/inquiry') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-info"></i>
                        <span>
                            Inquiry
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/logout" class="nav-link">
                        <i class="ph ph-sign-out"></i>
                        <span>
                            Sign Out
                        </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->