<?php
$user               = $session->user_type;
// pr($user);
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<style type="text/css">
    #simpletable_filter {
        float: right;
    }

    .simpletable_length label {
        display: inline-flex;
        padding: 10px;
    }

    .charts {
        border: 1px solid #ff980073;
        padding: 10px;
    }
</style>
<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>            
            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
    <div class="row">
        <div class="col-xl-12">
            <?php if(session('success_message')){?>
            <div class="alert alert-success custom-alert bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="GET" action="" enctype="multipart/form-data">  
                        <input type="hidden" name="mode" value="outside_project_cost">                      
                        <div class="row mb-3 align-items-center">                            
                            <div class="col-md-12 col-lg-12">
                                <label for="search_project_id">Project</label>
                                <select name="project_id" class="form-control" id="search_project_id" required>  
                                    <option value="all">All</option>                                                                      
                                    <?php if ($projects) {
                                        foreach ($projects as $row) { ?>
                                            <option value="<?= $row->id ?>" <?= (($fetch_project_id == $row->id) ? 'selected' : '') ?>><?= $row->name ?> (<?= $row->client_name ?>) - <?= $row->project_status_name ?></option>
                                            <hr>
                                    <?php }
                                    } ?>                                    
                                </select>
                            </div>                               
                        </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Show Exsisting Data</button>                                                                    
                            </div>
                    </form>
                </div>
                <!-- <a href="#exampleModal<?=$fetch_project_id?>" role="button" type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$row->id?>">
                    <i class="fa fa-plus"></i>
                </a> -->
                <!-- Modal -->
                <div class="modal fade team-assin-modal" id="exampleModal<?=$fetch_project_id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="exampleForm" method="post" class="general_form_style">
                                    <input type ="hidden" name="user_id" value ="<?=$row->id?>">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-4">
                                                <label for="date">Date</label>
                                                <input type="date" id="date" name="payment_date" class="form-control" value="" style="height: 40px;">
                                            </div>   
                                            <div class="col-md-4 col-lg-4">
                                                <label for="amount">Amount</label>
                                                <input type="text" id="amount" name="amount" class="form-control" value="" style="height: 40px;">
                                            </div> 
                                            <div class="col-md-4 col-lg-4">
                                                <label for="comment">comment</label>
                                                <textarea type="text" name="comment" class="form-control" style="height: 40px;"></textarea>                                 
                                            </div>  
                                            <button type="submit" class="btn btn-primary btn-sm font-12 mt-1">Submit</button>       
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-md-6 col-lg-4">
                                                <div class="general_form_left_box">
                                                    <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
                                                </div>  
                                            </div>
                                            <div class="col-md-6 col-lg-8">
                                                <div class="general_form_right_box">
                                                    <select name="type" class="form-control" id="type" required>
                                                        <option value="" selected>Select Type</option>
                                                        <option value="Teamlead" ?=(($single_dept_type == 'Teamlead')?'selected':'')?>>Team Lead</option>
                                                        <option value="Sublead" ?=(($single_dept_type == 'Sublead')?'selected':'')?>>Sub Lead</option>
                                                        <option value="Member" ?=(($single_dept_type == 'Member')?'selected':'')?>>Member</option>                                    
                                                    </select>
                                                   
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
                                                              
        </div>
        <div class="col-xl-6">                           
                <div class="card mt-3">
                    <div class="card-body pt-3">
                        <h6 class="fw-bold">Payment Details </h6>                        
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table table-bordered general_table_style">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="15%">Project Name</th>
                                        <th width="15%">Payment Date</th>
                                        <th width="10%">Amount</th>
                                        <th width="7%">Comment</th>
                                        <!-- <th width="30%">Action</th>                                         -->
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php 
                                     if (!empty($payment_details)) { 
                                    $sl=1; foreach ($payment_details as $res) { ?>                                 
                                        <tr>
                                            <td><?=$sl++?></td>
                                            <td><?= $res->name ?></td>
                                            <td><?= $res->payment_date ?></td>
                                            <td><?= $res->amount ?></td>
                                            <td><?= $res->comment ?></td>                                            
                                            <!-- <td>
                                                <a class="btn btn-outline-primary btn-sm" target="_blank" href="?=base_url('admin/outside_project_cost/edit/'.encoded($res->id))?>" title="Edit payment" onclick="return confirm('Do you want to edit this effort ?');"><i class="fa fa-pencil text-primary"></i></a>                                            
                                            </td> -->
                                        </tr> 
                                    <?php } }?>                                                                      
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>                
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">  
                        <input type="hidden" name="mode" value="outside_project_cost_add">
                        <input type="hidden" id="project_id" name="project_id" class="form-control" value="<?=$fetch_project_id?>">
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-6 col-lg-6">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="payment_date" class="form-control" value="" style="height: 40px;">
                            </div>   
                            <div class="col-md-6 col-lg-6">
                                <label for="amount">Amount</label>
                                <input type="text" id="amount" name="amount" class="form-control" value="" style="height: 40px;">
                            </div> 
                            <div class="col-md-12 col-lg-12">
                                <label for="comment">comment</label>
                                <textarea type="text" name="comment" class="form-control" style="height: 40px;"></textarea>                                 
                            </div>                            
                        </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Add Expense</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $("#is_date_range").click(function() {
        if ($(this).is(":checked")) {
            $("#day_range_row").show();
            $("#day_type_row").hide();
        } else {
            $("#day_range_row").hide();
            $("#day_type_row").show();
        }
    });
</script>