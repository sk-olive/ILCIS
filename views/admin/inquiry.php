<body class="">
    <?php include('header.php'); ?>
    <div class="page-content">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row mb-3 d-flex justify-content-center align-items-center">
                        <div class="col-12 col-md-10">
                            <h1>Inquiry</h1>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="inquiryTable">
                                            <thead>
                                                <tr>
                                                    <th>Email Address</th>
                                                    <th>Subject</th>
                                                    <th>Name</th>
                                                    <!-- <th>Message</th> -->
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
                    <div class="row mb-3 d-flex justify-content-center align-items-center">
                        <div class="col-12 col-md-10">
                            <h1>Inquiry (non-user)</h1>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="inquiryTable1">
                                            <thead>
                                                <tr>
                                                    <th>Email Address</th>
                                                    <th>Subject</th>
                                                    <th>Name</th>
                                                    <!-- <th>Message</th> -->
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
        let table = $("#inquiryTable").DataTable({
            ajax: "/admin/inquiry/getAll",
            order: [
                [3, 'desc']
            ]
        });

        let table1 = $("#inquiryTable1").DataTable({
            ajax: "/admin/inquiry1/getAll",
            order: [
                [3, 'desc']
            ]
        });
    </script>
    <?php include('modals.php'); ?>
</body>

</html>