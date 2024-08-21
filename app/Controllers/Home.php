<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
         return redirect()->to(base_url('admin'));
        // $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        // $data['title']              = $data['general_settings']->site_name;
        // $data['page_header']        = $data['general_settings']->site_name;
        // $data['page_content']       = $this->common_model->find_data('ecomm_pages', 'row', ['id' => 3]);
        // $data = [];
        //  return view('maintaince-page', $data);
    }
    // enquiry request for whatsapp share
    public function enquiryRequest($id)
    {
        $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        $id                         = decoded($id);
        $data['enquiry']            = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $id]);
        
        return view('enquiry-request-details', $data);
    }
    public function deleteAccountRequest()
    {
        $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        $data['title']              = $data['general_settings']->site_name;
        $data['page_header']        = $data['general_settings']->site_name;
        $data['page_content']       = $this->common_model->find_data('ecomm_pages', 'row', ['id' => 3]);

        if($this->request->getMethod() == 'post') {
            $postData   = array(
                'user_type'             => $this->request->getPost('user_type'),
                'entity_name'           => $this->request->getPost('entity_name'),
                'email'                 => $this->request->getPost('email'),
                'is_email_verify'       => $this->request->getPost('is_email_verify'),
                'phone'                 => $this->request->getPost('phone'),
                'is_phone_verify'       => $this->request->getPost('is_phone_verify'),
                'comments'              => $this->request->getPost('comments'),
            );
            // pr($postData);
            $this->common_model->save_data('ecomm_delete_account_requests', $postData, '', 'id');
            $this->session->setFlashdata('success_message', 'Delete Account Request Submitted Successfully. We Will Update You Shortly !!!');
            return redirect()->to(current_url());
        }
        
        return view('delete-account-request', $data);
    }

    public function getEmailOTP(){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $requestData        = $this->request->getPost();
        $user_type          = $requestData['user_type'];
        $email              = $requestData['email'];
        $tableName          = 'user';
        $getEntity          = $this->common_model->find_data($tableName, 'row', ['email' => $email]);
        if($getEntity){
            $remember_token = rand(100000,999999);
            /* send email */
                $mailData                   = [
                    'id'            => $getEntity->id,
                    'email'         => $getEntity->email,
                    'phone'         => $getEntity->phone1,
                    'otp'           => $remember_token,
                ];
                $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                $subject                    = $generalSetting->site_name.' :: Email Verify OTP For Delete Account';
                $message                    = view('email-templates/otp',$mailData);
                $this->sendMail($email, $subject, $message);

                $apiResponse        = [
                    'email_otp'     => $remember_token,
                    'entity_name'   => (($getEntity)?$getEntity->name:''),
                ];
                $apiStatus          = TRUE;
                $apiMessage         = 'OTP Sent To Email Successfully !!!';
            /* send email */
        } else {
            $apiStatus          = FALSE;
            $apiMessage         = 'We Don\'t Recognize You !!!';
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    }
    public function getPhoneOTP(){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $requestData        = $this->request->getPost();
        $user_type          = $requestData['user_type'];
        $phone              = $requestData['phone'];
        $tableName          = 'user';
        $getEntity          = $this->common_model->find_data($tableName, 'row', ['phone1' => $phone]);
        if($getEntity){
            $mobile_otp = rand(100000,999999);
            /* send sms */
                $message = "Dear ".$user_type.", ".$mobile_otp." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
                $mobileNo = $phone;
                $this->sendSMS($mobileNo,$message);

                $apiResponse        = [
                    'phone_otp'     => $mobile_otp,
                    'entity_name'   => (($getEntity)?$getEntity->name:''),
                ];
                $apiStatus          = TRUE;
                $apiMessage         = 'OTP Sent To Phone Successfully !!!';
            /* send sms */
        } else {
            $apiStatus          = FALSE;
            $apiMessage         = 'We Don\'t Recognize You !!!';
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    }
    /* cron report */
        public function dailyTrackerFillupReport(){
            $yesterdayDate              = date('Y-m-d',strtotime("-1 days"));

            $filledUsers                = [];
            $notFilledUsers             = [];
            $orderBy[0]                 = ['field' => 'name', 'type' => 'ASC'];
            $getUsers                   = $this->common_model->find_data('user', 'array', ['status' => '1', 'is_tracker_user' => '1'], 'id,name', '', '', $orderBy);
            if($getUsers){
                foreach($getUsers as $getUser){
                    $userId             = $getUser->id;
                    $checkTrackerFillup = $this->db->query("SELECT sum(hour) as totHr, sum(min) as totMin FROM `timesheet` WHERE `user_id` = '$userId' and date_added = '$yesterdayDate'")->getRow();
                    if($checkTrackerFillup->totHr != '' || $checkTrackerFillup->totMin != ''){
                        $hourMin                    = ($checkTrackerFillup->totHr * 60);
                        $totMin                     = $checkTrackerFillup->totMin;
                        $totalMins                  = ($hourMin + $totMin);
                        $totalBooked                = intdiv($totalMins, 60).':'. ($totalMins % 60);
                        $filledUsers[]              = [
                            'name' => $getUser->name,
                            'time' => $totalBooked
                        ];
                    } else {
                        $notFilledUsers[]                = [
                            'name' => $getUser->name,
                            'time' => '0:0'
                        ];
                    }
                }
            }
            $mailData                   = [
                'yesterday_date'    => $yesterdayDate,
                'filledUsers'       => $filledUsers,
                'notFilledUsers'    => $notFilledUsers,
            ];
            $generalSetting             = $this->common_model->find_data('general_settings', 'row');
            $subject                    = $generalSetting->site_name.' :: Tracker Booked Status - '.date_format(date_create($yesterdayDate), "M d, Y");
            $message                    = view('email-templates/cron-daily-tracker-fillup',$mailData);
            // echo $message;die;
            /* email log save */
                $postData2 = [
                    'name'                  => $generalSetting->site_name,
                    'email'                 => $generalSetting->system_email,
                    'subject'               => $subject,
                    'message'               => $message
                ];
                $this->common_model->save_data('email_logs', $postData2, '', 'id');
            /* email log save */
                
            if($this->sendMail($generalSetting->system_email, $subject, $message)){
                echo "Email Sent !!!";
            }
        }
        public function fetchDesklogReport()
        {            
            $apiSettings  = $this->common_model->find_data('application_settings', 'row', ['id' => 1]);            
            // $apiUrl = 'https://api.desklog.io/api/v2/app_usage_attendance';
            $apiUrl = $apiSettings->api_url;
            // $appKey = '0srjzz9r2x4isr1j2i0eg8f4u5ndmhilvbr5w3t5';
            $appKey = $apiSettings->api_key;
            // $cu_date = date('d-m-Y'); // Or however you are getting the current date
             $cu_date = '01-08-2024';
            
            $url = $apiUrl . '?appKey=' . $appKey . '&date=' . $cu_date;
            $response = file_get_contents($url);
            $data = json_decode($response, true);            
            if($data){
                foreach ($data as $item) {
                    $db_date = date_format(date_create($cu_date), "Y-m-d");
                    $existingRecord = $this->common_model->find_data('desklog_report', 'row', ['desklog_usrid' => $item['id'], 'insert_date LIKE' => '%'.$db_date.'%']);
                    //  pr($existingRecord);
                    if(!$existingRecord){
                        // echo "user insert"; die;
                        $postData   = array(
                            'desklog_usrid' => $item['id'],                
                            'email' => $item['email'],
                            'arrival_at' => $item['arrival_at'],
                            'left_at' => $item['left_at'],
                            'time_at_work' => $item['time_at_work'],
                            'productive_time' => $item['productive_time'],
                            'idle_time' => $item['idle_time'],
                            'private_time' => $item['private_time'],
                            'total_time_allocated' => $item['total_time_allocated'],
                            'total_time_spended' => $item['total_time_spended'],
                            'time_zone' => $item['time_zone'],
                            'app_and_os' => $item['app_and_os'],     
                        );
                        $user_email                     = $item['email'];            
                        // $data['user']                   = $this->common_model->find_data('user', 'array', ['status!=' => 3, 'email' => $user_email]);
                        $sql11                          = "SELECT user.*, department.deprt_name as deprt_name FROM `user`INNER JOIN department ON user.department = department.id WHERE user.email = '$user_email' AND user.status != 3";
                        $data['user']                   = $this->db->query($sql11)->getResult();                        
                        $user_id                        = $data['user'][0]->id;
                        $user_name                      = $data['user'][0]->name;
                        $user_dept                      = $data['user'][0]->deprt_name;
                        $postData['tracker_user_id']    = $user_id;
                        $postData['insert_date']        = $db_date;
                        $record                         = $this->common_model->save_data('desklog_report', $postData, '', 'id');
                        
                        $year = date('Y');
                        $month  =   date('m');
                        $sql10 = "SELECT * FROM `desktime_sheet_tracking` WHERE year_upload = '$year' AND month_upload = '$month' AND user_id = '$user_id'";
                        $getDesktimeHour = $this->db->query($sql10)->getRow();                        
                        $sql = "SELECT time_at_work FROM `desklog_report` where tracker_user_id='$user_id' and insert_date LIKE '%" . date('Y').'-'.date('m') . "%'";
                        $getDesktime = $this->db->query($sql)->getResult();                        
                        $totalHours = 0;
                        $totalMinutes = 0;
                        foreach ($getDesktime as $entry) {                            
                            // Extract hours and minutes
                            sscanf($entry->time_at_work, "%dh %dm", $hours, $minutes);                            
                            // Sum up hours and minutes
                            $totalHours += $hours;
                            $totalMinutes += $minutes;                           
                        }
                         $totalHours += intdiv($totalMinutes, 60);
                         $totalMinutes = $totalMinutes % 60;   
                         $MonthlyDesktime = $totalHours.'.'.$totalMinutes;                                                                
                        if ($getDesktimeHour) {                                                      
                        $postData = array(
                            'total_desktime_hour' => $MonthlyDesktime,                                
                        );                         
                        $updateData = $this->common_model->save_data('desktime_sheet_tracking',$postData,$user_id,'id'); 
                         $result7 = $getDesktimeHour->total_desktime_hour;
                        }else{
                            $postData = array(
                                'month_upload' => $month,                                
                                'year_upload' => $year,                                
                                'user_id' => $user_id,                                
                                'name' => $user_name,                                
                                'email' => $user_email,
                                'department' => $user_dept,
                                'total_desktime_hour' => $MonthlyDesktime,
                                'total_working_time' => $MonthlyDesktime,
                                'added_on' => $db_date,                               
                            );                             
                            $insertData = $this->common_model->save_data('desktime_sheet_tracking',$postData,'','id');
                            $result7 ='';
                        }
                    } else {                        
                        $id         = $existingRecord->id;
                        $postData   = array(
                            'desklog_usrid' => $item['id'],                
                            'email' => $item['email'],
                            'arrival_at' => $item['arrival_at'],
                            'left_at' => $item['left_at'],
                            'time_at_work' => $item['time_at_work'],
                            'productive_time' => $item['productive_time'],
                            'idle_time' => $item['idle_time'],
                            'private_time' => $item['private_time'],
                            'total_time_allocated' => $item['total_time_allocated'],
                            'total_time_spended' => $item['total_time_spended'],
                            'time_zone' => $item['time_zone'],
                            'app_and_os' => $item['app_and_os'],     
                        );
                        $user_email                     = $item['email'];  
                        // $data['user']                   = $this->common_model->find_data('user', 'array', ['status!=' => 3, 'email' => $user_email]);
                        $sql11                          = "SELECT user.*, department.deprt_name as deprt_name FROM `user`INNER JOIN department ON user.department = department.id WHERE user.email = '$user_email' AND user.status != 3";
                        $data['user']                   = $this->db->query($sql11)->getResult();                        
                        $user_id                        = $data['user'][0]->id;
                        $user_name                      = $data['user'][0]->name;
                        $user_dept                      = $data['user'][0]->deprt_name;
                        $postData['tracker_user_id']    = $user_id;
                        $postData['insert_date']        = $db_date;
                        $record                         = $this->common_model->save_data('desklog_report', $postData, $id, 'id');
                        
                        $year = date('Y');
                        $month  =   date('m');
                        $sql10 = "SELECT * FROM `desktime_sheet_tracking` WHERE year_upload = '$year' AND month_upload = '$month' AND user_id = '$user_id'";
                        $getDesktimeHour = $this->db->query($sql10)->getRow();                        
                        $sql = "SELECT time_at_work FROM `desklog_report` where tracker_user_id='$user_id' and insert_date LIKE '%" . date('Y').'-'.date('m') . "%'";
                        $getDesktime = $this->db->query($sql)->getResult();                        
                        $totalHours = 0;
                        $totalMinutes = 0;
                        foreach ($getDesktime as $entry) {                            
                            // Extract hours and minutes
                            sscanf($entry->time_at_work, "%dh %dm", $hours, $minutes);                            
                            // Sum up hours and minutes
                            $totalHours += $hours;
                            $totalMinutes += $minutes;                           
                        }
                         $totalHours += intdiv($totalMinutes, 60);
                         $totalMinutes = $totalMinutes % 60;   
                         $MonthlyDesktime = $totalHours.'.'.$totalMinutes;                                                                
                        if ($getDesktimeHour) {                                                      
                        $postData = array(
                            'total_desktime_hour' => $MonthlyDesktime,                                
                        );                         
                        $updateData = $this->common_model->save_data('desktime_sheet_tracking',$postData,$user_id,'id'); 
                         $result = $getDesktimeHour->total_desktime_hour;
                        }else{
                            $postData = array(
                                'month_upload' => $month,                                
                                'year_upload' => $year,                                
                                'user_id' => $user_id,                                
                                'name' => $user_name,                                
                                'email' => $user_email,
                                'department' => $user_dept,
                                'total_desktime_hour' => $MonthlyDesktime,
                                'total_working_time' => $MonthlyDesktime,
                                'added_on' => $db_date,                               
                            );                             
                            $insertData = $this->common_model->save_data('desktime_sheet_tracking',$postData,'','id');
                            $result ='';
                        }
                    }
                }
            }
            echo 'Data fetched and saved successfully.';
        }
    /* cron report */
    /*client details*/
    public function clientDetails(){
        $data  = [];
        return view('client-details', $data);
    }
    /*client details*/
    /*client proxy for country*/
    public function countryDetailsProxy() {
        $targetUrl  = 'http://api.geonames.org' . $_SERVER['REQUEST_URI'];
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response   = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            file_put_contents('proxy_log_country.txt', $response);
            $header_size    = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers        = substr($response, 0, $header_size);
            $body           = substr($response, $header_size);
            $headersArray = explode("\r\n", $headers);
            foreach ($headersArray as $header) {
                if (stripos($header, 'Transfer-Encoding:') === false) {
                    header($header);
                }
            }
            echo $body;
        }
        curl_close($ch);
    }
    /*client proxy for country*/
    /*client proxy for state*/
    public function stateDetailsProxy() {
        $url        = str_replace('/stateInfoJSON', '', $_SERVER['REQUEST_URI']);
        $targetUrl  = 'http://api.geonames.org/childrenJSON' . $url;
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response   = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            file_put_contents('proxy_log_state.txt', $response);
            $header_size    = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers        = substr($response, 0, $header_size);
            $body           = substr($response, $header_size);
            $headersArray = explode("\r\n", $headers);
            foreach ($headersArray as $header) {
                if (stripos($header, 'Transfer-Encoding:') === false) {
                    header($header);
                }
            }
            echo $body;
        }
        curl_close($ch);
    }
    /*client proxy for state*/
    /*client proxy for city*/
    public function cityDetailsProxy() {
        $url        = str_replace('/cityInfoJSON', '', $_SERVER['REQUEST_URI']);
        $targetUrl  = 'http://api.geonames.org/childrenJSON' . $url;
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response   = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            file_put_contents('proxy_log_city.txt', $response);
            $header_size    = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers        = substr($response, 0, $header_size);
            $body           = substr($response, $header_size);
            $headersArray = explode("\r\n", $headers);
            foreach ($headersArray as $header) {
                if (stripos($header, 'Transfer-Encoding:') === false) {
                    header($header);
                }
            }
            echo $body;
        }
        curl_close($ch);
    }
    /*client proxy for city*/
    /* client details form */
    public function clientDetailsData()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name           = htmlspecialchars($_POST['name']);
            $company        = htmlspecialchars($_POST['company']);
            $address1       = htmlspecialchars($_POST['address1']);
            $address2       = htmlspecialchars($_POST['address2']);
            $country        = htmlspecialchars($_POST['country']);
            $state          = htmlspecialchars($_POST['state']);
            $city           = htmlspecialchars($_POST['city']);
            $pin            = htmlspecialchars($_POST['pin']);
            $phone1         = htmlspecialchars($_POST['phone1']);
            $phone2         = htmlspecialchars($_POST['phone2']);
            $dob            = htmlspecialchars($_POST['dob']);
            $gstNoComment   = htmlspecialchars($_POST['gstNoComment']);
            $email1         = filter_var($_POST['email1'], FILTER_SANITIZE_EMAIL);
            $email2         = filter_var($_POST['email2'], FILTER_SANITIZE_EMAIL);

            if (empty($name) || empty($company) || empty($address1) || empty($country) || empty($state) || empty($city) || empty($pin) || empty($phone1) || empty($email1)) {
                echo "All fields are required.";
                exit;
            } else {

                function getCountryNameByGeonameId($geonameId, $username){
                    $url = "http://api.geonames.org/getJSON?geonameId=" . $geonameId . "&username=" . $username;
                    $ch  = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    if ($response === false) {
                        die('Error: ' . curl_error($ch));
                    }
                    curl_close($ch);
                    $data = json_decode($response, true);
                    if (isset($data['countryName'])) {
                        return $data['countryName'];
                    } else {
                        return "Country not found";
                    }
                }
                function getStateNameByGeonameId($geonameId, $username) {
                    $url = "http://api.geonames.org/getJSON?geonameId=" . urlencode($geonameId) . "&username=" . urlencode($username);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    if ($response === false) {
                        die('Error: ' . curl_error($ch));
                    }
                    curl_close($ch);
                    $data = json_decode($response, true);
                    if (isset($data['adminName1'])) {
                        return $data['adminName1'];
                    } else {
                        return "State not found";
                    }
                }
                function getCityNameByGeonameId($geonameId, $username) {
                    $url = "http://api.geonames.org/getJSON?geonameId=" . urlencode($geonameId) . "&username=" . urlencode($username);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    if ($response === false) {
                        die('Error: ' . curl_error($ch));
                    }
                    curl_close($ch);
                    $data = json_decode($response, true);
                    if (isset($data['name'])) {
                        return $data['name'];
                    } else {
                        return "City not found";
                    }
                }
                
                $username           = "avijit678";
                $geonameCountryId   = $country;
                $geonameStateId     = $state;
                $geonameCityId      = $city;

                $countryName        = getCountryNameByGeonameId($geonameCountryId, $username);
                $stateName          = getStateNameByGeonameId($geonameStateId, $username);
                $cityName           = getCityNameByGeonameId($geonameCityId, $username);

                $postData   = array(
                    'entried_by'     => 0,
                    'client_of'      => 0,
                    'name'           => $name,
                    'compnay'        => $company,
                    'address_1'      => $address1,
                    'state'          => $stateName,
                    'city'           => $cityName,
                    'country'        => $countryName,
                    'pin'            => $pin,
                    'address_2'      => $address2,
                    'email_1'        => $email1,
                    'email_2'        => $email2,
                    'phone_1'        => $phone1,
                    'phone_2'        => $phone2,
                    'dob_day'        => $dob,
                    'dob_month'      => '',
                    'dob_year'       => '',
                    'password_md5'   => '',
                    'password_org'   => '',
                    'reference'      => '',
                    'added_date'     => date('Y-m-d'),
                    'comment'        => $gstNoComment,
                    'login_access'   => '0',
                    'last_login'     => date('Y-m-d')
                );
                $this->common_model->save_data('client', $postData, '', '');
                // echo $this->db->getLastQuery();die;
            }
        } else {
            echo "Method not allowed.";
        }
    }
    /* client details form */
}
