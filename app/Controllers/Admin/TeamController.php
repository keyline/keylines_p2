<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class TeamController extends BaseController {
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
            'title'                 => 'Team',
            'controller_route'      => 'team',
            'controller'            => 'TeamController',
            'table_name'            => 'team',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'team/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        // $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', '', '', '');          
        $order_by[1]                = array('field' => 'status', 'type' => 'DESC');
        $order_by[2]                = array('field' => 'name', 'type' => 'ASC');
        $data['department']         = $this->data['model']->find_data('department', 'array', '', '', '');         
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status' => '1'], 'id,name,status,department,dept_type', '', '', $order_by);
        pr($data['department']);
        
        if($this->request->getMethod() == 'post') {           
            $user_id = $this->request->getPost('user_id');
            $existingRecord = $this->common_model->find_data('team', 'row', ['user_id' => $user_id]); 
            //   echo $this->db->getLastquery();die;
            // pr($existingRecord);
            if(!$existingRecord){
                // echo "not exist";die;                
                $postData   = array(
                    'dep_id'                  => $this->request->getPost('dep_id'),
                    'user_id'                 => $this->request->getPost('user_id'),                
                    'type'                  => $this->request->getPost('type'),               
                    'created_at'            => date('Y-m-d H:i:s'),
                );
                $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $user_id);
            }else {
                // echo "exist";die;
                $postData   = array(
                    'dep_id'                  => $this->request->getPost('dep_id'),
                    'user_id'                 => $this->request->getPost('user_id'),                
                    'type'                  => $this->request->getPost('type'),               
                    'created_at'            => date('Y-m-d H:i:s'),
                );
                // pr($postData);
                $record     = $this->data['model']->save_data($this->data['table_name'], $postData, $user_id,'user_id');
                //  echo $this->db->getLastquery();die;
            }            
            $postData1   = array(
                'department'                  => $this->request->getPost('dep_id'),
                'id'                 => $this->request->getPost('user_id'),                
                'dept_type'                  => $this->request->getPost('type'),                               
            );
            //   pr($postData1);  
             
             $record1    = $this->data['model']->save_data('user', $postData1, $user_id, $this->data['primary_key']);
            //  $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }
        // $data['team']               = $this->data['model']->find_data('team', 'array', '', '', '');        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'team/add-edit';        
        $data['row']                = [];        
        $data['department']         = $this->data['model']->find_data('department', 'array', '', '', '');        
        $order_by[0]                = array('field' => 'status', 'type' => 'DESC');
        $order_by[1]                = array('field' => 'name', 'type' => 'ASC');
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status' => '1'], 'id,name,status', '', '', $order_by);
        if($this->request->getMethod() == 'post') {           
            $postData   = array(
                'dep_id'                  => $this->request->getPost('dep_id'),
                'user_id'                 => $this->request->getPost('user_id'),                
                'type'                  => $this->request->getPost('type'),               
                'created_at'            => date('Y-m-d H:i:s'),
            );
            // pr($postData);           
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function edit($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'team/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['department']         = $this->data['model']->find_data('department', 'array', '', '', '');
        // pr($data['department']);die;
        $order_by[0]                = array('field' => 'status', 'type' => 'DESC');
        $order_by[1]                = array('field' => 'name', 'type' => 'ASC');
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status!=' => '3'], 'id,name,status', '', '', $order_by);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);        
        if($this->request->getMethod() == 'post') {           
            $postData   = array(
                'dep_id'                  => $this->request->getPost('dep_id'),
                'user_id'                 => $this->request->getPost('user_id'),                
                'type'                  => $this->request->getPost('type'),               
                'updated_at'            => date('Y-m-d H:i:s'),
            );
            // pr($postData);
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function confirm_delete($id)
    {
        $id                         = decoded($id);
        $postData = array(
                            'status' => 3
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    
    
}