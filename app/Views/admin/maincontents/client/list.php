<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="container-fluid">
      <div class="row">
         <div class="col-12">
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
    </div>
</div>
<?php if(checkModuleFunctionAccess(6,33)){ ?>
<section class="section">
    <div class="container-fluid">
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
                    <?php if(checkModuleFunctionAccess(6,34)){ ?>
                    <div class="card-header">
                        <h5>
                            <a href="<?= base_url('admin/' . $controller_route . '/add/') ?>" class="btn btn-outline-success btn-sm">Add <?= $title ?></a>
                            <!-- <a href="<?= base_url('admin/' . $controller_route . '/encrypt-info/') ?>" class="btn btn-info btn-sm" style="float: right;">Encrypt Client Email & Phone</a> -->
                        </h5>
                    </div>
                    <?php } ?>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table padding-y-10 general_table_style">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Reference Emails Phones </th>
                                        <th>Added Last Login</th>
                                        <?php if(checkModuleFunctionAccess(6,113) || checkModuleFunctionAccess(6,114)) { ?>
                                        <th class="text-center">Document</th>
                                        <?php } ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) { ?>
                                            <tr>
                                                <th scope="row"><?= $sl++ ?></th>
                                                <td>
                                                    <?=$pro->decrypt($row->name)?><br>
                                                    <?php $projectCount = $common_model->find_data('project', 'count', ['client_id' => $row->id], 'id'); ?>
                                                    <?php if(checkModuleFunctionAccess(6,112)) { ?>
                                                    <a href="<?= base_url('admin/' . $controller_route . '/add-project/' . base64_encode($row->id)) ?>" target="_blank" class="btn btn-info btn-sm d-inline-flex align-items-center" style="height: 20px;font-size: 12px;">
                                                        <i class="bi bi-plus-circle me-1"></i> Add Project
                                                    </a><br>
                                                    <?php } ?>
                                                    <span class="badge bg-warning mt-1"><?= $projectCount ?> Projects</span>
                                                    <span class="badge mt-1 <?= (($row->login_access == '1') ? 'bg-success' : 'bg-danger') ?>"><?= (($row->login_access == '1') ? ' Login Access: YES' : 'Login Access: NO') ?></span><br>
                                                </td>
                                                <td>
                                                    <span class="fw-bold"><?=$pro->decrypt($row->compnay)?></span><br>
                                                    <?= $row->address_1 ?> <?= $row->state ?> <?= $row->city ?> <?= $row->country ?> <?= $row->pin ?><br>
                                                    <?= $row->address_2 ?>
                                                </td>
                                                <td>
                                                    <p><?=$row->reference ?></p>
                                                    <p><?=$pro->decrypt($row->email_1)?></p>
                                                    <p><?=$pro->decrypt($row->email_2)?> </p>
                                                    <p><?=$pro->decrypt($row->phone_1)?></p>
                                                    <p><?=$pro->decrypt($row->phone_2)?></p>
                                                    <!-- <?=$pro->decrypt($row->encoded_email)?><br> -->
                                                    <!-- <?=$pro->decrypt($row->encoded_phone)?><br> -->
                                                </td>
                                                <td>
                                                    <?= (($row->added_date != '0000-00-00 00:00:00') ? date_format(date_create($row->added_date), "M d, Y h:i A") : '') ?>
                                                    <br>
                                                    <hr>
                                                    <?= (($row->last_login != '0000-00-00 00:00:00') ? date_format(date_create($row->last_login), "M d, Y h:i A") : '') ?>
                                                </td>
                                                <?php if(checkModuleFunctionAccess(6,113) || checkModuleFunctionAccess(6,114)) { ?>
                                                <td class="text-center">
                                                    <?php if(checkModuleFunctionAccess(6,113)){ ?>
                                                    <a href="<?= base_url('admin/' . $controller_route . '/add-proposal/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-success btn-sm" title="Add Proposal"><i class="fa fa-plus"></i></a>
                                                    <?php } ?>
                                                    <?php
                                                    $sql = "SELECT COUNT(file) as totalFile FROM proposal_files WHERE client_id=" . $row->$primary_key;
                                                    $res = $db->query($sql)->getRow();
                                                    if ($res->totalFile > 0) {   ?>
                                                        <?php if(checkModuleFunctionAccess(6,114)){ ?>
                                                        <a target="_blank" href="<?= base_url('admin/' . $controller_route . '/view-proposal/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-info btn-sm" title="View Proposal"><i class="fa fa-eye"></i></a>
                                                        <span class="badge bg-success mt-1"> <?= 'Total Document: ' . $res->totalFile ?? null ?></span>
                                                    <?php    }  } ?>
                                                </td>
                                                <?php } ?>
                                                <td>
                                                    <?php if(checkModuleFunctionAccess(6,55)){ ?>
                                                    <a href="<?= base_url('admin/' . $controller_route . '/edit/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-primary btn-sm" title="Edit <?= $title ?>"><i class="fa fa-edit"></i></a>
                                                    <?php } ?>
                                                    <?php if(checkModuleFunctionAccess(6,108)){ ?>
                                                    <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>
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
</section>
<?php } ?>