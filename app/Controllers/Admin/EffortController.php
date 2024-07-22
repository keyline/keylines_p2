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
        // pr($data['rows']);
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
        $data['effortTypes']        = $this->data['model']->find_data('effort_type', 'array', '', 'id,name', '', '', $orderBy2);
        $user_id                    = $this->session->get('user_id');
        $user_hour_cost             = $this->data['model']->find_data('user', 'row', ['id' => $user_id], 'id,hour_cost', '', '',);
        $user_cost                  = $user_hour_cost->hour_cost;
        // pr($user_cost);
        if($this->request->getMethod() == 'post') {
            $requestData    = $this->request->getPost();
            $user_id        = $this->session->get('user_id');
            $date_task      = $requestData['date_task'];
            $project        = $requestData['project'];
            $hour           = $requestData['hour'];
            $minute         = $requestData['minute'];
            $description    = $requestData['description'];
            $effort_type    = $requestData['effort_type'];
            // $work_home      = $requestData['work_home'];
            //  $cal_usercost= ($user_cost/60);
            if(!empty($project)){
                for($p=0;$p<count($project);$p++){
                    $getProject     = $this->data['model']->find_data('project', 'row', ['id' => $project[$p]], 'status,bill');
                    $postData   = array(
                        'project_id'            => $project[$p],
                        'status_id'             => (($getProject)?$getProject->status:0),
                        'user_id'               => $user_id,
                        'description'           => $description[$p],
                        'hour'                  => $hour[$p],
                        'min'                   => $minute[$p],
                        'work_home'             => 0,
                        'effort_type'           => $effort_type[$p],
                        'date_today'            => date('Y-m-d H:i:s'),
                        'date_added'            => $date_task,
                        'bill'                  => (($getProject)?$getProject->bill:1),
                        'assigned_task_id'      => 0,
                        'hour_rate'        =>  $user_cost
                    );
                    // $cal= (($hour[$p]*60) + $minute[$p]); //converted to minutes
                    // $projectCost= floatval($cal_usercost * $cal);
                    // $postData['cost']= number_format($projectCost, 2, '.', '');
                    // pr($postData,0);                    
                    $record     = $this->data['model']->save_data('timesheet', $postData, '', 'id');
                    
                }
                // die;
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
}