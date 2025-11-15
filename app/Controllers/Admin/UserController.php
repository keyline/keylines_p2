<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class UserController extends BaseController {
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
            'title'                 => 'User',
            'controller_route'      => 'users',
            'controller'            => 'UserController',
            'table_name'            => 'user',
            'primary_key'           => 'id'
        );
    }
    public function list()
{
     if (!$this->common_model->checkModuleFunctionAccess(4, 20)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }


        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'user/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $userType                   = $this->session->user_type;
        // pr($userType);
        if ($userType == "SUPER ADMIN") {             
        // $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['status' => '1'], 'id,name,email,personal_email,phone1,phone2,status,work_mode,is_tracker_user,is_salarybox_user,attendence_type,type', '', '', $order_by);        
        $sql = "SELECT u.id, u.name, u.email, u.personal_email, u.phone1, u.phone2,
                    u.status, u.work_mode, u.is_tracker_user, u.is_salarybox_user,
                    u.attendence_type, u.type,
                    ss.screenshot_time
                FROM user u
                LEFT JOIN (
                    SELECT user_id, MIN(time_stamp) AS screenshot_time
                    FROM user_screenshots
                    WHERE DATE(time_stamp) = CURDATE()
                    GROUP BY user_id
                ) ss ON u.id = ss.user_id
                WHERE u.status = '1'
                ORDER BY u.id DESC;
                
    ";
        $data['rows'] = $this->db->query($sql)->getResult();              
        //   echo $this->db->getLastquery();die;     
        // pr($data['rows']);     
        } else{            
            // $data['rows']           = $this->data['model']->find_data($this->data['table_name'], 'array', ['status' => '1', 'type!=' => 'SUPER ADMIN'], 'id,name,email,personal_email,phone1,phone2,status,work_mode,is_tracker_user,is_salarybox_user,attendence_type,type', '', '', $order_by);            
            //   echo $this->db->getLastquery();die;            
            $sql = "SELECT u.id, u.name, u.email, u.personal_email, u.phone1, u.phone2,
                    u.status, u.work_mode, u.is_tracker_user, u.is_salarybox_user,
                    u.attendence_type, u.type,
                    ss.screenshot_time
                FROM user u
                LEFT JOIN (
                    SELECT user_id, MIN(time_stamp) AS screenshot_time
                    FROM user_screenshots
                    WHERE DATE(time_stamp) = CURDATE()
                    GROUP BY user_id
                ) ss ON u.id = ss.user_id
                WHERE u.status = '1' and u.type != 'SUPER ADMIN'
                ORDER BY u.id DESC;
     ";
        $data['rows'] = $this->db->query($sql)->getResult();              
        //   echo $this->db->getLastquery();die;     
        // pr($data['rows']);  
        }
        echo $this->layout_after_login($title,$page_name,$data);
}
    public function DeactivateUserlist()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'user/deactivate_user_list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $userType                   = $this->session->user_type;
        // pr($userType);
        if ($userType = "SUPER ADMIN") { 
            $data['rows']           = $this->data['model']->find_data($this->data['table_name'], 'array', ['status' => '0'], 'id,name,email,personal_email,phone1,phone2,status,work_mode,is_tracker_user,is_salarybox_user,attendence_type,type', '', '', $order_by);            
        } else{
            $data['rows']           = $this->data['model']->find_data($this->data['table_name'], 'array', ['status' => '0', 'type!=' => 'SUPER ADMIN'], 'id,name,email,personal_email,phone1,phone2,status,work_mode,is_tracker_user,is_salarybox_user,attendence_type,type', '', '', $order_by);          
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        if (!$this->common_model->checkModuleFunctionAccess(4, 21)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }

        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'user/add-edit';        
        $data['row']                = [];
        $data['userCats']           = $this->data['model']->find_data('user_category', 'array');
        $userType                   = $this->session->user_type;        
        if ($userType == "SUPER ADMIN") { 
        $data['roleMasters']        = $this->data['model']->find_data('permission_roles', 'array', ['published=' => 1]);
        }else{
        $data['roleMasters']        = $this->data['model']->find_data('permission_roles', 'array', ['published=' => 1, 'id!=' => 1]);
        }
        $data['officeLocations']    = $this->data['model']->find_data('office_locations', 'array', ['status=' => 1], 'id,name,address');
        if($this->request->getMethod() == 'post') {
            //  pr($this->request->getPost());
            /* profile image */
                $file = $this->request->getFile('image');
                $originalName = $file->getClientName();
                $fieldName = 'image';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','image');
                    if($upload_array['status']) {
                        $profile_image = $upload_array['newFilename'];
                    } else {
                        $this->session->setFlashdata('error_message', $upload_array['message']);
                        return redirect()->to('/admin/settings');
                    }
                } else {
                    $profile_image = '';
                }
            /* profile image */
            $attendence_type = $this->request->getPost('attendence_type');
            if(!empty($attendence_type)){
                if(in_array(0, $attendence_type)){
                    $attnType = array('0');
                } else {
                    $attnType = $attendence_type;
                }
            } else {
                $attnType = array('0');
            }
            $postData   = array(
                'name'                  => $this->request->getPost('name'),
                'email'                 => $this->request->getPost('email'),
                'personal_email'        => $this->request->getPost('personal_email'),
                'phone1'                => $this->request->getPost('phone1'),
                'phone2'                => $this->request->getPost('phone2'),
                'address'               => $this->request->getPost('address'),
                'pincode'               => $this->request->getPost('pincode'),
                'latitude'              => $this->request->getPost('latitude'),
                'longitude'             => $this->request->getPost('longitude'),
                'password'              => md5($this->request->getPost('password')),
                'type'                  => $this->request->getPost('type'),
                'role_id'               => $this->request->getPost('role_id'),
                'category'              => $this->request->getPost('category'),
                'hour_cost'             => '0',
                'dob'                   => date_format(date_create($this->request->getPost('dob')), "Y-m-d"),
                'doj'                   => date_format(date_create($this->request->getPost('doj')), "Y-m-d"),
                'profile_image'         => $profile_image,
                'status'                => $this->request->getPost('status'),
                // 'work_mode'             => $this->request->getPost('work_mode'),
                'is_tracker_user'       => $this->request->getPost('is_tracker_user'),
                'is_salarybox_user'     => $this->request->getPost('is_salarybox_user'),
                'attendence_type'       => json_encode($attnType),
                'date_added'            => date('Y-m-d H:i:s'),
            );
            //  pr($postData);
            /* credentials sent */
            $generalSetting             = $this->common_model->find_data('general_settings', 'row');
            $subject                    = $generalSetting->site_name.' :: Account Created '.date('Y-m-d H:i:s');
            $mailData                   = [
                'email'     => $this->request->getPost('email'),
                'password'  => $this->request->getPost('password'),
            ];
            $message                    = view('email-templates/signup', $mailData);
            // $this->sendMail($this->request->getPost('email'), $subject, $message);

            // Send the email and get the result
            $mailResult = $this->sendMail($this->request->getPost('email'), $subject, $message);

            // Check if the email was sent successfully
            if (!$mailResult['status']) {
                // Email not sent – show an error and redirect back
                $this->session->setFlashdata('error_message', 'User is not added. Please fix your SMTP setup.');
                // $this->session->setFlashdata('error_message', $mailResult['message']);
                return redirect()->to('/admin/'.$this->data['controller_route'].'/add');
            }  else{
                /* email log save */
                $postData2 = [
                    'name'                  => $this->request->getPost('name'),
                    'email'                 => $this->request->getPost('email'),
                    'subject'               => $subject,
                    'message'               => $message
                ];
                $this->common_model->save_data('email_logs', $postData2, '', 'id');
            /* email log save */
            /* credentials sent */
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
            }                              
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function addBulkFromCSV()
    {
        if (!$this->common_model->checkModuleFunctionAccess(4, 21)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $data['moduleDetail']    = $this->data;
        $data['action']          = 'Add Bulk';
        $title                   = $data['action'].' '.$this->data['title'];
        $page_name               = 'user/add-bulk'; // you can create a separate view for bulk upload
        $data['userCats']        = $this->data['model']->find_data('user_category', 'array');
        
        if ($this->session->user_type == "SUPER ADMIN") {
            $data['roleMasters'] = $this->data['model']->find_data('permission_roles', 'array', ['published=' => 1]);
        } else {
            $data['roleMasters'] = $this->data['model']->find_data('permission_roles', 'array', ['published=' => 1, 'id!=' => 1]);
        }
        
        $data['officeLocations'] = $this->data['model']->find_data('office_locations', 'array', ['status=' => 1], 'id,name,address');

        if ($this->request->getMethod() == 'post') {
            $file = $this->request->getFile('bulkUserCsv');
            
            if ($file && $file->isValid() && $file->getExtension() == 'csv') {
                $filepath = $file->getTempName();
                $csvData  = array_map('str_getcsv', file($filepath));
                
                // Assuming first row is header
                $header = array_map('trim', $csvData[0]);
                unset($csvData[0]);
                
                $insertCount = 0;
                foreach ($csvData as $row) {
                    $rowData = array_combine($header, $row);

                    // Attendance type handling
                    $attnType = !empty($rowData['attendence_type']) ? explode('|', $rowData['attendence_type']) : ['0'];

                    $postData = [
                        'name'              => trim($rowData['name']),
                        'email'             => trim($rowData['email']),
                        'personal_email'    => trim($rowData['personal_email'] ?? ''),
                        'phone1'            => trim($rowData['phone1']),
                        'phone2'            => trim($rowData['phone2'] ?? ''),
                        'address'           => trim($rowData['address'] ?? ''),
                        'pincode'           => trim($rowData['pincode'] ?? ''),
                        'latitude'          => $rowData['latitude'] ?? '',
                        'longitude'         => $rowData['longitude'] ?? '',
                        'password'          => password_hash($rowData['password'], PASSWORD_DEFAULT),
                        'remember_token'    => $rowData['remember_token'] ?? null,
                        'type'              => $rowData['type'] ?? '',
                        'role_id'           => $rowData['role_id'] ?? 2,
                        'category'          => $rowData['category'] ?? '',
                        'hour_cost'         => $rowData['hour_cost'] ?? 0,
                        'dob'               => !empty($rowData['dob']) ? date('Y-m-d', strtotime($rowData['dob'])) : null,
                        'doj'               => !empty($rowData['doj']) ? date('Y-m-d', strtotime($rowData['doj'])) : null,
                        'profile_image'     => '', 
                        'department'        => $rowData['department'] ?? '',
                        'dept_type'         => $rowData['dept_type'] ?? '',
                        'status'            => $rowData['status'] ?? 1,
                        'approve_date'      => !empty($rowData['approve_date']) ? date('Y-m-d', strtotime($rowData['approve_date'])) : null,
                        'work_mode'         => $rowData['work_mode'] ?? 1,
                        'is_tracker_user'   => $rowData['is_tracker_user'] ?? 0,
                        'is_salarybox_user' => $rowData['is_salarybox_user'] ?? 0,
                        'attendence_type'   => json_encode($attnType),
                        'date_added'        => date('Y-m-d H:i:s'),
                    ];


                    // Save user
                    $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);

                    // Optionally, send email to user
                    /*
                    $generalSetting = $this->common_model->find_data('general_settings', 'row');
                    $subject = $generalSetting->site_name.' :: Account Created '.date('Y-m-d H:i:s');
                    $mailData = ['email' => $rowData['email'], 'password' => $rowData['password']];
                    $message = view('email-templates/signup', $mailData);
                    $this->sendMail($rowData['email'], $subject, $message);
                    */

                    $insertCount++;
                }

                $this->session->setFlashdata('success_message', "$insertCount users inserted successfully.");
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
            } else {
                $this->session->setFlashdata('error_message', 'Please upload a valid CSV file.');
                return redirect()->back();
            }
        }

        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function edit($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(4, 22)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'user/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        // pr($data['row']);
        $data['userCats']           = $this->data['model']->find_data('user_category', 'array');
        $userType                   = $this->session->user_type;
        // echo $userType; die;
        if ($userType == "SUPER ADMIN") { 
            $data['roleMasters']        = $this->data['model']->find_data('permission_roles', 'array', ['published=' => 1]);
            }else{
            $data['roleMasters']        = $this->data['model']->find_data('permission_roles', 'array', ['published=' => 1, 'id!=' => 1]);
            }
        $data['officeLocations']    = $this->data['model']->find_data('office_locations', 'array', ['status=' => 1], 'id,name,address');
        if($this->request->getMethod() == 'post') {
            /* profile image */
                $file = $this->request->getFile('image');
                $originalName = $file->getClientName();
                $fieldName = 'image';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','image');
                    if($upload_array['status']) {
                        $profile_image = $upload_array['newFilename'];
                    } else {
                        $this->session->setFlashdata('error_message', $upload_array['message']);
                        return redirect()->to('/admin/settings');
                    }
                } else {
                    $profile_image = $data['row']->profile_image;
                }
            /* profile image */
            $password = $this->request->getPost('password');
            // if (!empty($password)) {
            //    $newPassword = md5($password);
            // }
            // else{
            //     $newPassword = md5($this->request->getPost('password'));
            // }
            $attendence_type = $this->request->getPost('attendence_type');
            if(!empty($attendence_type)){
                if(in_array(0, $attendence_type)){
                    $attnType = array('0');
                } else {
                    $attnType = $attendence_type;
                }
            } else {
                $attnType = array('0');
            }
            if($password != ''){
                $postData   = array(
                    'name'                  => $this->request->getPost('name'),
                    'email'                 => $this->request->getPost('email'),
                    'personal_email'        => $this->request->getPost('personal_email'),
                    'phone1'                => $this->request->getPost('phone1'),
                    'phone2'                => $this->request->getPost('phone2'),
                    'address'               => $this->request->getPost('address'),
                    'pincode'               => $this->request->getPost('pincode'),
                    'latitude'              => $this->request->getPost('latitude'),
                    'longitude'             => $this->request->getPost('longitude'),
                    'password'              => md5($password),
                    'type'                  => $this->request->getPost('type'),
                    'role_id'               => $this->request->getPost('role_id'),
                    'category'              => $this->request->getPost('category'),                
                    'dob'                   => date_format(date_create($this->request->getPost('dob')), "Y-m-d"),
                    'doj'                   => date_format(date_create($this->request->getPost('doj')), "Y-m-d"),
                    'profile_image'         => $profile_image,
                    'status'                => $this->request->getPost('status'),
                    // 'work_mode'             => $this->request->getPost('work_mode'),
                    'is_tracker_user'       => $this->request->getPost('is_tracker_user'),
                    'is_salarybox_user'     => $this->request->getPost('is_salarybox_user'),
                    'attendence_type'       => json_encode($attnType),
                );
            } else {
                $postData   = array(
                    'name'                  => $this->request->getPost('name'),
                    'email'                 => $this->request->getPost('email'),
                    'personal_email'        => $this->request->getPost('personal_email'),
                    'phone1'                => $this->request->getPost('phone1'),
                    'phone2'                => $this->request->getPost('phone2'),
                    'address'               => $this->request->getPost('address'),
                    'pincode'               => $this->request->getPost('pincode'),
                    'latitude'              => $this->request->getPost('latitude'),
                    'longitude'             => $this->request->getPost('longitude'),
                    // 'password'              => $newPassword,
                    'type'                  => $this->request->getPost('type'),
                    'role_id'               => $this->request->getPost('role_id'),
                    'category'              => $this->request->getPost('category'),                
                    'dob'                   => date_format(date_create($this->request->getPost('dob')), "Y-m-d"),
                    'doj'                   => date_format(date_create($this->request->getPost('doj')), "Y-m-d"),
                    'profile_image'         => $profile_image,
                    'status'                => $this->request->getPost('status'),
                    // 'work_mode'             => $this->request->getPost('work_mode'),
                    'is_tracker_user'       => $this->request->getPost('is_tracker_user'),
                    'is_salarybox_user'     => $this->request->getPost('is_salarybox_user'),
                    'attendence_type'       => json_encode($attnType),
                );
            }
            // pr($postData);
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function confirm_delete($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(4, 58)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $postData = array(
                            'status' => 3
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function change_status($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(4, 23)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        if($data['row']->status){
            $status  = '0';
            $msg        = 'Deactivated';
        } else {
            $status  = '1';
            $msg        = 'Activated';
        }
        $postData = array(
                            'status' => $status
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function change_tracker_status($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(4, 110)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        if($data['row']->is_tracker_user){
            $is_tracker_user    = 0;
            $msg                = 'Tracker Off';
        } else {
            $is_tracker_user    = 1;
            $msg                = 'Tracker On';
        }
        $postData = array(
                            'is_tracker_user' => $is_tracker_user
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function change_salarybox_status($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(4, 111)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        if($data['row']->is_salarybox_user){
            $is_salarybox_user    = 0;
            $msg                = 'Salarybox Off';
        } else {
            $is_salarybox_user    = 1;
            $msg                = 'Salarybox On';
        }
        $postData = array(
                            'is_salarybox_user' => $is_salarybox_user
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function sendCredentials($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(4, 25)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        $new_password               = generateRandomString(8);

        /* credentials sent */
            $generalSetting             = $this->common_model->find_data('general_settings', 'row');
            $subject                    = $generalSetting->site_name.' :: Account Credentials '.date('Y-m-d H:i:s');
            $mailData                   = [
                'email'     => $data['row']->email,
                'password'  => $new_password,
            ];
            $message                    = view('email-templates/signup', $mailData);
            $this->sendMail($data['row']->email, $subject, $message);
            /* email log save */
                $postData2 = [
                    'name'                  => $this->request->getPost('name'),
                    'email'                 => $this->request->getPost('email'),
                    'subject'               => $subject,
                    'message'               => $message
                ];
                $this->common_model->save_data('email_logs', $postData2, '', 'id');
            /* email log save */
        /* credentials sent */

        $postData = array(
                            'password' => md5($new_password)
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        
        $msg                = 'Password Has Been Reset & Credentials Sent';
        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }

    public function usercostlist()
    {
        if (!$this->common_model->checkModuleFunctionAccess(33, 89)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'] . ' ' . $this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title']. ' Cost';
        $page_name                  = 'user_cost';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $userType                   = $this->session->user_type;        
        // $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['status' => '1'], '', '', '', $order_by);
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', '', '', '', '', $order_by);
        // echo $this->db->getLastquery(); die;
        if($this->request->getMethod() == 'post') {
            $id = $this->request->getPost('id');            
            $postData   = array(
                'hour_cost'           => $this->request->getPost('hour_cost'),                                                                       
            );             
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].'  cost updated successfully');
            return redirect()->to('/admin/user_cost/list');
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
}