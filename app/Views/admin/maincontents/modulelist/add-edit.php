<?php
if ($row) {
    $parent_id                      = $row->parent_id;
    $module_name                    = $row->module_name;
} else {
    $parent_id                      = '';
    $module_name                    = '';
}
?>
<script src="//cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>
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
            <form action="" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_id">Parent Module *</label>
                                <select class="form-control" name="parent_id" id="parent_id">
                                    <option value="" selected>Select Parent Module</option>
                                    <?php if ($modules) {
                                        foreach ($modules as $module) { ?>
                                            <option value="<?= $module->id ?>" <?= (($parent_id == $module->id) ? 'selected' : '') ?>><?= $module->module_name ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="module_name">Module Name *</label>
                                <input type="text" class="form-control" name="module_name" id="module_name" value="<?= $module_name ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <?php if ($functions) {
                                    foreach ($functions as $function) { ?>
                                        <span class="badge bg-primary"><?= $function->function_name ?></span>
                                <?php }
                                } ?>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div class="field_wrapper">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- <input type="text" class="form-control" name="function_name[]" placeholder="Function Name"> -->
                                        <select class="form-control" name="function_name[]" id="function_name">
                                            <option value="" selected>Select Function Name</option>
                                            <?php if ($allfunctions) {
                                                foreach ($allfunctions as $allfunction) { ?>
                                                    <option value="<?= $allfunction->name ?>"><?= $allfunction->name ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript:void(0);" class="add_button" title="Add field">
                                            <i class="fa fa-plus-circle fa-2x text-success"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

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
    var optionsHTML = '<?php 
        $options = '';
        if ($allfunctions) {
            foreach ($allfunctions as $allfunction) {
                $options .= '<option value="' . $allfunction->name . '">' . $allfunction->name . '</option>';
            }
        }
        echo $options;
    ?>';
    $(document).ready(function() {
        var maxField    = 10;
        var addButton   = $('.add_button');
        var wrapper     = $('.field_wrapper');
        var fieldHTML   = function() {
        return '<div class="row mt-3">\
                    <div class="col-md-4">\
                        <select class="form-control" name="function_name[]">\
                            <option value="" selected>Select Function Name</option>' + optionsHTML + '\
                        </select>\
                    </div>\
                    <div class="col-md-2">\
                        <a href="javascript:void(0);" class="remove_button" title="Remove field">\
                            <i class="fa fa-minus-circle fa-2x text-danger"></i>\
                        </a>\
                    </div>\
                </div>';
        };
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
</script>