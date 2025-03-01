<style type="text/css">
    #simpletable_filter {
        float: right;
    }

    .simpletable_length label {
        display: inline-flex;
        padding: 10px;
    }

    .charts {
        border: 1px solid #ff980073;
        padding: 10px;
    }

    .modal-dialog.wide-modal {
        max-width: 80%;
    }
</style>
<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
            <!-- <li class="breadcrumb-item active"><a href="<? //= base_url('admin/' . $controller_route . '/list/') 
                                                                ?>"><?= $title ?> List</a></li> -->
            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
    <?php if (checkModuleFunctionAccess(24, 43)) { ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3" style="margin-top: 20px;">
                        <form method="GET" action="" enctype="multipart/form-data">
                            <input type="hidden" name="mode" value="advance_search">
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-6 col-lg-6" id="day_type_row">
                                    <select name="search_day_id" class="form-control" onchange="dayWiseListGenerate(this.value)">
                                        <option value="today">Today</option>
                                        <hr>
                                        <option selected value="yesterday">Yesterday</option>
                                        <hr>
                                        <option value="this_week">This Week</option>
                                        <hr>
                                        <option value="last_week">Last Week</option>
                                        <hr>
                                        <option value="this_month">This Month</option>
                                        <hr>
                                        <option value="last_month">Last Month</option>
                                        <hr>
                                        <option value="last_7_days">Last 7 Days</option>
                                        <hr>
                                        <option value="last_30_days">Last 30 Days</option>
                                        <hr>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-6 input-group input-daterange">
                                    <!-- <label for="search_range_from">Date Range</label> -->
                                    <input type="date" id="search_range_from" name="search_range_from" class="form-control" value="" style="height: 40px;">
                                    <span class="input-group-text">To</span>
                                    <input type="date" id="search_range_to" name="search_range_to" class="form-control" value="" style="height: 40px;">
                                </div>
                                <button type="button" id="searchBtn" class="btn btn-primary mt-2">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php $yesterday          = date('Y-m-d', strtotime('-1 day'));?>
                <div class="card table-card" id="project-container">
                    <div class="row">
                        <div class="col md-6">
                            <div class="card-header card-header2">
                                <h6 class="heading_style text-center">
                                    ONGOING PROJECT
                                    <button type="button" class="btn btn-primary btn-sm" onclick="printDiv();"><i class="fa fa-print"></i></button>
                                </h6>
                            </div>
                            <div class="dt-responsive table-responsive" id="DivIdToPrint">
                                <table class="table nowrap general_table_style padding-y-10" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3">From Date : <u><?=date_format(date_create($yesterday), "M d, Y")?></u></th>
                                            <th colspan="3">To Date : <u><?=date_format(date_create($yesterday), "M d, Y")?></u></th>
                                        </tr>
                                        <!-- <caption>
                                            From Date: <u><?=date_format(date_create($yesterday), "M d, Y")?></u> | 
                                            To Date: <u><?=date_format(date_create($yesterday), "M d, Y")?></u>
                                        </caption> -->
                                        <tr>
                                            <th width="1%">#</th>
                                            <th width="5%">Project</th>
                                            <th width="5%">Project Status</th>
                                            <th width="5%">Total Time</th>
                                            <th width="5%">Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $start_date_array   = explode("-", $yesterday);
                                        $last_month_year    = $start_date_array[0];
                                        $last_month_month   = $start_date_array[1];
                                        $last_month_date    = $start_date_array[1];
                                        ?>
                                        <?php 
                                        if ($ongoingProjects) { $sl = 1; $total_cost = 0; $billable_cost=0; $non_billable_cost=0;   foreach ($ongoingProjects as $ongoingProject) { ?>
                                            <?php
                                            /* cost calculation */
                                                $project_cost   = 0;
                                                $date_added     = $yesterday;
                                                $cost_sql2      = "SELECT sum(cost) as total_cost FROM `timesheet` WHERE project_id=$ongoingProject->project_id AND date_added LIKE '%$date_added%'";
                                                $checkCost      = $db->query($cost_sql2)->getRow();
                                                $project_cost   = $checkCost->total_cost;
                                                $total_cost += $project_cost;
                                            /* cost calculation */
                                            ?>
                                            <tr>
                                                <th><?= $sl++; ?></th>
                                                <th>
                                                    <?php if ($ongoingProject->project_time_type == 'Onetime') { ?>
                                                        <?= $ongoingProject->name; ?> <a target="_blank" href="<?=base_url('admin/projects/reports/'. base64_encode($ongoingProject->project_id));?>"><i class="fa fa-file" style="margin-left: 5px;"></i></a>
                                                    <?php } else { ?>
                                                        <?= $ongoingProject->name; ?> <a target="_blank" href="<?=base_url('admin/projects/reports/'. base64_encode($ongoingProject->project_id));?>"><i class="fa fa-file" style="margin-left: 5px;"></i></a>
                                                    <?php } ?>
                                                    <?php
                                                    if ($ongoingProject->bill == 0) {
                                                        $billable_cost += $project_cost;
                                                    } else {
                                                        $non_billable_cost += $project_cost;
                                                    }
                                                    ?>
                                                </th>
                                                <th>
                                                    <?php if ($ongoingProject->project_time_type == 'Onetime') { ?>
                                                        <?= $ongoingProject->bill == 0 ? '<span class="badge bg-success">Billable</span>' : '<span class="badge bg-danger">Non-Billable</span>' ?><span class="badge bg-info">Fixed</span>
                                                    <?php } else { ?>
                                                        <?= $ongoingProject->bill == 0 ? '<span class="badge bg-success">Billable</span>' : '<span class="badge bg-danger">Non-Billable</span>' ?><span class="badge bg-primary">Monthly</span>
                                                    <?php } ?>
                                                </th>
                                                <?php
                                                $totalHours       = (int) $ongoingProject->total_hours;
                                                $totalMinutes     = (int) $ongoingProject->total_minutes;

                                                $additionalHours  = intdiv($totalMinutes, 60);
                                                $remainingMinutes = $totalMinutes % 60;

                                                $totalHours      += $additionalHours;

                                                $formattedTime    = sprintf("%d Hours %d Minutes", $totalHours, $remainingMinutes);
                                                // echo $formattedTime;
                                                ?>
                                                <th style="cursor: pointer;" onclick="showWorkList(<?= $ongoingProject->project_id ?>,'yesterday',<?= $ongoingProject->bill == 0 ? '0' : '1' ?>,'<?= $formattedTime ?>')"><?= $formattedTime; ?></th>
                                                <th><?=number_format($project_cost,2)?></th>
                                            </tr>
                                        <?php } ?>
                                            <tr>
                                                <th colspan="3" style="text-align:right; font-weight:bold;">Total</th>
                                                <!-- <th>-</th> -->
                                                <th><?=number_format($total_cost,2)?></th>
                                            </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col md-6">
                            <div class="card-header card-header2">
                                <h6 class="heading_style text-center">BILLABLE/NONBILLABLE HOURS</h6>
                            </div>
                            <div class="dt-responsive table-responsive">
                                <table class="table nowrap general_table_style padding-y-10" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">#</th>
                                            <th width="5%">Billable Hour<br>Billable Cost</th>
                                            <th width="5%">Nonbillable Hour<br>Nonbillable Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <th><?= $yesterdayAllUserHourBill; ?><br><?=number_format($billable_cost,2)?></th>
                                            <th><?= $yesterdayAllUserMinBill; ?><br><?=number_format($non_billable_cost,2)?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog wide-modal">
                <div class="modal-content" id="modalBody" style="height: 700px;overflow-y: scroll;">
                </div>
            </div>
        </div>
    <?php } ?>
</section>

<script>
    function dayWiseListGenerate(value) {
        console.log("Selected value: " + value);
        $.ajax({
            url: '<?= base_url('admin/reports/dayWiseListUpdate') ?>',
            type: 'GET',
            data: {
                day: value
            },
            success: function(response) {
                $('#project-container').html(response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }
    $(document).ready(function() {
        dayWiseListGenerate('yesterday');
    });
    function showWorkList(projectId, date, billable, hours) {
        $('#modalBody').html('');
        $.ajax({
            url: '<?php echo base_url('admin/reports/showWorkList'); ?>',
            type: 'GET',
            data: {
                projectId: projectId,
                billable: billable,
                hours: hours,
                date: date
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
    function printDiv()
    {
        var divToPrint=document.getElementById('DivIdToPrint');
        var newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();
        setTimeout(function(){newWin.close();},10);
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>