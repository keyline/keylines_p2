<?php
if ($row) {
    $role_name                      = $row->role_name;
    $role_id                        = $row->id;
} else {
    $role_name                      = '';
    $role_id                        = '';
}
?>
<style>
    .gray-checkbox {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 15px;
        height: 15px;
        border: 1px solid #ccc;
        background-color: #fff;
        border-radius: 4px;
        display: inline-block;
        position: relative;
        top: 2px;
    }

    .gray-checkbox:checked {
        background-color: #888;
    }

    .gray-checkbox:checked::after {
        content: '';
        position: absolute;
        left: 4px;
        top: 0px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .nav-link{
        color: #000;
    }
    .nav-link,
    .permission-dropdown select,
    .card-header{
        font-size: 14px
    }
    .card-header{
        margin-bottom: 0 !important;
    }
    .card-header .bg-success{
        background: #4CAB4F !important;
    }
    .card-body span{
        display: block;
        font-size: 14px
    }
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link,
    .box-footer .btn{
        background: #26A9E1 !important;
        color: #fff;
    }
</style>
<script src="//cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>
<div class="pcoded-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title pagetitle">
                            <h1 class="m-b-10"><?php echo $page_header; ?></h1>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/'); ?>/user"><i class="feather icon-home"></i>Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/'); ?>/<?php echo $moduleDetail['controller']; ?>">Manage <?php echo $moduleDetail['module']; ?></a></li>
                            <li class="breadcrumb-item"><a href="#!"><?php echo $page_header; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card table-card">
                    <div class="card-header">
                        <h5 class="mb-2"><?php echo $page_header; ?></h5>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group permission-dropdown">
                                    <label for="role_name">Role Name *</label>
                                    <select name="role_name" class="form-control" id="role_name" <?= ((!empty($row)) ? 'disabled' : '') ?> required>
                                        <option value="" selected>Select Type</option>
                                        <?php if ($role_masters) {
                                            foreach ($role_masters as $role_master) {   ?>
                                                <option value="<?= $role_master->role_name; ?>" <?= (($role_name == $role_master->role_name) ? 'selected' : '') ?>><?= $role_master->role_name; ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                    <?php if ($row) { ?>
                                        <input type="hidden" name="role_name_hidden" id="role_name_hidden" value="<?= htmlspecialchars($role_name) ?>">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="background: #fff; border-radius: 8px">
                                            <?php if ($parentmodules) {
                                                $i = 1;
                                                foreach ($parentmodules as $parentmodule) { ?>
                                                    <a style="font-size:12px;" class="nav-link <?= (($i == 1) ? 'active' : '') ?>" id="v-pills-<?= $parentmodule->id ?>-tab" data-bs-toggle="pill" href="#v-pills-<?= $parentmodule->id ?>" role="tab" aria-controls="v-pills-<?= $parentmodule->id ?>" aria-selected="true"><?= $parentmodule->module_name ?></a>
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

                                                            <div class="card">
                                                                <div class="card-header bg-success text-white">
                                                                    <?= $parentmodule->module_name ?>
                                                                </div>
                                                                <div class="card-body p-3">
                                                                    <?php
                                                                    $functions    = $common_model->find_data('permission_module_functions', 'array', ['published' => 1, 'module_id' => $parentmodule->id]);
                                                                    if ($functions) {
                                                                        foreach ($functions as $function) { ?>
                                                                            <?php
                                                                            // $checkFunctionSelected = $common_model->find_data('permission_role_module_function', 'count', ['role_id' => $role_id, 'module_id' => $parentmodule->id, 'function_id' => $function->function_id]);
                                                                            $checkFunctionSelected = $common_model->find_data('permission_role_module_function', 'row', ['role_id' => $role_id, 'module_id' => $parentmodule->id, 'function_id' => $function->function_id]);
                                                                            //  var_dump($checkFunctionSelected);
                                                                            if ($checkFunctionSelected &&$checkFunctionSelected->published == 1) {
                                                                                $checked = 'checked';
                                                                            } else {
                                                                                $checked = '';
                                                                            }
                                                                            ?>
                                                                            <span class="mb-1">
                                                                                <input type="checkbox" class="allow-interaction gray-checkbox" name="function_id[]" id="function<?= $function->function_id ?>" value="<?= $function->function_id ?>" <?= $checked ?>>
                                                                                <label for="function<?= $function->function_id ?>"><?= $function->function_name ?></label>
                                                                            </span>
                                                                    <?php }
                                                                    } ?>
                                                                </div>

                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="row">
                                                                <?php
                                                                $nestedMenus = $common_model->find_data('permission_modules', 'array', ['parent_id' => $parentmodule->id]);
                                                                if ($nestedMenus) {
                                                                    foreach ($nestedMenus as $nestedMenu) {
                                                                ?>
                                                                        <div class="col-md-6">
                                                                            <div class="card mb-3">
                                                                                <div class="card-header bg-success text-white">
                                                                                    <?= $nestedMenu->module_name ?>
                                                                                    <input type="hidden" name="module_id[]" value="<?= $nestedMenu->id ?>">
                                                                                </div>
                                                                                <div class="card-body p-3">
                                                                                    <?php
                                                                                    $functions    = $common_model->find_data('permission_module_functions', 'array', ['published' => 1, 'module_id' => $nestedMenu->id]);
                                                                                    if ($functions) {
                                                                                        foreach ($functions as $function) { ?>
                                                                                            <?php
                                                                                            $checkFunctionSelected = $common_model->find_data('permission_role_module_function', 'count', ['role_id' => $role_id, 'module_id' => $nestedMenu->id, 'function_id' => $function->function_id, 'published' => 1]);
                                                                                            if ($checkFunctionSelected > 0) {
                                                                                                $checked = 'checked';
                                                                                            } else {
                                                                                                $checked = '';
                                                                                            }
                                                                                            ?>
                                                                                            <span class="mb-1">
                                                                                                <input type="checkbox" class="allow-interaction gray-checkbox" name="function_id[]" id="function<?= $function->function_id ?>" value="<?= $function->function_id ?>" <?= $checked ?>>
                                                                                                <label for="function<?= $function->function_id ?>"><?= $function->function_name ?></label>
                                                                                            </span>
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
                            </div>
                            <?php if (checkModuleFunctionAccess(14, 63) == False) { ?>
                                <div class="box-footer mt-3">
                                    <input type="submit" class="btn btn-sm" name="submit" value="Submit">
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10;
        var addButton = $('.add_button');
        var wrapper = $('.field_wrapper');
        var fieldHTML = '<div class="row mt-3">\
                            <div class="col-md-4">\
                                <input type="text" class="form-control" name="function_name[]" placeholder="Function Name">\
                            </div>\
                            <div class="col-md-2">\
                                <a href="javascript:void(0);" class="remove_button" title="Add field">\
                                    <i class="fa fa-minus-circle fa-2x text-danger"></i>\
                                </a>\
                            </div>\
                        </div>';
        var x = 1;

        $(addButton).click(function() {
            if (x < maxField) {
                x++;
                $(wrapper).append(fieldHTML);
            }
        });

        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove();
            x--;
        });
    });
    document.getElementById('role_name').disabled = true;
</script>
<script>
    document.getElementById('role_name').addEventListener('change', function() {
        var selectValue = this.value;
        document.getElementById('role_name_hidden').value = selectValue;
    });
</script>

<?php if (checkModuleFunctionAccess(14, 63)) { ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.allow-interaction');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('click', function(event) {
                    event.preventDefault();
                    alert("You are not authorized to use this functionality !!");
                });
                checkbox.addEventListener('keydown', function(event) {
                    event.preventDefault();
                });
            });
        });
    </script>
<?php } ?>