<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class RoleMasterController extends BaseController {
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
            'title'                 => 'Role Master',
            'controller_route'      => 'role',
            'controller'            => 'RoleMasterController',
            'table_name'            => 'permission_roles',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add Role Master';
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'role-master/list';
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', '', '', '', '');
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'role-master/add-edit';
        $data['row']                = [];
        if($this->request->getMethod() == 'post') {
            $postData   = array(
                                'role_name'          => $this->request->getPost('role_master_name'),
                            );
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);            
            $this->session->setFlashdata('success_message', 'Role master inserted successfully');
            return redirect()->to('/admin/role-master/list');
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
}