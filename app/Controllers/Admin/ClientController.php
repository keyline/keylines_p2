<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Libraries\Pro;

class ClientController extends BaseController
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
            'title'                 => 'Clients',
            'controller_route'      => 'clients',
            'controller'            => 'ClientController',
            'table_name'            => 'client',
            'primary_key'           => 'id'
        );
    }
    public function listClients()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'client/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', '', 'id,name,compnay,address_1,state,city,country,pin,address_2,email_1,email_2,phone_1,phone_2,reference,added_date,last_login,login_access,encoded_email,encoded_phone', '', '', $order_by);
        // pr($data['rows']);
        // $data['rows']               = $this->data['model']->find_data('project', 'count', '', '', '', '', '');
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'] . ' ' . $this->data['title'];
        $page_name                  = 'client/add-edit';
        $data['row']                = [];
        $order_by[0]                = array('field' => 'name', 'type' => 'ASC');
        $data['countries']          = $this->common_model->find_data('countries', 'array', '', 'name', '', '', $order_by);
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status' => '1'], 'id,name', '', '', $order_by);

        if ($this->request->getMethod() == 'post') {
            $postData   = array(
                'name'                  => $this->pro->encrypt($this->request->getPost('name')),
                'compnay'               => $this->pro->encrypt($this->request->getPost('compnay')),
                'address_1'             => $this->request->getPost('address_1'),
                'state'                 => $this->request->getPost('state'),
                'city'                  => $this->request->getPost('city'),
                'country'               => $this->request->getPost('country'),
                'pin'                   => $this->request->getPost('pin'),
                'address_2'             => $this->request->getPost('address_2'),
                'email_1'               => $this->pro->encrypt($this->request->getPost('email_1')),
                'email_2'               => $this->pro->encrypt($this->request->getPost('email_2')),
                'phone_1'               => $this->pro->encrypt($this->request->getPost('phone_1')),
                'phone_2'               => $this->pro->encrypt($this->request->getPost('phone_2')),
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
            $this->session->setFlashdata('success_message', $this->data['title'] . ' inserted successfully');
            return redirect()->to('/admin/' . $this->data['controller_route'] . '/list');
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function edit($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'] . ' ' . $this->data['title'];
        $page_name                  = 'client/add-edit';
        $conditions                 = array($this->data['primary_key'] => $id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        pr($data['row']);
        $order_by[0]                = array('field' => 'name', 'type' => 'ASC');
        $data['countries']          = $this->common_model->find_data('countries', 'array', '', 'name', '', '', $order_by);
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status' => '1'], 'id,name', '', '', $order_by);

        if ($this->request->getMethod() == 'post') {
            // pr($this->request->getPost());
            $password = $this->request->getPost('password');
            // if (!empty($password)) {
            //    $newPassword = $password;
            // }
            // else{
            //     $newPassword = md5($this->request->getPost('password'));
            // }

            if ($this->request->getPost('password') != '') {
                $postData   = array(
                    'name'                  => $this->pro->encrypt($this->request->getPost('name')),
                    'compnay'               => $this->pro->encrypt($this->request->getPost('compnay')),
                    'address_1'             => $this->request->getPost('address_1'),
                    'state'                 => $this->request->getPost('state'),
                    'city'                  => $this->request->getPost('city'),
                    'country'               => $this->request->getPost('country'),
                    'pin'                   => $this->request->getPost('pin'),
                    'address_2'             => $this->request->getPost('address_2'),
                    'email_1'               => $this->pro->encrypt($this->request->getPost('email_1')),
                    'email_2'               => $this->pro->encrypt($this->request->getPost('email_2')),
                    'phone_1'               => $this->pro->encrypt($this->request->getPost('phone_1')),
                    'phone_2'               => $this->pro->encrypt($this->request->getPost('phone_2')),
                    'dob_day'               => $this->request->getPost('dob_day'),
                    'dob_month'             => $this->request->getPost('dob_month'),
                    'dob_year'              => $this->request->getPost('dob_year'),
                    'password_md5'          => md5($this->request->getPost('password')),
                    'password_org'          => $this->request->getPost('password'),
                    'comment'               => $this->request->getPost('comment'),
                    'reference'             => $this->request->getPost('reference'),
                    'login_access'          => $this->request->getPost('login_access'),
                    'client_of'             => $this->request->getPost('client_of'),
                );
            } else {
                $postData   = array(
                    'name'                  => $this->pro->encrypt($this->request->getPost('name')),
                    'compnay'               => $this->pro->encrypt($this->request->getPost('compnay')),
                    'address_1'             => $this->request->getPost('address_1'),
                    'state'                 => $this->request->getPost('state'),
                    'city'                  => $this->request->getPost('city'),
                    'country'               => $this->request->getPost('country'),
                    'pin'                   => $this->request->getPost('pin'),
                    'address_2'             => $this->request->getPost('address_2'),
                    'email_1'               => $this->pro->encrypt($this->request->getPost('email_1')),
                    'email_2'               => $this->pro->encrypt($this->request->getPost('email_2')),
                    'phone_1'               => $this->pro->encrypt($this->request->getPost('phone_1')),
                    'phone_2'               => $this->pro->encrypt($this->request->getPost('phone_2')),
                    'dob_day'               => $this->request->getPost('dob_day'),
                    'dob_month'             => $this->request->getPost('dob_month'),
                    'dob_year'              => $this->request->getPost('dob_year'),
                    'password_org'          => $this->request->getPost('password'),
                    'comment'               => $this->request->getPost('comment'),
                    'reference'             => $this->request->getPost('reference'),
                    'login_access'          => $this->request->getPost('login_access'),
                    'client_of'             => $this->request->getPost('client_of'),
                );
            }
            //   pr($postData);
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'] . ' updated successfully');
            return redirect()->to('/admin/' . $this->data['controller_route'] . '/list');
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function confirm_delete($id)
    {
        $id                         = decoded($id);
        $updateData = $this->common_model->delete_data($this->data['table_name'], $id, $this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'] . ' deleted successfully');
        return redirect()->to('/admin/' . $this->data['controller_route'] . '/list');
    }
    public function change_status($id)
    {
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key'] => $id]);
        if ($data['row']->status) {
            $status  = 0;
            $msg        = 'Deactivated';
        } else {
            $status  = 1;
            $msg        = 'Activated';
        }
        $postData = array(
            'status' => $status
        );
        $updateData = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'] . ' ' . $msg . ' successfully');
        return redirect()->to('/admin/' . $this->data['controller_route'] . '/list');
    }
    public function addProposal($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $title                      = 'Add Document';
        $page_name                  = 'client/add-proposal';
        $userId                     = $this->session->get('user_id');
        $data['row']                = [];
        // $data['row']                = $this->data['model']->find_data('client_proposal', 'row', ['client_id' => $id]);
        if ($this->request->getMethod() == 'post') {
            if ($this->request->getFileMultiple('proposal_file')) {
                $files  = $this->request->getFileMultiple('proposal_file');
                $data   = [];
                $date = date('Y-m-d');
                $timestamp = time();
                foreach ($files as $index => $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $originalName   = $file->getClientName();
                        $extension      = $file->getClientExtension();
                        $newName        = "{$date}_{$timestamp}_{$index}---" . str_replace(' ', '-', pathinfo($originalName, PATHINFO_FILENAME)) . ".{$extension}";
                        $file->move('public/uploads/proposal/', $newName);
                        $data[] = [
                            'filename'  => $newName,
                            'filepath'  => 'uploads/proposal/' . $newName,
                            'type'      => $extension
                        ];
                    }
                }
                if (!empty($data)) {
                    $postData0 = [
                        'client_id'         => $id,
                        'project_id'        => 0,
                        'title'             => $this->request->getPost('proposal_title'),
                        'description'       => $this->request->getPost('proposal_description')
                    ];
                    $lastInsertID        = $this->data['model']->save_data('client_proposal', $postData0, '', 'id');
                    for ($i = 0; $i < count($data); $i++) {
                        $postData = [
                            'client_id'   => $id,
                            'project_id'  => 0,
                            'proposal_id' => $lastInsertID,
                            'file'        => $data[$i]['filename'],
                            'uploaded_by' => $userId
                        ];
                        $record = $this->data['model']->save_data('proposal_files', $postData, '', 'id');
                    }
                }
            }
            $this->session->setFlashdata('success_message', 'Proposal' . ' added successfully');
            return redirect()->to('/admin/' . $this->data['controller_route'] . '/list');
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function viewProposal($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $title                      = 'View Document';
        $page_name                  = 'client/view-proposal';
        $data['rows']               = $this->data['model']->find_data('proposal_files', 'array', ['client_id' => $id], '', '', '', '');
        $userId                     = $this->session->get('user_id');
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function editProposal($id)
    {
        $id                         = base64_decode($id);
        $data['moduleDetail']       = $this->data;
        $title                      = 'Edit Document';
        $page_name                  = 'client/edit-proposal';
        $userId                     = $this->session->get('user_id');
        $data['row']                = $this->data['model']->find_data('proposal_files', 'row', ['id' => $id], '', '', '', '');
        $data['proposal']           = $this->data['model']->find_data('client_proposal', 'row', ['id' => $data['row']->proposal_id], '', '', '', '');
        if ($this->request->getMethod() == 'post') {
            $p_file                 = $this->data['model']->find_data('proposal_files', 'row', ['id' => $id], '', '', '', '');
            $p_id                   = $this->data['model']->find_data('client_proposal', 'row', ['id' => $data['proposal']->id], '', '', '', '');
            $postData0 = [
                'client_id'         => $p_file->client_id,
                'project_id'        => 0,
                'title'             => $this->request->getPost('proposal_title'),
                'description'       => $this->request->getPost('proposal_description')
            ];
            $lastInsertID       = $this->data['model']->save_data('client_proposal', $postData0, $p_file->proposal_id, 'id');
            if ($this->request->getFileMultiple('proposal_file')) {
                $file_pointer   = "public/uploads/proposal/" . $p_file->file;
                unlink($file_pointer);
                $files          = $this->request->getFileMultiple('proposal_file');
                $data           = [];
                $date           = date('Y-m-d');
                $timestamp = time();
                foreach ($files as $index => $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $originalName   = $file->getClientName();
                        $extension      = $file->getClientExtension();
                        $newName        = "{$date}_{$timestamp}_{$index}---" . str_replace(' ', '-', pathinfo($originalName, PATHINFO_FILENAME)) . ".{$extension}";
                        $file->move('public/uploads/proposal/', $newName);
                        $data[] = [
                            'filename'  => $newName,
                            'filepath'  => 'uploads/proposal/' . $newName,
                            'type'      => $extension
                        ];
                    }
                }
                if (!empty($data)) {
                    for ($i = 0; $i < count($data); $i++) {
                        $postData = [
                            'client_id'   => $p_file->client_id,
                            'project_id'  => 0,
                            'proposal_id' => $p_id->id,
                            'file'        => $data[$i]['filename'],
                            'uploaded_by' => $userId
                        ];
                        $record = $this->data['model']->save_data('proposal_files', $postData, $id, 'id');
                    }
                }
            }
            $this->session->setFlashdata('success_message', 'Proposal' . ' updated successfully');
            return redirect()->to('/admin/clients/' . 'view-proposal' . '/' . base64_encode($p_file->client_id));
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function deleteProposal($id)
    {
        $id             = decoded($id);
        $p_file         = $this->data['model']->find_data('proposal_files', 'row', ['id' => $id], '', '', '', '');
        $file_pointer   = "public/uploads/proposal/" . $p_file->file;
        unlink($file_pointer);
        $p_id           = $this->data['model']->find_data('proposal_files', 'row', ['id' => $id], '', '', '', '');
        // $clientID       = $p_id->client_id;
        $updateData     = $this->common_model->delete_data('proposal_files', $id, $this->data['primary_key']);
        $this->session->setFlashdata('success_message', 'Proposal' . ' deleted successfully');
        return redirect()->to('/admin/' . $this->data['controller_route'] . '/list');
    }
    public function addProject($id)
    {
        $id                         = base64_decode($id);
        $data['moduleDetail']       = $this->data;
        $title                      = 'Add Project';
        $page_name                  = 'client/add-project';
        $data['clientDetail']       = $this->data['model']->find_data('client', 'row', ['id' => $id], '', '', '', '');
        $order_by[0]                = array('field' => 'name', 'type' => 'ASC');
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status' => '1'], 'id,name', '', '', $order_by);
        $data['projectStats']       = $this->data['model']->find_data('project_status', 'array', ['status' => 1], 'id,name', '', '', $order_by);
        $data['clients']            = $this->data['model']->find_data('client', 'array', '', 'id,name,compnay', '', '', $order_by);
        $data['projects']           = $this->data['model']->find_data('project', 'array', '', 'id,name', '', '', $order_by);
        if ($this->request->getMethod() == 'post') {
            // pr($this->request->getPost());
            $project_status = $this->request->getPost('status');
            $postData   = array(
                'name'                  => $this->request->getPost('project_name'),
                'description'           => $this->request->getPost('project_description'),
                'assigned_by'           => $this->request->getPost('assigned_by'),
                'status'                => $this->request->getPost('status'),
                'type'                  => $this->request->getPost('type'),
                'client_id'             => $this->request->getPost('client_id'),
                'project_time_type'     => $this->request->getPost('project_time_type'),
                'hour'                  => (($this->request->getPost('hour') != '') ? $this->request->getPost('hour') : NULL),
                'hour_month'            => (($this->request->getPost('hour_month') != '') ? $this->request->getPost('hour_month') : NULL),
                'start_date'            => date_format(date_create($this->request->getPost('start_date')), "Y-m-d"),
                'deadline'              => date_format(date_create($this->request->getPost('deadline')), "Y-m-d"),
                'temporary_url'         => $this->request->getPost('temporary_url'),
                'permanent_url'         => $this->request->getPost('permanent_url'),
                'parent'                => $this->request->getPost('parent'),
                'client_service'        => $this->request->getPost('client_service'),
                'bill'                  => $this->request->getPost('bill'),
                'active'                => ($project_status != 13) ? 0 : 1,
                'date_added'            => date('Y-m-d H:i:s'),
                'date_modified'         => date('Y-m-d H:i:s'),
            );
            // pr($postData);
            $record     = $this->data['model']->save_data('project', $postData, '', $this->data['primary_key']);
            $this->session->setFlashdata('success_message', 'Project' . ' inserted successfully');
            return redirect()->to('/admin/' . $this->data['controller_route'] . '/list');
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function encryptInfo(){
        $this->pro           = new Pro();
        $clients               = $this->data['model']->find_data($this->data['table_name'], 'array');
        if($clients){
            foreach($clients as $client){
                $id             = $client->id;
                $name           = $client->name;
                $compnay        = $client->compnay;
                $email_1        = $client->email_1;
                $email_2        = $client->email_2;
                $phone_1        = $client->phone_1;
                $phone_2        = $client->phone_2;

                $encryptedName      = $this->pro->encrypt($name);
                $encryptedCompany   = $this->pro->encrypt($compnay);
                $encryptedEmail1    = $this->pro->encrypt($email_1);
                $encryptedEmail2    = $this->pro->encrypt($email_2);
                $encryptedPhone1    = $this->pro->encrypt($phone_1);
                $encryptedPhone2    = $this->pro->encrypt($phone_2);
                $fields             = [
                    'name'      => $encryptedName,
                    'compnay'   => $encryptedCompany,
                    'email_1'   => $encryptedEmail1,
                    'email_2'   => $encryptedEmail2,
                    'phone_1'   => $encryptedPhone1,
                    'phone_2'   => $encryptedPhone2,
                ];
                $this->data['model']->save_data($this->data['table_name'], $fields, $id, 'id');
            }
        }
        $this->session->setFlashdata('success_message', $this->data['title'] . ' name, company name, email 1, email 2, phone 1, phone 2 encrypted successfully');
        return redirect()->to('/admin/' . $this->data['controller_route'] . '/list');
    }
}