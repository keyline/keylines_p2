<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class EffortController extends BaseController {
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
            'title'                 => 'Effort',
            'controller_route'      => 'efforts',
            'controller'            => 'EffortController',
            'table_name'            => 'timesheet',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $user_id                    = $this->session->get('user_id');
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'effort/list';
        $order_by[0]                = array('field' => 'date_added', 'type' => 'desc');
        $order_by[1]                = array('field' => 'id', 'type' => 'asc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['user_id' => $user_id], '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'effort/add-edit';
        $order_by[0]                = array('field' => 'project.name', 'type' => 'ASC');
        $join[0]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
        $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
        $data['projects']           = $this->data['model']->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
        $orderBy2[0]                = array('field' => 'name', 'type' => 'ASC');
        $data['effortTypes']        = $this->data['model']->find_data('effort_type', 'array', ['status' => 1], 'id,name', '', '', $orderBy2);
        $data['workStats']          = $this->data['model']->find_data('work_status', 'array', ['status' => 1, 'is_schedule' => 1], 'id,name', '', '', $orderBy2);
        $user_id                    = $this->session->get('user_id');
        $user_hour_cost             = $this->data['model']->find_data('user', 'row', ['id' => $user_id], 'id,hour_cost', '', '',);
        $user_cost                  = $user_hour_cost->hour_cost;
        //  pr($user_cost);

        $order_by2[0]               = array('field' => 'id', 'type' => 'ASC');
        $data['morningSchedules']   = $this->common_model->find_data('morning_meetings', 'array', ['user_id' => $user_id, 'effort_id' => 0, 'is_leave' => 0, 'date_added<=' => date('Y-m-d')], '', '', '', $order_by2);

        if($this->request->getMethod() == 'post') {
            $requestData    = $this->request->getPost();
            // pr($requestData);die;
            $user_id                = $this->session->get('user_id');
            $date_task              = $requestData['date_task'];
            $assigned_task_id       = $requestData['assigned_task_id'];
            $date_added             = $requestData['date_added'];
            $project                = $requestData['project'];
            $hour                   = $requestData['hour'];
            $minute                 = $requestData['minute'];
            $description            = $requestData['description'];
            $effort_type            = $requestData['effort_type'];
            $work_status_id         = $requestData['work_status_id'];
            
            $cal_usercost= ($user_cost/60);
            if(!empty($assigned_task_id)){
                for($p=0;$p<count($assigned_task_id);$p++){
                    $getProject     = $this->data['model']->find_data('project', 'row', ['id' => $project[$p]], 'status,bill');
                    $getUser        = $this->data['model']->find_data('user', 'row', ['id' => $user_id], 'department');
                    $getWorkStatus  = $this->common_model->find_data('work_status', 'row', ['id' => $work_status_id[$p]], 'is_reassign');
                    
                    if($assigned_task_id[$p] > 0){
                        // scheduled task
                            $cal                = (($hour[$p]*60) + $minute[$p]); //converted to minutes
                            $projectCost        = floatval($cal_usercost * $cal);
                            $postData   = array(
                                'project_id'            => $project[$p],
                                'status_id'             => (($getProject)?$getProject->status:0),
                                'user_id'               => $user_id,
                                'description'           => $description[$p],
                                'hour'                  => $hour[$p],
                                'min'                   => $minute[$p],
                                'work_home'             => 0,
                                'effort_type'           => $effort_type[$p],
                                'work_status_id'        => $work_status_id[$p],
                                'date_today'            => date('Y-m-d H:i:s'),
                                'date_added'            => $date_added[$p],
                                'bill'                  => (($getProject)?$getProject->bill:1),
                                'assigned_task_id'      => $assigned_task_id[$p],
                                'hour_rate'             => $user_cost,
                                'cost'                  => number_format($projectCost, 2, '.', ''),
                            );
                            $effort_id             = $this->data['model']->save_data('timesheet', $postData, '', 'id');
                        // scheduled task
                        /* morning meeting schedule update */
                            $morningScheduleData = [
                                'project_id'            => $project[$p],
                                'status_id'             => (($getProject)?$getProject->status:0),
                                'user_id'               => $user_id,
                                'description'           => $description[$p],
                                'hour'                  => $hour[$p],
                                'min'                   => $minute[$p],
                                'work_home'             => 0,
                                'effort_type'           => $effort_type[$p],
                                'work_status_id'        => $work_status_id[$p],
                                'bill'                  => (($getProject)?$getProject->bill:1),
                                'effort_id'             => $effort_id,
                            ];
                            $this->data['model']->save_data('morning_meetings', $morningScheduleData, $assigned_task_id[$p], 'id');
                            $schedule_id = $assigned_task_id[$p];
                        /* morning meeting schedule update */
                        /* timesheet update for effort id */
                            $this->data['model']->save_data('timesheet', ['assigned_task_id' => $schedule_id], $effort_id, 'id');
                        /* timesheet update for effort id */
                        // Finish & Assign tomorrow
                            if($getWorkStatus){
                                if($getWorkStatus->is_reassign){
                                    /* next working data calculate */
                                        // for($c=1;$c<=7;$c++){
                                            $date_added1 = date('Y-m-d', strtotime("+1 days"));
                                            if($this->calculateNextWorkingDate($date_added1)){
                                                $next_working_day = $date_added1;
                                            } else {
                                                // echo 'not working day';
                                                $date_added2 = date('Y-m-d', strtotime("+2 days"));
                                                if($this->calculateNextWorkingDate($date_added2)){
                                                    $next_working_day = $date_added2;
                                                } else {
                                                    $date_added3 = date('Y-m-d', strtotime("+3 days"));
                                                    if($this->calculateNextWorkingDate($date_added3)){
                                                        $next_working_day = $date_added3;
                                                    } else {
                                                        $date_added4 = date('Y-m-d', strtotime("+4 days"));
                                                        if($this->calculateNextWorkingDate($date_added4)){
                                                            $next_working_day = $date_added4;
                                                        } else {
                                                            $date_added5 = date('Y-m-d', strtotime("+5 days"));
                                                            if($this->calculateNextWorkingDate($date_added5)){
                                                                $next_working_day = $date_added5;
                                                            } else {
                                                                $date_added6 = date('Y-m-d', strtotime("+6 days"));
                                                                if($this->calculateNextWorkingDate($date_added6)){
                                                                    $next_working_day = $date_added6;
                                                                } else {
                                                                    $date_added7 = date('Y-m-d', strtotime("+7 days"));
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
                                        'project_id'            => $project[$p],
                                        'status_id'             => (($getProject)?$getProject->status:0),
                                        'user_id'               => $user_id,
                                        'description'           => $description[$p],
                                        'hour'                  => $hour[$p],
                                        'min'                   => $minute[$p],
                                        'work_home'             => 0,
                                        'effort_type'           => 0,
                                        'date_added'            => $next_working_day,
                                        'added_by'              => $user_id,
                                        'bill'                  => (($getProject)?$getProject->bill:1),
                                        'work_status_id'        => 0,
                                        'priority'              => 3,
                                        'effort_id'             => 0,
                                    ];
                                    // pr($morningScheduleData2);
                                    $this->data['model']->save_data('morning_meetings', $morningScheduleData2, '', 'id');
                                }
                            }
                        // Finish & Assign tomorrow
                    } else {
                        if($project[$p] != ''){
                            // new task
                                $cal                = (($hour[$p]*60) + $minute[$p]); //converted to minutes
                                $projectCost        = floatval($cal_usercost * $cal);
                                $postData   = array(
                                    'project_id'            => $project[$p],
                                    'status_id'             => (($getProject)?$getProject->status:0),
                                    'user_id'               => $user_id,
                                    'description'           => $description[$p],
                                    'hour'                  => $hour[$p],
                                    'min'                   => $minute[$p],
                                    'work_home'             => 0,
                                    'effort_type'           => $effort_type[$p],
                                    'work_status_id'        => $work_status_id[$p],
                                    'date_today'            => date('Y-m-d H:i:s'),
                                    'date_added'            => $date_task,
                                    'bill'                  => (($getProject)?$getProject->bill:1),
                                    'assigned_task_id'      => 0,
                                    'hour_rate'             => $user_cost,
                                    'cost'                  => number_format($projectCost, 2, '.', ''),
                                );
                                $effort_id             = $this->data['model']->save_data('timesheet', $postData, '', 'id');
                            // new task
                            /* morning meeting schedule insert */
                                $morningScheduleData = [
                                    'dept_id'               => (($getUser)?$getUser->department:0),
                                    'project_id'            => $project[$p],
                                    'status_id'             => (($getProject)?$getProject->status:0),
                                    'user_id'               => $user_id,
                                    'description'           => $description[$p],
                                    'hour'                  => $hour[$p],
                                    'min'                   => $minute[$p],
                                    'work_home'             => 0,
                                    'effort_type'           => $effort_type[$p],
                                    'date_added'            => $date_added[$p],
                                    'added_by'              => $user_id,
                                    'bill'                  => (($getProject)?$getProject->bill:1),
                                    'work_status_id'        => $work_status_id[$p],
                                    'priority'              => 3,
                                    'effort_id'             => $effort_id,
                                ];
                                $schedule_id             = $this->data['model']->save_data('morning_meetings', $morningScheduleData, '', 'id');
                            /* morning meeting schedule insert */
                            /* timesheet update for effort id */
                                $this->data['model']->save_data('timesheet', ['assigned_task_id' => $schedule_id], $effort_id, 'id');
                            /* timesheet update for effort id */
                            // Finish & Assign tomorrow
                                if($getWorkStatus){
                                    if($getWorkStatus->is_reassign){
                                        /* next working data calculate */
                                            // for($c=1;$c<=7;$c++){
                                                $date_added1 = date('Y-m-d', strtotime("+1 days"));
                                                if($this->calculateNextWorkingDate($date_added1)){
                                                    $next_working_day = $date_added1;
                                                } else {
                                                    // echo 'not working day';
                                                    $date_added2 = date('Y-m-d', strtotime("+2 days"));
                                                    if($this->calculateNextWorkingDate($date_added2)){
                                                        $next_working_day = $date_added2;
                                                    } else {
                                                        $date_added3 = date('Y-m-d', strtotime("+3 days"));
                                                        if($this->calculateNextWorkingDate($date_added3)){
                                                            $next_working_day = $date_added3;
                                                        } else {
                                                            $date_added4 = date('Y-m-d', strtotime("+4 days"));
                                                            if($this->calculateNextWorkingDate($date_added4)){
                                                                $next_working_day = $date_added4;
                                                            } else {
                                                                $date_added5 = date('Y-m-d', strtotime("+5 days"));
                                                                if($this->calculateNextWorkingDate($date_added5)){
                                                                    $next_working_day = $date_added5;
                                                                } else {
                                                                    $date_added6 = date('Y-m-d', strtotime("+6 days"));
                                                                    if($this->calculateNextWorkingDate($date_added6)){
                                                                        $next_working_day = $date_added6;
                                                                    } else {
                                                                        $date_added7 = date('Y-m-d', strtotime("+7 days"));
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
                                            'project_id'            => $project[$p],
                                            'status_id'             => (($getProject)?$getProject->status:0),
                                            'user_id'               => $user_id,
                                            'description'           => $description[$p],
                                            'hour'                  => $hour[$p],
                                            'min'                   => $minute[$p],
                                            'work_home'             => 0,
                                            'effort_type'           => 0,
                                            'date_added'            => $next_working_day,
                                            'added_by'              => $user_id,
                                            'bill'                  => (($getProject)?$getProject->bill:1),
                                            'work_status_id'        => $work_status_id[$p],
                                            'priority'              => 3,
                                            'effort_id'             => 0,
                                        ];
                                        $this->data['model']->save_data('morning_meetings', $morningScheduleData2, '', 'id');
                                    }
                                }
                            // Finish & Assign tomorrow
                        }
                    }
                }
            }           
            $this->session->setFlashdata('success_message', 'Effort Submitted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/effort-success');
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function effortSuccess()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Success';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'effort/effort-success';
        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function edit($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'effort/edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        // pr($data['row']);

        $order_by[0]                = array('field' => 'project.name', 'type' => 'ASC');
        $join[0]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
        $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
        $data['projects']           = $this->data['model']->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
        $orderBy2[0]                = array('field' => 'name', 'type' => 'ASC');
        $data['effortTypes']        = $this->data['model']->find_data('effort_type', 'array', '', 'id,name', '', '', $orderBy2);
        if($this->request->getMethod() == 'post') {
            $requestData    = $this->request->getPost();
            $project        = $requestData['project'];
            $hour           = $requestData['hour'];
            $minute         = $requestData['minute'];
            $description    = $requestData['description'];
            $effort_type    = $requestData['effort_type'];
            $getProject     = $this->data['model']->find_data('project', 'row', ['id' => $project], 'status,bill');
            $postData   = array(
                'project_id'            => $project,
                'status_id'             => (($getProject)?$getProject->status:0),
                'description'           => $description,
                'hour'                  => $hour,
                'min'                   => $minute,
                'work_home'             => 0,
                'effort_type'           => $effort_type,
                'bill'                  => (($getProject)?$getProject->bill:1),
                'assigned_task_id'      => 0,
            );
            // pr($postData,0);die;
            $record     = $this->data['model']->save_data('timesheet', $postData, $id, 'id');
            $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/edit/'.encoded($id));
        }        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function confirm_delete($id)
    {
        $id                         = decoded($id);
        $updateData = $this->common_model->delete_data($this->data['table_name'], $id, $this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function change_status($id)
    {
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        if($data['row']->status){
            $status  = 0;
            $msg        = 'Deactivated';
        } else {
            $status  = 1;
            $msg        = 'Activated';
        }
        $postData = array(
                            'status' => $status
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function getProjectInfo(){
        $apiStatus          = FALSE;
        $apiMessage         = '';
        $apiResponse        = [];
        $projectId = $this->request->getPost('projectId');
        $getProject = $this->common_model->find_data('project', 'row', ['id' => $projectId]);
        if($getProject){
            $assigned = 0;
            if($getProject->project_time_type == 'Onetime'){
                $assigned               = $getProject->hour;
                $current_month_booking  = $this->common_model->getProjectBooking($projectId, 'Monthlytime');
                $total_booked           = $this->common_model->getProjectBooking($projectId, 'Onetime');
            } elseif($getProject->project_time_type == 'Monthlytime'){
                $assigned               = $getProject->hour_month;
                $current_month_booking  = $this->common_model->getProjectBooking($projectId, 'Monthlytime');
                $total_booked           = $this->common_model->getProjectBooking($projectId, 'Onetime');
            }
            $apiResponse        = [
                'project_time_type'                     => $getProject->project_time_type,
                'assigned'                              => $assigned,
                'current_month_booking'                 => $current_month_booking,
                'total_booked'                          => $total_booked,
            ];
            $apiStatus          = TRUE;
            $apiMessage         = 'Project Data Available !!!';
        } else {
            $apiStatus          = FALSE;
            $apiMessage         = 'Project Not Found !!!';
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
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
}