<body class="">
    <?php include('header.php'); ?>
    <div class="page-content">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row mb-3 d-flex justify-content-center align-items-center">
                        <div class="col-12 col-md-10">
                            <h1>Linkage and Partners</h1>
                            <div class="row row-cols-lg-4 row-cols-1 mb-3" id="cards">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('messages.php'); ?>
    </div>
    <script>
        let dataHTML;

        function loadData() {
            dataHTML = '';
            $('#cards').html('');
            $.ajax({
                url: '/student/linkage_and_partners/getAll',
                type: 'GET',
                success: function(data) {
                    for (let d of data.data) {
                        dataHTML += `
                        <div class="col mb-3">
                            <a href="//${d.linkage_link}" class="card mh-100 text-decoration-none text-black">
                                <div class="card-body text-center justify-content-center align-items-center d-flex">
                                    <img class="img-fluid" src="${d.linkage_photo}" />
                                </div>
                                <div class="card-footer text-center">
                                    <b>${d.linkage_name}</b>
                                </div>
                            </a>
                        </div>
                        `;
                    }
                    $('#cards').html(dataHTML);
                }
            });
        }

        $(document).ready(function() {
            var pusher = new Pusher('faac39db04715651483d', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('linkages');

            channel.bind('update', function(data) {
                loadData();
            });
            loadData();
        });
    </script>
</body>

</html>