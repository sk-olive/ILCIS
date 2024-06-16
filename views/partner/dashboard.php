<style>
    .announcementTitle {
        color: #095C00;
        font-weight: bold;
    }
</style>

<body class="">
    <?php include('header.php'); ?>
    <div class="page-content">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row d-flex justify-content-center align-items-center mb-3">
                        <div class="col-12 col-md-10">
                            <h1>Dashboard</h1>
                            <div class="card">
                                <div class="card-body text-center text-md-start">
                                    <div class="container-fluid d-flex flex-column">
                                        <div class="flex-1 flex-lg-0">
                                            <div class="d-inline-flex justify-content-center">
                                                <img src="<?= isset($_SESSION['partner_photo']) ? $_SESSION['partner_photo'] : '/public/assets/images/user.png' ?>" alt="" class="rounded-pill" style="width: 80px; height: 80px">
                                            </div>
                                            <div class="d-inline-block ms-3">
                                                <h3 class="mb-0 fw-bold"><?= $_SESSION['partner_name'] ?></h3>
                                                <h5 class="mb-0 fw-bold"><?= $_SESSION['partner_position'] ?></h5>
                                                <h5 class="mb-0 fw-bold"><?= $_SESSION['partner_contact'] ?></h5>
                                            </div>
                                            <div class="float-md-end float-center d-inline-block ms-3">
                                                <h3 class="mb-0 fw-bold"><br></h3>
                                                <button class="btn btn-light text-white" style="background: #095C00" onclick="window.location = '/partner/profile'">My Profile</button>
                                                <h5 class="mb-0 fw-bold"><br></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center mb-3">
                        <div class="col-12 col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title mb-0">News</h3>
                                </div>
                                <div class="card-body">
                                    <?php foreach($data['news'] as $news): ?>
                                    <div class="row mb-3">
                                        <div class="col-9">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#newsModal<?=$news['content_id']?>" class="announcementTitle h6 text-decoration-none"><?=$news['content_title']?></a>
                                            <p style="text-align: justify"><?=(strlen(strip_tags($news['content_content'])) > 30 ? substr(strip_tags($news['content_content']), 0, 30) . "..." : strip_tags($news['content_content']))?></p>
                                        </div>
                                        <div class="col-3 text-center">
                                            <p class="text-muted fw-bold"><?=(new DateTime($news['content_date']))->format('M j Y')?></p>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="newsModal<?=$news['content_id']?>" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="newsModalLabel">News</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-1">
                                                        <div class="col-12 text-center">
                                                            <h1><?=$news['content_title']?></h1>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12 text-center">
                                                            <?=($news['content_photo'] != '') ? "<img src='".$news['content_photo']."' class='img-thumbnail'/>" : ''?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <?=$news['content_content']?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center mb-3">
                        <div class="col-12 col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title mb-0">Events</h3>
                                </div>
                                <div class="card-body">
                                    <?php foreach($data['events'] as $event): ?>
                                    <div class="row mb-3">
                                        <div class="col-9">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#eventModal<?=$event['content_id']?>" class="announcementTitle h6 text-decoration-none"><?=$event['content_title']?></a>
                                            <p style="text-align: justify"><?=(strlen(strip_tags($event['content_content'])) > 30 ? substr(strip_tags($event['content_content']), 0, 30) . "..." : strip_tags($event['content_content']))?></p>
                                        </div>
                                        <div class="col-3 text-center">
                                            <p class="text-muted fw-bold"><?=(new DateTime($event['content_date']))->format('M j Y')?></p>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="eventModal<?=$event['content_id']?>" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="eventModalLabel">Event</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-1">
                                                        <div class="col-12 text-center">
                                                            <h1><?=$event['content_title']?></h1>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12 text-center">
                                                            <?=($event['content_photo'] != '') ? "<img src='".$event['content_photo']."' class='img-thumbnail'/>" : ''?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <?=$event['content_content']?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('messages.php');?>
    </div>
</body>

</html>