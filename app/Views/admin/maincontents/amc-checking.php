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
                    <?php if(checkModuleFunctionAccess(6,33)){ ?>
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered table-fit general_table_style">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Project Name</th>
                                    <th scope="col">Check(Days)</th>
                                    <th scope="col">URL</th>                                    
                                    <th scope="col">Action</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($rows){ $sl=1; foreach($rows as $row){?>
                                <tr>
                                    <th scope="row"><?=$sl++?></th>
                                    <td>
                                        <?=$row->name?>                                        
                                    </td>
                                    <td>
                                     <?php  $chk_date = $row->chk_date;
                                         $today_date = date('Y-m-d');
                                        $days_between = date_diff(date_create($chk_date),date_create($today_date));                                         
                                        $days_between->format("%R%a days");                                       
                                        foreach($amc_setting as $amc)
                                        {
                                            $dayspan = $amc->check_span;
                                        } 
                                        
                                        if($chk_date == null){
                                            echo '<span class="label label-danger">Never Checked</span>';
                                        }else if($days_between->format("%a") > $dayspan){
                                        echo '<b>'.$days_between->format("%a").' Days</b><span class="badge bg-danger">Overdue</span>';
                                        }else{
                                          echo $days_between->format("%a");  
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo '<a href="' . $row->permanent_url . '" target="_blank">' . $row->permanent_url . '</a>';
                                        ?>
                                    </td>
                                    <td>                                        
                                        <a href="<?=base_url('admin/' . $controller_route . '/ok_status/'.encoded($row->id))?>" class="btn btn-outline-success btn-sm" title="OK <?=$title?>"><i class="fa fa-check"></i>OK</a>
                                    </td>
                                    <td>                                        
                                        <a href="#exampleModal<?=$row->id?>" role="button" type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$row->id?>">
                                            <i class="fa fa-times"></i>NOT OK</a>
                                         <!-- Modal -->
                                            <div class="modal fade team-assin-modal" id="exampleModal<?=$row->id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Add Reason</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                                                            
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="exampleForm" method="post" class="general_form_style">
                                                                <input type ="hidden" name="project_id" value ="<?=$row->id?>">
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-lg-4">
                                                                            <div class="general_form_left_box">
                                                                                <label for="name" class="col-form-label">User <span class="text-danger">*</span></label>
                                                                            </div>  
                                                                        </div>
                                                                        <div class="col-md-6 col-lg-8">
                                                                            <div class="general_form_right_box">
                                                                                <select name="user_id" class="form-control" id="user_id" required>
                                                                                    <option value="all">All</option>
                                                                                    <hr>
                                                                                    <?php if($users){ foreach($users as $row1){?>
                                                                                        <option value="<?=$row1->id?> "><?=$row1->name?></option>
                                                                                        <hr>
                                                                                    <?php } }?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-lg-4">
                                                                            <div class="general_form_left_box">
                                                                                <label for="type" class="col-form-label">Comment<span class="text-danger">*</span></label>
                                                                            </div>  
                                                                        </div>
                                                                        <div class="col-md-6 col-lg-8">
                                                                            <div class="general_form_right_box">
                                                                                <textarea name="comment" class="form-control" rows="3" required></textarea>
                                                                                <button type="submit" class="btn btn-primary btn-sm font-12 mt-1">Submit</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </td>                                    
                                </tr>
                                <?php } }?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>