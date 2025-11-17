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
                    <!-- <h5 class="card-title">
                        <a href="<?= base_url('admin/' . $controller_route . '/add/') ?>" class="btn btn-outline-success btn-sm">Add <?= $title ?></a>
                    </h5> -->
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered table-fit general_table_style">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Files</th>
                                    <th scope="col">Uploaded By</th>
                                    <?php if(checkModuleFunctionAccess(6,115) || checkModuleFunctionAccess(6,116)) { ?>
                                    <th scope="col">Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($rows) {
                                    $sl = 1;
                                    foreach ($rows as $row) { ?>
                                        <tr>
                                            <th scope="row"><?= $sl++ ?></th>
                                            <td>
                                                <?php
                                                $db     = \Config\Database::connect();
                                                $sql    = 'SELECT * FROM `client_proposal` Where id = ' . $row->proposal_id;
                                                $res    = $db->query($sql)->getRow();
                                                ?>
                                                <?= $res->title; ?> <i class="fa fa-eye" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $res->id ?>" aria-hidden="true"></i>
                                            </td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?= $res->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $res->title ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?= $res->description ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <td>
                                                <?= $row->created_at ?>
                                            </td>
                                            <td>
                                                <a target="_blank" href="<?= base_url('public/uploads/proposal/' . $row->file) ?>"><?= $row->file ?></a>
                                            </td>
                                            <td>
                                                <?php
                                                $sql    = 'SELECT * FROM `user` Where id = ' . $row->uploaded_by;
                                                $res1    = $db->query($sql)->getRow();
                                                echo $res1->name ?? '';
                                                ?>
                                            </td>
                                            <?php if(checkModuleFunctionAccess(6,115) || checkModuleFunctionAccess(6,116)) { ?>
                                            <td>
                                                <?php if(checkModuleFunctionAccess(6,115)) { ?>
                                                <a href="<?= base_url('admin/' . $controller_route . '/edit-proposal/' . base64_encode($row->id)); ?>" class="btn btn-outline-primary btn-sm" title="Edit Proposal"><i class="fa fa-edit"></i></a>
                                                <?php } ?>
                                                <?php if(checkModuleFunctionAccess(6,116)) { ?>
                                                <a href="<?= base_url('admin/' . $controller_route . '/delete-proposal/' . base64_encode($row->id)); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Do you want to delete this proposal from list ?');" title="Delete Proposal"><i class="fa fa-trash"></i></a>
                                                <?php } ?>
                                            </td>
                                            <?php } ?>
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