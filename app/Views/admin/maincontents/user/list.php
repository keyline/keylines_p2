<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<?php if (checkModuleFunctionAccess(4, 20)) { ?>
    <section class="section">
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
            <div class="col-lg-12">
                <div class="card table-card">
                    <div class="card-header">
                        <!-- <h6 class="fw-bold heading_style">Last 7 Days Report</h6> -->
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="card-header-left">
                                    <?php if (checkModuleFunctionAccess(4, 21)) { ?>
                                        <h5>
                                            <a href="<?= base_url('admin/' . $controller_route . '/add/') ?>" class="btn btn-outline-success btn-sm">Add <?= $title ?></a>
                                            <a href="<?= base_url('admin/' . $controller_route . '/DeactivateUserlist/') ?>" class="btn btn-outline-success btn-sm">Deactivated <?= $title ?>s</a>
                                        </h5>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- ?php if(checkModuleFunctionAccess(4,21)){ ?>
                        <h5 class="card-title">
                            <a href="?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add ?=$title?></a>
                            <a href="?=base_url('admin/' . $controller_route . '/DeactivateUserlist/')?>" class="btn btn-outline-success btn-sm">Deactivated ?=$title?>s</a>
                        </h5>
                    ?php }?> -->
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table nowrap general_table_style padding-y-10 employess_table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name<br>User ID</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <!-- <th scope="col">Type</th>
                                        <th scope="col">Work Mode</th> -->
                                        <th scope="col">Tracker User</th>
                                        <th scope="col">Salarybox User</th>
                                        <th scope="col">Attendence Type</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) { ?>
                                            <tr>
                                                <th scope="row"><?= $sl++ ?></th>
                                                <td><?= $row->name ?><span class="badge bg-warning ms-1"><?= $row->id ?></span> <br>
                                                    <a href="<?= base_url('admin/user/screenshots/' . encoded($row->id)); ?>"> <?= $row->type ?> Check In: <?= (!empty($row->screenshot_time)) ? date("g:i A", strtotime($row->screenshot_time)) : "-" ?> <i class="fas fa-image"></i> </a>                                                    
                                                </td>
                                                <td class="text-center"><?= $row->phone1 ?></td>
                                                <td><?= $row->email ?></td>
                                                <!-- <td></td> -->
                                                <!-- <td>?= $row->work_mode ?></td> -->
                                                <td>
                                                    <?php if ($row->is_tracker_user) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/change-tracker-status/' . encoded($row->$primary_key)) ?>" class="badge badge-tracker-success" title="Tracker On <?= $title ?>" onclick="return confirm('Do You Want To Tracker Off This <?= $title ?>');"><i class="fa fa-check"></i> Tracker On</a>
                                                    <?php } else { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/change-tracker-status/' . encoded($row->$primary_key)) ?>" class="badge badge-tracker-danger" title="Tracker Off <?= $title ?>" onclick="return confirm('Do You Want To Tracker On This <?= $title ?>');"><i class="fa fa-times"></i> Tracker Off</a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($row->is_salarybox_user) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/change-salarybox-status/' . encoded($row->$primary_key)) ?>" class="badge badge-tracker-success" title="Salarybox On <?= $title ?>" onclick="return confirm('Do You Want To Salarybox Off This <?= $title ?>');"><i class="fa fa-check"></i> Salarybox On</a>
                                                    <?php } else { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/change-salarybox-status/' . encoded($row->$primary_key)) ?>" class="badge badge-tracker-danger" title="Salarybox Off <?= $title ?>" onclick="return confirm('Do You Want To Salarybox On This <?= $title ?>');"><i class="fa fa-times"></i> Salarybox Off</a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <?php
                                                        $attendence_type = json_decode($row->attendence_type);
                                                        if (count($attendence_type) > 0) {
                                                            for ($a = 0; $a < count($attendence_type); $a++) {
                                                                if ($attendence_type[$a] == 0) {
                                                                    $attnType = 'WORK FROM HOME';
                                                                } else {
                                                                    $getOfficeLocation = $common_model->find_data('office_locations', 'row', ['id' => $attendence_type[$a]], 'name');
                                                                    $attnType = (($getOfficeLocation) ? $getOfficeLocation->name : '');
                                                                }
                                                        ?>
                                                                <li><small><?= $attnType ?></small></li>
                                                        <?php }
                                                        } ?>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <?php if (checkModuleFunctionAccess(4, 22)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/edit/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-primary btn-sm" title="Edit <?= $title ?>"><i class="fa fa-edit"></i></a>
                                                    <?php   } ?>
                                                    <?php if (checkModuleFunctionAccess(4, 58)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i></a>
                                                    <?php   } ?>
                                                    <?php if ($row->status) { ?>
                                                        <?php if (checkModuleFunctionAccess(4, 23)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/change-status/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-success btn-sm" title="Activate <?= $title ?>" onclick="return confirm('Do You Want To Deactivate This <?= $title ?>');"><i class="fa fa-check"></i></a>
                                                        <?php   } ?>
                                                    <?php } else { ?>
                                                        <?php if (checkModuleFunctionAccess(4, 24)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/change-status/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?= $title ?>" onclick="return confirm('Do You Want To Activate This <?= $title ?>');"><i class="fa fa-times"></i></a>
                                                        <?php   } ?>
                                                    <?php } ?>
                                                    <br>
                                                    <?php if (checkModuleFunctionAccess(4, 25)) { ?>
                                                        <a href="<?= base_url('admin/users/send-credentials/' . encoded($row->$primary_key)) ?>" class="badge mt-2 bg-custom-primary" onclick="return confirm('Do you want to reset password & send credentials ?');"><i class="fa fa-envelope"></i> Reset & Send Credentials</a>
                                                    <?php   } ?>
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
    </section>
<?php   } ?>