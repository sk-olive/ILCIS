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
                <div class="container mt-3">
                    <div class="row">
                        <div class="col-12">
                            <header class="mb-4">
                                <h1 class="fw-bolder mb-1"><?=$content['content_title']?></h1>
                                <div class="text-muted fst-italic mb-2">
                                    Posted on <?=date('F j, Y g:i A', strtotime($content['content_date']))?> by <?=$content['content_author']?>
                                </div>
                            </header>
                            <?php if($content['content_photo'] != ''): ?>
                            <figure class="mb-4">
                                <img class="img-fluid rounded" src="<?=$content['content_photo']?>" alt="..."/>
                            </figure>
                            <?php endif; ?>
                            <section class="mb-5 fs-5">
                            <?=$content['content_content']?>
                            </section>
                        </div>
                    </div>
                </div>
                <?php include("footer.php"); ?>
            </div>
        </div>
        <?php include("sidebar.php"); ?>
    </div>

</body>

</html>