<body class="">
    <?php include('header.php'); ?>
    <div class="page-content">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <form id="editProfile" enctype="multipart/form-data">
                        <div class="row d-flex justify-content-center align-items-center mb-3">
                            <div class="col-12 col-md-8">
                                <h1>My Profile</h1>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center align-items-center mb-1 text-center">
                                            <div class="col-12">
                                                <label class="fw-semibold">Profile Picture</label>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-center">
                                                <div class="card-img-actions d-inline-block mb-3">
                                                    <img id="output" class="img-fluid rounded-circle" src="<?= $_SESSION['partner_photo'] ?>" width="150" height="150" alt="">
                                                    <div class="card-img-actions-overlay card-img rounded-circle" for="file">
                                                        <label class="btn btn-outline-white btn-icon rounded-pill" for="file">
                                                            <i class="ph-pencil"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <input class="d-md-none form-control" id="file" type="file" name="partner_photo" onchange="loadFile(event)" />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                                                <input type="text" name="partner_name" class="form-control" value="<?= $_SESSION['partner_name'] ?>" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Company Address <span class="text-danger">*</span></label>
                                                <input type="text" name="partner_address" class="form-control" value="<?= $_SESSION['partner_address'] ?>" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Contact Person <span class="text-danger">*</span></label>
                                                <input type="text" name="partner_person" class="form-control" value="<?= $_SESSION['partner_person'] ?>"  oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '')" required/>
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Partner Contact Number <span class="text-danger">*</span></label>
                                                <input type="text" id="partner_contact" name="partner_contact" class="form-control" value="<?= $_SESSION['partner_contact'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required/>
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Partner Position <span class="text-danger">*</span></label>
                                                <input type="text" name="partner_position" class="form-control" value="<?= $_SESSION['partner_position'] ?>" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                                <input type="email" id="user_email" name="user_email" class="form-control" value="<?= $_SESSION['user_email'] ?>" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Telephone No.</label>
                                                <input type="text" id="partner_telephone" name="partner_telephone" class="form-control" value="<?= $_SESSION['partner_telephone'] ?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <button type="submit" class="btn btn-success registerBtn1">Update Profile</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include('messages.php'); ?>
    </div>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        $(document).ready(function() {
            $("#editProfile").submit(function(e) {
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "/partner/profile/update",
                    data: formData,
                    cache: false,
                    contentType: false,
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
                                text: 'Profile updated successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>