<body class="d-flex flex-column min-vh-100">
    <div class="page-content login-cover">
        <div class="content-wrapper">
            <div class="content-inner">

                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login form -->
                    <form class="login-form wmin-sm-400">
                        <div class="card mb-0">
                            <ul class="nav nav-tabs nav-tabs-underline nav-justified bg-light rounded-top mb-0">
                                <li class="nav-item">
                                    <a href="#login-tab1" class="nav-link active" data-bs-toggle="tab">
                                        <h6 class="my-1">Change Password</h6>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content card-body">
                                <div class="tab-pane fade show active" id="login-tab1">
                                    <div class="container-fluid d-flex justify-content-center align-items-center mb-3">
                                        <div class="d-inline-block me-2">
                                            <img src="/public/assets/images/logo_icon.png" style="height: 80px;" />
                                        </div>
                                        <div class="d-inline-block align-middle">
                                            <p class="mb-0 fw-bold">LINKAGE AND COLLABORATION</p>
                                            <h5 class="mb-0">INFORMATION SYSTEM</h5>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="text-center mb-3">
                                        <h5 class="mb-0">Change Password</h5>
                                        <span class="d-block text-muted">Enter your new password below</span>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label">New Password <span class="text-danger">*</span></label>
                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input type="password" id="user_password" class="form-control" placeholder="••••••••••••" required>
                                                <div class="form-control-feedback-icon">
                                                    <i class="ph ph-lock text-muted"></i>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input type="password" id="confirm_password" class="form-control" placeholder="••••••••••••" required>
                                                <div class="form-control-feedback-icon">
                                                    <i class="ph ph-lock text-muted"></i>
                                                </div>
                                                <div class="valid-feedback">Passwords match!</div>
                                                <div class="invalid-feedback">Passwords do not match.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button id="registerBtn" type="button" class="btn btn-primary w-100">Change Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /login form -->

                </div>

            </div>
        </div>
    </div>
    <script>
        $("#registerBtn").click(function() {
            swalInit.fire({
                text: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
            });

            $.ajax({
                url: '/resetPass',
                method: 'POST',
                data: {user_password: $("#user_password").val(), token: '<?=$token?>'},
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.success === 'false') {
                        swalInit.close();
                        swalInit.fire({
                            text: 'Password Reset failed!',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        swalInit.close();
                        swalInit.fire({
                            text: 'Password Reset success! you want to log out?',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location = '/';
                        });
                    }
                },
                error: function(error) {
                    swalInit.close();
                    swalInit.fire({
                        title: 'Error',
                        text: 'There is error occurred. Please contact the administrator.',
                        icon: 'error'
                    });
                    console.log("Error: ", error);
                }
            });

        });
    </script>
</body>

</html>