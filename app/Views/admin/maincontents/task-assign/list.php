<?php
$user_type              = $session->user_type;
$user_id                = $session->user_id;
$getTeamMemberStatus    = $common_model->find_data('team', 'row', ['user_id' => $user_id], 'type');
$team_member_type       = (($getTeamMemberStatus)?$getTeamMemberStatus->type:'');

$title                  = $moduleDetail['title'];
$primary_key            = $moduleDetail['primary_key'];
$controller_route       = $moduleDetail['controller_route'];
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<!-- <link rel="stylesheet" href="https://amphiluke.github.io//jquery-plugins/floatingscroll/jquery.floatingscroll.css"/> -->

<link rel="stylesheet" href="style.css">
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
    .drag-box{
        overflow: hidden;
    }
    .task-assign-table {
        cursor: grab;
    }
    .task-assign-table tbody > tr,
    .task-assign-table thead > th{
        background: transparent !important;
    }
    .task-assign-table .fixed-table-head tr:first-child th{
        padding: 5px 10px !important
    }
    .fixed-table-head > tr{
        background-color: #e4f3ff !important;
    }
    .task-section .accordion-header{
        position: sticky;
        top: 70px;
        z-index: 5;
    } 
    .task-section .accordion-body{
        padding: 5px 15px;
        background: #f0e9d9;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    } 
    .task-assign-table{
        user-select: none;
    }
    .task-assign-table th,
    .task-assign-table td,
    .input-group > .card{
        width: 300px !important;
        vertical-align: top !important;
        border: 1px solid #e4f3ff;
        color: #000;
    }
    .task-assign-table th,
    .task-assign-table td{
        padding: 12px 8px !important; 
    }
    .task-assign-table td{
        text-align: center
    }
    .field_wrapper{
        width: 300px;
    }
    .input-group > .card{
        margin-bottom: 5px;
    }
    .bg-blue{
        background: #0d6efdc2;
    }
    /* .card_projectname {
        padding-bottom: 5px;
    } */
    .card_projectname,
    .card_projecttime{
        font-size: 12px !important;
    }
    .card_proj_info{
        font-size: 11px !important;
    }
    .card_projecttime {
        font-weight: 700;
        margin-bottom: 0;
        padding-top: 5px;
    }
    span.card_priotty_item {
        position: absolute;
        right: 10px;
        top: 10px;
        background: #ddd;
        /* padding: 2px 5px; */
        font-size: 10px;
        font-weight: 600;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    span.card_priotty_item.proiodty_high {
        background: #ff2625;
        color: #fff;
    }
    span.card_priotty_item.proiodty_medium {
        background: #1d80ff;
        color: #fff;
    }
    span.card_priotty_item.proiodty_low {
        background: #979797;
        color: #fff;
    }
    a.taskedit_iconright {
        float: right;
        margin: inherit;
    }
    .choices__list--multiple .choices__item {
        background-color: #ffc107;
        border: 1px solid #ffc107;
    }
    .bg-default{
        background-color: #fff;
    }
    .accordion-item{
        border-radius: 8px;
        border: none;
        margin-bottom: 8px
    }
    .accordion-header,
    .accordion-button{
        border-radius: 8px;
    }
    .accordion-button{
        padding: 10px 15px;
    }
    .task_add_btn i{
        font-size: 25px;
        color: #3ca936;
        margin-top: 5px;
    }
    .choices__list.choices__list--dropdown{
        z-index: 6;
    }
    .table-lagend-box{
        padding: 10px 0;
    }
    .table-lagend{
        width: 20px;
        height: 20px;
        margin: 0 5px;
        display: inline-block;
    }
    .light-yellow{
        background: #f0e9d9;
    }
    .dark-yellow{
        background: #ce7c26;
    }
    .design-text{
        color: #ce7c26;
    }
    .dev-text{
        color: #6da0bd
    }
    .light-blue{
        background: #dbf1fe;
    }
    .dark-blue{
        background: #6da0bd;
    }
    .digi-text{
        color: #6da0bd
    }
    .light-purple{
        background: #dcc6ed;
    }
    .dark-purple{
        background: #a57dc3;
    }
    .light-high{
    background: #ff2525;
    border-radius: 50%;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items:center;
    font-size: 12px;
    }
    .dark-mid{
    background: #1b81ff;
    border-radius: 50%;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items:center;
    font-size: 12px;
        
    }
    .dark-low{
    background: #989898;
    border-radius: 50%;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items:center;
    font-size: 12px;
        
    }
    .accordion-button:not(.collapsed){
        background: #f0e9d9;
        color: #000;
        box-shadow: none;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        border-top: 1px solid #ffb60f;
    }
    .accordion-collapse{
        border-radius: 8px;
    }
    .accordion-button:not(.collapsed)::after{
        filter: brightness(1) invert(1);
    }
    .choices__inner{
        border-radius: 5px;
        border: 1px solid #ccc;
        height: 48px;
        overflow: auto
    }
    .filter-btn{
        background: #424242;
        color: #fff;
        padding: 8px 20px;
        border-radius: 5px
    }
    .filter-btn img{
        margin-right: 5px;
    }
    .filter-btn:hover{
        background: #000;
        color: #fff
    }
    .gray_body{
        background: #f0f0f0;
        margin: -20px -15px -42px;
        padding: 20px 20px 35px;
        border-radius: 12px
    }
</style>
<div class="maze" style="display: none;">
    <canvas id="mazecnv" width="1840" height="1086"></canvas>
</div>

<div class="gray_body">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex">
                <div class="pagetitle me-5">
                    <h5><?=$page_header?></h5>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
                            <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
                            <li class="breadcrumb-item active"><?=$page_header?></li>
                        </ol>
                    </nav>
                </div>
                <div class="filtrable-box mb-3 mb-md-0 w-50">
                    <form method="POST" action="">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-6 col-sm-8">
                                <select class="form-control" id="choices-multiple-remove-button" name="tracker_depts_show[]" multiple>
                                    <!-- <option value="0">Only Mine</option> -->
                                    <?php if($all_departments){ foreach($all_departments as $dept){?>
                                        <option value="<?=$dept->id?>" <?=((in_array($dept->id, $tracker_depts_show))?'selected':'')?>><?=$dept->deprt_name?></option>
                                    <?php } }?>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-4" style="margin-left: -10px">
                                <button type="submit" class="btn filter-btn"><img src="<?= base_url('public/uploads/filter.webp')?>" alt="" class="img-fluid" style="width: 15px"> Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
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
            <div class="col-12 table-card">
                
            </div>
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-body">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <?php
                            if(!empty($date_array)){ for($k=0;$k<count($date_array);$k++){
                                $singleDate         = $date_array[$k];
                            ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                      <button class="accordion-button accordion-button-prev bg-default collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?=$k?>" aria-expanded="true" aria-controls="panelsStayOpen-collapse<?=$k?>" data-task-date="<?=$singleDate?>">
                                        <h6><?=date_format(date_create($singleDate), "M d, Y l")?></h6>
                                      </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapse<?=$k?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                      <div class="accordion-body" id="task-list-<?=$singleDate?>">
                                        
                                      </div>
                                    </div>
                                </div>
                            <?php } }?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button accordion-button-prev bg-default collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        <h6><?=date('M d, Y - l', strtotime("-1 days"));?></h6>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <div class="rows">
                                            <div class="dt-responsive whatwg drag-box fixed-header">
                                                <table id="wrapper" class="table nowrap general_table_style task-assign-table applies drag">
                                                    <thead class="fixed-table-head">
                                                        <tr>
                                                            <?php if($departments){ foreach($departments as $dept){?>
                                                                <?php
                                                                $join[0]                    = ['table' => 'user', 'field' => 'id', 'table_master' => 'team', 'field_table_master' => 'user_id', 'type' => 'INNER'];
                                                                $teamMemberCount            = $common_model->find_data('team', 'count', ['team.dep_id' => $dept->id, 'user.status' => '1'], '', $join);
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
                                                                    $yesterday                  = date('Y-m-d', strtotime("-1 days"));
                                                                    $order_by1[0]               = array('field' => 'morning_meetings.id', 'type' => 'ASC');
                                                                    $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'INNER'];
                                                                    $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'user_id', 'type' => 'INNER'];
                                                                    $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => $yesterday], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id, user.name as user_name', $join1, '', $order_by1);
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
                                                                    <th style="background-color: <?=$dept->header_color?>;">
                                                                        <div class="d-flex justify-content-between">
                                                                            <?=$teamMember->name?> <br><span id="total-time-previous-<?=$teamMember->id?>"><?=$totalBooked?></span>
                                                                        </div>
                                                                    </th>
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
                                                                <td style="background-color: <?=$dept->body_color?>;">
                                                                    <div class="field_wrapper" id="name">
                                                                        <div class="row">
                                                                            <div class="col-12" id="meeting-user-previous-<?=$teamMember->id?>">
                                                                                <?php
                                                                                $yesterday                  = date('Y-m-d', strtotime("-1 days"));
                                                                                $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                                                                                $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                                                                                $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'user_id', 'type' => 'INNER'];
                                                                                $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => $yesterday], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at', $join1, '', $order_by1);
                                                                                
                                                                                if($getTasks){ foreach($getTasks as $getTask){
                                                                                    $getWorkStatus                  = $common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color,border_color');
                                                                                    $work_status_color              = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                                                                                    $work_status_border_color       = (($getWorkStatus)?$getWorkStatus->border_color:'#0c0c0c4a');
                                                                                ?>
                                                                                    <div class="input-group">
                                                                                        <div class="card">
                                                                                            <div class="card-body" style="border: 1px solid <?=$work_status_border_color?>;width: 100%;padding: 8px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top; box-shadow: 0 0 15px -13px #000; background-color: <?=$work_status_color?>;">
                                                                                                
                                                                                                <p>
                                                                                                    <?php if($getTask->is_leave == 0){?>
                                                                                                        <?php if($getTask->priority == 3){?>
                                                                                                            <span class="card_priotty_item proiodty_high">H</span>
                                                                                                        <?php }?>
                                                                                                        <?php if($getTask->priority == 2){?>
                                                                                                            <span class="card_priotty_item proiodty_medium">M</span>
                                                                                                        <?php }?>
                                                                                                        <?php if($getTask->priority == 1){?>
                                                                                                            <span class="card_priotty_item proiodty_low">L</span>
                                                                                                        <?php }?>
                                                                                                    <?php }?>
                                                                                                </p>

                                                                                                <?php
                                                                                                if($getTask->project_name != ''){
                                                                                                    $projectName = $getTask->project_name;
                                                                                                } else {
                                                                                                    if($getTask->is_leave == 1){
                                                                                                        $projectName = 'HALFDAY LEAVE';
                                                                                                    } else {
                                                                                                        $projectName = 'FULLDAY LEAVE';
                                                                                                    }
                                                                                                }

                                                                                                if($getTask->is_leave == 0){
                                                                                                    $display = 'block';
                                                                                                } else {
                                                                                                    $display = 'none';
                                                                                                }
                                                                                                ?>
                                                                                                    
                                                                                                <div class="mb-1 d-block">
                                                                                                    <div class="card_projectname"><b><?=$projectName?> :</b> </div>
                                                                                                    <div class="card_proj_info"><?=$getTask->description?><br></div> 
                                                                                                </div>

                                                                                                <div class="card_projecttime">
                                                                                                    [<?php
                                                                                                    if($getTask->hour > 0) {
                                                                                                        if($getTask->hour == 1){
                                                                                                            echo $getTask->hour . " hr ";
                                                                                                        } else {
                                                                                                            echo $getTask->hour . " hrs ";
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo "0 hr ";
                                                                                                    }
                                                                                                    if($getTask->min > 0) {
                                                                                                        if($getTask->min == 1){
                                                                                                            echo $getTask->min . " min";
                                                                                                        } else {
                                                                                                            echo $getTask->min . " mins";
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo "0 min";
                                                                                                    }
                                                                                                    ?>]
                                                                                                </div>
                                                                                                <?php
                                                                                                if($getTask->updated_at == ''){
                                                                                                    $createdAt = date_format(date_create($getTask->created_at), "h:i a");
                                                                                                } else {
                                                                                                    $createdAt = date_format(date_create($getTask->updated_at), "h:i a");
                                                                                                }
                                                                                                ?>
                                                                                                <div class="d-flex justify-content-between">
                                                                                                    <p class="mb-0 assign-name">By <?=$getTask->user_name?> <span class="ms-1">(<?=$createdAt?>)</span></p>
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
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        <h6><?=date('M d, Y - l')?></h6>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">
                                        <div class="rows">
                                            <div class="dt-responsive whatwg drag-box fixed-header">
                                                <table id="myTable input-type-attr-summary wrapper2"  class="table general_table_style task-assign-table applies drag">
                                                    <thead class="fixed-table-head">
                                                        <tr>
                                                            <?php if($departments){ foreach($departments as $dept){?>
                                                                <?php
                                                                $join[0]                    = ['table' => 'user', 'field' => 'id', 'table_master' => 'team', 'field_table_master' => 'user_id', 'type' => 'INNER'];
                                                                $teamMemberCount            = $common_model->find_data('team', 'count', ['team.dep_id' => $dept->id, 'user.status' => '1'], '', $join);
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
                                                                    <th style="background-color: <?=$dept->header_color?>;">
                                                                        <div class="d-flex justify-content-between">
                                                                            <?=$teamMember->name?> <br><span id="total-time-<?=$teamMember->id?>"><?=$totalBooked?></span>
                                                                        </div>
                                                                    </th>
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
                                                                    $application_settings    = $common_model->find_data('application_settings', 'row');
                                                                    $edit_time_after_task_add = $application_settings->edit_time_after_task_add;
                                                                    if($type == 'SUPER ADMIN'){
                                                                        $alterIcon = 1;
                                                                    } elseif($type == 'ADMIN'){
                                                                        $alterIcon = 1;
                                                                    } elseif($type == 'USER'){
                                                                        if($user_id == $teamMember->id){
                                                                            $alterIcon = 1;
                                                                        } else {
                                                                            $alterIcon = 0;
                                                                        }
                                                                    } else {
                                                                        $alterIcon = 0;
                                                                    }
                                                            ?>
                                                                <td style="background-color: <?=$dept->body_color?>;">
                                                                    <div class="field_wrapper" id="name">
                                                                        <div class="row">
                                                                            <div class="col-12" id="meeting-user-<?=$teamMember->id?>">
                                                                                <?php
                                                                                $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                                                                                $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                                                                                $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
                                                                                $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at', $join1, '', $order_by1);
                                                                                
                                                                                if($getTasks){ foreach($getTasks as $getTask){
                                                                                    $getWorkStatus                  = $common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color,border_color');
                                                                                    $work_status_color              = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                                                                                    $work_status_border_color       = (($getWorkStatus)?$getWorkStatus->border_color:'#0c0c0c4a');
                                                                                ?>
                                                                                    <div class="input-group">
                                                                                        <div class="card">
                                                                                            <div class="card-body" style="border: 1px solid <?=$work_status_border_color?>;width: 100%;padding: 8px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top; box-shadow: 0 0 15px -13px #000; background-color: <?=$work_status_color?>;">
                                                                                                <p>
                                                                                                    <?php if($getTask->is_leave == 0){?>
                                                                                                        <?php if($getTask->priority == 3){?>
                                                                                                            <span class="card_priotty_item proiodty_high">H</span>
                                                                                                        <?php }?>
                                                                                                        <?php if($getTask->priority == 2){?>
                                                                                                            <span class="card_priotty_item proiodty_medium">M</span>
                                                                                                        <?php }?>
                                                                                                        <?php if($getTask->priority == 1){?>
                                                                                                            <span class="card_priotty_item proiodty_low">L</span>
                                                                                                        <?php }?>
                                                                                                    <?php }?>
                                                                                                </p>

                                                                                                <?php
                                                                                                if($getTask->project_name != ''){
                                                                                                    $projectName = $getTask->project_name;
                                                                                                } else {
                                                                                                    if($getTask->is_leave == 1){
                                                                                                        $projectName = 'HALFDAY LEAVE';
                                                                                                    } else {
                                                                                                        $projectName = 'FULLDAY LEAVE';
                                                                                                    }
                                                                                                }

                                                                                                if($getTask->is_leave == 0){
                                                                                                    $display = 'block';
                                                                                                } else {
                                                                                                    $display = 'none';
                                                                                                }
                                                                                                ?>

                                                                                                <div class="mb-1 d-block">
                                                                                                    <div class="card_projectname"><b><?=$projectName?> :</b> </div>
                                                                                                    <div class="card_proj_info"><?=$getTask->description?><br></div> 
                                                                                                </div>
                                                                                                <div class="card_projecttime">
                                                                                                    [<?php
                                                                                                    if($getTask->hour > 0) {
                                                                                                        if($getTask->hour == 1){
                                                                                                            echo $getTask->hour . " hr ";
                                                                                                        } else {
                                                                                                            echo $getTask->hour . " hrs ";
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo "0 hr ";
                                                                                                    }
                                                                                                    if($getTask->min > 0) {
                                                                                                        if($getTask->min == 1){
                                                                                                            echo $getTask->min . " min";
                                                                                                        } else {
                                                                                                            echo $getTask->min . " mins";
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo "0 min";
                                                                                                    }
                                                                                                    ?>]
                                                                                                </div>

                                                                                                <div class="d-flex justify-content-between">
                                                                                                    <?php
                                                                                                    if($getTask->updated_at == ''){
                                                                                                        $createdAt = date_format(date_create($getTask->created_at), "h:i a");
                                                                                                    } else {
                                                                                                        $createdAt = date_format(date_create($getTask->updated_at), "h:i a");
                                                                                                    }

                                                                                                    $time1 = new DateTime($getTask->created_at);
                                                                                                    $time2 = new DateTime(date('Y-m-d H:i:s'));
                                                                                                    // Get the difference
                                                                                                    $interval = $time1->diff($time2);
                                                                                                    // Convert the difference to total minutes
                                                                                                    $minutes = ($interval->h * 60) + $interval->i;
                                                                                                    ?>
                                                                                                    <p class="mb-0 assign-name">
                                                                                                        By <?=$getTask->user_name?> <span class="ms-1">(<?=$createdAt?>)</span>
                                                                                                        <?php if($getTask->work_status_id <= 0){?>
                                                                                                            <br>
                                                                                                            <span><a href="javascript:void(0);" class="badge bg-success text-light" onclick="openEffortSubmitForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>', <?=$getTask->schedule_id?>);">Add To Effort</a></span>
                                                                                                        <?php }?>
                                                                                                    </p>

                                                                                                    <?php if($getTask->work_status_id <= 0){?>
                                                                                                        <?php if($alterIcon){?>
                                                                                                            <?php if($minutes <= $edit_time_after_task_add){?>
                                                                                                                <a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>', <?=$getTask->schedule_id?>);" style="display: <?=$display?>;">
                                                                                                                    <i class="fa-solid fa-pencil text-primary"></i>
                                                                                                                </a>
                                                                                                            <?php }?>
                                                                                                        <?php }?>
                                                                                                    <?php }?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } }?>

                                                                                <?php
                                                                                $getLeaveTask                   = $common_model->find_data('morning_meetings', 'row', ['user_id' => $teamMember->id, 'date_added' => date('Y-m-d'), 'is_leave>' => 0], 'is_leave');
                                                                                if(!$getLeaveTask){
                                                                                    if($alterIcon){
                                                                                ?>
                                                                                        <a href="javascript:void(0);" class="task_add_btn" onclick="openForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>');">
                                                                                            <i class="fa-solid fa-plus-circle"></i>
                                                                                        </a>
                                                                                    <?php }?>
                                                                                <?php } else {?>
                                                                                    <?php if($getLeaveTask->is_leave == 1){?>
                                                                                        <?php if($alterIcon){?>
                                                                                            <a href="javascript:void(0);" class="task_add_btn" onclick="openForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>');">
                                                                                                <i class="fa-solid fa-plus-circle"></i>
                                                                                            </a>
                                                                                        <?php }?>
                                                                                    <?php }?>
                                                                                <?php }?>
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
                </div>

            </div>
        </div>
    </div>
</section>

<!-- lead activity modal -->
    <div class="modal fade" id="morningformModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999999;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 50%; margin-top: 20px;">
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
</div>

<!-- <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script> -->
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
                                <div class="col-4">
                                    <div class="input-group mb-1">
                                        <select name="project_id" id="project_id" class="form-control" required>
                                            <option value="" selected="">Select Project</option>
                                            <hr>
                                            <?php if($projects){ foreach($projects as $project){?>
                                                <option value="<?=$project->id?>"><?=$project->name?> (<?=$pro->decrypt($project->client_name)?>) - <?=$project->project_status_name?></option>
                                                <hr>
                                            <?php } }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-1">
                                        <input type="date" name="date_added" id="date_added" placeholder="Schedule Date" class="form-control" value="<?=date('Y-m-d')?>" min="<?=date('Y-m-d')?>" required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group mb-1">
                                        <span style="margin-left : 10px;"><input type="radio" name="is_leave" id="leave0" value="0" onchange="myFunction()" checked><label for="leave0" style="margin-left : 3px;">PRESENT</label></span>
                                        <span style="margin-left : 10px;"><input type="radio" name="is_leave" id="leave1" value="1" onchange="myFunction()"><label for="leave1" style="margin-left : 3px;">HALFDAY LEAVE</label></span>
                                        <span style="margin-left : 10px;"><input type="radio" name="is_leave" id="leave2" value="2" onchange="myFunction()"><label for="leave2" style="margin-left : 3px;">FULLDAY LEAVE</label></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-1">
                                        <textarea name="description" id="description" placeholder="Description" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-1">
                                        <select name="hour" class="form-control" id="hour" required>
                                            <option value="">Select Hour</option>
                                            <?php for($h=0;$h<=8;$h++){?>
                                                <option value="<?=$h?>" <?=(($h == 0)?'selected':'')?>><?=$h?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                        <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority2" value="2" checked required><label for="priority2" style="margin-left : 3px;">Priority MEDIUM</label></span>
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
        dataJson.is_leave                   = $('input[name="is_leave"]:checked').val();
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
                } else {
                    $('#morningMeetingForm').trigger("reset");
                    $('#morningformModal').modal('hide');
                    toastAlert("error", res.message);
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
        dataJson.is_leave                   = 0;
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

    function openEffortSubmitForm(deptId, userId, userName, scheduleId){
        var base_url                        = '<?=base_url()?>';
        var dataJson                        = {};
        dataJson.dept_id                    = deptId;
        dataJson.user_id                    = userId;
        dataJson.schedule_id                = scheduleId;
        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-schedule-prefill-effort-booking", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    var heading = '<h5>Task Effort Booking For <strong>' + userName + '</strong></h5>';
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
    function myFunction(){
        var selectedValue = $('input[name=is_leave]:checked').val();
        if(selectedValue == 0){
            var description = '';
            $('#description').val(description);
            $('#project_id').attr('required', true);
            $('#hour').attr('required', true);
            $('#min').attr('required', true);
            $('input[name="priority"]').attr('required', true);

            $('#project_id').attr('disabled', false);
            $('#hour').attr('disabled', false);
            $('#min').attr('disabled', false);
            $('input[name="priority"]').attr('disabled', false);
        } else if(selectedValue == 1){
            var description = 'Half Day Leave Taken';
            $('#description').val(description);
            $('#project_id').attr('required', false);
            $('#hour').attr('required', false);
            $('#min').attr('required', false);
            $('input[name="priority"]').attr('required', false);

            $('#project_id').attr('disabled', true);
            $('#hour').attr('disabled', true);
            $('#min').attr('disabled', true);
            $('input[name="priority"]').attr('disabled', true);
        } else if(selectedValue == 2){
            var description = 'Full Day Leave Taken';
            $('#description').val(description);
            $('#project_id').attr('required', false);
            $('#hour').attr('required', false);
            $('#min').attr('required', false);
            $('input[name="priority"]').attr('required', false);

            $('#project_id').attr('disabled', true);
            $('#hour').attr('disabled', true);
            $('#min').attr('disabled', true);
            $('input[name="priority"]').attr('disabled', true);
        }
    }
    $(document).ready(function(){    
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount:5,
            searchResultLimit:5,
            renderChoiceLimit:5
        });     
    });
    $(document).ready(function() {
      // Event listener for when an accordion item is clicked
      $('.accordion-button').on('click', function() {
            var targetPanel = $(this).attr('data-bs-target'); // Get the target panel ID
            // Check if the panel is open
            // if ($(targetPanel).hasClass('show')) {
            if (!$(this).hasClass('collapsed')) {
                // console.log('The accordion is open.');
                var taskDate                        = $(this).attr('data-task-date');
                var base_url                        = '<?=base_url()?>';
                var dataJson                        = {};
                dataJson.taskDate                   = taskDate;
                $.ajax({
                    type: 'POST',
                    url: base_url + "admin/task-assign/morning-meeting-get-previous-task", // Replace with your server endpoint
                    data: JSON.stringify(dataJson),
                    success: function(res) {
                        console.log(res);
                        res = $.parseJSON(res);
                        if(res.success){
                            $('#task-list-' + taskDate).html(res.data.scheduleHTML);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error); // Handle errors
                    }
                });
            } else {
              // console.log('The accordion is closed.');
            }
        });
    });
</script>
