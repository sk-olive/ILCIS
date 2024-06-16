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
                                        <h1 class="text-center fw-bold" style="color: #1B651B">INTERNATIONALIZATION, LINKAGES, AND COLLABORATION UNIT</h1>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <?php if(!$data['news']):?>
                                        <div class="col">
                                            There is no news updates available.
                                        </div>
                                    <?php endif;?>
                                    <?php foreach($data['news'] as $news): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="card">
                                                <img class="card-img-top" src="<?=$news['content_photo']?>" />
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-12">
                                                            <h5 class="mb-0"><?=$news['content_title']?></h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-12">
                                                            <h6><?=(new DateTime($news['content_date']))->format('M j Y')?></h6>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-12">
                                                            <p><?=strip_tags($news['content_content'])?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-12">
                                                            <a class="text-decoration-none fw-bold" style="color: #095C00;" href="/news/<?=$news['content_id']?>">Read More</a>
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
    <script>
        $(document).ready(function() {
            $('.col-12 p').each(function() {
                var text = $(this).text();
                if (text.length > 200) {
                    $(this).text(text.substring(0, 200) + '...');
                }
            });
        });
    </script>

</body>

</html>