<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use DB;
class Manage_modulelist extends BaseController {

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
            'module'        => 'Module',
            'controller'    => 'manage_modulelist',
            'table_name'    => 'sms_modules',
            'primary_key'   => 'id'
        );
    }
    public function index() 
    {
        $session = \Config\Services::session();
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['module'];
        $page_name                  = 'modulelist/list';        
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['published!=' => 3  ], '', '', '', $order_by);
        if($this->request->getMethod() == 'post') {
            $bulkData   =$this->request->getPost();
            for($j=0;$j<count($bulkData['draw']);$j++){
                $id = $bulkData['draw'][$j];
                $postData = array(
                                    'published' => 3
                                );
                $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
            }
                $this->session->setFlashdata('success_message', $this->data['module'].' deleted successfully');
                return redirect()->to('/admin/'.$this->data['controller']);
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $session = \Config\Services::session();
        $userId                  = $session->get('user_id');
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['module'];
        $page_name                  = 'modulelist/add-edit';
        $data['allfunctions']       = $this->data['model']->find_data('sms_function', 'array',['published' => 1]);
        // pr($data['functions']);
        $data['row'] = [];
        if(isset($userId)){
            if($this->request->getPost()){
                $postData = [
                                'parent_id'                      => $this->request->getPost('parent_id'),
                                'module_name'                    => strtoupper($this->request->getPost('module_name'))
                            ];
                $module_id = $this->common_model->save_data('sms_modules', $postData, '', 'id');
                /* function manage */
                    $function_name = $this->request->getPost('function_name');
                    if(count($function_name)>0){
                        for($f=0;$f<count($function_name);$f++){
                            if($function_name[$f] != ''){
                                $postData2 = [
                                          'module_id'             => $module_id,
                                          'function_name'         => $function_name[$f]
                                        ];
                                $this->common_model->save_data('sms_module_functions', $postData2, '', 'function_id');
                            }
                        }
                    }
                /* function manage */
                $this->session->setFlashdata('success_message', 'Module & Functions Created Successfully !!!');
                return redirect()->to(base_url('admin/manage_modulelist'));
            }
            $data['row']            = [];
            $data['action']         = 'Add';
            $data['session']        = $this->session; 
            $data['modules']        = $this->common_model->find_data('sms_modules', 'array', ['published' => 1, 'parent_id' => 0]);
            $data['functions']      = [];
        } else {
            return redirect()->to(base_url('/'));
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function edit($id)
    {
        $session = \Config\Services::session();
        $userId                  = $session->get('user_id');
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['module'];
        $page_name                  = 'modulelist/add-edit';
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        $data['allfunctions']       = $this->data['model']->find_data('sms_function', 'array',['published' => 1]);

        if(isset($userId)){
            $data['common_model'] = $this->common_model;
            $data['session']      = $this->session;
            $data['row']          = $this->common_model->find_data('sms_modules', 'row', ['id' => $id]);
            $data['modules']      = $this->common_model->find_data('sms_modules', 'array', ['published' => 1, 'parent_id' => 0]);
            $data['functions']    = $this->common_model->find_data('sms_module_functions', 'array', ['published' => 1, 'module_id' => $id]);
            $data['action']       = 'Update';
            if($this->request->getPost()){
                $postData = [
                          'parent_id'                      => $this->request->getPost('parent_id'),
                          'module_name'                    => strtoupper($this->request->getPost('module_name')),
                          'updated_at'                     => date('Y-m-d H:i:s')
                        ];
                $module_id = $this->common_model->save_data('sms_modules', $postData, $id, 'id');
                /* function manage */
                    $function_name = $this->request->getPost('function_name');
                    if(count($function_name)>0){
                        for($f=0;$f<count($function_name);$f++){
                            if($function_name[$f] != ''){
                                $postData2 = [
                                          'module_id'                      => $id,
                                          'function_name'                  => $function_name[$f]
                                        ];
                                $this->common_model->save_data('sms_module_functions', $postData2, '', 'function_id');
                            }
                        }
                    }
                /* function manage */
                $this->session->setFlashdata('success_message', 'Module & Functions Updated Successfully !!!');
                return redirect()->to(base_url('admin/manage_modulelist'));
            }
        } else {
            return redirect()->to(base_url('/'));
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function view($id){
        $this->common_model     = new CommonModel();
        $session = \Config\Services::session();
        $userId                 = $this->session->get('user_id');
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'View';
        $title                      = $data['action'].' '.$this->data['module'];
        $page_name                  = 'modulelist/view';
        $this->session          = \Config\Services::session();        
        if(isset($userId)){
            $data['common_model'] = $this->common_model;
                $data['session']      = $this->session;
                $data['row']          = $this->common_model->find_data('sms_modules', 'row', ['id' => $id]);
            } else {
                return redirect()->to(base_url('/'));
            }
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
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['module'].' deactivated successfully');
        return redirect()->to('/admin/'.$this->data['controller']);
    }
    public function active($id)
    {
        $postData = array(
                            'published' => 1
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['module'].' activated successfully');
        return redirect()->to('/admin/'.$this->data['controller']);
    }
}