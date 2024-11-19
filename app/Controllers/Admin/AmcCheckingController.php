<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class AmcCheckingController extends BaseController {

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
            'title'                 => 'AMC Checking',
            'controller_route'      => 'amc-checking',
            'controller'            => 'AmcCheckingController',
            'table_name'            => 'project',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'amc-checking';
        $currentdate                = date("Y-m-d");  
        $user_id                    = $this->session->get('user_id');
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status' => '1'], '', '');
        $data['user']               = $this->data['model']->find_data('user', 'row', ['id' => $user_id], '', '', '', '');                
        $hour_cost                  = $data['user']->hour_cost;
        $cal_usercost               = (($hour_cost != '')?($hour_cost/60):0);
        //  pr($data['users']);      
        $data['amc_setting']        = $this->data['model']->find_data('setting', 'array', ['id' => '1'], '', '', '', '');        
       $sql                        = "SELECT project.*,tab1.id amc_chkid, tab1.last_amcdate chk_date FROM project left JOIN 
                                        ( SELECT id,project_id,user_id,comment,status,max(date) last_amcdate FROM `amc_check` group by project_id) tab1 
                                        on project.id = tab1.project_id where project.status IN ('9', '4') and  project.deadline >= '$currentdate' order by DATE(tab1.last_amcdate)";
        $data['rows']               = $this->db->query($sql)->getResult();         
        $date_on                    = date('Y-m-d H:i:s');
        $today_date                 = date('Y-m-d');
        if($this->request->getMethod() == 'post') {     
            // pr($this->request->getPost());      
            $project_id         = $this->request->getPost('project_id');
            $assign_id          = $this->request->getPost('user_id');
            $comment            = $this->request->getPost('comment');
            $project            = "SELECT project.*, project_status.name as project_status_name FROM `project` INNER JOIN project_status on project.status = project_status.id WHERE project.id =  $project_id";
            $project_details    = $this->db->query($project)->getRow(); 
            $assign_user        = $this->data['model']->find_data('user', 'row', ['id'=>$assign_id]);
            $assignby_user      = $this->data['model']->find_data('user', 'row', ['id'=>$user_id]);
                // pr($project_details);
            $url                = $project_details->permanent_url;
            $proj_name          = $project_details->name;
            $status             = $project_details->status;
            $bill               = $project_details->bill;

            $data['amc_setting']        = $this->data['model']->find_data('setting', 'row', ['id' => 1], '', '', '', '');        
            $time                       = $data['amc_setting']->amc_check_min;
            $check_description          = $data['amc_setting']->check_description;

            $postData = array(
                'project_id' => $project_id,
                'user_id'    => $user_id,
                'comment'    => $comment,
                'status'     => '1',
                'date'       => $date_on
            );    
            $postData2 = array(
                'project_id'        => $project_id,
                'status_id'         => '9',
                'user_id'           => $user_id,
                'description'       => $check_description,
                'hour'              => '0',
                'min'               => $time,
                'work_home'         => '0',
                'effort_type'       => '11',
                'date_today'        => $date_on,
                'date_added'        => $date_on,
                'bill'              => '0',
                'assigned_task_id'  => '0',
                'hour_rate'         => $hour_cost
            );
            $cal                = ((0*60) + $time); //converted to minutes
            $projectCost        = floatval($cal_usercost * $cal);
            $postData2['cost']  = number_format($projectCost, 2, '.', '');
            $postData3 = array(
                'project_id'        => $project_id,
                'assigned_to'       => $assign_id,
                'assigned_by'       => $user_id,
                'description'       => $comment,
                'estimated_hour'    => '0',
                'estimated_minute'  => '0',
                'start_date'        => $today_date,
                'end_date'          => $today_date,
                'priority'          => '3',
                'status'            => '0',
                'entry_date'        => $date_on,                
            );
            $insertData3 = $this->common_model->save_data('assigned_task',$postData3,'',$this->data['primary_key']);
            $insertData2 = $this->common_model->save_data('timesheet',$postData2,'',$this->data['primary_key']);
            $insertData = $this->common_model->save_data('amc_check',$postData,'',$this->data['primary_key']);
            $mailData                   = [
                'assign_user'       => $assign_user->name,
                'project_name'      => $project_details->name,
                'project_url'       => $project_details->permanent_url,
                'project_status'    => $project_details->project_status_name,
                'assigned_by'       => $assignby_user->name,
                'description'       => $comment
            ];
            $subject    = ' New Task is assigned for project '.$project_details->name;
            $message    = view('email-templates/assign-task',$mailData);
            if($this->sendMail($assign_user->email, $subject, $message))
            {
                $this->session->setFlashdata('success_message', ' Email send is Successfully');
                return redirect()->to('/admin/'.$this->data['controller_route']);
            }
            
        }       
        echo $this->layout_after_login($title,$page_name,$data);
    }   
    public function ok_status($id)
    {
        $id                         = decoded($id);
        $user_id                    = $this->session->get('user_id');
        $data['user']               = $this->data['model']->find_data('user', 'row', ['id' => $user_id], '', '', '', '');                
        $hour_cost                  = $data['user']->hour_cost;
        $cal_usercost               = ($hour_cost/60);
        $data['amc_setting']        = $this->data['model']->find_data('setting', 'row', ['id' => 1], '', '', '', '');        
        $time                       = $data['amc_setting']->amc_check_min;
        $check_description          = $data['amc_setting']->check_description;
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        $date_on                    = date('Y-m-d H:i:s');      
        $postData = array(
            'project_id' => $id,
            'user_id'    => $user_id,
            'comment'    => '',
            'status'     => '0',
            'date'       => $date_on
                        );    
        $postData2 = array(
            'project_id'        => $id,
            'status_id'         => '9',
            'user_id'           => $user_id,
            'description'       => $check_description,
            'hour'              => '0',
            'min'               => $time,
            'work_home'         => '0',
            'effort_type'       => '11',
            'date_today'        => $date_on,
            'date_added'        => $date_on,
            'bill'              => '0',
            'assigned_task_id'  => '0',
            'hour_rate'         => $hour_cost
        );
        $cal                = ((0*60) + $time); //converted to minutes
        $projectCost        = floatval($cal_usercost * $cal);
        $postData2['cost']  = number_format($projectCost, 2, '.', '');

        $year                   = date('Y', strtotime($date_on)); // 2024
        $month                  = date('m', strtotime($date_on)); // 08

        $insertData2 = $this->common_model->save_data('timesheet',$postData2,'',$this->data['primary_key']);
        
        $projectcost            = "SELECT SUM(cost) AS total_hours_worked FROM `timesheet` WHERE `date_added` LIKE '%".$year . "-" . $month ."%' and project_id=".$id."";
        //  echo $this->db->getLastquery();die;
        $rows                   = $this->db->query($projectcost)->getResult(); 
        // pr($rows);
        foreach($rows as $row){
            $project_cost       =  $row->total_hours_worked;
        }  
        $exsistingProjectCost   = $this->common_model->find_data('project_cost', 'row', ['project_id' => $id, 'created_at LIKE' => '%'.$year . '-' . $month .'%']);
        if(!$exsistingProjectCost){
            echo "new add"; die;
            $postData3   = array(
                'project_id'            => $id,
                'month'                 => $month ,
                'year'                  => $year,
                'project_cost'          => $project_cost,
                'created_at'            => date('Y-m-d H:i:s'),                                
            );                                  
            $project_cost_id             = $this->data['model']->save_data('project_cost', $postData3, '', 'id');
        } else {
            echo "data update"; die;
            $id         = $exsistingProjectCost->id;
            $postData3   = array(
                'project_id'            => $id,
                'month'                 => $month ,
                'year'                  => $year,
                'project_cost'          => $project_cost,
                'updated_at'            => date('Y-m-d H:i:s'),                                
            );                                    
            $update_project_cost_id      = $this->data['model']->save_data('project_cost', $postData3, $id, 'id');
        }           

        $insertData = $this->common_model->save_data('amc_check',$postData,'',$this->data['primary_key']);
        $this->session->setFlashdata('success_message', ' AMC Site is Checked Successfully');
        return redirect()->to('/admin/'.$this->data['controller_route']);
    }    
}