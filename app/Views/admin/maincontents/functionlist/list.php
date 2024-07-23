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
    <?php if(checkModuleFunctionAccess(12,1)){ ?>
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
                    <?php if(checkModuleFunctionAccess(12,2)){ ?>
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
                                        <th>Name</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $i = 1;
                                        foreach ($rows as $row) { ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $row->name; ?></td>
                                                <td>
                                                    <?php if(checkModuleFunctionAccess(12,3)){ ?>
                                                    <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/edit/<?php echo $row->id; ?>"><i class="nav-icon fas fa-edit"></i> Edit</a>
                                                    <?php } ?>
                                                    <?php if(checkModuleFunctionAccess(12,61)){ ?>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?=base_url('admin/' . $moduleDetail['controller'] . '/delete/'. $row->id )?>" class="btn btn-danger btn-sm" title="Delete Function" onclick="return confirm('Do You Want To Delete This function');"><i class="fa fa-trash"></i>Delete</a>
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