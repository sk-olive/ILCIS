<body class="">
    <?php include('header.php'); ?>
    <div class="page-content">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row mb-3 d-flex justify-content-center align-items-center">
                        <div class="col-12">
                            <h1>Announcements</h1>
                            <div class="card">
                                <div class="card-body">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addContentModal">Add Announcement</button>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="table">
                                            <thead>
                                                <tr>
                                                    <th>Photo</th>
                                                    <th>Author</th>
                                                    <th>Title</th>
                                                    <th>Content</th>
                                                    <th>Date and Time</th>
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
        let table = $("#table").DataTable({
            ajax: "/partner/announcements/getAll",
            order: [
                [6, 'desc']
            ]
        });
    </script>
    <?php include('modals.php'); ?>
</body>

</html>