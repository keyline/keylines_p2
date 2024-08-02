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
                    <?php if(checkModuleFunctionAccess(6,34)){ ?>
                    <!-- <h5 class="card-title">
                        <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>
                    </h5> -->
                    <?php } ?>
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
                                        //$days_between  = date_diff(date_create("2018-07-07"),date_create("2018-07-09"));
                                        $days_between->format("%R%a days");
                                        // pr($amc_setting);
                                        foreach($amc_setting as $amc)
                                        {
                                            $dayspan = $amc->check_span;
                                        } 
                                        
                                        if($chk_date == null){
                                            echo '<span class="label label-danger">Never Checked</span>';
                                        }else if($days_between->format("%a") > $dayspan){
                                        echo '<span class="label label-warning">'.$days_between->format("%a").'</span><span class="label label-sm label-danger">Need to Check</span>';
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
                                        <!-- <a class="btn btn-sm btn-success" href="amc_ok.php?proj_id=?php echo $row_all_amc['id']; ?>">OK</a> -->
                                        <a href="<?=base_url('admin/' . $controller_route . '/ok_status/'.encoded($row->id))?>" class="btn btn-outline-success btn-sm" title="OK <?=$title?>"><i class="fa fa-check"></i>OK</a>
                                    </td>
                                    <td>
                                        <a href="<?=base_url('admin/' . $controller_route . '/notok_status/'.encoded($row->id))?>" class="btn btn-outline-danger btn-sm" title="NOT OK <?=$title?>"><i class="fa fa-times"></i>NOT OK</a>
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