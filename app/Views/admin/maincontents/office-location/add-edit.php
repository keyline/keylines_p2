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
              $phone                = $row->phone;
              $email                = $row->email;
              $address              = $row->address;
              $country              = $row->country;
              $state                = $row->state;
              $city                 = $row->city;
              $zipcode              = $row->zipcode;
              $latitude             = $row->latitude;
              $longitude            = $row->longitude;
            } else {
              $name                 = '';
              $phone                = '';
              $email                = '';
              $address              = '';
              $country              = '';
              $state                = '';
              $city                 = '';
              $zipcode              = '';
              $latitude             = '';
              $longitude            = '';
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
                                        <label for="name" class="col-form-label">Name</label>
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
                                        <label for="phone" class="col-form-label">Phone</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="phone" class="form-control" id="phone" value="<?=$phone?>" maxlength="10" minlength="10" onkeypress="return isNumber(event)" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="email" class="col-form-label">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="email" name="email" class="form-control" id="email" value="<?=$email?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="address" class="col-form-label">Address</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="address" class="form-control" id="address" value="<?=$address?>" required>
                                        <input type="text" name="latitude" class="form-control" id="latitude" value="<?=$latitude?>" required>
                                        <input type="text" name="longitude" class="form-control" id="longitude" value="<?=$longitude?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="country" class="col-form-label">Country</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="country" class="form-control" id="country" value="<?=$country?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="state" class="col-form-label">State</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="state" class="form-control" id="state" value="<?=$state?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="city" class="col-form-label">City</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="city" class="form-control" id="city" value="<?=$city?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="zipcode" class="col-form-label">Zipcode</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="zipcode" class="form-control" id="zipcode" maxlength="6" minlength="6" onkeypress="return isNumber(event)" value="<?=$zipcode?>" required>
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