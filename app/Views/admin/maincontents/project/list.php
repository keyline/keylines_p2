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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>
                    </h5>
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-bordered table-fit general_table_style">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Assigned<br>By</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Total Hour</th>
                                    <th scope="col">Monthly Hour</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Start<br>Deadline</th>
                                    <!-- <th scope="col">Parent</th> -->
                                    <th scope="col">URL</th>
                                    <th scope="col">Contact Service</th>
                                    <th scope="col">Created<br>Updated</th>
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
                                        <td><a target="_blank" href="<?=base_url('admin/projects/reports/'. base64_encode($row->id));?>"><?=$row->name?></a></td>
                                        <td><?=$row->client_name?></td>
                                        <td><?=$row->assigned_name?></td>
                                        <td><?=$row->project_status_name?></td>
                                        <td>
                                            <?php if($getProject){ if($getProject->project_time_type == 'Onetime'){?>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-primary">Assigned : <?=$assigned?> hrs</span></a><br>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-success">Booked(Monthly) : <?=$current_month_booking?></span></a><br>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-warning text-dark">Total : <?=$total_booked?></span></a>
                                            <?php } }?>
                                        </td>
                                        <td>
                                            <?php if($getProject){ if($getProject->project_time_type == 'Monthlytime'){?>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-primary">Assigned : <?=$assigned?> hrs</span></a><br>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-success">Booked : <?=$current_month_booking?></span></a><br>
                                                <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-warning text-dark">Total : <?=$total_booked?></span></a>
                                            <?php } }?>
                                        </td>
                                        <td><?=$row->client_name?></td>
                                        <td><?=(($row->start_date != '')?date_format(date_create($row->start_date), "M d, Y"):'')?><br><?=(($row->deadline != '')?date_format(date_create($row->deadline), "M d, Y"):'')?></td>
                                        <!-- <td></td> -->
                                        <td>
                                            <?php if($row->temporary_url != ''){?><small>Temp : <a href="<?=$row->temporary_url?>" target="_blank"><?=$row->temporary_url?></a></small><br><?php }?>
                                            <?php if($row->permanent_url != ''){?><small>Per : <a href="<?=$row->permanent_url?>" target="_blank"><?=$row->permanent_url?></a></small><?php }?>
                                        </td>
                                        <td><?=(($getClientService)?$getClientService->name:'')?></td>
                                        <td>
                                            <?=(($row->date_added != '')?date_format(date_create($row->date_added), "M d, Y h:i A"):'')?>
                                            <h6 style=" border-top: 1px solid #444444; width: auto; display: inline-block;">
                                            <?=(($row->date_modified != '')?date_format(date_create($row->date_modified), "M d, Y h:i A"):'')?></h6>
                                        </td>
                                        <td>
                                            <a href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$title?>"><i class="fa fa-edit"></i></a><br>
                                            <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm my-1" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a><br>
                                            <?php if($row->active == 0){?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i></a>
                                            <?php } else {?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i></a>
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