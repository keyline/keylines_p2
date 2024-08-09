<?php
namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Libraries\CreatorJwt;
use App\Libraries\JWT;

class ApiController extends BaseController
{
    /* before login */
        public function getAppSetting(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $headerData            = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $generalSetting = $this->common_model->find_data('general_settings', 'row');
                if($generalSetting){
                    $apiResponse = [
                        'site_name'                 => $generalSetting->site_name,
                        'site_phone'                => $generalSetting->site_phone,
                        'site_mail'                 => $generalSetting->site_mail,
                        'site_url'                  => $generalSetting->site_url,
                        'firebase_server_key'       => $generalSetting->firebase_server_key,
                        'gst_api_code'              => $generalSetting->gst_api_code,
                        'theme_color'               => $generalSetting->theme_color,
                        'font_color'                => $generalSetting->font_color,
                        'site_logo'                 => getenv('app.uploadsURL').$generalSetting->site_logo,
                    ];
                }
                http_response_code(200);
                $apiStatus          = TRUE;
                $apiMessage         = 'Data Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function getStaticPages(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['page_slug'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $page = $this->common_model->find_data('ecomm_pages', 'row', ['slug' => $requestData['page_slug']]);
                if($page){
                    $apiResponse = [
                        'page_title'                => $page->page_title,
                        'slug'                      => $page->slug,
                        'short_description'         => $page->short_description,
                        'long_description'          => $page->long_description,
                        'meta_title'                => $page->meta_title,
                        'meta_description'          => $page->meta_description,
                        'meta_keywords'             => $page->meta_keywords,
                    ];
                }
                http_response_code(200);
                $apiStatus          = TRUE;
                $apiMessage         = 'Data Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
    /* before login */
    /* authentication */
        // forgot password
            public function forgotPassword(){
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $apiExtraField      = '';
                $apiExtraData       = '';
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['type', 'email'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){              
                    http_response_code(406);
                    $apiStatus          = FALSE;
                    $apiMessage         = $this->getResponseCode(http_response_code());
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }           
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $checkEmail                 = $this->common_model->find_data('user', 'row', ['email' => $requestData['email']]);
                    if($checkEmail){
                        $remember_token  = rand(100000,999999);
                        $this->common_model->save_data('user', ['remember_token' => $remember_token], $checkEmail->id, 'id');
                        $mailData                   = [
                            'id'    => $checkEmail->id,
                            'email' => $checkEmail->email,
                            'otp'   => $remember_token,
                        ];
                        $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                        $subject                    = $generalSetting->site_name.' :: Forgot Password OTP';
                        $message                    = view('email-templates/otp',$mailData);
                        // echo $message;die;
                        $this->sendMail($requestData['email'], $subject, $message);

                        /* email log save */
                            $postData2 = [
                                'name'                  => $checkEmail->name,
                                'email'                 => $requestData['email'],
                                'subject'               => $subject,
                                'message'               => $message
                            ];
                            $this->common_model->save_data('email_logs', $postData2, '', 'id');
                        /* email log save */

                        $apiResponse                        = $mailData;
                        $apiStatus                          = TRUE;
                        http_response_code(200);
                        $apiMessage                         = 'OTP Sent To Email For Validation !!!';
                        $apiExtraField                      = 'response_code';
                        $apiExtraData                       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(200);
                        $apiMessage         = 'Email Not Registered With Us !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code(400);
                    $apiStatus          = FALSE;
                    $apiMessage         = $this->getResponseCode(http_response_code());
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
            }
            public function validateOTP(){
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $apiExtraField      = '';
                $apiExtraData       = '';
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['id', 'otp'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){              
                    http_response_code(406);
                    $apiStatus          = FALSE;
                    $apiMessage         = $this->getResponseCode(http_response_code());
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }           
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $getUser = $this->common_model->find_data('user', 'row', ['id' => $requestData['id']]);
                    if($getUser){
                        $remember_token  = $getUser->remember_token;
                        if($remember_token == $requestData['otp']){
                            $this->common_model->save_data('user', ['remember_token' => ''], $getUser->id, 'id');
                            $apiResponse        = [
                                'id'    => $getUser->id,
                                'email' => $getUser->email
                            ];
                            $apiStatus                          = TRUE;
                            http_response_code(200);
                            $apiMessage                         = 'OTP Validated Successfully !!!';
                            $apiExtraField                      = 'response_code';
                            $apiExtraData                       = http_response_code();
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(404);
                            $apiMessage         = 'OTP Mismatched !!!';
                            $apiExtraField      = 'response_code';
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code(400);
                    $apiStatus          = FALSE;
                    $apiMessage         = $this->getResponseCode(http_response_code());
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
            }
            public function resendOtp(){
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $apiExtraField      = '';
                $apiExtraData       = '';
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['id'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){              
                    http_response_code(406);
                    $apiStatus          = FALSE;
                    $apiMessage         = $this->getResponseCode(http_response_code());
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }           
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $id         = $requestData['id'];
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $id]);
                    if($getUser){
                        $remember_token = rand(100000,999999);
                        $postData = [
                            'remember_token'        => $remember_token
                        ];
                        $this->common_model->save_data('user', ['remember_token' => $remember_token], $getUser->id, 'id');

                        $mailData                   = [
                            'id'    => $getUser->id,
                            'email' => $getUser->email,
                            'otp'   => $remember_token,
                        ];
                        $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                        $subject                    = $generalSetting->site_name.' :: Forgot Password OTP';
                        $message                    = view('email-templates/otp',$mailData);
                        // echo $message;die;
                        $this->sendMail($getUser->email, $subject, $message);

                        /* email log save */
                            $postData2 = [
                                'name'                  => $getUser->name,
                                'email'                 => $getUser->email,
                                'subject'               => $subject,
                                'message'               => $message
                            ];
                            $this->common_model->save_data('email_logs', $postData2, '', 'id');
                        /* email log save */

                        $apiResponse                        = $mailData;
                        $apiStatus                          = TRUE;
                        http_response_code(200);
                        $apiMessage                         = 'OTP Resend Successfully !!!';
                        $apiExtraField                      = 'response_code';
                        $apiExtraData                       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(400);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code(400);
                    $apiStatus          = FALSE;
                    $apiMessage         = $this->getResponseCode(http_response_code());
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
            }
            public function resetPassword()
            {
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $apiExtraField      = '';
                $apiExtraData       = '';
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['id', 'password', 'confirm_password'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){              
                    http_response_code(406);
                    $apiStatus          = FALSE;
                    $apiMessage         = $this->getResponseCode(http_response_code());
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }           
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $id         = $requestData['id'];
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $id]);
                    if($getUser){
                        if($requestData['password'] == $requestData['confirm_password']){
                            $this->common_model->save_data('user', ['password' => md5($requestData['password'])], $getUser->id, 'id');
                            
                            $mailData        = [
                                'id'                => $getUser->id,
                                'name'              => $getUser->name,
                                'email'             => $getUser->email,
                                'password'          => $requestData['password'],
                            ];
                            $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                            $subject                    = $generalSetting->site_name.' :: Reset Password';
                            $message                    = view('email-templates/change-password',$mailData);
                            // echo $message;die;
                            $this->sendMail($getUser->email, $subject, $message);
                            
                            $apiStatus                          = TRUE;
                            http_response_code(200);
                            $apiMessage                         = 'Password Reset Successfully !!!';
                            $apiExtraField                      = 'response_code';
                            $apiExtraData                       = http_response_code();
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(404);
                            $apiMessage         = 'Password & Confirm Password Not Matched !!!';
                            $apiExtraField      = 'response_code';
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code(400);
                    $apiStatus          = FALSE;
                    $apiMessage         = $this->getResponseCode(http_response_code());
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
            }
        // forgot password
        // signin
            public function signin()
            {
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['type', 'email', 'password', 'device_token'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){
                    $apiStatus          = FALSE;
                    $apiMessage         = 'All Data Are Not Present !!!';
                }
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $email                      = $requestData['email'];
                    $password                   = $requestData['password'];
                    $device_token               = $requestData['device_token'];
                    $fcm_token                  = $requestData['fcm_token'];
                    $device_type                = trim($headerData['Source'], "Source: ");
                    $checkUser                  = $this->common_model->find_data('user', 'row', ['email' => $email, 'status' => '1']);
                    if($checkUser){
                        
                        if($checkUser->status != '3'){
                            if(md5($password) == $checkUser->password){

                                $objOfJwt           = new CreatorJwt();
                                $app_access_token   = $objOfJwt->GenerateToken($checkUser->id, $checkUser->email, $checkUser->phone1);
                                $user_id                        = $checkUser->id;
                                $fields     = [
                                    'user_id'               => $user_id,
                                    'device_type'           => $device_type,
                                    'device_token'          => $device_token,
                                    'fcm_token'             => $fcm_token,
                                    'app_access_token'      => $app_access_token,
                                ];
                                $checkUserTokenExist                  = $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $app_access_token]);
                                if(!$checkUserTokenExist){
                                    $this->common_model->save_data('ecomm_user_devices', $fields, '', 'id');
                                } else {
                                    $this->common_model->save_data('ecomm_user_devices', $fields, $checkUserTokenExist->id, 'id');
                                }

                                $userActivityData = [
                                    'user_email'        => $checkUser->email,
                                    'user_name'         => $checkUser->name,
                                    'activity_type'     => 1,
                                    'user_type'         => 'USER',
                                    'ip_address'        => $this->request->getIPAddress(),
                                    'activity_details'  => $checkUser->type.' Sign In Success',
                                ];
                                // pr($userActivityData);
                                $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                                $name = $checkUser->name;
                                $getDesignation                  = $this->common_model->find_data('user_category', 'row', ['id' => $checkUser->category], 'name');
                                $apiResponse = [
                                    'user_id'               => $user_id,
                                    'name'                  => $name,
                                    'email'                 => $checkUser->email,
                                    'phone'                 => $checkUser->phone1,
                                    'type'                  => $checkUser->type,
                                    'designation'           => (($getDesignation)?$getDesignation->name:''),
                                    'device_type'           => $device_type,
                                    'device_token'          => $device_token,
                                    'fcm_token'             => $fcm_token,
                                    'app_access_token'      => $app_access_token,
                                ];
                                $apiStatus                          = TRUE;
                                $apiMessage                         = 'SignIn Successfully !!!';
                            } else {
                                $userActivityData = [
                                    'user_email'        => $email,
                                    'user_name'         => $checkUser->name,
                                    'user_type'         => 'USER',
                                    'ip_address'        => $this->request->getIPAddress(),
                                    'activity_type'     => 0,
                                    'activity_details'  => 'Invalid Password',
                                ];
                                $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                                $apiStatus                          = FALSE;
                                $apiMessage                         = 'Invalid Password !!!';
                            }
                        } else {
                            $userActivityData = [
                                'user_email'        => $email,
                                'user_name'         => $checkUser->name,
                                'user_type'         => 'USER',
                                'ip_address'        => $this->request->getIPAddress(),
                                'activity_type'     => 0,
                                'activity_details'  => 'Sorry ! Account Is Deleted',
                            ];
                            $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                            $apiStatus                          = FALSE;
                            $apiMessage                         = 'Sorry ! Account Is Deleted !!!';
                        }
                    } else {
                        $userActivityData = [
                            'user_email'        => $email,
                            'user_name'         => '',
                            'user_type'         => 'USER',
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 0,
                            'activity_details'  => 'We Don\'t Recognize Your Email Address',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                        $apiStatus                              = FALSE;
                        $apiMessage                             = 'We Don\'t Recognize You !!!';
                    }
                } else {
                    $apiStatus          = FALSE;
                    $apiMessage         = 'Unauthenticate Request !!!';
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
            }
            public function signinWithMobile()
            {
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['type', 'phone'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){
                    $apiStatus          = FALSE;
                    $apiMessage         = 'All Data Are Not Present !!!';
                }
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $type                       = $requestData['type'];
                    $phone                      = $requestData['phone'];
                    $checkUser                  = $this->common_model->find_data('user', 'row', ['type' => $type, 'phone' => $phone, 'status>=' => 1]);
                    if($checkUser){
                        $mobile_otp = rand(100000,999999);
                        $postData = [
                            'mobile_otp'        => $mobile_otp
                        ];
                        $this->common_model->save_data('user', ['mobile_otp' => $mobile_otp], $checkUser->id, 'id');
                        /* send sms */
                            $memberType             = $this->common_model->find_data('ecomm_member_types', 'row', ['id' => $checkUser->member_type], 'name');
                            $message = "Dear ".(($memberType)?$memberType->name:'ECOEX').", ".$mobile_otp." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
                            $mobileNo = (($checkUser)?$checkUser->phone:'');
                            $this->sendSMS($mobileNo,$message);
                        /* send sms */
                        $mailData                   = [
                            'id'    => $checkUser->id,
                            'email' => $checkUser->email,
                            'phone' => $checkUser->phone,
                            'otp'   => $mobile_otp,
                        ];
                        $apiResponse                        = $mailData;
                        $apiStatus                          = TRUE;
                        $apiMessage                         = 'Please Enter OTP !!!';
                    } else {
                        $userActivityData = [
                            'user_email'        => '',
                            'user_name'         => '',
                            'user_type'         => 'USER',
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 0,
                            'activity_details'  => 'We Don\'t Recognize Your Phone Number',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                        $apiStatus                              = FALSE;
                        $apiMessage                             = 'We Don\'t Recognize You !!!';
                    }
                } else {
                    $apiStatus          = FALSE;
                    $apiMessage         = 'Unauthenticate Request !!!';
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
            }
            public function signinValidateMobile()
            {
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['phone', 'otp', 'device_token'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){
                    $apiStatus          = FALSE;
                    $apiMessage         = 'All Data Are Not Present !!!';
                }
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $phone                      = $requestData['phone'];
                    $otp                        = $requestData['otp'];
                    $device_token               = $requestData['device_token'];
                    $fcm_token                  = $requestData['fcm_token'];
                    $device_type                = trim($headerData['Source'], "Source: ");
                    $checkUser                  = $this->common_model->find_data('user', 'row', ['phone' => $phone, 'status>=' => 1]);
                    if($checkUser){
                        if($otp == $checkUser->mobile_otp){
                            $objOfJwt           = new CreatorJwt();
                            $app_access_token   = $objOfJwt->GenerateToken($checkUser->id, $checkUser->email, $checkUser->phone);
                            $user_id                        = $checkUser->id;
                            $fields     = [
                                'user_id'               => $user_id,
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            $checkUserTokenExist                  = $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $app_access_token]);
                            if(!$checkUserTokenExist){
                                $this->common_model->save_data('ecomm_user_devices', $fields, '', 'id');
                            } else {
                                $this->common_model->save_data('ecomm_user_devices', $fields, $checkUserTokenExist->id, 'id');
                            }

                            $userActivityData = [
                                'user_email'        => $checkUser->email,
                                'user_name'         => $checkUser->name,
                                'activity_type'     => 1,
                                'user_type'         => 'USER',
                                'ip_address'        => $this->request->getIPAddress(),
                                'activity_details'  => $checkUser->type.' Sign In Success',
                            ];
                            // pr($userActivityData);
                            $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');

                            $apiResponse = [
                                'user_id'               => $user_id,
                                'name'          => $checkUser->name,
                                'email'                 => $checkUser->email,
                                'phone'                 => $checkUser->phone,
                                'type'                  => $checkUser->type,
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            $this->common_model->save_data('user', ['mobile_otp' => ''], $checkUser->id, 'id');
                            $apiStatus                          = TRUE;
                            $apiMessage                         = 'SignIn Successfully !!!';
                        } else {
                            $userActivityData = [
                                'user_email'        => $checkUser->email,
                                'user_name'         => $checkUser->name,
                                'user_type'         => 'USER',
                                'ip_address'        => $this->request->getIPAddress(),
                                'activity_type'     => 0,
                                'activity_details'  => 'OTP Mismatched !!!',
                            ];
                            $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                            $apiStatus                          = FALSE;
                            $apiMessage                         = 'OTP Mismatched !!!';
                        }
                    } else {
                        $userActivityData = [
                            'user_email'        => $email,
                            'user_name'         => '',
                            'user_type'         => 'USER',
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 0,
                            'activity_details'  => 'We Don\'t Recognize Your Phone Number',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                        $apiStatus                              = FALSE;
                        $apiMessage                             = 'We Don\'t Recognize You !!!';
                    }
                } else {
                    $apiStatus          = FALSE;
                    $apiMessage         = 'Unauthenticate Request !!!';
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
            }
        // signin
    /* authentication */
    /* after login */
        public function signout()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                $checkUserTokenExist        = $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $app_access_token, 'published' => 1]);
                // pr($checkUserTokenExist);
                if($checkUserTokenExist){
                    $user_id    = $checkUserTokenExist->user_id;
                    $checkUser  = $this->common_model->find_data('user', 'row', ['id' => $user_id, 'status' => 1]);
                    /* user activity */
                        $userActivityData = [
                            'user_email'        => (($checkUser)?$checkUser->email:''),
                            'user_name'         => (($checkUser)?$checkUser->name:''),
                            'user_type'         => (($checkUser)?$checkUser->type:'USER'),
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 2,
                            'activity_details'  => 'Sign Out Successfully',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                    /* user activity */
                    $this->common_model->delete_data('ecomm_user_devices', $app_access_token, 'app_access_token');

                    $apiStatus                      = TRUE;
                    $apiMessage                     = 'Signout Successfully !!!';
                } else {
                    $apiStatus                      = FALSE;
                    $apiMessage                     = 'Something Went Wrong !!!';
                }               
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function changePassword()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['old_password', 'new_password', 'confirm_password'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $old_password               = $requestData['old_password'];
                $new_password               = $requestData['new_password'];
                $confirm_password           = $requestData['confirm_password'];
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        if($getUser->password == md5($old_password)){
                            if($new_password == $confirm_password){
                                if($getUser->password != md5($new_password)){
                                    $fields = [
                                        'password'      => md5($new_password)
                                    ];
                                    $this->common_model->save_data('user', $fields, $uId, 'id');
                                    $apiStatus          = TRUE;
                                    http_response_code(200);
                                    $apiMessage         = 'Password Updated Successfully !!!';
                                    $apiExtraField      = 'response_code';
                                    $apiExtraData       = http_response_code();
                                } else {
                                    $apiStatus          = FALSE;
                                    http_response_code(200);
                                    $apiMessage         = 'New & Existing Password Can\'t Be Same !!!';
                                    $apiExtraField      = 'response_code';
                                    $apiExtraData       = http_response_code();
                                }
                            } else {
                                $apiStatus          = FALSE;
                                http_response_code(200);
                                $apiMessage         = 'New & Confirm Password Doesn\'t Matched !!!';
                                $apiExtraField      = 'response_code';
                                $apiExtraData       = http_response_code();
                            }
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(200);
                            $apiMessage         = 'Existing Password Doesn\'t Matched !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getProfile()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        $getCategory         = $this->common_model->find_data('user_category', 'row', ['id' => $getUser->category], 'name');                        
                        $apiResponse        = [
                            'type'                                  => $getUser->type,
                            'name'                                  => $getUser->name,
                            'email'                                 => $getUser->email,
                            'personal_email'                        => $getUser->personal_email,
                            'phone1'                                => $getUser->phone1,
                            'phone2'                                => $getUser->phone2,
                            'address'                               => $getUser->address,
                            'pincode'                               => $getUser->pincode,
                            'latitude'                              => $getUser->latitude,
                            'longitude'                             => $getUser->longitude,
                            'hour_cost'                             => $getUser->hour_cost,
                            'category'                              => (($getCategory)?$getCategory->name:''),
                            'dob'                                   => (($getUser)?date_format(date_create($getUser->dob), "M d, Y"):''),
                            'doj'                                   => (($getUser)?date_format(date_create($getUser->doj), "M d, Y"):''),
                            'profile_image'                         => (($getUser->profile_image != '')?getenv('app.uploadsURL').'user/'.$getUser->profile_image:getenv('app.NO_IMAGE')),
                            'work_mode'                             => $getUser->work_mode,
                            'is_tracker_user'                       => (($getUser->is_tracker_user)?'YES':'NO'),
                            'is_salarybox_user'                     => (($getUser->is_salarybox_user)?'YES':'NO'),
                            'attendence_type'                       => $getUser->attendence_type,
                        ];

                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function updateProfile()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['type', 'gst_no', 'name', 'full_address', 'street', 'district', 'state', 'pincode', 'phone', 'contact_person_name', 'contact_person_designation'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $type                       = $requestData['type'];
                $gst_no                     = $requestData['gst_no'];
                $name               = $requestData['name'];
                $full_address               = $requestData['full_address'];
                $holding_no                 = $requestData['holding_no'];
                $street                     = $requestData['street'];
                $district                   = $requestData['district'];
                $state                      = $requestData['state'];
                $pincode                    = $requestData['pincode'];
                $location                   = $requestData['location'];
                $phone                      = $requestData['phone'];
                // $email                      = $requestData['email'];
                $member_type_id             = ((!empty($requestData['member_type_id']))?$requestData['member_type_id']:0);

                $gst_certificate                            = $requestData['gst_certificate'];
                $contact_person_name                        = $requestData['contact_person_name'];
                $contact_person_designation                 = $requestData['contact_person_designation'];
                $contact_person_document                    = $requestData['contact_person_document'];
                if($type == 'PLANT'){
                    $bank_name                                  = $requestData['bank_name'];
                    $branch_name                                = $requestData['branch_name'];
                    $ifsc_code                                  = $requestData['ifsc_code'];
                    $account_type                               = $requestData['account_type'];
                    $account_number                             = $requestData['account_number'];
                    $cancelled_cheque                           = $requestData['cancelled_cheque'];
                } else {
                    $bank_name                                  = '';
                    $branch_name                                = '';
                    $ifsc_code                                  = '';
                    $account_type                               = '';
                    $account_number                             = '';
                    $cancelled_cheque                           = '';
                }
                
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        $checkPhoneExist = $this->common_model->find_data('user', 'row', ['phone' => $phone, 'id!=' => $uId]);
                        if($checkPhoneExist){
                            $apiStatus          = FALSE;
                            http_response_code(200);
                            $apiMessage         = 'Phone No. Already Exists. Please Use Other Phone No. !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        } else {
                            /* gst certificate */
                                if(!empty($gst_certificate)){
                                    $gst_certificate    = $gst_certificate[0];
                                    $upload_type        = $gst_certificate['type'];
                                    if($upload_type == 'application/pdf'){
                                        $upload_base64      = $gst_certificate['base64'];
                                        $img                = $upload_base64;
                                        // $img            = $upload_file['base64'];
                                        // $img            = str_replace('data:application/pdf;base64,', '', $upload_file);
                                        // $img            = str_replace(' ', '+', $img);
                                        $data           = base64_decode($img);
                                        $fileName       = uniqid() . '.pdf';
                                        $file           = 'public/uploads/user/' . $fileName;
                                        $success        = file_put_contents($file, $data);
                                        $gst_docs       = $fileName;
                                    } else {
                                        $apiStatus          = FALSE;
                                        http_response_code(404);
                                        $apiMessage         = 'Please Upload Document in PDF Format !!!';
                                        $apiExtraField      = 'response_code';
                                        $apiExtraData       = http_response_code();
                                    }
                                } else {
                                    $gst_docs = $getUser->gst_certificate;
                                }
                            /* gst certificate */
                            /* pan card/company ID */
                                if(!empty($contact_person_document)){
                                    $contact_person_document    = $contact_person_document[0];
                                    $upload_type        = $contact_person_document['type'];
                                    if($upload_type == 'application/pdf'){
                                        $upload_base64      = $contact_person_document['base64'];
                                        $img                = $upload_base64;
                                        // $img            = $upload_file['base64'];
                                        // $img            = str_replace('data:application/pdf;base64,', '', $upload_file);
                                        // $img            = str_replace(' ', '+', $img);
                                        $data           = base64_decode($img);
                                        $fileName       = uniqid() . '.pdf';
                                        $file           = 'public/uploads/user/' . $fileName;
                                        $success        = file_put_contents($file, $data);
                                        $pan_docs       = $fileName;
                                    } else {
                                        $apiStatus          = FALSE;
                                        http_response_code(404);
                                        $apiMessage         = 'Please Upload Document in PDF Format !!!';
                                        $apiExtraField      = 'response_code';
                                        $apiExtraData       = http_response_code();
                                    }
                                } else {
                                    $pan_docs = $getUser->contact_person_document;
                                }
                            /* pan card/company ID */
                            /* cancelled cheque */
                                if(!empty($cancelled_cheque)){
                                    $cancelled_cheque    = $cancelled_cheque[0];
                                    $upload_type        = $cancelled_cheque['type'];
                                    if($upload_type == 'application/pdf'){
                                        $upload_base64      = $cancelled_cheque['base64'];
                                        $img                = $upload_base64;
                                        // $img            = $upload_file['base64'];
                                        // $img            = str_replace('data:application/pdf;base64,', '', $upload_file);
                                        // $img            = str_replace(' ', '+', $img);
                                        $data           = base64_decode($img);
                                        $fileName       = uniqid() . '.pdf';
                                        $file           = 'public/uploads/user/' . $fileName;
                                        $success        = file_put_contents($file, $data);
                                        $cheque_docs    = $fileName;
                                    } else {
                                        $apiStatus          = FALSE;
                                        http_response_code(404);
                                        $apiMessage         = 'Please Upload Document in PDF Format !!!';
                                        $apiExtraField      = 'response_code';
                                        $apiExtraData       = http_response_code();
                                    }
                                } else {
                                    $cheque_docs = $getUser->cancelled_cheque;
                                }
                            /* cancelled cheque */
                            $fields = [
                                'gst_no'                            => $gst_no,
                                'name'                      => $name,
                                'full_address'                      => $full_address,
                                'holding_no'                        => $holding_no,
                                'street'                            => $street,
                                'district'                          => $district,
                                'state'                             => $state,
                                'pincode'                           => $pincode,
                                'location'                          => $location,
                                'phone'                             => $phone,
                                // 'email'                          => $email,
                                'member_type'                       => $member_type_id,
                                'gst_certificate'                   => $gst_docs,
                                'contact_person_name'               => $contact_person_name,
                                'contact_person_designation'        => $contact_person_designation,
                                'contact_person_document'           => $pan_docs,
                                'bank_name'                         => $bank_name,
                                'branch_name'                       => $branch_name,
                                'ifsc_code'                         => $ifsc_code,
                                'account_type'                      => $account_type,
                                'account_number'                    => $account_number,
                                'cancelled_cheque'                  => $cheque_docs,
                            ];
                            // pr($fields);
                            $this->common_model->save_data('user', $fields, $uId, 'id');
                            $apiStatus          = TRUE;
                            http_response_code(200);
                            $apiMessage         = 'Profle Updated Successfully !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function sendEmailOTP()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => 1]);
                    if($getUser){
                        
                        $remember_token = rand(100000,999999);
                        $postData = [
                            'remember_token'        => $remember_token
                        ];
                        $this->common_model->save_data('user', ['remember_token' => $remember_token], $getUser->id, 'id');

                        $mailData                   = [
                            'id'    => $getUser->id,
                            'email' => $getUser->email,
                            'otp'   => $remember_token,
                        ];
                        $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                        $subject                    = $generalSetting->site_name.' :: Email Verify OTP';
                        $message                    = view('email-templates/otp',$mailData);
                        // echo $message;die;
                        // $this->sendMail($getUser->email, $subject, $message);

                        /* email log save */
                            $postData2 = [
                                'name'                  => $getUser->name,
                                'email'                 => $getUser->email,
                                'subject'               => $subject,
                                'message'               => $message
                            ];
                            $this->common_model->save_data('email_logs', $postData2, '', 'id');
                        /* email log save */

                        $apiResponse                        = $mailData;

                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function verifyEmail()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['otp'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => 1]);
                    if($getUser){
                        $remember_token  = $getUser->remember_token;
                        if($remember_token == $requestData['otp']){
                            $this->common_model->save_data('user', ['remember_token' => '', 'email_verify' => 1, 'email_verified_at' => date('Y-m-d H:i:s')], $getUser->id, 'id');
                            $apiResponse        = [
                                'id'    => $getUser->id,
                                'email' => $getUser->email
                            ];
                            $apiStatus                          = TRUE;
                            http_response_code(200);
                            $apiMessage                         = 'Email Verified Successfully !!!';
                            $apiExtraField                      = 'response_code';
                            $apiExtraData                       = http_response_code();
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(404);
                            $apiMessage         = 'OTP Mismatched !!!';
                            $apiExtraField      = 'response_code';
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function sendMobileOTP()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => 1]);
                    if($getUser){
                        $mobile_otp = rand(100000,999999);
                        $postData = [
                            'mobile_otp'        => $mobile_otp
                        ];
                        $this->common_model->save_data('user', ['mobile_otp' => $mobile_otp], $getUser->id, 'id');
                        /* send sms */
                            $memberType             = $this->common_model->find_data('ecomm_member_types', 'row', ['id' => $checkUser->member_type], 'name');
                            $message = "Dear ".(($memberType)?$memberType->name:'ECOEX').", ".$mobile_otp." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
                            $mobileNo = (($getUser)?$getUser->phone:'');
                            $this->sendSMS($mobileNo,$message);
                        /* send sms */
                        $mailData                   = [
                            'id'    => $getUser->id,
                            'email' => $getUser->email,
                            'phone' => $getUser->phone,
                            'otp'   => $mobile_otp,
                        ];
                        $apiResponse                        = $mailData;
                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function verifyMobile()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['otp'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => 1]);
                    if($getUser){
                        $mobile_otp  = $getUser->mobile_otp;
                        if($mobile_otp == $requestData['otp']){
                            $this->common_model->save_data('user', ['mobile_otp' => '', 'phone_verify' => 1, 'phone_verified_at' => date('Y-m-d H:i:s')], $getUser->id, 'id');
                            $apiResponse        = [
                                'id'    => $getUser->id,
                                'email' => $getUser->email,
                                'phone' => $getUser->phone,
                            ];
                            $apiStatus                          = TRUE;
                            http_response_code(200);
                            $apiMessage                         = 'Mobile Verified Successfully !!!';
                            $apiExtraField                      = 'response_code';
                            $apiExtraData                       = http_response_code();
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(404);
                            $apiMessage         = 'OTP Mismatched !!!';
                            $apiExtraField      = 'response_code';
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function deleteAccount()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        // $this->common_model->save_data('user', ['status' => '3'], $uId, 'id');
                        // $this->common_model->delete_data('ecomm_user_devices', $uId, 'user_id');

                        $postData   = array(
                            'user_type'             => $getUser->type,
                            'entity_name'           => $getUser->name,
                            'email'                 => $getUser->email,
                            'is_email_verify'       => 1,
                            'phone'                 => $getUser->phone1,
                            'is_phone_verify'       => 1,
                            'comments'              => '',
                        );
                        // pr($postData);
                        $this->common_model->save_data('ecomm_delete_account_requests', $postData, '', 'id');

                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Account Deleted Successfully !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getProduct()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        $assignItems = $this->common_model->find_data('ecomm_company_items', 'array', ['company_id' => $getUser->parent_id, 'status' => 1, 'is_approved' => 1], 'id,alias_name,hsn,unit');
                        // pr($assignCategory);
                        if($assignItems){
                            foreach($assignItems as $assignItem){
                                $getUnit       = $this->common_model->find_data('ecomm_units', 'row', ['status' => 1, 'id' => $assignItem->unit], 'id,name');
                                $apiResponse[]        = [
                                    'id'            => $assignItem->id,
                                    'name'          => $assignItem->alias_name,
                                    'hsn'           => $assignItem->hsn,
                                    'unit_name'     => (($getUnit)?$getUnit->name:''),
                                ];
                            }
                        }
                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getNotifications()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['page_no'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                $page_no                    = $requestData['page_no'];
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        $orderBy[0]     = ['field' => 'id', 'type' => 'DESC'];
                        $limit          = 15; // per page elements
                        if($page_no == 1){
                            $offset = 0;
                        } else {
                            $offset = (($limit * $page_no) - $limit); // ((15 * 3) - 15)
                        }
                        $notifications  = $this->common_model->find_data('notifications', 'array', ['status' => 1, 'is_send' => 1], 'id,title,description,send_timestamp,users', '', '', $orderBy, $limit, $offset);
                        if($notifications){
                            foreach($notifications as $notification){
                                $users = json_decode($notification->users);
                                if(in_array($uId, $users)){
                                    $apiResponse[]        = [
                                        'id'                    => $notification->id,
                                        'title'                 => $notification->title,
                                        'description'           => $notification->description,
                                        'send_timestamp'        => date_format(date_create($notification->send_timestamp), "M d, Y h:i A"),
                                    ];
                                }
                            }
                        }
                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function updateProfileImage()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['profile_image'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        $profile_image_post                            = $requestData['profile_image'];
                        /* profile image */
                            if(!empty($profile_image_post)){
                                $profile_image      = $profile_image_post[0];
                                $upload_type        = $profile_image['type'];
                                if($upload_type != 'image/jpeg' && $upload_type != 'image/jpg' && $upload_type != 'image/png'){
                                    $apiStatus          = FALSE;
                                    http_response_code(404);
                                    $apiMessage         = 'Please Upload Profile Image !!!';
                                    $apiExtraField      = 'response_code';
                                    $apiExtraData       = http_response_code();
                                } else {
                                    $upload_base64      = $profile_image['base64'];
                                    $img                = $upload_base64;
                                    
                                    $data           = base64_decode($img);
                                    $fileName       = uniqid() . '.jpg';
                                    $file           = 'public/uploads/user/' . $fileName;
                                    $success        = file_put_contents($file, $data);
                                    $profileImage   = $fileName;
                                }
                            } else {
                                $profileImage = $getUser->profile_image;
                            }
                        /* profile image */
                        $fields = [
                            'profile_image'                            => $profileImage,
                        ];
                        $this->common_model->save_data('user', $fields, $uId, 'id');

                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Profle Image Updated Successfully !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getHoliday()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        $orderBy[0]         = ['field' => 'id', 'type' => 'ASC'];
                        $getEvents          = $this->common_model->find_data('event', 'array', '', 'title,start_event', '', '', $orderBy);
                        if($getEvents){
                            foreach($getEvents as $getEvent){
                                $apiResponse[]        = [
                                    'start_event'                       => (($getEvent)?date_format(date_create($getEvent->start_event), "M d, Y"):''),
                                    'title'                             => $getEvent->title,
                                ];
                            }
                        }

                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function markAttendance()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['punch_type', 'latitude', 'longitude', 'userImage'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        // pr($requestData);die;
                        $punch_type = $requestData['punch_type'];
                        $latitude   = $requestData['latitude'];
                        $longitude  = $requestData['longitude'];

                        $orderBy[0]     = ['field' => 'id', 'type' => 'DESC'];
                        $checkPunchIn = $this->common_model->find_data('attendances', 'row', ['user_id' => $uId, 'punch_date' => date('Y-m-d'), 'status' => 1], '', '', '', $orderBy);
                        if(!$checkPunchIn){
                            $fields = [
                                'user_id' => $uId,
                                'punch_date' => date('Y-m-d'),
                            ];
                            $attenId = $this->common_model->save_data('attendances', $fields, '', 'id');
                            $punch_type = 1;
                        } else {
                            $attenId = $checkPunchIn->id;
                            $punch_type = $punch_type;
                        }
                        /* profile image */
                            $profile_image_post                            = $requestData['userImage'];
                            if(!empty($profile_image_post)){
                                $profile_image      = $profile_image_post;
                                $upload_type        = $profile_image['type'];
                                if($upload_type != 'image/jpeg' && $upload_type != 'image/jpg' && $upload_type != 'image/png'){
                                    $apiStatus          = FALSE;
                                    http_response_code(200);
                                    $apiMessage         = 'Please Upload Image !!!';
                                    $apiExtraField      = 'response_code';
                                    $apiExtraData       = http_response_code();
                                } else {
                                    $upload_base64      = $profile_image['base64'];
                                    $img                = $upload_base64;
                                    
                                    $data           = base64_decode($img);
                                    $fileName       = uniqid() . '.jpg';
                                    $file           = 'public/uploads/user/' . $fileName;
                                    $success        = file_put_contents($file, $data);
                                    $user_image     = $fileName;
                                }
                            } else {
                                $apiStatus          = FALSE;
                                http_response_code(200);
                                $apiMessage         = 'Please Upload Image !!!';
                                $apiExtraField      = 'response_code';
                                $apiExtraData       = http_response_code();
                            }
                        /* profile image */

                        $address    = $this->geolocationaddress($latitude, $longitude);
                        $punch_date = date('Y-m-d');
                        if($punch_type == 1){
                            $punch_in_time      = date('H:i:s');
                            $punch_in_lat       = $latitude;
                            $punch_in_lng       = $longitude;
                            $punch_in_address   = $address;

                            $from_time          = strtotime($punch_date." ".$punch_in_time);
                            $to_time            = strtotime($punch_date." 23:59:00");
                            $attendance_time    = round(abs($to_time - $from_time) / 60,2);

                            $fields2 = [
                                'punch_in_time'         => $punch_in_time,
                                'punch_in_lat'          => $punch_in_lat,
                                'punch_in_lng'          => $punch_in_lng,
                                'punch_in_address'      => $punch_in_address,
                                'punch_in_image'        => $user_image,
                                'punch_out_time'        => '',
                                'punch_out_lat'         => '',
                                'punch_out_lng'         => '',
                                'punch_out_address'     => '',
                                'punch_out_image'       => '',
                                'status'                => 1,
                                'attendance_time'       => $attendance_time,
                            ];
                            // pr($fields2);
                            $this->common_model->save_data('attendances', $fields2, $attenId, 'id');
                            $apiMessage         = 'Attendance Punch In Successfully !!!';
                        } elseif($punch_type == 2){
                            $punch_out_time      = date('H:i:s');
                            $punch_out_lat       = $latitude;
                            $punch_out_lng       = $longitude;
                            $punch_out_address   = $address;

                            $punch_in_time      = $checkPunchIn->punch_in_time;
                            $from_time          = strtotime($punch_date." ".$punch_in_time);
                            $to_time            = strtotime($punch_date." ".$punch_out_time);
                            $attendance_time    = round(abs($to_time - $from_time) / 60,2);

                            $fields2 = [
                                'punch_out_time'        => $punch_out_time,
                                'punch_out_lat'         => $punch_out_lat,
                                'punch_out_lng'         => $punch_out_lng,
                                'punch_out_address'     => $punch_out_address,
                                'punch_out_image'       => $user_image,
                                'status'                => 2,
                                'attendance_time'       => $attendance_time,
                            ];
                            $this->common_model->save_data('attendances', $fields2, $attenId, 'id');
                            $apiMessage         = 'Punch Out Successfully !!!';
                        } else {
                            $punch_out_time = date('H:i:s');
                            $punch_in_lat       = $latitude;
                            $punch_in_lng       = $longitude;
                            $punch_in_address   = $address;

                            $fields2 = [
                                'punch_out_time'        => $punch_out_time,
                                'punch_out_lat'         => $punch_out_lat,
                                'punch_out_lng'         => $punch_out_lng,
                                'punch_out_address'     => $punch_out_address,
                                'punch_out_image'       => $user_image,
                                'status'                => 2,
                            ];
                            $this->common_model->save_data('attendances', $fields2, $attenId, 'id');
                            $apiMessage         = 'Punch Out Successfully !!!';
                        }

                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getMonthAttendance(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['attn_month_year'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        
                        $attn_month_year    = explode("/", $requestData['attn_month_year']);
                        $month              = $attn_month_year[0];
                        $year               = $attn_month_year[1];

                        $list=array();

                        for($d=1; $d<=31; $d++)
                        {
                            $time=mktime(12, 0, 0, $month, $d, $year);          
                            if (date('m', $time)==$month)       
                                $list[]=date('Y-m-d', $time);
                        }
                        $markDates          = [];
                        $trackerLast7Days   = [];
                        if(!empty($list)){
                            $present_count  = 0;
                            $halfday_count  = 0;
                            $late_count     = 0;
                            $absent_count   = 0;

                            for($p=0;$p<count($list);$p++){
                                $punch_date = $list[$p];

                                $today = date('Y-m-d');
                                if($punch_date >= $today){
                                    $disableTouchEvent = 1;
                                } else {
                                    $disableTouchEvent = 0;
                                }

                                $checkAttn = $this->common_model->find_data('attendances', 'row', ['user_id' => $uId, 'punch_date' => $punch_date]);
                                if($checkAttn){
                                    $disableTouchEvent  = 0;
                                    $orderBy[0]         = ['field' => 'id', 'type' => 'asc'];
                                    $attnList           = $this->common_model->find_data('attendances', 'array', ['user_id' => $uId, 'punch_date' => $punch_date], 'attendance_time', '', '', $orderBy);
                                    $tot_attn_time      = 0;
                                    if($attnList){
                                        foreach($attnList as $attnRow){
                                            $tot_attn_time      += $attnRow->attendance_time;
                                        }
                                    }
                                    $attendance_time    = $tot_attn_time;
                                    $isAbsent           = 0;
                                    $isHalfday          = 0;
                                    $isFullday          = 0;
                                    $isLate             = 0;
                                    if($attendance_time < 240){
                                        $isAbsent       = 1;
                                        $isHalfday      = 0;
                                        $isFullday      = 0;
                                        if($checkAttn->punch_in_time > '10:00:58'){
                                            $isLate     = 1;
                                        }
                                    } elseif($attendance_time >= 240 && $attendance_time < 480){
                                        $isAbsent       = 0;
                                        $isHalfday      = 1;
                                        $isFullday      = 0;
                                        if($checkAttn->punch_in_time > '10:00:58'){
                                            $isLate     = 1;
                                        }
                                    } elseif($attendance_time >= 480){
                                        $isAbsent       = 0;
                                        $isHalfday      = 0;
                                        $isFullday      = 1;
                                        if($checkAttn->punch_in_time > '10:00:58'){
                                            $isLate     = 1;
                                        }
                                    }

                                    // .Present - #469148
                                    // .Absent - #F41F22
                                    // .Half Day- #E4AA39
                                    // .Late - #1e81b0
                                    // .Punchout Pending - #76E21B
                                    // .Holiday - #D623EA
                                    // .Disabled -#D5d5ce

                                    if($disableTouchEvent){
                                        $backgroundColor = '#D5d5ce';
                                    } else {
                                        $checkHoliday = $this->common_model->find_data('event', 'row', ['start_event' => $punch_date]);
                                        if($checkHoliday){
                                            $backgroundColor = '#469148';
                                            $disableTouchEvent = 0;
                                            // $present_count++;
                                        } else {
                                            if($isAbsent){
                                                $backgroundColor = '#F41F22';
                                                $absent_count++;
                                            }
                                            if($isHalfday){
                                                $backgroundColor = '#E4AA39';
                                                $halfday_count++;
                                                // $present_count++;
                                            }
                                            if($isFullday){
                                                $backgroundColor = '#469148';
                                                // $present_count++;
                                            }
                                            if($checkAttn->status == 1){
                                                $backgroundColor = '#76E21B';
                                                // $present_count++;
                                            }
                                            if($checkAttn->punch_in_time > '10:00:58'){
                                                $backgroundColor = '#1e81b0';
                                                $late_count++;
                                                
                                            }
                                        }
                                        $present_count++;
                                    }
                                    
                                    $markDates[]        = [
                                        $punch_date => [
                                            'marked' => 0,
                                            'disabled' => 0,
                                            'disableTouchEvent' => $disableTouchEvent,
                                            'customStyles' => [
                                                'container' => [
                                                    'backgroundColor' => $backgroundColor,
                                                    'width' => 'WIDTH * 0.1',
                                                    'height' => 'WIDTH * 0.1',
                                                    'borderRadius' => 5,
                                                    'justifyContent' => 'center',
                                                    'alignItems' => 'center',
                                                ]
                                            ]
                                        ]
                                    ];
                                } else {
                                    $isAbsent   = 1;
                                    $isHalfday  = 0;
                                    $isFullday  = 0;
                                    $isLate     = 0;
                                    if($disableTouchEvent){
                                        $backgroundColor = '#D5d5ce';
                                    } else {
                                        $checkHoliday = $this->common_model->find_data('event', 'row', ['start_event' => $punch_date]);
                                        if($checkHoliday){
                                            $backgroundColor = '#D623EA';
                                            $disableTouchEvent = 1;
                                        } else {
                                            if($isAbsent){
                                                $backgroundColor = '#F41F22';
                                                $absent_count++;
                                            }
                                            if($isHalfday){
                                                $backgroundColor = '#E4AA39';
                                                $halfday_count++;
                                                $present_count++;
                                            }
                                            if($isFullday){
                                                $backgroundColor = '#469148';
                                            }
                                        }
                                    }
                                    $markDates[]        = [
                                        $punch_date => [
                                            'marked' => 0,
                                            'disabled' => 0,
                                            'disableTouchEvent' => $disableTouchEvent,
                                            'customStyles' => [
                                                'container' => [
                                                    'backgroundColor' => $backgroundColor,
                                                    'width' => 'WIDTH * 0.1',
                                                    'height' => 'WIDTH * 0.1',
                                                    'borderRadius' => 5,
                                                    'justifyContent' => 'center',
                                                    'alignItems' => 'center',
                                                ]
                                            ]
                                        ]
                                    ];
                                }
                            }

                            $applicationSetting     = $this->common_model->find_data('application_settings', 'row');
                            /* last 7 days tracker report */
                                $last7Days          = $this->getLastNDays(7, 'Y-m-d');
                                if(!empty($last7Days)){
                                    for($t=0;$t<count($last7Days);$t++){
                                        $loopDate           = $last7Days[$t];
                                        $dayWiseBooked      = $this->db->query("SELECT sum(hour) as tothour, date_today, sum(min) as totmin FROM `timesheet` where user_id='$uId' and date_added LIKE '$loopDate'")->getRow();
                                        $tothour                = $dayWiseBooked->tothour * 60;
                                        $totmin                 = $dayWiseBooked->totmin;
                                        $totalMin               = ($tothour + $totmin);
                                        $booked_effort          = intdiv($totalMin, 60).'.'. ($totalMin % 60);
                                        $getDesklogTime         = $this->db->query("SELECT time_at_work FROM `desklog_report` where tracker_user_id='$uId' and insert_date LIKE '%$loopDate%'")->getRow();
                                        // echo $this->db->getLastQuery();
                                        $desklog_time           = (($getDesklogTime)?$getDesklogTime->time_at_work:'');
                                        $desklog_time1           = str_replace("m","",$desklog_time);
                                        $desklog_time2           = str_replace("h ",".",$desklog_time1);
                                        $trackerLast7Days[]     = [
                                            'date_no'       => date_format(date_create($last7Days[$t]), "M d, Y"),
                                            'day_name'      => date('D', strtotime($last7Days[$t])),
                                            'booked_time'   => $booked_effort,
                                            'desklog_time'  => (($desklog_time != '')?$desklog_time2:$desklog_time)
                                        ];
                                    }
                                }
                            /* last 7 days tracker report */

                            $apiResponse        = [
                                'present_count'     => $present_count,
                                'halfday_count'     => $halfday_count,
                                'late_count'        => $late_count,
                                'absent_count'      => $absent_count,
                                'is_desklog_use'    => $applicationSetting->is_desklog_use,
                                'markDates'         => $markDates,
                                'trackerLast7Days'  => $trackerLast7Days,
                            ];

                            $apiStatus          = TRUE;
                            http_response_code(200);
                            $apiMessage         = 'Data Available !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getSingleAttendance()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['attn_date'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        
                        $attn_date      = $requestData['attn_date'];
                        $orderBy[0]     = ['field' => 'id', 'type' => 'DESC'];
                        $checkAttn      = $this->common_model->find_data('attendances', 'row', ['user_id' => $uId, 'punch_date' => $attn_date], '', '', '', $orderBy);
                        if($checkAttn){
                            // $attendance_time = $checkAttn->attendance_time;
                            

                            $attnDatas          = [];
                            $orderBy[0]         = ['field' => 'id', 'type' => 'asc'];
                            $attnList           = $this->common_model->find_data('attendances', 'array', ['user_id' => $uId, 'punch_date' => $attn_date], '', '', '', $orderBy);
                            $tot_attn_time      = 0;
                            if($attnList){
                                foreach($attnList as $attnRow){
                                    if($attnRow->status == 1){
                                        $attnDatas[]          = [
                                            'punch_date'            => date_format(date_create($attn_date), "M d, Y"),
                                            'label'                 => 'In',
                                            'time'                  => date_format(date_create($attnRow->punch_in_time), "h:i A"),
                                            'address'               => (($attnRow->punch_in_address != '')?$attnRow->punch_in_address:''),
                                            'image'                 => getenv('app.uploadsURL').'user/'.$attnRow->punch_in_image,
                                            'type'                  => 1
                                        ];
                                    }
                                    if($attnRow->status == 2){
                                        $attnDatas[]          = [
                                            'punch_date'            => date_format(date_create($attn_date), "M d, Y"),
                                            'label'                 => 'In',
                                            'time'                  => date_format(date_create($attnRow->punch_in_time), "h:i A"),
                                            'address'               => (($attnRow->punch_in_address != '')?$attnRow->punch_in_address:''),
                                            'image'                 => getenv('app.uploadsURL').'user/'.$attnRow->punch_in_image,
                                            'type'                  => 1
                                        ];
                                        $attnDatas[]          = [
                                            'punch_date'            => date_format(date_create($attn_date), "M d, Y"),
                                            'label'                 => 'Out',
                                            'time'                  => (($attnRow->punch_out_time != '')?date_format(date_create($attnRow->punch_out_time), "h:i A"):''),
                                            'address'               => (($attnRow->punch_out_address != '')?$attnRow->punch_out_address:''),
                                            'image'                 => (($attnRow->punch_out_image != '')?getenv('app.uploadsURL').'user/'.$attnRow->punch_out_image:''),
                                            'type'                  => 2
                                        ];
                                    }
                                    $tot_attn_time      += $attnRow->attendance_time;
                                }
                            }

                            $isAbsent   = 0;
                            $isHalfday  = 0;
                            $isFullday  = 0;
                            $isLate     = 0;
                            $orderBy[0]         = ['field' => 'id', 'type' => 'asc'];
                            $getFirstAttn       = $this->common_model->find_data('attendances', 'row', ['user_id' => $uId, 'punch_date' => $attn_date], '', '', '', $orderBy);

                            if($tot_attn_time < 240){
                                $isAbsent   = 1;
                                $isHalfday  = 0;
                                $isFullday  = 0;
                                if($getFirstAttn->punch_in_time > '10:00:58'){
                                    $isLate     = 1;
                                }
                            } elseif($tot_attn_time >= 240 && $tot_attn_time < 480){
                                $isAbsent   = 0;
                                $isHalfday  = 1;
                                $isFullday  = 0;

                                if($getFirstAttn->punch_in_time > '10:00:58'){
                                    $isLate     = 1;
                                }
                            } elseif($tot_attn_time >= 480){
                                $isAbsent   = 0;
                                $isHalfday  = 0;
                                $isFullday  = 1;
                                if($getFirstAttn->punch_in_time > '10:00:58'){
                                    $isLate     = 1;
                                }
                            }

                            $apiResponse        = [
                                'punch_date'            => date_format(date_create($checkAttn->punch_date), "M d, Y"),
                                'punch_in_time'         => date_format(date_create($checkAttn->punch_in_time), "h:i A"),
                                'punch_in_address'      => $checkAttn->punch_in_address,
                                'punch_in_image'        => getenv('app.uploadsURL').'user/'.$checkAttn->punch_in_image,
                                'punch_out_time'        => (($checkAttn->punch_out_time != '')?date_format(date_create($checkAttn->punch_out_time), "h:i A"):''),
                                'punch_out_address'     => (($checkAttn->punch_out_address != '')?$checkAttn->punch_out_address:''),
                                'punch_out_image'       => (($checkAttn->punch_out_image != '')?getenv('app.uploadsURL').'user/'.$checkAttn->punch_out_image:''),
                                'isAbsent'              => $isAbsent,
                                'isHalfday'             => $isHalfday,
                                'isFullday'             => $isFullday,
                                'isLate'                => $isLate,
                                'note'                  => (($checkAttn->note != '')?$checkAttn->note:''),
                                'status'                => $checkAttn->status,
                                'attendance_time'       => $tot_attn_time,
                                'attnDatas'             => $attnDatas
                            ];

                            $apiStatus          = TRUE;
                            http_response_code(200);
                            $apiMessage         = 'Attendance Available !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(200);
                            $apiMessage         = 'You Are Absent !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function updateNote()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['note_date', 'note'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $note_date                  = date_format(date_create($requestData['note_date']), "Y-m-d");
                $note                       = $requestData['note'];
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId]);
                    if($getUser){
                        $checkAttns  = $this->common_model->find_data('attendances', 'array', ['user_id' => $uId, 'punch_date' => $note_date]);
                        $fields     = [
                            'note' => $note
                        ];
                        if($checkAttns){
                            foreach($checkAttns as $checkAttn){
                                $this->common_model->save_data('attendances', $fields, $checkAttn->id, 'id');
                            }
                            $apiMessage         = 'Note Updated Successfully !!!';
                        } else {
                            $this->common_model->save_data('attendances', $fields, '', 'id');
                            $apiMessage         = 'Note Inserted Successfully !!!';
                        }
                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public static function geolocationaddress($lat, $long)
        {
            $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=AIzaSyDHeAHBftV28TQMq2iqyO730UC6O0WoE9M";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $geocode);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($response);
            $dataarray = get_object_vars($output);
            if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
                if (isset($dataarray['results'][0]->formatted_address)) {
                    $address = $dataarray['results'][0]->formatted_address;
                } else {
                    $address = 'Not Found';
                }
            } else {
                $address = 'Not Found';
            }
            return $address;
        }
    /* after login */
    
    public function getLastNDays($days, $format = 'd/m'){
        $m = date("m"); $de= date("d"); $y= date("Y");
        $dateArray = array();
        for($i=0; $i<=$days-1; $i++){
            $dateArray[] = date($format, mktime(0,0,0,$m,($de-$i),$y)); 
        }
        return array_reverse($dateArray);
    }
    /*
    Get http response code
    Author : Subhomoy
    */
    private function getResponseCode($code = NULL){
        if ($code !== NULL) {
            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Unauthenticated Request !!!'; break;
                case 401: $text = 'Token Not Found !!!'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Token Has Expired !!!'; break;
                case 404: $text = 'User Not Found !!!'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'All Data Are Not Present !!!'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
            }
            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            header($protocol . ' ' . $code . ' ' . $text);
            $GLOBALS['http_response_code'] = $code;
        } else {
            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
            $text = '';
        }
        return $text;
    }
    /* extract header token */
    private function extractToken($token){
        $app_token = explode("Authorization: ", $token);
        $app_access_token = $app_token[1];
        return $app_access_token;
    }
    /* extract header token */
    /*
    Generate JWT tokens for authentication
    Author : Subhomoy
    */
    private static function generateToken($userId, $email, $phone){
        $token      = array(
            'id'                => $userId,
            'email'             => $email,
            'phone'             => $phone,
            'exp'               => time() + (30 * 24 * 60 * 60) // 30 days
        );
        // pr($token);
        return JWT::encode($token, TOKEN_SECRET, 'HS256');
    }
    /*
    Check Authentication
    Author : Subhomoy
    */
    private function tokenAuth($appAccessToken){
        $this->db   = \Config\Database::connect();
        $headers    = apache_request_headers();
        if (isset($appAccessToken) && !empty($appAccessToken)) :
            $userdata = $this->matchToken($appAccessToken);
            // echo $appAccessToken;
            if ($userdata['status']) :
                $checkToken =  $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $appAccessToken]);
                // echo $this->db->getLastQuery();
                // pr($checkToken);
                if (!empty($checkToken)) :
                    if ($userdata['data']->exp && $userdata['data']->exp > time()) :
                        $tokenStatus = array(TRUE, $userdata['data']->id, $userdata['data']->email, $userdata['data']->phone, $userdata['data']->exp);
                    else :
                        $tokenStatus = array(FALSE, 'Token Has Expired 1 !!!');
                    endif;
                else :
                    $tokenStatus = array(FALSE, 'Token Has Expired 2 !!!');
                endif;
            else :
                $tokenStatus = array(FALSE, 'Token Not Found !!!');
            endif;
        else :
            $tokenStatus = array(FALSE, 'Token Not Found In Request !!!');
        endif;
        if ($tokenStatus[0]) :
            $this->userId           = $tokenStatus[1];
            $this->userEmail        = $tokenStatus[2];
            $this->userMobile       = $tokenStatus[3];
            $this->userExpiry       = $tokenStatus[4];
            // pr($tokenStatus);
            return array('status' => TRUE, 'data' => $tokenStatus);
        else :
            return array('status' => FALSE, 'data' => $tokenStatus[1]);
            // $this->response_to_json(FALSE, $tokenStatus[1]);
        endif;
    }
    /*
    Match JWT token with user token saved in database
    Author : Subhomoy
    */
    private static function matchToken($token){
        // try{
        //     // $decoded    = JWT::decode($token, TOKEN_SECRET, 'HS256');
        //     $decoded    = JWT::decode($token, new Key(TOKEN_SECRET, 'HS256'));
        //     // pr($decoded);
        // } catch (\Exception $e) {
        //     //echo 'Caught exception: ',  $e->getMessage(), "\n";
        //     return array('status' => FALSE, 'data' => '');
        // }
        
        // return array('status' => TRUE, 'data' => $decoded);

        try{
            $key = "1234567890qwertyuiopmnbvcxzasdfghjkl";
            $decoded = JWT::decode($token, $key, array('HS256'));
            // $decodedData = (array) $decoded;
        } catch (\Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
            return array('status' => FALSE, 'data' => '');
        }
        return array('status' => TRUE, 'data' => $decoded);
    }
}
