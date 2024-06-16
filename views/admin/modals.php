<?php //$currentUrl = $_GET['currentUrl']; ?>
<?php if ($currentUrl == '/admin/students') : ?>
    <script>
        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('students');

            channel.bind('update', function(data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                }
            });
            
            $(document).on('submit', '.studentFormUpdate', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var user_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/students/update/" + user_id,
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
                                text: 'Updated successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', '.studentFormDelete', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var user_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/students/delete/" + user_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
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
<?php elseif ($currentUrl == '/admin/partners') : ?>
    <script>
        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('partners');

            channel.bind('update', function(data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                }
            });
            $(document).on('submit', '.partnerFormUpdate', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var user_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/partners/update/" + user_id,
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
                                text: 'Updated successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', '.partnerFormDelete', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var user_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/partners/delete/" + user_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
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
<?php elseif ($currentUrl == '/admin/pool_of_experts') : ?>
    <div class="modal fade" id="addExpertModal" tabindex="-1" aria-labelledby="addExpertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="expertForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExpertModalLabel">Add Expert</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Name of Expert <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="expert_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Position/Designation <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="expert_department" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Field of Specialization <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="expert_position" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Contact <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="expert_contact" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Expert</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var addExpertModal = new bootstrap.Modal(document.getElementById('addExpertModal'), {
            keyboard: true
        });
        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('experts');

            channel.bind('update', function(data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                }
            });
            $("#expertForm").submit(function(e) {
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/pool_of_experts/create",
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
                                text: 'Added successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                addExpertModal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".expertFormUpdate", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var expert_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/pool_of_experts/update/" + expert_id,
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
                                text: 'Updated successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".expertFormDelete", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var expert_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/pool_of_experts/delete/" + expert_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
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
<?php elseif ($currentUrl == '/admin/appointments') : ?>
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="appointmentForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAppointmentModalLabel">Appointment Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Company Name</label>
                                <select class="form-select" id="companyName" name="appointment_company_name">
                                    <option disabled selected>--- SELECT COMPANY NAME ---</option>
                                    <?php foreach($data['partners'] as $partner): ?>
                                        <option value="<?=$partner['partner_id']?>"><?=$partner['partner_name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-md-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold">Contact Person</label>
                                <input class="form-control" type="text" id="appointment_contact_person" name="appointment_contact_person" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Position</label>
                                <input class="form-control" type="text" id="appointment_position" name="appointment_position" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Company Address</label>
                                <textarea class="form-control" id="appointment_company_address" name="appointment_company_address" readonly></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input class="form-control" type="text" id="appointment_phone_number" name="appointment_phone_number" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input class="form-control" type="email" id="appointment_email" name="appointment_email" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Date and Time <span class="text-danger">*</span></label>
                                <input class="form-control" type="datetime-local" name="appointment_date_time" min="<?=date('Y-m-d\TH:i')?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="appointment_message" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var addAppointmentModal = new bootstrap.Modal(document.getElementById('addAppointmentModal'), {
            keyboard: true
        });
        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('appointments');

            channel.bind('update', function(data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                }
            });

            $("#companyName").change(function() {
                $.ajax({
                    url: '/admin/appointments/getPartner/' + $(this).val(),
                    method: "GET",
                    success: function(data) {
                        $("#appointment_contact_person").val(data.partner_person),
                        $("#appointment_position").val(data.partner_position),
                        $("#appointment_company_address").val(data.partner_address),
                        $("#appointment_phone_number").val(data.partner_contact),
                        $("#appointment_email").val(data.user_email)
                    }
                });  
            });

            $("#appointmentForm").submit(function(e) {
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/appointments/create",
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
                                text: 'Added successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                addAppointmentModal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".appointmentFormUpdate", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var appointment_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/appointments/update/" + appointment_id,
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
                                text: 'Updated successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".appointmentFormDelete", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var appointment_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/appointments/delete/" + appointment_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".appointmentFormChange", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var appointment_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/appointments/change/" + appointment_id,
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
                                text: 'Status Changed successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
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
<?php elseif ($currentUrl == '/admin/linkage_and_partners') : ?>
    <div class="modal fade" id="addLinkageModal" tabindex="-1" aria-labelledby="addLinkageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="linkageForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLinkageModalLabel">Add Linkage</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Linkage Partner Logo <span class="text-danger">*</span></label>
                                <input class="form-control" id="file" type="file" name="linkage_photo" required/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Linkage Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="linkage_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Linkage Link <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="linkage_link" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Linkage</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        var addLinkageModal = new bootstrap.Modal(document.getElementById('addLinkageModal'), {
            keyboard: true
        });
        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('linkages');

            channel.bind('update', function(data) {
                loadData();
            });

            $("#linkageForm").submit(function(e) {
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/linkage_and_partners/create",
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
                                text: 'Added successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                addLinkageModal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".linkageFormUpdate", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var linkage_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/linkage_and_partners/update/" + linkage_id,
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
                                text: 'Updated successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".linkageFormDelete", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var linkage_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/linkage_and_partners/delete/" + linkage_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
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
<?php elseif ($currentUrl == '/admin/ojt_partners') : ?>
    <div class="modal fade" id="addOJTPartnerModal" tabindex="-1" aria-labelledby="addOJTPartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="ojtForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOJTPartnerModalLabel">Add OJT Partner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">OJT Partner Logo <span class="text-danger">*</span></label>
                                <input class="form-control" id="file" type="file" name="ojt_photo" required/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">OJT Partner Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="ojt_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">OJT Partner Link <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="ojt_link" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add OJT Partner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        var addOJTPartnerModal = new bootstrap.Modal(document.getElementById('addOJTPartnerModal'), {
            keyboard: true
        });
        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('ojts');

            channel.bind('update', function(data) {
                loadData();
            });

            $("#ojtForm").submit(function(e) {
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/ojt_partners/create",
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
                                text: 'Added successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                addOJTPartnerModal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".ojtFormUpdate", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var ojt_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/ojt_partners/update/" + ojt_id,
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
                                text: 'Updated successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".ojtFormDelete", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var ojt_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/ojt_partners/delete/" + ojt_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
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
<?php elseif ($currentUrl == '/admin/institutional_membership') : ?>
    <div class="modal fade" id="addInstitutionalMembershipModal" tabindex="-1" aria-labelledby="addInstitutionalMembershipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="institutional_membershipForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addInstitutionalMembershipModalLabel">Add Institutional Membership Partner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Institutional Membership Partner Logo <span class="text-danger">*</span></label>
                                <input class="form-control" id="file" type="file" name="institutional_membership_photo" required/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Institutional Membership Partner Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="institutional_membership_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Institutional Membership Partner Link <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="institutional_membership_link" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Institutional Membership Partner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        var addInstitutionalMembershipModal = new bootstrap.Modal(document.getElementById('addInstitutionalMembershipModal'), {
            keyboard: true
        });
        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('institutional_memberships');

            channel.bind('update', function(data) {
                loadData();
            });

            $("#institutional_membershipForm").submit(function(e) {
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/institutional_membership/create",
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
                                text: 'Added successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                addInstitutionalMembershipModal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".institutional_membershipFormUpdate", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var institutional_membership_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/institutional_membership/update/" + institutional_membership_id,
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
                                text: 'Updated successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', ".institutional_membershipFormDelete", function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var institutional_membership_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/institutional_membership/delete/" + institutional_membership_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
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
<?php elseif ($currentUrl == '/admin/events' || $currentUrl == '/admin/news' || $currentUrl == '/admin/announcements' || $currentUrl == '/admin/for_approvals') : ?>
    <div class="modal fade" id="addContentModal" tabindex="-1" aria-labelledby="addContentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="contentForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContentModalLabel">Add Content</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <label class="form-label fw-semibold">Content Photo</label>
                                <input class="form-control" id="file" type="file" name="content_photo" onchange="loadFile(event)" />
                                <br><img id="output" class="img-fluid" src="https://placehold.co/200x200" alt="" style="width: 200px; height: 200px">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Content Title <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="content_title" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                                <div id="toolbar-container"></div>
                                <div class="form-control content_content" id="ckeditor_classic_empty" placeholder="Enter your content..."></div>
                            </div>
                        </div>
                        <?php if ($currentUrl == '/admin/announcement') : ?>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Announcement Date</label>
                                    <input class="form-control" type="datetime-local" name="content_date" required>
                                </div>
                            </div>
                        <?php else : ?>
                            <input type="hidden" name="content_date" value="<?= date('Y-m-d H:i:s') ?>" required />
                        <?php endif; ?>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Content Visibility <span class="text-danger">*</span></label>
                                <select class="form-select" name="content_status" required>
                                    <option value="published">Published</option>
                                    <option value="unpublished">Unpublished</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php if ($currentUrl == '/admin/events') : ?>
                            <input type="hidden" name="content_type" value="events" required />
                        <?php elseif ($currentUrl == '/admin/news') : ?>
                            <input type="hidden" name="content_type" value="news" required />
                        <?php elseif ($currentUrl == '/admin/announcements') : ?>
                            <input type="hidden" name="content_type" value="announcement" required />
                        <?php endif; ?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Content</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        var addContentModal = new bootstrap.Modal(document.getElementById('addContentModal'), {
            keyboard: true
        });

        function openEditor(content_id) {
            let editor1 = DecoupledEditor.create(document.querySelector('#ckeditor_classic_empty'+content_id), {
                toolbar: [
                    'undo', 'redo',
                    'heading', 'fontFamily', 'fontSize', 'fontColor',
                    'bold', 'italic', 'underline', 'strikethrough',
                    'link', 'insertTable', 'blockQuote',
                    'alignment', 'bulletedList', 'numberedList', 'outdent', 'indent'
                ],
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ]
                },
                alignment: {
                    options: [ 'left', 'right', 'center', 'justify' ]
                }
            }).then(editor => {
                const toolbarContainer = document.querySelector( '#toolbar-container'+content_id);
                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                window.editorInstance = editor;
                console.log(editor);
            }).catch(error => {
                console.error(error);
            });
        }

        function openNewEditor() {
            let editor = DecoupledEditor.create(document.querySelector('#ckeditor_classic_empty'), {
                toolbar: [
                    'undo', 'redo',
                    'heading', 'fontFamily', 'fontSize', 'fontColor',
                    'bold', 'italic', 'underline', 'strikethrough',
                    'link', 'insertTable', 'blockQuote',
                    'alignment', 'bulletedList', 'numberedList', 'outdent', 'indent'
                ],
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ]
                },
                alignment: {
                    options: [ 'left', 'right', 'center', 'justify' ]
                }
            }).then(editor => {
                const toolbarContainer = document.querySelector( '#toolbar-container' );
                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                window.editorInstance = editor;
            }).catch(error => {
                console.error(error);
            });
        }

        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('contents');

            channel.bind('update', function(data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                }
            });

            $("#contentForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                if(window.editorInstance.getData() == '') {
                    swalInit.fire({
                        text: "Content is Empty",
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1000
                    });

                    return false;
                }
                formData.append('content_content', window.editorInstance.getData());
                swalInit1.fire({
                    html: window.editorInstance.getData(),
                    showCancelButton: false,
                    showDenyButton: true,
                    confirmButtonText: "Save",
                    denyButtonText: "Cancel",
                }).then((result) => {
                    if(result.isConfirmed) {
                        swalInit.fire({
                            text: 'Please wait...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                        $.ajax({
                            type: "POST",
                            url: "/admin/content/create",
                            data: formData,
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
                                        text: 'Added successfully!',
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then(() => {
                                        addContentModal.toggle();
                                    });
                                }
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    }
                });
            });
            $(document).on('submit', '.contentFormUpdate', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var content_id = form.data("id");
                var formData = new FormData(this);
                if(window.editorInstance.getData() == '') {
                    swalInit.fire({
                        text: "Content is Empty",
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1000
                    });

                    return false;
                }
                formData.append('content_content', window.editorInstance.getData());
                swalInit1.fire({
                    html: window.editorInstance.getData(),
                    showCancelButton: false,
                    showDenyButton: true,
                    confirmButtonText: "Save",
                    denyButtonText: "Cancel"
                }).then((result) => {
                    if(result.isConfirmed) {
                        swalInit.fire({
                            text: 'Please wait...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                        $.ajax({
                            type: "POST",
                            url: "/admin/content/update/" + content_id,
                            data: formData,
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
                                        text: 'Updated successfully!',
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then(() => {
                                        modal.toggle();
                                    });
                                }
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    }
                });
            });
            $(document).on('submit', '.contentFormDelete', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var content_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/content/delete/" + content_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', '.contentFormApprove', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var content_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/content/approve/" + content_id,
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
                                text: 'Approved successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
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
<?php elseif ($currentUrl == '/admin/confidential_document') : ?>
    <div class="modal fade" id="addFilesModal" tabindex="-1" aria-labelledby="addFilesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="requestForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addFilesModalLabel">Add File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">File <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="document_file" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Document File Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="document_type" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                                <select class="form-select" name="document_company" required>
                                    <option disabled selected>--- SELECT COMPANY NAME ---</option>
                                    <?php foreach($data['partners'] as $partner): ?>
                                        <option value="<?=$partner['partner_name']?>"><?=$partner['partner_name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var addFilesModal = new bootstrap.Modal(document.getElementById('addFilesModal'), {
            keyboard: true
        });
        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('documents');

            channel.bind('update', function(data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                    table1.ajax.reload();
                }
            });
            $("#requestForm").submit(function(e) {
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/confidential_document/create",
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
                                text: 'Added successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                addFilesModal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', '.requestFormDelete', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var document_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/confidential_document/delete/" + document_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', '.requestFormDeny', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var document_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/confidential_document/deny/" + document_id,
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
                                text: 'Denied successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', '.requestFormApprove', function(e) {
                e.preventDefault();
                var form = $(this);
                var modal = form.data("modal");
                var document_id = form.data("id");
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/confidential_document/approve/" + document_id,
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
                                text: 'Approved successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                                form.remove();
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
<?php elseif ($currentUrl == '/admin/inquiry') : ?>
    <script>
        function openEditor(inquiry_id) {
            let editor = DecoupledEditor.create(document.querySelector('#ckeditor_classic_empty'+inquiry_id), {
                toolbar: [
                    'undo', 'redo',
                    'heading', 'fontFamily', 'fontSize', 'fontColor',
                    'bold', 'italic', 'underline', 'strikethrough',
                    'link', 'insertTable', 'blockQuote',
                    'alignment', 'bulletedList', 'numberedList', 'outdent', 'indent'
                ],
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ]
                },
                alignment: {
                    options: [ 'left', 'right', 'center', 'justify' ]
                }
            }).then(editor => {
                const toolbarContainer = document.querySelector( '#toolbar-container'+inquiry_id);
                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                window.editorInstance = editor;
            }).catch(error => {
                console.error(error);
            });
        }

        function openEditor1(inquiry_id) {
            let editor1 = DecoupledEditor.create(document.querySelector('#ckeditor_classic1_empty'+inquiry_id), {
                toolbar: [
                    'undo', 'redo',
                    'heading', 'fontFamily', 'fontSize', 'fontColor',
                    'bold', 'italic', 'underline', 'strikethrough',
                    'link', 'insertTable', 'blockQuote',
                    'alignment', 'bulletedList', 'numberedList', 'outdent', 'indent'
                ],
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ]
                },
                alignment: {
                    options: [ 'left', 'right', 'center', 'justify' ]
                }
            }).then(editor => {
                const toolbarContainer = document.querySelector( '#toolbar1-container'+inquiry_id);
                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                window.editorInstance = editor;
            }).catch(error => {
                console.error(error);
            });
        }
        $(document).ready(function(e) {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('inquiry');

            channel.bind('update', function(data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                    table1.ajax.reload();
                }
            });
            
            $(document).on('submit', '.replyInquiryForm', function(e) {
                var form = $(this);
                var modal = form.data("modal");
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                var formData = new FormData(this);
                formData.append('reply_message', window.editorInstance.getData());
                $.ajax({
                    type: "POST",
                    url: "/admin/inquiry/reply",
                    data: formData,
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
                                text: 'Replied successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            $(document).on('submit', '.replyInquiry1Form', function(e) {
                var form = $(this);
                var modal = form.data("modal");
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                var formData = new FormData(this);
                formData.append('reply_message', window.editorInstance.getData());
                $.ajax({
                    type: "POST",
                    url: "/admin/inquiry/reply",
                    data: formData,
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
                                text: 'Replied successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            $(document).on('submit', '.inquiryFormDelete', function(e) {
                var form = $(this);
                var modal = form.data("modal");
                var inquiry_id = form.data("id");
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/inquiry/delete/" + inquiry_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            $(document).on('submit', '.inquiryFormDelete1', function(e) {
                var form = $(this);
                var modal = form.data("modal");
                var inquiry_id = form.data("id");
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/inquiry/delete1/" + inquiry_id,
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
                                text: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                modal.toggle();
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
<?php endif; ?>