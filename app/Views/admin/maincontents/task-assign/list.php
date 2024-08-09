<?php
$user_type              = $session->user_type;
$user_id                = $session->user_id;
$getTeamMemberStatus    = $common_model->find_data('team', 'row', ['user_id' => $user_id], 'type');
$team_member_type       = (($getTeamMemberStatus)?$getTeamMemberStatus->type:'');

$title                  = $moduleDetail['title'];
$primary_key            = $moduleDetail['primary_key'];
$controller_route       = $moduleDetail['controller_route'];
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
    .task-assign-table th,
    .task-assign-table td,
    .input-group > .card{
        width: 150px !important;
        vertical-align: top !important;
    }
    .input-group > .card{
        margin-bottom: 5px;
    }
    .bg-blue{
        background: #0d6efdc2;
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

                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="badge bg-primary mb-2"><?=date('M d, Y - l', strtotime("-1 days"));?></h6>
                        <div class="rows">
                            <div class="dt-responsive table-responsive">
                                <table class="table table-bordered nowrap general_table_style task-assign-table">
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
                                                    <?php
                                                    $order_by1[0]               = array('field' => 'morning_meetings.id', 'type' => 'ASC');
                                                    $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'INNER'];
                                                    $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'user_id', 'type' => 'INNER'];
                                                    $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id, user.name as user_name', $join1, '', $order_by1);
                                                    $totalTime                  = 0;
                                                    if($getTasks){ foreach($getTasks as $getTask){
                                                        $tot_hour               = $getTask->hour * 60;
                                                        $tot_min                = $getTask->min;
                                                        $totMins                = $tot_hour + $tot_min;
                                                        $totalTime              += $totMins;
                                                    } }
                                                    $totalBooked    = intdiv($totalTime, 60) . ':' . ($totalTime % 60);
                                                    $totalBooked    = '[' . $totalBooked . ']';
                                                    ?>
                                                    <th style="background-color: <?=$dept->header_color?>;"><?=$teamMember->name?> <br><span id="total-time-<?=$teamMember->id?>"><?=$totalBooked?></span></th>
                                                <?php } } ?>
                                            <?php } } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if($departments){ foreach($departments as $dept){?>
                                                <?php
                                                $teamMembers = $db->query("select u.id,u.name from team t inner join user u on t.user_id = u.id where t.dep_id = '$dept->id' and u.status = '1'")->getResult();
                                                if($teamMembers){ foreach($teamMembers as $teamMember){
                                            ?>
                                                <td>
                                                    <div class="field_wrapper" id="name">
                                                        <div class="row">
                                                            <div class="col-12" id="meeting-user-previous-<?=$teamMember->id?>">
                                                                <?php
                                                                $yesterday                  = date('Y-m-d', strtotime("-1 days"));
                                                                $order_by1[0]               = array('field' => 'morning_meetings.id', 'type' => 'ASC');
                                                                $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'INNER'];
                                                                $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'user_id', 'type' => 'INNER'];
                                                                $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => $yesterday], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id, user.name as user_name, morning_meetings.work_status_id, morning_meetings.effort_id, morning_meetings.next_day_task_action,morning_meetings.priority', $join1, '', $order_by1);
                                                                
                                                                if($getTasks){ foreach($getTasks as $getTask){
                                                                    $getWorkStatus          = $common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color');
                                                                    $work_status_color      = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                                                                ?>
                                                                    <div class="input-group">
                                                                        <div class="card">
                                                                            <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: <?=$work_status_color?>;">
                                                                                <p class="mb-2">
                                                                                    <?php if($getTask->priority == 3){?>
                                                                                        <span><i class="fa-solid fa-medal" style="color: #FFD43B; border:1px solid #FFD43B; border-radius:50%; padding:3px;float:right;" title="High"></i></span>
                                                                                    <?php }?>
                                                                                    <?php if($getTask->priority == 2){?>
                                                                                        <span><i class="fa-solid fa-medal" style="color: #CCCCCC; border:1px solid #CCCCCC; border-radius:50%; padding:3px;float:right;" title="Medium"></i></span>
                                                                                    <?php }?>
                                                                                    <?php if($getTask->priority == 1){?>
                                                                                        <span><i class="fa-solid fa-medal" style="color: #b08d57; border:1px solid #b08d57; border-radius:50%; padding:3px;float:right;" title="Low"></i></span>
                                                                                    <?php }?>
                                                                                    
                                                                                    <span class="mb-1 d-block"><b><?=$getTask->project_name?> :</b> <?=$getTask->description?><br></span> [
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
                                                                                <div class="d-flex justify-content-between">
                                                                                    <p class="mb-0 assign-name"><?=$getTask->user_name?></p>
                                                                                </div>
                                                                                <?php if($application_settings->is_task_approval){?>
                                                                                    <?php if($team_member_type != 'Member'){?>
                                                                                        <?php if($getTask->next_day_task_action <= 0){?>
                                                                                            <div class="d-flex justify-content-end mt-2">
                                                                                                <a href="javascript:void(0);" class="btn-approv bg-success text-light me-1 action-<?=$getTask->schedule_id?>-<?=$teamMember->id?>" onclick="approveTask(<?=$getTask->schedule_id?>, <?=$getTask->effort_id?>, <?=$teamMember->id?>);"><i class="fa-solid fa-check"></i></a>
                                                                                                <a href="javascript:void(0);" class="btn-not-approv bg-danger text-light action-<?=$getTask->schedule_id?>-<?=$teamMember->id?>" onclick="rejectTask(<?=$getTask->schedule_id?>, <?=$getTask->effort_id?>, <?=$teamMember->id?>);"><i class="fa-solid fa-times"></i></a>
                                                                                            </div>
                                                                                        <?php }?>
                                                                                    <?php }?>
                                                                                <?php }?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } }?>
                                                            </div>
                                                        </div>
                                                    </div>
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

                <div class="card">
                    <div class="card-body">
                        <h6 class="badge bg-success mb-2"><?=date('M d, Y - l')?></h6>
                        <div class="rows">
                            <div class="dt-responsive table-responsive">
                                <table class="table table-bordered nowrap general_table_style task-assign-table">
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
                                                $teamMembers = $db->query("select u.id,u.name from team t inner join user u on t.user_id = u.id where t.dep_id = '$dept->id' and u.status = '1'")->getResult();
                                                if($teamMembers){ foreach($teamMembers as $teamMember){
                                                ?>
                                                    <?php
                                                    $order_by1[0]               = array('field' => 'morning_meetings.id', 'type' => 'ASC');
                                                    $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'INNER'];
                                                    $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'user_id', 'type' => 'INNER'];
                                                    $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id, user.name as user_name', $join1, '', $order_by1);
                                                    $totalTime                  = 0;
                                                    if($getTasks){ foreach($getTasks as $getTask){
                                                        $tot_hour               = $getTask->hour * 60;
                                                        $tot_min                = $getTask->min;
                                                        $totMins                = $tot_hour + $tot_min;
                                                        $totalTime              += $totMins;
                                                    } }
                                                    $totalBooked    = intdiv($totalTime, 60) . ':' . ($totalTime % 60);
                                                    $totalBooked    = '[' . $totalBooked . ']';
                                                    ?>
                                                    <th style="background-color: <?=$dept->header_color?>;"><?=$teamMember->name?> <br><span id="total-time-<?=$teamMember->id?>"><?=$totalBooked?></span></th>
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
                                                                $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
                                                                $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority', $join1, '', $order_by1);
                                                                
                                                                if($getTasks){ foreach($getTasks as $getTask){
                                                                    $getWorkStatus          = $common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color');
                                                                    $work_status_color      = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                                                                ?>
                                                                    <div class="input-group">
                                                                        <div class="card">
                                                                            <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: <?=$work_status_color?>;">
                                                                                <p class="mb-2">
                                                                                    <?php if($getTask->priority == 3){?>
                                                                                        <span><i class="fa-solid fa-medal" style="color: #FFD43B; border:1px solid #FFD43B; border-radius:50%; padding:3px;float:right;" title="High"></i></span>
                                                                                    <?php }?>
                                                                                    <?php if($getTask->priority == 2){?>
                                                                                        <span><i class="fa-solid fa-medal" style="color: #CCCCCC; border:1px solid #CCCCCC; border-radius:50%; padding:3px;float:right;" title="Medium"></i></span>
                                                                                    <?php }?>
                                                                                    <?php if($getTask->priority == 1){?>
                                                                                        <span><i class="fa-solid fa-medal" style="color: #b08d57; border:1px solid #b08d57; border-radius:50%; padding:3px;float:right;" title="Low"></i></span>
                                                                                    <?php }?>

                                                                                    <span class="mb-1 d-block"><b><?=$getTask->project_name?> :</b> <?=$getTask->description?><br></span> [
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
                                                                                <div class="d-flex justify-content-between">
                                                                                    <p class="mb-0 assign-name"><?=$getTask->user_name?></p>
                                                                                    <?php if($getTask->work_status_id <= 0){?>
                                                                                        <a href="javascript:void(0);" class="task_edit_btn" onclick="openEditForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>', <?=$getTask->schedule_id?>);">
                                                                                            <i class="fa-solid fa-pencil text-primary"></i>
                                                                                        </a>
                                                                                    <?php }?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } }?>
                                                                <a href="javascript:void(0);" class="task_edit_btn" onclick="openForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>');">
                                                                    <i class="fa-solid fa-plus-circle text-success"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
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
<!-- reject task modal -->
 <div class="modal fade" id="taskRescheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999999;">
        <div class="modal-dialog" role="document" style="max-width: 50%; margin-top: 20px;">
            <div class="modal-content">
                <div class="modal-header" id="taskRescheduleTitle">
                    
                </div>
                <div class="modal-body" id="taskRescheduleBody">
                    
                </div>
            </div>
        </div>
    </div>
<!-- reject task modal -->

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                                            <option value="">Select Hour</option>
                                            <?php for($h=0;$h<=8;$h++){?>
                                                <option value="<?=$h?>" <?=(($h == 0)?'selected':'')?>><?=$h?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <select name="min" class="form-control" id="min" required>
                                            <option value="">Select Minute</option>
                                            <?php for($m=0;$m<=59;$m++){?>
                                                <option value="<?=$m?>" <?=(($m == 0)?'selected':'')?>><?=$m?></option>
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
        dataJson.work_home                  = '';
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
                    $('#meeting-user-' + user_id).html(res.data.scheduleHTML);
                    $('#total-time-' + user_id).html('[' + res.data.totalTime + ']');
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
        dataJson.work_home                  = '';
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
                    $('#meeting-user-' + user_id).html(res.data.scheduleHTML);
                    $('#total-time-' + user_id).html('[' + res.data.totalTime + ']');
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }

    function approveTask(schedule_id, effort_id, user_id){
        var base_url                        = '<?=base_url()?>';
        var dataJson                        = {};
        dataJson.schedule_id                = schedule_id;
        dataJson.effort_id                  = effort_id;
        dataJson.user_id                    = user_id;
        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-schedule-approve-task", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    $('.action-' + schedule_id + '-' + user_id).hide();
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }
    function rejectTask(schedule_id, effort_id, user_id){
        var base_url                        = '<?=base_url()?>';
        var dataJson                        = {};
        dataJson.schedule_id                = schedule_id;
        dataJson.effort_id                  = effort_id;
        dataJson.user_id                    = user_id;
        $('#taskRescheduleModal').modal('show');
        var modalTitle  = 'Task Reschedule';
        var modalBody   = `<form id="taskRescheduleForm">
                            <input type="hidden" name="schedule_id" id="schedule_id" value="${schedule_id}">
                            <input type="hidden" name="effort_id" id="effort_id" value="${effort_id}">
                            <input type="hidden" name="user_id" id="user_id" value="${user_id}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="reschedule_date">Reschedule Date</label>
                                        <input type="date" name="reschedule_date" id="reschedule_date" placeholder="Reschedule Date" class="form-control" value="<?=date('Y-m-d')?>" min="<?=date('Y-m-d')?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-1">
                                        <button type="button" class="btn btn-success" onClick="submitRescheduleTaskForm();">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>`;
        $('#taskRescheduleTitle').empty();
        $('#taskRescheduleBody').empty();
        $('#taskRescheduleTitle').html(modalTitle);
        $('#taskRescheduleBody').html(modalBody);
    }
    function submitRescheduleTaskForm(){
        var base_url                        = '<?=base_url()?>';
        var dataJson                        = {};
        dataJson.schedule_id                = $('#schedule_id').val();
        dataJson.effort_id                  = $('#effort_id').val();
        dataJson.user_id                    = $('#user_id').val();
        dataJson.reschedule_date            = $('#reschedule_date').val();

        schedule_id                         = $('#schedule_id').val();
        effort_id                           = $('#effort_id').val();
        user_id                             = $('#user_id').val();

        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-reschedule-task", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    $('#taskRescheduleModal').modal('hide');
                    $('#meeting-user-' + user_id).empty();
                    $('#meeting-user-' + user_id).html(res.data.scheduleHTML);
                    $('#total-time-' + user_id).html('[' + res.data.totalTime + ']');
                    $('.action-' + schedule_id + '-' + user_id).hide();
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }
    $(function(){
        
    })
</script>