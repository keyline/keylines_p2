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
                <?php if(checkModuleFunctionAccess(26,47)){ ?>
                    <a href="<?=base_url('admin/reports/get-desklog-report')?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to fetch data from desklog ?');">Fetch Current Date Date From Desklog</a>
                    <?php } ?>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="advance_search">
                        <div class="row mb-3 align-items-center">                                                                                                                                      
                            <div class="col-md-6 col-lg-6">
                                <label for="is_date_range">Date</label>
                                <input type="date" id="is_date_range" name="is_date_range" class="form-control" value="<?=$is_date_range?>" required>
                            </div>
                            <?php if(checkModuleFunctionAccess(26,46)){ ?>
                            <div class="col-md-6 col-lg-6">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                                    <?php if(!empty($dateWise)){?>
                                        <a href="<?=base_url('admin/reports/advance-search')?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                                    <?php }?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            // pr($dateWise);
            if(!empty($dateWise)){?>   
            <?php if(checkModuleFunctionAccess(26,49)){ ?>              
                <div class="card mt-3">
                    <div class="card-body pt-3">
                        <!-- <h6 class="alert alert-success"><?=count($dateWise)?> result(s) found</h6> -->
                        <!-- <h5>
                            <a target="_blank" href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/download_csv" class="btn btn-success">Downlaod CSV</a>
                        </h5> -->
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table table-bordered general_table_style">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="5%">Desklog Usrid</th>
                                        <th width="5%">Tracker User Id</th>
                                        <th width="10%">Email</th>
                                        <th width="7%">Arrival At</th>
                                        <th width="30%">Left At</th>
                                        <th width="15%">Time At Work</th>
                                        <th width="5%">Productive Time</th>
                                        <th width="5%">Idle Time</th>
                                        <th width="5%">Private Time</th>
                                        <th width="5%">Total Time Allocated</th>
                                        <th width="5%">Total Time Spended</th>
                                        <th width="5%">Time Zone</th>
                                        <th width="5%">App And Os</th>
                                        <th width="5%">Insert Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($dateWise) { $sl=1; foreach($dateWise as $res){?>
                                        <tr>
                                            <td><?=$sl++?></td>
                                            <td><?=$res->desklog_usrid?></td>
                                            <td><?=$res->tracker_user_id?></td>
                                            <td><?=$res->email?></td>
                                            <td><?=$res->arrival_at?></td>
                                            <td><?=$res->left_at?></td>
                                            <td><?=$res->time_at_work?></td>
                                            <td><?=$res->productive_time?></td>
                                            <td><?=$res->idle_time?></td>
                                            <td><?=$res->private_time?></td>
                                            <td><?=$res->total_time_allocated?></td>
                                            <td><?=$res->total_time_spended?></td>
                                            <td><?=$res->time_zone?></td>
                                            <td><?=$res->app_and_os?></td>
                                            <td><?=$res->insert_date?></td>                                           
                                        </tr>                                        
                                    <?php } }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                
            <?php }?>
            <?php }?>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
