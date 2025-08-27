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
        $page_name                  = 'screenshot_settings/add-edit';
        $conditions                 = array($this->data['primary_key'] => $id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);

        if ($this->request->getMethod() == 'post') {

            //  rules for form-data validation
            $rules = [
                'screenshot_resolution' => 'required|max_length[255]|regex_match[/^\d{2,5}x\d{2,5}$/]',
                'idle_time'             => 'required|is_natural_no_zero',
                'screenshot_time'       => 'required|is_natural_no_zero', // assuming it's a time interval in seconds
            ];

            if (! $this->validate($rules)) {
                $errors = $this->validator->getErrors();
                $errorMessage =  implode(', ', $errors);
                $this->session->setFlashdata('error_message', $errorMessage);

                return redirect()->to('/admin/' . $this->data['controller_route']);
            }

            $postData   = array(
                'screenshot_resolution'             => $this->request->getPost('screenshot_resolution'),
                'idle_time'       => $this->request->getPost('idle_time'),
                'screenshot_time'       => $this->request->getPost('screenshot_time')
            );

            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'] . ' updated successfully');
            return redirect()->to('/admin/' . $this->data['controller_route']);
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }



    public function screenshotList($userId)
    {
        $id                         = decoded($userId);
        $title                      = 'Screenshot List';
        $page_name                  = 'screenshot_settings/user_screen_list';
        $data['start_date']         = $data['end_date'] = date('Y-m-d');
        $conditions                 = array('id' => $id);
        $data['user']               = $this->data['model']->find_data('user', 'row', $conditions);
        $data['row']                = [];

        if ($this->request->getGet('mode') === 'search') {
            $data['start_date'] = $this->request->getGet('start') ?? $data['start_date'];
            $data['end_date']   = $this->request->getGet('end') ?? $data['end_date'];
        }

        try {
            $builder = $this->data['model']->builder('user_screenshots');

            $builder->where('user_id', $id)
                // ->where('idle_status', 1)
                ->where('DATE(time_stamp) >=', $data['start_date'])
                ->where('DATE(time_stamp) <=', $data['end_date'])
                ->orderBy('time_stamp', 'DESC');

            $data['row'] = $builder->get()->getResultArray();
        } catch (\Exception $error) {
            log('error', 'Error fetching user screenshots: ' . $error->getMessage());
            $this->session->setFlashdata('error_message', 'Error fetching user screenshots');
        }

        echo $this->layout_after_login($title, $page_name, $data);
    }
}
