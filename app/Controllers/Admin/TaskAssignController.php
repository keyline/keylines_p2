<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use CodeIgniter\CLI\Console;
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
        $order_by[0]                = array('field' => 'rank', 'type' => 'asc');
        $data['departments']        = $this->common_model->find_data('department', 'array', ['status' => 1, 'is_join_morning_meeting' => 1], 'id,deprt_name,header_color', '', '', $order_by);

        $order_by1[0]               = array('field' => 'project.name', 'type' => 'ASC');
        $join1[0]                   = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
        $join1[1]                   = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
        $data['projects']           = $this->common_model->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join1, '', $order_by1);
        echo $this->layout_after_login($title,$page_name,$data);
    }
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
        ];
        $this->data['model']->save_data('morning_meetings', $fields, '', 'id');

        $scheduleHTML               = '';
        $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
        $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'INNER'];
        $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
        $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $requestData['user_id'], 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority', $join1, '', $order_by1);
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

                if($getTask->priority == 3){
                    $priority = '<span><i class="fa-solid fa-medal" style="color: #FFD43B; border:1px solid #FFD43B; border-radius:50%; padding:3px;float:right;" title="High"></i></span>';
                }
                if($getTask->priority == 2){
                    $priority = '<span><i class="fa-solid fa-medal" style="color: #CCCCCC; border:1px solid #CCCCCC; border-radius:50%; padding:3px;float:right;" title="Medium"></i></span>';
                }
                if($getTask->priority == 1){
                    $priority = '<span><i class="fa-solid fa-medal" style="color: #b08d57; border:1px solid #b08d57; border-radius:50%; padding:3px;float:right;" title="Low"></i></span>';
                }

                $scheduleHTML .= '<div class="input-group">
                                <div class="card">
                                    <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: ' . $work_status_color . ';">
                                        <p class="mb-2">
                                            ' . $priority . '
                                            <span class="mb-1 d-block"><b>'.$getTask->project_name.' :</b> '.$getTask->description.'</span> [' .$hr. ' ' .$min. ']
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

        $dept_id        = $requestData['dept_id'];
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
        $apiMessage                         = 'Task Submitted Successfully !!!';
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
                                    $scheduleHTML           .= '<option value="'.$project->id.'" '.$selectedProject.'>'.$project->name.' ('.$project->client_name.') - '.$project->project_status_name.'</option>
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
        ];
        $this->data['model']->save_data('morning_meetings', $fields, $schedule_id, 'id');

        $scheduleHTML               = '';
        $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
        $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'INNER'];
        $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
        $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $requestData['user_id'], 'morning_meetings.date_added' => date('Y-m-d')], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority', $join1, '', $order_by1);
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

                if($getTask->priority == 3){
                    $priority = '<span><i class="fa-solid fa-medal" style="color: #FFD43B; border:1px solid #FFD43B; border-radius:50%; padding:3px;float:right;" title="High"></i></span>';
                }
                if($getTask->priority == 2){
                    $priority = '<span><i class="fa-solid fa-medal" style="color: #CCCCCC; border:1px solid #CCCCCC; border-radius:50%; padding:3px;float:right;" title="Medium"></i></span>';
                }
                if($getTask->priority == 1){
                    $priority = '<span><i class="fa-solid fa-medal" style="color: #b08d57; border:1px solid #b08d57; border-radius:50%; padding:3px;float:right;" title="Low"></i></span>';
                }

                $scheduleHTML .= '<div class="input-group mb-1">
                                <div class="card">
                                    <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: ' . $work_status_color . ';">
                                        <p class="mb-2">
                                            ' . $priority . '
                                            <span class="mb-1 d-block"><b>'.$getTask->project_name.' :</b> '.$getTask->description.'</span> [' .$hr. ' ' .$min. ']
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
        
        $dept_id        = $requestData['dept_id'];
        $user_id        = $requestData['user_id'];
        $getUser        = $this->common_model->find_data('user', 'row', ['id' => $user_id], 'name');
        $user_name      = (($getUser)?$getUser->name:'');

        $scheduleHTML .= '<a href="javascript:void(0);" class="task_edit_btn" onclick="openForm('.$dept_id.', '.$user_id.', \''.$user_name.'\');">
                                <i class="fa-solid fa-plus-circle text-success"></i>
                            </a>';
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