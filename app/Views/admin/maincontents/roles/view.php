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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/'); ?>/<?php echo $moduleDetail['controller']; ?>">Manage <?php echo $moduleDetail['module']; ?></a></li>
                        <li class="breadcrumb-item"><a href="#!"><?php echo $page_header; ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <?php if ($session->getFlashdata('success_message')) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo $session->getFlashdata('success_message'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    <?php } ?>
                    <?php if ($session->getFlashdata('error_message')) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo $session->getFlashdata('error_message'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    <?php } ?>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <table class="table table-bordered table-stripped">
                                    <tr>
                                        <td style="font-weight: bold;">Role Name</td>
                                        <td>
                                            <?= $row->role_name ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight: bold;">Function Name Module Wise</td>

                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                        <?php if ($parentmodules) {
                                                            $i = 1;
                                                            foreach ($parentmodules as $parentmodule) { ?>
                                                                <a class="nav-link <?= (($i == 1) ? 'active' : '') ?>" id="v-pills-<?= $parentmodule->id ?>-tab" data-bs-toggle="pill" href="#v-pills-<?= $parentmodule->id ?>" role="tab" aria-controls="v-pills-<?= $parentmodule->id ?>" aria-selected="true"><?= $parentmodule->module_name ?></a>
                                                        <?php $i++;
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="col-9">
                                                    <div class="tab-content" id="v-pills-tabContent">
                                                        <?php if ($parentmodules) {
                                                            $i = 1;
                                                            foreach ($parentmodules as $parentmodule) { ?>
                                                                <div class="tab-pane fade <?= (($i == 1) ? 'show active' : '') ?>" id="v-pills-<?= $parentmodule->id ?>" role="tabpanel" aria-labelledby="v-pills-<?= $parentmodule->id ?>-tab">

                                                                    <?php
                                                                    $checkNestedMenu = $common_model->find_data('permission_modules', 'count', ['parent_id' => $parentmodule->id]);
                                                                    if ($checkNestedMenu <= 0) {
                                                                    ?>
                                                                        <input type="hidden" name="module_id[]" value="<?= $parentmodule->id ?>">
                                                                        <?php
                                                                        $functions    = $common_model->find_data('permission_module_functions', 'array', ['published' => 1, 'module_id' => $parentmodule->id]);
                                                                        if ($functions) {
                                                                            foreach ($functions as $function) { ?>
                                                                                <?php
                                                                                $checkFunctionSelected = $common_model->find_data('permission_role_module_function', 'count', ['role_id' => $row->id, 'module_id' => $parentmodule->id, 'function_id' => $function->function_id]);
                                                                                if ($checkFunctionSelected > 0) {
                                                                                    $checked = 1;
                                                                                } else {
                                                                                    $checked = 0;
                                                                                }
                                                                                if ($checked) {
                                                                                ?>
                                                                                    <span class="badge bg-primary mb-3" style="font-size: 12px;"><?= $function->function_name ?></span>
                                                                                <?php } ?>
                                                                        <?php }
                                                                        } ?>
                                                                    <?php } else { ?>
                                                                        <div class="row">
                                                                            <?php
                                                                            $nestedMenus = $common_model->find_data('permission_modules', 'array', ['parent_id' => $parentmodule->id]);
                                                                            // pr($nestedMenus);
                                                                            if ($nestedMenus) {
                                                                                foreach ($nestedMenus as $nestedMenu) {
                                                                            ?>
                                                                                    <div class="col-md-6">
                                                                                        <div class="card mb-3">
                                                                                            <div class="card-header bg-success text-white">
                                                                                                <?= $nestedMenu->module_name ?>
                                                                                                <input type="hidden" name="module_id[]" value="<?= $nestedMenu->id ?>">
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <?php
                                                                                                $functions    = $common_model->find_data('permission_module_functions', 'array', ['published' => 1, 'module_id' => $nestedMenu->id]);
                                                                                                // pr($functions);
                                                                                                if ($functions) {
                                                                                                    foreach ($functions as $function) { ?>
                                                                                                        <?php
                                                                                                        $checkFunctionSelected = $common_model->find_data('permission_role_module_function', 'count', ['role_id' => $row->id, 'module_id' => $nestedMenu->id, 'function_id' => $function->function_id]);
                                                                                                        if ($checkFunctionSelected > 0) {
                                                                                                            $checked = 1;
                                                                                                        } else {
                                                                                                            $checked = 0;
                                                                                                        }
                                                                                                        if ($checked) {
                                                                                                        ?>
                                                                                                            <span class="badge bg-primary mb-3" style="font-size: 12px;"><?= $function->function_name ?></span>
                                                                                                        <?php } ?>
                                                                                                <?php }
                                                                                                } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            <?php }
                                                                            } ?>
                                                                        </div>
                                                                    <?php } ?>

                                                                </div>
                                                        <?php $i++;
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function sweet_multiple(url) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location = url;
                    swal("Poof! Your data has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your data is safe!", {
                        icon: "error",
                    });
                }
            });
    }
</script>

<script>
    function checkALL() {
        var chk_arr = document.getElementsByName("draw[]");
        for (k = 0; k < chk_arr.length; k++) {
            chk_arr[k].checked = true;
        }
        CheckIfChecked();
    }

    function unCheckALL() {
        var chk_arr = document.getElementsByName("draw[]");
        for (k = 0; k < chk_arr.length; k++) {
            chk_arr[k].checked = false;
        }
        CheckIfChecked();
    }


    function checkAny() {
        var chk_arr = document.getElementsByName("draw[]");
        for (k = 0; k < chk_arr.length; k++) {
            if (chk_arr[k].checked == true) {
                return true;
            }
        }
        return false;
    }

    function isCheckAll() {
        var chk_arr = document.getElementsByName("draw[]");
        for (k = 0; k < chk_arr.length; k++) {
            if (chk_arr[k].checked == false) {
                return false;
            }
        }
        return true;
    }

    function showFirstButton() {
        document.getElementById('first_button').style.display = "block";
    }

    function hideFirstButton() {
        document.getElementById('first_button').style.display = "none";
    }

    function CheckIfChecked() {
        checkAny() ? showFirstButton() : hideFirstButton();
        isCheckAll() ? showSecondButton() : hideSecondButton();
    }
</script>