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
              $email                = $row->email;
              $personal_email       = $row->personal_email;
              $phone1               = $row->phone1;
              $phone2               = $row->phone2;
              $address              = $row->address;
              $pincode              = $row->pincode;
              $latitude             = $row->latitude;
              $longitude            = $row->longitude;
              $password             = $row->password;
              $type                 = $row->type;
              $category             = $row->category;
              $hour_cost            = $row->hour_cost;
              $dob                  = $row->dob;
              $doj                  = $row->doj;
              $profile_image        = $row->profile_image;
              $status               = $row->status;
              $work_mode            = $row->work_mode;
              $is_tracker_user      = $row->is_tracker_user;
              $is_salarybox_user    = $row->is_salarybox_user;
              $attendence_type      = json_decode($row->attendence_type);
            } else {
              $name                 = '';
              $email                = '';
              $personal_email       = '';
              $phone1               = '';
              $phone2               = '';
              $address              = '';
              $pincode              = '';
              $latitude             = '';
              $longitude            = '';
              $password             = '';
              $type                 = '';
              $category             = '';
              $hour_cost            = '';
              $dob                  = '';
              $doj                  = '';
              $profile_image        = '';
              $status               = '';
              $work_mode            = '';
              $is_tracker_user      = '';
              $is_salarybox_user    = '';
              $attendence_type      = [];
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <!-- <span class="text-danger">Star (*) marks fields are mandatory</span> -->
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- name field -->
                                    <div class="col-md-6 col-lg-6">
                                        <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <div class="general_form_right_box">
                                            <input type="text" name="name" class="form-control" id="name" value="<?=$name?>" required>
                                        </div>
                                    </div>
                                    <!-- Email field -->
                                    <div class="col-md-6 col-lg-6">
                                        <label for="email" class="col-form-label" >Email <span class="text-danger">*</span></label> 
                                        <div class="general_form_right_box">
                                            <input type="email" name="email" id="email" class="form-control" id="email" value="<?=$email?>" required>
                                            <span id="email-error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <!-- Alternate Email field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="personal_email" class="col-form-label">Alternate Email</label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <input type="email" name="personal_email" class="form-control" id="personal_email" value="<?=$personal_email?>">
                                        </div>
                                    </div>
                                    <!-- Phone field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="phone1" class="col-form-label">Phone <span class="text-danger">*</span></label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <input type="text" name="phone1" class="form-control" id="phone1" value="<?=$phone1?>" minlength="10" maxlength="10" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                    <!--Alternate Phone field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="phone2" class="col-form-label">Alternate Phone</label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <input type="text" name="phone2" class="form-control" id="phone2" value="<?=$phone2?>" minlength="10" maxlength="10" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                    <!-- address field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="address" class="col-form-label">Address</label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <input type="text" name="address" class="form-control" id="address" value="<?=$address?>">
                                            <input type="hidden" name="latitude" id="latitude" value="<?=$latitude?>">
                                            <input type="hidden" name="longitude" id="longitude" value="<?=$longitude?>">
                                        </div>
                                    </div>
                                    <!-- Pincode field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="pincode" class="col-form-label">Pincode</label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <input type="text" name="pincode" class="form-control" id="pincode" value="<?=$pincode?>" minlength="6" maxlength="6" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                    <!--Password fields -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="password" class="col-form-label">Password <span class="text-danger">*</span></label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box position-relative">
                                            <input type="password" name="password" class="form-control" id="password" <?=((empty($row))?'required':'')?> autocomplete="off">
                                            <div class="eye position-absolute end-0 translate-middle" style="top: 35% !important;">
                                                <i class="fa fa-eye-slash" id="viewPassword" style="cursor:pointer;"></i>
                                                <i class="fa fa-eye" id="hidePassword" style="cursor:pointer;display: none;"></i>
                                            </div>
                                            <span class="text-primary">Leave blank if you do not want to change password</span>
                                        </div>
                                    </div>
                                    <!--Category field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="category" class="col-form-label">Category <span class="text-danger">*</span></label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <select name="category" class="form-control" id="category" required>
                                                <option value="" selected>Select Category</option>
                                                <?php if($userCats){ foreach($userCats as $userCat){?>
                                                <option value="<?=$userCat->id?>" <?=(($userCat->id == $category)?'selected':'')?>><?=$userCat->name?></option>
                                                <?php } }?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Type field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <select name="type" class="form-control" id="type" required onchange="updateHiddenField()">
                                                <option value="" selected>Select Type</option>
                                                <?php if($roleMasters){ foreach($roleMasters as $roleMaster){?>
                                                    <option value="<?=$roleMaster->role_name;?>" <?= $roleMaster->role_name == $type ? 'selected' : ''   ?>  ><?=$roleMaster->role_name;?></option>
                                                <?php } }?>
                                            </select>
                                            <input type="hidden" id="role_id" name="role_id" value="">
                                            <?php foreach ($roleMasters as $roleMaster): ?>
                                                <?php if ($roleMaster->role_name == htmlspecialchars($type)): ?>
                                                    <input type="hidden" name="role_id" id="role_ide" value="<?= htmlspecialchars($roleMaster->id); ?>">
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <!--Hour Cost field -->
                                    <!-- <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="hour_cost" class="col-form-label">Hour Cost</label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <input type="text" name="hour_cost" class="form-control" id="hour_cost" value="<?=$hour_cost?>" minlength="2" maxlength="4" onkeypress="return isNumber(event)">
                                        </div>
                                    </div> -->
                                    <!--DOB field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="dob" class="col-form-label">DOB</label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <input type="date" name="dob" class="form-control" id="dob" value="<?=$dob?>" max="<?=date('Y-m-d')?>">
                                        </div>
                                    </div>
                                    <!--DOJ field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="doj" class="col-form-label">DOJ</label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <input type="date" name="doj" class="form-control" id="doj" value="<?=$doj?>" max="<?=date('Y-m-d')?>">
                                        </div>
                                    </div>
                                    <!--Status field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box d-flex align-items-center">
                                            <input class="me-1" type="radio" name="status" id="status1" value="1" <?=(($status == '1')?'checked':'')?> required> <label class="me-2" for="status1">Active</label>
                                            <input class="me-1" type="radio" name="status" id="status2" value="0" <?=(($status == '0')?'checked':'')?> required> <label for="status2">Deactive</label>
                                        </div>
                                    </div>
                                    <!--Work Mode field -->
                                    <!-- <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="work_mode" class="col-form-label">Work Mode <span class="text-danger">*</span></label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                            <select name="work_mode" class="form-control" id="work_mode" required>
                                                <option value="" selected>Select Work Mode</option>
                                                <option value="Work From Office" <?=(($work_mode == 'Work From Office')?'selected':'')?>>Work From Office</option>
                                                <option value="Work From Home" <?=(($work_mode == 'Work From Home')?'selected':'')?>>Work From Home</option>
                                                <option value="Hybrid" <?=(($work_mode == 'Hybrid')?'selected':'')?>>Hybrid</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!--Tracker User field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="is_tracker_user" class="col-form-label">Task Management <span class="text-danger">*</span></label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box d-flex align-items-center">
                                            <input class="me-1" type="radio" name="is_tracker_user" id="is_tracker_user1" <?=(($is_tracker_user == '1')?'checked':'')?> value="1" required> <label class="me-2" for="is_tracker_user1">YES</label>
                                            <input class="me-1" type="radio" name="is_tracker_user" id="is_tracker_user2" <?=(($is_tracker_user == '0')?'checked':'')?> value="0" required> <label for="is_tracker_user2">NO</label>
                                        </div>
                                    </div>
                                    <!--Salarybox User field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="is_salarybox_user" class="col-form-label">Mobile App User <span class="text-danger">*</span></label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box d-flex align-items-center">
                                            <input class="me-1" type="radio" name="is_salarybox_user" id="is_salarybox_user1" value="1" <?=(($is_salarybox_user == '1')?'checked':'')?> required> <label class="me-2" for="is_salarybox_user1">YES</label>
                                            <input class="me-1" type="radio" name="is_salarybox_user" id="is_salarybox_user2" value="0"  <?=(($is_salarybox_user == '0')?'checked':'')?>required> <label for="is_salarybox_user2">NO</label>
                                        </div>
                                    </div>
                                    <!--Attendence Type field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="attendence_type" class="col-form-label">Attendence Type <span class="text-danger">*</span></label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box d-flex align-items-center">
                                            <input class="me-1 attnType" type="checkbox" name="attendence_type[]" id="attendence_type0" value="0" <?=((in_array(0, $attendence_type))?'checked':'')?>> <label class="me-2" for="attendence_type0" onclick="getAttnValue(0);">Hybrid Mode<br><span style="font-size: 10px;">(Work From Home)</span></label>

                                            <?php if($officeLocations){ foreach($officeLocations as $officeLocation){?>
                                                <input class="me-1 attnType" type="checkbox" name="attendence_type[]" id="attendence_type<?=$officeLocation->id?>" value="<?=$officeLocation->id?>"  <?=((in_array($officeLocation->id, $attendence_type))?'checked':'')?>> <label for="attendence_type<?=$officeLocation->id?>" onclick="getAttnValue(<?=$officeLocation->id?>);"><?=$officeLocation->name?><br><span style="font-size: 10px;">(<?=$officeLocation->address?>)</span></label>
                                            <?php } }?>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box d-flex align-items-center">
                                            <select name="attendence_type" class="form-control" id="attendence_type" required>
                                                <option value="" selected>Select Attendence Type</option>
                                                <option value="OPEN" <?=(($attendence_type == 'OPEN')?'selected':'')?>>OPEN</option>
                                                <option value="OFFICE 1" <?=(($attendence_type == 'OFFICE 1')?'selected':'')?>>OFFICE 1</option>
                                                <option value="OFFICE 2" <?=(($attendence_type == 'OFFICE 2')?'selected':'')?>>OFFICE 2</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!--Profile Image field -->
                                    <div class="col-md-2 col-lg-2">
                                        <div class="general_form_left_box">
                                            <label for="image" class="col-form-label">Profile Image</label>
                                        </div>  
                                    </div>
                                    <div class="col-md-10 col-lg-10">
                                        <div class="general_form_right_box">
                                        <input type="file" name="image" class="form-control" id="profile_image" accept="image/*">
                                        <small class="text-dark">* Only JPG, JPEG, ICO, SVG, PNG files are allowed</small><br>
                                        <?php if($profile_image != ''){?>
                                        <img class="img-thumbnail" src="<?=getenv('app.uploadsURL').'user/'.$profile_image?>" alt="<?=$name?>" style="width: 150px; height: 150px; margin-top: 10px; border-radius:50%">
                                        <?php } else {?>
                                        <img class="img-thumbnail" src="<?=getenv('app.NO_IMAGE')?>" alt="<?=$name?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px; border-radius:50%">
                                        <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary font-12 btn-sm mt-1"><?=(($row)?'Save':'Add')?></button>
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
<script>
    const roles        = <?php echo json_encode($roleMasters); ?>;
    const roleMapping  = {};
    for(let i = 0; i < roles.length; i++){
        roleMapping[roles[i]['role_name']] = roles[i]['id'];
    }
    function updateHiddenField() {
        $('#role_ide').remove();
        const selectedType = document.getElementById('type').value;
        const roleIdField = document.getElementById('role_id');
        roleIdField.value = roleMapping[selectedType] || '';
    }
</script>
<script>
    $(function(){
        $('#viewPassword').on('click', function(){
            $('#password').attr('type', 'text');
            $('#viewPassword').hide();
            $('#hidePassword').show();
        });
        $('#hidePassword').on('click', function(){
            $('#password').attr('type', 'password');
            $('#hidePassword').hide();
            $('#viewPassword').show();
        });
    });
    function getAttnValue(valam){
        // Check if the checkbox is checked
        if (!$('#attendence_type' + valam).is(':checked')) {
            // Checkbox is checked, get the value
            var checkboxValue = $('#attendence_type' + valam).val();
            // console.log('Checkbox is checked. Value: ' + checkboxValue);
            if(checkboxValue == 0){
                $('.attnType').attr('disabled', true);
                $('#attendence_type' + valam).attr('disabled', false);
            }
        } else {
            // console.log('Checkbox is not checked.');
            $('.attnType').attr('disabled', false);
        }
    }
</script>
<script>
$(document).ready(function () {
    $('#email').on('blur', function () {
        var email = $(this).val();
        if (email !== '') {
            $.ajax({
                url: '<?= base_url("user/check_email") ?>', // adjust path accordingly
                method: 'POST',
                data: { email: email },
                success: function (response) {
                    if (response === 'exists') {
                        $('#email-error').text('Email already exists!');
                        $('#email').addClass('is-invalid');
                    } else {
                        $('#email-error').text('');
                        $('#email').removeClass('is-invalid');
                    }
                }
            });
        }
    });
});
</script>