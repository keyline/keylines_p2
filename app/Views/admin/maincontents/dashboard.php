<?php
   //die("dashboard");
   $userType           = $session->user_type;
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
                        <div class="d-flex align-items-center">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-people"></i>
                           </div>
                           <div class="ps-2">
                              <h6><?= $total_active_users ?></h6>
                           </div>
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
                  <?php if($userType == "SUPER ADMIN" || $userType == "ADMIN") {?>
                     <div class="col-md-12">
                        <div class="card table-card">
                           <div class="card-header">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="card-header-left">
                                       <ul class="d-flex align-items-center gap-2">                                    
                                          <li>
                                             <p>Present (<?=$total_present_user->user_count?>)</p>
                                          </li>
                                          <li>
                                             <p>Absent (<?php $absent = $total_app_user->user_count - $total_present_user->user_count; echo $absent;?>)</p>
                                          </li>                                    
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="col-md-8">
                                    <div class="card-header-right">

                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
               <?php } ?>

               <div class="col-md-12">
                        <div class="card table-card">
                           <div class="card-header">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="card-header-left">
                                       <ul class="d-flex align-items-center gap-2">                                    
                                          <li>
                                             <p>Present (<?=$total_present_user->user_count?>)</p>
                                          </li>
                                          <li>
                                             <p>Absent (<?php $absent = $total_app_user->user_count - $total_present_user->user_count; echo $absent;?>)</p>
                                          </li>                                    
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="col-md-8">
                                    <div class="card-header-right">

                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

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
</script>