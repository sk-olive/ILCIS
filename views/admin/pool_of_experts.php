<body class="d-flex flex-column min-vh-100">
    <?php include('header.php'); ?>
    <div class="page-content flex-grow-1">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row d-flex justify-content-center align-items-center mb-3">
                        <div class="col-12">
                            <h1>List of Experts</h1>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addExpertModal">Add Expert</button>
                                        <table class="table table-bordered" id="expertTable">
                                            <thead>
                                                <tr>
                                                    <th>Name of Expert</th>
                                                    <th>Position/Designation</th>
                                                    <th>Field of Specialization</th>
                                                    <th>Contact</th>
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
        let table = $("#expertTable").DataTable({
            ajax: "/admin/pool_of_experts/getAll",
            order: [
                [0, 'asc']
            ]
        });
    </script>
    <?php include('modals.php'); ?>
</body>

</html>