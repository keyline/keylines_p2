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
                    <?php if($session->getFlashdata('success_message')) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> <?php echo $session->getFlashdata('success_message');?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <?php } ?>
                    <?php if($session->getFlashdata('error_message')) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo $session->getFlashdata('error_message');?>
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
                                        <td style="font-weight: bold;">Parent Module</td>
                                        <td>
                                            <?php
                                            $module = $common_model->find_data('permission_modules', 'row', ['id' => $row->parent_id]);
                                            echo (($module)?$module->module_name:'');
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Module Name</td>
                                        <td>
                                            <?=$row->module_name?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Function Name</td>
                                        <td>
                                            <?php
                                            $functions    = $common_model->find_data('permission_module_functions', 'array', ['published' => 1, 'module_id' => $row->id]);
                                            if($functions){ foreach($functions as $function){?>
                                                <span class="badge bg-primary mb-3" style="font-size: 12px;"><?=$function->function_name?></span>
                                            <?php } }?>
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