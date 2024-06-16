<body class="d-flex flex-column min-vh-100">
    <?php include('header.php'); ?>
    <div class="page-content flex-grow-1">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row d-flex justify-content-center align-items-center mb-3">
                        <div class="col-12 col-md-10">
                            <h1>Dashboard</h1>
                            <div class="row row-cols-1 row-cols-md-3">
                                <div class="col">
                                    <div class="card text-white" style="background: #1A64D2">
                                        <div class="card-body">
                                            <span class="fw-bold" style="font-size: 2rem"><?= $data['total_students'] ?></span><br>
                                            <span class="fs-3">Total Number of Students</span>
                                        </div>
                                        <a href="/admin/students" class="card-footer text-decoration-none text-white" style="background: #4079CE">
                                            View Details <i class="ph ph-caret-right ms-auto float-end"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card text-white" style="background: #D21A1A">
                                        <div class="card-body">
                                            <span class="fw-bold" style="font-size: 2rem"><?= $data['total_partners'] ?></span><br>
                                            <span class="fs-3">Total Number of External Partners</span>
                                        </div>
                                        <a href="/admin/students" class="card-footer text-decoration-none text-white" style="background: #994040">
                                            View Details <i class="ph ph-caret-right ms-auto float-end"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card text-white" style="background: #09C870">
                                        <div class="card-body">
                                            <span class="fw-bold" style="font-size: 2rem"><?= $data['total_all'] ?></span><br>
                                            <span class="fs-3">Overall Registered Accounts</span>
                                        </div>
                                        <a href="/admin/students" class="card-footer text-decoration-none text-white" style="background: #2B8C5F">
                                            View Details <i class="ph ph-caret-right ms-auto float-end"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body ">
                                            <div class="chart-container text-center">
                                                <div id="chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-control-datepicker datepicker-inline" id="calendar1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php include('messages.php'); ?>
    </div>
    <script>
        const chart = document.getElementById('chart');
        var dateObj;
        var calendarData = [];
        var calendarItem = {};

        function appointmentDetails(appointment_contact_person, appointment_position, appointment_company_name, appointment_company_address, appointment_phone_number, appointment_email, appointment_status, appointment_date_time, appointment_message) {
            swalInit.fire({
                title: "Appointment Details",
                html: `
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Contact Person</label>
                            <input class="form-control" value="${appointment_contact_person}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Position</label>
                            <input class="form-control" value="${appointment_position}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Company Name</label>
                            <input class="form-control" value="${appointment_company_name}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Company Address</label>
                            <input class="form-control" value="${appointment_company_address}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input class="form-control" value="${appointment_phone_number}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input class="form-control" value="${appointment_email}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Date and Time</label>
                            <input type="datetime-local" class="form-control" value="${appointment_date_time}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Message</label>
                            <textarea class="form-control" readonly>${appointment_message}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Status</label>
                            <textarea class="form-control" readonly>${appointment_status}</textarea>
                        </div>
                    </div>
                `,
                showCancelButton: false,
                confirmButtonText: 'Close'
            });
        }

        var dpBasicElement = document.querySelector('.form-control-datepicker');

        if (dpBasicElement) {
            var dpBasic = new Datepicker(dpBasicElement, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                changeMonth: true,
                changeYear: true,
                autoPick: false,
                showButtonPanel: false,
                beforeShow: function(i) {
                    if ($(i).attr('readonly')) {
                        return false;
                    }
                }
            });

            var unselect1 = dpBasicElement.querySelectorAll('.datepicker-cell.day');
            unselect1.forEach(function(today) {
                today.classList.remove('selected', 'focused');
            });

            <?php foreach($data['appointments'] as $appointment): ?>
                var date = '<?=str_replace(' ', '-', $appointment['appointment_date_time'])?>';
                var dateParts = date.split('-');
                console.log(dateParts);
                dateObj = new Date(Date.UTC(dateParts[0], dateParts[1] - 1, dateParts[2] - 1, 0, 0, 0));
                dateObj.setUTCHours(16);
                calendarItem = {
                    time_unix: Math.floor(dateObj.getTime()),
                    data_date: date,
                    appointment_contact_person: '<?=$appointment['appointment_contact_person']?>',
                    appointment_position: '<?=$appointment['appointment_position']?>',
                    appointment_company_name: '<?=$appointment['appointment_company_name']?>',
                    appointment_company_address: '<?=$appointment['appointment_company_address']?>',
                    appointment_phone_number: '<?=$appointment['appointment_phone_number']?>',
                    appointment_email: '<?=$appointment['appointment_email']?>',
                    appointment_status: '<?=$appointment['appointment_status']?>',
                    appointment_date_time: '<?=$appointment['appointment_date_time']?>',
                    appointment_message: '<?=$appointment['appointment_message']?>',
                };
                calendarData.push(calendarItem);
            <?php endforeach; ?>

            $(".next-btn, .prev-btn").click(function(event) {
                var unselect1 = dpBasicElement.querySelectorAll('.datepicker-cell.day');
                unselect1.forEach(function(today) {
                    today.classList.remove('selected', 'focused');
                });
                if (calendarData.length > 0) {
                    calendarData.forEach(function(calendarItem) {
                        var dataDate = calendarItem.time_unix;
                        var dateOrig = calendarItem.data_date;
                        $('#calendar1').find("span.datepicker-cell.day[data-date='" + dataDate + "']").addClass('has_event');
                        $('#calendar1').find("span.datepicker-cell.day[data-date='" + dataDate + "']").data("date-orig", dateOrig);
                        $('#calendar1').find("span.datepicker-cell.day[data-date='" + dataDate + "']").attr('onclick', 'appointmentDetails(calendarItem.appointment_contact_person, calendarItem.appointment_position, calendarItem.appointment_company_name, calendarItem.appointment_company_address, calendarItem.appointment_phone_number, calendarItem.appointment_email, calendarItem.appointment_status, calendarItem.appointment_date_time, calendarItem.appointment_message)');
                    });
                } else {
                    console.error('Calendar data is missing.');
                }
            });

            if (calendarData.length > 0) {
                calendarData.forEach(function(calendarItem) {
                    var dataDate = calendarItem.time_unix;
                    var dateOrig = calendarItem.data_date;
                    $('#calendar1').find("span.datepicker-cell.day[data-date='" + dataDate + "']").addClass('has_event');
                    $('#calendar1').find("span.datepicker-cell.day[data-date='" + dataDate + "']").data("date-orig", dateOrig);
                    $('#calendar1').find("span.datepicker-cell.day[data-date='" + dataDate + "']").attr('onclick', 'appointmentDetails(calendarItem.appointment_contact_person, calendarItem.appointment_position, calendarItem.appointment_company_name, calendarItem.appointment_company_address, calendarItem.appointment_phone_number, calendarItem.appointment_email, calendarItem.appointment_status, calendarItem.appointment_date_time, calendarItem.appointment_message)');
                });
            } else {
                console.error('Calendar data is missing.');
            }
        }

        $(document).ready(function() {
            const pie_chart = c3.generate({
                bindto: chart,
                size: {
                    width: 350
                },
                color: {
                    pattern: ['#2ec7c9', '#d87a80']
                },
                data: {
                    columns: [
                        ['External Partners', <?= $data['total_partners'] ?>],
                        // ['Admin', <?= $data['total_admins'] ?>],
                        ['Students', <?= $data['total_students'] ?>]
                    ],
                    type: 'pie'
                }
            });
        })
    </script>
</body>

</html>