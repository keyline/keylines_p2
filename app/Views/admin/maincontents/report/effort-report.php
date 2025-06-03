<?php
$user = $session->user_type;
//pr($user);
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
            <!-- <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '/list/') ?>"><?= $title ?> List</a></li> -->
            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section dashboard">
    <?php if (checkModuleFunctionAccess(23, 41)) { ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <form method="GET" action="" enctype="multipart/form-data">
                            <input type="hidden" name="mode" value="year">
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-6 col-lg-6" id="day_type_row" style="display:'block'">
                                    <label for="year">Years</label>
                                    <?php
                                    // echo $selectedyear; die;
                                        $currentYear = date("Y"); // Get the current year
                                        $startYear = $currentYear - 7; // Calculate the starting year
                                        
                                        echo '<select name="year" class="form-control" id="year" required>';
                                        echo '<hr>';
                                        for ($allyear = $startYear; $allyear <= $currentYear; $allyear++) {
                                            $selected = ($allyear == $year) ? 'selected' : '';
                                            echo "<option value='$allyear' $selected>$allyear</option>";
                                        }
                                        echo '</select>';
                                    ?>
                                    
                                </div>
                                <div class="col-md-6 col-lg-6" style="margin-top: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                                    <?php if (!empty($response)) { ?>
                                        <a href="<?= base_url('admin/reports/advance-search') ?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Left side columns -->
             

            <div class="col-lg-12">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card table-card">
                            <div class="card-header text-dark bg-dark-info">
                                <h5 class="fw-bold text-center heading_style">Tracker Report <span id="year"><?= $year ?></span></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-12 col-md-12 table-responsive">
                                        <table class="table general_table_style padding-y-10">
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
                                                    foreach ($responses as $response) { ?>
                                                        <tr>
                                                            <td><?= $sl++ ?></td>
                                                            <td class="fw-bold"><?= $response['name'] ?></td>
                                                            <td>
                                                                <?php if ($response['jan_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(1) . ' ') ?>"><span class="badge <?= (($response['jan_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['jan_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['jan_desklog'] > 0) { ?><span class="badge <?= (($response['jan_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['jan_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['feb_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(2) . ' ') ?>"><span class="badge <?= (($response['feb_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['feb_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['feb_desklog'] > 0) { ?><span class="badge <?= (($response['feb_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['feb_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['mar_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(3) . ' ') ?>"><span class="badge <?= (($response['mar_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['mar_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['mar_desklog'] > 0) { ?><span class="badge <?= (($response['mar_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['mar_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['apr_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(4) . ' ') ?>"><span class="badge <?= (($response['apr_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['apr_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['apr_desklog'] > 0) { ?><span class="badge <?= (($response['apr_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['apr_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['may_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(5) . ' ') ?>"><span class="badge <?= (($response['may_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['may_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['may_desklog'] > 0) { ?><span class="badge <?= (($response['may_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['may_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['jun_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(6) . ' ') ?>"><span class="badge <?= (($response['jun_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['jun_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['jun_desklog'] > 0) { ?><span class="badge <?= (($response['jun_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['jun_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['jul_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(7) . ' ') ?>"><span class="badge <?= (($response['jul_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['jul_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['jul_desklog'] > 0) { ?><span class="badge <?= (($response['jul_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['jul_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['aug_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(8) . ' ') ?>"><span class="badge <?= (($response['aug_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['aug_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['aug_desklog'] > 0) { ?><span class="badge <?= (($response['aug_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['aug_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['sep_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(9) . ' ') ?>"><span class="badge <?= (($response['sep_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['sep_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['sep_desklog'] > 0) { ?><span class="badge <?= (($response['sep_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['sep_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['oct_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(10) . ' ') ?>"><span class="badge <?= (($response['oct_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['oct_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['oct_desklog'] > 0) { ?><span class="badge <?= (($response['oct_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['oct_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['nov_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(11) . ' ') ?>"><span class="badge <?= (($response['nov_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['nov_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['nov_desklog'] > 0) { ?><span class="badge <?= (($response['nov_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['nov_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($response['dec_booked'] > 0) { ?><a target="_blank" href="<?= base_url('admin/reports/viewMonthlyProjectReport/' . base64_encode($response['userId']) . '/' . base64_encode($year) . '/' . base64_encode(12) . ' ') ?>"><span class="badge <?= (($response['dec_booked'] >= 172) ? 'badge-tracker-success' : 'badge-tracker-danger') ?>"><img src="<?= base_url('public/uploads/tracker-icon.webp')?>" alt="" class="tracker-icon"> <?= $response['dec_booked'] ?></span></a><?php } ?>
                                                                <?php if ($response['deskloguser'] == 1) {
                                                                    if ($response['dec_desklog'] > 0) { ?><span class="badge <?= (($response['dec_desklog'] >= 172) ? 'badge-desktime-success' : 'badge-desktime-danger') ?>"><img src="<?= base_url('public/uploads/desklog-icon.webp')?>" alt="" class="desklog-icon"> <?= $response['dec_desklog'] ?></span><?php }
                                                                                                                                                                                                                                                                                        } ?>
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
                    </div>
                </div>
            </div>
            <!-- End Left side columns -->

        </div>
    <?php } ?>
</section>