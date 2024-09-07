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

        // Declare two dates
        $applicationSetting         = $this->common_model->find_data('application_settings', 'row');
        $Date1 = date('Y-m-d', strtotime("-".$applicationSetting->block_tracker_fillup_after_days." days"));
        $Date2 = date('d-m-Y');
        
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
        $order_by2[0]               = array('field' => 'id', 'type' => 'ASC');
        $data['previousMorningSchedules']   = $this->common_model->find_data('morning_meetings', 'array', ['user_id' => $user_id, 'effort_id' => 0, 'is_leave' => 0, 'date_added<' => $data['before_date']], '', '', '', $order_by2);

        if($this->request->getMethod() == 'post') {
            $requestData    = $this->request->getPost();
            pr($requestData);die;
            $user_id                = $this->session->get('user_id');
            if (array_key_exists("date_task",$requestData)){
                $date_task              = $requestData['date_task'];
            } else {
                $date_task              = $requestData['date_added'][0];
            }
            
            $assigned_task_id       = $requestData['assigned_task_id'];
            $date_added             = $requestData['date_added'];
            $project                = $requestData['project'];
            $hour                   = $requestData['hour'];
            $minute                 = $requestData['minute'];
            $description            = $requestData['description'];
            $effort_type            = $requestData['effort_type'];
            $work_status_id         = $requestData['work_status_id'];
            $year                   = date('Y', strtotime($date_task)); // 2024
            $month                  = date('m', strtotime($date_task)); // 08
           
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
                            pr($postData);
                                                        
                            $effort_id              = $this->data['model']->save_data('timesheet', $postData, '', 'id');
                            $projectcost            = "SELECT SUM(cost) AS total_hours_worked FROM `timesheet` WHERE `date_added` LIKE '%".$year . "-" . $month ."%' and project_id=".$project[$p]."";
                            $rows                   = $this->db->query($projectcost)->getResult(); 
                            foreach($rows as $row){
                                $project_cost       =  $row->total_hours_worked;
                            }  
                            $exsistingProjectCost   = $this->common_model->find_data('project_cost', 'row', ['project_id' => $project[$p], 'created_at LIKE' => '%'.$year . '-' . $month .'%']);
                            if(!$exsistingProjectCost){
                                $postData2   = array(
                                    'project_id'            => $project[$p],
                                    'month'                 => $month ,
                                    'year'                  => $year,
                                    'project_cost'          => $project_cost,
                                    'created_at'            => date('Y-m-d H:i:s'),                                
                                );
                                  pr($postData2);
                                    $project_cost_id             = $this->data['model']->save_data('project_cost', $postData2, '', 'id');
                                } else {
                                    // echo "exsisting data update"; die;
                                    $id         = $exsistingProjectCost->id;
                                    $postData2   = array(
                                        'project_id'            => $project[$p],
                                        'month'                 => $month ,
                                        'year'                  => $year,
                                        'project_cost'          => $project_cost,
                                        'updated_at'            => date('Y-m-d H:i:s'),                                
                                    );
                                    //  pr($postData2);
                                    $update_project_cost_id      = $this->data['model']->save_data('project_cost', $postData2, $id, 'id');
                                }

                            
                            $this->data['model']->save_data('project_cost', $postData2, '', 'id');
                        // scheduled task
                        /* morning meeting schedule update */
                            $morningScheduleData = [
                                'project_id'            => $project[$p],
                                'status_id'             => (($getProject)?$getProject->status:0),
                                'user_id'               => $user_id,
                                // 'description'           => $description[$p],
                                // 'hour'                  => $hour[$p],
                                // 'min'                   => $minute[$p],
                                'work_home'             => 0,
                                'effort_type'           => $effort_type[$p],
                                'work_status_id'        => $work_status_id[$p],
                                'bill'                  => (($getProject)?$getProject->bill:1),
                                'effort_id'             => $effort_id,
                            ];
                            // pr($morningScheduleData);
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
                                $postData           = array(
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
                                    'date_added'            => $requestData['date_task'],
                                    'bill'                  => (($getProject)?$getProject->bill:1),
                                    'assigned_task_id'      => 0,
                                    'hour_rate'             => $user_cost,
                                    'cost'                  => number_format($projectCost, 2, '.', ''),
                                );
                                // pr($postData);
                                
                                $effort_id              = $this->data['model']->save_data('timesheet', $postData, '', 'id');
                                $projectcost            = "SELECT SUM(cost) AS total_hours_worked FROM `timesheet` WHERE `date_added` LIKE '%".$year . "-" . $month ."%' and project_id=".$project[$p]."";
                                $rows                   = $this->db->query($projectcost)->getResult(); 
                                foreach($rows as $row){
                                    $project_cost       =  $row->total_hours_worked;
                                }  
                                $exsistingProjectCost   = $this->common_model->find_data('project_cost', 'row', ['project_id' => $project[$p], 'created_at LIKE' => '%'.$year . '-' . $month .'%']);
                                if(!$exsistingProjectCost){
                                    $postData2   = array(
                                        'project_id'            => $project[$p],
                                        'month'                 => $month ,
                                        'year'                  => $year,
                                        'project_cost'          => $project_cost,
                                        'created_at'            => date('Y-m-d H:i:s'),                                
                                    );
                                    //  pr($postData2);
                                    $project_cost_id             = $this->data['model']->save_data('project_cost', $postData2, '', 'id');
                                } else {
                                    // echo "exsisting data update"; die;
                                    $id         = $exsistingProjectCost->id;
                                    $postData2   = array(
                                        'project_id'            => $project[$p],
                                        'month'                 => $month ,
                                        'year'                  => $year,
                                        'project_cost'          => $project_cost,
                                        'updated_at'            => date('Y-m-d H:i:s'),                                
                                    );
                                    //  pr($postData2);
                                    $update_project_cost_id      = $this->data['model']->save_data('project_cost', $postData2, $id, 'id');
                                }
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
                                    'date_added'            => $requestData['date_task'],
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
                        } else{
                            $this->session->setFlashdata('error_message', 'Please select project and other info before submit');
                            return redirect()->to('/admin/'.$this->data['controller_route'].'/add');
                            // echo "false"; die;
                        }
                    }
                }
            }           
            $this->session->setFlashdata('success_message', 'Effort Submitted Successfully For ' . date_format(date_create($date_task), "M d, Y"));
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
        $user_id                    = $this->session->get('user_id');
        $user_hour_cost             = $this->data['model']->find_data('user', 'row', ['id' => $user_id], 'id,hour_cost', '', '',);
        $user_cost                  = $user_hour_cost->hour_cost;
        $effortlist                 = $this->data['model']->find_data('timesheet', 'row', ['id' => $id], 'date_added', '', '',);
        // pr($data['row']);
        //    pr($effortlist);

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
            $year           = date('Y', strtotime($effortlist->date_added)); // 2024
            $month          = date('m', strtotime($effortlist->date_added)); // 08
            $cal_usercost   = ($user_cost/60);
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
            $cal                = (($hour*60) + $minute); //converted to minutes
            $projectCost        = floatval($cal_usercost * $cal);
            $postData['cost']   = number_format($projectCost, 2, '.', '');
            //  pr($postData,0);die;
            $record             = $this->data['model']->save_data('timesheet', $postData, $id, 'id');

             /* project cost saved */
            $projectcost        = "SELECT SUM(cost) AS total_hours_worked FROM `timesheet` WHERE `date_added` LIKE '%".$year . "-" . $month ."%' and project_id=".$project."";
            $rows               = $this->db->query($projectcost)->getResult(); 
            foreach($rows as $row){
                $project_cost   =  $row->total_hours_worked;
            }           
            $exsistingProjectCost   = $this->common_model->find_data('project_cost', 'row', ['project_id' => $project, 'month' => $month, 'year' => $year]);
            //  echo $this->db->getLastquery();die;
                if(!$exsistingProjectCost){              
                $postData2   = array(
                    'project_id'            => $project,
                    'month'                 => $month ,
                    'year'                  => $year,
                    'project_cost'          => $project_cost,
                    'created_at'            => date('Y-m-d H:i:s'),                                
                );               
                $project_cost_id             = $this->data['model']->save_data('project_cost', $postData2, '', 'id');                               
                } else {              
                $projectCostId         = $exsistingProjectCost->id;
                $postData2   = array(
                    'project_id'            => $project,
                    'month'                 => $month ,
                    'year'                  => $year,
                    'project_cost'          => $project_cost,
                    'updated_at'            => date('Y-m-d H:i:s'),                                
                );                
                $update_project_cost_id      = $this->data['model']->save_data('project_cost', $postData2, $projectCostId, 'id');                                           
                }                                           
            /* project cost saved */
            
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
    public function requestPreviousTaskSubmit($before_date){
        $before_date                = decoded($before_date);
        $user_id                    = $this->session->get('user_id');
        $getUser                    = $this->common_model->find_data('user', 'row', ['id' => $user_id]);
        $getTL                      = $this->common_model->find_data('user', 'row', ['type' => 'SUPER ADMIN']);
        $mailData                   = [
            'before_date'       => $before_date,
            'getUser'           => $getUser,
            'getTL'             => $getTL,
        ];
        $generalSetting             = $this->common_model->find_data('general_settings', 'row');
        $subject                    = $generalSetting->site_name.' :: Effort Booking Request Before - '.date_format(date_create($before_date), "M d, Y");
        $message                    = view('email-templates/request-task-fillup-edit-access',$mailData);
        // echo $message;die;
        // pr($getUser);
        /* email log save */
            $postData2 = [
                'name'                  => $generalSetting->site_name,
                'email'                 => $generalSetting->system_email,
                'subject'               => $subject,
                'message'               => $message
            ];
            $this->common_model->save_data('email_logs', $postData2, '', 'id');
        /* email log save */
        // $this->sendMail($generalSetting->system_email, $subject, $message);
        if($this->sendMail($generalSetting->system_email, $subject, $message)){
            $this->session->setFlashdata('success_message', $this->data['title'].' Booking Access Request Submitted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/add');
        }
        // $this->session->setFlashdata('success_message', $this->data['title'].' Booking Access Request Submitted successfully');
        // return redirect()->to('/admin/'.$this->data['controller_route'].'/add');
    }
}