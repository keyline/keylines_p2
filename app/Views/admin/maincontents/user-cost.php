<?php
$user = $session->user_type;
//pr($user);
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<style type="text/css">
    #simpletable_filter{
        float: right;
    }
    .simpletable_length label {
        display: inline-flex;
        padding: 10px;
    }
    .charts{
        border: 1px solid #ff980073;
        padding: 10px;
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="GET" action="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="user-cost">
                        <div class="row mb-3 align-items-center">
                            
                            <div class="col-md-3 col-lg-3">
                                <label for="search_user_id">User</label>
                                <select name="search_user_id" class="form-control" id="search_user_id" required>
                                    <option value="all" <?=(($search_user_id == 'all')?'selected':'')?>>All</option>
                                    <hr>
                                    <?php if($users){ foreach($users as $row){?>
                                        <option value="<?=$row->id?>" <?=(($search_user_id == $row->id)?'selected':'')?>><?=$row->name?> - <?=(($row->status == '1')?'Active':'Deactive')?></option>
                                        <hr>
                                    <?php } }?>
                                </select>
                            </div>                                                    
                                                      
                            <div class="col-md-3 col-lg-3">
                                <label for="user_cost">Cost</label>
                                <input type="text" class="form-control" name="user_cost" value="" id="user_cost">                                
                            </div>
                            <div class="col-md-4 col-lg-4">
                            <label for="search_range_from">Date Range</label>
                                <div class="input-group input-daterange">
                                    
                                    <input type="date" id="search_range_from" name="search_range_from" class="form-control" value="<?=$search_range_from?>" style="height: 40px;">
                                    <span class="input-group-text">To</span>
                                    <input type="date" id="search_range_to" name="search_range_to" class="form-control" value="<?=$search_range_to?>" max="<?=date('Y-m-d')?>" style="height: 40px;">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                            <?php if(!empty($response)){?>
                                <a href="<?=base_url('admin/reports/advance-search')?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                            <?php }?>
                        </div>
                    </form>
                </div>
            </div>
            <?php if(!empty($response)){?>                 
                <div class="card mt-3">
                    <div class="card-body pt-3">
                        <h6 class="alert alert-success"><?=count($response)?> result(s) found</h6>
                        <!-- <h5>
                            <a target="_blank" href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/download_csv" class="btn btn-success">Downlaod CSV</a>
                        </h5> -->
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table table-bordered table-striped general_table_style">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="15%">Project</th>
                                        <th width="15%">User</th>
                                        <th width="10%">Work Date</th>
                                        <th width="7%">Time</th>
                                        <th width="7%">Cost</th>
                                        <th width="7%">Hour Rate</th>
                                        <th width="30%">Description</th>
                                        <th width="15%">Type</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totHour    = 0;
                                    $totMinute  = 0;
                                    $totalUsers = [];
                                    $totalTypes = [];
                                    foreach($response as $res){?>
                                        <tr>
                                            <td><?=$res['sl_no']?></td>
                                            <td><?=$res['project_name']?></td>
                                            <td><?=$res['user_name']?></td>
                                            <td><?=$res['work_date']?></td>
                                            <td><?=$res['effort_time']?></td>
                                            <td><?=$res['cost']?></td>
                                            <td><?=$res['hour_rate']?></td>
                                            <td><?=$res['description']?></td>
                                            <td><?=$res['effort_type']?><br><small>(<?=$res['project_status']?>)</small></td>
                                            <td>
                                                <a target="_blank" href="<?=base_url('admin/efforts/edit/'.encoded($res['id']))?>" title="Edit Effort" onclick="return confirm('Do you want to edit this effort ?');"><i class="fa fa-pencil text-primary"></i></a>
                                                <br><br>
                                                <?php
                                                $userType           = $session->user_type;
                                                if($userType == 'admin'){
                                                ?>
                                                    <a href="<?=base_url('admin/efforts/delete/'.encoded($res['id']))?>" title="Delete Effort" onclick="return confirm('Do you want to delete this effort from list ?');"><i class="fa fa-trash text-danger"></i></a>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php
                                        // $totHour    += $res['hour'];
                                        // $totMinute  += $res['min'];
                                        ?>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                
            <?php }?>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $("#is_date_range").click(function() {
        if($(this).is(":checked")) {
            $("#day_range_row").show();
            $("#day_type_row").hide();
        } else {
            $("#day_range_row").hide();
            $("#day_type_row").show();
        }
    });
</script>