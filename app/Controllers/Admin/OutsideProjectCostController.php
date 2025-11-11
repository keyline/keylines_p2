<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Libraries\Pro;
class OutsideProjectCostController extends BaseController {

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
            'title'                 => 'Outside Project Cost',
            'controller_route'      => 'outside_project_cost',
            'controller'            => 'OutsideProjectCostController',
            'table_name'            => 'outsource_payment',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        if (!$this->common_model->checkModuleFunctionAccess(34, 91)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'outside_project/project_name';
        $data['fetch_project_id']  = '';
        $date_on                    = date('Y-m-d H:i:s');  
        $user_id                    = $this->session->get('user_id');
        $order_by[0]                = array('field' => 'project.name', 'type' => 'ASC');
        $join[0]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
        $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
        $data['projects']           = $this->data['model']->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);

        $data['is_search'] = 0;
        if ($this->request->getGet('mode') == 'outside_project_cost') {
            $project_id = $this->request->getGet('project_id');
            $sql                        = "SELECT outsource_payment.*, project.name FROM `outsource_payment`
                                                INNER JOIN project on outsource_payment.project_id = project.id 
                                                WHERE outsource_payment.project_id = $project_id
                                                ORDER BY `outsource_payment`.`id` DESC";
            $data['payment_details']    = $this->db->query($sql)->getResult();
            $data['fetch_project_id'] = $project_id;
            $data['is_search'] = 1;
        }
        if ($this->request->getPost('mode') == 'outside_project_cost_add') {
            $project_id = $this->request->getPost('project_id');
            $fields = [
                'project_id'    => $project_id,
                'amount'        => $this->request->getPost('amount'),
                'payment_date'  => date_format(date_create($this->request->getPost('payment_date')), "Y-m-d"),
                'comment'       => $this->request->getPost('comment'),
                'date_added'    => date('Y-m-d H:i:s'),
            ];
            $this->data['model']->save_data('outsource_payment',$fields, '', 'id');
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to(current_url().'?mode=outside_project_cost&project_id=' . $project_id);
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }  
    public function showexsisting($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'List';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'outside_project/showexsisting';        
        
        echo  $sql                        = "SELECT outsource_payment.*, project.name FROM `outsource_payment`
        INNER JOIN project on outsource_payment.project_id = project.id 
        WHERE outsource_payment.project_id = $id
        ORDER BY `outsource_payment`.`id` DESC";
        $data['payment_details']    = $this->db->query($sql)->getResult();  
        pr($data['payment_details']);

        // if($this->request->getMethod() == 'post') {     
        //        pr($this->request->getPost());      
        //     $project_id         = $this->request->getPost('project_id');
        //     $payment_date               = $this->request->getPost('date');
        //     $comment            = $this->request->getPost('comment');
        //     $amount            = $this->request->getPost('amount');     
            
            
           

        //     $postData = array(
        //         'project_id'        => $project_id,
        //         'payment_date'      => $payment_date,
        //         'comment'           => $comment,
        //         'amount'            => $amount,
        //         'date_added'        => $date_on
        //     );    
            
            $insertData = $this->common_model->save_data('outsource_payment',$postData,'',$this->data['primary_key']);            
            $this->session->setFlashdata('success_message', ' Out Source Payment Information is added Successfully');
            return redirect()->to('/admin/'.$this->data['controller_route']);
            
            
                  
        echo $this->layout_after_login($title,$page_name,$data);
    }   
}