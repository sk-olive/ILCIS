<body class="d-flex flex-column min-vh-100">
    <div class="page-content login-cover">
        <div class="content-wrapper">
            <div class="content-inner">

                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login form -->
                    <div class="login-form wmin-sm-400">
                        <div class="card mb-0">
                            <div class="card-body">
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
                                        <h5 class="mb-0">Admin Login</h5>
                                        <span class="d-block text-muted">Enter your credentials below</span>
                                    </div>

                                    <form id="loginForm">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input type="email" id="login_username" class="form-control" placeholder="john@doe.com" required>
                                                <div class="invalid-feedback">Enter your username</div>
                                                <div class="form-control-feedback-icon">
                                                    <i class="ph-user-circle text-muted"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input type="password" id="login_password" class="form-control" placeholder="•••••••••••" required>
                                                <div class="invalid-feedback">Enter your password</div>
                                                <div class="form-control-feedback-icon">
                                                    <i class="ph-lock text-muted"></i>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Enter your password</div>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                        </div>
                                    </form>

                                    <div class="text-center align-items-center mb-3">
                                        <a href="#" class="ms-auto" data-bs-toggle="modal" data-bs-target="#forgotPassword">Forgot password?</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /login form -->

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="forgotPassword" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="forgotForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Forgot Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row mb-3 text-center">
                                <div class="col-12">
                                    <h1>Having trouble signing in?</h1>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-12">
                                    <p>Enter your registered email address below. An email will be sent to this address for password reset confirmation.</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="email" id="forgot_email" class="form-control" placeholder="john.doe@gmail.com" required>
                                        <div class="form-control-feedback-icon">
                                            <i class="ph ph-at text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted">
                                        * If you do not receive the email shortly after the submission, please check your <b>SPAM</b> folder.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Send</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $("#loginForm").submit(function(e) {
            e.preventDefault();
            var formData = {
                user_email: $("#login_username").val(),
                user_password: $("#login_password").val(),
                user_role: 'admin'
            };

            swalInit.fire({
                text: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
            });

            $.ajax({
                url: '/login',
                method: 'POST',
                data: formData,
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.success === 'false') {
                        swalInit.close();
                        swalInit.fire({
                            text: 'Login failed!',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        swalInit.close();
                        swalInit.fire({
                            text: 'Logged in successfully!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location = '/admin/dashboard';
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
        $("#forgotForm").submit(function(e) {
            e.preventDefault();
            swalInit.fire({
                text: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
            });

            $.ajax({
                url: '/reset_password',
                method: 'POST',
                data: {forgot_email: $("#forgot_email").val()},
                success: function(data) {
                    data = JSON.parse(data);
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
                            text: 'Reset password link has been sent!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
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