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
                                        <h1 class="text-center fw-bold" style="color: #1B651B">ANNOUNCEMENTS</h1>
                                    </div>
                                </div>
                                <div class="row rows-cols-1 rows-cols-md-2 d-flex justify-content-center align-items-center mb-3">
                                    <?php if(!$data['announcements']):?>
                                        <div class="col">
                                            There is no news and updates available.
                                        </div>
                                    <?php endif;?>
                                    <?php foreach($data['announcements'] as $announcements): ?>
                                        <div class="col">
                                            <div class="card">
                                                <img class="card-img-top" src="<?=$announcements['content_photo']?>" />
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <h4><?=$announcements['content_title']?></h4>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <h6><?=(new DateTime($announcements['content_date']))->format('M j Y')?></h6>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <p><?=$announcements['content_content']?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
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

</body>

</html>