<body class="">
    <?php include('header.php'); ?>
    <div class="page-content">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row mb-3 d-flex justify-content-center align-items-center">
                        <div class="col-12">
                            <h1>Appointments</h1>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">Add Appointment</button>
                                        <table class="table table-bordered" id="appointmentTable">
                                            <thead>
                                                <tr>
                                                    <th>Contact Person</th>
                                                    <th>Company Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Email Address</th>
                                                    <th>Date / Time</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
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
        let table = $("#appointmentTable").DataTable({
            ajax: "/admin/appointments/getAll",
            order: [
                [6, 'desc']
            ]
        });
    </script>
    <?php include('modals.php'); ?>
</body>

</html>