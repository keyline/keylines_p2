<?php
$user               = $session->user_type;
// pr($user);
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
            <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="GET" action="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="advance_search">
                        <div class="row mb-3 align-items-center">
                            <?php if($user == 'admin') { ?>
                            <div class="col-md-3 col-lg-3">
                                <label for="search_user_id">User</label>
                                <select name="search_user_id" class="form-control" id="search_user_id" required>
                                    <option value="all" <?=(($search_user_id == 'all')?'selected':'')?>>All</option>
                                    <hr>
                                    <?php if($users){ foreach($users as $row){?>
                                        <option value="<?=$row->id?>" <?=(($search_user_id == $row->id)?'selected':'')?>><?=$row->name?> - <?=(($row->status == '1')?'Active':'Deactive')?></option>
                                        <hr>
                                    <?php } }?>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="col-md-3 col-lg-3">
                                <label for="search_project_id">Project</label>
                                <?php if($user != 'admin') { ?>
                                    <input type="hidden" name="search_user_id" value="all" id="search_user_id">
                                <?php } ?>
                                <select name="search_project_id" class="form-control" id="search_project_id" required>
                                    <?php if($user == 'admin') {?>
                                    <option value="all" <?=(($search_project_id == 'all')?'selected':'')?>>All</option>
                                    <?php } ?>
                                    <hr>
                                    <?php if($projects){ foreach($projects as $row){?>
                                        <option value="<?=$row->id?>" <?=(($search_project_id == $row->id)?'selected':'')?>><?=$row->name?> (<?=$row->client_name?>) - <?=$row->project_status_name?></option>
                                        <hr>
                                    <?php } }?>
                                    <?php if($closed_projects){ foreach($closed_projects as $row2){?>
                                        <option value="<?=$row2->id?>" <?=(($search_project_id == $row2->id)?'selected':'')?>><?=$row2->name?> (<?=$row2->client_name?>) - <?=$row2->project_status_name?></option>
                                        <hr>
                                    <?php } }?>
                                </select>
                            </div>
                            <div class="col-md-3 col-lg-3" id="day_type_row" style="display: <?=(($is_date_range == 1)?'none':'block')?>;">
                                <label for="search_day_id">Days</label>
                                <select name="search_day_id" class="form-control" id="search_day_id" required>
                                    <option value="all" <?=(($search_day_id == 'all')?'selected':'')?>>All</option>
                                    <hr>
                                    <option value="today" <?=(($search_day_id == 'today')?'selected':'')?>>Today</option>
                                    <hr>
                                    <option value="yesterday" <?=(($search_day_id == 'yesterday')?'selected':'')?>>Yesterday</option>
                                    <hr>
                                    <option value="this_week" <?=(($search_day_id == 'this_week')?'selected':'')?>>This Week</option>
                                    <hr>
                                    <option value="last_week" <?=(($search_day_id == 'last_week')?'selected':'')?>>Last Week</option>
                                    <hr>
                                    <option value="this_month" <?=(($search_day_id == 'this_month')?'selected':'')?>>This Month</option>
                                    <hr>
                                    <option value="last_month" <?=(($search_day_id == 'last_month')?'selected':'')?>>Last Month</option>
                                    <hr>
                                    <option value="last_7_days" <?=(($search_day_id == 'last_7_days')?'selected':'')?>>Last 7 Days</option>
                                    <hr>
                                    <option value="last_30_days" <?=(($search_day_id == 'last_30_days')?'selected':'')?>>Last 30 Days</option>
                                    <hr>
                                </select>
                            </div>
                            <div class="col-md-2 col-lg-2" style="margin-top: 18px;">
                                <label for="is_date_range">Date Range</label>
                                <input type="checkbox" id="is_date_range" name="is_date_range" <?=(($is_date_range == 1)?'checked':'')?>>
                            </div>
                            <div class="col-md-4 col-lg-4" id="day_range_row" style="display: <?=(($is_date_range == 1)?'block':'none')?>; margin-top: 18px;">
                                <div class="input-group input-daterange">
                                    <!-- <label for="search_range_from">Date Range</label> -->
                                    <input type="date" id="search_range_from" name="search_range_from" class="form-control" value="<?=$search_range_from?>" style="height: 40px;">
                                    <span class="input-group-text">To</span>
                                    <input type="date" id="search_range_to" name="search_range_to" class="form-control" value="<?=$search_range_to?>" max="<?=date('Y-m-d')?>" style="height: 40px;">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                            <?php if(!empty($response)){?>
                                <a href="<?=base_url('admin/reports/advance-search')?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                            <?php }?>
                        </div>
                    </form>
                </div>
            </div>
            <?php if(!empty($response)){
                // pr($response);
                ?>
                 <div class="card mt-3">
                    <div class="card-body pt-3">
                        <?php
                        // $totHour    = 0;
                        // $totMinute  = 0;
                        // foreach($response as $res){
                        //     $totHour    += $res['hour'];
                        //     $totMinute  += $res['min'];
                        // }
                        // $totalMinutes = ($totHour * 60) + $totMinute;
                        $totalBooked = intdiv($total_effort_in_mins, 60).' Hours '. ($total_effort_in_mins % 60).' Minutes';;
                        ?>
                        <h4 class="alert alert-warning fw-bold"><i class="fa fa-clock"></i> Total Effort : <?=$totalBooked?></h4>
                    </div>
                </div> 
                <div class="card mt-3">
                    <div class="card-body pt-3">
                        <h6 class="alert alert-success"><?=count($response)?> result(s) found</h6>
                        <!-- <h5>
                            <a target="_blank" href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/download_csv" class="btn btn-success">Downlaod CSV</a>
                        </h5> -->
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table table-bordered table-striped general_table_style">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="15%">Project</th>
                                        <th width="15%">User</th>
                                        <th width="10%">Work Date</th>
                                        <th width="7%">Time</th>
                                        <th width="30%">Description</th>
                                        <th width="15%">Type</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totHour    = 0;
                                    $totMinute  = 0;
                                    $totalUsers = [];
                                    $totalTypes = [];
                                    foreach($response as $res){?>
                                        <tr>
                                            <td><?=$res['sl_no']?></td>
                                            <td><?=$res['project_name']?></td>
                                            <td><?=$res['user_name']?></td>
                                            <td><?=$res['work_date']?></td>
                                            <td><?=$res['effort_time']?></td>
                                            <td><?=$res['description']?></td>
                                            <td><?=$res['effort_type']?><br><small>(<?=$res['project_status']?>)</small></td>
                                            <td>
                                                <a target="_blank" href="<?=base_url('admin/efforts/edit/'.encoded($res['id']))?>" title="Edit Effort" onclick="return confirm('Do you want to edit this effort ?');"><i class="fa fa-pencil text-primary"></i></a>
                                                <br><br>
                                                <?php
                                                $userType           = $session->user_type;
                                                if($userType == 'admin'){
                                                ?>
                                                    <a href="<?=base_url('admin/efforts/delete/'.encoded($res['id']))?>" title="Delete Effort" onclick="return confirm('Do you want to delete this effort from list ?');"><i class="fa fa-trash text-danger"></i></a>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php
                                        // $totHour    += $res['hour'];
                                        // $totMinute  += $res['min'];
                                        ?>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body pt-3">
                        <?php
                        // $totalMinutes = ($totHour * 60) + $totMinute;
                        $totalBooked = intdiv($total_effort_in_mins, 60).' Hours '. ($total_effort_in_mins % 60).' Minutes';;
                        ?>
                        <h4 class="alert alert-warning fw-bold"><i class="fa fa-clock"></i> Total Effort : <?=$totalBooked?></h4>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="charts">
                                    <h6 class="fw-bold">User Wise Chart</h6>
                                    <!-- Bar Chart -->
                                    <div id="barChartUserWise"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                          new ApexCharts(document.querySelector("#barChartUserWise"), {
                                            series: [{
                                              data: [<?=implode(",", $graph_user_data)?>]
                                            }],
                                            chart: {
                                              type: 'bar',
                                              height: 500
                                            },
                                            plotOptions: {
                                              bar: {
                                                borderRadius: 4,
                                                horizontal: true,
                                              }
                                            },
                                            dataLabels: {
                                              enabled: true
                                            },
                                            xaxis: {
                                              categories: [<?=implode(",", $graph_users)?>],
                                            },
                                            yaxis: {
                                              labels: {
                                                 maxWidth: 300
                                              }
                                            },
                                            colors: ["#f19620"]
                                          }).render();
                                        });
                                    </script>
                                    <!-- End Bar Chart -->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="charts">
                                    <h6 class="fw-bold">Type Wise Chart</h6>
                                    <!-- Bar Chart -->
                                    <div id="barChartTypeWise"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                          new ApexCharts(document.querySelector("#barChartTypeWise"), {
                                            series: [{
                                              data: [<?=implode(",", $graph_type_data)?>]
                                            }],
                                            chart: {
                                              type: 'bar',
                                              height: 500
                                            },
                                            plotOptions: {
                                              bar: {
                                                borderRadius: 4,
                                                horizontal: true,
                                              }
                                            },
                                            dataLabels: {
                                              enabled: true
                                            },
                                            xaxis: {
                                              categories: [<?=implode(",", $graph_types)?>],
                                            },
                                            yaxis: {
                                              labels: {
                                                 maxWidth: 300
                                              }
                                            },
                                            colors: ["#f19620"]
                                          }).render();
                                        });
                                    </script>
                                    <!-- End Bar Chart -->
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="charts">
                                    <h6 class="fw-bold">Project Wise Chart</h6>
                                    <!-- Bar Chart -->
                                    <div id="barChartProjectWise"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                          new ApexCharts(document.querySelector("#barChartProjectWise"), {
                                            series: [{
                                              data: [<?=implode(",", $graph_project_data)?>]
                                            }],
                                            chart: {
                                              type: 'bar',
                                              height: <?=$graph_projects_bar_height?>
                                            },
                                            plotOptions: {
                                              bar: {
                                                borderRadius: 4,
                                                horizontal: true,
                                              }
                                            },
                                            dataLabels: {
                                              enabled: true
                                            },
                                            xaxis: {
                                              categories: [<?=implode(",", $graph_projects)?>],
                                            },
                                            yaxis: {
                                              labels: {
                                                 maxWidth: 300
                                              }
                                            },
                                            colors: ["#f19620"]
                                          }).render();
                                        });
                                    </script>
                                    <!-- End Bar Chart -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $("#is_date_range").click(function() {
        if($(this).is(":checked")) {
            $("#day_range_row").show();
            $("#day_type_row").hide();
        } else {
            $("#day_range_row").hide();
            $("#day_type_row").show();
        }
    });
</script>