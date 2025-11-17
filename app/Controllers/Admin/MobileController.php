<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use CodeIgniter\CLI\Console;

class MobileController extends BaseController
{
    private $model;  //This can be accessed by all class methods
    public function __construct()
    {
        $session = \Config\Services::session();
        if (!$session->get('is_admin_login')) {
            header('Location: ' . base_url('/'));
            // return redirect()->to('/Administrator');
            exit;
        }
        $model = new CommonModel();
        $this->data = array(
            'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Mobile application',
            'controller_route'      => 'mobile-application',
            'controller'            => 'MobileController',
            'table_name'            => '',
            'primary_key'           => ''
        );
 
    }

    public function show()
    {
        if(!$this->common_model->checkModuleFunctionAccess(40, 104)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'mobile-application';
        
        // $data['events']             = $this->data['model']->find_data('event', 'array', ['status!=' => '3'], '', '');                 
    
            //  pr($data['events']) ;
        echo $this->layout_after_login($title, $page_name, $data);
        //  return $this->response->setJSON($data['events']);
         
    }
           
}
