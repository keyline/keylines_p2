<div class="container-fluid">
    <div class="pcoded-content">
        <div class="row">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10"><?php echo $page_header; ?></h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home </a></li>
                                <li class="breadcrumb-item"><a href="javascript:(void);"><?php echo $page_header; ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (checkModuleFunctionAccess(28, 73)) { ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card table-card">
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
                            <?php if (checkModuleFunctionAccess(28, 74)) { ?>
                                <h5>
                                    <a href="<?php echo base_url(); ?>/admin/role-master/add" class="btn btn-success"><?= $action; ?></a>
                                </h5>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table general_table_style padding-y-10">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Role Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($rows) {
                                                $i = 1;
                                                foreach ($rows as $row) { ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= $row->role_name ?></td>
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
</div>