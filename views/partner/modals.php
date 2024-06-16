<?php if ($currentUrl == '/partner/appointments') : ?>
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="appointmentForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAppointmentModalLabel">Appointment Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-md-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold">Contact Person</label>
                                <input class="form-control" type="text" name="appointment_contact_person" value="<?=$_SESSION['partner_person']?>" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Position</label>
                                <input class="form-control" type="text" name="appointment_position" value="<?=$_SESSION['partner_position']?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Company Name</label>
                                <input class="form-control" type="text" name="appointment_company_name" value="<?=$_SESSION['partner_name']?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Company Address</label>
                                <textarea class="form-control" name="appointment_company_address" readonly><?=$_SESSION['partner_address']?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input class="form-control" type="text" name="appointment_phone_number" value="<?=$_SESSION['partner_contact']?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input class="form-control" type="email" name="appointment_email" value="<?=$_SESSION['user_email']?>" readonly>
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
            $("#appointmentForm").submit(function(e) {
                e.preventDefault();
                swalInit.fire({
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
                $.ajax({
                    type: "POST",
                    url: "/partner/appointments/create",
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
                    url: "/partner/appointments/update/" + appointment_id,
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
                    url: "/partner/appointments/delete/" + appointment_id,
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
<?php elseif ($currentUrl == '/partner/events' || $currentUrl == '/partner/news' || $currentUrl == '/partner/announcements') : ?>
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
                        <?php if ($currentUrl == '/partner/announcement') : ?>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Announcement Date</label>
                                    <input class="form-control" type="datetime-local" name="content_date" required>
                                </div>
                            </div>
                        <?php else : ?>
                            <input type="hidden" name="content_date" value="<?= date('Y-m-d H:i:s') ?>" required />
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <?php if ($currentUrl == '/partner/events') : ?>
                            <input type="hidden" name="content_type" value="events" required />
                        <?php elseif ($currentUrl == '/partner/news') : ?>
                            <input type="hidden" name="content_type" value="news" required />
                        <?php elseif ($currentUrl == '/partner/announcements') : ?>
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
                            url: "/partner/content/create",
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
            $(document).on('submit', ".contentFormUpdate", function(e) {
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
                            url: "/partner/content/update/" + content_id,
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
            $(document).on('submit', ".contentFormDelete", function(e) {
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
                    url: "/partner/content/delete/" + content_id,
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
<?php elseif ($currentUrl == '/partner/confidential_document') : ?>
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
                                <input class="form-control" type="text" name="document_company" value="<?=$_SESSION['partner_name']?>" readonly>
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
                    url: "/partner/confidential_document/create",
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
            $(document).on('submit', ".requestFormDelete", function(e) {
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
                    url: "/partner/confidential_document/delete/" + document_id,
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
            $(document).on('submit', ".requestFormDeny", function(e) {
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
                    url: "/partner/confidential_document/deny/" + document_id,
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
            $(document).on('submit', ".requestFormApprove", function(e) {
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
                    url: "/partner/confidential_document/approve/" + document_id,
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
<?php endif; ?>