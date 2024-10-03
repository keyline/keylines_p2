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
    public function morning_meeting_schedule_submit(){
        date_default_timezone_set("Asia/Kolkata");
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
                $this->data['model']->save_data('morning_meetings', $fields, '', 'id');

                $scheduleHTML               = '';
                $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
                $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $requestData['user_id'], 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.effort_id,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at', $join1, '', $order_by1);
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
                                $editBtn    = '<a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');" style="display:'.$display.'">
                                            <i class="fa-solid fa-pencil text-primary"></i>
                                            </a>';
                            }
                        }

                        if($getTask->updated_at == ''){
                            $createdAt = date_format(date_create($getTask->created_at), "h:i a");
                        } else {
                            $createdAt = date_format(date_create($getTask->updated_at), "h:i a");
                        }

                        if($getTask->work_status_id <= 0){
                            $addToEffort = '<br>
                                            <span><a href="javascript:void(0);" class="badge bg-success text-light">Add To Effort</a></span>';
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
                    $scheduleHTML .= '<a href="javascript:void(0);" class="task_add_btn" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                            <i class="fa-solid fa-plus-circle"></i>
                                    </a>';
                } else {
                    if($getLeaveTask->is_leave == 1){
                        $scheduleHTML .= '<a href="javascript:void(0);" class="task_add_btn" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                            <i class="fa-solid fa-plus-circle"></i>
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
                $this->data['model']->save_data('morning_meetings', $fields, '', 'id');

                $scheduleHTML               = '';
                $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
                $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $requestData['user_id'], 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.effort_id,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at', $join1, '', $order_by1);
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
                                $editBtn    = '<a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm('.$dept_id.', '.$user_id.', \''.$user_name.'\', '.$schedule_id.');" style="display:'.$display.'">
                                            <i class="fa-solid fa-pencil text-primary"></i>
                                            </a>';
                            }
                        }

                        if($getTask->updated_at == ''){
                            $createdAt = date_format(date_create($getTask->created_at), "h:i a");
                        } else {
                            $createdAt = date_format(date_create($getTask->updated_at), "h:i a");
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
                                                    </div>
                                                    <div class="card_projecttime">
                                                        [' .$hr. ' ' .$min. ']
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-0 assign-name">By '.$user_name.' <span class="ms-1">('.$createdAt.')</span></p>
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
                    $scheduleHTML .= '<a href="javascript:void(0);" class="task_add_btn" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                            <i class="fa-solid fa-plus-circle"></i>
                                    </a>';
                } else {
                    if($getLeaveTask->is_leave == 1){
                        $scheduleHTML .= '<a href="javascript:void(0);" class="task_add_btn" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                            <i class="fa-solid fa-plus-circle"></i>
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
        
        $apiExtraField                      = 'response_code';
        $apiExtraData                       = http_response_code();
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
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
                                                        <input type="date" name="date_added" id="date_added" placeholder="Schedule Date" class="form-control" value="'.$currentDate.'" min="'.$currentDate.'" value="' . $getTask->date_added . '" required>
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
                                                        <button type="button" class="btn btn-success" onClick="submitEditForm();">Save</button>
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
        date_default_timezone_set("Asia/Kolkata");
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
        $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $requestData['user_id'], 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.effort_id,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at', $join1, '', $order_by1);
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
                    $createdAt = date_format(date_create($getTask->created_at), "h:i a");
                } else {
                    $createdAt = date_format(date_create($getTask->updated_at), "h:i a");
                }

                if($getTask->work_status_id <= 0){
                    $addToEffort = '<br>
                                    <span><a href="javascript:void(0);" class="badge bg-success text-light">Add To Effort</a></span>';
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
            $scheduleHTML .= '<a href="javascript:void(0);" class="task_add_btn" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                    <i class="fa-solid fa-plus-circle"></i>
                            </a>';
        } else {
            if($getLeaveTask->is_leave == 1){
                $scheduleHTML .= '<a href="javascript:void(0);" class="task_add_btn" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                    <i class="fa-solid fa-plus-circle"></i>
                            </a>';
            }
        }
        $apiResponse['scheduleHTML']        = $scheduleHTML;
        $apiResponse['totalTime']           = $totalBooked;
        $apiStatus                          = TRUE;
        http_response_code(200);
        $apiMessage                         = 'Task Modified Successfully !!!';
        $apiExtraField                      = 'response_code';
        $apiExtraData                       = http_response_code();
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
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
        $getUser                    = $this->data['model']->find_data('user', 'row', ['id' => $user_id], 'tracker_depts_show');
        $data['tracker_depts_show'] = (($getUser)?json_decode($getUser->tracker_depts_show):[]);

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