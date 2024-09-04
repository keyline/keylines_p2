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
              $deprt_name                   = $row->deprt_name;
              $header_color                 = $row->header_color;
              $body_color                   = $row->body_color;
              $is_join_morning_meeting      = $row->is_join_morning_meeting;
              $rank                         = $row->rank;
            } else {
              $deprt_name                   = '';
              $header_color                 = '';
              $body_color                   = '';
              $is_join_morning_meeting      = '';
              $rank                         = '';
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
                                        <label for="deprt_name" class="col-form-label">Department Name</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="deprt_name" class="form-control" id="deprt_name" value="<?=$deprt_name?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="header_color" class="col-form-label">Header Color</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="color" name="header_color" class="form-control" id="header_color" value="<?=$header_color?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="body_color" class="col-form-label">Body Color</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="color" name="body_color" class="form-control" id="body_color" value="<?=$body_color?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="is_join_morning_meeting" class="col-form-label">Is Join Morning Meeting</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input name="is_join_morning_meeting" type="radio" id="is_join_morning_meeting1" value="1" <?=(($is_join_morning_meeting == 1)?'checked':'')?>>
                                        <label for="is_join_morning_meeting1">YES</label>
                                        <input name="is_join_morning_meeting" type="radio" id="is_join_morning_meeting2" value="0" <?=(($is_join_morning_meeting == 0)?'checked':'')?>>
                                        <label for="is_join_morning_meeting2">NO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="rank" class="col-form-label">Rank</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <select name="rank" class="form-control" id="rank" required>
                                            <option value="" selected>Select Rank</option>
                                            <?php for($t=1;$t<=5;$t++){?>
                                                <option value="<?=$t?>" <?=(($t == $rank)?'selected':'')?>><?=$t?></option>
                                            <?php }?>
                                        </select>
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