<body class="d-flex flex-column min-vh-100">
    <div class="page-content login-cover">
        <div class="content-wrapper">
            <div class="content-inner">

                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login form -->
                    <div class="login-form wmin-sm-400">
                        <div class="card mb-0">
                            <ul class="nav nav-tabs nav-tabs-underline nav-justified bg-light rounded-top mb-0">
                                <li class="nav-item">
                                    <a href="#login-tab1" class="nav-link active" data-bs-toggle="tab">
                                        <h6 class="my-1">Sign in</h6>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#login-tab2" class="nav-link" data-bs-toggle="tab">
                                        <h6 class="my-1">Register</h6>
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
                                        <h5 class="mb-0">External Partner Login</h5>
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
                                                <div class="invalid-feedback">Enter your username</div>
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

                                <div class="tab-pane fade" id="login-tab2">
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
                                        <h5 class="mb-0">Create New Account</h5>
                                    </div>

                                    <form id="registerForm">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" id="partner_name" class="form-control" placeholder="Kumatechnologies" required>
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph ph-building text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Company Address <span class="text-danger">*</span></label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" id="partner_address" class="form-control" placeholder="Dasmariñas, Cavite" required>
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-map-pin text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" id="partner_person" class="form-control" placeholder="Lance Kenji Parce" oninput="this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '')" required>
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label">Partner Contact <span class="text-danger">*</span></label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" id="partner_contact" class="form-control" placeholder="09638721664" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph ph-phone text-muted"></i>
                                                    </div>
                                                    <div class="invalid-feedback">Mobile number must be in the format 09xxxxxxxxx.</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Partner Position <span class="text-danger">*</span></label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" id="partner_position" class="form-control" placeholder="IT Specialist" required>
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph ph-user text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Telephone No.</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" id="partner_telephone" class="form-control" placeholder="XXX-XXXX-XXXX">
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph ph-phone text-muted"></i>
                                                    </div>
                                                    <div class="invalid-feedback">Telephone number must be in the format XXX-XXXX-XXXX.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="email" id="user_email" class="form-control" placeholder="john.doe@gmail.com" required>
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph ph-envelope text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="password" id="user_password" class="form-control" placeholder="••••••••••••" required>
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph ph-lock text-muted"></i>
                                                    </div>
                                                    <!-- <div class="valid-feedback">Passwords match!</div> -->
                                                    <div class="invalid-feedback" id="passwordHelp"></div>
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
                                                    <!-- <div class="invalid-feedback">Passwords do not match.</div> -->
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-teal w-100 registerBtn1">Register</button>
                                    </form>
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
                user_role: 'partner'
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
                            window.location = '/partner/dashboard';
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

        $("#registerForm").submit(function(e) {
            e.preventDefault();
            var formData = {
                partner_name: $("#partner_name").val(),
                partner_address: $("#partner_address").val(),
                partner_contact: $("#partner_contact").val(),
                partner_person: $("#partner_person").val(),
                partner_position: $("#partner_position").val(),
                partner_telephone: $("#partner_telephone").val(),
                user_email: $("#user_email").val(),
                user_password: $("#user_password").val(),
                user_role: 'partner'
            };

            swalInit.fire({
                text: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false
            });

            $.ajax({
                url: '/register',
                method: 'POST',
                data: formData,
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
                            text: 'Registered successfully!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location = '/partner/index';
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