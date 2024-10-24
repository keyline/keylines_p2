<?php
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
</style>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<?php if(checkModuleFunctionAccess(20,36)){ ?>
<section class="section">
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
        <div class="col-lg-12">
            <div class="card table-card">
                <!-- <div class="card-header">
                <?php //if(checkModuleFunctionAccess(20,37)){ ?>
                    <h5>
                        <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>
                    </h5>
                    <?php //} ?>
                </div> -->
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table padding-y-10 general_table_style" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Work Date</th>
                                    <th>Time</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Entry Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($rows){ $sl=1; foreach($rows as $row){?>
                                <?php
                                $getProject     = $common_model->find_data('project', 'row', ['id' => $row->project_id], 'name');
                                $getEffortType  = $common_model->find_data('effort_type', 'row', ['id' => $row->effort_type], 'name');
                                ?>
                                <tr>
                                    <th scope="row"><?=$sl++?></th>
                                    <td>
                                        <?=(($getProject)?$getProject->name:'')?>
                                        <p>
                                            <?php if($row->bill == 0){?>
                                                <span class="badge bg-success">Billable</span>
                                            <?php } else {?>
                                                <span class="badge bg-danger">Non-Billable</span>
                                            <?php }?>
                                        </p>
                                    </td>
                                    <td>
                                        <?=date_format(date_create($row->date_added), "d-m-Y")?>
                                        <!-- <p>
                                            <?php if($row->work_home == 1){?>
                                                <span class="text-primary"><i class="fa fa-home"></i></span>
                                            <?php }?>
                                        </p> -->
                                        <?php
                                        $date1              = date_create($row->date_today);
                                        $date2              = date_create($row->date_added);
                                        $diff               = date_diff($date1,$date2);
                                        $date_difference    = $diff->format("%R%a");
                                        if($date_difference < 0){
                                        ?>
                                        <span class="text-danger">(<?=$date_difference?>)</span>
                                        <?php }?>
                                    </td>
                                    <td><?=$row->hour?>:<?=$row->min?></td>
                                    <td>
                                        <?=wordwrap($row->description,55,"<br>\n")?><br>
                                        <?php if($row->assign_description != ''){?>
                                            <strong>Assigned : <?=wordwrap($row->assign_description,55,"<br>\n")?> (<?=$row->assign_hour?>:<?=$row->assign_min?>)</strong>
                                        <?php }?>
                                    </td>
                                    <td><?=(($getEffortType)?$getEffortType->name:'')?></td>
                                    <td><?=date_format(date_create($row->date_today), "d-m-Y h:i:s A")?></td>
                                    <td>
                                        <?php if(checkModuleFunctionAccess(20,38)){ ?>
                                        <a class="btn btn-outline-primary btn-sm me-1" target="_blank" href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->id))?>" title="Edit Effort" onclick="return confirm('Do you want to edit this effort ?');"><i class="fa fa-edit"></i></a>
                                        <?php } ?>
                                        <?php
                                        // $userType           = $session->user_type;
                                        // if($userType == 'ADMIN'){
                                        ?>
                                            <?php if(checkModuleFunctionAccess(20,39)){ ?>
                                            <a class="btn btn-outline-danger btn-sm me-1" href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->id))?>" title="Delete Effort" onclick="return confirm('Do you want to delete this effort from list ?');"><i class="fa fa-trash"></i></a>
                                            <?//php } ?>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php } }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>