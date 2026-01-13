<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="pagetitle">
                <h1><?=$page_header?></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
                        <li class="breadcrumb-item active"><?=$page_header?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- End Page Title -->
<section class="section profile">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <?php if(session('success_message')){?>
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message custom-alert" role="alert">
                    <?=session('success_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php }?>
                <?php if(session('error_message')){?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message custom-alert" role="alert">
                    <?=session('error_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php }?>
            </div>
            <?php
                if($row){
                $shifting_name                 = $row->shifting_name;
                $shift_in_time     = $row->shift_in_time;
                $shift_out_time         = $row->shift_out_time;  
                } else {
                $shifting_name                 = '';
                $shift_in_time     = '';
                $shift_out_time         = '';
                }
                ?>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <form method="POST" action="" enctype="multipart/form-data" class="">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="name" class="col-form-label">Shift Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="">
                                            <input type="text" name="shifting_name" class="form-control" id="shifting_name" value="<?=$shifting_name?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="background_color" class="col-form-label">Shifting In Time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="">
                                            <input type="time" name="shift_in_time" class="form-control" id="shift_in_time" value="<?=$shift_in_time?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="border_color" class="col-form-label">Shifting Out Time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="">
                                            <input type="time" name="shift_out_time" class="form-control" id="shift_out_time" value="<?=$shift_out_time?>" required>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm small-btn"><?=(($row)?'Save':'Add')?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>