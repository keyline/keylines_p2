<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<style>
/* Initially hide the form */
.hidden {
    display: none;
}
/* Style the form container */
#form-container {
    margin-top: 20px;
}
</style>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<?php if(checkModuleFunctionAccess(4,20)){ ?>
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
        <!-- ?php
        pr($row);
            if($row){
              $name                 = $row->name;              
              $hour_cost            = $row->hour_cost;             
            } else {
              $name                 = '';         
              $hour_cost            = '';             
            }
            ?> -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">                    
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap general_table_style">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name<br>User ID</th>
                                    <th scope="col">Hour Cost</th>                                    
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($rows){ $sl=1; foreach($rows as $row){ ?>
                                <tr>
                                    <th scope="row"><?=$sl++?></th>
                                    <td><?=$row->name?><span class="badge bg-warning ms-1"><?=$row->id?></span></td>
                                    <td>                                                                              
                                        <form method="POST" action="" enctype="multipart/form-data" class="general_form_style"> 
                                            <input type = "hidden" name="id" value="<?=$row->id?>">                                   
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <!--Hour Cost field -->                                                        
                                                    <div class="col-md-10 col-lg-10">
                                                        <div class="general_form_right_box">
                                                            <input type="text" name="hour_cost" class="form-control" id="hour_cost" value="<?=$row->hour_cost?>" onkeypress="return isNumber(event)">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                                                                   
                                    </td>                                                                        
                                    <td>                                        
                                            <input type="submit" value="Submit">                                     
                                        </form>   
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
</section>
<!-- <script>
    // Get the icon and form container elements
    const icon = document.getElementById('icon');
    const formContainer = document.getElementById('form-container');

    // Add click event listener to the icon
    icon.addEventListener('click', function() {
        // Toggle the visibility of the form container
        formContainer.classList.toggle('hidden');
    });
</script> -->
<?php   } ?>