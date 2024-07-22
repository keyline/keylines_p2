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
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?=session('success_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
            <?php if(session('error_message')){?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?=session('error_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User Type</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Send</th>
                                <th scope="col">Created At<br>Updated At</th>
                                <!-- <th scope="col">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows){ $sl=1; foreach($rows as $row){?>
                            <tr>
                                <th scope="row"><?=$sl++?></th>
                                <td><?=$row->user_type?></td>
                                <td><?=$row->title?></td>
                                <td><?=$row->description?></td>
                                <td>
                                    <?php if($row->is_send){?>
                                        <span class="badge bg-success">SEND</span><br>
                                        <small><?=date_format(date_create($row->send_timestamp), "M d, Y h:i A")?></small>
                                    <?php } else {?>
                                        <a href="<?=base_url('admin/' . $controller_route . '/send/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" onclick="return confirm('Do You Want To Send This Notification To Respective Users ?');"><i class="fa fa-paper-plane"></i> Send</a>
                                    <?php }?>
                                </td>
                                <td>
                                    <h6>
                                        <?=(($row->created_at != '')?date_format(date_create($row->created_at), "M d, Y h:i A"):'')?><br>
                                        <hr>
                                    </h6>
                                    <h6>
                                        <?=(($row->updated_at != '')?date_format(date_create($row->updated_at), "M d, Y h:i A"):'')?>
                                    </h6>
                                </td>
                                <!-- <td>
                                    <a href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$title?>"><i class="fa fa-edit"></i></a>
                                    <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a>
                                    <?php if($row->status){?>
                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i></a>
                                    <?php } else {?>
                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i></a>
                                    <?php }?>
                                </td> -->
                            </tr>
                            <?php } }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>