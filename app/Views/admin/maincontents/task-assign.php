<?php
$user = $session->user_type;
// pr($moduleDetail);
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
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="pagetitle">
                <h5><?=$page_header?></h5>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
                        <li class="breadcrumb-item active"><?=$page_header?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- End Page Title -->
<section class="section profile">
    <div class="container-fluid">
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
        </div>
    </div>
</section>
<section class="task-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">                      
                        <h5 class="fw-bold mb-2">Devoloper Team</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="dt-responsive table-responsive">
                                <table class="table table-bordered nowrap general_table_style">
                                    <thead>
                                        <th>Alolika</th>
                                        <th>Sudip</th>
                                        <th>Deblina</th>
                                        <th>Deep</th>
                                        <th>Alolika</th>
                                        <th>Sudip</th>
                                        <th>Deblina</th>
                                        <th>Deep</th>
                                        <th>Avijit</th>
                                        <th>Avijit</th>
                                        <th>Avijit</th>
                                    </thead>
                                    <tbody>
                                            <tr> 
                                                <?php for($i=0;$i<11;$i++) {  ?>
                                                    
                                                    <td>
                                                        <div class="field_wrapper" id="name<?=$i?>">
                                                            <form action="">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="input-group mb-1">
                                                                            <select name="" id="" class="form-control">
                                                                                <option value="">Select Project</option>
                                                                                <option value="">ABP Podcast Microsite Maintenance  (Biswajit Kolay) - Maintanance</option>
                                                                                <option value="">bengalrowingclub.com mobile app (Joydeep Thakurta) - Development</option>
                                                                                <option value="">Digital Marketing of RDB International HUT (Priyanka Muykherjee) - Promotion</option>
                                                                                <option value="">Gallery Rasa Phase II Maintenance & Modify (Rakesh Sahani) - Development   </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="input-group mb-1">
                                                                            <textarea name="" id="" placeholder="Description" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group mb-1">
                                                                            <input type="text" placeholder="Hour" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group mb-1">
                                                                            <input type="text" placeholder="Min." class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <ul class="d-flex justify-content-center">
                                                                <li>
                                                                    <a href="javascript:void(0);" class="btn btn-info save_button me-2" title="Add field"> <i class="fa-solid fa-floppy-disk"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);" class="btn btn-info save_button me-2" title="Add field"> <i class="fa-solid fa-edit"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);" class="btn btn-info add_button" title="Add field"> <i class="fa fa-circle-plus"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                </td>
                                               <?php }?>
                                            </tr>
                                            
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var maxField = 100; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var x = 1; //Initial field counter is 1
        
        // Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            const id = $(this).data('index');
             alert(id);
            if(x < maxField){
                var fieldHTML = '<div class=" mt-2 pt-2" style="border-top: 1px solid #000" id="name{$id}">\
                                    <form action="">\
                                        <div class="row">\
                                            <div class="col-12">\
                                                <div class="input-group mb-1">\
                                                    <select name="" id="" class="form-control">\
                                                        <option value="">Select Project</option>\
                                                        <option value="">ABP Podcast Microsite Maintenance  (Biswajit Kolay) - Maintanance</option>\
                                                        <option value="">bengalrowingclub.com mobile app (Joydeep Thakurta) - Development</option>\
                                                        <option value="">Digital Marketing of RDB International HUT (Priyanka Muykherjee) - Promotion</option>\
                                                        <option value="">Gallery Rasa Phase II Maintenance & Modify (Rakesh Sahani) - Development   </option>\
                                                    </select>\
                                                </div>\
                                            </div>\
                                            <div class="col-12">\
                                                <div class="input-group mb-1">\
                                                    <textarea name="" id="" placeholder="Description" class="form-control"></textarea>\
                                                </div>\
                                            </div>\
                                            <div class="col-md-6">\
                                                <div class="input-group mb-1">\
                                                    <input type="text" placeholder="Description" class="form-control">\
                                                </div>\
                                            </div>\
                                            <div class="col-md-6">\
                                                <div class="input-group mb-1">\
                                                    <input type="text" placeholder="Description" class="form-control">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </form>\
                                    <ul class="d-flex justify-content-center">\
                                        <li>\
                                            <a href="javascript:void(0);" class="btn btn-info save_button me-2" title="Add field"> <i class="fa-solid fa-floppy-disk"></i></a>\
                                        </li>\
                                        <li>\
                                            <a href="javascript:void(0);" class="btn btn-info save_button me-2" title="Add field"> <i class="fa-solid fa-edit"></i></a>\
                                        </li>\
                                        <li>\
                                            <a href="javascript:void(0);" class="btn btn-info add_button" title="Add field"> <i class="fa fa-circle-plus"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                x++; //Increase field counter
                $(wrapper).append(fieldHTML); //Add field html
            }else{
                alert('A maximum of '+maxField+' fields are allowed to be added. ');
            }
        });
        
        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            if(confirm('Are you sure you want to delete this element?')){
                e.preventDefault();
                $(this).parent('div').parent('div').remove(); //Remove field html
                x--; //Decrease field counter
            }
        });
    });
</script>