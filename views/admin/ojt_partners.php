<body class="">
    <?php include('header.php'); ?>
    <div class="page-content">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row mb-3 d-flex justify-content-center align-items-center">
                        <div class="col-12 col-md-10">
                            <h1>OJT Partners</h1>
                            <div class="row row-cols-lg-4 row-cols-1 mb-3" id="cards">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('messages.php'); ?>
    </div>
    <div class="container" id="modals"></div>
    <script>
        let dataHTML, modalHTML;

        function loadData() {
            dataHTML = '';
            modalHTML = '';
            $('#cards').html('');
            $("#modals").html('');
            $.ajax({
                url: '/admin/ojt_partners/getAll',
                type: 'GET',
                success: function(data) {
                    for (let d of data.data) {
                        dataHTML += `
                        <div class="col mb-3">
                            <a href="//${d.ojt_link}" class="card mh-100 text-decoration-none text-black">
                                <div class="card-body text-center justify-content-center align-items-center d-flex">
                                    <img class="img-fluid" src="${d.ojt_photo}" />
                                </div>
                                <div class="card-footer text-center">
                                    <b>${d.ojt_name}</b>
                                </div>
                            </a>
                            <div class="row d-flex align-items-center justify-content-center text-center">
                                <div class="col-12">
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#updateOJTPartnerModal${d.ojt_id}">Update</button> <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#deleteOJTPartnerModal${d.ojt_id}">Delete</button>
                                </div>
                            </div>
                        </div>
                        `;
                    }
                    for (let m of data.modals) {
                        modalHTML += m;
                    }
                    dataHTML += `
                    <div class="col mb-3">
                        <a class="card mh-100 text-decoration-none border-0 addCard" data-bs-toggle="modal" data-bs-target="#addOJTPartnerModal">
                            <div class="card-body text-center justify-content-center align-items-center d-flex">
                                <i class="ph-fill ph-4x ph-plus-circle"></i>
                            </div>
                        </a>
                    </div>
                    `;
                    $('#cards').html(dataHTML);
                    $("#modals").html(modalHTML);
                }
            });
        }

        $(document).ready(function() {
            // var pusher = new Pusher('faac39db04715651483d', {
            //     cluster: 'ap1'
            // });

            // var channel = pusher.subscribe('ojts');

            // channel.bind('update', function(data) {
            //     loadData();
            // });
            loadData();
        });
    </script>
    <?php include('modals.php'); ?>
</body>

</html>