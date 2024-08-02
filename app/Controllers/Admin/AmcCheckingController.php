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
        $data['amc_setting']        = $this->data['model']->find_data('setting', 'array', ['id' => 1], '', '', '', '');        
        $sql                        = "SELECT project.*,tab1.id amc_chkid, tab1.last_amcdate chk_date FROM project left JOIN 
                                        ( SELECT id,project_id,user_id,comment,status,max(date) last_amcdate FROM `amc_check` group by project_id) tab1 
                                        on project.id = tab1.project_id where project.status IN ('9', '4') and  project.deadline >= '$currentdate' order by DATE(tab1.last_amcdate)";
        $data['rows']        = $this->db->query($sql)->getResult();        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'client/add-edit';        
        $data['row']                = [];
        $order_by[0]                = array('field' => 'name', 'type' => 'ASC');
        $data['countries']          = $this->common_model->find_data('countries', 'array', '', 'name', '', '', $order_by);
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status' => '1'], 'id,name', '', '', $order_by);

        if($this->request->getMethod() == 'post') {
            $postData   = array(
                'name'                  => $this->request->getPost('name'),
                'compnay'               => $this->request->getPost('compnay'),
                'address_1'             => $this->request->getPost('address_1'),
                'state'                 => $this->request->getPost('state'),
                'city'                  => $this->request->getPost('city'),
                'country'               => $this->request->getPost('country'),
                'pin'                   => $this->request->getPost('pin'),
                'address_2'             => $this->request->getPost('address_2'),
                'email_1'               => $this->request->getPost('email_1'),
                'email_2'               => $this->request->getPost('email_2'),
                'phone_1'               => $this->request->getPost('phone_1'),
                'phone_2'               => $this->request->getPost('phone_2'),
                'dob_day'               => $this->request->getPost('dob_day'),
                'dob_month'             => $this->request->getPost('dob_month'),
                'dob_year'              => $this->request->getPost('dob_year'),
                'password_md5'          => md5($this->request->getPost('password')),
                'password_org'          => $this->request->getPost('password'),
                'comment'               => $this->request->getPost('comment'),
                'reference'             => $this->request->getPost('reference'),
                'login_access'          => $this->request->getPost('login_access'),
                'client_of'             => $this->request->getPost('client_of'),
                'entried_by'            => $this->session->get('user_id'),
                'added_date'            => date('Y-m-d H:i:s'),
                'last_login'            => date('Y-m-d H:i:s'),
            );
            // pr($postData);
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);            
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function ok_status($id)
    {
        $id                         = decoded($id);
        $user_id                    = $this->session->get('user_id');
        $data['amc_setting']        = $this->data['model']->find_data('setting', 'row', ['id' => 1], '', '', '', ''); 
        //  pr($data['amc_setting']);
        $time = $data['amc_setting']->amc_check_min;
        $check_description = $data['amc_setting']->check_description;
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        $date_on = date('Y-m-d H:i:s');

        // pr($data['row']);        
        $postData = array(
                            'project_id' => $id,
                            'user_id' => $user_id,
                            'comment' => '',
                            'status' => '0',
                            'date' => $date_on
                        );
        // pr($postData);
        $insertData = $this->common_model->save_data('amc_check',$postData,'',$this->data['primary_key']);
        $this->session->setFlashdata('success_message', ' AMC Site is Checked Successfully');
        return redirect()->to('/admin/'.$this->data['controller_route']);
    }
    public function confirm_delete($id)
    {
        $id                         = decoded($id);
        $updateData = $this->common_model->delete_data($this->data['table_name'],$id,$this->data['primary_key']);
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
}