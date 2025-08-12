<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<style type="text/css">
    .col-form-label{
        font-weight: bold;
    }
</style>
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
                $name                     = $row->name;
                $description              = $row->description;
                $assigned_by              = $row->assigned_by;
                $status                   = $row->status;
                $hour                     = $row->hour;
                $hour_month               = $row->hour_month;
                $project_time_type        = $row->project_time_type;
                $client_id                = $row->client_id;
                $temporary_url            = $row->temporary_url;
                $permanent_url            = $row->permanent_url;
                $client_service           = $row->client_service;
                $start_date               = $row->start_date;
                $deadline                 = $row->deadline;
                $parent                   = $row->parent;
                $bill                     = $row->bill;
                $type                     = $row->type;
                $active                   = $row->active;
                } else {
                $name                     = '';
                $description              = '';
                $assigned_by              = '';
                $status                   = '';
                $hour                     = '';
                $hour_month               = '';
                $project_time_type        = '';
                $client_id                = '';
                $temporary_url            = '';
                $permanent_url            = '';
                $client_service           = '';
                $start_date               = '';
                $deadline                 = '';
                $parent                   = '';
                $bill                     = '';
                $type                     = '';
                $active                   = '';
                }
                ?>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <small class="text-danger">Star (*) marks fields are mandatory</small>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-6">
                                    <label for="name" class="col-form-label">Name <small class="text-danger">*</small></label>
                                    <input type="text" name="name" class="form-control" id="name" value="<?=$name?>" required>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label for="description" class="col-form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="1" id="description"><?=$description?></textarea>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label for="assigned_by" class="col-form-label">Assigned By <small class="text-danger">*</small></label>
                                    <select name="assigned_by" class="form-control" id="assigned_by" required>
                                        <option value="" selected>Select</option>
                                        <hr>
                                        <?php if($users){ foreach($users as $user){?>
                                            <option value="<?=$user->id?>" <?=(($assigned_by == $user->id)?'selected':'')?>><?=$user->name?></option>
                                            <hr>
                                        <?php } }?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label for="status" class="col-form-label">Type <small class="text-danger">*</small></label>
                                    <select name="status" class="form-control" id="status" required>
                                        <option value="" selected>Select</option>
                                        <hr>
                                        <?php if($projectStats){ foreach($projectStats as $projectStat){?>
                                            <option value="<?=$projectStat->id?>" <?=(($status == $projectStat->id)?'selected':'')?>><?=$projectStat->name?></option>
                                            <hr>
                                        <?php } }?>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label for="type" class="col-form-label">Status <small class="text-danger">*</small></label>
                                    <p>
                                        <input type="radio" name="type" id="type1" value="Own" <?=(($type == 'Own')?'checked':'')?> required>&nbsp;&nbsp;<label for="type1">Own</label>
                                        <input type="radio" name="type" id="type2" value="Lost" <?=(($type == 'Lost')?'checked':'')?> required>&nbsp;&nbsp;<label for="type2">Lost</label>
                                        <input type="radio" name="type" id="type3" value="Prospect" <?=(($type == 'Prospect')?'checked':'')?> required>&nbsp;&nbsp;<label for="type3">Prospect</label>
                                    </p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label for="client_id" class="col-form-label">Contact <small class="text-danger">*</small></label>
                                    <select name="client_id" class="form-control" id="client_id" required>
                                        <option value="" selected>Select</option>
                                        <hr>
                                        <?php if($clients){ foreach($clients as $client){?>
                                            <option value="<?=$client->id?>" <?=(($client_id == $client->id)?'selected':'')?>><?=$pro->decrypt($client->name)?> <?=(($pro->decrypt($client->compnay) != '')?'(' . $pro->decrypt($client->compnay) . ')':'')?></option>
                                            <hr>
                                        <?php } }?>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label for="type" class="col-form-label">Project Time Type <small class="text-danger">*</small></label>
                                    <p>
                                        <input type="radio" name="project_time_type" id="project_time_type1" value="Onetime" <?=(($project_time_type == 'Onetime')?'checked':'')?> required>&nbsp;&nbsp;<label for="project_time_type1">Fixed Cost</label>
                                        <input type="radio" name="project_time_type" id="project_time_type2" value="Monthlytime" <?=(($project_time_type == 'Monthlytime')?'checked':'')?> required>&nbsp;&nbsp;<label for="project_time_type2">T&M / Retainership</label>
                                    </p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <p id="Onetime" style="display: none;">
                                        <label for="hour" class="col-form-label">Hour <small class="text-danger">*</small></label>
                                        <input type="text" name="hour" class="form-control" id="hour" value="<?=$hour?>">
                                    </p>
                                    <p id="Monthlytime" style="display: none;">
                                        <label for="hour_month" class="col-form-label">Hour/Month <small class="text-danger">*</small></label>
                                        <input type="text" name="hour_month" class="form-control" id="hour_month" value="<?=$hour_month?>">
                                    </p>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label for="start_date" class="col-form-label">Start Date <small class="text-danger">*</small></label>
                                    <input type="date" name="start_date" class="form-control" id="start_date" value="<?=$start_date?>" required>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label for="deadline" class="col-form-label">Deadline <small class="text-danger">*</small></label>
                                    <input type="date" name="deadline" class="form-control" id="deadline" value="<?=$deadline?>" required>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label for="temporary_url" class="col-form-label">Temporary URL</label>
                                    <input type="text" name="temporary_url" class="form-control" id="temporary_url" value="<?=$temporary_url?>">
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label for="permanent_url" class="col-form-label">Permanent URL</label>
                                    <input type="text" name="permanent_url" class="form-control" id="permanent_url" value="<?=$permanent_url?>">
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label for="parent" class="col-form-label">Parent</label>
                                    <select name="parent" class="form-control" id="parent" required>
                                        <option value="0" selected>No Parent</option>
                                        <hr>
                                        <?php if($projects){ foreach($projects as $project){?>
                                            <option value="<?=$project->id?>" <?=(($parent == $project->id)?'selected':'')?>><?=$project->name?></option>
                                            <hr>
                                        <?php } }?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label for="client_service" class="col-form-label">Contact Service <small class="text-danger">*</small></label>
                                    <select name="client_service" class="form-control" id="client_service" required>
                                        <option value="" selected>Select</option>
                                        <hr>
                                        <?php if($users){ foreach($users as $user){?>
                                            <option value="<?=$user->id?>" <?=(($client_service == $user->id)?'selected':'')?>><?=$user->name?></option>
                                            <hr>
                                        <?php } }?>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label for="type" class="col-form-label">Billable/Non-billable <small class="text-danger">*</small></label>
                                    <p>
                                        <input type="radio" name="bill" id="bill1" value="0" <?=(($bill == 0)?'checked':'')?> required>&nbsp;&nbsp;<label for="bill1">Billable</label>
                                        <input type="radio" name="bill" id="bill2" value="1" <?=(($bill == 1)?'checked':'')?> required>&nbsp;&nbsp;<label for="bill2">Non-billable</label>
                                    </p>
                                </div>
                                <!-- <div class="col-lg-6 col-md-6">
                                    <label for="type" class="col-form-label">Active <small class="text-danger">*</small></label>
                                    <p>
                                        <input type="radio" name="active" id="active1" value="0" <?=(($active == 0)?'checked':'')?> required>&nbsp;&nbsp;<label for="active1">Active</label>
                                        <input type="radio" name="active" id="active2" value="1" <?=(($active == 1)?'checked':'')?> required>&nbsp;&nbsp;<label for="active2">Deactive</label>
                                    </p>
                                </div> -->
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><?=(($row)?'Save':'Add')?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script> -->
<script src="https://cdn.ckeditor.com/4.24.0-lts/standard/ckeditor.js"></script>
<script>
        CKEDITOR.replace( 'description' );
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        var project_time_type = '<?=$project_time_type?>';
        if(project_time_type == 'Onetime') {
            $("#Onetime").show();
            $("#Monthlytime").hide();
        } else {
            $("#Onetime").hide();
            $("#Monthlytime").show();
        }
        $('input[name="project_time_type"]').click(function() {
            if($('input[name="project_time_type"]:checked').val() == 'Onetime') {
                $("#Onetime").show();
                $("#Monthlytime").hide();
                $('#hour').attr('required', true);
                $('#hour_month').attr('required', false);
            } else {
                $("#Onetime").hide();
                $("#Monthlytime").show();
                $('#hour').attr('required', false);
                $('#hour_month').attr('required', true);
            }
        });
    })
</script>