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
                                <div class="col-md-12 col-lg-12" id="day_type_row">
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
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card table-card" id="project-container">
                    <div class="row">
                        <div class="col md-6" style="padding: 12px;margin: 15px;margin-top:0px">
                            <div class="card-header card-header2">
                                <h6 class="heading_style text-center">ONGOING PROJECT</h6>
                            </div>
                            <div class="dt-responsive table-responsive">
                                <table class="table nowrap general_table_style padding-y-10" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">#</th>
                                            <th width="5%">Project</th>
                                            <th width="5%">Total Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($ongoingProjects) {
                                            $sl = 1;
                                            foreach ($ongoingProjects as $ongoingProject) { ?>
                                                <tr>
                                                    <th><?= $sl++; ?></th>
                                                    <th>
                                                        <?php if ($ongoingProject->project_time_type == 'Onetime') { ?>
                                                            <?= $ongoingProject->name; ?> <?= $ongoingProject->bill == 0 ? '<span class="badge bg-success">Billable</span>' : '<span class="badge bg-danger">Non-Billable</span>' ?><span class="badge bg-info">Fixed</span>
                                                        <?php } else {   ?>
                                                            <?= $ongoingProject->name; ?> <?= $ongoingProject->bill == 0 ? '<span class="badge bg-success">Billable</span>' : '<span class="badge bg-danger">Non-Billable</span>' ?><span class="badge bg-primary">Monthly</span>
                                                        <?php }     ?>
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
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col md-6" style="padding: 12px;margin: 15px;margin-top:0px">
                            <div class="card-header card-header2">
                                <h6 class="heading_style text-center">BILLABLE/NONBILLABLE HOURS</h6>
                            </div>
                            <div class="dt-responsive table-responsive">
                                <table class="table nowrap general_table_style padding-y-10" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">#</th>
                                            <th width="5%">Billable Hour</th>
                                            <th width="5%">Nonbillable Hour</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <th><?= $yesterdayAllUserHourBill; ?></th>
                                            <th><?= $yesterdayAllUserMinBill; ?></th>
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
</script>