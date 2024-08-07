<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><?php echo $page_header; ?></h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/'); ?>/user"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!"><?php echo $page_header; ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php if (checkModuleFunctionAccess(14, 7)) { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
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
                        <?php if (checkModuleFunctionAccess(14, 8)) { ?>
                            <!-- <h5>
                                <a href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/add" class="btn btn-success">Add <?php echo $moduleDetail['module']; ?></a>
                            </h5> -->
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Role Master Name</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($rows) {
                                            $i = 1;
                                            foreach ($rows as $row) { ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $row->role_name ?></td>
                                                    <td>
                                                        <?php if (checkModuleFunctionAccess(14, 9) || (checkModuleFunctionAccess(14, 63)) ) { ?>
                                                            <a href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/edit/<?php echo $row->id; ?>" class="btn btn-icon btn-primary btn-sm" title="Provide Permissions"><i class="fa fa-edit"></i></a>
                                                        <?php } ?>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <?php if (checkModuleFunctionAccess(14, 63)) { ?>
                                                            <!-- <a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/view/<?php echo $row->id; ?>"><i class="nav-icon fas fa-info-circle"></i> Analyze Permissions </a> -->
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>