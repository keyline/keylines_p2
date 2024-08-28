<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row">
        <div class="col-xl-12">
            <?php if(session('success_message')){?>
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message custom-alert" role="alert">
                    <?=session('success_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
            <?php if(session('error_message')){?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message custom-alert" role="alert">
                    <?=session('error_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php if (checkModuleFunctionAccess(30, 83)) { ?>
                    <h5 class="card-title">
                        <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm add_effort_btn">Add <?=$title?></a>
                    </h5>
                    <?php } ?>
                    <div class="dt-responsive table-responsive">
                        <?php if (checkModuleFunctionAccess(30, 82)) { ?>
                            <table id="simpletable" class="table table-bordered nowrap general_table_style">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Status Name</th>
                                        <th scope="col">Background Color</th>
                                        <th scope="col">Border Color</th>
                                        <th scope="col">Is Schedule</th>
                                        <th scope="col">Is Reassign</th>
                                        <th scope="col">Created At<br>Updated At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($rows){ $sl=1; foreach($rows as $row){?>
                                    <tr>
                                        <th scope="row"><?=$sl++?></th>
                                        <td><?=$row->name?></td>
                                        <td><span style="border-radius: 50%; background-color: <?=$row->background_color?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                                        <td><span style="border-radius: 50%; background-color: <?=$row->border_color?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                                        <td><?=(($row->is_schedule)?'<span class="badge bg-success">YES</span>':'<span class="badge bg-danger">NO</span>')?></td>
                                        <td><?=(($row->is_reassign)?'<span class="badge bg-success">YES</span>':'<span class="badge bg-danger">NO</span>')?></td>
                                        <td class="text-center">
                                            <h6>
                                                <?=(($row->created_at != '')?date_format(date_create($row->created_at), "M d, Y h:i A"):'')?>
                                            </h6>
                                            <h6 <?php if($row->updated_at != ''){?>
                                                echo style=" border-top: 1px solid #444444; margin-top: 15px; padding: 15px 20px 0; width: auto; display: inline-block;"
                                            <?php }?>>
                                                <?=(($row->updated_at != '')?date_format(date_create($row->updated_at), "M d, Y h:i A"):'')?>
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <?php if (checkModuleFunctionAccess(30, 84)) { ?>
                                            <a href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$title?>"><i class="fa fa-edit"></i></a>
                                            <?php } ?>
                                            <?php if (checkModuleFunctionAccess(30, 85)) { ?>
                                            <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
                                            <?php if($row->status){?>
                                                <?php if (checkModuleFunctionAccess(30, 86)) { ?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i></a>
                                                <?php } ?>
                                            <?php } else {?>
                                                <?php if (checkModuleFunctionAccess(30, 87)) { ?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i></a>
                                                <?php } ?>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php } }?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>