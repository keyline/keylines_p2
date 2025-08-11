<?php
if ($row) {
    $name                    = $row->name;
} else {
    $name                    = '';
}
?>
<script src="//cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="pagetitle">
                <h1><?=$page_header?></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
                        <li class="breadcrumb-item active"><?=$page_header?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-content">
    <!-- <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><?php echo $page_header; ?></h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="?php echo base_url('admin/'); ?>/user"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="?php echo base_url('admin/dashboard'); ?>">Home </a></li>
                        <li class="breadcrumb-item"><a href="#!">?php echo $page_header; ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="col-sm-12">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="module_name">Role Master Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="role_master_name" id="role_master_name" value="<?= $name ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center" style="margin-top: 10px;">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('role_master_name').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>