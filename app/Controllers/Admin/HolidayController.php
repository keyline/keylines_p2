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
            'controller_route'      => 'holiday',
            'controller'            => 'HolidayController',
            'table_name'            => 'event',
            'primary_key'           => 'id'
        );
    }

    public function holiday()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'holiday-list';
        $data['events']             = $this->data['model']->find_data('event', 'array', '', '', '');   
        echo $this->layout_after_login($title, $page_name, $data);
    }
           
}
