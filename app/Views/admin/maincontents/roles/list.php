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
    <?php if(checkModuleFunctionAccess(14,7)){ ?>
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
                    <?php if(checkModuleFunctionAccess(14,8)){ ?>                      
                    <h5>
                        <a href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/add" class="btn btn-success">Add <?php echo $moduleDetail['module']; ?></a>
                    </h5>
                    <?php } ?>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Role Name</th>
                                  <!-- <th>Function Name</th> -->
                                  <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($rows){ $i=1; foreach($rows as $row){ ?>
                                <tr>
                                  <td><?=$i++?></td>
                                  <td><?=$row->role_name?></td>
                                  <!--<td>
                                     <?php
                                    $functions    = $common_model->find_data('sms_module_functions', 'array', ['published' => 1, 'module_id' => $row->id]);
                                    if($functions){ foreach($functions as $function){?>
                                      <span class="badge badge-primary mb-3" style="font-size: 12px;"><?=$function->function_name?></span>
                                    <?php } }?> 
                                  </td>-->
                                  <td>
                                    <?php if(checkModuleFunctionAccess(14,9)){ ?>
                                    <a href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/edit/<?php echo $row->id; ?>" class="btn  btn-icon btn-primary" title="Edit"><i class="feather icon-edit"></i>Edit</a>
                                    <?php } ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <?php if(checkModuleFunctionAccess(14,63)){ ?>
                                    <a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/view/<?php echo $row->id; ?>"><i class="nav-icon fas fa-info-circle"></i> View</a>
                                    <?php } ?>
                                    <?php if($row->published){?>
                                      <?php if(checkModuleFunctionAccess(14,64)){ ?>
                                      <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/deactive/<?php echo $row->id; ?>" onclick="return confirm('Are You Sure ?');"><i class="nav-icon fas fa-check"></i> Active</a>
                                      <?php } ?>
                                    <?php }else {?>
                                      <?php if(checkModuleFunctionAccess(14,65)){ ?>
                                      <a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/active/<?php echo $row->id; ?>" onclick="return confirm('Are You Sure ?');"><i class="nav-icon fas fa-times"></i> Deactive</a>
                                      <?php } ?>
                                    <?php }?>
                                  </td>
                                </tr>
                                <?php } }?>
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