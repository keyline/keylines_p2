<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use CodeIgniter\CLI\Console;

class HolidayController extends BaseController
{
    private $model;  //This can be accessed by all class methods
    public function __construct()
    {
        $session = \Config\Services::session();
        if (!$session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }
        $model = new CommonModel();
        $this->data = array(
            'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Holiday',
            'controller_route'      => 'holiday-list',
            'controller'            => 'HolidayController',
            'table_name'            => 'event',
            'primary_key'           => 'id'
        );
 
    }

    public function fetchHolidays()
    {
        if(!$this->common_model->checkModuleFunctionAccess(37, 95)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'holiday-list';
        $data['events']             = $this->data['model']->find_data('event', 'array', ['status!=' => '3'], '', '');                 
        
        if($this->request->getMethod() == 'post') {
            //  pr($this->request->getPost());
            $postdata = array(
                'title'             => $this->request->getPost('title'),
                'start_event'       => $this->request->getPost('start_event'),
                'end_event'         => $this->request->getPost('end_event'),
                'color_code_bc'     => $this->request->getPost('color_code_bc'),
                'color_code_fc'     => $this->request->getPost('color_code_fc'),
            );
            // pr($postdata);
            $record     = $this->data['model']->save_data($this->data['table_name'], $postdata, '', $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to(current_url());
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function Holidaylistapi()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'holiday-list';
        $data['events']             = $this->data['model']->find_data('event', 'array', ['status!=' => '3'], '', ''); 
        $events = [];        

        foreach ($data['events'] as $holiday) {     
            // pr($holiday);       
            $events[] = [   
                'id'    =>$holiday->id ,     
                'title' => $holiday->title,
                'start' => $holiday->start_event,            
                'backgroundColor' => $holiday->color_code_bc,           
                'textColor' => $holiday->color_code_fc,           
            ];
        }
                // pr($events) ;
        // echo $this->layout_after_login($title, $page_name, $data);
            return $this->response->setJSON($events);
         
    }

    public function Weekofflistapi()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'holiday-list';
        $data['weekoff']            = $this->data['model']->find_data('application_settings', 'row', '', 'sunday,monday,tuesday,wednesday,thursday,friday,satarday', ''); 
        $weekoff = [];        
        // pr($data['weekoff']);
        // foreach ($data['weekoff'] as $holiday) {  
            // pr($holiday);          
            $weekoff[] = [   
                'sunday'        => $data['weekoff']->sunday ,     
                'monday'        => $data['weekoff']->monday,
                'tuesday'       => $data['weekoff']->tuesday,            
                'wednesday'     => $data['weekoff']->wednesday,           
                'thursday'      => $data['weekoff']->thursday,           
                'friday'        => $data['weekoff']->friday,           
                'satarday'      => $data['weekoff']->satarday,           
            ];
        // }
                // pr($weekoff) ;
        // echo $this->layout_after_login($title, $page_name, $data);
            return $this->response->setJSON($weekoff);
         
    }

    public function addHoliday()
    {
        if(!$this->common_model->checkModuleFunctionAccess(37, 96)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'holiday-list';

        if($this->request->getMethod() == 'post') {
            //  pr($this->request->getPost());
            $postdata = array(
                'title'         => $this->request->getPost('title'),
                'start_event'    => $this->request->getPost('start_event'),
                'end_event'      => $this->request->getPost('end_event'),
                'color_code_bc'   => $this->request->getPost('color_code_bc'),
                'color_code_fc'   => $this->request->getPost('color_code_fc'),
            );
            //  pr($postdata);
            $record     = $this->data['model']->save_data($this->data['table_name'], $postdata, '', $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return $this->response->setJSON(['status' => 'success']);                   
        }
        echo $this->layout_after_login($title,$page_name,$data);                
    }

    public function editHoliday($id)
    {
        if(!$this->common_model->checkModuleFunctionAccess(37, 119)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $id                         = $id;
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'holiday-list';  
        if($this->request->getMethod() == 'post') { 
            //  pr($this->request->getPost());
            $postdata = array(
                'title'         => $this->request->getPost('title'),
                'start_event'    => $this->request->getPost('start_event'),
                'end_event'      => $this->request->getPost('end_event'),
                'color_code_bc'   => $this->request->getPost('color_code_bc'),
                'color_code_fc'   => $this->request->getPost('color_code_fc'),
                'updated_at'            => date('Y-m-d H:i:s'),
            );     
            // pr($postdata);
            $record     = $this->data['model']->save_data($this->data['table_name'], $postdata, $id, $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            return $this->response->setJSON(['status' => 'success']);      
        }
        echo $this->layout_after_login($title,$page_name,$data);    
    } 

    public function confirm_delete($id)
    {
        if(!$this->common_model->checkModuleFunctionAccess(37, 120)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $id                         = decoded($id);
        $postData = array(
                            'status' => 3
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller_route']);
    }
           
}
