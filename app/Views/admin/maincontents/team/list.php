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
<?php if(checkModuleFunctionAccess(18,26)){ ?>
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
                    <!--<h5 class="card-title">-->
                    <!--    <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>-->
                    <!--</h5>-->
                    <div class="row">
                        <div class="col-md-3">
                        <?php foreach($department as $row){?>
                            <div class="card">
                                <div class="card-header text-dark bg-dark-info">                       
                                    <h5 class="fw-bold text-center heading_style"><?=$row->deprt_name?></h5>                            
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="dt-responsive table-responsive">
                                            <table class="table table-striped table-bordered nowrap general_table_style">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>                                                
                                                        <th scope="col">Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $deprt_id = $row->id;
                                                    $sql = "SELECT team.*, user.name FROM `team` INNER JOIN user ON user.id = team.user_id WHERE `dep_id` = ?";
                                                    $query = $db->query($sql, [$deprt_id]);
                                                    $team = $query->getResult();                                                    
                                                
                                                    // Check if the team is not null before accessing its properties
                                                    if ($team !== null) { $sl= 1;
                                                        foreach($team as $teamlist){                                                        
                                                       ?> <tr>
                                                         <th scope="row"><?=$sl++?></th> 
                                                        <td><?=$teamlist->name; if($teamlist->type == "Teamlead"){ echo "(T)"; } elseif($teamlist->type == "Sublead"){ echo "(ST)"; }?></td>
                                                    </tr>
                                                    <?php } } 
                                                        ?>
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
                                    <h5 class="fw-bold text-center heading_style">All Members</h5>                            
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="dt-responsive table-responsive">
                                            <table class="table table-striped table-bordered nowrap general_table_style">
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
                                                        //    pr($row);
                                                        $db = db_connect();
                                                        $department_name =$db->query("SELECT user.id, user.name, user.status, user.department, user.dept_type, department.deprt_name FROM `user` 
                                                        INNER JOIN department ON user.department = department.id 
                                                        WHERE `status` = '1'AND user.id= $row->id ORDER BY `status` DESC, `name` ASC;")->getRow();  
                                                        //  pr($department_name[0]->name);die;
                                                        //  pr($department_name);
                                                    //     echo "<pre>";
                                                    // print_r($department_name);


                                                        ?>
                                                    <tr>
                                                        <th scope="row"><?=$sl++?></th>
                                                        <td style= "text-align: left !important;"><?=$row->name;?></td> 
                                                        <?php
                                                        // if($department_name){ $sl=1; foreach($department_name as $row1){
                                                            //  pr($row1);
                                                        ?>
                                                        <td><?=$department_name->deprt_name ?? null;?></td>
                                                        <!-- ?php } }?>                                                                                    -->
                                                        <td>
                                                            <?php if(checkModuleFunctionAccess(18,27)){ ?>
                                                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample<?=$row->id?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                Add/Edit
                                                            </a>
                                                            <?php } ?>

                                                            <div class="collapse" id="collapseExample<?=$row->id?>">
                                                            <div class="card card-body">
                                                                <form id="exampleForm" method="post">
                                                                    <input type ="hidden" name="user_id" value ="<?=$row->id?>">
                                                                    <div class="form-group">
                                                                        <label for="name" class="col-form-label">Department Id <span class="text-danger">*</span></label>
                                                                        <select name="dep_id" class="form-control" id="search_user_id" required>
                                                                            <option value="all">All</option>
                                                                            <hr>
                                                                            <?php if($department){ foreach($department as $row1){?>
                                                                                <option value="<?=$row1->id?> "<?=(($row->department == $row1->id)?'selected':'')?>><?=$row1->deprt_name?></option>
                                                                                <hr>
                                                                            <?php } }?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
                                                                        <select name="type" class="form-control" id="type" required>
                                                                            <option value="" selected>Select Type</option>
                                                                            <option value="Teamlead"<?=(($row->dept_type == 'Teamlead')?'selected':'')?>>Team Lead</option>
                                                                            <option value="Sublead"<?=(($row->dept_type == 'Sublead')?'selected':'')?>>Sub Lead</option>
                                                                            <option value="Member"<?=(($row->dept_type == 'Member')?'selected':'')?>>Member</option>                                    
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                </form>
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
<?php   } ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
<!-- <script>
    $(document).ready(function() {
        $('#exampleForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            // Your form submission logic here (e.g., AJAX call)
            alert('Form submitted successfully!');
            window.location.href = '<?php base_url('admin/team/list.php')?>';  // Redirect to list page
        });
    });
</script> -->