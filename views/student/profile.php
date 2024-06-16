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
                                                    <img id="output" class="img-fluid rounded-circle" src="<?= $_SESSION['student_photo'] ?>" width="150" height="150" alt="">
                                                    <div class="card-img-actions-overlay card-img rounded-circle" for="file">
                                                        <label class="btn btn-outline-white btn-icon rounded-pill" for="file">
                                                            <i class="ph-pencil"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <input class="d-md-none form-control" id="file" type="file" name="student_photo" onchange="loadFile(event)" />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                                <input type="text" name="student_fname" class="form-control" value="<?= $_SESSION['student_fname'] ?>" oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '').slice(0, 100)" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" name="student_lname" class="form-control" value="<?= $_SESSION['student_lname'] ?>" oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '').slice(0, 100)" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                                <input type="text" id="user_email" name="user_email" class="form-control" value="<?= $_SESSION['user_email'] ?>" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Student No. <span class="text-danger">*</span></label>
                                                <input type="text" name="student_number" class="form-control" value="<?= $_SESSION['student_number'] ?>" oninput="this.value = this.value.replace(/[^0-9-]/g, '').slice(0,14)" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Birth Date <span class="text-danger">*</span></label>
                                                <input type="date" name="student_birthday" class="form-control" value="<?= $_SESSION['student_birthday'] ?>" max="<?=date('Y-m-d')?>" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label">Sex <span class="text-danger">*</span></label>
                                                <div>
                                                    <label class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" id="student_gender" name="student_gender" required value="Male" <?= $_SESSION['student_gender'] == 'Male' ? 'checked' : '' ?>>
                                                        <span class="form-check-label">Male</span>
                                                    </label>

                                                    <label class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" id="student_gender" name="student_gender" value="Female" <?= $_SESSION['student_gender'] == 'Female' ? 'checked' : '' ?>>
                                                        <span class="form-check-label">Female</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                                                <?php
                                                $courses = ["BS in Information Technology", "BS Business Administration Major in Marketing Management", "BS Hospitality Management", "BS Psychology", "Bachelor of Science in Office Administration", "Bachelor of Secondary Education Major in English"];
                                                ?>
                                                <select class="form-select" name="student_course" required>
                                                    <option value="<?= $_SESSION['student_course'] ?>" selected><?= $_SESSION['student_course'] ?></option>
                                                    <?php foreach ($courses as $course) : ?>
                                                        <?php if ($_SESSION['student_course'] !== $course) : ?>
                                                            <option value="<?= $course ?>"><?= $course ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center align-items-center d-flex">
                                            <div class="col-12 col-md-8">
                                                <button type="submit" class="btn btn-success" id="registerBtnS">Update Profile</button>
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
        <?php include('messages.php');?>
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
                    url: "/student/profile/update",
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