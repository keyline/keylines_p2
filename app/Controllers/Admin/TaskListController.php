<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class TaskListController extends BaseController {

    private $model;  //This can be accessed by all class methods
	public function __construct()
    {
        $session = \Config\Services::session();
        if(!$session->get('is_admin_login')) {
            // return redirect()->to('/');
            header('Location: ' . base_url('/'));
            exit;
        }
        $model = new CommonModel();
        $this->data = array(
            'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Task List',
            'controller_route'      => 'task-list',
            'controller'            => 'TaskListController',
            'table_name'            => 'task_list',
            'primary_key'           => 'id'
        );
    }

    public function tasklist() {
        if(!$this->common_model->checkModuleFunctionAccess(17, 15)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'task-list/list';
        // $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $select                     = 'task_list.id as task_id, task_list.task_name, task_list.project_id, task_list.estimated_minutes, task_list.status, task_list.created_at, task_list.updated_at, project.name as project_name';
        $join[0]                    = ['table' => 'project', 'field' => 'id', 'table_master' => 'task_list', 'field_table_master' => 'project_id', 'type' => 'INNER'];
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', '', $select, $join, '', '');
        $data['projects']           = $this->data['model']->find_data('project', 'array', ['status!=' => 13], '', '', '', '');
        // var_dump($data['projects']); die;
        if($this->request->getMethod() == 'post'){
            $id = (int) ($this->request->getPost('id') ?? 0);
            
                $estimate_hour  = $this->request->getPost('estimate_hour');
                $estimate_minutes  = $this->request->getPost('estimate_minutes');
                $total_estimate_minutes = ($estimate_hour * 60) + $estimate_minutes;

                $user_id = $this->data['session']->get('user_id');

           if($id > 0){     
                $postdata = array(
                    'task_name'         => trim((string)$this->request->getPost('task_name')),
                    'project_id'        => $this->request->getPost('project_id'),
                    'estimated_minutes' => $total_estimate_minutes,
                    'updated_at'        => date('Y-m-d H:i:s'),
                );
           } else{
                $postdata = array(
                    'task_name'         => trim((string)$this->request->getPost('task_name')),
                    'project_id'        => $this->request->getPost('project_id'),
                    'estimated_minutes' => $total_estimate_minutes,
                    'created_by'        => $user_id,
                    'created_at'        => date('Y-m-d H:i:s'),
                );
           }

            if($id > 0){
                // echo $id; die;
                $this->data['model']->save_data($this->data['table_name'], $postdata, $id, $this->data['primary_key']);
                $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            } else {
                $postdata['created_at'] = date('Y-m-d H:i:s');
                $this->data['model']->save_data($this->data['table_name'], $postdata, '', $this->data['primary_key']);
                $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            }

            return redirect()->to(current_url());
        }
      //    var_dump($data['rows']); die;
        echo $this->layout_after_login($title,$page_name,$data);
    }


}  
