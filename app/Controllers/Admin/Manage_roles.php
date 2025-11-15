<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use DB;
class Manage_roles extends BaseController {

    private $model;  //This can be accessed by all class methods
	public function __construct()
    {
        $session = \Config\Services::session();
        if(!$session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }
        $model = new CommonModel();
        $this->data = array(
            'model'         => $model,
            'session'       => $session,
            'module'        => 'Roles',
            'controller'    => 'manage_roles',
            'table_name'    => 'permission_roles',
            'primary_key'   => 'id'
        );
    }
    public function index() 
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['module'];
        $page_name                  = 'roles/list';        
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'asc');
        $userType                   = $this->session->user_type;
        if($userType == 'SUPER ADMIN'){
            $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['published!=' => 3 ], '', '', '', $order_by);
        }else{
            $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['published!=' => 3 , 'role_name!=' => 'SUPER ADMIN'  ], '', '', '', $order_by);
        }
        if($this->request->getMethod() == 'post') {
            // pr($this->request->getPost());
            $bulkData   =$this->request->getPost();
            // $bulkcount      =count($bulkData['draw']);
            for($j=0;$j<count($bulkData['draw']);$j++){
                $id = $bulkData['draw'][$j]; 
                $postData = array(
                    'published' => 3
                );
                $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
                // echo $this->db->getLastQuery();die;
            }
                $this->session->setFlashdata('success_message', $this->data['module'].' deleted successfully');
                return redirect()->to('/admin/'.$this->data['controller']);
            }  
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['module'];
        $page_name                  = 'roles/add-edit';        
        $data['row'] = [];
        $data['role_masters']       = $this->data['model']->find_data('permission_roles', 'array', ['published=' => 1 ], '', '', '');
            if($this->request->getPost()){
                $postData = [
                                'role_name'                    => strtoupper($this->request->getPost('role_name'))
                            ];
                $role_id = $this->common_model->save_data('permission_roles', $postData, '', 'id');
                /* function manage */
                    $function_id  = $this->request->getPost('function_id');
                    if(count($function_id)>0){
                        for($f=0;$f<count($function_id);$f++){
                            $function    = $this->common_model->find_data('permission_module_functions', 'row', ['function_id' => $function_id[$f]]);
                            $postData2 = [
                                      'role_id'                         => $role_id,
                                      'module_id'                       => (($function)?$function->module_id:0),
                                      'function_id'                     => $function_id[$f],
                                    ];
                            $this->common_model->save_data('permission_role_module_function', $postData2, '', 'function_id');
                        }
                    }
                /* function manage */
                // $session->setFlashdata('success_message', 'Role Created Successfully !!!');
                return redirect()->to(base_url('admin/manage_roles'));
            }
            $data['row']            = [];
            $data['action']         = 'Add';
            $data['parentmodules']  = $this->common_model->find_data('permission_modules', 'array', ['published' => 1, 'parent_id' => 0]);
            $data['functions']      = [];
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function edit($id)
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['module'];
        $page_name                  = 'roles/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->common_model->find_data('permission_roles', 'row', ['id' => $id]);
        $data['role_masters']       = $this->data['model']->find_data('permission_roles', 'array', ['published=' => 1 ], '', '', '');
        // pr($data['row']);
        $data['parentmodules']      = $this->common_model->find_data('permission_modules', 'array', ['published' => 1, 'parent_id' => 0]);
        $data['functions']          = $this->common_model->find_data('permission_module_functions', 'array', ['published' => 1, 'module_id' => $id]);
        $data['action']             = 'Update';
        if($this->request->getPost()){
            // pr($this->request->getPost());
            $postData = [
                            'role_name'                    => strtoupper($this->request->getPost('role_name_hidden')),
                            'updated_at'                   => date('Y-m-d H:i:s')
                        ];
            // $this->common_model->save_data('permission_roles', $postData, $id, 'id');
            $role_id = $id;
            $this->common_model->delete_data('permission_role_module_function', $role_id, 'role_id');
            /* function manage */
                $function_id  = $this->request->getPost('function_id');
                if(count($function_id)>0){
                    for($f=0;$f<count($function_id);$f++){
                        $function    = $this->common_model->find_data('permission_module_functions', 'row', ['function_id' => $function_id[$f]]);
                        $postData2 = [
                                        'role_id'                         => $role_id,
                                        'module_id'                       => (($function)?$function->module_id:0),
                                        'function_id'                     => $function_id[$f],
                                    ];
                        $this->common_model->save_data('permission_role_module_function', $postData2, '', 'function_id');
                    }
                }
            /* function manage */                    
            $this->session->setFlashdata('success_message', $this->data['module'].' inserted successfully');
            return redirect()->to('/admin/'.$this->data['controller']);
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function view($id){
        $this->common_model     = new CommonModel();
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'View';
        $title                      = $data['action'].' '.$this->data['module'];
        $page_name                  = 'roles/view';
        $this->session          = \Config\Services::session();        
        // $userId                 = $this->session->get('userId');
        // if(isset($userId)){
            $data['common_model']   = $this->common_model;
            $data['session']        = $this->session;
            $data['row']            = $this->common_model->find_data('permission_roles', 'row', ['id' => $id]);
            $data['parentmodules']  = $this->common_model->find_data('permission_modules', 'array', ['published' => 1, 'parent_id' => 0]);
            // } else {
                // return redirect()->to(base_url('admin/login'));
                // }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function confirm_delete($id)
    {
        $postData = array(
                            'published' => 3
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['module'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller']);
    }
    public function deactive($id)
    {
        $postData = array(
            'published' => 0
        );
        $this->common_model->save_data('permission_roles', $postData, $id, 'id');
        $this->session->setFlashdata('success_message', $this->data['module'].' deactivated successfully');
        return redirect()->to('/admin/'.$this->data['controller']);
    }
    public function active($id)
    {
        $postData = array(
            'published' => 1
        );
        $this->common_model->save_data('permission_roles', $postData, $id, 'id');
        $this->session->setFlashdata('success_message', $this->data['module'].' activated successfully');
        return redirect()->to('/admin/'.$this->data['controller']);
    }
}