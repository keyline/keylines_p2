<?php
    $title              = $moduleDetail['title'];
    $primary_key        = $moduleDetail['primary_key'];
    $controller_route   = $moduleDetail['controller_route'];
?>
<style type="text/css">
    .control-label{
        font-weight: bold;
    }
</style>
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
            $date_added     = $row->date_added;
            $project_id     = $row->project_id;
            $hour           = $row->hour;
            $min            = $row->min;
            $description    = $row->description;
            $effort_type    = $row->effort_type;
        } else {
            $date_added     = '';
            $project_id     = '';
            $hour           = '';
            $min            = '';
            $description    = '';
            $effort_type    = '';
        }
        ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row" style="border:1px solid #f19620a6; padding: 10px; border-radius: 5px; margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-md-12">
                                <label class="control-label">Effort Date</label>
                                <h5 class="text-success"><?=date_format(date_create($date_added), "M d, Y")?></h5>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Project</label>
                                <br>
                                <select name="project" data-index="0" class="select_proj form-control" style="font-size: 12px;" autocomplete="off" required>
                                    <option value="" selected="">Select Project</option>
                                    <?php if($projects){ foreach($projects as $project){?>
                                        <option value="<?=$project->id?>" <?=(($project_id == $project->id)?'selected':'')?>><?=$project->name?> (<?=$project->client_name?>) - <?=$project->project_status_name?></option>
                                        <hr>
                                    <?php } }?>
                                    
                                </select>
                                <div class="fill_up_project" style="color: red;"></div>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Hour</label>
                                <br>
                                <input type="number" name="hour" minlength="0" maxlength="2" min="0" max="4" class="form-control" required="" autocomplete="off" value="<?=$hour?>">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Minute</label>
                                <br>
                                <input type="number" name="minute" minlength="0" maxlength="2" min="0" max="50" class="form-control" required="" autocomplete="off" value="<?=$min?>">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Description</label>
                                <languagebr>
                                    <textarea name="description" class="form-control description" rows="3" autocomplete="off" required><?=$description?></textarea>
                                    <div class="itemDetails">
                                        
                                    </div>
                                </languagebr>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Effort Type</label>
                                <br>
                                <select name="effort_type" class="select_et form-control" style="font-size: 12px;" autocomplete="off" required>
                                    <option value="" selected="">Select Type</option>
                                    <?php if($effortTypes){ foreach($effortTypes as $effortType){?>
                                    <option value="<?=$effortType->id?>" <?=(($effort_type == $effortType->id)?'selected':'')?>><?=$effortType->name?></option>
                                    <?php } }?>
                                </select>
                                <div class="fill_up_et" style="color: red;"></div>
                            </div>
                        </div>
                        <div class="text-left mt-3">
                            <button type="submit" class="btn btn_org btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>