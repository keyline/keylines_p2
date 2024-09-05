<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<style type="text/css">
    table.table-fit {
      width: auto !important;
      table-layout: auto !important;
    }
    table.table-fit thead th,
    table.table-fit tbody td,
    table.table-fit tfoot th,
    table.table-fit tfoot td {
      width: auto !important;
      font-size: 15px;
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
<?php if(checkModuleFunctionAccess(5,28)){ ?>
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
                <div class="card-header">
                    <?php if(checkModuleFunctionAccess(5,29)){ ?>
                        <div style="display: inline-flex;gap: 10px;">
                        <h5>
                            <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-primary btn-sm">Add <?=$title?></a>
                        </h5>
                        <h5>
                            <a href="<?=base_url('admin/' . $controller_route . '/list/')?>" class="btn btn-outline-info btn-sm">All Projects</a>
                        </h5>
                        <h5>
                            <a href="<?=base_url('admin/' . $controller_route . '/active-project/')?>" class="btn btn-outline-success btn-sm">Active Projects</a>
                        </h5>
                        <h5>
                            <a href="<?=base_url('admin/' . $controller_route . '/inactive-project/')?>" class="btn btn-outline-danger btn-sm">Inactive Project</a>
                        </h5>
                        </div>
                    <?php   } ?>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table general_table_style">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Project Name</th>                                    
                                    <th scope="col">Assigned By<br>Client Service</th>                                    
                                    <th scope="col">Total Hour</th>
                                    <!-- <th scope="col">Monthly Hour</th> -->
                                    <!-- <th scope="col">Contact</th> -->
                                    <!-- <th scope="col">Start<br>Deadline</th> -->
                                    <!-- <th scope="col">Parent</th> -->
                                    <!-- <th scope="col">URL</th> -->
                                    <!-- <th scope="col"></th> -->
                                    <!-- <th scope="col">Created<br>Updated</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($rows){ $sl=1; foreach($rows as $row){?>
                                    <?php
                                    $getClientService           = $common_model->find_data('user', 'row', ['id' => $row->client_service], 'name');
                                    $assigned                   = 0;
                                    $current_month_booking      = 0;
                                    $total_booked               = 0;
                                    $projectId                  = $row->id;
                                    $getProject                 = $common_model->find_data('project', 'row', ['id' => $projectId]);
                                    if($getProject){
                                        if($getProject->project_time_type == 'Onetime'){
                                            $assigned               = $getProject->hour;
                                            $current_month_booking  = $common_model->getProjectBooking2($projectId, 'Monthlytime');
                                            $total_booked           = $common_model->getProjectBooking2($projectId, 'Onetime');
                                        } elseif($getProject->project_time_type == 'Monthlytime'){
                                            $assigned               = $getProject->hour_month;
                                            $current_month_booking  = $common_model->getProjectBooking2($projectId, 'Monthlytime');
                                            $total_booked           = $common_model->getProjectBooking2($projectId, 'Onetime');
                                        }
                                        $apiResponse        = [
                                            'project_time_type'                     => $getProject->project_time_type,
                                            'assigned'                              => $assigned,
                                            'current_month_booking'                 => $current_month_booking,
                                            'total_booked'                          => $total_booked,
                                        ];
                                    }
                                    ?>
                                    <tr>
                                        <th scope="row"><?=$sl++?></th>
                                        <td>
                                            <span class="badge bg-warning text-dark me-1">Id: <?=$row->$primary_key?></span><b><?=$row->name?></b><a target="_blank" href="<?=base_url('admin/projects/reports/'. base64_encode($row->id));?>"><i class="fa fa-file" style="margin-left: 5px;"></i></a><br>
                                            <span class="badge bg-primary  me-1 my-1"><?=$row->project_status_name?></span>
                                            <span class="badge bg-success  me-1 my-1"><?=(($row->start_date != '')?date_format(date_create($row->start_date), "M d, Y"):'')?></span><br>
                                            Deadline: <?=(($row->deadline != '')?date_format(date_create($row->deadline), "M d, Y"):'')?> /
                                            Last Update: <?=(($row->date_modified != '')?date_format(date_create($row->date_modified), "M d, Y h:i A"):'')?>
                                            <i class="fa fa-user" style="margin-left: 5px;"></i><b><?=$pro->decrypt($row->client_name)?></b> <br>
                                            
                                            <!-- ?=(($row->deadline != '')?date_format(date_create($row->deadline), "M d, Y"):'')?> -->
                                        </td>                                    
                                        <td><?=$row->assigned_name?><br><?=(($getClientService)?$getClientService->name:'')?></td>                                        
                                        <td>
                                            <?php if($getProject){ if($getProject->project_time_type == 'Onetime'){?>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-primary">Fixed : <?=$assigned?> hrs</span></a>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-success">Booked(Monthly) : <?=$current_month_booking?></span></a>

                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-warning text-dark">Total : <?=$total_booked?></span></a>
                                            <?php } elseif($getProject->project_time_type == 'Monthlytime'){?>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-warning text-dark">Monthly : <?=$assigned?> hrs</span></a>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-success">Booked : <?=$current_month_booking?></span></a><br>
                                                <!-- <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-warning text-dark">Total : <?=$total_booked?></span></a> -->
                                            <?php } }?>
                                        </td>
                                        <!-- <td>
                                            <?php if($getProject){  }?>
                                        </td> -->
                                        <!-- <td>?=$pro->decrypt($row->client_name)?></td>                                         -->
                                        <!-- <td></td> -->
                                        <!-- <td>
                                            <?php if($row->temporary_url != ''){?><small>Temp : <a href="<?=$row->temporary_url?>" target="_blank"><?=$row->temporary_url?></a></small><br><?php }?>
                                            <?php if($row->permanent_url != ''){?><small>Per : <a href="<?=$row->permanent_url?>" target="_blank"><?=$row->permanent_url?></a></small><?php }?>
                                        </td> -->
                                        <!-- <td></td> -->
                                        <!-- <td>
                                            ?=(($row->date_added != '')?date_format(date_create($row->date_added), "M d, Y h:i A"):'')?>
                                            <br><hr>
                                            
                                        </td> -->
                                        <td>
                                            <?php if(checkModuleFunctionAccess(5,30)){ ?>
                                            <a href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$title?>"><i class="fa fa-edit"></i></a>
                                            <?php  } ?>
                                            <?php if(checkModuleFunctionAccess(5,57)){ ?>
                                            <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
                                            <?php if($row->active == 0){?>
                                                <?php if(checkModuleFunctionAccess(5,31)){ ?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i></a>
                                                <?php } ?>
                                            <?php } else {?>
                                                <?php if(checkModuleFunctionAccess(5,32)){ ?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i></a>
                                                <?php   } ?>
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
<?PHP } ?>