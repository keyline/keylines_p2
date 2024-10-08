<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
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
<!-- End Page Title -->
<section class="section profile">
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
              $name                 = $row->name;
              $background_color     = $row->background_color;
              $border_color         = $row->border_color;
              $is_schedule          = $row->is_schedule;
              $is_reassign          = $row->is_reassign;
            } else {
              $name                 = '';
              $background_color     = '';
              $border_color         = '';
              $is_schedule          = '';
              $is_reassign          = '';
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data" class="general_form_style">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="name" class="col-form-label">Work Status Name</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="name" class="form-control" id="name" value="<?=$name?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="background_color" class="col-form-label">Background Color</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="color" name="background_color" class="form-control" id="background_color" value="<?=$background_color?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="border_color" class="col-form-label">Border Color</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="color" name="border_color" class="form-control" id="border_color" value="<?=$border_color?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="is_schedule" class="col-form-label">Is Schedule</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input name="is_schedule" type="radio" id="is_schedule1" value="1" <?=(($is_schedule == 1)?'checked':'')?>>
                                        <label for="is_schedule1">YES</label>
                                        <input name="is_schedule" type="radio" id="is_schedule2" value="0" <?=(($is_schedule == 0)?'checked':'')?>>
                                        <label for="is_schedule2">NO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="is_reassign" class="col-form-label">Is Reassign</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input name="is_reassign" type="radio" id="is_reassign1" value="1" <?=(($is_reassign == 1)?'checked':'')?>>
                                        <label for="is_reassign1">YES</label>
                                        <input name="is_reassign" type="radio" id="is_reassign2" value="0" <?=(($is_reassign == 0)?'checked':'')?>>
                                        <label for="is_reassign2">NO</label>
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
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>