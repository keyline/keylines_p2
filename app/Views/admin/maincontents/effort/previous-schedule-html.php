<?php
use App\Models\CommonModel;
use App\Libraries\Pro;
$common_model               = new CommonModel;
$db                         = \Config\Database::connect();
$pro                        = new Pro();
$generalSetting             = $common_model->find_data('general_settings', 'row');
?>
<div class="rows">
    <div class="dt-responsive table-responsive whatwg drag-box fixed-header">
        <table id="wrapper" class="table general_table_style task-assign-table applies drag">
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
                            $application_settings    = $common_model->find_data('application_settings', 'row');
                            $edit_time_after_task_add = $application_settings->edit_time_after_task_add;
                            if($type == 'SUPER ADMIN'){
                                $alterIcon  = 1;
                                if($user_id == $teamMember->id){
                                    $effortIcon = 1;
                                } else {
                                    $effortIcon = 0;
                                }
                            } elseif($type == 'ADMIN'){
                                $alterIcon  = 1;
                                if($user_id == $teamMember->id){
                                    $effortIcon = 1;
                                } else {
                                    $effortIcon = 0;
                                }
                            } elseif($type == 'USER'){
                                if($user_id == $teamMember->id){
                                    $alterIcon  = 1;
                                    $effortIcon = 1;
                                } else {
                                    $alterIcon  = 0;
                                    $effortIcon = 0;
                                }
                            } else {
                                $alterIcon  = 0;
                                $effortIcon = 0;
                            }
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
                            $totalAssigned    = intdiv($totalTime, 60) . ':' . ($totalTime % 60);
                            $totalAssigned    = '[Assigned : ' . $totalAssigned . ']';

                            $checkAttnendance = $common_model->find_data('attendances', 'count', ['user_id' => $teamMember->id, 'punch_date' => $yesterday]);
                            if($checkAttnendance > 0){
                                $attnBgColor = '#d1fa05';
                            } else {
                                $attnBgColor = 'red';
                            }
                            $checkBooking = $common_model->find_data('timesheet', 'count', ['user_id' => $teamMember->id, 'date_added' => $yesterday]);
                            if($checkBooking > 0){
                                $trackerBgColor = '#d1fa05';
                            } else {
                                $trackerBgColor = 'red';
                            }

                            $totalBookedTime                  = 0;
                            $bookings = $common_model->find_data('timesheet', 'array', ['user_id' => $teamMember->id, 'date_added' => $yesterday]);
                            if($bookings){ foreach($bookings as $booking){
                                $tot_hour               = $booking->hour * 60;
                                $tot_min                = $booking->min;
                                $totMins                = $tot_hour + $tot_min;
                                $totalBookedTime              += $totMins;
                            } }
                            $totalBooked    = intdiv($totalBookedTime, 60) . ':' . ($totalBookedTime % 60);
                            $totalBooked    = '[Booked : ' . $totalBooked . ']';
                            ?>
                            <th style="background-color: <?=$dept->header_color?>;">
                                <div class="d-flex justify-content-between">
                                    <?=$teamMember->name?><br>
                                    <span style="padding: 2px 8px; border-radius: 10px; font-size:10px; background-color:<?=$attnBgColor?>; color: #000;">Punch-In</span><br>
                                    <span style="padding: 2px 8px; border-radius: 10px; font-size:10px; background-color:<?=$trackerBgColor?>; color: #000;">Tracker</span><br>
                                    <span id="total-time-<?=$teamMember->id?>"><?=$totalAssigned?></span><br>
                                    <span id="total-booked-time-<?=$teamMember->id?>"><?=$totalBooked?></span>
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
                            $yesterday                  = $taskDate;
                    ?>
                        <td style="background-color: <?=$dept->body_color?>;">
                            <div class="field_wrapper" id="name">
                                <div class="row">
                                    <div class="col-12" id="meeting-user-previous-<?=$teamMember->id?>_<?=$yesterday?>">
                                        <?php
                                        $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                                        $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                                        $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'user_id', 'type' => 'INNER'];
                                        $getTasks                   = $common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $teamMember->id, 'morning_meetings.date_added' => $yesterday], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.id as schedule_id, user.name as user_name, morning_meetings.work_status_id, morning_meetings.effort_id, morning_meetings.next_day_task_action,morning_meetings.priority,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at', $join1, '', $order_by1);
                                        
                                        if($getTasks){ foreach($getTasks as $getTask){
                                            $getWorkStatus                  = $common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color,border_color');
                                            $work_status_color              = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                                            $work_status_border_color       = (($getWorkStatus)?$getWorkStatus->border_color:'#0c0c0c4a');
                                        ?>
                                            <div class="input-group">
                                                <div class="card">
                                                    <div class="card-body" style="border: 1px solid <?=$work_status_border_color?>;width: 100%;padding: 8px;background-color: #fff;border-radius: 6px;text-align: left; box-shadow: 0 0 15px -13px #000; vertical-align: top;background-color: <?=$work_status_color?>;">
                                                        
                                                        <p class="mb-2">
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
                                                            $createdAt = date_format(date_create($getTask->created_at), "d/m/y - h:i a");
                                                        } else {
                                                            $createdAt = date_format(date_create($getTask->updated_at), "d/m/y - h:i a");
                                                        }
                                                        ?>
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0 assign-name">
                                                                By <?=$getTask->user_name?> <span class="ms-1">(<?=$createdAt?>)</span>
                                                                <?php
                                                                if($type == 'SUPER ADMIN'){
                                                                    $alterIcon  = 1;
                                                                    if($user_id == $teamMember->id){
                                                                        $effortIcon = 1;
                                                                    } else {
                                                                        $effortIcon = 0;
                                                                    }
                                                                } elseif($type == 'ADMIN'){
                                                                    $alterIcon  = 1;
                                                                    if($user_id == $teamMember->id){
                                                                        $effortIcon = 1;
                                                                    } else {
                                                                        $effortIcon = 0;
                                                                    }
                                                                } elseif($type == 'USER'){
                                                                    if($user_id == $teamMember->id){
                                                                        $alterIcon  = 1;
                                                                        $effortIcon = 1;
                                                                    } else {
                                                                        $alterIcon  = 0;
                                                                        $effortIcon = 0;
                                                                    }
                                                                } else {
                                                                    $alterIcon  = 0;
                                                                    $effortIcon = 0;
                                                                }
                                                                ?>
                                                                <?php if($getTask->work_status_id == 0){?>
                                                                    <?php if($effortIcon == 1){?>
                                                                        <br>
                                                                        <span><a href="javascript:void(0);" class="badge bg-success text-light" onclick="openEffortSubmitForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>', <?=$getTask->schedule_id?>);">Add Effort</a></span>
                                                                    <?php }?>
                                                                <?php }?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } }?>

                                        <?php
                                        if($type == 'SUPER ADMIN'){
                                            if($user_id == $teamMember->id){
                                                $alterIcon  = 1;
                                                $effortIcon = 1;
                                            } else {
                                                $alterIcon  = 0;
                                                $effortIcon = 0;
                                            }
                                        } elseif($type == 'ADMIN'){
                                            if($user_id == $teamMember->id){
                                                $alterIcon  = 1;
                                                $effortIcon = 1;
                                            } else {
                                                $alterIcon  = 0;
                                                $effortIcon = 0;
                                            }
                                        } elseif($type == 'USER'){
                                            if($user_id == $teamMember->id){
                                                $alterIcon  = 1;
                                                $effortIcon = 1;
                                            } else {
                                                $alterIcon  = 0;
                                                $effortIcon = 0;
                                            }
                                        } else {
                                            $alterIcon  = 0;
                                            $effortIcon = 0;
                                        }
                                        ?>

                                         <?php if($effortIcon == 1){?>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" data-taskdate="<?=$yesterday?>" onclick="openEffortSubmitForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>', '');">
                                                <i class="fa-solid fa-plus-circle"></i> Add Effort
                                            </a>
                                        <?php }?>
                                        <!-- <?php
                                        $getLeaveTask                   = $common_model->find_data('morning_meetings', 'row', ['user_id' => $teamMember->id, 'date_added' => $yesterday, 'is_leave>' => 0], 'is_leave');
                                        if(!$getLeaveTask){
                                            if($alterIcon){
                                        ?>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" data-taskdate="<?=$yesterday?>" onclick="openEffortSubmitForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>', '');">
                                                    <i class="fa-solid fa-plus-circle"></i> Add Effort
                                                </a>
                                            <?php }?>
                                        <?php } else {?>
                                            <?php if($getLeaveTask->is_leave == 1){?>
                                                <?php if($alterIcon){?>
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" data-taskdate="<?=$yesterday?>" onclick="openEffortSubmitForm(<?=$dept->id?>, <?=$teamMember->id?>, '<?=$teamMember->name?>', '');">
                                                        <i class="fa-solid fa-plus-circle"></i> Add Effort
                                                    </a>
                                                <?php }?>
                                            <?php }?>
                                        <?php }?> -->
                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php } } ?>
                    <?php } } ?>
                </tr>
            </tbody>
        </table>
        <div class="col-12">
            <div class="row justify-content-center">
                <?php if($all_departments){ foreach($all_departments as $all_department){?>
                    <div class="col-md-2">
                        <div class="table-lagend-box">
                            <p class="design-text d-flex align-items-center" style="color: <?=$all_department->header_color?>;"> <?=$all_department->deprt_name?> Team 
                                <span class="table-lagend light-yellow" style="background: <?=$all_department->body_color?>;"></span>
                                <span class="table-lagend dark-yellow" style="background: <?=$all_department->header_color?>;"></span>
                            </p>
                        </div>
                    </div>
                <?php } }?>
                <div class="col-md-2">
                    <div class="table-lagend-box">
                        <p class="d-flex align-items-center"> Priority: 
                            <span class="table-lagend light-high circle">H</span>
                            <span class="table-lagend dark-mid circle">M</span>
                            <span class="table-lagend dark-low circle">L</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
