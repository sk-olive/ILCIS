<?php $currentUrl = $_SERVER['REQUEST_URI']; ?>

<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-1">External Partner</h5>

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
                    <a href="/partner/profile" class="d-inline-flex justify-content-center">
                        <img id="partnerPhoto" src="<?= isset($_SESSION['partner_photo']) ? $_SESSION['partner_photo'] : '/public/assets/images/user.png' ?>" alt="" class="rounded-pill" style="width: 35px; height: 35px">
                    </a>
                    <div class="d-sm-inline-block ms-3">
                        <p id="partnerName" class="mb-0 fw-bold text-uppercase" style="font-size: 16px"><?=substr($_SESSION['partner_name'], 0, 19) . "<br>". substr($_SESSION['partner_name'], 19)?></p>
                        <p id="userEmail" class="mb-0"><?=substr($_SESSION['user_email'], 0, 30) . "<br>" . substr($_SESSION['user_email'], 30)?></p>
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
                    <a href="/partner/dashboard" class="nav-link <?= ($currentUrl == '/partner/dashboard') ? 'active fw-bold' : '' ?>">
                        <i class="ph ph-house"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/partner/appointments" class="nav-link <?= ($currentUrl == '/partner/appointments') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-calendar-dots"></i>
                        <span>
                            Appointments
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/partner/confidential_document" class="nav-link <?= ($currentUrl == '/partner/confidential_document') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-file-lock"></i>
                        <span>
                            Confidential Document
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu <?= ($currentUrl == '/partner/announcements' || $currentUrl == '/partner/events' || $currentUrl == '/partner/news') ? 'nav-item-open' : '' ?>">
                    <a href="#" class="nav-link">
                        <i class="ph ph-pencil-line"></i>
                        <span>Content Management</span>
                    </a>
                    <ul class="nav-group-sub collapse <?= ($currentUrl == '/partner/announcements' || $currentUrl == '/partner/events' || $currentUrl == '/partner/news') ? 'show' : '' ?>" id="content">
                        <!-- <li class="nav-item">
                            <a href="/partner/announcements" class="nav-link <?= ($currentUrl == '/partner/announcements') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-megaphone"></i>
                                Announcement
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="/partner/events" class="nav-link <?= ($currentUrl == '/partner/events') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-calendar-dots"></i>
                                Events
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/partner/news" class="nav-link <?= ($currentUrl == '/partner/news') ? 'active fw-bold' : ''; ?>">
                                <i class="ph ph-newspaper"></i>
                                News and Updates
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item mb-1">
                    <a href="/partner/linkage_and_partners" class="nav-link <?= ($currentUrl == '/partner/linkage_and_partners') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-handshake"></i>
                        <span>
                            Linkage and Partners
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/partner/institutional_membership" class="nav-link <?= ($currentUrl == '/partner/institutional_membership') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-users-four"></i>
                        <span>
                            Institutional Membership
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/partner/ojt_partners" class="nav-link <?= ($currentUrl == '/partner/ojt_partners') ? 'active fw-bold' : ''; ?>">
                        <i class="ph ph-users-three"></i>
                        <span>
                            OJT Partners
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                        <i class="ph ph-info"></i>
                        <span>
                            Inquiry
                        </span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#change_password">
                        <i class="ph ph-info"></i>
                        <span>
                            Change Password
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
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="inquiryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="inquiryModalLabel">Inquiry Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Name</label>
                            <input class="form-control" type="text" value="<?= $_SESSION['partner_name'] ?>" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input class="form-control" type="text" value="<?= $_SESSION['user_email'] ?>" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Telephone No.</label>
                            <input class="form-control" type="text" value="<?= $_SESSION['partner_telephone'] ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                            <textarea class="form-control" type="text" name="inquiry_subject" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Leave a message <span class="text-danger">*</span></label>
                            <textarea class="form-control" type="text" name="inquiry_message" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send Inquiry to Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var inquiryModal = new bootstrap.Modal(document.getElementById('inquiryModal'), {
            keyboard: true
        });

        $('#inquiryForm').submit(function(e) {
            e.preventDefault();
            swalInit.fire({
                text: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
            });
            $.ajax({
                type: "POST",
                url: "/partner/inquiry",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.success === 'false') {
                        swalInit.close();
                        swalInit.fire({
                            text: data.message,
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        swalInit.close();
                        swalInit.fire({
                            text: 'Inquiry sent successfully!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            inquiryModal.toggle();
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>

<div class="modal fade" id="change_password" tabindex="-1" aria-labelledby="change_passwordLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

    <form name="resetform" id="resetform" class="passform" method="post" role="form">
        <div class="modal-body">
    <h3>Change Your Password</h3>
    <br />
    <input type="hidden" name="user_email" value="<?php echo $user_email; ?>" ></input>

    <div class="col-12">
    <label>Enter Old Password <span class="text-danger">*</span></label>
    <div class="form-control-feedback form-control-feedback-start">
    <input type="password" class="form-control" name="user_password" id="user_password" placeholder="••••••••••••" required/>
    <div class="form-control-feedback-icon">
    <i class="ph ph-lock text-muted"></i>
    </div>
    </div>
        </div>

    <div class="col-12">
    <label class="form-label">Enter New Password <span class="text-danger">*</span></label>
    <div class="form-control-feedback form-control-feedback-start">
    <input type="password" id="new_password" class="form-control" name="new_password" placeholder="••••••••••••" required/>
    <div class="form-control-feedback-icon">
    <i class="ph ph-lock text-muted"></i>
    </div>
    </div>
        </div>

    <div class="row mb-3">
    <div class="col-12">
        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
        <div class="form-control-feedback form-control-feedback-start">
        <input type="password" id="con_password" name="con_newpassword" class="form-control" placeholder="••••••••••••" required/>
        <div class="form-control-feedback-icon">
        <i class="ph ph-lock text-muted"></i>
       </div>
         <div class="valid-feedback">Passwords match!</div>
          </div>
                                            </div>
                                        </div>
    <br>
</div>
    <div class="modal-footer">
    <input type="submit" class="btn btn-success" name="password_change" id="submit_btn" value="Change Password" />
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
</form>

<!--display success/error message-->
<div id="message"></div>
        </div>
    </div>
</div>


<?php

    if (isset($_POST['password_change'])) {

        $user_email = strip_tags($_POST['user_email']);
        $user_password = strip_tags($_POST['user_password']);
        $newpassword = strip_tags($_POST['new_password']);
        $confirmnewpassword = strip_tags($_POST['con_newpassword']);
        extract($data);
        // match username with the username in the database
        $sql = "SELECT * FROM `tbl_users` WHERE `user_password` = ? LIMIT 1";

        $query = $data->prepare($sql);
        $query->bindParam(1, $user_email, PDO::PARAM_STR);

        if($query->execute() && $query->rowCount()){
            $hash = $query->fetch();
            if ($user_password == $hash['user_password']){
                if($newpassword == $confirmnewpassword) {
                    $sql = "UPDATE `tbl_users` SET `user_password` = ? WHERE `user_email` = ?";

                    $query = $data->prepare($sql);
                    $query->bindParam(1, $newpassword, PDO::PARAM_STR);
                    $query->bindParam(2, $user_email, PDO::PARAM_STR);
                    if($query->execute()){
                        echo "Password Changed Successfully!";
                    }else{
                        echo "Password could not be updated";
                    }
                } else {
                    echo "Passwords do not match!";
                }
            }else{
                echo "Please type your current password accurately!";
            }
        }else{
            echo "Incorrect username";
        }
    }

?>

<script>
    
        $(document).ready(function() {
    var frm = $('#resetform');
    frm.submit(function(e){
        e.preventDefault();

        var formData = frm.serialize();
        formData += '&' + $('#submit_btn').attr('name') + '=' + $('#submit_btn').attr('value');
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: formData,
            success: function(data){
                $('#message').html(data).delay(3000).fadeOut(3000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#message').html(textStatus).delay(2000).fadeOut(2000);
            }

        });
    });
});
        $("#forgotForm").submit(function(e) {
            e.preventDefault();
            swalInit.fire({
                text: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
            });

        
    $.ajax({
    type: "post", 
    url: "",
    success: function (data) {
        //...
    },
    error: function (request, status, error) {
        console.log(request);
        console.log(status);
        console.log();
    }
});
</script>