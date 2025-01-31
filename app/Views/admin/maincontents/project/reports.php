<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/css/bootstrap-select.css" />


<style type="text/css">
    #myChart,
    #myChart2{
        background: #fff;
    }
    .options {
        padding: 20px;
        background-color: rgba(191, 191, 191, 0.15);
        margin-top: 20px;
    }

    .option {
        margin-top: 10px;
    }

    .caption {
        font-size: 18px;
        font-weight: 500;
    }

    .option>span {
        margin-right: 10px;
    }

    .option>.dx-widget {
        display: inline-block;
        vertical-align: middle;
    }

    .h-50 {
        width: 100% !important;
        height: 50% !important;
    }
    table { page-break-inside:auto; }
    tr    { page-break-inside:auto; }

    @media(max-width: 767px) {
        .h-50 {
            width: 100% !important;
            height: 100% !important;
        }
    }
    .dropdown-menu .dropdown-item:hover{
        color: #fff;
        background: #0d6efd;
    }
    .dropdown-toggle {
        /* top: 5px; */
    }
    .dropdown.bootstrap-select{
        /* height: 37px */
    }
    
</style>
<section class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="pagetitle">
                <h1><?= $page_header ?></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $page_header ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <?php if (session('success_message')) { ?>
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message custom-alert" role="alert">
                        <?= session('success_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php if (session('error_message')) { ?>
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message custom-alert" role="alert">
                        <?= session('error_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
            </div>
            
            <div class="col-lg-12">
                <div class="card table-card">
                    <div class="card-header">
                        <div style="display: inline-flex;gap: 10px;width: 100%; background: #fff; border-radius: 8px">
                                <select class="selectpicker" onchange="selectProject(this.value)" data-show-subtext="true" data-live-search="true">
                                    <optgroup label="">
                                    <?php if ($all_projects) {
                                        
                                        foreach ($all_projects as $all_project) { ?>
                                            <option <?= ($all_project->id == $project->id) ? 'selected' : '' ?> value="<?= base64_encode($all_project->id); ?>"><?= $all_project->name; ?> (<?= $all_project->project_status_name; ?>)</option>
                                    <?php }
                                    } ?>
                                    </optgroup>                                        
                                    <optgroup label="">
                                    <?php if ($all_projects) {
                                        
                                        foreach ($all_closed_projects as $all_closed_project) { ?>
                                            <option <?= ($all_closed_project->id == $project->id) ? 'selected' : '' ?> value="<?= base64_encode($all_closed_project->id); ?>"><?= $all_closed_project->name; ?> (<?= $all_closed_project->project_status_name; ?>)</option>
                                    <?php }
                                    } ?>
                                    </optgroup>
                                </select>
                                <button class="btn btn-info btn-sm font-12">
                                    <?php
                                    $dateString = $project->start_date;
                                    $timestamp = strtotime($dateString);
                                    $formattedDate = date('l, F j, Y', $timestamp);
                                    echo 'Started: ' . $formattedDate;
                                    ?>
                                </button>
                            <?php if ($project->project_time_type == 'Onetime') {  ?>
                                <button class="btn btn-success btn-sm font-12"> Fixed: <?= $project->hour . ' Hours' ?></button>
                            <?php   } else {  ?>
                                <button class="btn btn-success"> Monthly: <?= $project->hour_month . ' Hours' ?></button>
                            <?php } ?>
                            <a href="javascript: void(0)" style="font-size: 14px; background-color: #dcf5dc; padding: 4px; margin: 0px; text-align: center; padding: 5px; border-radius: 5px; background: #dcf5dc; margin-left: auto; float: right; text-transform: capitalize; display: flex; align-items: center"><?= $project->name; ?></a>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $db = \Config\Database::connect();
                        $sql50      = "SELECT timesheet.* FROM timesheet WHERE timesheet.project_id = " . $id . " AND timesheet.date_added BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND CURDATE()";
                        $result     = $db->query($sql50)->getResult();
                        if (!empty($result)) {
                        ?>
                            <div class="">
                                <!-- <div style="display: inline-flex;gap: 10px;width: 100%; background: #fff; border-radius: 8px">
                                    <select class="selectpicker" onchange="selectProject(this.value)" data-show-subtext="true" data-live-search="true">
                                        <optgroup label="">
                                        <?php if ($all_projects) {
                                           
                                            foreach ($all_projects as $all_project) { ?>
                                                <option <?= ($all_project->id == $project->id) ? 'selected' : '' ?> value="<?= base64_encode($all_project->id); ?>"><?= $all_project->name; ?> (<?= $all_project->project_status_name; ?>)</option>
                                        <?php }
                                        } ?>
                                        </optgroup>                                        
                                        <optgroup label="">
                                        <?php if ($all_projects) {
                                           
                                           foreach ($all_closed_projects as $all_closed_project) { ?>
                                               <option <?= ($all_closed_project->id == $project->id) ? 'selected' : '' ?> value="<?= base64_encode($all_closed_project->id); ?>"><?= $all_closed_project->name; ?> (<?= $all_closed_project->project_status_name; ?>)</option>
                                       <?php }
                                       } ?>
                                       </optgroup>
                                    </select>
                                    <h1><button class="btn btn-info btn-sm font-12">
                                            <?php
                                            $dateString = $project->start_date;
                                            $timestamp = strtotime($dateString);
                                            $formattedDate = date('l, F j, Y', $timestamp);
                                            echo 'Started: ' . $formattedDate;
                                            ?>
                                        </button>
                                    </h1>
                                    <?php if ($project->project_time_type == 'Onetime') {  ?>
                                        <h1><button class="btn btn-success btn-sm font-12"> Fixed: <?= $project->hour . ' Hours' ?></button></h1>
                                    <?php   } else {  ?>
                                        <h1><button class="btn btn-success"> Monthly: <?= $project->hour_month . ' Hours' ?></button></h1>
                                    <?php } ?>
                                    <h3 style="font-size: 15px; background-color: #dcf5dc; padding: 4px; margin: 0px; text-align: center; padding: 5px; border-radius: 5px; background: #dcf5dc; margin-left: auto; float: right;"><?= $project->name; ?></h3>
                                    
                                </div> -->
                                <div class="">
                                    <h4 style="margin: 20px 0;text-align: center;padding: 8px;border-radius: 8px;background: #dcf5dc;"><b>Total Hours Report Last 12 Months</b></h4>
                                    <div id="chartContainer"  style="width: 100%; height: 200px; background-color: transparent !important;"></div>
                                    <div class="table-responsive mt-2">
                                        <table class="table general_table_style padding-y-10">
                                            <thead>
                                                <tr>
                                                    <?php if ($months) {
                                                        foreach ($months as $month) {  ?>
                                                            <th scope="col"><?= $month; ?></th>
                                                    <?php }
                                                    } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php if ($eachMonthHour) {
                                                        // pr($eachMonthHour);
                                                        foreach ($eachMonthHour as $index => $row) {
                                                            ?>
                                                            <td>
                                                                <?php
                                                                $totHours           = $row[0]->hours;
                                                                $minutes            = $row[0]->mins;
                                                                $total_hours_worked = intval($row[0]->total_hours_worked);

                                                                $hours              = floor($minutes / 60);
                                                                $remainingMinutes   = $minutes % 60;
                                                                $totalHours         = $totHours + $hours;
                                                                // echo '<img src="' . base_url('public/uploads/tracker-icon.webp') . '" alt="" class="tracker-icon">' ($totalHours > 0 || $remainingMinutes > 0) ? '<b>' . $totalHours  . ':' . $remainingMinutes . '</b>'  : '' . $totalHours  . ':' . $remainingMinutes . '';
                                                                echo '<img src="' . base_url('public/uploads/tracker-icon.webp') . '" alt="" class="tracker-icon">';
                                                                echo ($totalHours > 0 || $remainingMinutes > 0) ? '<b>' . $totalHours . ':' . $remainingMinutes . '</b>' : $totalHours . ':' . $remainingMinutes;
                                                               ?>  <?php 
                                                                $sql                = "SELECT is_project_cost FROM `application_settings`";                   
                                                                $project_cost               = $db->query($sql)->getRow();
                                                                if($project_cost->is_project_cost == 1){ ?>
                                                                    <br>
                                                                  <?php  
                                                                  echo '<i class="fa-solid fa-indian-rupee-sign" style="width: 15px;margin-left: 3px;"></i> ';
                                                                  echo ($total_hours_worked > 0 ) ? '<b>' . number_format($total_hours_worked) . '</b>'  : '' . number_format($total_hours_worked) . '';
                                                                //   echo 'average cost: '.$totalWorkedHours;
                                                                }                                                               
                                                                $processedData[] = [
                                                                    'month' => $months[$index],
                                                                    'totalHours' => $totalHours,
                                                                    'remainingMinutes' => $remainingMinutes,
                                                                ];
                                                                ?>
                                                            </td>
                                                        <?php }?>                                                        
                                                   <?php } else {    ?>
                                                        <th>
                                                            <?= 'Not found'; ?>
                                                        </th>
                                                    <?php } ?>
                                                </tr>                                                
                                            </tbody>
                                        </table>
                                        <?php pr($monthcountrows);?>
                                        <button class="btn btn-success"> <?php echo 'Average cost: '.number_format($totalWorkedHours / 12, 2); ?></button>                                        
                                    </div>
                                    <h4 style="margin: 20px 0;text-align: center;padding: 8px;border-radius: 8px;background: #dcf5dc;"><b>Total Hours Report (Effort-wise) Last 12 Months</b></h4>
                                    <canvas id="myChart" class="h-50"></canvas>
                                    <div class="table-responsive mt-2">
                                        <table class="table table-fit general_table_style  padding-y-10">
                                            <tr>
                                                <th>Effort Type</th>
                                                <?php if ($months) {
                                                    foreach ($months as $month) {  ?>
                                                        <th scope="col"><?= $month; ?></th>
                                                <?php }
                                                } ?>
                                            </tr>
                                            <?php
                                            $chartData = [];
                                            if ($effortTypes) {
                                                foreach ($effortTypes as $effortType) {
                                                    //  pr($effortType);
                                                    $effortTypeData = [
                                                        'label' => htmlspecialchars($effortType->name),
                                                        'data' => [],
                                                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                                                        'borderColor' => 'rgba(75, 192, 192, 1)',
                                                        'borderWidth' => 1
                                                    ];
                                            ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($effortType->name); ?></td>
                                                        <?php if ($numeric_dates) {
                                                            foreach ($numeric_dates as $numeric_date) { ?>
                                                                <td>
                                                                    <?php
                                                                    $db = \Config\Database::connect();
                                                                    $sql                = "SELECT SUM(hour) as hours,SUM(min) as mins FROM `timesheet` WHERE `effort_type`=" . $effortType->effort_type_id . " AND `date_added` LIKE '%" . $numeric_date . "%' and project_id=" . $id . "";
                                                                    $rowresult          = $db->query($sql)->getResult();
                                                                    $totHours           = $rowresult[0]->hours;
                                                                    $minutes            = $rowresult[0]->mins;

                                                                    $hours              = floor($minutes / 60);
                                                                    $remainingMinutes   = $minutes % 60;
                                                                    $totalHours         = $totHours + $hours;
                                                                    echo '<img src="' . base_url('public/uploads/tracker-icon.webp') . '" alt="" class="tracker-icon">';
                                                                    echo ($totalHours > 0 || $remainingMinutes > 0) ? '<b>' . $totalHours  . ':' . $remainingMinutes . '</b>'  : '' . $totalHours  . ':' . $remainingMinutes . '';
                                                                    $effortTypeData['data'][] = $totalHours;
                                                                    ?>
                                                                </td>
                                                        <?php }
                                                            $chartData[] = $effortTypeData;
                                                        } ?>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </div>
                                    <h4 style="margin: 20px 0;text-align: center;padding: 8px;border-radius: 8px;background: #dcf5dc;"><b>Total Hours Report (User-wise) Last 12 Months</b></h4>
                                    <canvas id="myChart2" class="h-50"></canvas>
                                    <div class="table-responsive mt-2">
                                        <table class="table  padding-y-10 general_table_style">
                                            <tr>
                                                <th>Users </th>
                                                <?php if ($months) {
                                                    foreach ($months as $month) {  ?>
                                                        <th scope="col"><?= $month; ?></th>
                                                <?php }
                                                } ?>
                                            </tr>
                                            <?php
                                            if ($usersData) {
                                                foreach ($usersData as $user) {
                                                    $userWiseData = [
                                                        'label' => htmlspecialchars($user->name),
                                                        'data' => [],
                                                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                                                        'borderColor' => 'rgba(75, 192, 192, 1)',
                                                        'borderWidth' => 1
                                                    ];
                                            ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($user->name); ?></td>
                                                        <?php if ($numeric_dates) {
                                                            foreach ($numeric_dates as $numeric_date) { ?>
                                                                <td>
                                                                    <?php
                                                                    $db = \Config\Database::connect();
                                                                    $sql                = "SELECT SUM(hour) as hours,SUM(min) as mins FROM `timesheet` WHERE `user_id`=" . $user->user_id . " AND `date_added` LIKE '%" . $numeric_date . "%' and project_id=" . $id . "";
                                                                    $rowresult          = $db->query($sql)->getResult();
                                                                    $totHours           = $rowresult[0]->hours;
                                                                    $minutes            = $rowresult[0]->mins;

                                                                    $hours              = floor($minutes / 60);
                                                                    $remainingMinutes   = $minutes % 60;
                                                                    $totalHours         = $totHours + $hours;
                                                                    echo '<img src="' . base_url('public/uploads/tracker-icon.webp') . '" alt="" class="tracker-icon">';
                                                                    echo ($totalHours > 0 || $remainingMinutes > 0) ? '<b>' . $totalHours  . ':' . $remainingMinutes . '</b>'  : '' . $totalHours  . ':' . $remainingMinutes . '';
                                                                    $userWiseData['data'][] = $totalHours;
                                                                    ?>
                                                                </td>
                                                        <?php }
                                                            $chartData2[] = $userWiseData;
                                                        } ?>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php   } else {  ?>
                            <h4 style="color: red;text-align:center;padding: 30px;">The last 12 months have not seen any activity from this project !!!</h4>
                        <?php  }  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/js/bootstrap-select.js"></script>
<?php if (!empty($result)) { ?>
    <script>
        var processedData = <?php echo json_encode($processedData); ?>;
        var dataPoints = [];
        var trendLineDataPoints = [];
        var sumX = 0,
            sumY = 0,
            sumXY = 0,
            sumXX = 0;
        var n = processedData.length;

        for (var i = 0; i < processedData.length; i++) {
            var month = processedData[i].month;
            var totalHours = processedData[i].totalHours;
            dataPoints.push({
                label: month,
                y: totalHours
            });

            var x = i + 1;
            var y = totalHours;
            sumX += x;
            sumY += y;
            sumXY += x * y;
            sumXX += x * x;
        }

        var m = (n * sumXY - sumX * sumY) / (n * sumXX - sumX * sumX);
        var b = (sumY - m * sumX) / n;

        for (var i = 0; i < processedData.length; i++) {
            var x = i + 1;
            var y = m * x + b;
            trendLineDataPoints.push({
                label: processedData[i].month,
                y: y
            });
        }

        window.onload = function() {
            var options = {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Total Hours"
                },
                axisX: {
                    valueFormatString: "DD MMM"
                },
                axisY: {
                    title: "Hours",
                    suffix: " H",
                    minimum: 1
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "bottom",
                    horizontalAlign: "left",
                    dockInsidePlotArea: true,
                    itemclick: toogleDataSeries
                },
                data: [{
                        type: "line",
                        showInLegend: true,
                        name: "Monthly Hours",
                        markerType: "circle",
                        xValueFormatString: "DD MMM, YYYY",
                        color: "#F08080",
                        yValueFormatString: "#,##0H",
                        dataPoints: dataPoints
                    },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "Trend Line",
                        lineDashType: "dash",
                        markerType: "none",
                        color: "#6B8E23",
                        dataPoints: trendLineDataPoints
                    }
                ]
            };
            $("#chartContainer").CanvasJSChart(options);

            function toogleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                e.chart.render();
            }
        }
    </script>
    <script>
        const chartData = <?php echo json_encode($chartData); ?>;
        const labels = <?php echo json_encode($months); ?>;
        const colors = [
            'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)',
            'rgba(199, 199, 199, 0.2)', 'rgba(83, 102, 255, 0.2)', 'rgba(99, 255, 132, 0.2)',
            'rgba(162, 54, 235, 0.2)', 'rgba(206, 255, 86, 0.2)', 'rgba(192, 75, 75, 0.2)',
            'rgba(102, 153, 255, 0.2)', 'rgba(159, 255, 64, 0.2)', 'rgba(199, 83, 199, 0.2)',
            'rgba(255, 102, 83, 0.2)', 'rgba(99, 132, 255, 0.2)', 'rgba(54, 162, 255, 0.2)',
            'rgba(86, 255, 206, 0.2)', 'rgba(192, 75, 192, 0.2)'
        ];
        const borderColors = [
            'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
            'rgba(199, 199, 199, 1)', 'rgba(83, 102, 255, 1)', 'rgba(99, 255, 132, 1)',
            'rgba(162, 54, 235, 1)', 'rgba(206, 255, 86, 1)', 'rgba(192, 75, 75, 1)',
            'rgba(102, 153, 255, 1)', 'rgba(159, 255, 64, 1)', 'rgba(199, 83, 199, 1)',
            'rgba(255, 102, 83, 1)', 'rgba(99, 132, 255, 1)', 'rgba(54, 162, 255, 1)',
            'rgba(86, 255, 206, 1)', 'rgba(192, 75, 192, 1)'
        ];

        const datasets = chartData.map((data, index) => ({
            label: data.label,
            data: data.data,
            backgroundColor: colors[index % colors.length],
            borderColor: borderColors[index % borderColors.length],
            borderWidth: 3,
            fill: false
        }));

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Effort Types vs. Total Hours'
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Numeric Dates'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Total Hours'
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const chartData2 = <?php echo json_encode($chartData2); ?>;
        const labels2 = <?php echo json_encode($months); ?>;
        const colors2 = [
            'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)',
            'rgba(199, 199, 199, 0.2)', 'rgba(83, 102, 255, 0.2)', 'rgba(99, 255, 132, 0.2)',
            'rgba(162, 54, 235, 0.2)', 'rgba(206, 255, 86, 0.2)', 'rgba(192, 75, 75, 0.2)',
            'rgba(102, 153, 255, 0.2)', 'rgba(159, 255, 64, 0.2)', 'rgba(199, 83, 199, 0.2)',
            'rgba(255, 102, 83, 0.2)', 'rgba(99, 132, 255, 0.2)', 'rgba(54, 162, 255, 0.2)',
            'rgba(86, 255, 206, 0.2)', 'rgba(192, 75, 192, 0.2)'
        ];
        const borderColors2 = [
            'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
            'rgba(199, 199, 199, 1)', 'rgba(83, 102, 255, 1)', 'rgba(99, 255, 132, 1)',
            'rgba(162, 54, 235, 1)', 'rgba(206, 255, 86, 1)', 'rgba(192, 75, 75, 1)',
            'rgba(102, 153, 255, 1)', 'rgba(159, 255, 64, 1)', 'rgba(199, 83, 199, 1)',
            'rgba(255, 102, 83, 1)', 'rgba(99, 132, 255, 1)', 'rgba(54, 162, 255, 1)',
            'rgba(86, 255, 206, 1)', 'rgba(192, 75, 192, 1)'
        ];

        const datasets2 = chartData2.map((data, index) => ({
            label: data.label,
            data: data.data,
            backgroundColor: colors[index % colors2.length],
            borderColor: borderColors[index % borderColors2.length],
            borderWidth: 3,
            fill: false
        }));

        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: labels2,
                datasets: datasets2
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Users vs. Total Hours'
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Users'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Total Hours'
                        }
                    }
                }
            }
        });
    </script>
    <script>
        function selectProject(val) {
            var url = '<?= base_url('admin/projects/reports/') ?>' + val;
            window.open(url, '_blank');
        }
    </script>
<?php } ?>