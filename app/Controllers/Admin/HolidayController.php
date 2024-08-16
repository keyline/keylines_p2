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
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'holiday-list';
        $data['events']             = $this->data['model']->find_data('event', 'array', ['status!=' => '3'], '', '');                 
    
            // pr($events) ;
        echo $this->layout_after_login($title, $page_name, $data);
        //  return $this->response->setJSON($data['events']);
         
    }

    public function Holidaylistapi()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'holiday-list';
        $data['events']             = $this->data['model']->find_data('event', 'array', ['status!=' => '3'], '', ''); 
        $events = [];

        foreach ($data['events'] as $holiday) {
            $events[] = [   
                'id'    =>$holiday->id ,     
                'title' => $holiday->title,
                'start' => $holiday->start_event,            
                'color' => $holiday->color_code,           
            ];
        }
            //  pr($events) ;
        // echo $this->layout_after_login($title, $page_name, $data);
          return $this->response->setJSON($events);
         
    }

    public function addHoliday()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'holiday-list';

        if($this->request->getMethod() == 'post') { 
            //  pr($this->request->getPost());
            $postdata = array(
                'title'         => $this->request->getPost('title'),
                'start_event'    => $this->request->getPost('start_event'),
                'end_event'      => $this->request->getPost('end_event'),
                'color_code'   => $this->request->getPost('color_code'),
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
                'color_code'   => $this->request->getPost('color_code'),
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
        $id                         = decoded($id);
        $postData = array(
                            'status' => 3
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller_route']);
    }
           
}
