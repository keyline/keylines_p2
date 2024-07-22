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
              $dep_id                 = $row->dep_id;
              $user_id                = $row->user_id;              
              $type                 = $row->type;              
            } else {
              $dep_id                 = '';
              $user_id                = '';           
              $type                 = '';              
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <span class="text-danger">Star (*) marks fields are mandatory</span>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="col-form-label">Department Id <span class="text-danger">*</span></label>
                                <select name="dep_id" class="form-control" id="search_user_id" required>
                                    <option value="all">All</option>
                                    <hr>
                                    <?php if($department){ foreach($department as $row){?>
                                        <option value="<?=$row->id?>"<?=(($dep_id == $row->id)?'selected':'')?>><?=$row->deprt_name?></option>
                                        <hr>
                                    <?php } }?>
                                </select>
                                <!-- <input type="text" name="dep_id" class="form-control" id="name" value="<?=$dep_id?>" required> -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="col-form-label">User Id <span class="text-danger">*</span></label>
                                <select name="user_id" class="form-control" id="search_user_id" required>
                                    <option value="all">All</option> 
                                     <hr>
                                    <?php                                     
                                    if($users){ foreach($users as $row){?>
                                        <option value="<?=$row->id?>"<?=(($user_id == $row->id)?'selected':'')?>><?=$row->name?></option>
                                        <hr>
                                    <?php } }?>
                                </select>
                                <!-- <input type="text" name="user_id" class="form-control" id="name" value="<?=$user_id?>" required> -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-control" id="type" required>
                                    <option value="" selected>Select Type</option>
                                    <option value="Teamlead" <?=(($type == 'Teamlead')?'selected':'')?>>Team Lead</option>
                                    <option value="Sublead" <?=(($type == 'Sublead')?'selected':'')?>>Sub Lead</option>
                                    <option value="Member" <?=(($type == 'Member')?'selected':'')?>>Member</option>                                    
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