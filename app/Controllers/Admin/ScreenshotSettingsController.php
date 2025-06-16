<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;

class ScreenshotSettingsController extends BaseController
{
    protected $data;

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
            'title'                 => 'Screenshot Settings',
            'controller_route'      => 'screenshot-settings',
            'controller'            => 'ScreenshotSettingsController',
            'table_name'            => 'screenshot_settings',
            'primary_key'           => 'id'
        );
    }

    public function index()
    {
       
        $id                         = 1;
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'] . ' ' . $this->data['title'];
        $page_name                  = 'notification_settings/add-edit';
        $conditions                 = array($this->data['primary_key'] => $id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
      
        if ($this->request->getMethod() == 'post') {
            $users      = [];
            $user_type  = $this->request->getPost('user_type');
            $getUsers   = $this->common_model->find_data('ecomm_users', 'array', ['status!=' => 3, 'type' => $user_type], 'id');
            if ($getUsers) {
                foreach ($getUsers as $getUser) {
                    $users[]      = $getUser->id;
                }
            }
            $postData   = array(
                'title'             => $this->request->getPost('title'),
                'description'       => $this->request->getPost('description'),
                'user_type'         => $user_type,
                'users'             => json_encode($users),
            );
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'] . ' updated successfully');
            return redirect()->to('/admin/' . $this->data['controller_route'] . '/list');
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
}
