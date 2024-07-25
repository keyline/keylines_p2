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
            <!-- <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li> -->
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section dashboard">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="GET" action="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="year">
                        <div class="row mb-3 align-items-center">                                                        
                            <div class="col-md-6 col-lg-6" id="day_type_row" style="display:'block'">
                                <label for="year">Years</label>
                                <select name="year" class="form-control" id="year" required>
                                    <option value="2018" <?=(($year == '2018')?'selected':'')?>>2018</option>
                                    <hr>
                                    <option value="2019" <?=(($year == '2019')?'selected':'')?>>2019</option>
                                    <hr>
                                    <option value="2020" <?=(($year == '2020')?'selected':'')?>>2020</option>
                                    <hr>
                                    <option value="2021" <?=(($year == '2021')?'selected':'')?>>2021</option>
                                    <hr>
                                    <option value="2022" <?=(($year == '2022')?'selected':'')?>>2022</option>
                                    <hr>
                                    <option value="2023" <?=(($year == '2023')?'selected':'')?>>2023</option>
                                    <hr>
                                    <option value="2024" <?=(($year == '2024')?'selected':'')?>>2024</option>
                                    <hr>                                    
                                </select>
                            </div>                                                        
                            <div class="col-md-6 col-lg-6" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Left side columns -->
        <div class="col-lg-12">                       
                <div class="row mt-3">                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-dark bg-dark-info">
                                <h6 class="fw-bold text-center heading_style">Project Report <span id="year"><?=$year?></span></h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-12 col-md-12 table-responsive">
                                        <table class="table table-bordered general_table_style">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Project</th>
                                                    <th>January</th>
                                                    <th>February</th>
                                                    <th>March</th>
                                                    <th>April</th>
                                                    <th>May</th>
                                                    <th>June</th>
                                                    <th>July</th>
                                                    <th>August</th>
                                                    <th>September</th>
                                                    <th>October</th>
                                                    <th>November</th>
                                                    <th>December</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if($responses){ $sl=1; foreach($responses as $response){?>
                                                    <tr>
                                                        <td><?=$sl++?></td>
                                                        <td class="fw-bold"><?=$response['project_name']?></td>
                                                        <td>
                                                            <?=$response['jan_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['feb_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['mar_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['apr_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['may_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['jun_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['jul_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['aug_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['sep_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['oct_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['nov_booked']?>                                                            
                                                        </td>
                                                        <td>
                                                            <?=$response['dec_booked']?>                                                            
                                                        </td>
                                                    </tr>
                                                <?php } }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>                                                                                               
                    </div>                    
                </div>                                
        </div>
        <!-- End Left side columns -->
        
    </div>
</section>
