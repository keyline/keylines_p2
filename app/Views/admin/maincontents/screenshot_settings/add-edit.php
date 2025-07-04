<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
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
        <?php
        if ($row) {
            $id                   = $row->id;
            $idle_time            = $row->idle_time;
            $screenshot_resolution = $row->screenshot_resolution;
            $screenshot_time      = $row->screenshot_time;
        } else {
            $id                   = '';
            $idle_time            = '';
            $screenshot_resolution = '';
            $screenshot_time      = '';
        }
        ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">

                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-lg-2 col-form-label">Screenshot Resolution</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" class="form-control" name="screenshot_resolution" value="<?= $screenshot_resolution ?>" required placeholder="e.g. 1920x1080">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-2 col-lg-2 col-form-label">Idle Time</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" class="form-control" name="idle_time" value="<?= $idle_time ?>" required placeholder="e.g. 300 (in seconds)">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-lg-2 col-form-label">Screenshot time</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" class="form-control" name="screenshot_time" value="<?= $screenshot_time ?>" required placeholder="e.g. 60 (in seconds)">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><?= (($row) ? 'Save' : 'Add') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
