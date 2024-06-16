<style>
    #footer {
        background: #303440;
        color: white;
    }
</style>

<body class="d-flex flex-column min-vh-100">
    <?php include('header.php'); ?>
    <div class="page-content">
        <div class="content-wrapper">
            <div class="content-inner">
                <section class="mx-lg-5" id="about">
                    <div class="row justify-content-center align-items-center d-flex">
                        <div class="col-12 col-lg-8">
                            <div class="content min-vh-100">
                                <div class="row d-flex justify-content-center align-items-center mb-3">
                                    <div class="col-12">
                                        <h1 class="text-center fw-bold" style="color: #1B651B">POOL OF EXPERTS</h1>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center align-items-center mb-3">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-res onsive">
                                                    <table class="table table-bordered table-striped" style="table-layout: fixed" id="expertTable">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-white" style="background: #0C4B05">NAME</th>
                                                                <th class="text-white" style="background: #0C4B05">POSITION/DESIGNATION</th>
                                                                <th class="text-white" style="background: #0C4B05">FIELD OF SPECIALIZATION</th>
                                                                <th class="text-white" style="background: #0C4B05">CONTACT</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($data['pool_of_experts'] as $expert): ?>
                                                                <tr>
                                                                    <td class="fw-bold text-uppercase"><?=$expert['expert_name']?></td>
                                                                    <td class="fw-bold"><?=$expert['expert_department']?></td>
                                                                    <td class="fw-bold"><?=$expert['expert_position']?></td>
                                                                    <td class="fw-bold"><?=$expert['expert_contact']?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
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
                </section>

                <?php include("footer.php"); ?>

            </div>
        </div>
        <?php include("sidebar.php"); ?>
    </div>
    <script>
        let table = $("#expertTable").DataTable({
            "bInfo" : false,
            searching: false,
            order: [
                [0, 'asc']
            ]
        });
    </script>
</body>

</html>