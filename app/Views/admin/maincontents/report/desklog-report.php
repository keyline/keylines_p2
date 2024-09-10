<?php
$user               = $session->user_type;
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
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
</style>
<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '/list/') ?>"><?= $title ?> List</a></li>
            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
    <?php if (checkModuleFunctionAccess(26, 49)) { ?>
        <div class="row">
            <div class="col-xl-12">
                <?php if (session('success_message')) { ?>
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('success_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php if (session('error_message')) { ?>
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('error_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                            <!-- <input type="hidden" name="mode" value="advance_search"> -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-6 col-lg-6">
                                    <label for="is_date_range">Date</label>
                                    <input type="date" id="is_date_range" name="is_date_range" class="form-control" value="<?= $is_date_range ?>" required>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i>Fetch Backlog Date From Desklog</button>                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <a href="<?= base_url('admin/reports/get-desklog-report') ?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to fetch data from desklog ?');">Fetch Current Date Date From Desklog</a>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="mode" value="advance_search">
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-6 col-lg-6">
                                    <label for="is_date_range">Date</label>
                                    <input type="date" id="is_date_range" name="is_date_range" class="form-control" value="<?= $is_date_range ?>" required>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                                        <?php if (!empty($dateWise)) { ?>
                                            <a href="<?= base_url('admin/reports/advance-search') ?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                if (!empty($dateWise)) { ?>
                    <div class="card table-card">
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table padding-y-10 general_table_style">
                                    <thead>
                                        <tr>
                                            <th width="3%">#</th>
                                            <th>Desklog Usrid</th>
                                            <th>Tracker User Id</th>
                                            <th>Email</th>
                                            <th>Arrival At</th>
                                            <th>Left At</th>
                                            <th>Time At Work</th>
                                            <th>Productive Time</th>
                                            <th>Idle Time</th>
                                            <th>Private Time</th>
                                            <th>Total Time Allocated</th>
                                            <th>Total Time Spended</th>
                                            <th>Time Zone</th>
                                            <th>App And Os</th>
                                            <th>Insert Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($dateWise) {
                                            $sl = 1;
                                            foreach ($dateWise as $res) { ?>
                                                <tr>
                                                    <td><?= $sl++ ?></td>
                                                    <td><?= $res->desklog_usrid ?></td>
                                                    <td><?= $res->tracker_user_id ?></td>
                                                    <td><?= $res->email ?></td>
                                                    <td><?= $res->arrival_at ?></td>
                                                    <td><?= $res->left_at ?></td>
                                                    <td><?= $res->time_at_work ?></td>
                                                    <td><?= $res->productive_time ?></td>
                                                    <td><?= $res->idle_time ?></td>
                                                    <td><?= $res->private_time ?></td>
                                                    <td><?= $res->total_time_allocated ?></td>
                                                    <td><?= $res->total_time_spended ?></td>
                                                    <td><?= $res->time_zone ?></td>
                                                    <td><?= $res->app_and_os ?></td>
                                                    <td><?= $res->insert_date ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>