<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$userType           = $session->user_type;
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
<div class="container-fluid">
    <div class="row">
        <div class="pagetitle">
            <h1><?=$page_header?></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
                    <li class="breadcrumb-item active"><?=$page_header?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<?php if(checkModuleFunctionAccess(5,28)){ ?>
<div class="container-fluid">
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
                    <?php if(checkModuleFunctionAccess(5,29)){ ?>
                        <div class="card-header">
                        
                            <div style="display: inline-flex;gap: 10px;">
                            <h5>
                                <!-- <a href="</?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-primary btn-sm">Add </?=$title?></a> -->
                                <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="<?php echo (empty($projectStats)  || empty($clients)) ? 'btn btn-secondary btn-sm disabled' : 'btn btn-outline-primary btn-sm'  ?>">Add <?=$title?></a>
                            </h5>
                            <h5>
                                <!-- <a href="</?=base_url('admin/' . $controller_route . '/list/')?>" class="btn btn-outline-info btn-sm">All Projects</a> -->
                                <a href="<?=base_url('admin/' . $controller_route . '/list/')?>" class="<?php echo empty($rows)? 'btn btn-secondary btn-sm disabled' : 'btn btn-outline-primary btn-sm'  ?>">All Projects</a>
                            </h5>
                            <h5>
                                <!-- <a href="</?=base_url('admin/' . $controller_route . '/active-project/')?>" class="btn btn-outline-success btn-sm">Active Projects</a> -->
                                <a href="<?=base_url('admin/' . $controller_route . '/active-project/')?>" class="<?php echo empty($rows)? 'btn btn-secondary btn-sm disabled' : 'btn btn-outline-primary btn-sm'  ?>">Active Projects</a>
                            </h5>
                            <h5>
                                <!-- <a href="</?=base_url('admin/' . $controller_route . '/inactive-project/')?>" class="btn btn-outline-danger btn-sm">Inactive Project</a> -->
                                <a href="<?=base_url('admin/' . $controller_route . '/inactive-project/')?>" class="<?php echo empty($rows)? 'btn btn-secondary btn-sm disabled' : 'btn btn-outline-primary btn-sm'  ?>">Inactive Project</a>
                            </h5>
                            </div>                        
                        </div>
                    <?php   } ?>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <?php if(!empty($rows)){ ?>
                            <table id="simpletable" class="table general_table_style padding-y-10">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Project Name</th>                                    
                                        <th scope="col">Assigned By<br>Client Service</th>   
                                        <?php if (checkModuleFunctionAccess(5, 90)) { ?>                                 
                                        <th scope="col">Total Hour</th>
                                        <?php }?>
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
                                                <span class="badge bg-warning text-dark me-1">Id: <?=$row->$primary_key?></span><b><?=$row->name?></b>
                                                <?php if($userType == 'SUPER ADMIN') { ?>
                                                <a target="_blank" href="<?=base_url('admin/projects/reports/'. base64_encode($row->id));?>"><i class="fa fa-file" style="margin-left: 5px;"></i></a>
                                                <?php } ?>
                                                <br>
                                                <span class="badge bg-primary me-1 my-1"><?=$row->project_status_name?></span>
                                                <span class="badge bg-success me-1 my-1"><?=(($row->start_date != '')?date_format(date_create($row->start_date), "M d, Y"):'')?></span><br>
                                                Deadline: <?=(($row->deadline != '')?date_format(date_create($row->deadline), "M d, Y"):'')?> /
                                                Last Update: <?=(($row->date_modified != '')?date_format(date_create($row->date_modified), "M d, Y h:i A"):'')?>
                                                <i class="fa fa-user" style="margin-left: 5px;"></i><b><?=$pro->decrypt($row->client_name)?></b> <br>
                                                
                                                <!-- ?=(($row->deadline != '')?date_format(date_create($row->deadline), "M d, Y"):'')?> -->
                                            </td>                                    
                                            <td><?=$row->assigned_name?><br><?=(($getClientService)?$getClientService->name:'')?></td>  
                                            <?php if (checkModuleFunctionAccess(5, 90)) { ?>                                      
                                            <td>
                                                <?php if($getProject){ ?>
                                                    <button class="btn btn-primary btn-sm" onclick="toggleDetails(this)">Load More</button>
                                                    <div class="project-details mt-2" style="display: none;">
                                                        <?php if($getProject->project_time_type == 'Onetime'){?>
                                                            <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-primary mb-1">Fixed : <?=$assigned?> hrs</span></a>
                                                            <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-success mb-1">Booked(Monthly) : <?=$current_month_booking?></span></a>
                                                            <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-warning text-dark mb-1">Total : <?=$total_booked?></span></a>
                                                        <?php } elseif($getProject->project_time_type == 'Monthlytime'){?>
                                                            <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-warning text-dark mb-1">Monthly : <?=$assigned?> hrs</span></a>
                                                            <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-success mb-1">Booked : <?=$current_month_booking?></span></a>
                                                        <!-- <a href="<?=base_url('admin/projects/project-effort-list/'.encoded($row->$primary_key))?>" target="_blank"><span class="badge bg-warning text-dark">Total : <?=$total_booked?></span></a> -->
                                                        <?php } ?>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <?php }?>
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
                                                    <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a><br><br>
                                                <?php } ?>
                                                <?php if($row->active == 0){?>
                                                    <?php if(checkModuleFunctionAccess(5,31)){ ?>
                                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i></a>
                                                    <?php } ?>
                                                <?php } else {?>
                                                    <?php if(checkModuleFunctionAccess(5,32)){ ?>
                                                    <a href="#activemodal<?=encoded($row->$primary_key)?>" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#activemodal<?=$row->$primary_key?>" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i></a>
                                                    <!-- Modal -->
                                                        <div class="modal fade team-assin-modal" id="activemodal<?=$row->id?>" tabindex="-1" aria-labelledby="activemodalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Active project status</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                                                            
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="exampleForm" method="post" class="general_form_style">
                                                                            <input type ="hidden" name="project_id" value ="<?=$row->$primary_key?>">
                                                                            <div class="container-fluid">
                                                                                <div class="row">
                                                                                    <div class="col-md-6 col-lg-4">
                                                                                        <div class="general_form_left_box">
                                                                                            <label for="name" class="col-form-label">Project status <span class="text-danger">*</span></label>
                                                                                        </div>  
                                                                                    </div>
                                                                                    <div class="col-md-6 col-lg-8">
                                                                                        <div class="general_form_right_box">                                                                                        
                                                                                            <select name="status" class="form-control" id="status" required>
                                                                                                <option value="" selected>Select</option>
                                                                                                <hr>
                                                                                                <?php if($projectStats){ foreach($projectStats as $projectStat){?>
                                                                                                    <option value="<?=$projectStat->id?>"><?=$projectStat->name?></option>
                                                                                                    <hr>
                                                                                                <?php } }?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">                                                                                
                                                                                    <div class="col-md-6 col-lg-12">
                                                                                        <div class="">                                                                                        
                                                                                            <button type="submit" class="btn btn-primary btn-sm font-12 mt-1 d-block mx-auto">Submit</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php   } ?>
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php } }?>
                                </tbody>
                            </table>
                            <?php }else{ ?>
                                <div class="text-center">
                                    <p class="mt-2">No projects found.</p>
                            <?php } ?>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?PHP } ?>
<script>
function toggleDetails(button) {
    let detailsDiv = button.nextElementSibling;

    if (detailsDiv.style.display === "none") {
        detailsDiv.style.display = "block";
        button.textContent = "Show Less";
    } else {
        detailsDiv.style.display = "none";
        button.textContent = "Load More";
    }
}
</script>