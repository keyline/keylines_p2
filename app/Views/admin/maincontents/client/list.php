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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="<?= base_url('admin/' . $controller_route . '/add/') ?>" class="btn btn-outline-success btn-sm">Add <?= $title ?></a>
                    </h5>
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered table-fit general_table_style">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Reference <br> Emails <br> Phones </th>
                                    <th scope="col">Added<br>Last Login</th>
                                    <th scope="col">Document</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($rows) {
                                    $sl = 1;
                                    foreach ($rows as $row) { ?>
                                        <tr>
                                            <th scope="row"><?= $sl++ ?></th>
                                            <td>
                                                <?= $row->name ?><br>
                                                <?php $projectCount = $common_model->find_data('project', 'count', ['client_id' => $row->id], 'id'); ?>
                                                <a href="<?= base_url('admin/' . $controller_route . '/add-project/' . base64_encode($row->id)) ?>" target="_blank" class="btn btn-info btn-sm d-inline-flex align-items-center" style="height: 20px;font-size: 12px;">
                                                    <i class="bi bi-plus-circle me-1"></i> Add Project
                                                </a>
                                                <h6><span class="badge bg-warning"><?= $projectCount ?> Projects</span></h6>
                                                <span class="badge <?= (($row->login_access == '1') ? 'bg-success' : 'bg-danger') ?>"><?= (($row->login_access == '1') ? ' Login Access: YES' : 'Login Access: NO') ?></span><br>
                                            </td>
                                            <td>
                                                <span class="fw-bold"><?= $row->compnay ?></span><br>
                                                <?= $row->address_1 ?> <?= $row->state ?> <?= $row->city ?> <?= $row->country ?> <?= $row->pin ?><br>
                                                <?= $row->address_2 ?>
                                            </td>
                                            <td><?= $row->reference ?> <br> <?= $row->email_1 ?><br><?= $row->email_2 ?> <br> <?= $row->phone_1 ?><br><?= $row->phone_2 ?> </td>
                                            <td>
                                                <?= (($row->added_date != '0000-00-00 00:00:00') ? date_format(date_create($row->added_date), "M d, Y h:i A") : '') ?>
                                                <br>
                                                <hr>
                                                <?= (($row->last_login != '0000-00-00 00:00:00') ? date_format(date_create($row->last_login), "M d, Y h:i A") : '') ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/' . $controller_route . '/add-proposal/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-success btn-sm" title="Add Proposal"><i class="fa fa-plus"></i></a>
                                                <?php
                                                $sql = "SELECT COUNT(file) as totalFile FROM proposal_files WHERE client_id=" . $row->$primary_key;
                                                $res = $db->query($sql)->getRow();
                                                if ($res->totalFile > 0) {   ?>
                                                    <a target="_blank" href="<?= base_url('admin/' . $controller_route . '/view-proposal/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-info btn-sm" title="View Proposal"><i class="fa fa-eye"></i></a>
                                                    <span class="badge bg-success"> <?= 'Total Document: ' . $res->totalFile ?? null ?></span>
                                                <?php    }  ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/' . $controller_route . '/edit/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-primary btn-sm" title="Edit <?= $title ?>"><i class="fa fa-edit"></i></a>
                                                <!-- <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i></a> -->
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