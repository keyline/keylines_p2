<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
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
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message custom-alert mb-2" role="alert">
                    <?=session('success_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
            <?php if(session('error_message')){?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message custom-alert mb-2" role="alert">
                    <?=session('error_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!--<h5 class="card-title">-->
                    <!--    <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>-->
                    <!--</h5>-->
                    <div class="row">
                        <div class="col-md-3">
                        <?php foreach($departments as $row){?>
                            <div class="card">
                                <div class="card-header text-dark bg-dark-info">                       
                                    <h6 class="fw-bold text-center heading_style"><?=$row->deprt_name?></h6>                            
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="dt-responsive table-responsive">
                                            <table class="table table-bordered nowrap general_table_style">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>                                                
                                                        <th scope="col">Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $deprt_id = $row->id;
                                                    $sql = "SELECT team.*, user.name FROM `team` INNER JOIN user ON user.id = team.user_id WHERE team.`dep_id` = '$deprt_id'";
                                                    // $query = $db->query($sql, [$deprt_id]);
                                                    $team = $db->query($sql)->getResult();                                                    
                                                
                                                    // Check if the team is not null before accessing its properties
                                                    if ($team !== null) { $sl= 1;
                                                        foreach($team as $teamlist){                                                        
                                                       ?> <tr>
                                                         <th scope="row"><?=$sl++?></th> 
                                                        <td><?=$teamlist->name; if($teamlist->type == "Teamlead"){ echo "(T)"; } elseif($teamlist->type == "Sublead"){ echo "(ST)"; }?></td>
                                                    </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header text-dark bg-dark-info">                       
                                    <h6 class="fw-bold text-center heading_style">All Members</h6>                            
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="dt-responsive table-responsive">
                                            <table class="table table-bordered nowrap general_table_style">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>                                                
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Department</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php                                                    
                                                    if($users){ $sl=1; foreach($users as $row){
                                                        $department_name =$db->query("SELECT user.id, user.name, user.status, user.department as depart_id, user.dept_type, department.deprt_name FROM `user` 
                                                        INNER JOIN department ON user.department = department.id 
                                                        WHERE user.`status` = '1' AND user.id= $row->id ORDER BY user.`status` DESC, user.`name` ASC")->getRow();
                                                        // echo $db->getlastQuery();
                                                        // pr($row);
                                                        ?>
                                                    <tr>
                                                        <th scope="row"><?=$sl++?></th>
                                                        <td><?=$row->name;?></td>
                                                        <td><?=(($department_name)?$department_name->deprt_name:'')?></td>
                                                        <td class="text-center">
                                                            <a href="#exampleModal<?=$row->id?>" role="button" type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <!-- Modal -->
                                                            <div class="modal fade team-assin-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                        <div class="col-md-6 col-lg-4">
                                                                                            <div class="general_form_left_box">
                                                                                                <label for="name" class="col-form-label">Department Id <span class="text-danger">*</span></label>
                                                                                            </div>  
                                                                                        </div>
                                                                                        <div class="col-md-6 col-lg-8">
                                                                                            <div class="general_form_right_box">
                                                                                                <select name="dep_id" class="form-control" id="search_user_id" required>
                                                                                                    <option value="all">All</option>
                                                                                                    <hr>
                                                                                                    <?php if($departments){ foreach($departments as $row1){?>
                                                                                                        <option value="<?=$row1->id?> "<?=(($row->department == $row1->id)?'selected':'')?>><?=$row1->deprt_name?></option>
                                                                                                        <hr>
                                                                                                    <?php } }?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 col-lg-4">
                                                                                            <div class="general_form_left_box">
                                                                                                <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
                                                                                            </div>  
                                                                                        </div>
                                                                                        <div class="col-md-6 col-lg-8">
                                                                                            <div class="general_form_right_box">
                                                                                                <select name="type" class="form-control" id="type" required>
                                                                                                    <option value="" selected>Select Type</option>
                                                                                                    <option value="Teamlead"<?=(($row->dept_type == 'Teamlead')?'selected':'')?>>Team Lead</option>
                                                                                                    <option value="Sublead"<?=(($row->dept_type == 'Sublead')?'selected':'')?>>Sub Lead</option>
                                                                                                    <option value="Member"<?=(($row->dept_type == 'Member')?'selected':'')?>>Member</option>                                    
                                                                                                </select>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>    
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>