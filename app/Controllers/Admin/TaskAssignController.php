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
        // pr($data['moduleDetail'] );
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'task-assign/list';
        // $data                       =[];
        // $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        // $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', '', 'id,name,compnay,address_1,state,city,country,pin,address_2,email_1,email_2,phone_1,phone_2,reference,added_date,last_login,login_access', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
}