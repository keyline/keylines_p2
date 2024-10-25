<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use CodeIgniter\CLI\Console;
use DateTime;
class TaskAssignController extends BaseController {

    private $model;  //This can be accessed by all class methods
	public function __construct()
    {
        $session = \Config\Services::session();
        if(!$session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }
        $model = new CommonModel();
        $this->data = array(
            'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Task Assign',
            'controller_route'      => 'task-assign',
            'controller'            => 'TaskAssignController',
            'table_name'            => 'client',
            'primary_key'           => 'id'
        );
    }
    /* task list */
        public function task_list()
        {
            $data['moduleDetail']       = $this->data;
            $title                      = 'Manage '.$this->data['title'];
            $page_name                  = 'task-assign/list';

            $user_id                    = $this->session->get('user_id');
            $getUser                    = $this->data['model']->find_data('user', 'row', ['id' => $user_id], 'tracker_depts_show,type');
            $data['tracker_depts_show'] = (($getUser)?json_decode($getUser->tracker_depts_show):[]);
            $data['type']               = (($getUser)?$getUser->type:'');
            $data['user_id']            = $user_id;
            $data['current_date']       = date('Y-m-d');

            $order_by[0]                = array('field' => 'rank', 'type' => 'asc');
            $data['all_departments']    = $this->common_model->find_data('department', 'array', ['status' => 1, 'is_join_morning_meeting' => 1], 'id,deprt_name,header_color,body_color', '', '', $order_by);

            if(empty($data['tracker_depts_show'])){
                $data['departments']        = $this->common_model->find_data('department', 'array', ['status' => 1, 'is_join_morning_meeting' => 1], 'id,deprt_name,header_color,body_color', '', '', $order_by);
            } else {
                $tracker_depts_show_string = implode(",", $data['tracker_depts_show']);
                $data['departments']        = $this->db->query("SELECT * FROM `department` WHERE `id` IN ($tracker_depts_show_string) AND `is_join_morning_meeting` = 1 AND status = 1 ORDER BY rank ASC")->getResult();
            }        

            $order_by1[0]               = array('field' => 'project.name', 'type' => 'ASC');
            $join1[0]                   = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
            $join1[1]                   = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
            $data['projects']           = $this->common_model->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join1, '', $order_by1);

            // Declare two dates
            $applicationSetting         = $this->common_model->find_data('application_settings', 'row');
            $Date1 = date('Y-m-d', strtotime("-".$applicationSetting->block_tracker_fillup_after_days." days"));
            $Date2 = date('Y-m-d', strtotime("-2 days"));
            
            // Declare an empty array
            $date_array = array();
            
            // Use strtotime function
            $Variable1 = strtotime($Date1);
            $Variable2 = strtotime($Date2);
            
            // Use for loop to store dates into array
            // 86400 sec = 24 hrs = 60*60*24 = 1 day
            for ($currentDate = $Variable1;
            $currentDate <= $Variable2;
            $currentDate += (86400)){
                $Store = date('Y-m-d', $currentDate);
                $date_array[] = $Store;
            }
            // pr($date_array);
            $data['date_array']         = $date_array;
            $data['user_id']            = $user_id;
            $data['before_date']        = $Date1;

            if($this->request->getMethod() == 'post') {
                $user_id            = $this->session->get('user_id');
                $tracker_depts_show = $this->request->getPost('tracker_depts_show');
                $postData           = array(
                    'tracker_depts_show'          => (($tracker_depts_show != '')?json_encode($tracker_depts_show):json_encode([])),
                );
                // pr($postData);
                $record     = $this->data['model']->save_data('user', $postData, $user_id, 'id');            
                $this->session->setFlashdata('success_message', 'Filter Applied Successfully');
                return redirect()->to('/admin/'.$this->data['controller_route']);
            }

            echo $this->layout_after_login($title,$page_name,$data);
        }
    /* task list */
    /* task add */
        public function morning_meeting_schedule_submit(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            
            $getProject         = $this->data['model']->find_data('project', 'row', ['id' => $requestData['project_id']], 'status,bill');
            $fields             = [
                'dept_id'       => $requestData['dept_id'],
                'user_id'       => $requestData['user_id'],
                'project_id'    => (($requestData['project_id'] != '')?$requestData['project_id']:0),
                'description'   => $requestData['description'],
                'hour'          => $requestData['hour'],
                'min'           => $requestData['min'],
                'work_home'     => $requestData['work_home'],
                'date_added'    => $requestData['date_added'],
                'priority'      => (($requestData['is_leave'] <= 0)?$requestData['priority']:3),
                'added_by'      => $this->session->get('user_id'),
                'bill'          => (($getProject)?$getProject->bill:1),
                'status_id'     => (($getProject)?$getProject->status:0),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];
            if($requestData['project_id'] == ''){
                $fields['effort_type']          = 0;
                $fields['work_status_id']       = 6;
                $fields['effort_id']            = 0;
                $fields['next_day_task_action'] = 1;
                $fields['is_leave']             = $requestData['is_leave'];
            }

            $post_is_leave  = $requestData['is_leave'];

            $application_settings       = $this->common_model->find_data('application_settings', 'row');
            $edit_time_after_task_add   = $application_settings->edit_time_after_task_add;

            if($post_is_leave > 0){
                // leave
                    $checkLeave     = $this->common_model->find_data('morning_meetings', 'row', ['user_id' => $requestData['user_id'], 'date_added' => date('Y-m-d'), 'is_leave>' => 0], 'is_leave');
                    $post_user_id   = $requestData['user_id'];
                    $getUser        = $this->common_model->find_data('user', 'row', ['id' => $post_user_id], 'name');
                    if($checkLeave){
                    $leave_name = '';
                    if($checkLeave->is_leave == 1){
                        $leave_name = 'HALF DAY';
                    } else {
                        $leave_name = 'FULL DAY';
                    }
                    $apiStatus                          = FALSE;
                    http_response_code(200);
                    $apiMessage                         = 'You Have Already Applied For '.$leave_name.' Leave For '.(($getUser)?$getUser->name:'').'. Can\'t Assign More Leave !!!';
                // leave
            } else {
                    $schedule_id = $this->data['model']->save_data('morning_meetings', $fields, '', 'id');

                    $scheduleHTML               = '';
                    $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                    $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                    $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
                    $join1[2]                   = ['table' => 'timesheet', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'effort_id', 'type' => 'LEFT'];

                    $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $requestData['user_id'], 'morning_meetings.date_added' => $requestData['date_added']], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.effort_id,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at, timesheet.description as booked_description, timesheet.hour as booked_hour, timesheet.min as booked_min', $join1, '', $order_by1);
                    $totalTime                  = 0;
                    if($getTasks){
                        foreach($getTasks as $getTask){
                            $dept_id        = $getTask->dept_id;
                            $user_id        = $getTask->user_id;
                            $user_name      = $getTask->user_name;
                            $schedule_id    = $getTask->schedule_id;

                            $getWorkStatus                  = $this->common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color,border_color');
                            $work_status_color              = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                            $work_status_border_color       = (($getWorkStatus)?$getWorkStatus->border_color:'#0c0c0c4a');

                            if($getTask->hour > 0) {
                                if($getTask->hour == 1){
                                    $hr = $getTask->hour . " hr ";
                                } else {
                                    $hr = $getTask->hour . " hrs ";
                                }
                            } else {
                                $hr = $getTask->hour . " hr ";
                            }
                            if($getTask->min > 0) {
                                if($getTask->min == 1){
                                    $min = $getTask->min . " min";
                                } else {
                                    $min = $getTask->min . " mins";
                                }
                            } else {
                                $min = $getTask->min . " min";
                            }
                            $tot_hour               = $getTask->hour * 60;
                            $tot_min                = $getTask->min;
                            $totMins                = $tot_hour + $tot_min;
                            $totalTime              += $totMins;

                            if($getTask->is_leave == 0){
                                if($getTask->priority == 3){
                                    $priority = '<span class="card_priotty_item proiodty_high">H</span>';
                                }
                                if($getTask->priority == 2){
                                    $priority = '<span class="card_priotty_item proiodty_medium">M</span>';
                                }
                                if($getTask->priority == 1){
                                    $priority = '<span class="card_priotty_item proiodty_low">L</span>';
                                }
                            } else {
                                $priority = '';
                            }

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

                            $time1      = new DateTime($getTask->created_at);
                            $time2      = new DateTime(date('Y-m-d H:i:s'));
                            // Get the difference
                            $interval   = $time1->diff($time2);
                            // Convert the difference to total minutes
                            $minutes    = ($interval->h * 60) + $interval->i;

                            $editBtn    = '';
                            $effort_id  = $getTask->effort_id;
                            if($effort_id <= 0){
                                if($minutes <= $edit_time_after_task_add){
                                    if($requestData['date_added'] == date('Y-m-d')){
                                        $editBtn    = '<a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');" style="display:'.$display.'">
                                                <i class="fa-solid fa-pencil text-primary"></i>
                                                </a>';
                                    }
                                }
                            }

                            if($getTask->updated_at == ''){
                                $createdAt = date_format(date_create($getTask->created_at), "d/m/y - h:i a");
                            } else {
                                $createdAt = date_format(date_create($getTask->updated_at), "d/m/y - h:i a");
                            }

                            if($getTask->work_status_id == 0){
                                if($user_id == $this->session->get('user_id')){
                                    $addToEffort = '<br>
                                                <span><a href="javascript:void(0);" class="badge bg-success text-light" onclick="openEffortSubmitForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');">Add Effort</a></span>';
                                } else {
                                    $addToEffort = '';
                                }
                            } else {
                                $addToEffort = '';
                            }

                            $bookedEffort = '';
                            if($getTask->booked_description != ''){
                                $bookedEffort = '<div class="card_proj_info">
                                                    <span style="font-weight: bold;color: #08487b;font-size: 14px !important;">(Booked : ' . $getTask->booked_description . ' - ' . $getTask->booked_hour . ':' . $getTask->booked_min . ')</span><br>
                                                </div>';
                            }

                            $scheduleHTML .= '<div class="input-group">
                                                <div class="card">
                                                    <div class="card-body" style="border: 1px solid ' . $work_status_border_color . ';width: 100%;padding: 5px;border-radius: 6px;text-align: left;vertical-align: top;background-color: ' . $work_status_color . ';">
                                                        <p class="mb-2">
                                                            ' . $priority . '
                                                        </p>
                                                        <div class="mb-1 d-block">
                                                            <div class="card_projectname"><b>'.$projectName.' :</b> </div>
                                                            <div class="card_proj_info">'.$getTask->description.'</div>
                                                            ' . $bookedEffort . '
                                                        </div>
                                                        <div class="card_projecttime">
                                                            [' .$hr. ' ' .$min. ']
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0 assign-name">By '.$user_name.' <span class="ms-1">('.$createdAt.')</span>' . $addToEffort . '</p>
                                                            ' . $editBtn . '
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                        }
                    }

                    $totalBooked    = intdiv($totalTime, 60) . ':' . ($totalTime % 60);

                    $dept_id        = $requestData['dept_id'];
                    $user_id        = $requestData['user_id'];
                    $getUser        = $this->common_model->find_data('user', 'row', ['id' => $user_id], 'name');
                    $user_name      = (($getUser)?$getUser->name:'');

                    $getLeaveTask                   = $this->common_model->find_data('morning_meetings', 'row', ['user_id' => $user_id, 'date_added' => date('Y-m-d'), 'is_leave>' => 0], 'is_leave');
                    if(!$getLeaveTask){
                        $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                                <i class="fa-solid fa-plus-circle"></i> Add Task
                                        </a>';
                    } else {
                        if($getLeaveTask->is_leave == 1){
                            $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                                <i class="fa-solid fa-plus-circle"></i> Add Task
                                        </a>';
                        }
                    }
                    $apiResponse['scheduleHTML']        = $scheduleHTML;
                    $apiResponse['totalTime']           = $totalBooked;
                    $apiStatus                          = TRUE;
                    http_response_code(200);
                    $apiMessage                         = 'Task Submitted Successfully !!!';
                }
            } else {
                // not leave
                    $schedule_id = $this->data['model']->save_data('morning_meetings', $fields, '', 'id');

                    $scheduleHTML               = '';
                    $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                    $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                    $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
                    $join1[2]                   = ['table' => 'timesheet', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'effort_id', 'type' => 'LEFT'];

                    $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $requestData['user_id'], 'morning_meetings.date_added' => $requestData['date_added']], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.effort_id,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at, timesheet.description as booked_description, timesheet.hour as booked_hour, timesheet.min as booked_min', $join1, '', $order_by1);
                    // pr($getTasks);
                    $totalTime                  = 0;
                    if($getTasks){
                        foreach($getTasks as $getTask){
                            $dept_id        = $getTask->dept_id;
                            $user_id        = $getTask->user_id;
                            $user_name      = $getTask->user_name;
                            $schedule_id    = $getTask->schedule_id;

                            $getWorkStatus                  = $this->common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color,border_color');
                            $work_status_color              = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                            $work_status_border_color       = (($getWorkStatus)?$getWorkStatus->border_color:'#0c0c0c4a');

                            if($getTask->hour > 0) {
                                if($getTask->hour == 1){
                                    $hr = $getTask->hour . " hr ";
                                } else {
                                    $hr = $getTask->hour . " hrs ";
                                }
                            } else {
                                $hr = $getTask->hour . " hr ";
                            }
                            if($getTask->min > 0) {
                                if($getTask->min == 1){
                                    $min = $getTask->min . " min";
                                } else {
                                    $min = $getTask->min . " mins";
                                }
                            } else {
                                $min = $getTask->min . " min";
                            }
                            $tot_hour               = $getTask->hour * 60;
                            $tot_min                = $getTask->min;
                            $totMins                = $tot_hour + $tot_min;
                            $totalTime              += $totMins;

                            if($getTask->is_leave == 0){
                                if($getTask->priority == 3){
                                    $priority = '<span class="card_priotty_item proiodty_high">H</span>';
                                }
                                if($getTask->priority == 2){
                                    $priority = '<span class="card_priotty_item proiodty_medium">M</span>';
                                }
                                if($getTask->priority == 1){
                                    $priority = '<span class="card_priotty_item proiodty_low">L</span>';
                                }
                            } else {
                                $priority = '';
                            }

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

                            $time1      = new DateTime($getTask->created_at);
                            $time2      = new DateTime(date('Y-m-d H:i:s'));
                            // Get the difference
                            $interval   = $time1->diff($time2);
                            // Convert the difference to total minutes
                            $minutes    = ($interval->h * 60) + $interval->i;

                            $editBtn    = '';
                            $effort_id  = $getTask->effort_id;
                            if($effort_id <= 0){
                                if($minutes <= $edit_time_after_task_add){
                                    if($requestData['date_added'] == date('Y-m-d')){
                                        $editBtn    = '<a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');" style="display:'.$display.'">
                                                <i class="fa-solid fa-pencil text-primary"></i>
                                                </a>';
                                    }
                                }
                            }

                            if($getTask->updated_at == ''){
                                $createdAt = date_format(date_create($getTask->created_at), "d/m/y - h:i a");
                            } else {
                                $createdAt = date_format(date_create($getTask->updated_at), "d/m/y - h:i a");
                            }

                            if($getTask->work_status_id == 0){
                                if($user_id == $this->session->get('user_id')){
                                    $addToEffort = '<br>
                                                <span><a href="javascript:void(0);" class="badge bg-success text-light" onclick="openEffortSubmitForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');">Add Effort</a></span>';
                                } else {
                                    $addToEffort = '';
                                }
                            } else {
                                $addToEffort = '';
                            }

                            $bookedEffort = '';
                            if($getTask->booked_description != ''){
                                $bookedEffort = '<div class="card_proj_info">
                                                    <span style="font-weight: bold;color: #08487b;font-size: 14px !important;">(Booked : ' . $getTask->booked_description . ' - ' . $getTask->booked_hour . ':' . $getTask->booked_min . ')</span><br>
                                                </div>';
                            }

                            $scheduleHTML .= '<div class="input-group">
                                                <div class="card">
                                                    <div class="card-body" style="border: 1px solid ' . $work_status_border_color . ';width: 100%;padding: 5px;border-radius: 6px;text-align: left;vertical-align: top;background-color: ' . $work_status_color . ';">
                                                        <p class="mb-2">
                                                            ' . $priority . '
                                                        </p>
                                                        <div class="mb-1 d-block">
                                                            <div class="card_projectname"><b>'.$projectName.' :</b> </div>
                                                            <div class="card_proj_info">'.$getTask->description.'</div>
                                                            ' . $bookedEffort . '
                                                        </div>
                                                        <div class="card_projecttime">
                                                            [' .$hr. ' ' .$min. ']
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-0 assign-name">By '.$user_name.' <span class="ms-1">('.$createdAt.')</span>' . $addToEffort . '</p>
                                                            ' . $editBtn . '
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                        }
                    }

                    $totalBooked    = intdiv($totalTime, 60) . ':' . ($totalTime % 60);

                    $dept_id        = $requestData['dept_id'];
                    $user_id        = $requestData['user_id'];
                    $getUser        = $this->common_model->find_data('user', 'row', ['id' => $user_id], 'name');
                    $user_name      = (($getUser)?$getUser->name:'');

                    $getLeaveTask                   = $this->common_model->find_data('morning_meetings', 'row', ['user_id' => $user_id, 'date_added' => date('Y-m-d'), 'is_leave>' => 0], 'is_leave');
                    if(!$getLeaveTask){
                        $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                                <i class="fa-solid fa-plus-circle"></i> Add Task
                                        </a>';
                    } else {
                        if($getLeaveTask->is_leave == 1){
                            $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                                <i class="fa-solid fa-plus-circle"></i> Add Task
                                        </a>';
                        }
                    }
                    // echo $scheduleHTML;die;
                    $apiResponse['scheduleHTML']        = $scheduleHTML;
                    $apiResponse['totalTime']           = $totalBooked;
                    $apiStatus                          = TRUE;
                    http_response_code(200);
                    $apiMessage                         = 'Task Submitted Successfully !!!';
                // not leave
            }

            /* mail function */
                $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                $getProject                 = $this->common_model->find_data('project', 'row', ['id' => $requestData['project_id']], 'name');
                $getAssignedTask            = $this->common_model->find_data('morning_meetings', 'row', ['id' => $schedule_id]);
                $added_by                   = (($getAssignedTask)?$getAssignedTask->added_by:'');
                $getUser                    = $this->common_model->find_data('user', 'row', ['id' => $added_by], 'name,email');
                $subject                    = $generalSetting->site_name.' :: New Task Assigned '.(($getAssignedTask)?date_format(date_create($getAssignedTask->created_at), "M d, Y"):'').' '.(($getProject)?$getProject->name:'').' - '.$requestData['hour'].':'.$requestData['min'];
                $mailData                   = [
                    'subject'                   => $subject,
                    'project_name'              => (($getProject)?$getProject->name:''),
                    'hour'                      => $requestData['hour'],
                    'min'                       => $requestData['min'],
                    'description'               => $requestData['description'],
                    'priority'                  => $requestData['priority'],
                    'date_added'                => $requestData['date_added'],
                    'task_created'              => (($getAssignedTask)?date_format(date_create($getAssignedTask->updated_at), "M d, Y h:i a"):''),
                    'added_by'                  => (($getUser)?$getUser->name:''),
                ];
                $message                    = view('email-templates/task-assigned', $mailData);
                // echo $message;die;
                $this->sendMail((($getUser)?$getUser->email:''), $subject, $message);
                /* email log save */
                    $postData2 = [
                        'name'                  => (($getUser)?$getUser->name:''),
                        'email'                 => (($getUser)?$getUser->email:''),
                        'subject'               => $subject,
                        'message'               => $message
                    ];
                    $this->common_model->save_data('email_logs', $postData2, '', 'id');
                /* email log save */
            /* mail function */
            
            $apiExtraField                      = 'response_code';
            $apiExtraData                       = http_response_code();
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
    /* task add */
    /* task edit */
        public function morning_meeting_schedule_prefill(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));

            $order_by1[0]               = array('field' => 'project.name', 'type' => 'ASC');
            $join1[0]                   = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
            $join1[1]                   = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
            $projects                   = $this->common_model->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join1, '', $order_by1);
            
            $dept_id                    = $requestData['dept_id'];
            $user_id                    = $requestData['user_id'];
            $schedule_id                = $requestData['schedule_id'];

            $scheduleHTML               = '';
            $getTask                    = $this->common_model->find_data('morning_meetings', 'row', ['id' => $schedule_id]);
            if($getTask){
                $checkedPriority1 = (($getTask->priority == 1)?'checked':'');
                $checkedPriority2 = (($getTask->priority == 2)?'checked':'');
                $checkedPriority3 = (($getTask->priority == 3)?'checked':'');

                $checkedWorkFromHome0 = (($getTask->work_home == 0)?'checked':'');
                $checkedWorkFromHome1 = (($getTask->work_home == 1)?'checked':'');

                $currentDate            = date('Y-m-d'); 

                $scheduleHTML           .= '<form id="morningMeetingForm">
                                                <input type="hidden" name="dept_id" id="dept_id" value="' . $getTask->dept_id . '">
                                                <input type="hidden" name="user_id" id="user_id" value="' . $getTask->user_id . '">
                                                <input type="hidden" name="schedule_id" id="schedule_id" value="' . $schedule_id . '">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-1">
                                                            <input type="date" name="date_added" id="date_added" placeholder="Schedule Date" class="form-control" value="'.$currentDate.'" min="'.$currentDate.'" value="' . $getTask->date_added . '" readonly required>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group mb-1">
                                                            <select name="project_id" id="project_id" class="form-control" required>
                                                                <option value="" selected="">Select Project</option>
                                                                <hr>';
                                                                if($projects){ foreach($projects as $project){
                                                                    $selectedProject = (($project->id == $getTask->project_id)?'selected':'');
                                        $scheduleHTML           .= '<option value="'.$project->id.'" '.$selectedProject.'>'.$project->name.' ('.$this->pro->decrypt($project->client_name).') - '.$project->project_status_name.'</option>
                                                                    <hr>';
                                                                } }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group mb-1">
                                                            <textarea name="description" id="description" placeholder="Description" class="form-control" rows="5" required>' . $getTask->description . '</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-1">
                                                            <select name="hour" class="form-control" id="hour" required>
                                                                <option value="" selected>Select Hour</option>';
                                                                for($h=0;$h<=8;$h++){
                                                                    $selectedHour = (($h == $getTask->hour)?'selected':'');
                                        $scheduleHTML           .= '<option value="' . $h . '" ' . $selectedHour . '>' . $h . '</option>';
                                                                }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-1">
                                                            <select name="min" class="form-control" id="min" required>
                                                                <option value="" selected>Select Minute</option>';
                                                                for($m=0;$m<=59;$m++){
                                                                    $selectedMinute = (($m == $getTask->min)?'selected':'');
                                        $scheduleHTML           .= '<option value="' . $m . '" ' . $selectedMinute . '>' . $m . '</option>';
                                                                }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-1">
                                                            <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority1" value="1" required ' . $checkedPriority1 . '><label for="priority1" style="margin-left : 3px;">Priority LOW</label></span>
                                                            <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority2" value="2" required ' . $checkedPriority2 . '><label for="priority2" style="margin-left : 3px;">Priority MEDIUM</label></span>
                                                            <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority3" value="3" required ' . $checkedPriority3 . '><label for="priority3" style="margin-left : 3px;">Priority HIGH</label></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-1">
                                                            <button type="button" class="btn btn-success btn-sm" onClick="submitEditForm();">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>';
            }
            // echo $scheduleHTML;die;
            $apiResponse                        = $scheduleHTML;
            $apiStatus                          = TRUE;
            http_response_code(200);
            $apiMessage                         = 'Task Schedule Form Open For Modify !!!';
            $apiExtraField                      = 'response_code';
            $apiExtraData                       = http_response_code();
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function morning_meeting_schedule_update(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $schedule_id        = $requestData['schedule_id'];
            $getProject         = $this->data['model']->find_data('project', 'row', ['id' => $requestData['project_id']], 'status,bill');
            $fields             = [
                'project_id'    => $requestData['project_id'],
                'description'   => $requestData['description'],
                'hour'          => $requestData['hour'],
                'min'           => $requestData['min'],
                'work_home'     => $requestData['work_home'],
                'date_added'    => $requestData['date_added'],
                'priority'      => $requestData['priority'],
                'added_by'      => $this->session->get('user_id'),
                'bill'          => (($getProject)?$getProject->bill:1),
                'status_id'     => (($getProject)?$getProject->status:0),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];
            $this->data['model']->save_data('morning_meetings', $fields, $schedule_id, 'id');

            $scheduleHTML               = '';
            $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
            $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
            $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
            $join1[2]                   = ['table' => 'timesheet', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'effort_id', 'type' => 'LEFT'];

            $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $requestData['user_id'], 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.effort_id,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at, timesheet.description as booked_description, timesheet.hour as booked_hour, timesheet.min as booked_min', $join1, '', $order_by1);
            // pr($getTasks);
            $totalTime                  = 0;
            if($getTasks){
                foreach($getTasks as $getTask){
                    $application_settings       = $this->common_model->find_data('application_settings', 'row');
                    $edit_time_after_task_add   = $application_settings->edit_time_after_task_add;

                    $dept_id        = $getTask->dept_id;
                    $user_id        = $getTask->user_id;
                    $user_name      = $getTask->user_name;
                    $schedule_id    = $getTask->schedule_id;

                    $getWorkStatus                  = $this->common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color,border_color');
                    $work_status_color              = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                    $work_status_border_color       = (($getWorkStatus)?$getWorkStatus->border_color:'#0c0c0c4a');

                    if($getTask->hour > 0) {
                        if($getTask->hour == 1){
                            $hr = $getTask->hour . " hr ";
                        } else {
                            $hr = $getTask->hour . " hrs ";
                        }
                    } else {
                        $hr = $getTask->hour . " hr ";
                    }
                    if($getTask->min > 0) {
                        if($getTask->min == 1){
                            $min = $getTask->min . " min";
                        } else {
                            $min = $getTask->min . " mins";
                        }
                    } else {
                        $min = $getTask->min . " min";
                    }
                    $tot_hour               = $getTask->hour * 60;
                    $tot_min                = $getTask->min;
                    $totMins                = $tot_hour + $tot_min;
                    $totalTime              += $totMins;

                    if($getTask->is_leave == 0){
                        if($getTask->priority == 3){
                            $priority = '<span class="card_priotty_item proiodty_high">H</span>';
                        }
                        if($getTask->priority == 2){
                            $priority = '<span class="card_priotty_item proiodty_medium">M</span>';
                        }
                        if($getTask->priority == 1){
                            $priority = '<span class="card_priotty_item proiodty_low">L</span>';
                        }
                    } else {
                        $priority = '';
                    }

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

                    $time1      = new DateTime($getTask->created_at);
                    $time2      = new DateTime(date('Y-m-d H:i:s'));
                    // Get the difference
                    $interval   = $time1->diff($time2);
                    // Convert the difference to total minutes
                    $minutes    = ($interval->h * 60) + $interval->i;

                    $editBtn    = '';
                    $effort_id  = $getTask->effort_id;
                    if($effort_id <= 0){
                        if($minutes <= $edit_time_after_task_add){
                            $editBtn    = '<a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');" style="display:'.$display.'">
                                        <i class="fa-solid fa-pencil text-primary"></i>
                                        </a>';
                        }
                    }

                    if($getTask->updated_at == ''){
                        $createdAt = date_format(date_create($getTask->created_at), "d/m/y - h:i a");
                    } else {
                        $createdAt = date_format(date_create($getTask->updated_at), "d/m/y - h:i a");
                    }

                    if($getTask->work_status_id == 0){
                        if($user_id == $this->session->get('user_id')){
                            $addToEffort = '<br>
                                        <span><a href="javascript:void(0);" class="badge bg-success text-light" onclick="openEffortSubmitForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');">Add Effort</a></span>';
                        } else {
                            $addToEffort = '';
                        }
                    } else {
                        $addToEffort = '';
                    }

                    $bookedEffort = '';
                    if($getTask->booked_description != ''){
                        $bookedEffort = '<div class="card_proj_info">
                                            <span style="font-weight: bold;color: #08487b;font-size: 14px !important;">(Booked : ' . $getTask->booked_description . ' - ' . $getTask->booked_hour . ':' . $getTask->booked_min . ')</span><br>
                                        </div>';
                    }

                    $scheduleHTML .= '<div class="input-group">
                                        <div class="card">
                                            <div class="card-body" style="border: 1px solid ' . $work_status_border_color . ';width: 100%;padding: 5px;border-radius: 6px;text-align: left;vertical-align: top;background-color: ' . $work_status_color . ';">
                                                <p class="mb-2">
                                                    ' . $priority . '
                                                </p>
                                                <div class="mb-1 d-block">
                                                    <div class="card_projectname"><b>'.$projectName.' :</b> </div>
                                                    <div class="card_proj_info">'.$getTask->description.'</div>
                                                    ' . $bookedEffort . '
                                                </div>
                                                <div class="card_projecttime">
                                                    [' .$hr. ' ' .$min. ']
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-0 assign-name">By '.$user_name.' <span class="ms-1">('.$createdAt.')</span>' . $addToEffort . '</p>
                                                    ' . $editBtn . '
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                }
            }
            // echo $scheduleHTML;die;
            $totalBooked    = intdiv($totalTime, 60) . ':' . ($totalTime % 60);
            
            $dept_id        = $requestData['dept_id'];
            $user_id        = $requestData['user_id'];
            $getUser        = $this->common_model->find_data('user', 'row', ['id' => $user_id], 'name');
            $user_name      = (($getUser)?$getUser->name:'');

            $getLeaveTask                   = $this->common_model->find_data('morning_meetings', 'row', ['user_id' => $user_id, 'date_added' => date('Y-m-d'), 'is_leave>' => 0], 'is_leave');
            if(!$getLeaveTask){
                $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                        <i class="fa-solid fa-plus-circle"></i> Add Task
                                </a>';
            } else {
                if($getLeaveTask->is_leave == 1){
                    $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                        <i class="fa-solid fa-plus-circle"></i> Add Task
                                </a>';
                }
            }

            /* mail function */
                $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                $getProject                 = $this->common_model->find_data('project', 'row', ['id' => $requestData['project_id']], 'name');
                $getAssignedTask            = $this->common_model->find_data('morning_meetings', 'row', ['id' => $schedule_id]);
                $added_by                   = (($getAssignedTask)?$getAssignedTask->added_by:'');
                $getUser                    = $this->common_model->find_data('user', 'row', ['id' => $added_by], 'name,email');
                $subject                    = $generalSetting->site_name.' :: Task Updated '.(($getAssignedTask)?date_format(date_create($getAssignedTask->created_at), "M d, Y"):'').' '.(($getProject)?$getProject->name:'').' - '.$requestData['hour'].':'.$requestData['min'];
                $mailData                   = [
                    'subject'                   => $subject,
                    'project_name'              => (($getProject)?$getProject->name:''),
                    'hour'                      => $requestData['hour'],
                    'min'                       => $requestData['min'],
                    'description'               => $requestData['description'],
                    'priority'                  => $requestData['priority'],
                    'date_added'                => $requestData['date_added'],
                    'task_created'              => (($getAssignedTask)?date_format(date_create($getAssignedTask->updated_at), "M d, Y h:i a"):''),
                    'added_by'                  => (($getUser)?$getUser->name:''),
                ];
                $message                    = view('email-templates/task-assigned', $mailData);
                // echo $message;die;
                $this->sendMail((($getUser)?$getUser->email:''), $subject, $message);
                /* email log save */
                    $postData2 = [
                        'name'                  => (($getUser)?$getUser->name:''),
                        'email'                 => (($getUser)?$getUser->email:''),
                        'subject'               => $subject,
                        'message'               => $message
                    ];
                    $this->common_model->save_data('email_logs', $postData2, '', 'id');
                /* email log save */
            /* mail function */
            $apiResponse['scheduleHTML']        = $scheduleHTML;
            $apiResponse['totalTime']           = $totalBooked;
            $apiStatus                          = TRUE;
            http_response_code(200);
            $apiMessage                         = 'Task Modified Successfully !!!';
            $apiExtraField                      = 'response_code';
            $apiExtraData                       = http_response_code();
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
    /* task edit */
    /* task effort booking */
        public function morning_meeting_schedule_prefill_effort_booking(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));

            $order_by1[0]               = array('field' => 'project.name', 'type' => 'ASC');
            $join1[0]                   = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
            $join1[1]                   = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
            $projects                   = $this->common_model->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join1, '', $order_by1);

            $orderBy2[0]                = array('field' => 'name', 'type' => 'ASC');
            $effortTypes                = $this->common_model->find_data('effort_type', 'array', ['status' => 1], 'id,name', '', '', $orderBy2);
            $workStats                  = $this->common_model->find_data('work_status', 'array', ['status' => 1, 'is_schedule' => 1], 'id,name', '', '', $orderBy2);
            
            $dept_id                    = $requestData['dept_id'];
            $user_id                    = $requestData['user_id'];
            $schedule_id                = ((array_key_exists("schedule_id",$requestData))?$requestData['schedule_id']:'');
            $task_date                  = $requestData['task_date'];
            $yesterday                  = date('Y-m-d', strtotime("-1 days"));

            $scheduleHTML               = '';
            $getTask                    = $this->common_model->find_data('morning_meetings', 'row', ['id' => $schedule_id]);
            if($getTask){
                $checkedPriority1 = (($getTask->priority == 1)?'checked':'');
                $checkedPriority2 = (($getTask->priority == 2)?'checked':'');
                $checkedPriority3 = (($getTask->priority == 3)?'checked':'');

                $checkedWorkFromHome0 = (($getTask->work_home == 0)?'checked':'');
                $checkedWorkFromHome1 = (($getTask->work_home == 1)?'checked':'');

                $currentDate            = date('Y-m-d');

                if($schedule_id == ''){
                    $inputDate = '<input type="date" name="date_added" id="date_added" placeholder="Schedule Date" class="form-control" value="'.$task_date.'" min="'.$task_date.'" value="' . $task_date . '" required>';
                } else {
                    $inputDate = '<input type="date" name="date_added" id="date_added" placeholder="Schedule Date" class="form-control" value="'.$getTask->date_added.'" min="'.$getTask->date_added.'" value="' . $getTask->date_added . '" required disabled>';
                }

                $scheduleHTML           .= '<form id="morningMeetingForm">
                                                <input type="hidden" name="dept_id" id="dept_id" value="' . $getTask->dept_id . '">
                                                <input type="hidden" name="user_id" id="user_id" value="' . $getTask->user_id . '">
                                                <input type="hidden" name="schedule_id" id="schedule_id" value="' . $schedule_id . '">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-1">
                                                            ' . $inputDate . '   
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group mb-1">
                                                            <select name="project_id" id="project_id" class="form-control" required disabled>
                                                                <option value="" selected="">Select Project</option>
                                                                <hr>';
                                                                if($projects){ foreach($projects as $project){
                                                                    $selectedProject = (($project->id == $getTask->project_id)?'selected':'');
                                        $scheduleHTML           .= '<option value="'.$project->id.'" '.$selectedProject.'>'.$project->name.' ('.$this->pro->decrypt($project->client_name).') - '.$project->project_status_name.'</option>
                                                                    <hr>';
                                                                } }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group mb-1">
                                                            <textarea name="description" id="description" placeholder="Description" class="form-control" rows="5" required>' . $getTask->description . '</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-1">
                                                            <select name="hour" class="form-control" id="hour" required>
                                                                <option value="" selected>Select Hour</option>';
                                                                for($h=0;$h<=8;$h++){
                                                                    $selectedHour = (($h == $getTask->hour)?'selected':'');
                                        $scheduleHTML           .= '<option value="' . $h . '" ' . $selectedHour . '>' . $h . '</option>';
                                                                }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-1">
                                                            <select name="min" class="form-control" id="min" required>
                                                                <option value="" selected>Select Minute</option>';
                                                                for($m=0;$m<=59;$m++){
                                                                    $selectedMinute = (($m == $getTask->min)?'selected':'');
                                        $scheduleHTML           .= '<option value="' . $m . '" ' . $selectedMinute . '>' . $m . '</option>';
                                                                }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group mb-1">
                                                            <input type="hidden" name="priority" id="priority" value="3">
                                                            <select name="effort_type" id="effort_type" class="form-control" required>
                                                                <option value="" selected="">Select Effort Type</option>
                                                                <hr>';
                                                                if($effortTypes){ foreach($effortTypes as $effortType){
                                                                    $selectedEffortType = (($effortType->id == $getTask->effort_type)?'selected':'');
                                        $scheduleHTML           .= '<option value="'.$effortType->id.'" '.$selectedEffortType.'>'.$effortType->name.'</option>
                                                                    <hr>';
                                                                } }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group mb-1">
                                                            <select name="work_status_id" id="work_status_id" class="form-control" onchange="change_work_status(this.value);" required>
                                                                <option value="" selected="">Select Work Status</option>
                                                                <hr>';
                                                                if($workStats){ foreach($workStats as $workStat){
                                                                    $selectedWorkStatus = (($workStat->id == $getTask->work_status_id)?'selected':'');
                                        $scheduleHTML           .= '<option value="'.$workStat->id.'" '.$selectedWorkStatus.'>'.$workStat->name.'</option>
                                                                    <hr>';
                                                                } }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-1">
                                                            <button type="button" class="btn btn-success btn-sm" onClick="submitEffortBookingForm(\''.$getTask->date_added.'\');"><i class="fa fa-paper-plane"></i> Book Effort</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>';
            } else {
                $inputDate = '<input type="date" name="date_added" id="date_added" placeholder="Schedule Date" class="form-control" value="'.$task_date.'" min="'.$task_date.'" max="'.$task_date.'" value="' . $task_date . '" required>';

                $scheduleHTML           .= '<form id="morningMeetingForm">
                                                <input type="hidden" name="dept_id" id="dept_id" value="' . $dept_id . '">
                                                <input type="hidden" name="user_id" id="user_id" value="' . $user_id . '">
                                                <input type="hidden" name="schedule_id" id="schedule_id" value="">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-1">
                                                            ' . $inputDate . '
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group mb-1">
                                                            <select name="project_id" id="project_id" class="form-control" required>
                                                                <option value="" selected="">Select Project</option>
                                                                <hr>';
                                                                if($projects){ foreach($projects as $project){
                                        $scheduleHTML           .= '<option value="'.$project->id.'">'.$project->name.' ('.$this->pro->decrypt($project->client_name).') - '.$project->project_status_name.'</option>
                                                                    <hr>';
                                                                } }
                                $scheduleHTML           .= '</select>
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
                                                                <option value="" selected>Select Hour</option>';
                                                                for($h=0;$h<=8;$h++){
                                        $scheduleHTML           .= '<option value="' . $h . '">' . $h . '</option>';
                                                                }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-1">
                                                            <select name="min" class="form-control" id="min" required>
                                                                <option value="" selected>Select Minute</option>';
                                                                for($m=0;$m<=59;$m++){
                                        $scheduleHTML           .= '<option value="' . $m . '">' . $m . '</option>';
                                                                }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group mb-1">
                                                            <input type="hidden" name="priority" id="priority" value="3">
                                                            <select name="effort_type" id="effort_type" class="form-control" required>
                                                                <option value="" selected="">Select Effort Type</option>
                                                                <hr>';
                                                                if($effortTypes){ foreach($effortTypes as $effortType){
                                        $scheduleHTML           .= '<option value="'.$effortType->id.'">'.$effortType->name.'</option>
                                                                    <hr>';
                                                                } }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group mb-1">
                                                            <select name="work_status_id" id="work_status_id" class="form-control" required>
                                                                <option value="" selected="">Select Work Status</option>
                                                                <hr>';
                                                                if($workStats){ foreach($workStats as $workStat){
                                        $scheduleHTML           .= '<option value="'.$workStat->id.'">'.$workStat->name.'</option>
                                                                    <hr>';
                                                                } }
                                $scheduleHTML           .= '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-1">
                                                            <button type="button" class="btn btn-success btn-sm" onClick="submitEffortBookingForm(\''.$task_date.'\');"><i class="fa fa-paper-plane"></i> Book Effort</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>';
            }
            // echo $scheduleHTML;die;
            $apiResponse                        = $scheduleHTML;
            $apiStatus                          = TRUE;
            http_response_code(200);
            $apiMessage                         = 'Scheduled Task Open For Effort Booking !!!';
            $apiExtraField                      = 'response_code';
            $apiExtraData                       = http_response_code();
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function morning_meeting_effort_booking(){
            $apiStatus                  = TRUE;
            $apiMessage                 = '';
            $apiResponse                = [];
            $apiExtraField              = '';
            $apiExtraData               = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData                = $this->extract_json(file_get_contents('php://input'));
            
            $schedule_id                = $requestData['schedule_id'];
            $user_id                    = $requestData['user_id'];
            $dept_id                    = $requestData['dept_id'];
            $date_added                 = $requestData['date_added'];
            $project_id                 = $requestData['project_id'];
            $description                = $requestData['description'];
            $hour                       = $requestData['hour'];
            $min                        = $requestData['min'];
            $priority                   = $requestData['priority'];
            $is_leave                   = $requestData['is_leave'];
            $work_home                  = $requestData['work_home'];
            $effort_type                = $requestData['effort_type'];
            $work_status_id             = $requestData['work_status_id'];


            $user_hour_cost             = $this->data['model']->find_data('user', 'row', ['id' => $user_id], 'id,hour_cost', '', '',);
            $user_cost                  = $user_hour_cost->hour_cost;
            $cal_usercost               = ($user_cost/60);

            $getProject     = $this->data['model']->find_data('project', 'row', ['id' => $project_id], 'status,bill');
            $getUser        = $this->data['model']->find_data('user', 'row', ['id' => $user_id], 'department');
            $getWorkStatus  = $this->common_model->find_data('work_status', 'row', ['id' => $work_status_id], 'is_reassign');

            if (array_key_exists("date_task",$requestData)){
                $date_task              = $requestData['date_task'];
            } else {
                $date_task              = $requestData['date_added'];
            }
            $year                   = date('Y', strtotime($date_task)); // 2024
            $month                  = date('m', strtotime($date_task)); // 08

            // if backdated task not added
                if($schedule_id == ''){
                    $getProject         = $this->data['model']->find_data('project', 'row', ['id' => $project_id], 'status,bill');
                    $fields             = [
                        'dept_id'       => $requestData['dept_id'],
                        'user_id'       => $requestData['user_id'],
                        'project_id'    => (($requestData['project_id'] != '')?$requestData['project_id']:0),
                        'description'   => $requestData['description'],
                        'hour'          => $requestData['hour'],
                        'min'           => $requestData['min'],
                        'work_home'     => $requestData['work_home'],
                        'date_added'    => $requestData['date_added'],
                        'priority'      => $requestData['priority'],
                        'added_by'      => $this->session->get('user_id'),
                        'bill'          => (($getProject)?$getProject->bill:1),
                        'status_id'     => (($getProject)?$getProject->status:0),
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ];
                    // pr($fields);
                    $schedule_id = $this->data['model']->save_data('morning_meetings', $fields, '', 'id');
                }
            // if backdated task not added
            // scheduled task
                $cal                    = (($hour*60) + $min); //converted to minutes
                $projectCost            = floatval($cal_usercost * $cal);
                $postData               = array(
                    'project_id'            => $project_id,
                    'status_id'             => (($getProject)?$getProject->status:0),
                    'user_id'               => $user_id,
                    'description'           => $description,
                    'hour'                  => $hour,
                    'min'                   => $min,
                    'work_home'             => 0,
                    'effort_type'           => $effort_type,
                    'work_status_id'        => $work_status_id,
                    'date_today'            => date('Y-m-d H:i:s'),
                    'date_added'            => $date_added,
                    'bill'                  => (($getProject)?$getProject->bill:1),
                    'assigned_task_id'      => $schedule_id,
                    'hour_rate'             => $user_cost,
                    'cost'                  => number_format($projectCost, 2, '.', ''),
                );
                // pr($postData);
                $effort_id              = $this->data['model']->save_data('timesheet', $postData, '', 'id');

                $projectcost            = "SELECT SUM(cost) AS total_hours_worked FROM `timesheet` WHERE `date_added` LIKE '%".$year . "-" . $month ."%' and project_id=".$project_id."";
                $rows                   = $this->db->query($projectcost)->getResult(); 
                foreach($rows as $row){
                    $project_cost       =  $row->total_hours_worked;
                }  
                $exsistingProjectCost   = $this->common_model->find_data('project_cost', 'row', ['project_id' => $project_id, 'created_at LIKE' => '%'.$year . '-' . $month .'%']);
                if(!$exsistingProjectCost){
                    $postData2   = array(
                        'project_id'            => $project_id,
                        'month'                 => $month ,
                        'year'                  => $year,
                        'project_cost'          => $project_cost,
                        'created_at'            => date('Y-m-d H:i:s'),                                
                    );                                  
                    $project_cost_id             = $this->data['model']->save_data('project_cost', $postData2, '', 'id');
                } else {
                    $id         = $exsistingProjectCost->id;
                    $postData2   = array(
                        'project_id'            => $project_id,
                        'month'                 => $month ,
                        'year'                  => $year,
                        'project_cost'          => $project_cost,
                        'updated_at'            => date('Y-m-d H:i:s'),                                
                    );                                    
                    $update_project_cost_id      = $this->data['model']->save_data('project_cost', $postData2, $id, 'id');
                }                                                        
            // scheduled task
            /* morning meeting schedule update */
                $fields                     = [
                    'work_home'         => $requestData['work_home'],
                    'effort_type'       => $requestData['effort_type'],
                    'work_status_id'    => $requestData['work_status_id'],
                    'effort_id'         => $effort_id,
                    'updated_at'        => date('Y-m-d H:i:s'),
                ];
                $this->data['model']->save_data('morning_meetings', $fields, $schedule_id, 'id');
            /* morning meeting schedule update */
            // Finish & Assign tomorrow
                if($getWorkStatus){
                    if($getWorkStatus->is_reassign){
                        /* next working data calculate */
                            // for($c=1;$c<=7;$c++){
                                // echo $date_added1 = date('Y-m-d', strtotime("+1 days"));
                                $date_added1 = date('Y-m-d', strtotime($date_added . ' +1 day'));
                                if($this->calculateNextWorkingDate($date_added1)){
                                    $next_working_day = $date_added1;
                                } else {
                                    // echo 'not working day';
                                    $date_added2 = date('Y-m-d', strtotime($date_added . "+2 days"));
                                    if($this->calculateNextWorkingDate($date_added2)){
                                        $next_working_day = $date_added2;
                                    } else {
                                        $date_added3 = date('Y-m-d', strtotime($date_added . "+3 days"));
                                        if($this->calculateNextWorkingDate($date_added3)){
                                            $next_working_day = $date_added3;
                                        } else {
                                            $date_added4 = date('Y-m-d', strtotime($date_added . "+4 days"));
                                            if($this->calculateNextWorkingDate($date_added4)){
                                                $next_working_day = $date_added4;
                                            } else {
                                                $date_added5 = date('Y-m-d', strtotime($date_added . "+5 days"));
                                                if($this->calculateNextWorkingDate($date_added5)){
                                                    $next_working_day = $date_added5;
                                                } else {
                                                    $date_added6 = date('Y-m-d', strtotime($date_added . "+6 days"));
                                                    if($this->calculateNextWorkingDate($date_added6)){
                                                        $next_working_day = $date_added6;
                                                    } else {
                                                        $date_added7 = date('Y-m-d', strtotime($date_added . "+7 days"));
                                                        if($this->calculateNextWorkingDate($date_added7)){
                                                            $next_working_day = $date_added7;
                                                        } else {
                                                            $next_working_day = $date_added7;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    
                                }
                            // }
                            // echo $next_working_day;
                            // die;
                        /* next working data calculate */
                        $morningScheduleData2 = [
                            'dept_id'               => (($getUser)?$getUser->department:0),
                            'project_id'            => $project_id,
                            'status_id'             => (($getProject)?$getProject->status:0),
                            'user_id'               => $user_id,
                            'description'           => $description,
                            'hour'                  => $hour,
                            'min'                   => $min,
                            'work_home'             => 0,
                            'effort_type'           => 0,
                            'date_added'            => $next_working_day,
                            'added_by'              => $user_id,
                            'bill'                  => (($getProject)?$getProject->bill:1),
                            'work_status_id'        => 0,
                            'priority'              => 3,
                            'effort_id'             => 0,
                            'created_at'            => $next_working_day.' 10:01:00',
                            'updated_at'            => $next_working_day.' 10:01:00',
                        ];
                        // pr($morningScheduleData2);
                        $this->data['model']->save_data('morning_meetings', $morningScheduleData2, '', 'id');
                    }
                }
            // Finish & Assign tomorrow

            $scheduleHTML               = '';
            $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
            $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
            $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
            $join1[2]                    = ['table' => 'timesheet', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'effort_id', 'type' => 'LEFT'];

            $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $requestData['user_id'], 'morning_meetings.date_added' => $date_added], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.effort_id,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at, timesheet.description as booked_description, timesheet.hour as booked_hour, timesheet.min as booked_min', $join1, '', $order_by1);
            $totalTime                  = 0;
            if($getTasks){
                foreach($getTasks as $getTask){
                    $application_settings       = $this->common_model->find_data('application_settings', 'row');
                    $edit_time_after_task_add   = $application_settings->edit_time_after_task_add;

                    $dept_id        = $getTask->dept_id;
                    $user_id        = $getTask->user_id;
                    $user_name      = $getTask->user_name;
                    $schedule_id    = $getTask->schedule_id;

                    $getWorkStatus                  = $this->common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color,border_color');
                    $work_status_color              = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');
                    $work_status_border_color       = (($getWorkStatus)?$getWorkStatus->border_color:'#0c0c0c4a');

                    if($getTask->hour > 0) {
                        if($getTask->hour == 1){
                            $hr = $getTask->hour . " hr ";
                        } else {
                            $hr = $getTask->hour . " hrs ";
                        }
                    } else {
                        $hr = $getTask->hour . " hr ";
                    }
                    if($getTask->min > 0) {
                        if($getTask->min == 1){
                            $min = $getTask->min . " min";
                        } else {
                            $min = $getTask->min . " mins";
                        }
                    } else {
                        $min = $getTask->min . " min";
                    }
                    $tot_hour               = $getTask->hour * 60;
                    $tot_min                = $getTask->min;
                    $totMins                = $tot_hour + $tot_min;
                    $totalTime              += $totMins;

                    if($getTask->is_leave == 0){
                        if($getTask->priority == 3){
                            $priority = '<span class="card_priotty_item proiodty_high">H</span>';
                        }
                        if($getTask->priority == 2){
                            $priority = '<span class="card_priotty_item proiodty_medium">M</span>';
                        }
                        if($getTask->priority == 1){
                            $priority = '<span class="card_priotty_item proiodty_low">L</span>';
                        }
                    } else {
                        $priority = '';
                    }

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

                    $time1      = new DateTime($getTask->created_at);
                    $time2      = new DateTime(date('Y-m-d H:i:s'));
                    // Get the difference
                    $interval   = $time1->diff($time2);
                    // Convert the difference to total minutes
                    $minutes    = ($interval->h * 60) + $interval->i;

                    $editBtn    = '';
                    $effort_id  = $getTask->effort_id;
                    if($effort_id <= 0){
                        if($minutes <= $edit_time_after_task_add){
                            $editBtn    = '<a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');" style="display:'.$display.'">
                                        <i class="fa-solid fa-pencil text-primary"></i>
                                        </a>';
                        }
                    }

                    if($getTask->updated_at == ''){
                        $createdAt = date_format(date_create($getTask->created_at), "d/m/y - h:i a");
                    } else {
                        $createdAt = date_format(date_create($getTask->updated_at), "d/m/y - h:i a");
                    }

                    if($getTask->work_status_id == 0){
                        $addToEffort = '<br>
                                        <span><a href="javascript:void(0);" class="badge bg-success text-light" onclick="openEffortSubmitForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');">Add Effort</a></span>';
                    } else {
                        $addToEffort = '';
                    }

                    $bookedEffort = '';
                    if($getTask->booked_description != ''){
                        $bookedEffort = '<div class="card_proj_info">
                                            <span style="font-weight: bold;color: #08487b;font-size: 14px !important;">(Booked : ' . $getTask->booked_description . ' - ' . $getTask->booked_hour . ':' . $getTask->booked_min . ')</span><br>
                                        </div>';
                    }

                    $scheduleHTML .= '<div class="input-group">
                                        <div class="card">
                                            <div class="card-body" style="border: 1px solid ' . $work_status_border_color . ';width: 100%;padding: 5px;border-radius: 6px;text-align: left;vertical-align: top;background-color: ' . $work_status_color . ';">
                                                <p class="mb-2">
                                                    ' . $priority . '
                                                </p>
                                                <div class="mb-1 d-block">
                                                    <div class="card_projectname"><b>'.$projectName.' :</b> </div>
                                                    <div class="card_proj_info">'.$getTask->description.'</div>
                                                    ' . $bookedEffort . '
                                                </div>
                                                <div class="card_projecttime">
                                                    [' .$hr. ' ' .$min. ']
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-0 assign-name">By '.$user_name.' <span class="ms-1">('.$createdAt.')</span>' . $addToEffort . '</p>
                                                    ' . $editBtn . '
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                }
            }
            // echo $scheduleHTML;die;
            $totalAssigned    = intdiv($totalTime, 60) . ':' . ($totalTime % 60);
            
            $dept_id        = $requestData['dept_id'];
            $user_id        = $requestData['user_id'];
            $getUser        = $this->common_model->find_data('user', 'row', ['id' => $user_id], 'name');
            $user_name      = (($getUser)?$getUser->name:'');

            $getLeaveTask                   = $this->common_model->find_data('morning_meetings', 'row', ['user_id' => $user_id, 'date_added' => date('Y-m-d'), 'is_leave>' => 0], 'is_leave');
            $yesterday                      = $requestData['date_added'];
            if(!$getLeaveTask){
                if($yesterday != date('Y-m-d')){
                    $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" data-taskdate="'.$yesterday.'" onclick="openEffortSubmitForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                        <i class="fa-solid fa-plus-circle"></i> Add Effort
                                </a>';
                } else {
                    $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                        <i class="fa-solid fa-plus-circle"></i> Add Task
                                    </a>';
                }
            } else {
                if($getLeaveTask->is_leave == 1){
                    if($yesterday != date('Y-m-d')){
                        $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" data-taskdate="'.$yesterday.'" onclick="openEffortSubmitForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                        <i class="fa-solid fa-plus-circle"></i> Add Effort
                                </a>';
                    } else {
                        $scheduleHTML .= '<a href="javascript:void(0);" class="btn btn-sm btn-success task_add_btn-updated" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                            <i class="fa-solid fa-plus-circle"></i> Add Task
                                        </a>';
                    }
                }
            }

            $totalBookedTime                  = 0;
            $bookings = $this->common_model->find_data('timesheet', 'array', ['user_id' => $user_id, 'date_added' => $date_added]);
            if($bookings){ foreach($bookings as $booking){
                $tot_hour               = $booking->hour * 60;
                $tot_min                = $booking->min;
                $totMins                = $tot_hour + $tot_min;
                $totalBookedTime              += $totMins;
            } }
            $totalBooked    = intdiv($totalBookedTime, 60) . ':' . ($totalBookedTime % 60);

            $apiResponse['scheduleHTML']        = $scheduleHTML;
            $apiResponse['totalTime']           = $totalAssigned;
            $apiResponse['totalBookedTime']     = $totalBooked;
            $apiStatus                          = TRUE;
            http_response_code(200);
            $apiMessage                         = 'Effort Booked Successfully !!!';
            $apiExtraField                      = 'response_code';
            $apiExtraData                       = http_response_code();
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function calculateNextWorkingDate($givenDate){
            // echo $givenDate;
            $checkHoliday = $this->common_model->find_data('event', 'count', ['start_event' => $givenDate]);
            if($checkHoliday > 0){
                return true;
            } else {
                $applicationSetting = $this->common_model->find_data('application_settings', 'row');
                $dayOfWeek = date("l", strtotime($givenDate));
                if($dayOfWeek == 'Sunday'){
                    $dayNo          = 7;
                    $fieldName      = 'sunday';
                    $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
                } elseif($dayOfWeek == 'Monday'){
                    $dayNo          = 1;
                    $fieldName      = 'monday';
                    $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
                } elseif($dayOfWeek == 'Tuesday'){
                    $dayNo          = 2;
                    $fieldName      = 'monday';
                    $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
                } elseif($dayOfWeek == 'Wednesday'){
                    $dayNo          = 3;
                    $fieldName      = 'monday';
                    $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
                } elseif($dayOfWeek == 'Thursday'){
                    $dayNo          = 4;
                    $fieldName      = 'thursday';
                    $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
                } elseif($dayOfWeek == 'Friday'){
                    $dayNo          = 5;
                    $fieldName      = 'friday';
                    $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
                } elseif($dayOfWeek == 'Saturday'){
                    $dayNo          = 6;
                    $fieldName      = 'satarday';
                    $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
                }
                // echo $getDayCount;
                $fieldArray = json_decode($applicationSetting->$fieldName);
                // pr($fieldArray,0);
                if(in_array($getDayCount, $fieldArray)){
                    return false;
                } else {
                    return true;
                }
            }
        }
        public function getDayCountInMonth($givenDate, $dayNo){
            $date = $givenDate; // Example date
            // $date = "2024-08-24"; // Example date

            // Get the day of the month
            $dayOfMonth = date("j", strtotime($date));

            // Get the month and year from the date
            $month = date("m", strtotime($date));
            $year = date("Y", strtotime($date));

            // Initialize the counter for Saturdays
            $saturdayCount = 0;

            for ($day = 1; $day <= $dayOfMonth; $day++) {
                // Create a date string for each day of the month
                $currentDate = "$year-$month-$day";
                // echo date("N", strtotime('2024-08-25')).'<br>';
                // Check if the current date is a Saturday
                if (date("N", strtotime($currentDate)) == $dayNo) {
                    $saturdayCount++;
                }
            }

            // Check if the provided date is a Saturday and count it
            if (date("N", strtotime($date)) == $dayNo) {
                // echo "The date $date is the $saturdayCount" . "th Saturday of the month.";
                return $saturdayCount;
            } else {
                // echo "The date $date is not a Saturday.";
                return 0;
            }
        }
    /* task effort booking */
    /* task approve/reject */
        public function morning_meeting_schedule_approve_task(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $schedule_id        = $requestData['schedule_id'];
            $effort_id          = $requestData['effort_id'];
            $user_id            = $requestData['user_id'];
            
            $this->common_model->save_data('morning_meetings', ['next_day_task_action' => 1], $schedule_id, 'id');
            $this->common_model->save_data('timesheet', ['next_day_task_action' => 1], $effort_id, 'id');

            $apiStatus                          = TRUE;
            http_response_code(200);
            $apiMessage                         = 'Task Approved Successfully !!!';
            $apiExtraField                      = 'response_code';
            $apiExtraData                       = http_response_code();
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function morning_meeting_reschedule_task(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $schedule_id        = $requestData['schedule_id'];
            $effort_id          = $requestData['effort_id'];
            $user_id            = $requestData['user_id'];
            $reschedule_date    = $requestData['reschedule_date'];
            
            $this->common_model->save_data('morning_meetings', ['next_day_task_action' => 3], $schedule_id, 'id');
            $this->common_model->save_data('timesheet', ['next_day_task_action' => 3], $effort_id, 'id');

            /* task reschedule */
                $getScheduleInfo =  $this->common_model->find_data('morning_meetings', 'row', ['id' => $schedule_id]);
                if($getScheduleInfo){
                    $getProject         = $this->data['model']->find_data('project', 'row', ['id' => $getScheduleInfo->project_id], 'status,bill');
                    $fields             = [
                        'dept_id'       => $getScheduleInfo->dept_id,
                        'user_id'       => $getScheduleInfo->user_id,
                        'project_id'    => $getScheduleInfo->project_id,
                        'description'   => $getScheduleInfo->description,
                        'hour'          => $getScheduleInfo->hour,
                        'min'           => $getScheduleInfo->min,
                        'work_home'     => $getScheduleInfo->work_home,
                        'date_added'    => date_format(date_create($reschedule_date), "Y-m-d"),
                        'priority'      => $getScheduleInfo->priority,
                        'added_by'      => $this->session->get('user_id'),
                        'bill'          => (($getProject)?$getProject->bill:1),
                        'status_id'     => (($getProject)?$getProject->status:0),
                    ];
                    $this->data['model']->save_data('morning_meetings', $fields, '', 'id');
                }
            /* task reschedule */

            $scheduleHTML               = '';
            $order_by1[0]               = array('field' => 'morning_meetings.id', 'type' => 'ASC');
            $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'INNER'];
            $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'user_id', 'type' => 'INNER'];
            $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $user_id, 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id', $join1, '', $order_by1);
            $totalTime                  = 0;
            if($getTasks){
                foreach($getTasks as $getTask){
                    $dept_id        = $getTask->dept_id;
                    $user_id        = $getTask->user_id;
                    $user_name      = $getTask->user_name;
                    $schedule_id    = $getTask->schedule_id;

                    $getWorkStatus          = $this->common_model->find_data('work_status', 'row', ['id' => $getTask->work_status_id], 'background_color');
                    $work_status_color      = (($getWorkStatus)?$getWorkStatus->background_color:'#FFF');

                    if($getTask->hour > 0) {
                        if($getTask->hour == 1){
                            $hr = $getTask->hour . " hr ";
                        } else {
                            $hr = $getTask->hour . " hrs ";
                        }
                    } else {
                        $hr = $getTask->hour . " hr ";
                    }
                    if($getTask->min > 0) {
                        if($getTask->min == 1){
                            $min = $getTask->min . " min";
                        } else {
                            $min = $getTask->min . " mins";
                        }
                    } else {
                        $min = $getTask->min . " min";
                    }
                    $tot_hour               = $getTask->hour * 60;
                    $tot_min                = $getTask->min;
                    $totMins                = $tot_hour + $tot_min;
                    $totalTime              += $totMins;

                    $scheduleHTML .= '<div class="input-group">
                                        <div class="card">
                                            <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: ' . $work_status_color . ';">
                                                <p class="mb-2">
                                                    <b>'.$getTask->project_name.' :</b> '.$getTask->description.' [' .$hr. ' ' .$min. ']
                                                </p>
                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-0">'.$user_name.'</p>
                                                    <a href="javascript:void(0);" class="task_edit_btn" onclick="openEditForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');">
                                                        <i class="fa-solid fa-pencil text-primary"></i>
                                                    </a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>';
                }
            }

            $totalBooked    = intdiv($totalTime, 60) . ':' . ($totalTime % 60);

            $dept_id        = $getScheduleInfo->dept_id;
            $user_id        = $requestData['user_id'];
            $getUser        = $this->common_model->find_data('user', 'row', ['id' => $user_id], 'name');
            $user_name      = (($getUser)?$getUser->name:'');

            $scheduleHTML .= '<a href="javascript:void(0);" class="task_edit_btn" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                    <i class="fa-solid fa-plus-circle text-success"></i>
                                </a>';
            // echo $scheduleHTML;die;
            $apiResponse['scheduleHTML']        = $scheduleHTML;
            $apiResponse['totalTime']           = $totalBooked;

            $apiStatus                          = TRUE;
            http_response_code(200);
            $apiMessage                         = 'Task Reassigned Successfully !!!';
            $apiExtraField                      = 'response_code';
            $apiExtraData                       = http_response_code();
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
    /* task approve/reject */
    /* previous task fetch */
        public function morning_meeting_get_previous_task(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            // pr($requestData);
            $taskDate                   = $requestData['taskDate'];
            $scheduleHTML               = '';
            $data['taskDate']           = $taskDate;

            $user_id                    = $this->session->get('user_id');
            $getUser                    = $this->data['model']->find_data('user', 'row', ['id' => $user_id], 'tracker_depts_show,type');
            $data['tracker_depts_show'] = (($getUser)?json_decode($getUser->tracker_depts_show):[]);
            $data['type']               = (($getUser)?$getUser->type:'');
            $data['user_id']            = $user_id;

            $order_by[0]                = array('field' => 'rank', 'type' => 'asc');
            $data['all_departments']    = $this->common_model->find_data('department', 'array', ['status' => 1, 'is_join_morning_meeting' => 1], 'id,deprt_name,header_color,body_color', '', '', $order_by);

            if(empty($data['tracker_depts_show'])){
                $data['departments']        = $this->common_model->find_data('department', 'array', ['status' => 1, 'is_join_morning_meeting' => 1], 'id,deprt_name,header_color,body_color', '', '', $order_by);
            } else {
                $tracker_depts_show_string  = implode(",", $data['tracker_depts_show']);
                $data['departments']        = $this->db->query("SELECT * FROM `department` WHERE `id` IN ($tracker_depts_show_string) AND `is_join_morning_meeting` = 1 AND status = 1 ORDER BY rank ASC")->getResult();
            }

            $order_by1[0]               = array('field' => 'project.name', 'type' => 'ASC');
            $join1[0]                   = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
            $join1[1]                   = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
            $data['projects']           = $this->common_model->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join1, '', $order_by1);
            $scheduleHTML               = view('admin/maincontents/effort/previous-schedule-html',$data);

            // echo $scheduleHTML;die;
            $apiResponse['scheduleHTML']        = $scheduleHTML;
            $apiStatus                          = TRUE;
            http_response_code(200);
            $apiMessage                         = 'Task Schedule Generated For  !!!';
            $apiExtraField                      = 'response_code';
            $apiExtraData                       = http_response_code();
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
    /* previous task fetch */
    public function task_listv2()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'task-assign/list-v2';
        $order_by[0]                = array('field' => 'rank', 'type' => 'asc');
        $data['departments']        = $this->common_model->find_data('department', 'array', ['status' => 1, 'is_join_morning_meeting' => 1], 'id,deprt_name,header_color', '', '', $order_by);

        $order_by1[0]               = array('field' => 'project.name', 'type' => 'ASC');
        $join1[0]                   = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
        $join1[1]                   = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
        $data['projects']           = $this->common_model->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join1, '', $order_by1);
        echo $this->layout_after_login($title,$page_name,$data);
    }
}