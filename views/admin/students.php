<body class="d-flex flex-column min-vh-100">
    <?php include('header.php'); ?>
    <div class="page-content flex-grow-1">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row d-flex justify-content-center align-items-center mb-3">
                        <div class="col-12">
                            <h1>List of Students</h1>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">Add Appointment</button> -->
                                        <table class="table table-bordered" id="studentTable">
                                            <thead>
                                                <tr>
                                                    <th>Student Number</th>
                                                    <th>Name</th>
                                                    <th>Email Address</th>
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
        let table = $("#studentTable").DataTable({
            ajax: "/admin/students/getAll",
            order: [
                [0, 'asc']
            ]
        });
    </script>
    <?php include('modals.php'); ?>
</body>

</html>