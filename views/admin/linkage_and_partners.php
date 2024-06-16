<body class="">
    <?php include('header.php'); ?>
    <div class="page-content">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row mb-3 d-flex justify-content-center align-items-center">
                        <div class="col-12">
                            <h1>Linkage Partners</h1>
                            <div class="card">
                                <div class="card-header bg-success">
                                    <p class="mb-0 card-title text-white fs-6"></p>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" href="">Add Linkage Partners</button>
                                        <table class="table table-bordered" id="requestsTable">
                                            <thead>
                                                <tr>
                                                    <th> ID No. </th>
                                                    <th> Company Name</th>
                                                    <th>Email</th>
                                                    <th></th>
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
        let table = $("#requestsTable").DataTable({
            ajax: "/admin/confidential_document/requests/getAll",
            order: [
                [3, 'desc']
            ]
        });

        let table1 = $("#filesTable").DataTable({
            ajax: "/admin/confidential_document/files/getAll",
            order: [
                [3, 'desc']
            ]
        });
    </script>
    <?php include('modals.php'); ?>
</body>

</html>