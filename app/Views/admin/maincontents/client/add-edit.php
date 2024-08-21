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
            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                <?=session('success_message')?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
            <?php if(session('error_message')){?>
            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                <?=session('error_message')?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
        </div>
        <?php
            if($row){
              $name             = $pro->decrypt($row->name);
              $compnay          = $pro->decrypt($row->compnay);
              $address_1        = $row->address_1;
              $state            = $row->state;
              $city             = $row->city;
              $country          = $row->country;
              $pin              = $row->pin;
              $address_2        = $row->address_2;
              $email_1          = $pro->decrypt($row->email_1);
              $email_2          = $pro->decrypt($row->email_2);
              $phone_1          = $pro->decrypt($row->phone_1);
              $phone_2          = $pro->decrypt($row->phone_2);
              $dob_day          = $row->dob_day;
              $dob_month        = $row->dob_month;
              $dob_year         = $row->dob_year;
              $password         = $row->password_org;
              $comment          = $row->comment;
              $reference        = $row->reference;
              $login_access     = $row->login_access;
              $client_of        = $row->client_of;
            } else {
              $name             = '';
              $compnay          = '';
              $address_1        = '';
              $state            = '';
              $city             = '';
              $country          = '';
              $pin              = '';
              $address_2        = '';
              $email_1          = '';
              $email_2          = '';
              $phone_1          = '';
              $phone_2          = '';
              $dob_day          = '';
              $dob_month        = '';
              $dob_year         = '';
              $comment          = '';
              $reference        = '';
              $login_access     = '';
              $client_of        = '';
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6">
                                <label for="name" class="col-form-label">Name <small class="text-danger">*</small></label>
                                <input type="text" name="name" class="form-control" id="name" value="<?=$name?>" required>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="compnay" class="col-form-label">Company <small class="text-danger">*</small></label>
                                <input type="text" name="compnay" class="form-control" id="compnay" value="<?=$compnay?>" required>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label for="address_1" class="col-form-label">Address 1 <small class="text-danger">*</small></label>
                                <textarea name="address_1" class="form-control" id="address_1" required><?=$address_1?></textarea>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="state" class="col-form-label">State <small class="text-danger">*</small></label>
                                <input type="text" name="state" class="form-control" id="state" value="<?=$state?>" required>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label for="city" class="col-form-label">City <small class="text-danger">*</small></label>
                                <input type="text" name="city" class="form-control" id="city" value="<?=$city?>" required>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="country" class="col-form-label">Country <small class="text-danger">*</small></label>
                                <select name="country" class="form-control" id="country" required>
                                    <option value="" selected>Select</option>
                                    <hr>
                                    <?php if($countries){ foreach($countries as $coun){?>
                                        <option value="<?=$coun->name?>" <?=(($country == $coun->name)?'selected':'')?>><?=$coun->name?></option>
                                        <hr>
                                    <?php } }?>
                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label for="pin" class="col-form-label">Pincode <small class="text-danger">*</small></label>
                                <input type="text" name="pin" class="form-control" id="pin" value="<?=$pin?>" required>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="address_2" class="col-form-label">Address 2</label>
                                <textarea name="address_2" class="form-control" id="address_2"><?=$address_2?></textarea>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label for="email_1" class="col-form-label">Email 1 <small class="text-danger">*</small></label>
                                <input type="email" name="email_1" class="form-control" id="email_1" value="<?=$email_1?>" required>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="email_2" class="col-form-label">Email 2</label>
                                <input type="email" name="email_2" class="form-control" id="email_2" value="<?=$email_2?>">
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label for="phone_1" class="col-form-label">Phone 1 <small class="text-danger">*</small></label>
                                <input type="text" name="phone_1" class="form-control" id="phone_1" value="<?=$phone_1?>" minlength="10" maxlength="10" onkeypress="return isNumber(event)" required>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="phone_2" class="col-form-label">Phone 2</label>
                                <input type="text" name="phone_2" class="form-control" id="phone_2" value="<?=$phone_2?>" minlength="10" maxlength="10" onkeypress="return isNumber(event)">
                            </div>

                            <div class="col-lg-4 col-md-4">
                                <label for="dob_day" class="col-form-label">DOB Date</label>
                                <select name="dob_day" class="form-control" id="dob_day">
                                    <option value="" selected>Select</option>
                                    <hr>
                                    <?php for($i=1;$i<=31;$i++){?>
                                        <option value="<?=$i?>" <?=(($dob_day == $i)?'selected':'')?>><?=$i?></option>
                                        <hr>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label for="dob_month" class="col-form-label">DOB Month</label>
                                <select name="dob_month" class="form-control" id="dob_month">
                                    <option value="" selected>Select</option>
                                    <hr>
                                    <option value="January" <?=(($dob_month == 'January')?'selected':'')?>>January</option><hr>
                                    <option value="February" <?=(($dob_month == 'February')?'selected':'')?>>February</option><hr>
                                    <option value="March" <?=(($dob_month == 'March')?'selected':'')?>>March</option><hr>
                                    <option value="April" <?=(($dob_month == 'April')?'selected':'')?>>April</option><hr>
                                    <option value="May" <?=(($dob_month == 'May')?'selected':'')?>>May</option><hr>
                                    <option value="June" <?=(($dob_month == 'June')?'selected':'')?>>June</option><hr>
                                    <option value="July" <?=(($dob_month == 'July')?'selected':'')?>>July</option><hr>
                                    <option value="August" <?=(($dob_month == 'August')?'selected':'')?>>August</option><hr>
                                    <option value="September" <?=(($dob_month == 'September')?'selected':'')?>>September</option><hr>
                                    <option value="October" <?=(($dob_month == 'October')?'selected':'')?>>October</option><hr>
                                    <option value="November" <?=(($dob_month == 'November')?'selected':'')?>>November</option><hr>
                                    <option value="December" <?=(($dob_month == 'December')?'selected':'')?>>December</option><hr>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label for="dob_year" class="col-form-label">DOB Year</label>
                                <select name="dob_year" class="form-control" id="dob_year">
                                    <option value="" selected>Select</option>
                                    <hr>
                                    <?php for($i=1930;$i<=date('Y');$i++){?>
                                        <option value="<?=$i?>" <?=(($dob_year == $i)?'selected':'')?>><?=$i?></option>
                                        <hr>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="password" class="col-form-label">Password <small class="text-danger">*</small></label>
                                <input type="password" name="password" class="form-control" id="password" required value="<?=$password?>" >
                                <?php if($row){?><small>Leave blank if do not want to update</small><?php }?>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label for="comment" class="col-form-label">Comment</label>
                                <textarea name="comment" class="form-control" id="comment"><?=$comment?></textarea>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label for="reference" class="col-form-label">Reference</label>
                                <input type="text" name="reference" class="form-control" id="reference" value="<?=$reference?>">
                            </div>

                            <div class="col-lg-4 col-md-4">
                                <label for="client_of" class="col-form-label">Contact of <small class="text-danger">*</small></label>
                                <select name="client_of" class="form-control" id="client_of" required>
                                    <option value="" selected>Select</option>
                                    <hr>
                                    <?php if($users){ foreach($users as $user){?>
                                        <option value="<?=$user->id?>" <?=(($client_of == $user->id)?'selected':'')?>><?=$user->name?></option>
                                        <hr>
                                    <?php } }?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label for="login_access" class="col-form-label">Login Access <small class="text-danger">*</small></label>
                                <select name="login_access" class="form-control" id="login_access" required>
                                    <option value="" selected>Select</option>
                                    <hr>
                                    <option value="1" <?=(($login_access == '1')?'selected':'')?>>YES</option><hr>
                                    <option value="0" <?=(($login_access == '0')?'selected':'')?>>NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><?=(($row)?'Save':'Add')?></button>
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