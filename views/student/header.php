<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10 my-0 py-0" style="background: #095C00">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="index.html" class="d-inline-flex align-items-center">
                <img src="/public/assets/images/logo_icon.png" alt="" style="width: 60px; height: 50px">
            </a>
            <div class="d-none d-sm-inline-block ms-3">
                <p class="mb-0 fw-bold">LINKAGE AND COLLABORATION</p>
                <h6 class="mb-0">INFORMATION SYSTEM</h6>
            </div>
        </div>

        <ul class="nav flex-row"></ul>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        <img id="studentPhoto1" src="<?= isset($_SESSION['student_photo']) ? $_SESSION['student_photo'] : '/public/assets/images/user.png' ?>" class="w-32px h-32px rounded-pill" alt="">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span id="studentName1" class="d-none d-lg-inline-block mx-lg-2"><?= $_SESSION['student_fname'] . " " . $_SESSION['student_lname'] ?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="/student/profile" class="dropdown-item">
                        <i class="ph-user-circle me-2"></i>
                        My profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/logout" class="dropdown-item">
                        <i class="ph-sign-out me-2"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>