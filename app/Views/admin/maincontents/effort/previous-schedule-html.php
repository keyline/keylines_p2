<?php
use App\Models\CommonModel;
use App\Libraries\Pro;
$common_model               = new CommonModel;
$db                         = \Config\Database::connect();
$pro                        = new Pro();
$generalSetting             = $common_model->find_data('general_settings', 'row');
?>
<div class="rows">
    <div class="dt-responsive table-responsive whatwg drag-box">
        <table id="wrapper" class="table general_table_style task-assign-table applies drag">
            <thead>
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
                            $yesterday                  = $taskDate;
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
                            <th style="background-color: <?=$dept->header_color?>;"><?=$teamMember->name?> <br><span id="total-time-previous-<?=$teamMember->id?>"><?=$totalBooked?></span></th>
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
                                        $yesterday                  = $taskDate;
                                        $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                                        $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                                        $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'user_id', 'type' => 'INNER'];
                                        $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => $yesterday], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id, user.name as user_name, morning_meetings.work_status_id, morning_meetings.effort_id, morning_meetings.next_day_task_action,morning_meetings.priority,morning_meetings.is_leave', $join1, '', $order_by1);
                                        
                                        if($getTasks){ foreach($getTasks as $getTask){
                                            $getWorkStatus                  = $common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color,border_color');
                                            $work_status_color              = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                                            $work_status_border_color       = (($getWorkStatus)?$getWorkStatus->border_color:'#0c0c0c4a');
                                        ?>
                                            <div class="input-group">
                                                <div class="card">
                                                    <div class="card-body" style="border: 1px solid <?=$work_status_border_color?>;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: <?=$work_status_color?>;">
                                                        
                                                        <p class="mb-2">
                                                            <?php if($getTask->is_leave == 0){?>
                                                                <?php if($getTask->priority == 3){?>
                                                                    <span class="card_priotty_item proiodty_high">High</span>
                                                                <?php }?>
                                                                <?php if($getTask->priority == 2){?>
                                                                    <span class="card_priotty_item proiodty_medium">Medium</span>
                                                                <?php }?>
                                                                <?php if($getTask->priority == 1){?>
                                                                    <span class="card_priotty_item proiodty_low">Low</span>
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
                                                            <p class="mb-0 assign-name"><?=$getTask->user_name?></p>
                                                        </div>
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

<script type="text/javascript">

    $('.drag').dragScroll({
    });

    $('#wrapper2').kinetic({
        cursor:'grab',
        decelerate:true,
        triggerHardware:false,
        threshold: 0,
 
        // enable x/y scrolling
        y:true,
        x:true,
        
        // animation speed
        slowdown: 0.9,
        // max velocity speed
        maxvelocity: 40,
        
        // FPS
        throttleFPS: 60,
        
        // inverts movement direction
        invert:false,
        
        // default CSS classes
        movingClass: {    up:'kinetic-moving-up',
            down:'kinetic-moving-down',
            left:'kinetic-moving-left',
            right:'kinetic-moving-right'
        },
        deceleratingClass: {
            up:'kinetic-decelerating-up',
            down:'kinetic-decelerating-down',
            left:'kinetic-decelerating-left',
            right:'kinetic-decelerating-right'
        },


});
</script>