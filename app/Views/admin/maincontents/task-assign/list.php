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
                                        <tr>
                                            <?php if($departments){ foreach($departments as $dept){?>
                                                <?php
                                                $teamMemberCount = $common_model->find_data('team', 'count', ['dep_id' => $dept->id]);
                                                ?>
                                                <th colspan="<?=$teamMemberCount?>" style="background-color: <?=$dept->header_color?>;"><?=$dept->deprt_name?></th>
                                            <?php } } ?>
                                        </tr>
                                        <tr>
                                            <?php if($departments){ foreach($departments as $dept){?>
                                                <?php
                                                $teamMembers = $db->query("select u.id,u.name from team t inner join user u on t.user_id = u.id where t.dep_id = '$dept->id'")->getResult();
                                                if($teamMembers){ foreach($teamMembers as $teamMember){
                                                ?>
                                                    <th style="background-color: <?=$dept->header_color?>;"><?=$teamMember->name?></th>
                                                <?php } } ?>
                                            <?php } } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if($departments){ foreach($departments as $dept){?>
                                                <?php
                                                $teamMembers = $db->query("select u.id,u.name from team t inner join user u on t.user_id = u.id where t.dep_id = '$dept->id'")->getResult();
                                                if($teamMembers){ foreach($teamMembers as $teamMember){
                                            ?>
                                                <td>
                                                    <div class="field_wrapper" id="name">
                                                        <div class="row">
                                                            <div class="col-12" id="meeting-user-<?=$teamMember->id?>">
                                                                <?php
                                                                $order_by1[0]               = array('field' => 'morning_meetings.id', 'type' => 'ASC');
                                                                $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'INNER'];
                                                                $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id', $join1, '', $order_by1);
                                                                if($getTasks){ foreach($getTasks as $getTask){
                                                                ?>
                                                                    <div class="input-group mb-1">
                                                                        <div class="card">
                                                                            <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 15px;background-color: #fff;border-radius: 10px;text-align: left;vertical-align: top;" onclick="openEditForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>', <?=$getTask->schedule_id?>);">
                                                                                <p>
                                                                                    <b><?=$getTask->project_name?> :</b> <?=$getTask->description?> [
                                                                                        <?php
                                                                                        if($getTask->hour > 0) {
                                                                                            if($getTask->hour == 1){
                                                                                                echo $getTask->hour . " hr ";
                                                                                            } else {
                                                                                                echo $getTask->hour . " hrs ";
                                                                                            }
                                                                                        }
                                                                                        if($getTask->min > 0) {
                                                                                            if($getTask->min == 1){
                                                                                                echo $getTask->min . " min ";
                                                                                            } else {
                                                                                                echo $getTask->min . " mins ";
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    ]
                                                                                </p>
                                                                                <a href="javascript:void(0);" class="task_edit_btn" onclick="openEditForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>', <?=$getTask->schedule_id?>);">
                                                                                    <i class="fa-solid fa-pencil text-primary"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <textarea name="" id="" class="form-control form-control2"></textarea> -->
                                                                    </div>
                                                                <?php } }?>
                                                                <a href="javascript:void(0);" class="task_edit_btn" onclick="openForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>');">
                                                                    <i class="fa-solid fa-plus-circle text-success"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--  -->
                                                </td>
                                                <?php } } ?>
                                            <?php } } ?>
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

<!-- lead activity modal -->
    <div class="modal fade" id="morningformModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999999;">
        <div class="modal-dialog" role="document" style="max-width: 50%; margin-top: 20px;">
            <div class="modal-content">
                <div class="modal-header" id="morningformTitle">
                    
                </div>
                <div class="modal-body" id="morningformBody">
                    
                </div>
            </div>
        </div>
    </div>
<!-- lead activity modal -->

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
<script type="text/javascript">
    function openForm(deptId, userId, userName){
        $('#morningformModal').modal('show');
        var heading = '<h5>Task Schedule For <strong>' + userName + '</strong></h5>';
        var body    = '';
        body        =   `<form id="morningMeetingForm">
                            <input type="hidden" name="dept_id" id="dept_id" value="${deptId}">
                            <input type="hidden" name="user_id" id="user_id" value="${userId}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <input type="date" name="date_added" id="date_added" placeholder="Schedule Date" class="form-control" value="<?=date('Y-m-d')?>" min="<?=date('Y-m-d')?>" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-1">
                                        <select name="project_id" id="project_id" class="form-control" required>
                                            <option value="" selected="">Select Project</option>
                                            <hr>
                                            <?php if($projects){ foreach($projects as $project){?>
                                                <option value="<?=$project->id?>"><?=$project->name?> (<?=$project->client_name?>) - <?=$project->project_status_name?></option>
                                                <hr>
                                            <?php } }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-1">
                                        <textarea name="description" id="description" placeholder="Description" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <select name="hour" class="form-control" id="hour" required>
                                            <option value="" selected>Select Hour</option>
                                            <?php for($h=0;$h<=8;$h++){?>
                                                <option value="<?=$h?>"><?=$h?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <select name="min" class="form-control" id="min" required>
                                            <option value="" selected>Select Minute</option>
                                            <?php for($m=0;$m<=59;$m++){?>
                                                <option value="<?=$m?>"><?=$m?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority1" value="1" required><label for="priority1" style="margin-left : 3px;">Priority LOW</label></span>
                                        <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority2" value="2" required><label for="priority2" style="margin-left : 3px;">Priority MEDIUM</label></span>
                                        <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority3" value="3" required><label for="priority3" style="margin-left : 3px;">Priority HIGH</label></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <span style="margin-left : 10px;"><input type="radio" name="work_home" id="work_home1" value="0" required><label for="work_home1" style="margin-left : 3px;">Work From Office</label></span>
                                        <span style="margin-left : 10px;"><input type="radio" name="work_home" id="work_home2" value="1" required><label for="work_home2" style="margin-left : 3px;">Work From Home</label></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-1">
                                        <button type="button" class="btn btn-success" onClick="submitForm();">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>`;

        $('#morningformTitle').empty();
        $('#morningformBody').empty();
        $('#morningformTitle').html(heading);
        $('#morningformBody').html(body);
    }
    function submitForm(){
        var base_url        = '<?=base_url()?>';
        var dataJson        = {};
        dataJson.dept_id                    = $('#dept_id').val();
        dataJson.user_id                    = $('#user_id').val();
        dataJson.date_added                 = $('#date_added').val();
        dataJson.project_id                 = $('#project_id').val();
        dataJson.description                = $('#description').val();
        dataJson.hour                       = $('#hour').val();
        dataJson.min                        = $('#min').val();
        dataJson.priority                   = $('input[name="priority"]:checked').val();
        dataJson.work_home                  = $('input[name="work_home"]:checked').val();
        var user_id                         = $('#user_id').val();
        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-schedule-submit", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    $('#morningMeetingForm').trigger("reset");
                    $('#morningformModal').modal('hide');
                    $('#meeting-user-' + user_id).empty();
                    $('#meeting-user-' + user_id).html(res.data);
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }

    function openEditForm(deptId, userId, userName, scheduleId){
        var base_url                        = '<?=base_url()?>';
        var dataJson                        = {};
        dataJson.dept_id                    = deptId;
        dataJson.user_id                    = userId;
        dataJson.schedule_id                = scheduleId;
        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-schedule-prefill", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    var heading = '<h5>Task Schedule Modify For <strong>' + userName + '</strong></h5>';
                    var body    = res.data;
                    $('#morningformModal').modal('show');
                    $('#morningformTitle').empty();
                    $('#morningformBody').empty();
                    $('#morningformTitle').html(heading);
                    $('#morningformBody').html(body);
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }
    function submitEditForm(){
        var base_url        = '<?=base_url()?>';
        var dataJson        = {};
        dataJson.dept_id                    = $('#dept_id').val();
        dataJson.user_id                    = $('#user_id').val();
        dataJson.schedule_id                = $('#schedule_id').val();
        dataJson.date_added                 = $('#date_added').val();
        dataJson.project_id                 = $('#project_id').val();
        dataJson.description                = $('#description').val();
        dataJson.hour                       = $('#hour').val();
        dataJson.min                        = $('#min').val();
        dataJson.priority                   = $('input[name="priority"]:checked').val();
        dataJson.work_home                  = $('input[name="work_home"]:checked').val();
        var user_id                         = $('#user_id').val();
        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-schedule-update", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    $('#morningMeetingForm').trigger("reset");
                    $('#morningformModal').modal('hide');
                    $('#meeting-user-' + user_id).empty();
                    $('#meeting-user-' + user_id).html(res.data);
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }
    $(function(){
        // toastAlert("success", 'test');
    })
</script>