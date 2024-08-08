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
            <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '/list/') ?>"><?= $title ?> List</a></li>
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
            <?php
                if($row){
                    $client_id        = $row->client_id;
                    $project_id       = $row->project_id;
                    $title            = $row->title;
                    $description      = $row->description;
                } else {
                    $client_id        = '';
                    $project_id       = '';
                    $title            = '';
                    $description      = '';
                }
            ?>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="proposal_title" class="col-md-4 col-lg-3 col-form-label">Document Title <span style="color:red">*</span></label>
                            <div class="col-md-8 col-lg-9">
                                <input name="proposal_title" type="text" required class="form-control" id="proposal_title" value="<?=$title;?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="proposal_description" class="col-md-4 col-lg-3 col-form-label">Document Description</label>
                            <div class="col-md-8 col-lg-9">
                                <textarea name="proposal_description" class="form-control" id="proposal_description" rows="5"><?=$description;?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="proposal_file" class="col-md-4 col-lg-3 col-form-label">Files <span style="color:red">*</span></label>
                            <div class="col-md-8 col-lg-9">
                                <input name="proposal_file[]" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt" multiple class="form-control" required id="proposal_file" value="">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>