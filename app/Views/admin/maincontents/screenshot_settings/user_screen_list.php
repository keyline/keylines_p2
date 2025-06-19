<!-- lightbox CSS -->
<link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />
<style>
    .row {
        margin: 15px;
    }
</style>

<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>

            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
    <div class="row">
        <div class="col-xl-12">
            <?php if (session('success_message')) { ?>
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?= session('success_message') ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <?php if (session('error_message')) { ?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?= session('error_message') ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">

                    <form method="GET" action="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="search">
                        <div class="row mb-3 align-items-center">


                            <div class="col-md-4 col-lg-4" id="day_range_row" style="margin-top: 18px;">
                                <div class="input-group input-daterange">
                                    <!-- <label for="search_range_from">Date Range</label> -->
                                    <input type="date" id="search_range_from" name="start" class="form-control" value="<?= $start_date ?>" style="height: 40px;">
                                    <span class="input-group-text">To</span>
                                    <input type="date" id="search_range_to" name="end" class="form-control" value="<?= $end_date ?>" style="height: 40px;">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                        </div>
                    </form>

                    <!-- ____ code ____ -->

                    <div class="container my-4">
                        <div class="row g-3">
                            <?php if (count($row)) {
                                foreach ($row as $screenshot) { ?>
                                  

                                    <div class="col-3">
                                        <div class="card">
                                            <a href="<?= getenv('app.uploadsURL') . 'screenshot/' . $screenshot['image_name'] ?>" class="glightbox">
                                                <img src="<?= getenv('app.uploadsURL') . 'screenshot/' . $screenshot['image_name'] ?>" class="card-img-top img-fluid rounded" alt="Screenshot image">
                                            </a>
                                            <div class="card-body p-2">
                                                <p class="card-text text-center mb-0"><?= date('F j, Y \a\t h:i A', strtotime($screenshot['time_stamp'])) ?></p> 
                                            </div>
                                        </div>
                                    </div>

                                <?php }
                            } else { ?>
                                <div class="col-12">
                                    <div class="alert alert-warning" role="alert">
                                        No screenshots found for the selected date range.
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>


                    <!-- ____ code ____ -->
                </div>
            </div>
        </div>
    </div>
</section>


<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
    const lightbox = GLightbox({
        selector: '.glightbox'
    });
</script>