<?php
   //die("dashboard");
   $userType    = $session->user_type;
   $user_id     = $session->user_id;
   ?>
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="pagetitle">
               <h1>Dashboard</h1>
               <nav>
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                     <li class="breadcrumb-item active">Dashboard</li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
   </div>
   <style>
   .modal-dialog.wide-modal {
   max-width: 80%;
   }
</style>
<!-- End Page Title -->
<section class="section dashboard">
   <div class="container-fluid">
      <div class="row">
         <!-- Left side columns -->
         <div class="col-lg-12">
            <div class="row">
               <div class="col-xxl-12 col-md-12">
                  <h4 style="font-weight: bold;">Welcome To <?= $general_settings->site_name ?></h4>
               </div>
               <!-- Recent Sales -->
               <div class="col-12">
                  <div class="card recent-sales overflow-auto m-0">
                  </div>
               </div>
               <!-- End Recent Sales -->
            </div>
            <?php if ($userType != 'CLIENT') { ?>
            <div class="row mt-3">
               <?php if (checkModuleFunctionAccess(1, 75)) { ?>
               <!-- Companies Card -->
               <!-- <div class="col-xxl-4 col-md-6">
                  <div class="card info-card sales-card">
                     <div class="card-body">
                        <h5 class="card-title">Total Users <span>| All Time</span></h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-people"></i>
                           </div>
                           <div class="ps-2">
                              <h6>?= $total_users ?></h6>
                           </div>
                        </div>
                     </div>
                  </div>
               </div> -->
               <!-- End Companies Card -->
               <!-- Plants Card -->
               <div class="col-xxl-4 col-md-6">
                  <div class="card info-card revenue-card">
                     <div class="card-body">
                        <h5 class="card-title">Total Employees</h5>
                        <!-- <h5 class="card-title">Total Active Users <span>| All Time</span></h5> -->
                        <div class="d-flex align-items-center gap-1">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-people"></i>
                           </div>
                           <div class="ps-2">
                              <h6><?= $total_active_users ?></h6>
                           </div>
                           <?php if($userType == "SUPER ADMIN" || $userType == "ADMIN") {?>
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                 <i class="bi bi-person-fill-check"></i>
                              </div>
                              <div class="ps-2">
                                 <h6><?=$total_present_user->user_count?></h6>
                              </div>
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                 <i class="bi bi-person-x"></i>
                              </div>
                              <div class="ps-2">
                                 <h6><?php $absent = $total_app_user->user_count - $total_present_user->user_count; echo $absent;?></h6>
                              </div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- End Plants Card -->
               <!-- Vendors Card -->
               <!-- <div class="col-xxl-4 col-xl-12">
                  <div class="card info-card customers-card">
                     <div class="card-body">
                        <h5 class="card-title">Total Inactive Users <span>| All Time</span></h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-people"></i>
                           </div>
                           <div class="ps-2">
                              <h6>?= $total_inactive_users ?></h6>
                           </div>
                        </div>
                     </div>
                  </div>
               </div> -->
               <!-- End Vendors Card -->
               <!-- Companies Card -->
               <div class="col-xxl-4 col-md-6">
                  <div class="card info-card customers-card2">
                     <div class="card-body">
                        <!-- <h5 class="card-title">Project (Prospect/Active/Lost) <span>| All Time</span></h5> -->
                        <h5 class="card-title">Active Projects (Billable/Non-Billable)</h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-people"></i>
                           </div>
                           <div class="ps-2">
                              <h6><?= $total_active_projects ?><small>(<?= $total_bill_projects ?>/<?= $total_nonbill_projects ?>)</small></h6>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- End Companies Card -->
               <!-- Plants Card -->
               <div class="col-xxl-4 col-md-6">
                  <div class="card info-card customers-card3">
                     <div class="card-body">
                        <h5 class="card-title">Clients</h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-people"></i>
                           </div>
                           <div class="ps-2">
                              <h6><?= $total_clients ?></h6>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- End Plants Card -->
               <!-- Vendors Card -->
               <!-- <div class="col-xxl-4 col-xl-12">
                  <div class="card info-card customers-card4">
                     <div class="card-body">
                        <h5 class="card-title">Billable/Non-Billable <span>| All Time</span></h5>
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-people"></i>
                           </div>
                           <div class="ps-2">
                              <h6><?= $total_bill_projects ?>/<?= $total_nonbill_projects ?></h6>
                           </div>
                        </div>
                     </div>
                  </div>
               </div> -->
               <!-- End Vendors Card -->
               <?php   } ?>
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
               <?php if (checkModuleFunctionAccess(1, 105)) { ?>
               <div class="col-md-12">
                  <div class="card table-card shadow-sm">
                     <div class="card-header">
                        <div class="row align-items-center">
                           <div class="col-lg-5 col-md-6">
                              <div class="card-header-left"> 
                                 <ul class="d-flex align-items-center">
                                    <li class="me-3"><h6 class="fw-bold heading_style">Task Management</h6></li>                                    
                                 </ul>                                                                                                      
                              </div>
                           </div> 
                           <div class="col-lg-7 col-md-6">
                              <div class="card-header-right"> 
                                 <ul class="d-flex justify-content-end gap-2 flex-wrap lagend-list ms-auto">
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addAttendanceModal"><i class="fa fa-plus"></i> Add Task</button>                                    
                                 </ul>
                              </div>
                           </div>                           
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <?php
                              $application_settings    = $common_model->find_data('application_settings', 'row');
                              $edit_time_after_task_add = $application_settings->edit_time_after_task_add;
                              foreach ($employees as $emp):
                                 if($userType == 'SUPER ADMIN'){
                                    $alterIcon  = 1;
                                    if($user_id == $emp->id){
                                          $effortIcon = 1;
                                    } else {
                                          $effortIcon = 0;
                                    }
                                 } elseif($userType == 'ADMIN'){
                                    $alterIcon  = 1;
                                    if($user_id == $emp->id){
                                          $effortIcon = 1;
                                    } else {
                                          $effortIcon = 0;
                                    }
                                 } elseif($userType == 'USER'){
                                    if($user_id == $emp->id){
                                          $alterIcon  = 1;
                                          $effortIcon = 1;
                                    } else {
                                          $alterIcon  = 0;
                                          $effortIcon = 0;
                                    }
                                 } else {
                                    $alterIcon  = 0;
                                    $effortIcon = 0;
                                 }
                              endforeach;
                              function formatMinutesToHourMin($totalMin) {
                                 $hr = intdiv($totalMin, 60);
                                 $min = $totalMin % 60;
                                 return "{$hr} hr {$min} min";
                              }                              
                              ?>
                           <div class="col-xxl-4 col-md-4 table-responsive"> 
                              <div style="background-color: #799cb0;padding: 8px;text-align: center;font-weight: 700;border-radius: 8px;color: white; margin-bottom: 10px; font-size: 14px;"> 
                                 <h6>Yesterday Task</h6> 
                                 <?php 
                                    $total_time = formatMinutesToHourMin($yesterday_total_time);
                                    $total_book_time = formatMinutesToHourMin($yesterday_total_book_time);
                                 ?>                           
                                 <p><span>Assigned: <?=$total_time?></span>    <span>Booked: <?=$total_book_time?></span></p>
                              </div>
                              <div class="row">
                                 <?php  foreach($yesterday_task_details as $task){  
                                    $task_background = $task['background_color'] ?? '';                                                                    
                                 ?>  
                                 <div class="col-md-12">
                                    <div class="card table-card card table-card shadow-sm">
                                       <div class="card-header task" style="background-color: <?= $task_background ?>;">
                                          <div class="row">
                                             <div class="col-md-8">
                                                <div>                                  
                                                   <h6 class="mb-2" style="font-size: 12px;"><b><i class="fa fa-building" aria-hidden="true"></i> <?= $task['project_name']?></b></h6>
                                                   <?php if($task['work_status_id'] != 0) { ?>
                                                   <p style="font-size: 10px;"><b>Status:</b> <?= $task['work_status_name']?></p>
                                                   <?php } ?>
                                                   <p style="font-size: 10px;"><b>Assigned:</b> (<?= $task['hour']?> hr <?= $task['min']?> min)</p>
                                                   <p style="font-size: 10px;"><?=$task['description']?></p>
                                                   <?php if($task['work_status_id'] != 0) { ?>
                                                   <p style="font-size: 10px;"><b>Booked:</b> (<?= $task['booked_hour']?> hr <?= $task['booked_min']?> min)</p>
                                                   <?php if($task['description'] != $task['booked_description']) { ?>
                                                      <p style="font-size: 10px;"><?=$task['booked_description']?></p>
                                                   <?php } }?>

                                                   <p class="card-details text-muted" style="font-size: 9px;">
                                                      <i class="fa fa-clock" aria-hidden="true"></i> <?= $task['created_at']?> 
                                                      <span class="ms-3"><i class="fa fa-user" aria-hidden="true"></i> <?= $task['user_name']?></span>
                                                      <span class="ms-3"><i class="fa fa-flag" aria-hidden="true"></i> <?php if($task['priority'] == 1){ echo 'Low';} else if($task['priority'] == 2) {echo 'Medium';} else if($task['priority'] == 3) {echo 'High';} ?></span>
                                                   </p>                                                                                                                                                                                            
                                                </div>
                                             </div>  
                                             <?php if($task['work_status_id'] == 0) { ?>
                                             <div class="col-md-4 text-right">
                                                <button style="font-size: 10px;" type="button" onclick="taskWiseList('<?= $task['task_id'] ?>')" class="btn btn-success mb-3 add-effort-btn btn-sm" data-bs-toggle="modal" data-bs-target="#addEffortModal" data-task-id="<?= $task['task_id'] ?>">
                                                   <i class="fa fa-plus"></i> Add Effort
                                                </button>                                                                                     
                                             </div> 
                                             <?php } ?>                       
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                  <?php } ?>                                                                   
                              </div>                                                                                         
                           </div>
                           <div class="col-xxl-4 col-md-4 table-responsive"> 
                              <div style="background-color: #799cb0;padding: 8px;text-align: center;font-weight: 700;border-radius: 8px;color: white;margin-bottom: 10px;font-size: 14px;">
                                 <h6>Today Task</h6>       
                                 <?php 
                                    $total_time = formatMinutesToHourMin($user_total_time);
                                    $total_book_time = formatMinutesToHourMin($user_total_book_time);
                                 ?>                      
                                 <p><span>Assigned: <?=$total_time?></span>    <span>Booked: <?=$total_book_time?></span></p>
                              </div>
                              <div class="row">                                 
                                  <?php foreach($user_task_details as $task){ 
                                    // pr($task);
                                    $task_background = $task['background_color'] ?? '';                                                                         
                                 ?> 
                                 <div class="col-md-12">
                                    <div class="card table-card card table-card shadow-sm">
                                       <div class="card-header task" style="background-color: <?= $task_background ?>;">
                                          <div class="row">
                                             <div class="col-md-8">
                                                <div>                                                                                                                                                                                                       
                                                   <h6 class="mb-2" style="font-size: 12px;"><b><i class="fa fa-building" aria-hidden="true"></i> <?= $task['project_name']?></b></h6>
                                                   <?php if($task['work_status_id'] != 0) { ?>
                                                   <p style="font-size: 10px;"><b>Status:</b> <?= $task['work_status_name']?></p>
                                                   <?php } ?>
                                                   <p style="font-size: 10px;"><b>Assigned:</b> (<?= $task['hour']?> hr <?= $task['min']?> min)</p>
                                                   <p style="font-size: 10px;"><?=$task['description']?></p>
                                                   <?php if($task['work_status_id'] != 0) { ?>
                                                   <p style="font-size: 10px;"><b>Booked:</b> (<?= $task['booked_hour']?> hr <?= $task['booked_min']?> min)</p>
                                                   <?php if($task['description'] != $task['booked_description']) { ?>
                                                      <p style="font-size: 10px;"><?=$task['booked_description']?></p>
                                                   <?php } } ?>
                                                   <p class="card-details text-muted" style="font-size: 9px;">
                                                      <i class="fa fa-clock" aria-hidden="true"></i> <?= $task['created_at']?> 
                                                      <span class="ms-3"><i class="fa fa-user" aria-hidden="true"></i> <?= $task['user_name']?></span>
                                                      <span class="ms-3"><i class="fa fa-flag" aria-hidden="true"></i> <?php if($task['priority'] == 1){ echo 'Low';} else if($task['priority'] == 2) {echo 'Medium';} else if($task['priority'] == 3) {echo 'High';} ?></span>
                                                   </p>                                                                                                                                                                                            
                                                </div>
                                             </div>  
                                             <?php if($task['work_status_id'] == 0) { 
                                                $time1 = DateTime::createFromFormat('M d, Y h:i a', $task['created_at']); 
    
                                                // Current datetime as DateTime object
                                                $time2 = new DateTime();
                                                // Get the difference
                                                $interval = $time1->diff($time2);
                                                // pr($interval);
                                                // Convert the difference to total minutes
                                                $minutes = ($interval->h * 60) + $interval->i;        
                                                // pr($minutes);                                        
                                                ?>
                                             <div class="col-md-4 text-right">
                                                <button style="font-size: 10px;" type="button" onclick="taskWiseList('<?= $task['task_id'] ?>')" class="btn btn-success mb-3 add-effort-btn btn-sm" data-bs-toggle="modal" data-bs-target="#addEffortModal" data-task-id="<?= $task['task_id'] ?>">
                                                   <i class="fa fa-plus"></i> Add Effort
                                                </button> <br>
                                                <?php if($minutes <= $edit_time_after_task_add){
                                                   if($task['added_by'] == $user_id){ ?>
                                                <button style="font-size: 10px;" type="button" onclick="taskEditList('<?= $task['task_id'] ?>')" class="btn btn-success mb-3 add-effort-btn btn-sm" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-task-id="<?= $task['task_id'] ?>">
                                                   <i class="fa fa-pencil-square"></i>
                                                </button>  
                                                <?php } }?>                                                                                                        
                                             </div> 
                                             <?php } ?>                       
                                          </div>
                                       </div>
                                    </div>
                                 </div>                                  
                                 <?php } ?>                                 
                              </div>                                                                                         
                           </div>
                           <div class="col-xxl-4 col-md-4 table-responsive">    
                              <div style="background-color: #799cb0;padding: 8px;text-align: center;font-weight: 700;border-radius: 8px;color: white;margin-bottom: 10px;font-size: 14px;">
                                 <h6>Upcoming Task</h6>  
                                 <?php 
                                    $total_time = formatMinutesToHourMin($upcoming_total_time);
                                    $total_book_time = formatMinutesToHourMin($upcoming_total_book_time);
                                 ?>                        
                                 <p><span>Assigned: <?=$total_time?></span>    <span>Booked: <?=$total_book_time?></span></p>
                              </div>
                              <div class="row">                                                                                                   
                                 <?php foreach($upcoming_task_details as $task){ 
                                    $task_background = $task['background_color'] ?? '';                                       
                                 ?> 
                                 <div class="col-md-12">
                                    <div class="card table-card card table-card shadow-sm">
                                       <div class="card-header task" style="background-color: <?= $task_background ?>;">
                                          <div class="row">
                                             <div class="col-md-8">
                                                <div>                                                                                                                                                                                                       
                                                   <h6 class="mb-2" style="font-size: 12px;"><b><i class="fa fa-building" aria-hidden="true"></i> <?= $task['project_name']?></b></h6>
                                                   <?php if($task['work_status_id'] != 0) { ?>
                                                   <p style="font-size: 10px;"><b>Status:</b> <?= $task['work_status_name']?></p>
                                                   <?php } ?>
                                                   <p style="font-size: 10px;"><b>Assigned:</b> (<?= $task['hour']?> hr <?= $task['min']?> min) for <?= date_format(date_create($task['date_added']), "M d, Y") ?></p>                                                   
                                                   <p style="font-size: 10px;"><?=$task['description']?></p>
                                                   <?php if($task['work_status_id'] != 0) { ?>
                                                   <p style="font-size: 10px;"><b>Booked:</b> (<?= $task['booked_hour']?> hr <?= $task['booked_min']?> min)</p>
                                                   <?php if($task['description'] != $task['booked_description']) { ?>
                                                      <p style="font-size: 10px;"><?=$task['booked_description']?></p>
                                                   <?php } } ?>
                                                   <p class="card-details text-muted" style="font-size: 9px;">
                                                      <i class="fa fa-clock" aria-hidden="true"></i> <?= $task['created_at']?> 
                                                      <span class="ms-3"><i class="fa fa-user" aria-hidden="true"></i> <?= $task['user_name']?></span>
                                                      <span class="ms-3"><i class="fa fa-flag" aria-hidden="true"></i> <?php if($task['priority'] == 1){ echo 'Low';} else if($task['priority'] == 2) {echo 'Medium';} else if($task['priority'] == 3) {echo 'High';} ?></span>
                                                   </p>                                                                                                                                                                                            
                                                </div>
                                             </div>  
                                             <?php if($task['work_status_id'] == 0) { 
                                                $time1 = DateTime::createFromFormat('M d, Y h:i a', $task['created_at']); 
    
                                                // Current datetime as DateTime object
                                                $time2 = new DateTime();
                                                // Get the difference
                                                $interval = $time1->diff($time2);                                                
                                                // Convert the difference to total minutes
                                                $minutes = ($interval->h * 60) + $interval->i;        
                                                       ?>
                                                       <?php if($minutes <= $edit_time_after_task_add){
                                                   if($task['added_by'] == $user_id){ ?>
                                             <div class="col-md-4 text-right">
                                                <button style="font-size: 10px;" type="button" onclick="taskEditList('<?= $task['task_id'] ?>')" class="btn btn-success mb-3 add-effort-btn btn-sm" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-task-id="<?= $task['task_id'] ?>">
                                                   <i class="fa fa-pencil-square"></i>
                                                </button>                                                                                     
                                             </div> 
                                             <?php } } }?>                       
                                          </div>
                                       </div>
                                    </div>
                                 </div>                                  
                                 <?php } ?>
                              </div>                                                                                         
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php   } ?>                                 
                        
               <div class="col-md-12">
                  <?php if (checkModuleFunctionAccess(1, 66)) { ?>
                  <div class="card table-card">
                     <div class="card-header">
                        <div class="row align-items-center">
                           <div class="col-lg-5 col-md-6">
                              <div class="card-header-left">
                                 <ul class="d-flex align-items-center">
                                    <li class="me-3"><h6 class="fw-bold heading_style">Monthly Effort Report <span id="year"><?= date('Y') ?></span></h6></li>
                                    <li>
                                       <p>January to December</p>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-6">
                              <div class="card-header-right">
                                 <ul class="d-flex justify-content-end gap-2 flex-wrap lagend-list ms-auto">
                                    <li><span class="dots dots-bg-dark-success"></span>Reach Max. Time - <img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"></li>
                                    <?php
                                    if($desklog_user == 1){
                                    ?>
                                    <li><span class="dots dots-bg-light-success"></span>Reach Max. Time - <img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"></li>
                                    <?php } ?>
                                    <li><span class="dots dots-bg-dark-denger"></span>Not Reach Max. Time - <img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"></li>
                                    <?php 
                                    if($desklog_user == 1) {
                                    ?>
                                    <li><span class="dots dots-bg-light-denger"></span>Not Reach Max. Time - <img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"></li>
                                    <?php } ?>
                                    <li><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> : Keyline Tracker</li>
                                    <?php 
                                    if($desklog_user == 1){
                                    ?>
                                    <li><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> : Desktop Tracker</li>
                                    <?php } ?>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="rows">
                           <div class="col-xxl-12 col-md-12 table-responsive">
                              <table class="table general_table_style">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>User</th>
                                       <th>January</th>
                                       <th>February</th>
                                       <th>March</th>
                                       <th>April</th>
                                       <th>May</th>
                                       <th>June</th>
                                       <th>July</th>
                                       <th>August</th>
                                       <th>September</th>
                                       <th>October</th>
                                       <th>November</th>
                                       <th>December</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if ($responses) {
                                       $sl = 1;
                                       foreach ($responses as $response) { 
                                             // pr($response);?>
                                    <tr>
                                       <td><?= $sl++ ?></td>
                                       <td class="fw-bold"><?= $response['name'] ?></td>
                                       <td>
                                          <?php if ($response['jan_booked'] > 0) { ?><span class="badge <?= (($response['jan_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['jan_booked'], 2) ?></span><?php } ?>

                                          <?php if($response['deskloguser'] == 1) { if ($response['jan_desklog'] > 0) { ?><span class="badge <?= (($response['jan_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['jan_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['feb_booked'] > 0) { ?><span class="badge <?= (($response['feb_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['feb_booked'], 2) ?></span><?php } ?>

                                          <?php if($response['deskloguser'] == 1) { if ($response['feb_desklog'] > 0) { ?><span class="badge <?= (($response['feb_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['feb_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['mar_booked'] > 0) { ?><span class="badge <?= (($response['mar_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['mar_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['mar_desklog'] > 0) { ?><span class="badge <?= (($response['mar_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['mar_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['apr_booked'] > 0) { ?><span class="badge <?= (($response['apr_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['apr_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['apr_desklog'] > 0) { ?><span class="badge <?= (($response['apr_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['apr_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['may_booked'] > 0) { ?><span class="badge <?= (($response['may_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['may_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['may_desklog'] > 0) { ?><span class="badge <?= (($response['may_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['may_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['jun_booked'] > 0) { ?><span class="badge <?= (($response['jun_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['jun_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['jun_desklog'] > 0) { ?><span class="badge <?= (($response['jun_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['jun_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['jul_booked'] > 0) { ?><span class="badge <?= (($response['jul_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['jul_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['jul_desklog'] > 0) { ?><span class="badge <?= (($response['jul_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['jul_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['aug_booked'] > 0) { ?><span class="badge <?= (($response['aug_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['aug_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['aug_desklog'] > 0) { ?><span class="badge <?= (($response['aug_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['aug_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['sep_booked'] > 0) { ?><span class="badge <?= (($response['sep_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['sep_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['sep_desklog'] > 0) { ?><span class="badge <?= (($response['sep_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['sep_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['oct_booked'] > 0) { ?><span class="badge <?= (($response['oct_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['oct_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['oct_desklog'] > 0) { ?><span class="badge <?= (($response['oct_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['oct_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['nov_booked'] > 0) { ?><span class="badge <?= (($response['nov_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['nov_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['nov_desklog'] > 0) { ?><span class="badge <?= (($response['nov_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['nov_desklog'] ?></span><?php } }?>
                                       </td>
                                       <td>
                                          <?php if ($response['dec_booked'] > 0) { ?><span class="badge <?= (($response['dec_booked'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= number_format($response['dec_booked'], 2) ?></span><?php } ?>
                                          
                                          <?php if($response['deskloguser'] == 1) { if ($response['dec_desklog'] > 0) { ?><span class="badge <?= (($response['dec_desklog'] >= $application_settings->monthly_minimum_effort_time) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['dec_desklog'] ?></span><?php } }?>
                                       </td>
                                    </tr>
                                    <?php }
                                       } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php   } ?>
                  <?php if (checkModuleFunctionAccess(1, 67)) { ?>
                  <div class="card table-card">
                     <div class="card-header">
                        <h6 class="fw-bold heading_style">Attendance Report</h6>
                     </div>
                     <div class="card-body">
                        <div class="rows">
                           <div class="col-xxl-12 col-md-12 table-responsive">
                              <table class="table general_table_style general_table_style">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>User</th>
                                       <?php if (!empty($arr)) {
                                          for ($a = 0; $a < count($arr); $a++) { ?>
                                       <th><?= date_format(date_create($arr[$a]), "d-m-Y") ?></th>
                                       <?php }
                                          } ?>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if ($last7DaysAttendance) {
                                       // pr($last7DaysAttendance);
                                       $sl = 1;
                                       $counter = 0;
                                       foreach ($last7DaysAttendance as $res) { ?>
                                    <tr>
                                       <td><?= $sl++ ?></td>
                                       <td class="fw-bold"><?= $res['name'] ?></td>
                                       <?php
                                          $reports = $res['Attendancereports'];
                                          foreach ($reports as $report) {
                                             if (!empty($report['punchIn'])) {
                                                $punchIn = date('H:i', strtotime($report['punchIn']));
                                            } else {
                                                $punchIn = null; // Handle cases where punchIn is empty
                                            }
                                        
                                            if (!empty($report['punchOut'])) {
                                                $punchOut = date('H:i', strtotime($report['punchOut']));
                                            } else {
                                                $punchOut = null; // Handle cases where punchOut is empty
                                            }
                                        
                                           $comparison_time = sprintf("%02d:00", $application_settings->mark_later_after);
                                          ?>
                                       <td>
                                       <!-- <p onclick="punchin('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['punchIn'] ?>','<?= $report['punchOut'] ?>')"><?php if ($punchIn > 0) { ?><span class="badge <?= (($punchIn <= 10) ? 'badge-tracker-success' : 'badge-tracker-danger') ?> d-block h-100" style="cursor:pointer;"><span class="mt-3">IN: <?= date('H:i', strtotime($punchIn)) ?></span><?php } ?></p>                                                                                 
                                       <p onclick="punchin('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['punchIn'] ?>','<?= $report['punchOut'] ?>')"><?php if ($punchOut > 0) { ?><span class="badge badge-desktime-success d-block h-100" style="cursor:pointer;"><span class="mt-3">OUT: <?= date('H:i', strtotime($punchOut)) ?></span><?php } ?></span></p>                                                                                  -->
                                       <p class="mb-1 mt-1 text-center font14" onclick="punchin('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['punchIn'] ?>','<?= $report['punchOut'] ?>')">
                                          <?php if ($punchIn) { ?>
                                                <span class="badge <?= ($punchIn <= $comparison_time) ? 'badge-tracker-success' : 'badge-tracker-danger' ?> d-block h-100" style="cursor:pointer;">
                                                   <span class="mt-3">IN: <?= $punchIn ?></span>
                                                </span>
                                          <?php } ?>
                                       </p>                                                                                 
                                       <p class="mb-1 mt-1 text-center font14" onclick="punchin('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['punchIn'] ?>','<?= $report['punchOut'] ?>')">
                                          <?php if ($punchOut) { ?>
                                                <span class="badge badge-desktime-success d-block h-100" style="cursor:pointer;">
                                                   <span class="mt-3">OUT: <?= $punchOut ?></span>
                                                </span>
                                          <?php } ?>
                                       </p>         
                                       </td>
                                       <?php } ?>
                                    </tr>
                                    <?php $counter++;
                                       }
                                       } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php   } ?>
                  <?php if (checkModuleFunctionAccess(1, 68)) { ?>
                  <div class="card table-card">
                        <div class="card-header">
                           <!-- <h6 class="fw-bold heading_style">Last 7 Days Report</h6> -->
                           <div class="row align-items-center">
                              <div class="col-lg-5 col-md-7">
                                 <div class="card-header-left">
                                    <ul class="d-flex align-items-center">
                                       <!-- <li class="me-3"><h6 class="fw-bold heading_style">Last 7 Days Report</h6></li> -->
                                       <li class="me-3"><h6 class="fw-bold heading_style">Effort Report</h6></li>
                                    </ul>
                                 </div>
                              </div>
                              <div class="col-lg-7 col-md-5">
                                 <div class="card-header-right">
                                    <ul class="d-flex justify-content-end gap-2 flex-wrap lagend-list ms-auto">
                                       <li><span class="dots dots-bg-dark-success"></span>Reach Max. Time - <img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"></li>
                                       <?php
                                       if($desklog_user == 1){
                                       ?>
                                       <li><span class="dots dots-bg-light-success"></span>Reach Max. Time - <img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"></li>
                                       <?php } ?>
                                       <li><span class="dots dots-bg-dark-denger"></span>Not Reach Max. Time - <img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"></li>
                                       <?php 
                                       if($desklog_user == 1) {
                                       ?>
                                       <li><span class="dots dots-bg-light-denger"></span>Not Reach Max. Time - <img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"></li>
                                       <?php } ?>
                                       <li><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> : Keyline Tracker</li>
                                       <?php 
                                       if($desklog_user == 1){
                                       ?>
                                       <li><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> : Desktop Tracker</li>
                                       <?php } ?>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     <div class="card-body">
                        <div class="rows">
                           <div class="col-xxl-12 col-md-12 table-responsive">
                              <table class="table general_table_style">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>User</th>
                                       <?php if (!empty($arr)) {
                                          for ($a = 0; $a < count($arr); $a++) { ?>
                                       <th><?= date_format(date_create($arr[$a]), "d-m-Y") ?></th>
                                       <?php }
                                          } ?>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if ($last7DaysResponses) {
                                       $sl = 1;
                                       $counter = 0;
                                       foreach ($last7DaysResponses as $res) {
                                           //  pr($res);
                                            ?>
                                    <tr>
                                       <td><?= $sl++ ?></td>
                                       <td class="fw-bold"><?= $res['name'] ?></td>
                                       <?php
                                          $reports = $res['reports'];
                                          foreach ($reports as $report) {
                                              $date1              = date_create($report['booked_date']);
                                              $date2              = date_create($report['booked_today']);
                                              $diff               = date_diff($date1, $date2);
                                              $date_difference    = $diff->format("%a");
                                              //    echo $report['booked_effort']                                                  
                                          ?>
                                       <td onclick="dayWiseList('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['booked_effort'] ?>')">
                                       <?php                                          
                                          if ($date_difference == 0 && $report['booked_effort'] != 0) {
                                             echo '<span class="badge badge-tracker-success cursor-pointer"><img src="' . base_url('public/uploads/tracker-icon.webp') . '" alt="" class="tracker-icon">' . date("H:i", strtotime($report['booked_effort'])) . '' . ($report['booked_effort'] < $application_settings->daily_minimum_effort_time ? '<span class="dotted-badge"></span>' : '') . '</span>';
                                             echo ($report['deskloguser'] == 1) ? '<span class="badge badge-tracker-success cursor-pointer"><img src="' . base_url('public/uploads/desklog-icon.webp') . '" alt="" class="desklog-icon">' : '';
                                             echo ($report['deskloguser'] == 1) ? '' . $report['desklog_time'] : '';
                                             echo '</span>';
                                          } 
                                          elseif ($date_difference > 1 && $report['booked_effort'] != 0) {
                                             echo '<span class="badge badge-tracker-warrning cursor-pointer"><img src="' . base_url('public/uploads/tracker-icon.webp') . '" alt="" class="tracker-icon">' . date("H:i", strtotime($report['booked_effort'])) . '' . ($report['booked_effort'] < $application_settings->daily_minimum_effort_time ? '<span class="dotted-badge"></span>' : '') . '</span> ';
                                             echo ($report['deskloguser'] == 1) ? '<span class="badge badge-tracker-warrning cursor-pointer"><img src="' . base_url('public/uploads/desklog-icon.webp') . '" alt="" class="desklog-icon">' : '';
                                             echo ($report['deskloguser'] == 1) ? '' . $report['desklog_time'] : '';
                                             echo '</span>';
                                          } elseif ($date_difference <= 1 && $report['booked_effort'] != 0) {
                                             echo '<span class="badge badge-desktime-success cursor-pointer"><img src="' . base_url('public/uploads/tracker-icon.webp') . '" alt="" class="tracker-icon">' . date("H:i", strtotime($report['booked_effort'])) . '' . ($report['booked_effort'] < $application_settings->daily_minimum_effort_time ? '<span class="dotted-badge"></span>' : '') . '</span> ';
                                             echo ($report['deskloguser'] == 1) ? '<span class="badge badge-desktime-success cursor-pointer"><img src="' . base_url('public/uploads/desklog-icon.webp') . '" alt="" class="desklog-icon">' : '';
                                             echo ($report['deskloguser'] == 1) ? '' . $report['desklog_time'] : '';
                                             echo '</span>';
                                          }

                                          if($report['booked_effort'] == 0)
                                          {
                                             echo '<span class="badge badge-tracker-holiday cursor-pointer"><img src="' . base_url('public/uploads/tracker-icon.webp') . '" alt="" class="tracker-icon">' . date("H:i", strtotime($report['booked_effort'])) . '</span>';
                                             echo ($report['deskloguser'] == 1) ? '<span class="badge badge-tracker-holiday cursor-pointer"><img src="' . base_url('public/uploads/desklog-icon.webp') . '" alt="" class="desklog-icon">' : '';
                                             echo ($report['deskloguser'] == 1) ? '' . $report['desklog_time'] : '';
                                             echo '</span>';
                                          }
                                                                                                                                                                        
                                          ?>                                         
                                       </td>
                                       <?php } ?>
                                    </tr>
                                    <?php $counter++;
                                       }
                                       } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php   } ?>
               </div>
               <?php if (checkModuleFunctionAccess(1, 71)) { ?>
               <div class="col-md-12">
                  <div class="heading-box">
                     <div class="row">
                        <div class="col-md-4">
                           <div class="card-header-left">
                              <ul class="d-flex align-items-center">
                                 <!-- <li class="me-3"><h6 class="fw-bold heading_style">All Graph</h6></li> -->
                                 <li>
                                    <p>Billable & Non-Billable</p>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="chart-container">
                     <div class="row">
                        <?php if ($AlluserGraph) {
                           foreach ($AlluserGraph as $res) { ?>
                              <div class="col-md-4">
                                 <div class="chart-holder">
                                    <div class="chart-info d-flex justify-content-between flex-column">
                                       <div class="chart-info-inner">
                                          <h4>Yesterday</h4>
                                          <p class="mt-1">Compare between <br>Billable & Non-Billable</p>
                                       </div>
                                       <ul>
                                          <li>Billable  <span class="billable-dot"></span></li>
                                          <li>Non-Billable   <span class="non-billable-dot"></span></li>
                                       </ul>
                                    </div>
                                    <div class="chart-box">
                                       <?php if ($res['yesterdayAllUserHourBill'] != 0) { ?>
                                          <!-- Pie Chart -->
                                          <div id="pieChartWise" :options="chartOptions"></div>
                                          <script>
                                             document.addEventListener("DOMContentLoaded", () => {
                                                var options = {
                                                   series: [<?= $res['yesterdayAllUserHourBill'] ?>, <?= $res['yesterdayAllUserMinBill'] ?>],
                                                   chart: {
                                                         width: 220,
                                                         type: 'donut',
                                                   },
                                                   plotOptions: {
                                                         pie: {
                                                            donut: {
                                                               size: '35%', // Adjust the size of the inner circle (can be changed as per your preference)
                                                            }
                                                         }
                                                      },
                                                   fill: {
                                                         colors: ['#C5EEC5', '#FD6363']
                                                   },
                                                   dataLabels: {
                                                         enabled: true,
                                                         dropShadow: {
                                                            enabled: false  // Disable the box shadow here
                                                         },
                                                         style: {
                                                            fontSize: '12px',
                                                         },
                                                         background: {
                                                            enabled: true,
                                                            foreColor: '#000',
                                                            padding: 5,
                                                            borderRadius: 2,
                                                            borderWidth: 1,
                                                            borderColor: '#ffc107'
                                                         },
                                                   },
                                                   colors: ['#C5EEC5', '#FD6363'],
                                                   labels: ['Billable', 'Non-Billable'],
                                                   responsive: [{
                                                         breakpoint: 1300,
                                                         options: {
                                                            chart: {
                                                               width: 180,
                                                            },
                                                            
                                                         }
                                                   }],
                                                   legend: {
                                                      show: false,
                                                   }
                                                };
                                                var chart = new ApexCharts(document.querySelector("#pieChartWise"), options);
                                                chart.render();
                                             });
                                          </script>
                                          <!-- End Pie Chart -->
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="chart-holder">
                                       <div class="chart-info d-flex justify-content-between flex-column">
                                          <div class="chart-info-inner">
                                             <h4>This Month</h4>
                                             <p class="mt-1">Compare between <br>Billable & Non-Billable</p>
                                          </div>
                                          <ul>
                                             <li>Billable  <span class="billable-dot"></span></li>
                                             <li>Non-Billable   <span class="non-billable-dot"></span></li>
                                          </ul>
                                       </div>
                                       <div class="chart-box">
                                          <?php if ($res['thismonthAllUserHourBillUsr'] != 0) { ?>
                                             <!-- Pie Chart -->
                                             <div id="pieChartMonthWise"></div>
                                             <script>
                                                document.addEventListener("DOMContentLoaded", () => {
                                                   var options = {
                                                      series: [<?= str_replace(",", "", $res['thismonthAllUserHourBillUsr']) ?>, <?= $res['thismonthAllUserMinBillUsr'] ?>],
                                                      chart: {
                                                            width: 220,
                                                            type: 'donut',
                                                      },
                                                      plotOptions: {
                                                         pie: {
                                                            donut: {
                                                               size: '35%', // Adjust the size of the inner circle (can be changed as per your preference)
                                                            }
                                                         }
                                                      },
                                                      fill: {
                                                            colors: ['#C5EEC5', '#FD6363']
                                                      },
                                                      dataLabels: {
                                                            enabled: true,
                                                            dropShadow: {
                                                               enabled: false  // Disable the box shadow here
                                                            },
                                                            style: {
                                                               fontSize: '12px',
                                                               textShadow: 'none'
                                                            },
                                                            background: {
                                                               enabled: true,
                                                               foreColor: '#000',
                                                               padding: 5,
                                                               borderRadius: 2,
                                                               borderWidth: 1,
                                                               borderColor: '#ffc107'
                                                            },
                                                      },
                                                      colors: ['#C5EEC5', '#FD6363'],
                                                      labels: ['Billable', 'Non-Billable'],
                                                      responsive: [{
                                                            breakpoint: 1300,
                                                            options: {
                                                               chart: {
                                                                  width: 180
                                                               },
                                                            }
                                                      }],
                                                      legend: {
                                                         show: false,
                                                      }
                                                   };
                                                   var chart = new ApexCharts(document.querySelector("#pieChartMonthWise"), options);
                                                   chart.render();
                                                });
                                             </script>
                                             <!-- End Pie Chart -->
                                          <?php } ?>
                                       </div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="chart-holder">
                                    <div class="chart-info d-flex justify-content-between flex-column">
                                       <div class="chart-info-inner">
                                          <h4>Last Month</h4>
                                          <p class="mt-1">Compare between <br>Billable & Non-Billable</p>
                                       </div>
                                       <ul>
                                          <li>Billable  <span class="billable-dot"></span></li>
                                          <li>Non-Billable   <span class="non-billable-dot"></span></li>
                                       </ul>
                                    </div>
                                    <div class="chart-box">
                                       <?php if ($res['thismonthAllUserHourBillUsr'] != 0) { ?>
                                          <!-- Pie Chart -->
                                          <div id="pieChartlmWise"></div>
                                          <script>
                                             document.addEventListener("DOMContentLoaded", () => {
                                                var options = {
                                                   series: [<?= str_replace(",", "", $res['lastmonthAllUserHourBillUsr']) ?>, <?= $res['lastmonthAllUserMinBillUsr'] ?>],
                                                   chart: {
                                                         width: 220,
                                                         type: 'donut',
                                                   },
                                                   plotOptions: {
                                                         pie: {
                                                            donut: {
                                                               size: '35%', // Adjust the size of the inner circle (can be changed as per your preference)
                                                            }
                                                         }
                                                      },
                                                   fill: {
                                                         colors: ['#C5EEC5', '#FD6363']
                                                   },
                                                   dataLabels: {
                                                         enabled: true,
                                                         dropShadow: {
                                                            enabled: false  // Disable the box shadow here
                                                         },
                                                         style: {
                                                            fontSize: '12px',
                                                         },
                                                         background: {
                                                            enabled: true,
                                                            foreColor: '#000',
                                                            padding: 4,
                                                            borderRadius: 2,
                                                            borderWidth: 1,
                                                            borderColor: '#ffc107',
                                                         },
                                                   },
                                                   colors: ['#C5EEC5', '#FD6363'],
                                                   labels: ['Billable', 'Non-Billable'],
                                                   responsive: [{
                                                         breakpoint: 1300,
                                                         options: {
                                                            chart: {
                                                               width: 180
                                                            },
                                                         }
                                                   }],
                                                   legend: {
                                                      show: false,
                                                   }
                                                };
                                                var chart = new ApexCharts(document.querySelector("#pieChartlmWise"), options);
                                                chart.render();
                                             });
                                          </script>
                                          <!-- End Pie Chart -->
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                           <?php  }
                        } ?>
                     </div>
                  </div>
               </div>
               <?php } ?>
               <?php if (checkModuleFunctionAccess(1, 72)) { ?>

               <div class="col-md-12">
                  <div class="heading-box">
                     <div class="row">
                        <div class="col-md-4">
                           <div class="card-header-left">
                              <ul class="d-flex align-items-center">
                                 <!-- <li class="me-3"><h6 class="fw-bold heading_style">User Graph</h6></li> -->
                                 <li>
                                    <p>Billable & Non-Billable Effort</p>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="chart-container all-user-chart">
                     <div class="row">
                        <?php if ($userGraph) {
                           $sl = 1;
                           $counter = 0;
                           foreach ($userGraph as $res) { ?>
                              <div class="col-lg-6 mb-3">
                                 <div class="chart-holder">
                                    <div class="row">
                                       <div class="col-md-5">
                                          <div class="chart-info d-flex flex-column justify-content-between">
                                             <div class="chart-info-inner">
                                                <h6 class="mb-1"><?= $sl++ ?>.</h6>
                                                <h4><?= $res['name'] ?></h4>
                                                <p class="mt-1"><?= $res['deprt_name'] ?>(<?= $res['type'] ?>)</p>
                                             </div>
                                             <ul>
                                                <li>Billable  <span class="billable-dot"></span></li>
                                                <li>Non-Billable   <span class="non-billable-dot"></span></li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="col-md-7">
                                          <div class="chart-box">
                                             <div class="row">
                                                <div class="col-md-4 text-center">
                                                   <!-- ?php if ($res['yesterdayHourBill'] != 0) { ?> -->
                                                      <!-- Pie Chart -->
                                                      <div id="pieChartWise<?= $res['id'] ?>"></div>
                                                      <script>
                                                         document.addEventListener("DOMContentLoaded", () => {
                                                            var options = {
                                                               series: [<?= $res['yesterdayHourBill'] ?>, <?= $res['yesterdayMinBill'] ?>],
                                                               chart: {
                                                                     width: "100%",
                                                                     height: '75%',
                                                                     type: 'donut',
                                                               },
                                                               plotOptions: {
                                                                        pie: {
                                                                           donut: {
                                                                              size: '35%', // Adjust the size of the inner circle (can be changed as per your preference)
                                                                           }
                                                                        }
                                                                     },
                                                               fill: {
                                                                     colors: ['#C5EEC5', '#FD6363']
                                                               },
                                                               dataLabels: {
                                                                     enabled: true,
                                                                     dropShadow: {
                                                                        enabled: false  // Disable the box shadow here
                                                                     },
                                                                     style: {
                                                                        fontSize: '12px',
                                                                     },
                                                                     background: {
                                                                        enabled: true,
                                                                        foreColor: '#000',
                                                                        padding: 4,
                                                                        borderRadius: 2,
                                                                        borderWidth: 1,
                                                                        borderColor: '#ffc107',
                                                                     },
                                                               },
                                                               colors: ['#C5EEC5', '#FD6363'],
                                                               labels: ['Billable', 'Non-Billable'],
                                                               responsive: [
                                                                  {
                                                                     breakpoint: 1375,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '60%',
                                                                        },
                                                                     
                                                                     }
                                                                  },
                                                                  {
                                                                     breakpoint: 1110,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '55%',
                                                                        },
                                                                     
                                                                     }
                                                                  },
                                                                  {
                                                                     breakpoint: 992,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '70%',
                                                                        },
                                                                     
                                                                     }
                                                                  },
                                                                  {
                                                                     breakpoint: 768,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '100%',
                                                                        },
                                                                     
                                                                     }
                                                                  }
                                                               ],
                                                               legend: {
                                                                  show: false,
                                                               }
                                                            };
                                                            var chart = new ApexCharts(document.querySelector("#pieChartWise<?= $res['id'] ?>"), options);
                                                            chart.render();
                                                         });
                                                      </script>
                                                      <!-- End Pie Chart -->
                                                   <!-- ?php } ?> -->
                                                   <p class="chart-label">Yesterday</p>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                   <?php if ($res['thismonthHourBillUsr'] != 0) { ?>
                                                      <!-- Pie Chart -->
                                                      <div id="pieChartMonthWise<?= $res['id'] ?>"></div>
                                                      <script>
                                                         document.addEventListener("DOMContentLoaded", () => {
                                                            var options = {
                                                               series: [<?= $res['thismonthHourBillUsr'] ?>, <?= $res['thismonthMinBillUsr'] ?>],
                                                               chart: {
                                                                     width: "100%",
                                                                     height: '75%',
                                                                     type: 'donut',
                                                               },
                                                               dataLabels: {
                                                                     enabled: true,
                                                                     dropShadow: {
                                                                        enabled: false  // Disable the box shadow here
                                                                     },
                                                                     style: {
                                                                        fontSize: '12px',
                                                                     },
                                                                     background: {
                                                                        enabled: true,
                                                                        foreColor: '#000',
                                                                        padding: 4,
                                                                        borderRadius: 2,
                                                                        borderWidth: 1,
                                                                        borderColor: '#ffc107',
                                                                     },
                                                               },
                                                               plotOptions: {
                                                                        pie: {
                                                                           donut: {
                                                                              size: '35%', // Adjust the size of the inner circle (can be changed as per your preference)
                                                                           }
                                                                        }
                                                                     },
                                                               fill: {
                                                                     colors: ['#C5EEC5', '#FD6363']
                                                               },
                                                               colors: ['#C5EEC5', '#FD6363'],
                                                               labels: ['Billable', 'Non-Billable'],
                                                               responsive: [
                                                                  {
                                                                     breakpoint: 1375,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '60%',
                                                                        },
                                                                     
                                                                     }
                                                                  },
                                                                  {
                                                                     breakpoint: 1110,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '55%',
                                                                        },
                                                                     
                                                                     }
                                                                  },
                                                                  {
                                                                     breakpoint: 992,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '70%',
                                                                        },
                                                                     
                                                                     }
                                                                  },
                                                                  {
                                                                     breakpoint: 768,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '100%',
                                                                        },
                                                                     
                                                                     }
                                                                  }
                                                               ],
                                                               legend: {
                                                                  show: false,
                                                               }
                                                            };
                                                            var chart = new ApexCharts(document.querySelector("#pieChartMonthWise<?= $res['id'] ?>"), options);
                                                            chart.render();
                                                         });
                                                      </script>
                                                      <!-- End Pie Chart -->
                                                   <?php } ?>
                                                   <p class="chart-label">This Month</p>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                   <?php if ($res['lastmonthHourBillUsr'] != 0) { ?>
                                                   <!-- Pie Chart -->
                                                      <div id="pieChartlmWise<?= $res['id'] ?>"></div>
                                                      <script>
                                                         document.addEventListener("DOMContentLoaded", () => {
                                                            var options = {
                                                               series: [<?= $res['lastmonthHourBillUsr'] ?>, <?= $res['lastmonthMinBillUsr'] ?>],
                                                               chart: {
                                                                     width: "100%",
                                                                     height: '75%',
                                                                     type: 'donut',
                                                               },
                                                               plotOptions: {
                                                                        pie: {
                                                                           donut: {
                                                                              size: '35%', // Adjust the size of the inner circle (can be changed as per your preference)
                                                                           }
                                                                        }
                                                                     },
                                                               fill: {
                                                                     colors: ['#C5EEC5', '#FD6363']
                                                               },
                                                               dataLabels: {
                                                                     enabled: true,
                                                                     dropShadow: {
                                                                        enabled: false  // Disable the box shadow here
                                                                     },
                                                                     style: {
                                                                        fontSize: '12px',
                                                                     },
                                                                     background: {
                                                                        enabled: true,
                                                                        foreColor: '#000',
                                                                        padding: 4,
                                                                        borderRadius: 2,
                                                                        borderWidth: 1,
                                                                        borderColor: '#ffc107',
                                                                     },
                                                               },
                                                               colors: ['#C5EEC5', '#FD6363'],
                                                               labels: ['Billable', 'Non-Billable'],
                                                               responsive: [
                                                                  {
                                                                     breakpoint: 1375,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '60%',
                                                                        },
                                                                     
                                                                     }
                                                                  },
                                                                  {
                                                                     breakpoint: 1110,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '55%',
                                                                        },
                                                                     
                                                                     }
                                                                  },
                                                                  {
                                                                     breakpoint: 992,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '70%',
                                                                        },
                                                                     
                                                                     }
                                                                  },
                                                                  {
                                                                     breakpoint: 768,
                                                                     options: {
                                                                        chart: {
                                                                           width: "100%",
                                                                           height: '100%',
                                                                        },
                                                                     
                                                                     }
                                                                  }
                                                               ],
                                                               legend: {
                                                                  show: false,
                                                               }
                                                            };
                                                            var chart = new ApexCharts(document.querySelector("#pieChartlmWise<?= $res['id'] ?>"), options);
                                                            chart.render();
                                                         });
                                                      </script>
                                                   <!-- End Pie Chart -->
                                                   <?php } ?>
                                                   <p class="chart-label">Last Month</p>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php $counter++;
                           }
                           } ?>
                     </div>
                  </div>
               </div>     
               <?php } ?>
            </div>
            <?php } else { ?>
            <div class="row">
               <div class="col-md-6 col-xl-6">
                  <!-- <a href="<?php echo base_url('admin/'); ?>/manage_pledge_taken/enquiry_form"> -->
                  <div class="card bg-c-blue order-card">
                     <div class="card-body">
                        <h6 class="text-white">Active Projects</h6>
                        <h2 class="text-right text-white"><i class="fa fa-paperclip float-left"></i><span>
                           <?= $active_project ?>
                           </span>
                        </h2>
                     </div>
                  </div>
                  <!-- </a> -->
               </div>
               <div class="col-md-6 col-xl-6">
                  <!-- <a href="<?php echo base_url('admin/'); ?>/manage_pledge_taken/enquiry_form"> -->
                  <div class="card bg-c-green order-card">
                     <div class="card-body">
                        <h6 class="text-white">Closed Projects</h6>
                        <h2 class="text-right text-white"><i class="fa fa-paperclip float-left"></i><span>
                           <?= $closed_project ?>
                           </span>
                        </h2>
                     </div>
                  </div>
                  <!-- </a> -->
               </div>
            </div>
            <div class="card">
               <div class="card-header bg-warning text-dark">
                  <h6 class="fw-bold text-center">Project Report</h6>
               </div>
               <div class="card-body">
                  <div class="rows">
                     <div class="col-xxl-12 col-md-12 table-responsive">
                        <table class="table">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>Project Name</th>
                                 <th>Project Type</th>
                                 <!-- <th>Effort Time</th> -->
                              </tr>
                           </thead>
                           <tbody>
                              <?php if ($projects) {
                                 $sl = 1;
                                 foreach ($projects as $row) { ?>
                              <tr>
                                 <td><?= $sl++ ?></td>
                                 <td><?= $row->name ?></td>
                                 <td><?= $row->project_status_name ?></td>
                                 <!-- <td><?= intdiv($total_effort_in_mins, 60) . ' Hours ' . ($total_effort_in_mins % 60) . ' Minutes'; ?></td> -->
                              </tr>
                              <?php }
                                 } ?>
                              <?php if ($closed_projects) {
                                 foreach ($closed_projects as $row2) { ?>
                              <tr>
                                 <td><?= $row2->name ?></td>
                                 <td><?= $row2->project_status_name ?></td>
                              </tr>
                              <hr>
                              <?php }
                                 } ?>
                           </tbody>
                        </table>
                        <div>
                           <a class="btn btn-primary" href="<?= base_url('admin/reports/advance-search') ?>"> View Report Details</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
         </div>
         <!-- End Left side columns -->
      </div>
   </div>
   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable mx-auto modal-lg">
         <div class="modal-content" id="modalBody">
         </div>
      </div>
   </div>
   <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable mx-auto">
         <div class="modal-content" id="modalBody1">
         </div>
      </div>
   </div>
   <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mx-auto modal-lg">
         <div class="modal-content" id="modalBody2">
         </div>
      </div>
   </div>
   
</section>

<!-- task add modal -->
<div class="modal fade" id="addAttendanceModal" tabindex="-1" aria-labelledby="addAttendanceLabel" aria-hidden="true">
   <div class="modal-dialog">                        
         <form action="<?= base_url('admin/save-task') ?>" method="POST" id="addTaskForm">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Assign Task</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
               </div>

               <div class="modal-body">
                  <!-- Project Dropdown -->
                  <div class="mb-3">
                     <label for="project_id" class="form-label">Select Project</label>
                     <select name="project_id" id="project_id" class="form-select select2" required>
                        <option value="">Select Project</option>
                        <?php foreach ($projects as $project): ?>
                           <option value="<?= $project->id ?>"><?= $project->name ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <?php if ($userType == 'ADMIN' || $userType == 'SUPER ADMIN') { ?>
                  <!-- Employee Dropdown -->
                  <div class="mb-3">
                     <label for="employee_id" class="form-label">Select Employee</label>
                     <select name="employee_id" id="employee_id" class="form-select select2" required>
                        <option value="">Select Employee</option>
                        <?php foreach ($employees as $emp): ?>
                              <option value="<?= $emp->id ?>"><?= $emp->name ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <?php } ?>

                  <!-- Status Radio -->
                  <div class="mb-3">
                  <label class="form-label">Status</label><br>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="status" id="present" value="0" onchange="myFunction()" checked>
                     <label class="form-check-label" for="present">PRESENT</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="status" id="halfday" value="1" onchange="myFunction()">
                     <label class="form-check-label" for="halfday">HALFDAY LEAVE</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="status" id="fullday" value="2" onchange="myFunction()">
                     <label class="form-check-label" for="fullday">FULLDAY LEAVE</label>
                  </div>
                  </div>

                  <!-- Description -->
                  <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                  </div>
                  
                  <?php
                     $today = date('Y-m-d');
                     $maxDate = date('Y-m-d', strtotime('+1 month'));
                  ?>
                  <!-- Date -->
                     <div class="row mb-3">
                        <div class="col">
                           <label for="date" class="form-label">Date</label>
                           <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d') ?>" min="<?= $today ?>" max="<?= $maxDate ?>" required>
                        </div>
                        <div class="col">
                           <label for="fhour" class="form-label">Hour</label>
                           <select name="fhour" id="fhour" class="form-select">
                              <option value="">Select Hour</option>
                              <?php for ($i = 0; $i <= 8; $i++): ?>
                              <option value="<?= $i ?>"><?= $i ?></option>
                              <?php endfor; ?>
                           </select>
                        </div> 
                        <div class="col">
                           <label for="fminute" class="form-label">Minute</label>
                           <select name="fminute" id="fminute" class="form-select">
                              <option value="">Select Minute</option>
                              <?php for ($i = 0; $i <= 45; $i+= 15): ?>
                              <option value="<?= $i ?>"><?= $i ?></option>
                              <?php endfor; ?>
                           </select>
                        </div>                       
                     </div>                  

                  <!-- Priority -->
                  <div class="mb-3">
                  <label class="form-label me-2">Priority:</label>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="priority" id="low" value="1">
                     <label class="form-check-label" for="low">LOW</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="priority" id="medium" value="2" checked>
                     <label class="form-check-label" for="medium">MEDIUM</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="priority" id="high" value="3">
                     <label class="form-check-label" for="high">HIGH</label>
                  </div>
                  </div>
               </div>

               <div class="modal-footer">
                  <button type="submit" class="btn btn-success" id="addTaskSaveBtn">Save</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
               </div>
            </div>
         </form>

   </div>
</div>

<!-- task edit modal -->
   <div class="modal fade" id="myModaltaskEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div id="modalTask">
         </div>
      </div>
   </div>

<!-- effort add modal -->
   <!-- <div class="modal fade" id="myModaltask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div id="modalEffort">
         </div>
      </div>
   </div> -->
   <div class="modal fade" id="myModaltask" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <form action="<?= base_url('admin/save-effort') ?>" method="POST" id="addEffortForm">
            <input type="hidden" name="task_id" id="task_id">
            
            <div id="modalEffort">
               <!-- AJAX loads content here (body + footer) -->
            </div>
            </form>
         </div>
      </div>
   </div>

 
<!-- <script>
   $(document).ready(function() {
       $('#project_id').select2({
           placeholder: "Search...",
           allowClear: true
       });
   });
</script> -->

<script>
   function dayWiseList(userId, name, date, effort_time) {
       $('#modalBody').html('');
       $.ajax({
           url: '<?php echo base_url('admin/dayWiseListRecords'); ?>',
           type: 'GET',
           data: {
               userId: userId,
               name: name,
               date: date,
               effort_time: effort_time
           },
           dataType: 'html',
           success: function(response) {
               $('#modalBody').html(response);
               $('#myModal').modal('show');
           },
           error: function(xhr, status, error) {
               console.error('Error fetching modal content:', error);
           }
       });
   }
   
   function punchin(userId, name, date, punchIn, punchOut) {
       $('#modalBody1').html('');
       $.ajax({
           url: '<?php echo base_url('admin/PunchInRecords'); ?>',
           type: 'GET',
           data: {
               userId: userId,
               name: name,
               date: date,
               punchIn: punchIn,
               punchOut: punchOut
           },
           dataType: 'html',
           success: function(response) {
               $('#modalBody1').html(response);
               $('#myModal1').modal('show');
           },
           error: function(xhr, status, error) {
               console.error('Error fetching modal content:', error);
           }
       });
   }
   
   function punchout(userId, name, date, effort_time) {
       $('#modalBody2').html('');
       $.ajax({
           url: '<?php echo base_url('admin/PunchOutRecords'); ?>',
           type: 'GET',
           data: {
               userId: userId,
               name: name,
               date: date,
               effort_time: effort_time
           },
           dataType: 'html',
           success: function(response) {
               $('#modalBody2').html(response);
               $('#myModal2').modal('show');
           },
           error: function(xhr, status, error) {
               console.error('Error fetching modal content:', error);
           }
       });
   }

   function myFunction(){
        var selectedValue = $('input[name=status]:checked').val();
        if(selectedValue == 0){
            var description = '';
            $('#description').val(description);
            $('#project_id').attr('required', true);
            $('#fhour').attr('required', true);
            $('#fminute').attr('required', true);
            $('input[name="priority"]').attr('required', true);

            $('#project_id').attr('disabled', false);
            $('#fhour').attr('disabled', false);
            $('#fminute').attr('disabled', false);
            $('input[name="priority"]').attr('disabled', false);
        } else if(selectedValue == 1){
            var description = 'Half Day Leave Taken';
            $('#description').val(description);
            $('#project_id').attr('required', false);
            $('#fhour').attr('required', false);
            $('#fminute').attr('required', false);            
            $('input[name="priority"]').attr('required', false);

            $('#project_id').attr('disabled', true);
            $('#fhour').attr('disabled', true);
            $('#fminute').attr('disabled', true);
            $('#date').attr('disabled', true);
            $('input[name="priority"]').attr('disabled', true);

            $('#project_id').val('');
            $('#fhour').val('');
            $('#fminute').val('');
            $('#date').val(date);
        } else if(selectedValue == 2){
            var description = 'Full Day Leave Taken';
            $('#description').val(description);
            $('#project_id').attr('required', false);
            $('#fhour').attr('required', false);
            $('#fminute').attr('required', false);
            $('input[name="priority"]').attr('required', false);

            $('#project_id').attr('disabled', true);
            $('#fhour').attr('disabled', true);
            $('#fminute').attr('disabled', true);
            $('#date').attr('disabled', true);
            $('input[name="priority"]').attr('disabled', true);

            $('#project_id').val('');
            $('#fhour').val('');
            $('#fminute').val('');
            $('#date').val(date);
        }
   }

   function taskWiseList(task_id) {
       $('#modalEffort').html('');
      $.ajax({
         url: '<?= base_url('admin/get-task-details') ?>', // Your backend URL
         type: 'GET',
         data: { task_id: task_id },
         dataType: 'html',
         success: function(response) {
            // Set hidden task ID
            document.getElementById('task_id').value = task_id;
            console.log(response);
            
            // Inject only modal header + body + footer
            $('#modalEffort').html(response);  
            let modalEl = document.getElementById('myModaltask');
            let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();          
            },
         error: function(xhr, status, error) {
               console.error('Error fetching task details:', error);
         }
      });
   }

   function taskEditList(task_id) {
       $('#modalTask').html('');
      $.ajax({
         url: '<?= base_url('admin/edit-task-details') ?>', // Your backend URL
         type: 'GET',
         data: { task_id: task_id },
         dataType: 'html',
         success: function(response) {
            $('#modalTask').html(response);
            // $('#myModal').modal('show');            

                  $('#myModaltaskEdit').modal('show');   
                  // Initialize Select2 inside the modal
                  // $('#myModaltaskEdit .select2').select2({
                  //    dropdownParent: $('#myModaltaskEdit') // ensures Select2 works correctly inside Bootstrap modal
                  // });            
         },
         error: function(xhr, status, error) {
               console.error('Error fetching task details:', error);
         }
      });
   }
   

function change_work_status(work_status_id) {
   //  console.log("Work status changed to:", work_status_id);
    work_status_id = parseInt(work_status_id);

    if (work_status_id == 2) {
      // console.log("Work status changed to:", work_status_id);
        // Store current hour/minute before overwriting        

        // Set both to 0 and disable
        $('#fhour').val(0);
        $('#fminute').val(0);
        $('#fhour').prop('disabled', true);
        $('#fminute').prop('disabled', true);
    } else {
        // Re-enable and restore previous values
        $('#fhour').prop('disabled', false).val();
        $('#fminute').prop('disabled', false).val();
    }
}



     //prevention double click on save add task button
      document.getElementById('addTaskForm').addEventListener('submit', ()=>{
         const btn = document.getElementById('addTaskSaveBtn');
         btn.disabled = true;         // disable the button
         btn.innerText = "Saving...";
          console.log("yes");
      });
      
       //prevention double click on save add effort button
      document.addEventListener("submit", function(e) {
       if (e.target && e.target.id === "addEffortForm") {
      //   e.preventDefault(); // stops full page reload on form submit
        const btn = e.target.querySelector("#addEffortSaveBtn");
        if (btn) {
            btn.disabled = true;
            btn.innerText = "Saving...";
            console.log("Effort form submitted");
            }
         }
      }, true);



</script>