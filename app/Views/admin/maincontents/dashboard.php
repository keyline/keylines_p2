<?php
//die("dashboard");
$userType           = $session->user_type;
?>
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
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
                            <div class="col-xxl-3 col-md-6">
                                <div class="card info-card sales-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Users <span>| All Time</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-2">
                                                <h6><?= $total_users ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Companies Card -->

                            <!-- Plants Card -->
                            <div class="col-xxl-3 col-md-6">
                                <div class="card info-card revenue-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Active Users <span>| All Time</span></h5>
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
                            <div class="col-xxl-3 col-xl-12">
                                <div class="card info-card customers-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Inactive Users <span>| All Time</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-2">
                                                <h6><?= $total_inactive_users ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Vendors Card -->

                            <!-- Companies Card -->
                            <div class="col-xxl-3 col-md-6">
                                <div class="card info-card customers-card2">
                                    <div class="card-body">
                                        <h5 class="card-title">Project (Prospect/Active/Lost) <span>| All Time</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-2">
                                                <h6><?= $total_projects ?> <small>(<?= $total_prospect_projects ?>/<?= $total_active_projects ?>/<?= $total_lost_projects ?>)</small></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Companies Card -->

                            <!-- Plants Card -->
                            <div class="col-xxl-3 col-md-6">
                                <div class="card info-card customers-card3">
                                    <div class="card-body">
                                        <h5 class="card-title">Contacts (Lead) <span>| All Time</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-2">
                                                <h6><?= $total_clients ?> (<?= $total_clients_leads->count_lead ?>)</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Plants Card -->

                            <!-- Vendors Card -->
                            <div class="col-xxl-3 col-xl-12">
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
                            </div>
                            <!-- End Vendors Card -->

                        <?php   } ?>

                        <div class="col-md-12">
                            <?php if (checkModuleFunctionAccess(1, 66)) { ?>
                            <div class="card">
                                <div class="card-header text-dark bg-dark-info">
                                    <h6 class="fw-bold text-center heading_style">Tracker Report <span id="year"><?= date('Y') ?></span></h6>
                                </div>
                                <div class="card-body">
                                    <div class="rows">
                                        <div class="col-xxl-12 col-md-12 table-responsive">
                                            <table class="table table-bordered general_table_style">
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
                                                            //  pr($response);?>
                                                            <tr>
                                                                <td><?= $sl++ ?></td>
                                                                <td class="fw-bold"><?= $response['name'] ?></td>
                                                                <td class="text-center">
                                                                    <?php if ($response['jan_booked'] > 0) { ?><span class="badge <?= (($response['jan_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['jan_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['jan_desklog'] > 0) { ?><span class="badge" <?= (($response['jan_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['jan_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['feb_booked'] > 0) { ?><span class="badge <?= (($response['feb_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['feb_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['feb_desklog'] > 0) { ?><span class="badge" <?= (($response['feb_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['feb_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['mar_booked'] > 0) { ?><span class="badge <?= (($response['mar_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['mar_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['mar_desklog'] > 0) { ?><span class="badge" <?= (($response['mar_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['mar_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['apr_booked'] > 0) { ?><span class="badge <?= (($response['apr_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['apr_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['apr_desklog'] > 0) { ?><span class="badge" <?= (($response['apr_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['apr_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['may_booked'] > 0) { ?><span class="badge <?= (($response['may_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['may_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['may_desklog'] > 0) { ?><span class="badge" <?= (($response['may_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['may_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['jun_booked'] > 0) { ?><span class="badge <?= (($response['jun_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['jun_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['jun_desklog'] > 0) { ?><span class="badge" <?= (($response['jun_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['jun_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['jul_booked'] > 0) { ?><span class="badge <?= (($response['jul_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['jul_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['jul_desklog'] > 0) { ?><span class="badge" <?= (($response['jul_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['jul_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['aug_booked'] > 0) { ?><span class="badge <?= (($response['aug_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['aug_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['aug_desklog'] > 0) { ?><span class="badge" <?= (($response['aug_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['aug_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['sep_booked'] > 0) { ?><span class="badge <?= (($response['sep_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['sep_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['sep_desklog'] > 0) { ?><span class="badge" <?= (($response['sep_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['sep_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['oct_booked'] > 0) { ?><span class="badge <?= (($response['oct_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['oct_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['oct_desklog'] > 0) { ?><span class="badge" <?= (($response['oct_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['oct_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['nov_booked'] > 0) { ?><span class="badge <?= (($response['nov_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['nov_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['nov_desklog'] > 0) { ?><span class="badge" <?= (($response['nov_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['nov_desklog'] ?></span><?php } }?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($response['dec_booked'] > 0) { ?><span class="badge <?= (($response['dec_booked'] >= 172) ? 'bg-success' : 'bg-danger custom_bg') ?>">T: <?= $response['dec_booked'] ?></span><?php } ?><br>
                                                                    <?php if($response['deskloguser'] == 1) { if ($response['dec_desklog'] > 0) { ?><span class="badge" <?= (($response['dec_desklog'] >= 172) ? 'style="background-color: #29cb05;"' : 'style="background-color: #b70400;"') ?>>D: <?= $response['dec_desklog'] ?></span><?php } }?>
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
                            <div class="card">
                                <div class="card-header text-dark bg-dark-info">
                                    <h6 class="fw-bold text-center heading_style">Last 7 Days Attendance Report</h6>
                                </div>
                                <div class="card-body">
                                    <div class="rows">
                                        <div class="col-xxl-12 col-md-12 table-responsive">
                                            <table class="table table-bordered general_table_style general_table_style">
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
                                                        $sl = 1;
                                                        $counter = 0;
                                                        foreach ($last7DaysAttendance as $res) { ?>
                                                            <tr>
                                                                <td><?= $sl++ ?></td>
                                                                <td class="fw-bold"><?= $res['name'] ?></td>
                                                                <?php
                                                                $reports = $res['Attendancereports'];
                                                                foreach ($reports as $report) {
                                                                    $punchIn = $report['punchIn'];
                                                                    $punchOut = $report['punchOut'];
                                                                ?>
                                                                    <td class="text-center">
                                                                        <p onclick="punchin('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['punchIn'] ?>')"><?php if ($punchIn > 0) { ?><span class="badge <?= (($punchIn <= 10) ? 'bg-success' : 'bg-danger') ?>" style="cursor:pointer;">IN: <?= date('H:i', strtotime($punchIn)) ?></span> <?php } ?></p><br>
                                                                        <p onclick="punchout('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['punchOut'] ?>')"><?php if ($punchOut > 0) { ?><span class="badge" style="background-color: #29cb05;cursor:pointer;">OUT: <?= date('H:i', strtotime($punchOut)) ?></span> <?php } ?></p>
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
                            <div class="card">
                                <div class="card-header text-dark bg-dark-info">
                                    <h6 class="fw-bold text-center heading_style">Last 7 Days Report</h6>
                                </div>
                                <div class="card-body">
                                    <div class="rows">
                                        <div class="col-xxl-12 col-md-12 table-responsive">
                                            <table class="table table-bordered general_table_style">
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
                                                                    <td class="text-right" onclick="dayWiseList('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['booked_effort'] ?>')" <?php
                                                                                                                                                                                                                                    // if ($date_difference > 0 && $report['booked_effort'] != 0 && $report['booked_effort'] < 8) { 
                                                                                                                                                                                                                                    //     echo 'style="background-color: #f9d99d;cursor:pointer;"';
                                                                                                                                                                                                                                    // } elseif ($date_difference > 0 && $report['booked_effort'] != 0 && $report['booked_effort'] >= 8) {
                                                                                                                                                                                                                                    //     echo 'style="background-color: #f9d99d;cursor:pointer;"';
                                                                                                                                                                                                                                    // } elseif ($date_difference == 0 && $report['booked_effort'] != 0 && $report['booked_effort'] < 8) {
                                                                                                                                                                                                                                    //     echo 'style="background-color: #b5f1a8;cursor:pointer;"';
                                                                                                                                                                                                                                    // } elseif ($date_difference == 0 && $report['booked_effort'] != 0 && $report['booked_effort'] >= 8) {
                                                                                                                                                                                                                                    //     echo 'style="background-color: #b5f1a8;cursor:pointer;"';
                                                                                                                                                                                                                                    // }
                                                                                                                                                                                                                                    if ($date_difference == 0 && $report['booked_effort'] != 0) {
                                                                                                                                                                                                                                        echo 'style="background-color: #5bc164;cursor:pointer;"';
                                                                                                                                                                                                                                    } elseif ($date_difference > 1 && $report['booked_effort'] != 0) {
                                                                                                                                                                                                                                        echo 'style="background-color: #f9d99d;cursor:pointer;"';
                                                                                                                                                                                                                                    } elseif ($date_difference <= 1 && $report['booked_effort'] != 0) {
                                                                                                                                                                                                                                        echo 'style="background-color: #b5f1a8;cursor:pointer;"';
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                    ?>> <?php
                                                                                                                                                                                                                                        if ($date_difference != 0 && $report['booked_effort'] != 0 && $report['booked_effort'] < 8) {
                                                                                                                                                                                                                                            echo '<span class="badge badge-danger badge_circle"></span>';
                                                                                                                                                                                                                                        } elseif ($date_difference == 0 && $report['booked_effort'] != 0 && $report['booked_effort'] < 8) {
                                                                                                                                                                                                                                            echo '<span class="badge badge-danger badge_circle"></span>';
                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                        ?>
                                                                        T:
                                                                        <?= $report['booked_effort']  ?>
                                                                        <!-- ?= $date_difference  ?>  -->
                                                                        </br>
                                                                        <?php if($report['deskloguser'] == 1) { ?>
                                                                        D: <?= $report['desklog_time'] ?>
                                                                        <?php } ?>
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
                            <div class="card">
                                <div class="card-header  text-dark bg-dark-info">
                                    <h6 class="fw-bold text-center heading_style">ALL GRAPH</h6>
                                </div>
                                <div class="card-body">
                                    <div class="rows">
                                        <div class="col-xxl-12 col-md-12 table-responsive">
                                            <table class="table table-bordered general_table_style">
                                                <thead>
                                                    <tr>
                                                        <th>Yesterday</th>
                                                        <th>This Month</th>
                                                        <th>Last Month</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($AlluserGraph) {
                                                        foreach ($AlluserGraph as $res) { ?>
                                                            <tr>
                                                                <td>
                                                                    <?php if ($res['yesterdayAllUserHourBill'] != 0) { ?>
                                                                        <!-- Pie Chart -->
                                                                        <div id="pieChartWise"></div>
                                                                        <script>
                                                                            document.addEventListener("DOMContentLoaded", () => {
                                                                                var options = {
                                                                                    series: [<?= $res['yesterdayAllUserHourBill'] ?>, <?= $res['yesterdayAllUserMinBill'] ?>],
                                                                                    chart: {
                                                                                        width: 270,
                                                                                        type: 'pie',
                                                                                    },
                                                                                    fill: {
                                                                                        colors: ['#b5f1a8', '#ff2323']
                                                                                    },
                                                                                    dataLabels: {
                                                                                        enabled: true,
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
                                                                                    colors: ['#b5f1a8', '#ff2323'],
                                                                                    labels: ['Billable', 'Non-Billable'],
                                                                                    responsive: [{
                                                                                        breakpoint: 300,
                                                                                        options: {
                                                                                            chart: {
                                                                                                width: 100
                                                                                            },
                                                                                            legend: {
                                                                                                position: 'bottom'
                                                                                            }
                                                                                        }
                                                                                    }]
                                                                                };
                                                                                var chart = new ApexCharts(document.querySelector("#pieChartWise"), options);
                                                                                chart.render();
                                                                            });
                                                                        </script>
                                                                        <!-- End Pie Chart -->
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($res['thismonthAllUserHourBillUsr'] != 0) { ?>
                                                                        <!-- Pie Chart -->
                                                                        <div id="pieChartMonthWise"></div>
                                                                        <script>
                                                                            document.addEventListener("DOMContentLoaded", () => {
                                                                                var options = {
                                                                                    series: [<?= str_replace(",", "", $res['thismonthAllUserHourBillUsr']) ?>, <?= $res['thismonthAllUserMinBillUsr'] ?>],
                                                                                    chart: {
                                                                                        width: 270,
                                                                                        type: 'pie',
                                                                                    },
                                                                                    fill: {
                                                                                        colors: ['#b5f1a8', '#ff2323']
                                                                                    },
                                                                                    dataLabels: {
                                                                                        enabled: true,
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
                                                                                    colors: ['#b5f1a8', '#ff2323'],
                                                                                    labels: ['Billable', 'Non-Billable'],
                                                                                    responsive: [{
                                                                                        breakpoint: 300,
                                                                                        options: {
                                                                                            chart: {
                                                                                                width: 100
                                                                                            },
                                                                                            legend: {
                                                                                                position: 'bottom'
                                                                                            }
                                                                                        }
                                                                                    }]
                                                                                };
                                                                                var chart = new ApexCharts(document.querySelector("#pieChartMonthWise"), options);
                                                                                chart.render();
                                                                            });
                                                                        </script>
                                                                        <!-- End Pie Chart -->
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($res['thismonthAllUserHourBillUsr'] != 0) { ?>
                                                                        <!-- Pie Chart -->
                                                                        <div id="pieChartlmWise"></div>
                                                                        <script>
                                                                            document.addEventListener("DOMContentLoaded", () => {
                                                                                var options = {
                                                                                    series: [<?= str_replace(",", "", $res['lastmonthAllUserHourBillUsr']) ?>, <?= $res['lastmonthAllUserMinBillUsr'] ?>],
                                                                                    chart: {
                                                                                        width: 270,
                                                                                        type: 'pie',
                                                                                    },
                                                                                    fill: {
                                                                                        colors: ['#b5f1a8', '#ff2323']
                                                                                    },
                                                                                    dataLabels: {
                                                                                        enabled: true,
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
                                                                                    colors: ['#b5f1a8', '#ff2323'],
                                                                                    labels: ['Billable', 'Non-Billable'],
                                                                                    responsive: [{
                                                                                        breakpoint: 300,
                                                                                        options: {
                                                                                            chart: {
                                                                                                width: 100
                                                                                            },
                                                                                            legend: {
                                                                                                position: 'bottom'
                                                                                            }
                                                                                        }
                                                                                    }]
                                                                                };
                                                                                var chart = new ApexCharts(document.querySelector("#pieChartlmWise"), options);
                                                                                chart.render();
                                                                            });
                                                                        </script>
                                                                        <!-- End Pie Chart -->
                                                                    <?php } ?>
                                                                </td>

                                                            </tr>
                                                    <?php  }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if (checkModuleFunctionAccess(1, 72)) { ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-dark bg-dark-info">
                                    <h6 class="fw-bold text-center heading_style">USER GRAPH</h6>
                                </div>
                                <div class="card-body">
                                    <div class="rows">
                                        <div class="col-xxl-12 col-md-12 table-responsive">
                                            <table class="table table-bordered general_table_style">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Yesterday</th>
                                                        <th>This Month</th>
                                                        <th>Last Month</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($userGraph) {
                                                        $sl = 1;
                                                        $counter = 0;
                                                        foreach ($userGraph as $res) { ?>
                                                            <tr>
                                                                <td class="text-center"><?= $sl++ ?></td>
                                                                <td class="fw-bold"><?= $res['name'] ?></td>
                                                                <td>
                                                                    <?php if ($res['yesterdayHourBill'] != 0) { ?>
                                                                        <!-- Pie Chart -->
                                                                        <div id="pieChartWise<?= $res['id'] ?>"></div>
                                                                        <script>
                                                                            document.addEventListener("DOMContentLoaded", () => {
                                                                                var options = {
                                                                                    series: [<?= $res['yesterdayHourBill'] ?>, <?= $res['yesterdayMinBill'] ?>],
                                                                                    chart: {
                                                                                        width: 270,
                                                                                        type: 'pie',
                                                                                    },
                                                                                    fill: {
                                                                                        colors: ['#b5f1a8', '#ff2323']
                                                                                    },
                                                                                    dataLabels: {
                                                                                        enabled: true,
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
                                                                                    colors: ['#b5f1a8', '#ff2323'],
                                                                                    labels: ['Billable', 'Non-Billable'],
                                                                                    responsive: [{
                                                                                        breakpoint: 300,
                                                                                        options: {
                                                                                            chart: {
                                                                                                width: 100
                                                                                            },
                                                                                            legend: {
                                                                                                position: 'bottom'
                                                                                            }
                                                                                        }
                                                                                    }]
                                                                                };
                                                                                var chart = new ApexCharts(document.querySelector("#pieChartWise<?= $res['id'] ?>"), options);
                                                                                chart.render();
                                                                            });
                                                                        </script>
                                                                        <!-- End Pie Chart -->
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($res['thismonthHourBillUsr'] != 0) { ?>
                                                                        <!-- Pie Chart -->
                                                                        <div id="pieChartMonthWise<?= $res['id'] ?>"></div>
                                                                        <script>
                                                                            document.addEventListener("DOMContentLoaded", () => {
                                                                                var options = {
                                                                                    series: [<?= $res['thismonthHourBillUsr'] ?>, <?= $res['thismonthMinBillUsr'] ?>],
                                                                                    chart: {
                                                                                        width: 270,
                                                                                        type: 'pie',
                                                                                    },
                                                                                    dataLabels: {
                                                                                        enabled: true,
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
                                                                                    fill: {
                                                                                        colors: ['#b5f1a8', '#ff2323']
                                                                                    },
                                                                                    colors: ['#b5f1a8', '#ff2323'],
                                                                                    labels: ['Billable', 'Non-Billable'],
                                                                                    responsive: [{
                                                                                        breakpoint: 280,
                                                                                        options: {
                                                                                            chart: {
                                                                                                width: 100
                                                                                            },
                                                                                            legend: {
                                                                                                position: 'bottom'
                                                                                            }
                                                                                        }
                                                                                    }]
                                                                                };
                                                                                var chart = new ApexCharts(document.querySelector("#pieChartMonthWise<?= $res['id'] ?>"), options);
                                                                                chart.render();
                                                                            });
                                                                        </script>
                                                                        <!-- End Pie Chart -->
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($res['lastmonthHourBillUsr'] != 0) { ?>
                                                                        <!-- Pie Chart -->
                                                                        <div id="pieChartlmWise<?= $res['id'] ?>"></div>
                                                                        <script>
                                                                            document.addEventListener("DOMContentLoaded", () => {
                                                                                var options = {
                                                                                    series: [<?= $res['lastmonthHourBillUsr'] ?>, <?= $res['lastmonthMinBillUsr'] ?>],
                                                                                    chart: {
                                                                                        width: 270,
                                                                                        type: 'pie',
                                                                                    },
                                                                                    fill: {
                                                                                        colors: ['#b5f1a8', '#ff2323']
                                                                                    },
                                                                                    dataLabels: {
                                                                                        enabled: true,
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
                                                                                    colors: ['#b5f1a8', '#ff2323'],
                                                                                    labels: ['Billable', 'Non-Billable'],
                                                                                    responsive: [{
                                                                                        breakpoint: 280,
                                                                                        options: {
                                                                                            chart: {
                                                                                                width: 100
                                                                                            },
                                                                                            legend: {
                                                                                                position: 'bottom'
                                                                                            }
                                                                                        }
                                                                                    }]
                                                                                };
                                                                                var chart = new ApexCharts(document.querySelector("#pieChartlmWise<?= $res['id'] ?>"), options);
                                                                                chart.render();
                                                                            });
                                                                        </script>
                                                                        <!-- End Pie Chart -->
                                                                    <?php } ?>
                                                                </td>
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
                                        </span></h2>
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
                                        </span></h2>
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
                                    <table class="table table-bordered">
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
                                    <div class="text-center">
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
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable mx-auto wide-modal">
            <div class="modal-content" id="modalBody">
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mx-auto wide-modal">
            <div class="modal-content" id="modalBody1">
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mx-auto wide-modal">
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

    function punchin(userId, name, date, punchIn) {
        $('#modalBody1').html('');
        $.ajax({
            url: '<?php echo base_url('admin/PunchInRecords'); ?>',
            type: 'GET',
            data: {
                userId: userId,
                name: name,
                date: date,
                punchIn: punchIn
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