<?php

use SebastianBergmann\Diff\Diff;

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
            <!-- <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li> -->
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section dashboard">
    <div class="row">
        <!-- <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="GET" action="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="year">
                        <div class="row mb-3 align-items-center">                                                        
                            <div class="col-md-6 col-lg-6" id="day_type_row" style="display:'block'">
                                <label for="year">Years</label>
                                <select name="year" class="form-control" id="year" required>
                                    <option value="2018" ?=(($year == '2018')?'selected':'')?>>2018</option>
                                    <hr>
                                    <option value="2019" ?=(($year == '2019')?'selected':'')?>>2019</option>
                                    <hr>
                                    <option value="2020" ?=(($year == '2020')?'selected':'')?>>2020</option>
                                    <hr>
                                    <option value="2021" ?=(($year == '2021')?'selected':'')?>>2021</option>
                                    <hr>
                                    <option value="2022" ?=(($year == '2022')?'selected':'')?>>2022</option>
                                    <hr>
                                    <option value="2023" ?=(($year == '2023')?'selected':'')?>>2023</option>
                                    <hr>
                                    <option value="2024" ?=(($year == '2024')?'selected':'')?>>2024</option>
                                    <hr>                                    
                                </select>
                            </div>                                                        
                            <div class="col-md-6 col-lg-6" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                                <?php if(!empty($response)){?>
                                    <a href="<?=base_url('admin/reports/advance-search')?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                                <?php }?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
        <!-- Left side columns -->
        <?php if($userType == "SUPER ADMIN" || $userType == "ADMIN") {?>
            <div class="col-md-12">
                <div class="card table-card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                            <div class="card-header-left">
                                <ul class="d-flex align-items-center gap-2">                                    
                                    <li>
                                        <p class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#presentModal">Present (<?=$total_present_user->user_count?>)</p>
                                    </li>
                                    <li>
                                        <p class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#AbsentModal">Absent (<?php $absent = $total_app_user->user_count - $total_present_user->user_count; echo $absent;?>)</p>
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">

                    <form method="POST" action="<?= base_url('admin/attendance-report') ?>" enctype="multipart/form-data">
                        <input type="hidden" name="form_type" value="monthly_attendance_report">
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-6 col-lg-6">
                                    <label for="date">Month</label>
                                    <input type="month" id="month" name="month" class="form-control" value="<?= $month_fetch ?>" required>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Monthly Attendance Report</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if (!empty($monthlyAttendancereport)) { ?>
            <div class="card table-card">
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table padding-y-10 general_table_style">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th>EMP ID</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Team</th>
                                    <th>Total working days</th>
                                    <th>Present</th>
                                    <th>Absent</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($monthlyAttendancereport) {
                                    $sl = 1;
                                    foreach ($monthlyAttendancereport as $res) { ?>
                                        <tr>
                                            <td><?= $sl++ ?></td>
                                            <td><?= $res->user_id ?></td>
                                            <td><?= $res->name ?></td>
                                            <td><?= $res->designation ?></td>
                                            <td><?= $res->team ?></td>
                                            <td><?= $working_days ?></td>
                                            <td><?= $res->present_count ?></td>
                                            <td><?= $working_days - $res->present_count?></td>                                            
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-12">
            <div class="card table-card">
                <div class="card-header text-dark">
                    <h6 class="fw-bold text-center heading_style">Last 7 Days Attendance Report</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xxl-12 col-md-12 table-responsive">
                            <table class="table general_table_style padding-y-10">
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
                                        foreach ($last7DaysResponses as $res) { ?>
                                            <tr>
                                                <td><?= $sl++ ?></td>
                                                <td class="fw-bold"><?= $res['name'] ?></td>
                                                <?php
                                                $reports = $res['reports'];
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
                                                
                                                    $comparison_time = "10:00";
                                                ?>
                                                    <td>
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
                                                <?php 
                                                } 
                                                ?>
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
        </div>
        <!-- End Left side columns -->
        
    </div>
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" id="modalBody1">
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog wide-modal modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" id="modalBody2">
            </div>
        </div>
    </div>

    <!--Present Modal -->
    <div class="modal fade" id="presentModal" tabindex="-1" aria-labelledby="presentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="presentModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...1
                </div>
            </div>
        </div>
    </div>
    <!--Absent Modal -->
    <div class="modal fade" id="AbsentModal" tabindex="-1" aria-labelledby="AbsentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AbsentModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...2
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function punchin(userId, name, date, punchIn) {
        $('#modalBody1').html('');
        $.ajax({
            url: '<?php echo base_url('admin/PunchInRecords'); ?>',
            type: 'GET',
            data: {
                userId: userId,
                name: name,
                date: date,
                punchIn : punchIn
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
                effort_time : effort_time
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