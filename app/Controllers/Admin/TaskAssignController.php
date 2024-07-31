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

        $apiStatus                          = TRUE;
        http_response_code(200);
        $apiMessage                         = 'Task Submitted Successfully !!!';
        $apiExtraField                      = 'response_code';
        $apiExtraData                       = http_response_code();
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
}