<div class="navbar navbar-sm navbar-footer sticky-bottom" style="background: rgba(0, 0, 0, 0)" id="chatContent">
    <div class="container-fluid">
        <ul class="nav">
            <li class="nav-item">
                <div class="card float-start w-100 w-lg-100 chatbox" id="chatbox-inquiry" style="display:none">
                    <div class="card-header text-white" style="background: #059065">
                        <h5 class="mb-0">
                            Inquiry
                            <button type="button" class="btn btn-sm float-end fs-1 text-white rounded-pill chatBoxHide mw-auto mb-0" data-popup="popup-inquiry"><i class="ph ph-minus"></i></button>
                        </h5>
                    </div>

                    <form id="sendInquiry">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inquiry_name" name="inquiry_name" type="text" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inquiry_email" name="inquiry_email" type="email" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="inquiry_subject" name="inquiry_subject" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Leave a message <span class="text-danger">*</span></label>
                                    <textarea class="form-control" type="text" id="inquiry_message" name="inquiry_message" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success w-100">Send Inquiry</button>    
                        </div>
                    </form>

                </div>

                <button type="button" class="btn navbar-nav-link rounded text-white btn-warning" id="popup-inquiry" data-chatbox="chatbox-inquiry">
                    <div class="d-flex align-items-center mx-md-1">
                        <span class="d-md-inline-block">Inquiry </span>
                    </div>
                </button>

            </li>
        </ul>
        <span></span>
    </div>
    <script>
        $("#popup-inquiry").click(function() {
            $(this).fadeOut(0, function() {
                $("#" + $(this).data("chatbox")).fadeIn();
            });
        });

        $(".chatBoxHide").click(function() {
            var popup_id = $(this).data("popup");
            $(this).closest(".chatbox").fadeOut(0, function() {
                $("#" + popup_id).fadeIn();
            });
        });

        $("#sendInquiry").submit(function(e) {
            e.preventDefault();

            swalInit.fire({
                text: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
            });

            $.ajax({
                url: '/inquiry',
                method: "POST",
                data: {
                    inquiry_name: $("#inquiry_name").val(),
                    inquiry_email: $("#inquiry_email").val(),
                    inquiry_subject: $("#inquiry_subject").val(),
                    inquiry_message: $("#inquiry_message").val()
                },
                success: function(data) {
                    $("#inquiry_name").val('');
                    $("#inquiry_email").val('');
                    $("#inquiry_subject").val('');
                    $("#inquiry_message").val('');
                    if (data.success === 'false') {
                        swalInit.close();
                        swalInit.fire({
                            text: 'Sending inquiry failed!',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        swalInit.close();
                        swalInit.fire({
                            text: 'Inquiry has been sent!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            })
        });
    </script>
</div>
<section id="footer">
    <div class="row d-lg-block d-none">
        <div class="col-12">
            <div class="content mx-5">
                <div class="row d-flex justify-content-center">
                    <div class="col">
                        <img src="/public/assets/images/Cavite_State_University_(CvSU).png" width="50%" />
                    </div>
                    <div class="col mt-3">
                        <h1 class="fw-bold">Other Links</h1>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="https://trece.cvsu.edu.ph/" class="text-white text-decoration-none">
                                    <i class="ph ph-globe"></i>
                                    <span>trece.cvsu.edu.ph</span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="https://www.facebook.com/CvSUTreceCampus" class="text-white text-decoration-none">
                                    <i class="ph ph-facebook-logo"></i>
                                    <span>Cavite State University - Trece Martires City Campus</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col mt-3">
                        <h1 class="fw-bold">Quick Links</h1>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="/partnership" class="text-white text-decoration-none">
                                    <span>Partnerships</span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="/news" class="text-white text-decoration-none">
                                    <span>News Updates</span>
                                </a>
                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <div class="col-12">
                                <a href="#" class="text-white text-decoration-none">
                                    <span>Downloads</span>
                                </a>
                            </div>
                        </div> -->
                    </div>
                    <div class="col mt-3">
                        <h1 class="fw-bold">Contact Us</h1>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="https://www.google.com/maps/place/Cavite+State+University+-+Trece+Martires+Campus/@14.2830989,120.8758131,17z/data=!4m6!3m5!1s0x33bd80655363e331:0xa4247d4e2b9cbce8!8m2!3d14.2833061!4d120.8760517!16s%2Fg%2F11xnygdgb?entry=ttu" class="text-white text-decoration-none">
                                    <i class="ph-fill ph-map-pin"></i>
                                    <span>Brgy. Gregorio, Trece Martires City, Cavite 4109</span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="mailto:cvsutrecemartires@cvsu.edu.ph" class="text-white text-decoration-none">
                                    <i class="ph-fill ph-envelope"></i>
                                    <span>cvsutrecemartires@cvsu.edu.ph</span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="tel:+639778033809" class="text-white text-decoration-none">
                                    <i class="ph-fill ph-phone"></i>
                                    <span>(+63) 977 803 3809</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-lg-none d-block">
        <div class="col-12">
            <div class="content">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 mb-3">
                        <img src="/public/assets/images/Cavite_State_University_(CvSU).png" width="50%" />
                    </div>
                    <div class="col-12 mb-3">
                        <h1 class="fw-bold">Other Links</h1>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="https://trece.cvsu.edu.ph/" class="text-white text-decoration-none">
                                    <i class="ph ph-globe"></i>
                                    <span>trece.cvsu.edu.ph</span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="https://www.facebook.com/CvSUTreceCampus" class="text-white text-decoration-none">
                                    <i class="ph ph-facebook-logo"></i>
                                    <span>Cavite State University - Trece Martires City Campus</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <h1 class="fw-bold">Quick Links</h1>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="#" class="text-white text-decoration-none">
                                    <span>Events</span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="#" class="text-white text-decoration-none">
                                    <span>News Updates</span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="#" class="text-white text-decoration-none">
                                    <span>Downloads</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h1 class="fw-bold">Contact Us</h1>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="https://www.google.com/maps/place/Cavite+State+University+-+Trece+Martires+Campus/@14.2830989,120.8758131,17z/data=!4m6!3m5!1s0x33bd80655363e331:0xa4247d4e2b9cbce8!8m2!3d14.2833061!4d120.8760517!16s%2Fg%2F11xnygdgb?entry=ttu" class="text-white text-decoration-none">
                                    <i class="ph-fill ph-map-pin"></i>
                                    <span>Brgy. Gregorio, Trece Martires City, Cavite 4109</span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="mailto:cvsutrecemartires@cvsu.edu.ph" class="text-white text-decoration-none">
                                    <i class="ph-fill ph-envelope"></i>
                                    <span>cvsutrecemartires@cvsu.edu.ph</span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="tel:+639778033809" class="text-white text-decoration-none">
                                    <i class="ph-fill ph-phone"></i>
                                    <span>(+63) 977 803 3809</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="d-none d-lg-block text-white text-center fw-bold py-2 pt-3" style="background: #2B2F3A">
    <p>Cavite State University • Trece Martires Cavite, Philippines <i class="ph ph-copyright"></i> <?= date("Y") ?></p>
</footer>
<footer class="d-block d-lg-none text-white text-center fw-bold py-2 pt-3 px-3" style="background: #2B2F3A">
    <p>Cavite State University • Trece Martires Cavite, Philippines <i class="ph ph-copyright"></i> <?= date("Y") ?></p>
</footer>