<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use DateTime;

class User extends BaseController
{
    public function __construct() {}
    /* authentication */
    public function login()
    {
        if ($this->request->getMethod() == 'post') {
            $input = $this->validate([
                'email'     => 'required',
                'password'  => 'required|min_length[6]'
            ]);
            if ($input == true) {
                $conditions = array(
                    'email'  => $this->request->getPost('email')
                );
                // echo $this->pro->decrypt('C+MjEJRD6htGGKkEGFPuDYuShcUqbV0s5lWLc0cMJn0=');
                // echo '<br>';
                // echo $this->pro->encrypt($this->request->getPost('email'));
                $conditions2 = array(
                    'email_1'  => $this->pro->encrypt($this->request->getPost('email'))
                );
                $checkEmail = $this->common_model->find_data('user', 'row', $conditions);
                $checkclientEmail = $this->common_model->find_data('client', 'row', $conditions2);
                // pr($checkclientEmail);
                if ($checkEmail) {
                    $user_type = $checkEmail->type;
                    $user_name = $checkEmail->name;
                    if ($checkEmail->status == '1') {
                        if ($checkEmail->password == md5($this->request->getPost('password'))) {
                            $session_data = array(
                                'user_id'           => $checkEmail->id,
                                'user_type'         => $checkEmail->type,
                                'username'          => $checkEmail->name,
                                'name'              => $checkEmail->name,
                                'email'             => $checkEmail->email,
                                'category'          => $checkEmail->category,
                                'is_admin_login'    => 1
                            );
                            $this->session->set($session_data);
                            if ($this->session->get('is_admin_login') == 1) {
                                $fields = array(
                                    'ip_address'        => $this->request->getIPAddress(),
                                    'last_login'        => date('d-m-Y h:i:s a'),
                                    'last_browser_used' => $this->request->getUserAgent()
                                );
                                $user_id = $checkEmail->id;
                                $this->common_model->save_data('user', $fields, $user_id, 'id');
                                $userActivityData = [
                                    'user_email'        => $this->request->getPost('email'),
                                    'user_name'         => $user_name,
                                    'activity_type'     => 1,
                                    'user_type'         => $user_type,
                                    'ip_address'        => $this->request->getIPAddress(),
                                    'activity_details'  => 'Admin Sign In Success',
                                ];
                                $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
                                // $this->session->setFlashdata('success_message', 'SignIn Success! Redirecting to dashboard !!!');
                                return redirect()->to('/admin/dashboard');
                            }
                        } else {
                            $userActivityData = [
                                'user_email'        => $this->request->getPost('email'),
                                'user_name'         => $user_name,
                                'user_type'         => $user_type,
                                'ip_address'        => $this->request->getIPAddress(),
                                'activity_type'     => 0,
                                'activity_details'  => 'Invalid Password',
                            ];
                            $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
                            $this->session->setFlashdata('error_message', 'Invalid Password !!!');
                            return redirect()->to(base_url("admin"));
                        }
                    } else {
                        $userActivityData = [
                            'user_email'        => $this->request->getPost('email'),
                            'user_name'         => $user_name,
                            'user_type'         => $user_type,
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 0,
                            'activity_details'  => 'Account Deactivated',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
                        $this->session->setFlashdata('error_message', 'Account Deactivated !!!');
                        return redirect()->to(base_url("admin"));
                    }
                } elseif ($checkclientEmail) {
                    $user_type = 'CLIENT';
                    $user_name = $checkclientEmail->name;
                    //if($checkclientEmail->status == '1'){

                    if ($checkclientEmail->password_md5 == md5($this->request->getPost('password'))) {
                        $session_data = array(
                            'user_id'           => $checkclientEmail->id,
                            'user_type'         => $user_type,
                            'username'          => $this->pro->decrypt($checkclientEmail->name),
                            'name'              => $this->pro->decrypt($checkclientEmail->name),
                            'email'             => $this->pro->decrypt($checkclientEmail->email_1),
                            'is_admin_login'    => $checkclientEmail->login_access
                        );
                        // pr($checkclientEmail);
                        // pr($session_data);
                        $this->session->set($session_data);

                        if ($this->session->get('is_admin_login') == 1) {
                            // pr($session_data);
                            $fields = array(
                                //'ip_address'        => $this->request->getIPAddress(),
                                'last_login'        => date('Y-m-d H:i:s'),
                                //'last_browser_used' => $this->request->getUserAgent()
                            );
                            $user_id = $checkclientEmail->id;
                            $this->common_model->save_data('client', $fields, $user_id, 'id');
                            return redirect()->to('/admin/dashboard');
                        } else {
                            $this->session->setFlashdata('error_message', 'Please contact the admin for access !!!');
                            return redirect()->to(base_url("admin"));
                        }
                    } else {
                        $userActivityData = [
                            'user_email'        => $this->request->getPost('email'),
                            'user_name'         => $user_name,
                            'user_type'         => $user_type,
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 0,
                            'activity_details'  => 'Invalid Password',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
                        $this->session->setFlashdata('error_message', 'Invalid Password !!!');
                        return redirect()->to(base_url("admin"));
                    }
                    // } else {
                    //     $userActivityData = [
                    //         'user_email'        => $this->request->getPost('email'),
                    //         'user_name'         => $user_name,
                    //         'user_type'         => $user_type,
                    //         'ip_address'        => $this->request->getIPAddress(),
                    //         'activity_type'     => 0,
                    //         'activity_details'  => 'Account Deactivated',
                    //     ];
                    //     $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                    //     $this->session->setFlashdata('error_message','Account Deactivated !!!');
                    //     return redirect()->to(base_url("admin"));
                    // }
                } else {
                    $userActivityData = [
                        'user_email'        => '',
                        'user_name'         => '',
                        //'user_type'         => $user_type,
                        'ip_address'        => $this->request->getIPAddress(),
                        'activity_type'     => 0,
                        'activity_details'  => 'We Don\'t Recognize Your Email Address',
                    ];
                    $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
                    $this->session->setFlashdata('error_message', 'We Don\'t Recognize Your Email Address !!!');
                    return redirect()->to(base_url("admin"));
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        $title      = 'Sign In';
        $page_name  = 'signin';
        $data       = [];
        echo $this->layout_before_login($title, $page_name, $data);
    }
    public function signout()
    {
        /* user activity */
        $userActivityData = [
            'user_email'        => $this->session->email,
            'user_name'         => $this->session->username,
            'user_type'         => $this->session->user_type,
            'ip_address'        => $this->request->getIPAddress(),
            'activity_type'     => 2,
            'activity_details'  => 'Admin Sign Out Successfully',
        ];
        // pr($userActivityData);
        $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
        /* user activity */
        $this->session->destroy();
        $this->session->setFlashdata('success_message', 'Sign Out Successfully !!!');
        return redirect()->to('/admin');
    }
    /* authentication */
    /* forgot password */
    public function forgotPassword()
    {
        $title      = 'Forgot Password';
        $page_name  = 'forgot-password';
        $data       = [];
        if ($this->request->getPost()) {
            $email          = $this->request->getPost('username');
            $checkEmail     = $this->common_model->find_data('user', 'row', ['email' => $email, 'status' => '1']);
            if ($checkEmail) {
                // otp mail send
                $otp        =  rand(1000, 9999);
                $fields     =  ['remember_token' => $otp];
                $this->common_model->save_data('user', $fields, $checkEmail->id, 'id');

                /* email sent */
                $mailData   = [
                    'otp' => $otp
                ];
                $general_settings           = $this->common_model->find_data('general_settings', 'row');
                $to         = $checkEmail->email;
                $subject    = $general_settings->site_name . " :: Validate Email OTP";
                $message    = view('email-templates/otp', $mailData);
                // echo $message;die;
                $this->sendMail($to, $subject, $message);
                /* email sent */
                /* email log save */
                $emailLogData = [
                    'name'      => $checkEmail->name,
                    'email'     => $checkEmail->email,
                    'subject'   => $subject,
                    'message'   => $message,
                ];
                $this->common_model->save_data('email_logs', $emailLogData, '', 'id');
                /* email log save */
                $this->session->setFlashdata('success_message', 'OTP Successfully Sent On Registered Email !!!');
                return redirect()->to(base_url('admin/verify-otp/' . encoded($checkEmail->id)));
                // otp mail send
            } else {
                $this->session->setFlashdata('error_message', 'Email Id Is Not Recognized !!!');
                return redirect()->to(current_url());
            }
        }
        echo $this->layout_before_login($title, $page_name, $data);
    }
    public function verifyOtp($id)
    {
        $id         = decoded($id);
        $title      = 'Verify OTP';
        $page_name  = 'verify-otp';
        $data       = [];
        if ($this->request->getPost()) {
            $otp            = $this->request->getPost('otp');
            $checkEmail     = $this->common_model->find_data('user', 'row', ['id' => $id, 'status' => '1']);
            if ($checkEmail) {
                if ($checkEmail->remember_token == $otp) {
                    $this->common_model->save_data('user', ['remember_token' => 0], $id, 'id');
                    $this->session->setFlashdata('success_message', 'OTP Validated Successfully !!!');
                    return redirect()->to(base_url('admin/reset-password/' . encoded($id)));
                } else {
                    $this->session->setFlashdata('error_message', 'Invalid OTP !!!');
                    return redirect()->to(current_url());
                }
            } else {
                $this->session->setFlashdata('error_message', 'User Not Found !!!');
                return redirect()->to(current_url());
            }
        }
        echo $this->layout_before_login($title, $page_name, $data);
    }
    public function resetPassword($id)
    {
        $id         = decoded($id);
        $title      = 'Reset Password';
        $page_name  = 'reset-password';
        $data       = [];
        if ($this->request->getPost()) {
            $password               = $this->request->getPost('password');
            $confirm_password       = $this->request->getPost('confirm_password');
            $checkEmail             = $this->common_model->find_data('user', 'row', ['id' => $id, 'status' => '1']);
            if ($checkEmail) {
                if ($password == $confirm_password) {
                    $this->common_model->save_data('user', ['password' => md5($password), 'remember_token' => 0], $id, 'id');

                    /* email sent */
                    $mailData   = [
                        'name'      => $checkEmail->name,
                        'email'     => $checkEmail->email,
                        'password'  => $password,
                    ];
                    $general_settings           = $this->common_model->find_data('general_settings', 'row');
                    $to         = $checkEmail->email;
                    $subject    = $general_settings->site_name . " :: Reset Password";
                    $message    = view('email-templates/change-password', $mailData);
                    // echo $message;die;
                    $this->sendMail($to, $subject, $message);
                    /* email sent */
                    /* email log save */
                    $emailLogData = [
                        'name'      => $checkEmail->name,
                        'email'     => $checkEmail->email,
                        'subject'   => $subject,
                        'message'   => $message,
                    ];
                    $this->common_model->save_data('email_logs', $emailLogData, '', 'id');
                    /* email log save */

                    $this->session->setFlashdata('success_message', 'Password Reset Successfully !!!');
                    return redirect()->to(base_url('admin'));
                } else {
                    $this->session->setFlashdata('error_message', 'Password & Confirm Password Does Not Matched !!!');
                    return redirect()->to(current_url());
                }
            } else {
                $this->session->setFlashdata('error_message', 'User Not Found !!!');
                return redirect()->to(current_url());
            }
        }
        echo $this->layout_before_login($title, $page_name, $data);
    }
    /* forgot password */
    /* dashboard */
    public function dashboard()
    {
        if (!$this->session->get('is_admin_login')) {
            return redirect()->to('/admin');
        }

        $userType                           = $this->session->user_type;
        $userId                             = $this->session->user_id;
        if ($userType == 'CLIENT') {
            $user_id                = $this->session->get('user_id');
            $data['active_project'] = $this->common_model->find_data('project', 'count', ['client_id' => $user_id, 'status!=' => 13, 'type' => 'own']);
            $data['closed_project'] = $this->common_model->find_data('project', 'count', ['client_id' => $user_id, 'status' => 13, 'type' => 'own']);
            $join[0]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
            $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
            $data['projects']           = $this->common_model->find_data('project', 'array', ['project.status!=' => 13, 'project.client_id' => $user_id], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join);
            // pr($data['projects']);
            $data['closed_projects']    = $this->common_model->find_data('project', 'array', ['project.status' => 13, 'project.client_id' => $user_id], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join);
            foreach ($data['projects'] as $project) {
                // pr($project);
                $project_id = $project->id;
                $sql = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where t.project_id = '$project_id' group by t.project_id order by p.name asc";
                $rows = $this->db->query($sql)->getResult();
                // echo $sql; die;
                $total_effort_in_mins = 0;
                $hour = $rows[0]->tot_hour;
                $min = $rows[0]->tot_min;
                $total_hour_min = ($hour * 60); // 0*60 = 0
                $total_min_min = $min; // 30
                $total_effort_in_mins += ($total_hour_min + $total_min_min);
                $data['total_effort_in_mins']   = $total_effort_in_mins;
                // pr($data['total_effort_in_mins']);
            }
        } else {
            /* total cards */
            $cu_date            = date('Y-m-d');
            $data['total_users']                = $this->common_model->find_data('user', 'count');
            $data['total_active_users']         = $this->common_model->find_data('user', 'count', ['status' => '1']);
            $data['total_inactive_users']       = $this->common_model->find_data('user', 'count', ['status' => '0']);
            $data['total_projects']             = $this->common_model->find_data('project', 'count');
            $data['total_prospect_projects']    = $this->common_model->find_data('project', 'count', ['type' => 'Prospect']);
            $data['total_active_projects']      = $this->common_model->find_data('project', 'count', ['active' => '0', 'status<>' => '13']);
            // echo $this->db->getLastquery();
            $data['total_lost_projects']        = $this->common_model->find_data('project', 'count', ['type' => 'Lost']);
            $data['total_nonbill_projects']     = $this->common_model->find_data('project', 'count', ['bill' => 1, 'active' => 0]);
            $data['total_bill_projects']        = $this->common_model->find_data('project', 'count', ['bill' => 0, 'active' => 0]);
            $data['total_clients']              = $this->common_model->find_data('client', 'count');
            $data['total_clients_leads']        = $this->db->query("select count(*) as count_lead from client where id not in(select client_id from project)")->getRow();
            $data['total_app_user']             = $this->db->query("SELECT COUNT(id) as user_count FROM `user` WHERE is_salarybox_user = '1'")->getRow();
            $data['total_present_user']         = $this->db->query("SELECT COUNT(DISTINCT attendances.user_id) AS user_count FROM `attendances` WHERE attendances.punch_date LIKE '%$cu_date%'")->getRow();
            // $order_by[0]                        = array('field' => 'status', 'type' => 'DESC');
            $order_by[0]                        = array('field' => 'name', 'type' => 'ASC');
            $data['employees']                  = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'is_tracker_user' => 1], 'id,name,status', '', '', $order_by);
            $data['projects']                   = $this->common_model->find_data('project', 'array', ['status!=' => '13'], 'id,name,status','', '', $order_by);            
            // $data['total_absent_user']          = $this->db->query("SELECT COUNT(DISTINCT attendances.user_id) AS user_count FROM `attendances` WHERE attendances.punch_date LIKE '%$cu_date%' and punch_in_time = ''")->getRow();                                                
            $user_task = "SELECT morning_meetings.*, project.name as project_name FROM `morning_meetings`INNER JOIN project ON morning_meetings.project_id = project.id WHERE morning_meetings.created_at LIKE '%$cu_date%' and morning_meetings.user_id = $userId ORDER BY morning_meetings.date_added ASC";
            $user_task_data = $this->db->query($user_task)->getResult();
            $user_task_details = [];
            foreach ($user_task_data as $task_data) {
                $assign_by = $task_data->added_by;
                $task_date = $task_data->created_at;
                // Create DateTime object
                $date = new DateTime($task_date);
                // Format the date
                $formattedDate = $date->format('d-M-y h:i A');
                $assign_time = new DateTime($task_data->date_added);
                $user_details = $this->common_model->find_data('user', 'row', ['id' => $assign_by]);                
                $work_status_background = '';
                $work_status_border = '';
                if ($task_data->work_status_id != 0) {
                    $work_status = $this->common_model->find_data('work_status', 'row', ['id' => $task_data->work_status_id]);
                    if ($work_status) {
                        $work_status_background = $work_status->background_color;
                        $work_status_border = $work_status->border_color;
                    }
                }
                $user_task_details[] = [
                    'id'            => $task_data->id,                    
                    'user_name'     => $user_details->name,                    
                    'project_name'  => $task_data->project_name,
                    'priority'      => $task_data->priority,  
                    'description'   => ucfirst($task_data->description),
                    'work_status_id' => $task_data->work_status_id,       
                    'work_status_background'   => $work_status_background,
                    'work_status_border'   => $work_status_border,
                    'created_at'    => $formattedDate,
                    'assign_at'     => $assign_time->format('d-M-y'),
                ];
            }
            $data['user_task_details'] = $user_task_details;                   
            // pr($user_task_details);
            // $users              = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'id' => $userId], '', '', '', $order_by);
            $sql11              = "SELECT user.*, department.deprt_name as deprt_name FROM `user`INNER JOIN department ON user.department = department.id WHERE user.id = $userId AND user.status != 3";
            $users              = $this->db->query($sql11)->getResult();
            $application_settings        = $this->common_model->find_data('application_settings', 'row', ['id' => 1]);
            //  pr($application_settings);
            $desklog_user       = $application_settings->is_desklog_use;
            $data['desklog_user'] = $desklog_user;
            // $cu_date            = date('Y-m-d');
            // }

            $response = [];
            $last7DaysAttendance = [];
            $sl = 1;
            if ($users) {
                foreach ($users as $row) {
                    $monthYear1 = date('Y') . '-' . date('01');
                    $year = date('Y');
                    $sql1 = "SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear1%'";
                    $jan_booked = $this->db->query($sql1)->getRow();
                    $sql = "SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 1 AND user_id = '$row->id'";
                    // $sql = "SELECT time_at_work FROM `desklog_report` where tracker_user_id='$row->id' and insert_date LIKE '%$monthYear1%'";
                    $getDesktimeHour = $this->db->query($sql)->getRow();
                    //  pr($getDesktimeHour);
                    if ($getDesktimeHour) {
                        // $result1 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                        // $result1 = (int)$getDesktimeHour->total_desktime_hour;
                        $result1 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result1 = '';
                    }
                    if ($jan_booked) {
                        $tothour = $jan_booked->tothour * 60;
                        $totmin = $jan_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked1            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear2 = date('Y') . '-' . date('02');
                    $feb_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear2%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 2 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result2 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                        // $result2 = (int)$getDesktimeHour->total_desktime_hour;
                        $result2 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result2 = '';
                    }
                    if ($feb_booked) {
                        $tothour = $feb_booked->tothour * 60;
                        $totmin = $feb_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked2            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear3 = date('Y') . '-' . date('03');
                    $mar_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id=$row->id and date_added LIKE '%$monthYear3%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 3 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result3 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                        // $result3 = (int)$getDesktimeHour->total_desktime_hour;
                        $result3 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result3 = '';
                    }
                    if ($mar_booked) {
                        $tothour3 = $mar_booked->tothour * 60;
                        $totmin3 = $mar_booked->totmin;
                        $totalMin3 = ($tothour3 + $totmin3);
                        $totalBooked3            = intdiv($totalMin3, 60) . '.' . ($totalMin3 % 60);
                    }
                    $monthYear4 = date('Y') . '-' . date('04');
                    $apr_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear4%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 4 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result4 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                        // $result4 = (int)$getDesktimeHour->total_desktime_hour;
                        $result4 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result4 = '';
                    }
                    if ($apr_booked) {
                        $tothour = $apr_booked->tothour * 60;
                        $totmin = $apr_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked4            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear5 = date('Y') . '-' . date('05');
                    $may_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear5%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 5 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result5 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                        // $result5 = (int)$getDesktimeHour->total_desktime_hour;
                        $result5 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result5 = '';
                    }
                    if ($may_booked) {
                        $tothour = $may_booked->tothour * 60;
                        $totmin = $may_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked5            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear6 = date('Y') . '-' . date('06');
                    $jun_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear6%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 6 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result6 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                        // $result6 = (int)$getDesktimeHour->total_desktime_hour;
                        $result6 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result6 = '';
                    }
                    if ($jun_booked) {
                        $tothour = $jun_booked->tothour * 60;
                        $totmin = $jun_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked6            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear7 = date('Y') . '-' . date('07');
                    $jul_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear7%'")->getRow();
                    $sql10 = "SELECT * FROM `desktime_sheet_tracking` WHERE year_upload = '$year' AND month_upload = 7 AND user_id = '$row->id'";
                    $getDesktimeHour = $this->db->query($sql10)->getRow();
                    if ($getDesktimeHour) {
                        // $result7 = $getDesktimeHour->total_desktime_hour;  
                        // $result7 = (int)$getDesktimeHour->total_desktime_hour; 
                        $result7 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result7 = '';
                    }
                    if ($jul_booked) {
                        $tothour = $jul_booked->tothour * 60;
                        $totmin = $jul_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked7            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear8 = date('Y') . '-' . date('08');
                    $aug_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear8%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 8 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result8 = $getDesktimeHour->total_desktime_hour;
                        // $result8 = (int)$getDesktimeHour->total_desktime_hour;
                        $result8 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result8 = '';
                    }
                    if ($aug_booked) {
                        $tothour = $aug_booked->tothour * 60;
                        $totmin = $aug_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked8            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear9 = date('Y') . '-' . date('09');
                    $sep_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear9%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 9 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result9 = $getDesktimeHour->total_desktime_hour;
                        $result9 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result9 = '';
                    }
                    if ($sep_booked) {
                        $tothour = $sep_booked->tothour * 60;
                        $totmin = $sep_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked9            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear10 = date('Y') . '-' . date('10');
                    $oct_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear10%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 10 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result10 = $getDesktimeHour->total_desktime_hour;
                        // $result10 = (int)$getDesktimeHour->total_desktime_hour;
                        $result10 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result10 = '';
                    }
                    if ($oct_booked) {
                        $tothour = $oct_booked->tothour * 60;
                        $totmin = $oct_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked10            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear11 = date('Y') . '-' . date('11');
                    $nov_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear11%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 11 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result11 = $getDesktimeHour->total_desktime_hour;
                        // $result11 = (int)$getDesktimeHour->total_desktime_hour;
                        $result11 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result11 = '';
                    }
                    if ($nov_booked) {
                        $tothour = $nov_booked->tothour * 60;
                        $totmin = $nov_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked11            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }
                    $monthYear12 = date('Y') . '-' . date('12');
                    $dec_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear12%'")->getRow();
                    $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$year' AND month_upload = 12 AND user_id = '$row->id'")->getRow();
                    if ($getDesktimeHour) {
                        // $result12 = $getDesktimeHour->total_desktime_hour;
                        // $result12 = (int)$getDesktimeHour->total_desktime_hour;
                        $result12 = str_replace(['h ', 'm'], [':', ''], $getDesktimeHour->total_desktime_hour);
                    } else {
                        $result12 = '';
                    }
                    if ($dec_booked) {
                        $tothour = $dec_booked->tothour * 60;
                        $totmin = $dec_booked->totmin;
                        $totalMin = ($tothour + $totmin);
                        $totalBooked12            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                    }

                    $arr                = [];
                    $arr = $this->getLastNDays(7, 'Y-m-d');
                    if (!empty($arr)) {
                        $Attendancereports = [];
                        for ($k = 0; $k < count($arr); $k++) {
                            $loopDate           = $arr[$k];
                            // print_r($loopDate);die;
                            $dayWiseAttendance      = $this->db->query("SELECT MIN(punch_in_time) AS first_punch_in, MAX(punch_out_time) AS last_punch_out FROM `attendances` where user_id='$row->id' and punch_date LIKE '$loopDate'")->getRow();
                            // $dayWiseAttendance      = $this->db->query("SELECT MIN(punch_in_time) AS first_punch_in, MAX(punch_out_time) AS last_punch_out FROM `attendances` where user_id='$row->id' and punch_date LIKE '%2024-08-29%'")->getRow();
                            // echo $this->db->getLastquery();
                            //  pr($dayWiseAttendance);                                

                            if ($dayWiseAttendance) {
                                $punchIn = $dayWiseAttendance->first_punch_in;
                                $punchOut = $dayWiseAttendance->last_punch_out;
                            } else {
                                $punchIn = null;
                                $punchOut = null;
                            }
                            $Attendancereports[] = [
                                'booked_date'   => date_format(date_create($loopDate), "d-m-Y"),
                                'punchIn' => $punchIn,
                                'punchOut' => $punchOut,
                            ];
                        }
                        // pr($Attendancereports);
                    }
                    $last7DaysAttendance[] = [
                        'userId'    => $row->id,
                        'name'      => $row->name,
                        'Attendancereports'   => $Attendancereports,
                    ];



                    $response[] = [
                        'sl_no'         => $sl++,
                        'name'          => $row->name,
                        'jan_booked'    => $totalBooked1,
                        'feb_booked'    => $totalBooked2,
                        'mar_booked'    => $totalBooked3,
                        'apr_booked'    => $totalBooked4,
                        'may_booked'    => $totalBooked5,
                        'jun_booked'    => $totalBooked6,
                        'jul_booked'    => $totalBooked7,
                        'aug_booked'    => $totalBooked8,
                        'sep_booked'    => $totalBooked9,
                        'oct_booked'    => $totalBooked10,
                        'nov_booked'    => $totalBooked11,
                        'dec_booked'    => $totalBooked12,
                        'jan_desklog'   => $result1,
                        'feb_desklog'   => $result2,
                        'mar_desklog'   => $result3,
                        'apr_desklog'   => $result4,
                        'may_desklog'   => $result5,
                        'jun_desklog'   => $result6,
                        'jul_desklog'   => $result7,
                        'aug_desklog'   => $result8,
                        'sep_desklog'   => $result9,
                        'oct_desklog'   => $result10,
                        'nov_desklog'   => $result11,
                        'dec_desklog'   => $result12,
                        'deskloguser'   => $desklog_user,
                    ];
                }
            }
            $data['responses']                   = $response;
            $data['last7DaysAttendance']         = $last7DaysAttendance;

            $last7DaysResponses = [];
            $arr                = [];
            $users_data              = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'is_tracker_user' => 1], 'id,name,status', '', '', $order_by);
            $arr = $this->getLastNDays(7, 'Y-m-d');
            //print_r($arr);die;
            if ($user = ($userType == 'SUPER ADMIN' || $userType == 'ADMIN') ? $users_data : $users) {
                // if($users){
                foreach ($user as $row) {
                    if (!empty($arr)) {
                        $reports = [];
                        for ($k = 0; $k < count($arr); $k++) {
                            $loopDate               = $arr[$k];
                            $dayWiseBooked          = $this->db->query("SELECT sum(hour) as tothour, date_today, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '$loopDate'")->getRow();
                            $desklogdayWise         = $this->db->query("SELECT time_at_work  FROM `desklog_report` where tracker_user_id='$row->id' and insert_date LIKE '%$loopDate%'")->getRow();
                            // echo $this->db->getLastquery();
                            // echo "<pre>";
                            // print_r($str);
                            // var_dump($desklogdayWise); die();

                            $tothour                = $dayWiseBooked->tothour * 60;
                            $totmin                 = $dayWiseBooked->totmin;
                            $totalMin               = ($tothour + $totmin);
                            $booked_effort          = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                            $workdate               = date_create($loopDate);
                            $entrydate              = date_create($dayWiseBooked->date_today);
                            if ($desklogdayWise !== null) {
                                $desklogTime            = $desklogdayWise->time_at_work;
                            } else {
                                $desklogTime            = 0;
                            }

                            $reports[] = [
                                'booked_date'   => date_format(date_create($loopDate), "d-m-Y"),
                                'booked_effort' => $booked_effort,
                                'booked_today' => date_format(date_create($dayWiseBooked->date_today), "d-m-Y"),
                                'desklog_time'  => str_replace(['h ', 'm'], [':', ''], $desklogTime),
                                'deskloguser'   => $desklog_user,
                            ];
                        }
                    }
                    $last7DaysResponses[] = [
                        'userId'    => $row->id,
                        'name'      => $row->name,
                        'reports'   => $reports,
                    ];
                }
            }
            $data['arr']                        = $arr;
            $data['last7DaysResponses']         = $last7DaysResponses;
            // echo "<pre>";   
            // print_r($data['last7DaysResponses'])  ;die;       
            $userGraph = [];
            $AlluserGraph = [];

            if ($user = ($userType == 'SUPER ADMIN' || $userType == 'ADMIN') ? $users_data : $users) {
                foreach ($user as $row) {
                    // pr($row);       
                    $team = "SELECT team.*,department.deprt_name  FROM `team` INNER JOIN department on team.dep_id = department.id WHERE user_id = '$row->id'";
                    $teamdetails = $this->db->query($team)->getRow();
                    // pr($teamdetails);
                    /* user graph */
                    $yesterday_date = date('Y-m-d', strtotime("-1 days"));
                    $qry_yesterday_proj = "select timesheet.project_id,sum(hour) hour,sum(min) min,timesheet.bill  from timesheet where date_added = '$yesterday_date' and user_id = '$row->id' group by timesheet.project_id" . " order by timesheet.date_added desc";
                    $res_yesterday_proj = $this->db->query($qry_yesterday_proj)->getResult();
                    $i4 = 1;
                    $ystrdhr = 0;
                    $ystrdmin = 0;
                    $ystrdbill_hr = 0;
                    $ystrdbill_min = 0;
                    $ystrdnonbill_hr = 0;
                    $ystrdnonbill_min = 0;
                    // $yesterday_hour = 0;
                    // $yesterday_minute = 0;
                    foreach ($res_yesterday_proj as $row_yesterday_proj) {
                        if ($row_yesterday_proj->bill != '1') {
                            $ystrdbill_hr = $ystrdbill_hr + $row_yesterday_proj->hour;
                            $ystrdbill_min = $ystrdbill_min + $row_yesterday_proj->min;
                        } else {
                            $ystrdnonbill_hr = $ystrdnonbill_hr + $row_yesterday_proj->hour;
                            $ystrdnonbill_min = $ystrdnonbill_min + $row_yesterday_proj->min;
                        }
                        $i4++;
                    }
                    if ($ystrdbill_min < 60) {
                        $ystrdtotbill_hour = $ystrdbill_hr;
                        $ystrdtotbill_minute = $ystrdbill_min;
                    } else {
                        $ystrdtotbill_hour_res1 = floor($ystrdbill_min / 60);
                        $ystrdtotbill_minute = $ystrdbill_min % 60;
                        $ystrdtotbill_hour = $ystrdbill_hr + $ystrdtotbill_hour_res1;
                    }
                    if ($ystrdnonbill_min < 60) {
                        $ystrdtotnonbill_hour = $ystrdnonbill_hr;
                        $ystrdtotnonbill_minute = $ystrdnonbill_min;
                    } else {
                        $ystrdtotnonbill_hour_res1 = floor($ystrdnonbill_min / 60);
                        $ystrdtotnonbill_minute = $ystrdnonbill_min % 60;
                        $ystrdtotnonbill_hour = $ystrdnonbill_hr + $ystrdtotnonbill_hour_res1;
                    }
                    $yesterdayHourBill = $ystrdtotbill_hour + ($ystrdtotbill_minute / 60);
                    $yesterdayMinBill = $ystrdtotnonbill_hour + ($ystrdtotnonbill_minute / 60);
                    /* user graph */
                    /* user Monthly graph */
                    $thismonthdayUsr = "";
                    $thismonthmonthUsr = "";
                    $thismonthyearUsr = "";
                    $thismonthtdayUsr = ($thismonthdayUsr == "") ? "01" : $thismonthdayUsr;
                    $thismonthtmonthUsr = ($thismonthmonthUsr == "") ? date("m") : $thismonthmonthUsr;
                    $thismonthtyearUsr = ($thismonthyearUsr == "") ? date("Y") : $thismonthyearUsr;
                    $thismonthmonth_sdUsr = date("Y-m-d", strtotime($thismonthtmonthUsr . '/' . $thismonthtdayUsr . '/' . $thismonthtyearUsr . ' 00:00:00'));
                    $thismonthmonth_edUsr = date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime($thismonthtmonthUsr . '/' . $thismonthtdayUsr . '/' . $thismonthtyearUsr . ' 00:00:00'))));
                    $thismonthdateUsr = date('Y-m-d');
                    $qry_thismonth_projUsr = "select timesheet.project_id,sum(hour) hour,sum(min) min,timesheet.bill "
                        . "from timesheet where date_added between '$thismonthmonth_sdUsr' and '$thismonthdateUsr' and user_id = '$row->id' "
                        . " group by timesheet.project_id order by timesheet.date_added desc";
                    $res_thismonth_projUsr = $this->db->query($qry_thismonth_projUsr)->getResult();
                    //pr($res_thismonth_projUsr);
                    $i5Usr = 1;
                    $thismonthhrUsr = 0;
                    $thismonthminUsr = 0;
                    $thismonthbill_hrUsr = 0;
                    $thismonthbill_minUsr = 0;
                    $thismonthnonbill_hrUsr = 0;
                    $thismonthnonbill_minUsr = 0;
                    foreach ($res_thismonth_projUsr as $row_thismonth_projUsr) {
                        if ($row_thismonth_projUsr->bill != '1') {
                            $thismonthbill_hrUsr = $thismonthbill_hrUsr + $row_thismonth_projUsr->hour;
                            $thismonthbill_minUsr = $thismonthbill_minUsr + $row_thismonth_projUsr->min;
                        } else {
                            $thismonthnonbill_hrUsr = $thismonthnonbill_hrUsr + $row_thismonth_projUsr->hour;
                            $thismonthnonbill_minUsr = $thismonthnonbill_minUsr + $row_thismonth_projUsr->min;
                        }
                        $i5Usr++;
                    }
                    if ($thismonthbill_minUsr < 60) {
                        $thismonthtotbill_hourUsr = $thismonthbill_hrUsr;
                        $thismonthtotbill_minuteUsr = $thismonthbill_minUsr;
                    } else {
                        $thismonthtotbill_hour_res1Usr = floor($thismonthbill_minUsr / 60);
                        $thismonthtotbill_minuteUsr = $thismonthbill_minUsr % 60;
                        $thismonthtotbill_hourUsr = $thismonthbill_hrUsr + $thismonthtotbill_hour_res1Usr;
                    }

                    if ($thismonthnonbill_minUsr < 60) {
                        $thismonthtotnonbill_hourUsr = $thismonthnonbill_hrUsr;
                        $thismonthtotnonbill_minuteUsr = $thismonthnonbill_minUsr;
                    } else {
                        $thismonthtotnonbill_hour_res1Usr = floor($thismonthnonbill_minUsr / 60);
                        $thismonthtotnonbill_minuteUsr = $thismonthnonbill_minUsr % 60;
                        $thismonthtotnonbill_hourUsr = $thismonthnonbill_hrUsr + $thismonthtotnonbill_hour_res1Usr;
                    }
                    $thismonthHourBillUsr = $thismonthtotbill_hourUsr + ($thismonthtotbill_minuteUsr / 60);
                    $thismonthMinBillUsr = $thismonthtotnonbill_hourUsr + ($thismonthtotnonbill_minuteUsr / 60);
                    $data['thismonthHourBillUsr']        = $thismonthHourBillUsr;
                    $data['thismonthMinBillUsr']        = $thismonthMinBillUsr;
                    /* user Monthly graph */
                    /* user Last Month graph */
                    $lastmonththis_yearUsr = date("Y");
                    $lastmonththis_monthUsr = date("m");
                    if ($lastmonththis_monthUsr == '01' || $lastmonththis_monthUsr == '1') {
                        $lastmonthmonthUsr = 12;
                        $lastmonththis_yearUsr = $lastmonththis_yearUsr - 1;
                    } else {
                        $lastmonthmonthUsr = $lastmonththis_monthUsr - 1;
                    }
                    $lastmonthlastdayUsr = mktime(0, 0, 0, $lastmonthmonthUsr + 1, 0, $lastmonththis_yearUsr);
                    $lastmonthfirstdayUsr = mktime(0, 0, 0, $lastmonthmonthUsr, 1, $lastmonththis_yearUsr);
                    $lastmonthendUsr = date("Y-m-d", $lastmonthlastdayUsr);
                    $lastmonthstartUsr = date("Y-m-d", $lastmonthfirstdayUsr);
                    $qry_lastmonth_projUsr = "select timesheet.project_id,sum(hour) hour,sum(min) min,timesheet.bill "
                        . "from timesheet where date_added between '$lastmonthstartUsr' and '$lastmonthendUsr' and user_id = '$row->id' "
                        . " group by timesheet.project_id order by timesheet.date_added desc";
                    $res_lastmonth_projUsr = $this->db->query($qry_lastmonth_projUsr)->getResult();
                    $i6Usr = 1;
                    $lastmonthhhrUsr = 0;
                    $lastmonthminUsr = 0;
                    $lastmonthbill_hrUsr = 0;
                    $lastmonthbill_minUsr = 0;
                    $lastmonthnonbill_hrUsr = 0;
                    $lastmonthnonbill_minUsr = 0;
                    foreach ($res_lastmonth_projUsr as $row_lastmonth_projUsr) {
                        if ($row_lastmonth_projUsr->bill != '1') {
                            $lastmonthbill_hrUsr = $lastmonthbill_hrUsr + $row_lastmonth_projUsr->hour;
                            $lastmonthbill_minUsr = $lastmonthbill_minUsr + $row_lastmonth_projUsr->min;
                        } else {
                            $lastmonthnonbill_hrUsr = $lastmonthnonbill_hrUsr + $row_lastmonth_projUsr->hour;
                            $lastmonthnonbill_minUsr = $lastmonthnonbill_minUsr + $row_lastmonth_projUsr->min;
                        }
                        $i6Usr++;
                    }
                    if ($lastmonthbill_minUsr < 60) {
                        $lastmonthtotbill_hourUsr = $lastmonthbill_hrUsr;
                        $lastmonthtotbill_minuteUsr = $lastmonthbill_minUsr;
                    } else {
                        $lastmonthtotbill_hour_res1Usr = floor($lastmonthbill_minUsr / 60);
                        $lastmonthtotbill_minuteUsr = $lastmonthbill_minUsr % 60;
                        $lastmonthtotbill_hourUsr = $lastmonthbill_hrUsr + $lastmonthtotbill_hour_res1Usr;
                    }
                    if ($lastmonthnonbill_minUsr < 60) {
                        $lastmonthtotnonbill_hourUsr = $lastmonthnonbill_hrUsr;
                        $lastmonthtotnonbill_minuteUsr = $lastmonthnonbill_minUsr;
                    } else {
                        $lastmonthtotnonbill_hour_res1Usr = floor($lastmonthnonbill_minUsr / 60);
                        $lastmonthtotnonbill_minuteUsr = $lastmonthnonbill_minUsr % 60;
                        $lastmonthtotnonbill_hourUsr = $lastmonthnonbill_hrUsr + $lastmonthtotnonbill_hour_res1Usr;
                    }
                    $lastmonthHourBillUsr = $lastmonthtotbill_hourUsr + ($lastmonthtotbill_minuteUsr / 60);
                    $lastmonthMinBillUsr = $lastmonthtotnonbill_hourUsr + ($lastmonthtotnonbill_minuteUsr / 60);
                    $data['lastmonthHourBillUsr']        = $lastmonthHourBillUsr;
                    $data['lastmonthMinBillUsr']        = $lastmonthMinBillUsr;
                    /* user last Month graph */
                    $userGraph[] = [
                        'name'                      => $row->name,
                        'id'                        => $row->id,
                        'type'                      => ($teamdetails) ? $teamdetails->type : '',
                        'deprt_name'                => ($teamdetails) ? $teamdetails->deprt_name : '',
                        'yesterdayMinBill'          => number_format($yesterdayMinBill, 2),
                        'yesterdayHourBill'         => number_format($yesterdayHourBill, 2),
                        'thismonthHourBillUsr'      => number_format($thismonthHourBillUsr, 2),
                        'thismonthMinBillUsr'       => number_format($thismonthMinBillUsr, 2),
                        'lastmonthHourBillUsr'      => number_format($lastmonthHourBillUsr, 2),
                        'lastmonthMinBillUsr'       => number_format($lastmonthMinBillUsr, 2),
                        // 'reports'   => $reports,
                    ];
                    //    pr($userGraph);               
                    //array_push($userGraph,$row->name);

                }
                //  pr($userGraph);  

                /* All user graph */
                $yesterday_date = date('Y-m-d', strtotime("-1 days"));
                $qry_yesterday_proj = "select timesheet.project_id,sum(hour) hour,sum(min) min,timesheet.bill  from timesheet where date_added = '$yesterday_date' group by timesheet.project_id" . " order by timesheet.date_added desc";
                $res_yesterday_proj = $this->db->query($qry_yesterday_proj)->getResult();
                // pr($res_yesterday_proj);                      
                $i4 = 1;
                $ystrdhr = 0;
                $ystrdmin = 0;
                $ystrdbill_hr = 0;
                $ystrdbill_min = 0;
                $ystrdnonbill_hr = 0;
                $ystrdnonbill_min = 0;
                foreach ($res_yesterday_proj as $row_yesterday_proj) {
                    // pr($row_yesterday_proj);
                    if ($row_yesterday_proj->bill != '1') {
                        $ystrdbill_hr = $ystrdbill_hr + $row_yesterday_proj->hour;
                        $ystrdbill_min = $ystrdbill_min + $row_yesterday_proj->min;
                    } else {
                        $ystrdnonbill_hr = $ystrdnonbill_hr + $row_yesterday_proj->hour;
                        $ystrdnonbill_min = $ystrdnonbill_min + $row_yesterday_proj->min;
                    }
                    $i4++;
                }
                if ($ystrdbill_min < 60) {
                    $ystrdtotbill_hour = $ystrdbill_hr;
                    $ystrdtotbill_minute = $ystrdbill_min;
                } else {
                    $ystrdtotbill_hour_res1 = floor($ystrdbill_min / 60);
                    $ystrdtotbill_minute = $ystrdbill_min % 60;
                    $ystrdtotbill_hour = $ystrdbill_hr + $ystrdtotbill_hour_res1;
                }
                if ($ystrdnonbill_min < 60) {
                    $ystrdtotnonbill_hour = $ystrdnonbill_hr;
                    $ystrdtotnonbill_minute = $ystrdnonbill_min;
                } else {
                    $ystrdtotnonbill_hour_res1 = floor($ystrdnonbill_min / 60);
                    $ystrdtotnonbill_minute = $ystrdnonbill_min % 60;
                    $ystrdtotnonbill_hour = $ystrdnonbill_hr + $ystrdtotnonbill_hour_res1;
                }
                $yesterdayAllUserHourBill = $ystrdtotbill_hour + ($ystrdtotbill_minute / 60);
                $yesterdayAllUserMinBill = $ystrdtotnonbill_hour + ($ystrdtotnonbill_minute / 60);
                /* All user graph */

                /* All user Monthly graph */
                $thismonthdayUsr = "";
                $thismonthmonthUsr = "";
                $thismonthyearUsr = "";
                $thismonthtdayUsr = ($thismonthdayUsr == "") ? "01" : $thismonthdayUsr;
                $thismonthtmonthUsr = ($thismonthmonthUsr == "") ? date("m") : $thismonthmonthUsr;
                $thismonthtyearUsr = ($thismonthyearUsr == "") ? date("Y") : $thismonthyearUsr;
                $thismonthmonth_sdUsr = date("Y-m-d", strtotime($thismonthtmonthUsr . '/' . $thismonthtdayUsr . '/' . $thismonthtyearUsr . ' 00:00:00'));
                $thismonthmonth_edUsr = date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime($thismonthtmonthUsr . '/' . $thismonthtdayUsr . '/' . $thismonthtyearUsr . ' 00:00:00'))));
                $thismonthdateUsr = date('Y-m-d');
                $qry_thismonth_projUsr = "select timesheet.project_id,sum(hour) hour,sum(min) min,timesheet.bill "
                    . "from timesheet where date_added between '$thismonthmonth_sdUsr' and '$thismonthdateUsr' "
                    . " group by timesheet.project_id order by timesheet.date_added desc";
                $res_thismonth_projUsr = $this->db->query($qry_thismonth_projUsr)->getResult();
                //pr($res_thismonth_projUsr);
                $i5Usr = 1;
                $thismonthhrUsr = 0;
                $thismonthminUsr = 0;
                $thismonthbill_hrUsr = 0;
                $thismonthbill_minUsr = 0;
                $thismonthnonbill_hrUsr = 0;
                $thismonthnonbill_minUsr = 0;
                foreach ($res_thismonth_projUsr as $row_thismonth_projUsr) {
                    if ($row_thismonth_projUsr->bill != '1') {
                        $thismonthbill_hrUsr = $thismonthbill_hrUsr + $row_thismonth_projUsr->hour;
                        $thismonthbill_minUsr = $thismonthbill_minUsr + $row_thismonth_projUsr->min;
                    } else {
                        $thismonthnonbill_hrUsr = $thismonthnonbill_hrUsr + $row_thismonth_projUsr->hour;
                        $thismonthnonbill_minUsr = $thismonthnonbill_minUsr + $row_thismonth_projUsr->min;
                    }
                    $i5Usr++;
                }
                if ($thismonthbill_minUsr < 60) {
                    $thismonthtotbill_hourUsr = $thismonthbill_hrUsr;
                    $thismonthtotbill_minuteUsr = $thismonthbill_minUsr;
                } else {
                    $thismonthtotbill_hour_res1Usr = floor($thismonthbill_minUsr / 60);
                    $thismonthtotbill_minuteUsr = $thismonthbill_minUsr % 60;
                    $thismonthtotbill_hourUsr = $thismonthbill_hrUsr + $thismonthtotbill_hour_res1Usr;
                }

                if ($thismonthnonbill_minUsr < 60) {
                    $thismonthtotnonbill_hourUsr = $thismonthnonbill_hrUsr;
                    $thismonthtotnonbill_minuteUsr = $thismonthnonbill_minUsr;
                } else {
                    $thismonthtotnonbill_hour_res1Usr = floor($thismonthnonbill_minUsr / 60);
                    $thismonthtotnonbill_minuteUsr = $thismonthnonbill_minUsr % 60;
                    $thismonthtotnonbill_hourUsr = $thismonthnonbill_hrUsr + $thismonthtotnonbill_hour_res1Usr;
                }
                $thismonthAllUserHourBillUsr = $thismonthtotbill_hourUsr + ($thismonthtotbill_minuteUsr / 60);
                $thismonthAllUserMinBillUsr = $thismonthtotnonbill_hourUsr + ($thismonthtotnonbill_minuteUsr / 60);
                $data['thismonthAllUserHourBillUsr']        = $thismonthAllUserHourBillUsr;
                $data['thismonthAllUserMinBillUsr']        = $thismonthAllUserMinBillUsr;
                /* All user Monthly graph */
                /* All user Last Month graph */
                $lastmonththis_yearUsr = date("Y");
                $lastmonththis_monthUsr = date("m");
                if ($lastmonththis_monthUsr == '01' || $lastmonththis_monthUsr == '1') {
                    $lastmonthmonthUsr = 12;
                    $lastmonththis_yearUsr = $lastmonththis_yearUsr - 1;
                } else {
                    $lastmonthmonthUsr = $lastmonththis_monthUsr - 1;
                }
                $lastmonthlastdayUsr = mktime(0, 0, 0, $lastmonthmonthUsr + 1, 0, $lastmonththis_yearUsr);
                $lastmonthfirstdayUsr = mktime(0, 0, 0, $lastmonthmonthUsr, 1, $lastmonththis_yearUsr);
                $lastmonthendUsr = date("Y-m-d", $lastmonthlastdayUsr);
                $lastmonthstartUsr = date("Y-m-d", $lastmonthfirstdayUsr);
                $qry_lastmonth_projUsr = "select timesheet.project_id,sum(hour) hour,sum(min) min,timesheet.bill "
                    . "from timesheet where date_added between '$lastmonthstartUsr' and '$lastmonthendUsr'"
                    . " group by timesheet.project_id order by timesheet.date_added desc";
                $res_lastmonth_projUsr = $this->db->query($qry_lastmonth_projUsr)->getResult();
                $i6Usr = 1;
                $lastmonthhhrUsr = 0;
                $lastmonthminUsr = 0;
                $lastmonthbill_hrUsr = 0;
                $lastmonthbill_minUsr = 0;
                $lastmonthnonbill_hrUsr = 0;
                $lastmonthnonbill_minUsr = 0;
                foreach ($res_lastmonth_projUsr as $row_lastmonth_projUsr) {
                    if ($row_lastmonth_projUsr->bill != '1') {
                        $lastmonthbill_hrUsr = $lastmonthbill_hrUsr + $row_lastmonth_projUsr->hour;
                        $lastmonthbill_minUsr = $lastmonthbill_minUsr + $row_lastmonth_projUsr->min;
                    } else {
                        $lastmonthnonbill_hrUsr = $lastmonthnonbill_hrUsr + $row_lastmonth_projUsr->hour;
                        $lastmonthnonbill_minUsr = $lastmonthnonbill_minUsr + $row_lastmonth_projUsr->min;
                    }
                    $i6Usr++;
                }
                if ($lastmonthbill_minUsr < 60) {
                    $lastmonthtotbill_hourUsr = $lastmonthbill_hrUsr;
                    $lastmonthtotbill_minuteUsr = $lastmonthbill_minUsr;
                } else {
                    $lastmonthtotbill_hour_res1Usr = floor($lastmonthbill_minUsr / 60);
                    $lastmonthtotbill_minuteUsr = $lastmonthbill_minUsr % 60;
                    $lastmonthtotbill_hourUsr = $lastmonthbill_hrUsr + $lastmonthtotbill_hour_res1Usr;
                }
                if ($lastmonthnonbill_minUsr < 60) {
                    $lastmonthtotnonbill_hourUsr = $lastmonthnonbill_hrUsr;
                    $lastmonthtotnonbill_minuteUsr = $lastmonthnonbill_minUsr;
                } else {
                    $lastmonthtotnonbill_hour_res1Usr = floor($lastmonthnonbill_minUsr / 60);
                    $lastmonthtotnonbill_minuteUsr = $lastmonthnonbill_minUsr % 60;
                    $lastmonthtotnonbill_hourUsr = $lastmonthnonbill_hrUsr + $lastmonthtotnonbill_hour_res1Usr;
                }
                $lastmonthAllUserHourBillUsr = $lastmonthtotbill_hourUsr + ($lastmonthtotbill_minuteUsr / 60);
                $lastmonthAllUserMinBillUsr = $lastmonthtotnonbill_hourUsr + ($lastmonthtotnonbill_minuteUsr / 60);
                $data['lastmonthAllUserHourBillUsr']        = $lastmonthAllUserHourBillUsr;
                $data['lastmonthAllUserMinBillUsr']        = $lastmonthAllUserMinBillUsr;
                /* All user last Month graph */

                $AlluserGraph[] = [
                    'yesterdayAllUserHourBill'      => number_format($yesterdayAllUserHourBill, 2),
                    'yesterdayAllUserMinBill'       => number_format($yesterdayAllUserMinBill, 2),
                    'thismonthAllUserHourBillUsr'   => number_format($thismonthAllUserHourBillUsr, 2),
                    'thismonthAllUserMinBillUsr'    => number_format($thismonthAllUserMinBillUsr, 2),
                    'lastmonthAllUserHourBillUsr'   => number_format($lastmonthAllUserHourBillUsr, 2),
                    'lastmonthAllUserMinBillUsr'    => number_format($lastmonthAllUserMinBillUsr, 2),
                ];
                //   pr($AlluserGraph);
            }
            $data['userGraph']         = $userGraph;
            $data['AlluserGraph']         = $AlluserGraph;
        }
        $title                              = 'Dashboard';
        $page_name                          = 'dashboard';
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function Savetask()
    { 
        $added_by                = $this->session->get('user_id');
        $created_at            = date('Y-m-d H:i:s');
        if($this->request->getMethod() == 'post') {  
            $user_id            = $this->request->getPost('employee_id') ?? $this->session->get('user_id');
            $department         = $this->common_model->find_data('team', 'row', ['user_id' => $user_id]);
            $department_id      = $department ? $department->dep_id : 0;            
            $hour              = $this->request->getPost('fhour');
            $min           = $this->request->getPost('fminute');
            $task_assign_time   = $hour . ':' . $min . ':00';

            $project_id         = $this->request->getPost('project_id');
            if ($project_id != 0) {
                $project = $this->common_model->find_data('project', 'row', ['id' => $project_id]);
                $project_status            = $project->status;
                $project_bill           = $project->bill;
            } else {
                $project = 0;
                $project_status = 0;
                $project_bill = 0;
            }   
            // pr($project);

            $is_leave             = $this->request->getPost('status');
            $description        = $this->request->getPost('description');
            $priority           = $this->request->getPost('priority');
            $date_added         = date_format(date_create($this->request->getPost('date')), "Y-m-d");  
            
            if($is_leave == 1){                            
                $postData            = [                   
                    'project_id'        => 0,
                    'status_id'         => 0,
                    'user_id'           => $user_id,
                    'dept_id'           => $department_id,
                    'description'       => "Half Day Leave Taken",
                    'date_added'        => $date_added,
                    'added_by'          => $added_by,
                    'hour'              => 0,
                    'min'               => 0,
                    'bill'              => 1,
                    'work_status_id'    => 6,
                    'priority'          => 3,
                    'next_day_task_action' => 1,
                    'is_leave'          => 1,
                    'created_at'        => $created_at
                ];                            
            } else if($is_leave == 2){                            
                $postData            = [                   
                    'project_id'        => 0,
                    'status_id'         => 0,
                    'user_id'           => $user_id,
                    'dept_id'           => $department_id,
                    'description'       => "Full Day Leave Taken",
                    'date_added'        => $date_added,
                    'added_by'          => $added_by,
                    'hour'              => 0,
                    'min'               => 0,
                    'bill'              => 1,
                    'work_status_id'    => 6,
                    'priority'          => 3,
                    'next_day_task_action' => 1,
                    'is_leave'          => 2,
                    'created_at'        => $created_at
                ];
            } else {
                $postData            = [
                    'project_id'        => $project_id,
                    'status_id'         => $project_status,
                    'user_id'           => $user_id,
                    'dept_id'           => $department_id,
                    'description'       => $description,
                    'date_added'        => $date_added,
                    'added_by'          => $added_by,
                    'hour'              => $hour,
                    'min'               => $min,
                    'bill'              => $project_bill,
                    'priority'          => $priority,
                    'created_at'        => $created_at
                ];
            }              
            $record     = $this->common_model->save_data('morning_meetings', $postData, '', 'id');
        }   
        $this->session->setFlashdata('success_message', 'Task added successfully.');
        return redirect()->to('/admin/dashboard');     
    }

    public function get_task_details() {
        $task_id    = $this->request->getGet('task_id');        

        $task           = $this->common_model->find_data('morning_meetings', 'row', ['id' => $task_id]);
        $project        = $this->common_model->find_data('project', 'row', ['id' => $task->project_id]);
        $order_by[0]    = array('field' => 'name', 'type' => 'ASC');
        $projects       = $this->common_model->find_data('project', 'array', ['status!=' => '13'], 'id,name,status','', '', $order_by);
        $effort_type    = $this->common_model->find_data('effort_type', 'array', ['status=' => '1'], 'id,name,status','', '', $order_by);
        $work_status    = $this->common_model->find_data('work_status', 'array', ['is_schedule=' => '1'], '','', '', $order_by);
        // pr($task);
        $html = '<form action="' . base_url('admin/save-effort') . '" method="POST">  
                    <input type="hidden" name="task_id" value="'.$task->id.'">          
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Effort Booking</h5>                  
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">                                              
                            <div class="mb-3">
                                <label for="project_id" class="form-label">Select Project</label>
                                <select name="project_id" id="project_id" class="form-select" readonly>
                                    <option value="">Select Project</option>';                                                                      
                                    foreach ($projects as $project){
                                        $selected_project = ($project->id == $task->project_id) ? 'selected' : '';
                                        $html .= '<option value="'.$project->id.'" '.$selected_project.'> '.$project->name.'</option>';
                                    }                                    
                                $html .='</select>
                            </div>                                                                                                         
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date" class="form-control" value="'.$task->date_added.'" readonly>
                            </div>
                            
                            <div class="row mb-3">
                            <div class="col">
                                    <label for="fhour" class="form-label">Hour</label>
                                    <select name="fhour" id="fhour" class="form-select">
                                    <option value="">Select Hour</option>';
                                    for ($i = 0; $i <= 8; $i++){
                                    $selected_hour = ($i == $task->hour) ? 'selected' : '';
                                    $html .= '<option value="' . $i . '" ' . $selected_hour . '>'.$i.'</option>';
                                    }
                                    $html .='</select>
                                </div>
                                <div class="col">
                                    <label for="fminute" class="form-label">Minute</label>
                                    <select name="fminute" id="fminute" class="form-select">
                                    <option value="">Select Minute</option>';
                                    for ($i = 0; $i <= 45; $i+= 15){
                                    $selected_minute = ($i == $task->min) ? 'selected' : '';
                                    $html .='<option value="' . $i . '" ' . $selected_minute . '>'.$i.'</option>';
                                    }
                                    $html .='</select>
                                </div>
                            </div>

                            <!-- Effort type -->
                            <div class="mb-3">
                                <label for="effort_type_id" class="form-label">Effort Type</label>
                                <select name="effort_type_id" id="effort_type_id" class="form-select select2" required>
                                    <option value="">Select Effort Type</option>';
                                    foreach ($effort_type as $effort){
                                    $html .='<option value="'. $effort->id .'">'. $effort->name .'</option>';
                                    }
                                $html .='</select>
                            </div> 
                                    
                            <!-- Work status -->
                            <div class="mb-3">
                                <label for="work_status_id" class="form-label">Work Status</label>
                                <select name="work_status_id" id="work_status_id" class="form-select select2" required>
                                    <option value="">Select Work Status</option>';
                                    foreach ($work_status as $work){
                                    $html .='<option value="'. $work->id .'">'. $work->name .'</option>';
                                    }
                                $html .='</select>
                            </div> 
                            
                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3">'.$task->description.'</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>';        
        echo $html;
    }


    public function SaveEffort()
    {          
        $uId                = $this->session->get('user_id');
        $taskId = $this->request->getPost('task_id');
        $requestData = $this->request->getPost();        
        $getUser       = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
        $task_details = $this->common_model->find_data('morning_meetings', 'row', ['id' => $taskId]);
        
        $user_cost                  = $getUser->hour_cost;
        $cal_usercost               = ($user_cost/60);

        $department                = $this->common_model->find_data('team', 'row', ['user_id' => $uId]);
        $project_id                = $requestData['project_id'];                
        $project                   = $this->common_model->find_data('project', 'row', ['id' => $project_id]);
        $project_status            = $project->status;
        $project_bill              = $project->bill;                                 
        $user_id                   = $requestData['user_id'] ?? $uId; // Default to current user if not provided
        $department_id             = $department ? $department->dep_id : 0;                    
        $description               = $requestData['description'];                
        $date_added                = date_format(date_create($requestData['date']), "Y-m-d");
        $hour                      = $requestData['fhour'];
        $min                       = $requestData['fminute'];                
        $created_at                = date('Y-m-d H:i:s');
        $effort_type_id            = $requestData['effort_type_id'];
        $work_status_id            = $requestData['work_status_id'];      
        $schedule_id               = $requestData['task_id'];

        $cal                    = (($hour*60) + $min); //converted to minutes
        $projectCost            = floatval($cal_usercost * $cal);

        if ($task_details) {                                        
            $postData            = [
                'project_id'        => $project_id,                        
                'status_id'         => $project_status,
                'user_id'           => $user_id,                            
                'description'       => $description,                            
                'hour'              => $hour,
                'min'               => $min,
                'effort_type'       => $effort_type_id,
                'work_status_id'    => $work_status_id,
                'date_added'        => $date_added,                                                                 
                'bill'              => $project_bill,
                'assigned_task_id'  => $requestData['task_id'],                            
                'date_today'        => $created_at,
                'hour_rate'         => $user_cost,
                'cost'              => number_format($projectCost, 2, '.', ''),
            ];
            $effort_id = $this->common_model->save_data('timesheet', $postData, '', 'id');
            $fields                     = [                    
            'effort_type'       => $effort_type_id,
            'work_status_id'    => $work_status_id,
            'effort_id'         => $effort_id,
            'updated_at'        => date('Y-m-d H:i:s'),
        ];
        $this->common_model->save_data('morning_meetings', $fields, $schedule_id, 'id');
        } else{
            //backdate task effort addition
            $today = date('Y-m-d');
            if ($date_added < $today) {
                $postData            = [
                    'project_id'        => $project_id,
                    'dept_id'           => $department_id,
                    'status_id'         => $project_status,
                    'user_id'           => $user_id,                            
                    'description'       => "Not Booked Task",                            
                    'hour'              => 0,
                    'min'               => 0,
                    'effort_type'       => $effort_type_id,
                    'work_status_id'    => $work_status_id,
                    'date_added'        => $date_added,  
                    'added_by'          => $uId,                          
                    'bill'              => $project_bill,  
                    'created_at'        => $created_at,
                    'updated_at'        => $created_at
                ]; 
                $schedule_id = $this->common_model->save_data('morning_meetings', $postData, '', 'id');  
                $field            = [
                    'project_id'        => $project_id,                        
                    'status_id'         => $project_status,
                    'user_id'           => $user_id,                            
                    'description'       => $description,                            
                    'hour'              => $hour,
                    'min'               => $min,
                    'effort_type'       => $effort_type_id,
                    'work_status_id'    => $work_status_id,
                    'date_added'        => $date_added,                                                                 
                    'bill'              => $project_bill,
                    'assigned_task_id'  => $schedule_id,                            
                    'date_today'        => $created_at,
                    'hour_rate'         => $user_cost,
                    'cost'              => number_format($projectCost, 2, '.', ''),
                ];
                $this->common_model->save_data('timesheet', $field, '', 'id');
            }                                        
        }

        //ptoject cost calculation
        $year                   = date('Y', strtotime($date_added)); // 2024
        $month                  = date('m', strtotime($date_added)); // 08
        $projectcost            = "SELECT SUM(cost) AS total_hours_worked FROM `timesheet` WHERE `date_added` LIKE '%".$year . "-" . $month ."%' and project_id=".$project_id."";
        $rows                   = $this->db->query($projectcost)->getResult(); 
        foreach($rows as $row){
            $project_cost       =  $row->total_hours_worked;
        }  
        $exsistingProjectCost   = $this->common_model->find_data('project_cost', 'row', ['project_id' => $project_id, 'created_at LIKE' => '%'.$year . '-' . $month .'%']);
        if(!$exsistingProjectCost){
            $postData2   = array(
                'project_id'            => $project_id,
                'month'                 => $month ,
                'year'                  => $year,
                'project_cost'          => $project_cost,
                'created_at'            => date('Y-m-d H:i:s'),                                
            );                                  
            $project_cost_id             = $this->common_model->save_data('project_cost', $postData2, '', 'id');
        } else {
            $id         = $exsistingProjectCost->id;
            $postData2   = array(
                'project_id'            => $project_id,
                'month'                 => $month ,
                'year'                  => $year,
                'project_cost'          => $project_cost,
                'updated_at'            => date('Y-m-d H:i:s'),                                
            );                                    
            $update_project_cost_id      = $this->common_model->save_data('project_cost', $postData2, $id, 'id');
        } 
        // project cost calculation end
        
        // Finish & Assign tomorrow
        $getWorkStatus  = $this->common_model->find_data('work_status', 'row', ['id' => $work_status_id], 'is_reassign');
        if($getWorkStatus){
            if($getWorkStatus->is_reassign){
                /* next working data calculate */
                    // for($c=1;$c<=7;$c++){
                        // echo $date_added1 = date('Y-m-d', strtotime("+1 days"));
                        $date_added1 = date('Y-m-d', strtotime($date_added . ' +1 day'));
                        if($this->calculateNextWorkingDate($date_added1)){
                            $next_working_day = $date_added1;
                        } else {
                            // echo 'not working day';
                            $date_added2 = date('Y-m-d', strtotime($date_added . "+2 days"));
                            if($this->calculateNextWorkingDate($date_added2)){
                                $next_working_day = $date_added2;
                            } else {
                                $date_added3 = date('Y-m-d', strtotime($date_added . "+3 days"));
                                if($this->calculateNextWorkingDate($date_added3)){
                                    $next_working_day = $date_added3;
                                } else {
                                    $date_added4 = date('Y-m-d', strtotime($date_added . "+4 days"));
                                    if($this->calculateNextWorkingDate($date_added4)){
                                        $next_working_day = $date_added4;
                                    } else {
                                        $date_added5 = date('Y-m-d', strtotime($date_added . "+5 days"));
                                        if($this->calculateNextWorkingDate($date_added5)){
                                            $next_working_day = $date_added5;
                                        } else {
                                            $date_added6 = date('Y-m-d', strtotime($date_added . "+6 days"));
                                            if($this->calculateNextWorkingDate($date_added6)){
                                                $next_working_day = $date_added6;
                                            } else {
                                                $date_added7 = date('Y-m-d', strtotime($date_added . "+7 days"));
                                                if($this->calculateNextWorkingDate($date_added7)){
                                                    $next_working_day = $date_added7;
                                                } else {
                                                    $next_working_day = $date_added7;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            
                        }
                    // }
                    // echo $next_working_day;
                    // die;
                /* next working data calculate */
                $morningScheduleData2 = [
                    'dept_id'               => $department_id,
                    'project_id'            => $project_id,
                    'status_id'             => $project_status,
                    'user_id'               => $user_id,
                    'description'           => $description,
                    'hour'                  => $hour,
                    'min'                   => $min,
                    'work_home'             => 0,
                    'effort_type'           => 0,
                    'date_added'            => $next_working_day,
                    'added_by'              => $uId,
                    'bill'                  => $project_bill,
                    'work_status_id'        => 0,
                    'priority'              => 3,
                    'effort_id'             => 0,
                    'created_at'            => $next_working_day.' 10:01:00',
                    'updated_at'            => $next_working_day.' 10:01:00',
                ];
                // pr($morningScheduleData2);
                $this->common_model->save_data('morning_meetings', $morningScheduleData2, '', 'id');
            }
        }
        // Finish & Assign tomorrow end

    }

    public function calculateNextWorkingDate($givenDate){
        // echo $givenDate;
        $checkHoliday = $this->common_model->find_data('event', 'count', ['start_event' => $givenDate]);
        if($checkHoliday > 0){
            return true;
        } else {
            $applicationSetting = $this->common_model->find_data('application_settings', 'row');
            $dayOfWeek = date("l", strtotime($givenDate));
            if($dayOfWeek == 'Sunday'){
                $dayNo          = 7;
                $fieldName      = 'sunday';
                $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
            } elseif($dayOfWeek == 'Monday'){
                $dayNo          = 1;
                $fieldName      = 'monday';
                $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
            } elseif($dayOfWeek == 'Tuesday'){
                $dayNo          = 2;
                $fieldName      = 'monday';
                $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
            } elseif($dayOfWeek == 'Wednesday'){
                $dayNo          = 3;
                $fieldName      = 'monday';
                $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
            } elseif($dayOfWeek == 'Thursday'){
                $dayNo          = 4;
                $fieldName      = 'thursday';
                $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
            } elseif($dayOfWeek == 'Friday'){
                $dayNo          = 5;
                $fieldName      = 'friday';
                $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
            } elseif($dayOfWeek == 'Saturday'){
                $dayNo          = 6;
                $fieldName      = 'satarday';
                $getDayCount    = $this->getDayCountInMonth($givenDate, $dayNo);
            }
            // echo $getDayCount;
            $fieldArray = json_decode($applicationSetting->$fieldName);
            // pr($fieldArray,0);
            if(in_array($getDayCount, $fieldArray)){
                return false;
            } else {
                return true;
            }
        }
    }
    public function getDayCountInMonth($givenDate, $dayNo){
        $date = $givenDate; // Example date
        // $date = "2024-08-24"; // Example date

        // Get the day of the month
        $dayOfMonth = date("j", strtotime($date));

        // Get the month and year from the date
        $month = date("m", strtotime($date));
        $year = date("Y", strtotime($date));

        // Initialize the counter for Saturdays
        $saturdayCount = 0;

        for ($day = 1; $day <= $dayOfMonth; $day++) {
            // Create a date string for each day of the month
            $currentDate = "$year-$month-$day";
            // echo date("N", strtotime('2024-08-25')).'<br>';
            // Check if the current date is a Saturday
            if (date("N", strtotime($currentDate)) == $dayNo) {
                $saturdayCount++;
            }
        }

        // Check if the provided date is a Saturday and count it
        if (date("N", strtotime($date)) == $dayNo) {
            // echo "The date $date is the $saturdayCount" . "th Saturday of the month.";
            return $saturdayCount;
        } else {
            // echo "The date $date is not a Saturday.";
            return 0;
        }
    }

    /* day-wise modal list */
    public function dayWiseListRecords()
    {
        $userId         = $this->request->getGet('userId');
        $name           = $this->request->getGet('name');
        $date           = $this->request->getGet('date');
        $effort_time    = $this->request->getGet('effort_time');

        $dateFormate = date_create($date);
        if ($dateFormate) {
            $formattedDate = date_format($dateFormate, 'Y-m-d');
        }
        $sql = "SELECT
                        timesheet.*,
                        project.name AS projectName,
                        effort_type.name AS effortName
                    FROM
                        timesheet
                    LEFT JOIN
                        project ON timesheet.project_id = project.id
                    LEFT JOIN
                        effort_type ON timesheet.effort_type = effort_type.id
                    WHERE
                        timesheet.user_id = $userId 
                    AND timesheet.date_added = '$formattedDate'";

        $rows = $this->db->query($sql)->getResult();
        $html = '<div class="modal-header" style="justify-content: center;">
                        <center><h6 class="modal-title">List of Efforts of  <b><u> ' . $name . ' </b></u> on <b><u> ' . $date . ' </b></u></h6></center>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="table-responsive table-card">
                                <table class="table general_table_style">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Project</th>
                                            <th>Work Date</th>
                                            <th>Time</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        if (!empty($rows)) {
            $sl = 1;
            foreach ($rows as $record) {
                $html .= '<tr>
                                <td>' . $sl++ . '</td>
                                <td>' . esc($record->projectName) . '</td>
                                <td>' . esc($record->date_added) . '</td>
                                <td>' . esc($record->hour) . ':' . esc($record->min) . '</td>
                                <td>' . esc($record->description) . '</td>
                                <td>' . esc($record->effortName) . '</td>
                            </tr>';
            }
        } else {
            $html .= '<tr>
                            <td colspan="6">No records found for the selected date.</td>
                          </tr>';
        }
        $html .= '</tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-center"><b>On ' . $date . ', ' . $name . ' work total of ' . $effort_time . ' hours</b></td>
                                </tr>
                            </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>';
        echo $html;
    }
    /* day-wise modal list */

    /* day-wise modal punchin list */
    public function PunchInRecords()
    {
        $userId         = $this->request->getGet('userId');
        $name           = $this->request->getGet('name');
        $date           = $this->request->getGet('date');
        $punchIn        = $this->request->getGet('punchIn');
        $punchOut       = $this->request->getGet('punchOut');

        // pr($this->request->getGet());

        $dateFormate = date_create($date);
        if ($dateFormate) {
            $formattedDate = date_format($dateFormate, 'Y-m-d');
        }
        $sql = "SELECT attendances.user_id, attendances.punch_date, attendances.punch_in_time, attendances.punch_in_address, attendances.punch_in_image, attendances.punch_out_time, attendances.punch_out_address, attendances.punch_out_image, user.name FROM `attendances`
                    INNER JOIN user WHERE attendances.user_id = user.id and user_id = $userId AND punch_date = '$formattedDate'";

        $rows = $this->db->query($sql)->getResult();
        //  echo $this->db->getLastquery();die;
        $html = '<div class="modal-header" style="justify-content: center;">
                        <center><h6 class="modal-title">Attendance of  <b> ' . $name . ' </b> on <b> ' . $date . ' </b></h6></center>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="table-responsive table-card">
                                <table class="table general_table_style">
                                    <thead>
                                        <tr>                                            
                                            <th>Image</th>                                                                                       
                                            <th>Punch Time(IN-OUT)</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        if (!empty($rows)) {
            $sl = 1;
            foreach ($rows as $record) {
                $html .= '<tr>
                                <td>
                                    <img src="' . getenv('app.uploadsURL') . 'user/' . esc($record->punch_in_image) . '" alt="' . esc($record->user_id) . '" class="rounded-circle punch-img">
                                </td>                                                                
                                <td><b>IN:</b> ' . esc($record->punch_in_time) . '</td>
                                <td>' . esc($record->punch_in_address) . '</td>
                            </tr> ';
                if ($record->punch_out_address != '') {
                    $html .= '<tr>
                                    <td>
                                        <img src="' . getenv('app.uploadsURL') . 'user/' . esc($record->punch_out_image) . '" alt="' . esc($record->user_id) . '" class="rounded-circle punch-img">
                                    </td>                                                                
                                    <td><b>OUT:</b> ' . esc($record->punch_out_time) . '</td>
                                    <td>' . esc($record->punch_out_address) . '</td>
                                </tr>';
                }
            }
        } else {
            $html .= '<tr>
                            <td colspan="6">No records found for the selected date.</td>
                          </tr>';
        }
        $html .= '</tbody>                            
                        </table>
                    </div>
                </div>
            </div>';
        echo $html;
    }
    /* day-wise modal punchin list */

    /* day-wise modal punchout list */
    public function PunchOutRecords()
    {
        $userId         = $this->request->getGet('userId');
        $name           = $this->request->getGet('name');
        $date           = $this->request->getGet('date');
        $punchIn        = $this->request->getGet('punchOut');

        $dateFormate = date_create($date);
        if ($dateFormate) {
            $formattedDate = date_format($dateFormate, 'Y-m-d');
        }
        $sql = "SELECT attendances.user_id, attendances.punch_date, attendances.punch_out_time, attendances.punch_out_address, attendances.punch_out_image, user.name FROM `attendances`
                    INNER JOIN user WHERE attendances.user_id = user.id and user_id = $userId AND punch_date = '$formattedDate'";

        $rows = $this->db->query($sql)->getResult();
        $html = '<div class="modal-header" style="justify-content: center;">
                        <center><h6 class="modal-title">Attendance of  <b><u> ' . $name . ' </b></u> on <b><u> ' . $date . ' </b></u></h6></center>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="table-responsive">
                                <table class="table general_table_style table-bordered">
                                    <thead>
                                        <tr>                                            
                                            <th>Image</th>
                                            <th>User Name</th>
                                            <th>Punch Date</th>
                                            <th>Punch in Time</th>
                                            <th>Punch in Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        if (!empty($rows)) {
            $sl = 1;
            foreach ($rows as $record) {
                $html .= '<tr>
                                <td>
                                    <img src="' . getenv('app.uploadsURL') . 'user/' . esc($record->punch_out_image) . '" alt="' . esc($record->user_id) . '" class="rounded-circle">
                                </td>
                                <td>' . esc($record->name) . '</td>
                                <td>' . esc($record->punch_date) . '</td>
                                <td>' . esc($record->punch_out_time) . '</td>
                                <td>' . esc($record->punch_out_address) . '</td>
                            </tr>';
            }
        } else {
            $html .= '<tr>
                            <td colspan="6">No records found for the selected date.</td>
                          </tr>';
        }
        $html .= '</tbody>                            
                        </table>
                    </div>
                </div>
            </div>';
        echo $html;
    }
    /* day-wise modal punchout list */

    public function getLastNDays($days, $format = 'd/m')
    {
        $m = date("m");
        $de = date("d");
        $y = date("Y");
        $dateArray = array();
        for ($i = 0; $i <= $days - 1; $i++) {
            $dateArray[] = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
        }
        return array_reverse($dateArray);
    }
    /* dashboard */
    /* settings */
    public function settings()
    {
        if (!$this->session->get('is_admin_login')) {
            return redirect()->to('/admin');
        }
        $title                  = 'Settings';
        $page_name              = 'settings';
        $user_id                = $this->session->get('user_id');
        $data['admin']          = $this->common_model->find_data('user', 'row', ['id' => $user_id]);
        $data['setting']        = $this->common_model->find_data('general_settings', 'row', ['id' => 1]);
        $data['application_setting']        = $this->common_model->find_data('application_settings', 'row', ['id' => 1]);
        $data['amc_setting']    = $this->common_model->find_data('setting', 'row', ['id' => 1]);
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function profileSetting()
    {
        $user_id                = $this->session->get('user_id');
        $user_type              = $this->session->get('user_type');

        if ($user_type != 'CLIENT') {
            /* profile image */
            $file = $this->request->getFile('image');
            $originalName = $file->getClientName();
            $fieldName = 'image';
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'user', 'image');
                if ($upload_array['status']) {
                    $profile_image = $upload_array['newFilename'];
                } else {
                    $this->session->setFlashdata('error_message', $upload_array['message']);
                    return redirect()->to('/admin/settings');
                }
            } else {
                $site_setting = $this->common_model->find_data('user', 'row');
                $profile_image = $site_setting->profile_image;
            }
            /* profile image */
            $fields = [
                'name'              => $this->request->getPost('name'),
                'email'             => $this->request->getPost('email'),
                'phone1'            => $this->request->getPost('phone1'),
                'phone2'            => $this->request->getPost('phone2'),
                'hour_cost'         => $this->request->getPost('hour_cost'),
                'dob'               => $this->request->getPost('dob'),
                'doj'               => $this->request->getPost('doj'),
                'profile_image'     => $profile_image,
            ];
            $this->common_model->save_data('user', $fields, $user_id, 'id');
        } else {
            $fields = [
                'name'              => $this->pro->encrypt($this->request->getPost('name')),
                'email_1'             => $this->pro->encrypt($this->request->getPost('email_1')),
                'email_2'             => $this->pro->encrypt($this->request->getPost('email_2')),
                'phone_1'            => $this->pro->encrypt($this->request->getPost('phone_1')),
                'phone_2'            => $this->pro->encrypt($this->request->getPost('phone_2')),
                // 'profile_image'     => $profile_image,
            ];
            $this->common_model->save_data('client', $fields, $user_id, 'id');
        }

        $this->session->setFlashdata('success_message', 'Profile Settings Updated Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    public function generalSetting()
    {
        $user_id                = $this->session->get('user_id');
        /* logo */
        $file = $this->request->getFile('site_logo');
        $originalName = $file->getClientName();
        $fieldName = 'site_logo';
        if ($file != '') {
            $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, '', 'image');
            if ($upload_array['status']) {
                $site_logo = $upload_array['newFilename'];
            } else {
                $this->session->setFlashdata('error_message', $upload_array['message']);
                return redirect()->to('/admin/settings');
            }
        } else {
            $site_setting   = $this->common_model->find_data('general_settings', 'row');
            $site_logo      = $site_setting->site_logo;
        }
        /* logo */
        /* footer logo */
        $file = $this->request->getFile('site_footer_logo');
        $originalName = $file->getClientName();
        $fieldName = 'site_footer_logo';
        if ($file != '') {
            $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, '', 'image');
            if ($upload_array['status']) {
                $site_footer_logo = $upload_array['newFilename'];
            } else {
                $this->session->setFlashdata('error_message', $upload_array['message']);
                return redirect()->to('/admin/settings');
            }
        } else {
            $site_setting           = $this->common_model->find_data('general_settings', 'row');
            $site_footer_logo       = $site_setting->site_footer_logo;
        }
        /* footer logo */
        /* favicon */
        $file = $this->request->getFile('site_favicon');
        $originalName = $file->getClientName();
        $fieldName = 'site_favicon';
        if ($file != '') {
            $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, '', 'image');
            if ($upload_array['status']) {
                $site_favicon = $upload_array['newFilename'];
            } else {
                $this->session->setFlashdata('error_message', $upload_array['message']);
                return redirect()->to('/admin/settings');
            }
        } else {
            $site_setting           = $this->common_model->find_data('general_settings', 'row');
            $site_favicon       = $site_setting->site_favicon;
        }
        /* favicon */
        $fields = [
            'company_name'                  => $this->request->getPost('company_name'),
            'site_name'                     => $this->request->getPost('site_name'),
            'site_phone'                    => $this->request->getPost('site_phone'),
            'site_mail'                     => $this->request->getPost('site_mail'),
            'system_email'                  => $this->request->getPost('system_email'),
            // 'site_url'                      => $this->request->getPost('site_url'),
            'description'                   => $this->request->getPost('description'),
            'copyright_statement'           => $this->request->getPost('copyright_statement'),
            'google_map_api_code'           => $this->request->getPost('google_map_api_code'),
            'google_analytics_code'         => $this->request->getPost('google_analytics_code'),
            'google_pixel_code'             => $this->request->getPost('google_pixel_code'),
            'facebook_tracking_code'        => $this->request->getPost('facebook_tracking_code'),
            'gst_api_code'                  => $this->request->getPost('gst_api_code'),
            'firebase_server_key'           => $this->request->getPost('firebase_server_key'),
            'theme_color'                   => $this->request->getPost('theme_color'),
            'font_color'                    => $this->request->getPost('font_color'),
            'twitter_profile'               => $this->request->getPost('twitter_profile'),
            'facebook_profile'              => $this->request->getPost('facebook_profile'),
            'instagram_profile'             => $this->request->getPost('instagram_profile'),
            'linkedin_profile'              => $this->request->getPost('linkedin_profile'),
            'youtube_profile'               => $this->request->getPost('youtube_profile'),
            'site_logo'                     => $site_logo,
            'site_footer_logo'              => $site_footer_logo,
            'site_favicon'                  => $site_favicon,
        ];
        $this->common_model->save_data('general_settings', $fields, 1, 'id');
        $this->session->setFlashdata('success_message', 'General Settings Updated Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    public function applicationSetting()
    {
        $user_id                = $this->session->get('user_id');
        $yes_no                 = isset($_POST['is_desklog_use']) ? $_POST['is_desklog_use'] : 0;
        $approval               = isset($_POST['is_task_approval']) ? $_POST['is_task_approval'] : 0;
        $project_cost           = isset($_POST['is_project_cost']) ? $_POST['is_project_cost'] : 0;
        //  pr($this->request->getpost());
        $sundaySelections       = isset($_POST['sunday']) ? $_POST['sunday'] : [];
        $mondaySelections       = isset($_POST['monday']) ? $_POST['monday'] : [];
        $tuesdaySelections      = isset($_POST['tuesday']) ? $_POST['tuesday'] : [];
        $wednesdaySelections    = isset($_POST['wednesday']) ? $_POST['wednesday'] : [];
        $thursdaySelections     = isset($_POST['thursday']) ? $_POST['thursday'] : [];
        $fridaySelections       = isset($_POST['friday']) ? $_POST['friday'] : [];
        $satardaySelections     = isset($_POST['satarday']) ? $_POST['satarday'] : [];
        // pr($satardaySelections);
        $sundayJson             = json_encode($sundaySelections);
        $mondayJson             = json_encode($mondaySelections);
        $tuesdayJson            = json_encode($tuesdaySelections);
        $wednesdayJson          = json_encode($wednesdaySelections);
        $thursdayJson           = json_encode($thursdaySelections);
        $fridayJson             = json_encode($fridaySelections);
        $satardayJson           = json_encode($satardaySelections);
        //  pr($sundayJson);

        $fields = [
            'theme_color'                       => $this->request->getPost('theme_color'),
            'font_color'                        => $this->request->getPost('font_color'),
            'tomorrow_task_editing_time'        => $this->request->getPost('tomorrow_task_editing_time'),
            'block_tracker_fillup_after_days'   => $this->request->getPost('block_tracker_fillup_after_days'),
            'api_url'                           => $this->request->getPost('api_url'),
            'api_key'                           => $this->request->getPost('api_key'),
            'is_desklog_use'                    => $yes_no,
            'is_task_approval'                  => $approval,
            'is_project_cost'                   => $project_cost,
            'encryption_api_secret_key'         => $this->request->getPost('encryption_api_secret_key'),
            'encryption_api_secret_iv'          => $this->request->getPost('encryption_api_secret_iv'),
            'encryption_api_encrypt_method'     => $this->request->getPost('encryption_api_encrypt_method'),
            'google_map_api_code'               => $this->request->getPost('google_map_api_code'),
            'allow_punch_distance'              => $this->request->getPost('allow_punch_distance'),
            'current_date_tasks_show_in_effort' => $this->request->getPost('current_date_tasks_show_in_effort'),
            'monthly_minimum_effort_time'       => $this->request->getPost('monthly_minimum_effort_time'),
            'daily_minimum_effort_time'         => $this->request->getPost('daily_minimum_effort_time'),
            'mark_later_after'                  => date_format(date_create($this->request->getPost('mark_later_after')), "H:i:s"),
            'currency'                          => $this->request->getPost('currency'),
            'edit_time_after_task_add'          => $this->request->getPost('edit_time_after_task_add'),
            'sunday'                            => $sundayJson,
            'monday'                            => $mondayJson,
            'tuesday'                           => $tuesdayJson,
            'wednesday'                         => $wednesdayJson,
            'thursday'                          => $thursdayJson,
            'friday'                            => $fridayJson,
            'satarday'                          => $satardayJson,
        ];
        $fields2 = [
            'check_span' => $this->request->getpost('amc_checking_after_days')
        ];
        //    pr($fields);
        $this->common_model->save_data('application_settings', $fields, 1, 'id');
        $this->common_model->save_data('setting', $fields2, 1, 'id');
        $this->session->setFlashdata('success_message', 'Application Settings Updated Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    public function changePassword()
    {
        $user_id                = $this->session->get('user_id');
        $profile                = $this->common_model->find_data('user', 'row', ['id' => $user_id]);
        $old_password           = $this->request->getPost('old_password');
        $new_password           = $this->request->getPost('new_password');
        $confirm_password       = $this->request->getPost('confirm_password');
        if ($new_password == $confirm_password) {
            if (md5($old_password) == $profile->password) {
                if ($profile->password != md5($new_password)) {
                    $fields = [
                        'password'                      => md5($this->request->getPost('new_password'))
                    ];
                    $this->common_model->save_data('user', $fields, $user_id, 'id');

                    /* email sent */
                    $mailData   = [
                        'name'      => $profile->name,
                        'email'     => $profile->email,
                        'password'  => $new_password,
                    ];
                    $general_settings           = $this->common_model->find_data('general_settings', 'row');
                    $to         = $profile->email;
                    $subject    = $general_settings->site_name . " :: Change Password";
                    $message    = view('email-templates/change-password', $mailData);
                    // echo $message;die;
                    $this->sendMail($to, $subject, $message);
                    /* email sent */
                    /* email log save */
                    $emailLogData = [
                        'name'      => $profile->name,
                        'email'     => $profile->email,
                        'subject'   => $subject,
                        'message'   => $message,
                    ];
                    $this->common_model->save_data('email_logs', $emailLogData, '', 'id');
                    /* email log save */

                    $this->session->setFlashdata('success_message', 'Password Updated Successfully !!!');
                    return redirect()->to('/admin/settings');
                } else {
                    $this->session->setFlashdata('error_message', 'New & Old Password Should Not Be Same !!!');
                    return redirect()->to('/admin/settings');
                }
            } else {
                $this->session->setFlashdata('error_message', 'Old Password Mismatched !!!');
                return redirect()->to('/admin/settings');
            }
        } else {
            $this->session->setFlashdata('error_message', 'New & Confirm Password Mismatched !!!');
            return redirect()->to('/admin/settings');
        }
    }
    public function emailSetting()
    {
        $user_id                = $this->session->get('user_id');
        $fields = [
            'from_email'                => $this->request->getPost('from_email'),
            'from_name'                 => $this->request->getPost('from_name'),
            'smtp_host'                 => $this->request->getPost('smtp_host'),
            'smtp_username'             => $this->request->getPost('smtp_username'),
            'smtp_password'             => $this->request->getPost('smtp_password'),
            'smtp_port'                 => $this->request->getPost('smtp_port'),
        ];
        $this->common_model->save_data('general_settings', $fields, 1, 'id');
        $this->session->setFlashdata('success_message', 'Email Settings Updated Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    public function smsSetting()
    {
        $user_id                = $this->session->get('user_id');
        $fields = [
            'sms_authentication_key'        => $this->request->getPost('sms_authentication_key'),
            'sms_sender_id'                 => $this->request->getPost('sms_sender_id'),
            'sms_base_url'                  => $this->request->getPost('sms_base_url'),
        ];
        $this->common_model->save_data('general_settings', $fields, 1, 'id');
        $this->session->setFlashdata('success_message', 'SMS Settings Updated Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    public function footerSetting()
    {
        $user_id                = $this->session->get('user_id');
        // pr($this->request->getPost());
        $footer_text            = $this->request->getPost('footer_text');
        $footer_link_name       = $this->request->getPost('footer_link_name');
        $footer_link            = $this->request->getPost('footer_link');
        $footer_link_name2      = $this->request->getPost('footer_link_name2');
        $footer_link2           = $this->request->getPost('footer_link2');
        $footer_link_name3      = $this->request->getPost('footer_link_name3');
        $footer_link3           = $this->request->getPost('footer_link3');
        $fields = [
            'footer_text'                       => $footer_text,
            'footer_link_name'                  => json_encode(array_filter($footer_link_name)),
            'footer_link'                       => json_encode(array_filter($footer_link)),
            'footer_link_name2'                 => json_encode(array_filter($footer_link_name2)),
            'footer_link2'                      => json_encode(array_filter($footer_link2)),
            'footer_link_name3'                 => json_encode(array_filter($footer_link_name3)),
            'footer_link3'                      => json_encode(array_filter($footer_link3)),
        ];
        // pr($fields);
        $this->common_model->save_data('general_settings', $fields, 1, 'id');
        $this->session->setFlashdata('success_message', 'Footer Settings Updated Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    public function seoSetting()
    {
        $user_id                = $this->session->get('user_id');
        $fields = [
            'meta_title'                        => $this->request->getPost('meta_title'),
            'meta_description'                  => $this->request->getPost('meta_description'),
            'meta_keywords'                     => $this->request->getPost('meta_keywords'),
        ];
        $this->common_model->save_data('general_settings', $fields, 1, 'id');
        $this->session->setFlashdata('success_message', 'SEO Settings Updated Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    public function paymentSetting()
    {
        $user_id                = $this->session->get('user_id');
        $fields = [
            'stripe_payment_type'               => $this->request->getPost('stripe_payment_type'),
            'stripe_sandbox_sk'                 => $this->request->getPost('stripe_sandbox_sk'),
            'stripe_sandbox_pk'                 => $this->request->getPost('stripe_sandbox_pk'),
            'stripe_live_sk'                    => $this->request->getPost('stripe_live_sk'),
            'stripe_live_pk'                    => $this->request->getPost('stripe_live_pk'),
        ];
        $this->common_model->save_data('general_settings', $fields, 1, 'id');
        $this->session->setFlashdata('success_message', 'Payment Settings Updated Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    public function bankSetting()
    {
        $user_id                = $this->session->get('user_id');
        $fields = [
            'bank_name'                     => $this->request->getPost('bank_name'),
            'branch_name'                   => $this->request->getPost('branch_name'),
            'acc_no'                        => $this->request->getPost('acc_no'),
            'ifsc_code'                     => $this->request->getPost('ifsc_code'),
        ];
        $this->common_model->save_data('general_settings', $fields, 1, 'id');
        $this->session->setFlashdata('success_message', 'Bank Settings Updated Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    /* settings */
    /* email logs */
    public function emailLogs()
    {
        if (!$this->session->get('is_admin_login')) {
            return redirect()->to('/admin');
        }
        // if(!$this->common_model->checkModuleAccess(21)){
        //     $data['action']             = 'Access Forbidden';
        //     $title                      = $data['action'].' '.$this->data['title'];
        //     $page_name                  = 'access-forbidden';        
        //     echo $this->layout_after_login($title,$page_name,$data);
        //     exit;
        // }
        $title              = 'Email Logs';
        $page_name          = 'email-logs';
        $order_by[0]        = array('field' => 'id', 'type' => 'desc');
        $data['rows']       = $this->common_model->find_data('email_logs', 'array', '', '', '', '', $order_by);
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function emailLogsDetails($id)
    {
        if (!$this->session->get('is_admin_login')) {
            return redirect()->to('/admin');
        }
        // if(!$this->common_model->checkModuleAccess(21)){
        //     $data['action']             = 'Access Forbidden';
        //     $title                      = $data['action'].' '.$this->data['title'];
        //     $page_name                  = 'access-forbidden';        
        //     echo $this->layout_after_login($title,$page_name,$data);
        //     exit;
        // }
        $id                 = decoded($id);
        $title              = 'Email Logs Details';
        $page_name          = 'email-logs-details';
        $data['row']        = $this->common_model->find_data('email_logs', 'row', ['id' => $id]);
        echo $this->layout_after_login($title, $page_name, $data);
    }
    /* email logs */
    /* login logs */
    public function loginLogs()
    {
        if (!$this->session->get('is_admin_login')) {
            return redirect()->to('/admin');
        }
        // if(!$this->common_model->checkModuleAccess(22)){
        //     $data['action']             = 'Access Forbidden';
        //     $title                      = $data['action'].' '.$this->data['title'];
        //     $page_name                  = 'access-forbidden';        
        //     echo $this->layout_after_login($title,$page_name,$data);
        //     exit;
        // }
        $title              = 'Login Logs';
        $page_name          = 'login-logs';
        $order_by[0]        = array('field' => 'activity_id', 'type' => 'desc');
        $data['rows1']       = $this->common_model->find_data('user_activities', 'array', ['user_type' => 'admin'], '', '', '', $order_by);
        $data['rows2']       = $this->common_model->find_data('user_activities', 'array', ['user_type' => 'user'], '', '', '', $order_by);
        $data['rows3']       = $this->common_model->find_data('user_activities', 'array', ['user_type' => 'client'], '', '', '', $order_by);
        $data['rows4']       = $this->common_model->find_data('user_activities', 'array', ['user_type' => 'sales'], '', '', '', $order_by);
        echo $this->layout_after_login($title, $page_name, $data);
    }
    /* login logs */
    /* test email */
    public function testEmail()
    {
        $generalSetting             = $this->common_model->find_data('general_settings', 'row');
        $subject                    = 'Test email subject on ' . date('Y-m-d H:i:s');
        $message                    = 'Test email message body on ' . date('Y-m-d H:i:s');
        $this->sendMail($generalSetting->site_mail, $subject, $message);
        $this->session->setFlashdata('success_message', 'Test Email Sent Successfully !!!');
        return redirect()->to('/admin/settings');
    }
    /* test email */

    /* test sms */
    public function testSmS($number)
    {

        // Indian mobile number validation (starts with 6-9 and is 10 digits long)
        if (!preg_match('/^[7-9]\d{9}$/', $number)) {
            echo 'Invalid mobile number. Please enter a valid 10-digit Indian mobile number.';
            return;
        }
        $otp = random_int(100000, 999999);
        $message                    = "Dear $number, $otp is you verification OTP for registration at KEYLINE";
        $result                     = $this->common_model->sendSMS('91' . $number, $message);
        if ($result['success']) {
            echo '<pre>';
            print_r($result['response']);
            echo '</pre>';
        } else {
            echo 'Error sending SMS: ' . $result['error'];
        }
    }
    /* test sms */
}
