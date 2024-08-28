<?php
$user = $session->user_type;
//pr($user);
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<style type="text/css">
    #simpletable_filter{
        float: right;
    }
    .simpletable_length label {
        display: inline-flex;
        padding: 10px;
    }
    .charts{
        border: 1px solid #ff980073;
        padding: 10px;
    }
</style>
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
<!-- End Page Title -->
<section class="section profile">
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="GET" action="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="project-cost">
                        <div class="row mb-3 align-items-center">
                            
                            <div class="col-md-3 col-lg-3">
                                <label for="search_project_id">Project</label>
                                <select name="search_project_id" class="form-control" id="search_project_id" required>
                                    <option value="all" <?=(($search_project_id == 'all')?'selected':'')?>>All</option>
                                    <hr>
                                    <?php if($projects){ foreach($projects as $row){?>
                                        <option value="<?=$row->id?>" <?=(($search_project_id == $row->id)?'selected':'')?>><?=$row->name?> - (<?=$pro->decrypt($row->client_name)?>) - <?=$row->project_status_name?></option>
                                        <hr>
                                    <?php } }?>
                                </select>
                            </div>                                                    
                                                      
                            <div class="col-md-3 col-lg-3">
                                <label for="project_month">Select a Month :</label>
                                <!-- <input type="text" class="form-control" >  -->
                                <select name="project_month" id="project_month">
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>                               
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <label for="project_year">Select a Year :</label>
                                <!-- <input type="text" class="form-control" >  -->
                                <select name="project_year" id="project_year">
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>                                    
                                </select>                               
                            </div>                            
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>                            
                        </div>
                    </form>
                </div>
            </div>
            <?php if(!empty($response)){?>                 
                <div class="card mt-3">
                    <div class="card-body pt-3">
                        <h6 class="alert alert-success"><?=count($response)?> result(s) found</h6>
                        <!-- <h5>
                            <a target="_blank" href="<?php echo base_url(); ?>/admin/<?php echo $moduleDetail['controller']; ?>/download_csv" class="btn btn-success">Downlaod CSV</a>
                        </h5> -->
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table table-bordered table-striped general_table_style">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="15%">Project</th>                                        
                                        <th width="7%">Month</th>
                                        <th width="7%">Year</th>
                                        <th width="7%">Cost</th>
                                        <th width="10%">Created At</th>
                                        <th width="10%">Updated At</th>
                                        <!-- <th width="5%">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                   
                                    foreach($response as $res){?>
                                        <tr>
                                            <td><?=$res['sl_no']?></td>
                                            <td><?=$res['project_name']?></td>
                                            <td><?=$res['month']?></td>
                                            <td><?=$res['year']?></td>
                                            <td><?=$res['project_cost']?></td>
                                            <td><?=$res['created_at']?></td>
                                            <td><?=$res['updated_at']?></td>                                            
                                            <!-- <td>
                                                <a target="_blank" href="<?=base_url('admin/efforts/edit/'.encoded($res['id']))?>" title="Edit Effort" onclick="return confirm('Do you want to edit this effort ?');"><i class="fa fa-pencil text-primary"></i></a>
                                                <br><br>
                                                <?php
                                                $userType           = $session->user_type;
                                                if($userType == 'ADMIN'){
                                                ?>
                                                    <a href="<?=base_url('admin/efforts/delete/'.encoded($res['id']))?>" title="Delete Effort" onclick="return confirm('Do you want to delete this effort from list ?');"><i class="fa fa-trash text-danger"></i></a>
                                                <?php }?>
                                            </td> -->
                                        </tr>
                                        <?php
                                        // $totHour    += $res['hour'];
                                        // $totMinute  += $res['min'];
                                        ?>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                
            <?php }?>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $("#is_date_range").click(function() {
        if($(this).is(":checked")) {
            $("#day_range_row").show();
            $("#day_type_row").hide();
        } else {
            $("#day_range_row").hide();
            $("#day_type_row").show();
        }
    });
</script>