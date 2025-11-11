<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Libraries\CreatorJwt;
use App\Libraries\JWT;
use CodeIgniter\CLI\Console;
use DateTime;

class ApiController extends BaseController
{
    /* before login */
    public function getAppSetting()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $headerData            = $this->request->headers();
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $generalSetting = $this->common_model->find_data('general_settings', 'row');
            if ($generalSetting) {
                $apiResponse = [
                    'company_name'              => $generalSetting->company_name,
                    'site_name'                 => $generalSetting->site_name,
                    'site_phone'                => $generalSetting->site_phone,
                    'site_mail'                 => $generalSetting->site_mail,
                    'site_url'                  => $generalSetting->site_url,
                    'firebase_server_key'       => $generalSetting->firebase_server_key,
                    'gst_api_code'              => $generalSetting->gst_api_code,
                    'theme_color'               => $generalSetting->theme_color,
                    'font_color'                => $generalSetting->font_color,
                    'site_logo'                 => getenv('app.uploadsURL') . $generalSetting->site_logo,
                ];
            }
            http_response_code(200);
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
                        'company_name'              => $generalSetting->company_name,
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
            // CORS headers for immediate effect
            header('Access-Control-Allow-Origin: http://localhost:3000');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');

            // Handle preflight request
            if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                return $this->response->setStatusCode(200);
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
    public function getStaticPages()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['page_slug'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            http_response_code(406);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $page = $this->common_model->find_data('ecomm_pages', 'row', ['slug' => $requestData['page_slug']]);
            if ($page) {
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
    public function forgotPassword()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['type', 'email'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            http_response_code(406);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $checkEmail                 = $this->common_model->find_data('user', 'row', ['email' => $requestData['email']]);
            if ($checkEmail) {
                $remember_token  = rand(100000, 999999);
                $this->common_model->save_data('user', ['remember_token' => $remember_token], $checkEmail->id, 'id');
                $mailData                   = [
                    'id'    => $checkEmail->id,
                    'email' => $checkEmail->email,
                    'otp'   => $remember_token,
                ];
                $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                $subject                    = $generalSetting->site_name . ' :: Forgot Password OTP';
                $message                    = view('email-templates/otp', $mailData);
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
    public function validateOTP()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['id', 'otp'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            http_response_code(406);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $getUser = $this->common_model->find_data('user', 'row', ['id' => $requestData['id']]);
            if ($getUser) {
                $remember_token  = $getUser->remember_token;
                if ($remember_token == $requestData['otp']) {
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
    public function resendOtp()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['id'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            http_response_code(406);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $id         = $requestData['id'];
            $getUser    = $this->common_model->find_data('user', 'row', ['id' => $id, 'status' => '1']);
            if ($getUser) {
                $remember_token = rand(100000, 999999);
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
                $subject                    = $generalSetting->site_name . ' :: Forgot Password OTP';
                $message                    = view('email-templates/otp', $mailData);
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            http_response_code(406);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $id         = $requestData['id'];
            $getUser    = $this->common_model->find_data('user', 'row', ['id' => $id, 'status' => '1']);
            if ($getUser) {
                if ($requestData['password'] == $requestData['confirm_password']) {
                    $this->common_model->save_data('user', ['password' => md5($requestData['password'])], $getUser->id, 'id');

                    $mailData        = [
                        'id'                => $getUser->id,
                        'name'              => $getUser->name,
                        'email'             => $getUser->email,
                        'password'          => $requestData['password'],
                    ];
                    $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                    $subject                    = $generalSetting->site_name . ' :: Reset Password';
                    $message                    = view('email-templates/change-password', $mailData);
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $email                      = $requestData['email'];
            $password                   = $requestData['password'];
            $device_token               = $requestData['device_token'];
            $fcm_token                  = $requestData['fcm_token'];
            $device_type                = trim($headerData['Source'], "Source: ");
            $checkUser                  = $this->common_model->find_data('user', 'row', ['email' => $email, 'status' => '1']);
            if ($checkUser) {

                if ($checkUser->status != '3') {
                    if (md5($password) == $checkUser->password) {

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
                        if (!$checkUserTokenExist) {
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
                            'activity_details'  => $checkUser->type . ' Sign In Success',
                        ];
                        // pr($userActivityData);
                        $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
                        $name = $checkUser->name;
                        $getDesignation                  = $this->common_model->find_data('user_category', 'row', ['id' => $checkUser->category], 'name');
                        $apiResponse = [
                            'user_id'               => $user_id,
                            'name'                  => $name,
                            'email'                 => $checkUser->email,
                            'phone'                 => $checkUser->phone1,
                            'type'                  => $checkUser->type,
                            'designation'           => (($getDesignation) ? $getDesignation->name : ''),
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
                        $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
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
                    $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
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
                $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
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
        $requiredFields     = ['phone'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            // $type                       = $requestData['type'];
            $phone                      = $requestData['phone'];
            $checkUser                  = $this->common_model->find_data('user', 'row', ['phone1' => $phone, 'status' => '1']);
            if ($checkUser) {
                $mobile_otp = rand(100000, 999999);
                $postData = [
                    'remember_token'        => $mobile_otp
                ];
                $this->common_model->save_data('user', $postData, $checkUser->id, 'id');
                /* send sms */
                $name       = $checkUser->name;
                $mobileNo   = (($checkUser) ? $checkUser->phone1 : '');
                # code commneted by @Shubha75 on 2025-06-17
                // $message    = "Dear ".$name.", ".$mobile_otp." is your verification OTP for ProTime Manager at KEYLINE. Do not share this OTP with anyone for security reasons.";

                # new code added by @Shubha75 on 2025-06-17
                $message    = "Dear $name, $mobile_otp is you verification OTP for registration at KEYLINE";
                # old code commented by @Shubha75 on 2025-06-18
                // $this->sendSMS($mobileNo, $message);

                # code added by @Shubha75 on 2025-06-18
                $this->common_model->sendSMS('91' . $mobileNo, $message);
                /* send sms */

                $mailData                   = [
                    'id'    => $checkUser->id,
                    'email' => $checkUser->email,
                    'phone' => $checkUser->phone1,
                    'otp'   => $mobile_otp,
                ];
                $apiResponse                        = $mailData;
                $apiStatus                          = TRUE;
                $apiMessage                         = 'Please Enter OTP !!!';
            } else {
                $userActivityData = [
                    'user_email'        => '',
                    'user_name'         => '',
                    'user_type'         => 'user',
                    'ip_address'        => $this->request->getIPAddress(),
                    'activity_type'     => 0,
                    'activity_details'  => 'We Don\'t Recognize Your Phone Number',
                ];
                $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $phone                      = $requestData['phone'];
            $otp                        = $requestData['otp'];
            $device_token               = $requestData['device_token'];
            $fcm_token                  = $requestData['fcm_token'];
            $device_type                = trim($headerData['Source'], "Source: ");
            $checkUser                  = $this->common_model->find_data('user', 'row', ['phone1' => $phone, 'status' => '1']);
            if ($checkUser) {
                if ($otp == $checkUser->remember_token) {
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
                    if (!$checkUserTokenExist) {
                        $this->common_model->save_data('ecomm_user_devices', $fields, '', 'id');
                    } else {
                        $this->common_model->save_data('ecomm_user_devices', $fields, $checkUserTokenExist->id, 'id');
                    }

                    $userActivityData = [
                        'user_email'        => $checkUser->email,
                        'user_name'         => $checkUser->name,
                        'activity_type'     => 1,
                        'user_type'         => 'user',
                        'ip_address'        => $this->request->getIPAddress(),
                        'activity_details'  => $checkUser->type . ' Sign In Success',
                    ];
                    // pr($userActivityData);
                    $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');

                    $apiResponse = [
                        'user_id'               => $user_id,
                        'name'                  => $checkUser->name,
                        'email'                 => $checkUser->email,
                        'phone'                 => $checkUser->phone1,
                        'type'                  => $checkUser->type,
                        'device_type'           => $device_type,
                        'device_token'          => $device_token,
                        'fcm_token'             => $fcm_token,
                        'app_access_token'      => $app_access_token,
                    ];
                    $this->common_model->save_data('user', ['remember_token' => ''], $checkUser->id, 'id');
                    $apiStatus                          = TRUE;
                    $apiMessage                         = 'SignIn Successfully !!!';
                } else {
                    $userActivityData = [
                        'user_email'        => $checkUser->email,
                        'user_name'         => $checkUser->name,
                        'user_type'         => 'user',
                        'ip_address'        => $this->request->getIPAddress(),
                        'activity_type'     => 0,
                        'activity_details'  => 'OTP Mismatched !!!',
                    ];
                    $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
                    $apiStatus                          = FALSE;
                    $apiMessage                         = 'OTP Mismatched !!!';
                }
            } else {
                $userActivityData = [
                    'user_email'        => $email,
                    'user_name'         => '',
                    'user_type'         => 'user',
                    'ip_address'        => $this->request->getIPAddress(),
                    'activity_type'     => 0,
                    'activity_details'  => 'We Don\'t Recognize Your Phone Number',
                ];
                $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
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
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            $checkUserTokenExist        = $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $app_access_token, 'published' => 1]);
            // pr($checkUserTokenExist);
            if ($checkUserTokenExist) {
                $user_id    = $checkUserTokenExist->user_id;
                $checkUser  = $this->common_model->find_data('user', 'row', ['id' => $user_id, 'status' => 1]);
                /* user activity */
                $userActivityData = [
                    'user_email'        => (($checkUser) ? $checkUser->email : ''),
                    'user_name'         => (($checkUser) ? $checkUser->name : ''),
                    'user_type'         => (($checkUser) ? $checkUser->type : 'USER'),
                    'ip_address'        => $this->request->getIPAddress(),
                    'activity_type'     => 2,
                    'activity_details'  => 'Sign Out Successfully',
                ];
                $this->common_model->save_data('user_activities', $userActivityData, '', 'activity_id');
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $old_password               = $requestData['old_password'];
            $new_password               = $requestData['new_password'];
            $confirm_password           = $requestData['confirm_password'];
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);

            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
                    if ($getUser->password == md5($old_password)) {
                        if ($new_password == $confirm_password) {
                            if ($getUser->password != md5($new_password)) {
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
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                $generalSetting = $this->common_model->find_data('general_settings', 'row');
                if ($getUser) {
                    $getCategory         = $this->common_model->find_data('user_category', 'row', ['id' => $getUser->category], 'name');
                    $apiResponse        = [
                        'company_name'                          => $generalSetting->company_name,
                        'id'                                    => $getUser->id,
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
                        'category'                              => (($getCategory) ? $getCategory->name : ''),
                        'dob'                                   => (($getUser) ? $getUser->dob : ''),
                        'doj'                                   => (($getUser) ? $getUser->doj : ''),
                        'profile_image'                         => (($getUser->profile_image != '') ? getenv('app.uploadsURL') . 'user/' . $getUser->profile_image : getenv('app.NO_IMAGE')),
                        'work_mode'                             => $getUser->work_mode,
                        'is_tracker_user'                       => (($getUser->is_tracker_user) ? 'YES' : 'NO'),
                        'is_salarybox_user'                     => (($getUser->is_salarybox_user) ? 'YES' : 'NO'),
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
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
            $member_type_id             = ((!empty($requestData['member_type_id'])) ? $requestData['member_type_id'] : 0);

            $gst_certificate                            = $requestData['gst_certificate'];
            $contact_person_name                        = $requestData['contact_person_name'];
            $contact_person_designation                 = $requestData['contact_person_designation'];
            $contact_person_document                    = $requestData['contact_person_document'];
            if ($type == 'PLANT') {
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
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
                    $checkPhoneExist = $this->common_model->find_data('user', 'row', ['phone' => $phone, 'id!=' => $uId]);
                    if ($checkPhoneExist) {
                        $apiStatus          = FALSE;
                        http_response_code(200);
                        $apiMessage         = 'Phone No. Already Exists. Please Use Other Phone No. !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        /* gst certificate */
                        if (!empty($gst_certificate)) {
                            $gst_certificate    = $gst_certificate[0];
                            $upload_type        = $gst_certificate['type'];
                            if ($upload_type == 'application/pdf') {
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
                        if (!empty($contact_person_document)) {
                            $contact_person_document    = $contact_person_document[0];
                            $upload_type        = $contact_person_document['type'];
                            if ($upload_type == 'application/pdf') {
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
                        if (!empty($cancelled_cheque)) {
                            $cancelled_cheque    = $cancelled_cheque[0];
                            $upload_type        = $cancelled_cheque['type'];
                            if ($upload_type == 'application/pdf') {
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
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => 1]);
                if ($getUser) {

                    $remember_token = rand(100000, 999999);
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
                    $subject                    = $generalSetting->site_name . ' :: Email Verify OTP';
                    $message                    = view('email-templates/otp', $mailData);
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => 1]);
                if ($getUser) {
                    $remember_token  = $getUser->remember_token;
                    if ($remember_token == $requestData['otp']) {
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
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => 1]);
                if ($getUser) {
                    $mobile_otp = rand(100000, 999999);
                    $postData = [
                        'mobile_otp'        => $mobile_otp
                    ];
                    $this->common_model->save_data('user', ['mobile_otp' => $mobile_otp], $getUser->id, 'id');
                    /* send sms */
                    $memberType             = $this->common_model->find_data('ecomm_member_types', 'row', ['id' => $checkUser->member_type], 'name');
                    $message = "Dear " . (($memberType) ? $memberType->name : 'ECOEX') . ", " . $mobile_otp . " is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
                    $mobileNo = (($getUser) ? $getUser->phone : '');
                    $this->sendSMS($mobileNo, $message);
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => 1]);
                if ($getUser) {
                    $mobile_otp  = $getUser->mobile_otp;
                    if ($mobile_otp == $requestData['otp']) {
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
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
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
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
                    $assignItems = $this->common_model->find_data('ecomm_company_items', 'array', ['company_id' => $getUser->parent_id, 'status' => 1, 'is_approved' => 1], 'id,alias_name,hsn,unit');
                    // pr($assignCategory);
                    if ($assignItems) {
                        foreach ($assignItems as $assignItem) {
                            $getUnit       = $this->common_model->find_data('ecomm_units', 'row', ['status' => 1, 'id' => $assignItem->unit], 'id,name');
                            $apiResponse[]        = [
                                'id'            => $assignItem->id,
                                'name'          => $assignItem->alias_name,
                                'hsn'           => $assignItem->hsn,
                                'unit_name'     => (($getUnit) ? $getUnit->name : ''),
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            $page_no                    = $requestData['page_no'];
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
                    $orderBy[0]     = ['field' => 'id', 'type' => 'DESC'];
                    $limit          = 15; // per page elements
                    if ($page_no == 1) {
                        $offset = 0;
                    } else {
                        $offset = (($limit * $page_no) - $limit); // ((15 * 3) - 15)
                    }
                    $notifications  = $this->common_model->find_data('notifications', 'array', ['status' => 1, 'is_send' => 1], 'id,title,description,send_timestamp,users', '', '', $orderBy, $limit, $offset);
                    if ($notifications) {
                        foreach ($notifications as $notification) {
                            $users = json_decode($notification->users);
                            if (in_array($uId, $users)) {
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
    public function getNotes()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['page_no'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            $page_no                    = $requestData['page_no'];
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
                    $orderBy[0]     = ['field' => 'id', 'type' => 'DESC'];
                    $limit          = 15; // per page elements
                    if ($page_no == 1) {
                        $offset = 0;
                    } else {
                        $offset = (($limit * $page_no) - $limit); // ((15 * 3) - 15)
                    }
                    $attns  = $this->common_model->find_data('attendances', 'array', ['note!=' => '', 'user_id' => $uId], 'id,punch_date,note', '', '', $orderBy, $limit, $offset);
                    if ($attns) {
                        foreach ($attns as $attn) {
                            $apiResponse[]        = [
                                'id'                    => $attn->id,
                                'description'           => $attn->note,
                                'punch_date'            => date_format(date_create($attn->punch_date), "M d, Y"),
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
    // public function updateProfileImage()
    // {
    //     $apiStatus          = TRUE;
    //     $apiMessage         = '';
    //     $apiResponse        = [];
    //     $this->isJSON(file_get_contents('php://input'));
    //     $requestData        = $this->extract_json(file_get_contents('php://input'));
    //     $requiredFields     = ['profile_image'];
    //     $headerData         = $this->request->headers();
    //     if (!$this->validateArray($requiredFields, $requestData)) {
    //         $apiStatus          = FALSE;
    //         $apiMessage         = 'All Data Are Not Present !!!';
    //     }
    //     if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
    //         $Authorization              = $headerData['Authorization'];
    //         $app_access_token           = $this->extractToken($Authorization);
    //         $getTokenValue              = $this->tokenAuth($app_access_token);
    //         if ($getTokenValue['status']) {
    //             $uId        = $getTokenValue['data'][1];
    //             $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
    //             $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
    //             if ($getUser) {
    //                 $profile_image_post                            = $requestData['profile_image'];
    //                 /* profile image */
    //                 if (!empty($profile_image_post)) {
    //                     $profile_image      = $profile_image_post[0];
    //                     $upload_type        = $profile_image['type'];
    //                     if ($upload_type != 'image/jpeg' && $upload_type != 'image/jpg' && $upload_type != 'image/png') {
    //                         $apiStatus          = FALSE;
    //                         http_response_code(404);
    //                         $apiMessage         = 'Please Upload Profile Image !!!';
    //                         $apiExtraField      = 'response_code';
    //                         $apiExtraData       = http_response_code();
    //                     } else {
    //                         $upload_base64      = $profile_image['base64'];
    //                         $img                = $upload_base64;

    //                         $data           = base64_decode($img);
    //                         $fileName       = uniqid() . '.jpg';
    //                         $file           = 'public/uploads/user/' . $fileName;
    //                         $success        = file_put_contents($file, $data);
    //                         $profileImage   = $fileName;
    //                     }
    //                 } else {
    //                     $profileImage = $getUser->profile_image;
    //                 }
    //                 /* profile image */
    //                 $fields = [
    //                     'profile_image'                            => $profileImage,
    //                 ];
    //                 $this->common_model->save_data('user', $fields, $uId, 'id');

    //                 $apiStatus          = TRUE;
    //                 http_response_code(200);
    //                 $apiMessage         = 'Profle Image Updated Successfully !!!';
    //                 $apiExtraField      = 'response_code';
    //                 $apiExtraData       = http_response_code();
    //             } else {
    //                 $apiStatus          = FALSE;
    //                 http_response_code(404);
    //                 $apiMessage         = 'User Not Found !!!';
    //                 $apiExtraField      = 'response_code';
    //                 $apiExtraData       = http_response_code();
    //             }
    //         } else {
    //             http_response_code($getTokenValue['data'][2]);
    //             $apiStatus                      = FALSE;
    //             $apiMessage                     = $this->getResponseCode(http_response_code());
    //             $apiExtraField                  = 'response_code';
    //             $apiExtraData                   = http_response_code();
    //         }
    //     } else {
    //         http_response_code(400);
    //         $apiStatus          = FALSE;
    //         $apiMessage         = $this->getResponseCode(http_response_code());
    //         $apiExtraField      = 'response_code';
    //         $apiExtraData       = http_response_code();
    //     }
    //     $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    // }
    public function updateProfileImage()
    {
        $apiStatus   = TRUE;
        $apiMessage  = '';
        $apiResponse = [];

        $headerData  = $this->request->headers();

        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization      = $headerData['Authorization'];
            $app_access_token   = $this->extractToken($Authorization);
            $getTokenValue      = $this->tokenAuth($app_access_token);

            if ($getTokenValue['status']) {
                $uId    = $getTokenValue['data'][1];
                $expiry = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);

                if ($getUser) {
                    $profileImage = $getUser->profile_image;

                    // ✅ Handle form-data file upload
                    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                        $fileType     = $_FILES['profile_image']['type'];
                        $fileTmp      = $_FILES['profile_image']['tmp_name'];
                        $fileExt      = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                        $uploadDir    = FCPATH . 'public/uploads/user/';
                        $fileName     = uniqid() . '.' . strtolower($fileExt);
                        $uploadPath   = $uploadDir . $fileName;

                        if (!in_array($fileType, $allowedTypes)) {
                            $apiStatus  = FALSE;
                            http_response_code(400);
                            $apiMessage = 'Please upload a valid profile image (jpg, jpeg, png)';
                            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
                            return;
                        }

                        // Create folder if not exists
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, TRUE);
                        }

                        if (move_uploaded_file($fileTmp, $uploadPath)) {
                            // ✅ Remove old image if exists
                            if (!empty($getUser->profile_image) && file_exists($uploadDir . $getUser->profile_image)) {
                                @unlink($uploadDir . $getUser->profile_image);
                            }
                            $profileImage = $fileName;
                        } else {
                            $apiStatus  = FALSE;
                            http_response_code(500);
                            $apiMessage = 'Failed to upload profile image.';
                            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
                            return;
                        }
                    }

                    // ✅ Update database
                    $fields = [
                        'profile_image' => $profileImage,
                    ];
                    $this->common_model->save_data('user', $fields, $uId, 'id');

                    $apiStatus  = TRUE;
                    http_response_code(200);
                    $apiMessage = 'Profile image updated successfully!';
                } else {
                    $apiStatus  = FALSE;
                    http_response_code(404);
                    $apiMessage = 'User not found!';
                }
            } else {
                http_response_code($getTokenValue['data'][2]);
                $apiStatus  = FALSE;
                $apiMessage = $this->getResponseCode(http_response_code());
            }
        } else {
            http_response_code(400);
            $apiStatus  = FALSE;
            $apiMessage = $this->getResponseCode(http_response_code());
        }

        $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    }
    public function getHoliday()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $headerData         = $this->request->headers();
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
                    $currentYear        = date('Y');
                    $orderBy[0]         = ['field' => 'id', 'type' => 'ASC'];
                    $getEvents          = $this->common_model->find_data('event', 'array', ['start_event LIKE' => '%' . $currentYear . '%'], 'title,start_event', '', '', $orderBy);
                    if ($getEvents) {
                        foreach ($getEvents as $getEvent) {
                            $apiResponse[]        = [
                                'start_event'                       => (($getEvent) ? date_format(date_create($getEvent->start_event), "M d, Y") : ''),
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
    public function getEmployee()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $headerData         = $this->request->headers();
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getEmployees    = $this->common_model->find_data('user', 'array', ['status' => '1']);
                if ($getEmployees) {
                    foreach ($getEmployees as $getEmployee) {
                        $orderBy[0]     = ['field' => 'id', 'type' => 'DESC'];
                        $punch_time = $this->common_model->find_data('attendances', 'row', ['user_id' => $getEmployee->id, 'punch_date' => date('Y-m-d')], 'punch_in_time,punch_out_time,status', '', '', $orderBy);
                        $department = $this->common_model->find_data('department', 'row', ['id' => $getEmployee->department], 'deprt_name');
                        $punchout = ($punch_time) ? DateTime::createFromFormat('H:i:s', $punch_time->punch_out_time) : false;
                        $apiResponse[]        = [
                            'id'              => $getEmployee->id,
                            'name'            => $getEmployee->name,
                            'email'           => $getEmployee->email,
                            'phone'           => $getEmployee->phone1,
                            'profile_image'   => (($getEmployee->profile_image) ? base_url('public/uploads/user/' . $getEmployee->profile_image) : ''),
                            'department'      => (($department) ? $department->deprt_name : ''),
                            'punch_in_time'   => (($punch_time) ? date('h:i a', strtotime($punch_time->punch_in_time)) : ''),
                            'punch_out_time'  => (($punchout) ? $punchout->format('g:i a') : ''),
                            'punch_status'    => (($punch_time) ? (int)$punch_time->status : 0),
                        ];
                    }
                    // // Sort the array by punch_in_time DESC (latest first)
                    // usort($apiResponse, function ($a, $b) {
                    //     // return strtotime($b['punch_in_time']) - strtotime($a['punch_in_time']); //latest first 
                    //     return strtotime($a['punch_in_time']) - strtotime($b['punch_in_time']); // oldest first
                    // });   
                    usort($apiResponse, function ($a, $b) {
                        $a_time = strtotime($a['punch_in_time']);
                        $b_time = strtotime($b['punch_in_time']);

                        // Handle missing punch_in_time: move to bottom
                        if (empty($a['punch_in_time'])) return 1;
                        if (empty($b['punch_in_time'])) return -1;

                        // Sort by punch_in_time ascending (oldest first)
                        return $a_time - $b_time;

                        // Or for descending (latest first), use:
                        // return $b_time - $a_time;
                    });
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
    // public function markAttendance()
    // {
    //     $apiStatus          = TRUE;
    //     $apiMessage         = '';
    //     $apiResponse        = [];
    //     $this->isJSON(file_get_contents('php://input'));
    //     $requestData        = $this->extract_json(file_get_contents('php://input'));
    //     $requiredFields     = ['punch_type', 'latitude', 'longitude', 'userImage'];
    //     $headerData         = $this->request->headers();
    //     if (!$this->validateArray($requiredFields, $requestData)) {
    //         $apiStatus          = FALSE;
    //         $apiMessage         = 'All Data Are Not Present !!!';
    //     }
    //     if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            
    //         $Authorization              = $headerData['Authorization'];
    //         $app_access_token           = $this->extractToken($Authorization);
    //         $getTokenValue              = $this->tokenAuth($app_access_token);
    //         if ($getTokenValue['status']) {
    //             $uId        = $getTokenValue['data'][1];
    //             $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
    //             $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
    //             if ($getUser) {
    //                 $punch_type = $requestData['punch_type'];
    //                 $latitude   = $requestData['latitude'];
    //                 $longitude  = $requestData['longitude'];

    //                 $orderBy[0]     = ['field' => 'id', 'type' => 'DESC'];
    //                 $checkPunchIn = $this->common_model->find_data('attendances', 'row', ['user_id' => $uId, 'punch_date' => date('Y-m-d'), 'status' => 1], '', '', '', $orderBy);
    //                 if (!$checkPunchIn) {
    //                     $fields = [
    //                         'user_id' => $uId,
    //                         'punch_date' => date('Y-m-d'),
    //                     ];
    //                     $attenId = $this->common_model->save_data('attendances', $fields, '', 'id');
    //                     $punch_type = 1;
    //                 } else {
    //                     $attenId = $checkPunchIn->id;
    //                     $punch_type = $punch_type;
    //                 }
    //                 /* profile image */
    //                     $profile_image_post                            = $requestData['userImage'];
    //                     if (!empty($profile_image_post)) {
    //                         $profile_image      = $profile_image_post;
    //                         $upload_type        = $profile_image['type'];
    //                         if ($upload_type != 'image/jpeg' && $upload_type != 'image/jpg' && $upload_type != 'image/png') {
    //                             $apiStatus          = FALSE;
    //                             http_response_code(200);
    //                             $apiMessage         = 'Please Upload Image !!!';
    //                             $apiExtraField      = 'response_code';
    //                             $apiExtraData       = http_response_code();
    //                         } else {
    //                             $upload_base64      = $profile_image['base64'];
    //                             $img                = $upload_base64;

    //                             $data           = base64_decode($img);
    //                             $fileName       = uniqid() . '.jpg';
    //                             $file           = 'public/uploads/user/' . $fileName;
    //                             $success        = file_put_contents($file, $data);
    //                             $user_image     = $fileName;
    //                         }
    //                     } else {
    //                         $apiStatus          = FALSE;
    //                         http_response_code(200);
    //                         $apiMessage         = 'Please Upload Image !!!';
    //                         $apiExtraField      = 'response_code';
    //                         $apiExtraData       = http_response_code();
    //                     }
    //                 /* profile image */

    //                 $attendence_type = json_decode($getUser->attendence_type);
    //                 if (!empty($attendence_type)) {
    //                     $attendanceGivenStatus  = 1;
    //                     $address                = $this->geolocationaddress($latitude, $longitude);
    //                     if ($attendanceGivenStatus) {
    //                         $punch_date = date('Y-m-d');
    //                         $orderBy = [['field' => 'id', 'type' => 'DESC']];
    //                         $AdminUsers         = $this->db->query("SELECT * FROM `user` WHERE `status` = '1' AND `type` IN ('SUPER ADMIN', 'ADMIN') ORDER BY `id` DESC")->getResult();
    //                         foreach ($AdminUsers as $user) {
    //                             $orderBy = [['field' => 'id', 'type' => 'DESC']];
    //                             $userdevice = $this->common_model->find_data('ecomm_user_devices', 'row', ['user_id' => $user->id], '', '', '', $orderBy);
    //                             if (!empty($userdevice) && isset($userdevice->fcm_token) && isset($userdevice->device_type)) {
    //                                 // Add the token and device_type for this user to the collective array
    //                                 $allLastUserDevices[] = [
    //                                     'id' => $userdevice->user_id,
    //                                     'token' => $userdevice->fcm_token,
    //                                     'device_type' => $userdevice->device_type
    //                                 ];
    //                             }
    //                         }
                            
    //                         if ($punch_type == 1) {
    //                             $punch_in_time      = date('H:i:s');
    //                             $punch_in_lat       = $latitude;
    //                             $punch_in_lng       = $longitude;
    //                             $punch_in_address   = $address;

    //                             $from_time          = strtotime($punch_date . " " . $punch_in_time);
    //                             $to_time            = strtotime($punch_date . " 23:59:00");
    //                             $attendance_time    = round(abs($to_time - $from_time) / 60, 2);

    //                             $fields2 = [
    //                                 'punch_in_time'         => $punch_in_time,
    //                                 'punch_in_lat'          => $punch_in_lat,
    //                                 'punch_in_lng'          => $punch_in_lng,
    //                                 'punch_in_address'      => $punch_in_address,
    //                                 'punch_in_image'        => $user_image,
    //                                 'punch_out_time'        => '',
    //                                 'punch_out_lat'         => '',
    //                                 'punch_out_lng'         => '',
    //                                 'punch_out_address'     => '',
    //                                 'punch_out_image'       => '',
    //                                 'status'                => 1,
    //                                 'attendance_time'       => $attendance_time,
    //                             ];
    //                             // pr($fields2);
    //                             $this->common_model->save_data('attendances', $fields2, $attenId, 'id');
    //                             $apiMessage         = 'Attendance Punch In Successfully !!!';
    //                             $apiStatus          = TRUE;
    //                             http_response_code(200);
    //                             // Send Notification
    //                             if (!empty($allLastUserDevices)) {
    //                                 $title = $getUser->name;
    //                                 $body  = 'Punch In at ' . date('h:i A');
    //                                 // $image = 'https://example.com/your-image.png'; // Optional: provide a valid image URL

    //                                 $allResults = [];
    //                                 foreach ($allLastUserDevices as $record) {
    //                                     $token = $record['token'];
    //                                     $device_type = $record['device_type'];

    //                                     // Call sendCommonPushNotification for each record
    //                                     $notificationResponse = $this->sendCommonPushNotification(
    //                                         $token, // Pass single token
    //                                         $title,
    //                                         $body,
    //                                         'attendance',
    //                                         '',
    //                                         $device_type // Pass device type for this specific token
    //                                     );
    //                                     $allResults[$token] = $notificationResponse->getJSON();
    //                                 }
    //                                 // pr($allResults); // Show results for all notifications
    //                             }
    //                             // if (!empty($deviceToken)) {
    //                             //     $title = 'Punch In Successful';
    //                             //     $body  = 'Hello ' . $getUser->name . ', your punch-in was recorded at ' . date('h:i A');
    //                             //     $this->sendCommonPushNotification($deviceToken, $title, $body, 'attendance','', $device_type);
    //                             // }

    //                         } elseif ($punch_type == 2) {
    //                             $punch_out_time      = date('H:i:s');
    //                             $punch_out_lat       = $latitude;
    //                             $punch_out_lng       = $longitude;
    //                             $punch_out_address   = $address;

    //                             $punch_in_time      = $checkPunchIn->punch_in_time;
    //                             $from_time          = strtotime($punch_date . " " . $punch_in_time);
    //                             $to_time            = strtotime($punch_date . " " . $punch_out_time);
    //                             $attendance_time    = round(abs($to_time - $from_time) / 60, 2);

    //                             $fields2 = [
    //                                 'punch_out_time'        => $punch_out_time,
    //                                 'punch_out_lat'         => $punch_out_lat,
    //                                 'punch_out_lng'         => $punch_out_lng,
    //                                 'punch_out_address'     => $punch_out_address,
    //                                 'punch_out_image'       => $user_image,
    //                                 'status'                => 2,
    //                                 'attendance_time'       => $attendance_time,
    //                             ];
    //                             $this->common_model->save_data('attendances', $fields2, $attenId, 'id');
    //                             $apiMessage         = 'Punch Out Successfully !!!';
    //                             $apiStatus          = TRUE;
    //                             http_response_code(200);
    //                             // Send Notification
    //                             if (!empty($allLastUserDevices)) {
    //                                 $title = $getUser->name;
    //                                 $body  = 'Punch Out at ' . date('h:i A');
    //                                 // $image = 'https://example.com/your-image.png'; // Optional: provide a valid image URL

    //                                 $allResults = [];
    //                                 foreach ($allLastUserDevices as $record) {
    //                                     $token = $record['token'];
    //                                     $device_type = $record['device_type'];

    //                                     // Call sendCommonPushNotification for each record
    //                                     $notificationResponse = $this->sendCommonPushNotification(
    //                                         $token, // Pass single token
    //                                         $title,
    //                                         $body,
    //                                         'attendance',
    //                                         '',
    //                                         $device_type // Pass device type for this specific token
    //                                     );
    //                                     $allResults[$token] = $notificationResponse->getJSON();
    //                                 }
    //                                 // pr($allResults); // Show results for all notifications
    //                             }
    //                             // if (!empty($deviceToken)) {
    //                             //     $title = 'Punch Out Successful';
    //                             //     $body  = 'Goodbye ' . $getUser->name . ', your punch-out was recorded at ' . date('h:i A');
    //                             //     $this->sendCommonPushNotification($deviceToken, $title, $body, 'attendance','', $device_type);
    //                             // }
    //                         } else {
    //                             $punch_out_time     = date('H:i:s');
    //                             $punch_in_lat       = $latitude;
    //                             $punch_in_lng       = $longitude;
    //                             $punch_in_address   = $address;

    //                             $fields2 = [
    //                                 'punch_out_time'        => $punch_out_time,
    //                                 'punch_out_lat'         => $punch_out_lat,
    //                                 'punch_out_lng'         => $punch_out_lng,
    //                                 'punch_out_address'     => $punch_out_address,
    //                                 'punch_out_image'       => $user_image,
    //                                 'status'                => 2,
    //                             ];
    //                             $this->common_model->save_data('attendances', $fields2, $attenId, 'id');
    //                             $apiMessage         = 'Punch Out Successfully !!!';
    //                             $apiStatus          = TRUE;
    //                             http_response_code(200);
    //                             // Send Notification
    //                             if (!empty($allLastUserDevices)) {
    //                                 $title = $getUser->name;
    //                                 $body  = 'Punch Out at ' . date('h:i A');
    //                                 // $image = 'https://example.com/your-image.png'; // Optional: provide a valid image URL

    //                                 $allResults = [];
    //                                 foreach ($allLastUserDevices as $record) {
    //                                     $token = $record['token'];
    //                                     $device_type = $record['device_type'];

    //                                     // Call sendCommonPushNotification for each record
    //                                     $notificationResponse = $this->sendCommonPushNotification(
    //                                         $token, // Pass single token
    //                                         $title,
    //                                         $body,
    //                                         'attendance',
    //                                         '',
    //                                         $device_type // Pass device type for this specific token
    //                                     );
    //                                     $allResults[$token] = $notificationResponse->getJSON();
    //                                 }
    //                             }
    //                         }
    //                     } else {
    //                         $apiStatus          = FALSE;
    //                         http_response_code(200);
    //                     }
    //                 } else {
    //                     $apiStatus          = FALSE;
    //                     http_response_code(200);
    //                     $apiMessage         = 'Please Contact System Administrator For Attendance Type Update !!!';
    //                 }
    //                 $apiExtraField      = 'response_code';
    //                 $apiExtraData       = http_response_code();
    //             } else {
    //                 $apiStatus          = FALSE;
    //                 http_response_code(200);
    //                 $apiMessage         = 'User Not Found !!!';
    //                 $apiExtraField      = 'response_code';
    //                 $apiExtraData       = http_response_code();
    //             }
    //         } else {
    //             http_response_code($getTokenValue['data'][2]);
    //             $apiStatus                      = FALSE;
    //             $apiMessage                     = $this->getResponseCode(http_response_code());
    //             $apiExtraField                  = 'response_code';
    //             $apiExtraData                   = http_response_code();
    //         }
    //     } else {
    //         http_response_code(400);
    //         $apiStatus          = FALSE;
    //         $apiMessage         = $this->getResponseCode(http_response_code());
    //         $apiExtraField      = 'response_code';
    //         $apiExtraData       = http_response_code();
    //     }
    //     $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    // }
    public function markAttendance()
    {
        $apiStatus   = TRUE;
        $apiMessage  = '';
        $apiResponse = [];
        $headerData  = $this->request->headers();

        // ✅ Check header project key
        if ($headerData['Key'] != 'Key: ' . getenv('app.PROJECTKEY')) {
            http_response_code(400);
            $apiStatus  = FALSE;
            $apiMessage = $this->getResponseCode(http_response_code());
            return $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }

        // ✅ Validate required form-data fields
        $requiredFields = ['punch_type', 'latitude', 'longitude'];
        foreach ($requiredFields as $field) {
            if (empty($this->request->getPost($field))) {
                http_response_code(400);
                $apiStatus  = FALSE;
                $apiMessage = 'All Data Are Not Present !!!';
                return $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
            }
        }

        // ✅ Token authentication
        $Authorization    = $headerData['Authorization'];
        $app_access_token = $this->extractToken($Authorization);
        $getTokenValue    = $this->tokenAuth($app_access_token);

        if (!$getTokenValue['status']) {
            http_response_code($getTokenValue['data'][2]);
            $apiStatus  = FALSE;
            $apiMessage = $this->getResponseCode(http_response_code());
            return $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }

        $uId    = $getTokenValue['data'][1];
        $getUser = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);

        if (!$getUser) {
            http_response_code(404);
            $apiStatus  = FALSE;
            $apiMessage = 'User Not Found !!!';
            return $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }

        // ✅ Extract request values
        $punch_type = $this->request->getPost('punch_type');
        $latitude   = $this->request->getPost('latitude');
        $longitude  = $this->request->getPost('longitude');

        // ✅ Handle image upload from form-data
        $uploadDir = FCPATH . 'public/uploads/user/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, TRUE);
        }

        if (!isset($_FILES['userImage']) || $_FILES['userImage']['error'] != 0) {
            http_response_code(400);
            $apiStatus  = FALSE;
            $apiMessage = 'Please Upload Image !!!';
            return $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }

        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $fileType     = $_FILES['userImage']['type'];
        $fileTmp      = $_FILES['userImage']['tmp_name'];
        $fileExt      = pathinfo($_FILES['userImage']['name'], PATHINFO_EXTENSION);
        $fileName     = uniqid() . '.' . strtolower($fileExt);
        $uploadPath   = $uploadDir . $fileName;

        if (!in_array($fileType, $allowedTypes)) {
            http_response_code(400);
            $apiStatus  = FALSE;
            $apiMessage = 'Please Upload a valid image (jpg, jpeg, png)';
            return $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }

        if (!move_uploaded_file($fileTmp, $uploadPath)) {
            http_response_code(500);
            $apiStatus  = FALSE;
            $apiMessage = 'Failed to upload image!';
            return $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }

        $user_image = $fileName;

        // ✅ Find or create attendance entry for the day
        $orderBy      = [['field' => 'id', 'type' => 'DESC']];
        $checkPunchIn = $this->common_model->find_data('attendances', 'row', [
            'user_id'   => $uId,
            'punch_date'=> date('Y-m-d'),
            'status'    => 1
        ], '', '', '', $orderBy);

        if (!$checkPunchIn) {
            $fields = [
                'user_id'    => $uId,
                'punch_date' => date('Y-m-d'),
            ];
            $attenId   = $this->common_model->save_data('attendances', $fields, '', 'id');
            $punch_type = 1; // default to Punch In
        } else {
            $attenId = $checkPunchIn->id;
        }

        // ✅ Attendance logic
        $address = $this->geolocationaddress($latitude, $longitude);
        $punch_date = date('Y-m-d');
        $AdminUsers = $this->db->query("SELECT * FROM `user` WHERE `status` = '1' AND `type` IN ('SUPER ADMIN','ADMIN') ORDER BY `id` DESC")->getResult();

        $allLastUserDevices = [];
        foreach ($AdminUsers as $user) {
            $userdevice = $this->common_model->find_data('ecomm_user_devices', 'row', ['user_id' => $user->id], '', '', '', $orderBy);
            if (!empty($userdevice) && isset($userdevice->fcm_token)) {
                $allLastUserDevices[] = [
                    'id'          => $userdevice->user_id,
                    'token'       => $userdevice->fcm_token,
                    'device_type' => $userdevice->device_type,
                ];
            }
        }

        if ($punch_type == 1) {
            // ✅ Punch In
            $punch_in_time = date('H:i:s');
            $fields2 = [
                'punch_in_time'    => $punch_in_time,
                'punch_in_lat'     => $latitude,
                'punch_in_lng'     => $longitude,
                'punch_in_address' => $address,
                'punch_in_image'   => $user_image,
                'status'           => 1,
            ];
            $this->common_model->save_data('attendances', $fields2, $attenId, 'id');

            $apiMessage = 'Attendance Punch In Successfully !!!';
            $apiStatus  = TRUE;
            http_response_code(200);

            // 🔔 Send Notification
            if (!empty($allLastUserDevices)) {
                $title = $getUser->name;
                $body  = 'Punch In at ' . date('h:i A');
                foreach ($allLastUserDevices as $record) {
                    $this->sendCommonPushNotification(
                        $record['token'],
                        $title,
                        $body,
                        'attendance',
                        '',
                        $record['device_type']
                    );
                }
            }

        } elseif ($punch_type == 2) {
            // ✅ Punch Out
            $punch_out_time = date('H:i:s');
            $punch_in_time  = $checkPunchIn->punch_in_time ?? date('H:i:s');
            $from_time      = strtotime($punch_date . " " . $punch_in_time);
            $to_time        = strtotime($punch_date . " " . $punch_out_time);
            $attendance_time = round(abs($to_time - $from_time) / 60, 2);

            $fields2 = [
                'punch_out_time'    => $punch_out_time,
                'punch_out_lat'     => $latitude,
                'punch_out_lng'     => $longitude,
                'punch_out_address' => $address,
                'punch_out_image'   => $user_image,
                'status'            => 2,
                'attendance_time'   => $attendance_time,
            ];
            $this->common_model->save_data('attendances', $fields2, $attenId, 'id');

            $apiMessage = 'Punch Out Successfully !!!';
            $apiStatus  = TRUE;
            http_response_code(200);

            // 🔔 Send Notification
            if (!empty($allLastUserDevices)) {
                $title = $getUser->name;
                $body  = 'Punch Out at ' . date('h:i A');
                foreach ($allLastUserDevices as $record) {
                    $this->sendCommonPushNotification(
                        $record['token'],
                        $title,
                        $body,
                        'attendance',
                        '',
                        $record['device_type']
                    );
                }
            }
        }

        return $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    }
    public function getMonthAttendanceNew()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['attn_month_year', 'id'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUserId = $requestData['id'];
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $getUserId, 'status' => '1']);

                $applicationSetting = $this->common_model->find_data('application_settings', 'row');
                $mark_later_after = $applicationSetting->mark_later_after;

                if ($getUser) {

                    $attn_month_year    = explode("/", $requestData['attn_month_year']);
                    $month              = $attn_month_year[0];
                    $year               = $attn_month_year[1];

                    $list = array();

                    for ($d = 1; $d <= 31; $d++) {
                        $time = mktime(12, 0, 0, $month, $d, $year);
                        if (date('m', $time) == $month)
                            $list[] = date('Y-m-d', $time);
                    }
                    $markDates          = [];
                    $trackerLast7Days   = [];
                    if (!empty($list)) {
                        $present_count  = 0;
                        $halfday_count  = 0;
                        $late_count     = 0;
                        $absent_count   = 0;

                        for ($p = 0; $p < count($list); $p++) {
                            $punch_date = $list[$p];

                            $today = date('Y-m-d');
                            if ($punch_date >= $today) {
                                $disableTouchEvent = 1;
                            } else {
                                $disableTouchEvent = 0;
                            }

                            $checkAttn = $this->common_model->find_data('attendances', 'row', ['user_id' => $getUserId, 'punch_date' => $punch_date]);
                            if ($checkAttn) {
                                $disableTouchEvent  = 0;
                                $orderBy[0]         = ['field' => 'id', 'type' => 'asc'];
                                $attnList           = $this->common_model->find_data('attendances', 'array', ['user_id' => $getUserId, 'punch_date' => $punch_date], 'attendance_time', '', '', $orderBy);
                                $tot_attn_time      = 0;
                                if ($attnList) {
                                    foreach ($attnList as $attnRow) {
                                        $tot_attn_time      += $attnRow->attendance_time;
                                    }
                                }
                                $attendance_time    = $tot_attn_time;
                                $isAbsent           = 0;
                                $isHalfday          = 0;
                                $isFullday          = 0;
                                $isLate             = 0;
                                if ($attendance_time < 240) {
                                    $isAbsent       = 1;
                                    $isHalfday      = 0;
                                    $isFullday      = 0;
                                    if ($checkAttn->punch_in_time > $mark_later_after) {
                                        $isLate     = 1;
                                    }
                                } elseif ($attendance_time >= 240 && $attendance_time < 480) {
                                    $isAbsent       = 0;
                                    $isHalfday      = 1;
                                    $isFullday      = 0;
                                    if ($checkAttn->punch_in_time > $mark_later_after) {
                                        $isLate     = 1;
                                    }
                                } elseif ($attendance_time >= 480) {
                                    $isAbsent       = 0;
                                    $isHalfday      = 0;
                                    $isFullday      = 1;
                                    if ($checkAttn->punch_in_time > $mark_later_after) {
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

                                if ($disableTouchEvent) {
                                    $backgroundColor = '#D5d5ce';
                                } else {
                                    $checkHoliday = $this->common_model->find_data('event', 'row', ['start_event' => $punch_date]);
                                    if ($checkHoliday) {
                                        $backgroundColor = '#469148';
                                        $disableTouchEvent = 0;
                                        // $present_count++;
                                    } else {
                                        if ($isAbsent) {
                                            $backgroundColor = '#F41F22';
                                            $absent_count++;
                                        }
                                        if ($isHalfday) {
                                            $backgroundColor = '#E4AA39';
                                            $halfday_count++;
                                            // $present_count++;
                                        }
                                        if ($isFullday) {
                                            $backgroundColor = '#469148';
                                            // $present_count++;
                                        }
                                        if ($checkAttn->status == 1) {
                                            $backgroundColor = '#76E21B';
                                            // $present_count++;
                                        }
                                        if ($checkAttn->punch_in_time > $mark_later_after) {
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
                                if ($disableTouchEvent) {
                                    $backgroundColor = '#D5d5ce';
                                } else {
                                    $checkHoliday = $this->common_model->find_data('event', 'row', ['start_event' => $punch_date]);
                                    if ($checkHoliday) {
                                        $backgroundColor = '#D623EA';
                                        $disableTouchEvent = 1;
                                    } else {
                                        if ($isAbsent) {
                                            $backgroundColor = '#F41F22';
                                            $absent_count++;
                                        }
                                        if ($isHalfday) {
                                            $backgroundColor = '#E4AA39';
                                            $halfday_count++;
                                            $present_count++;
                                        }
                                        if ($isFullday) {
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
                        if (!empty($last7Days)) {
                            for ($t = 0; $t < count($last7Days); $t++) {
                                $loopDate           = $last7Days[$t];
                                $dayWiseBooked      = $this->db->query("SELECT sum(hour) as tothour, date_today, sum(min) as totmin FROM `timesheet` where user_id='$getUserId' and date_added LIKE '$loopDate'")->getRow();
                                $tothour                = $dayWiseBooked->tothour * 60;
                                $totmin                 = $dayWiseBooked->totmin;
                                $totalMin               = ($tothour + $totmin);
                                $booked_effort          = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                                $getDesklogTime         = $this->db->query("SELECT time_at_work FROM `desklog_report` where tracker_user_id='$getUserId' and insert_date LIKE '%$loopDate%'")->getRow();
                                // echo $this->db->getLastQuery();
                                $desklog_time           = (($getDesklogTime) ? $getDesklogTime->time_at_work : '');
                                $desklog_time1           = str_replace("m", "", $desklog_time);
                                $desklog_time2           = str_replace("h ", ".", $desklog_time1);
                                $trackerLast7Days[]     = [
                                    'date_no'       => date_format(date_create($last7Days[$t]), "M d, Y"),
                                    'day_name'      => date('D', strtotime($last7Days[$t])),
                                    'booked_time'   => $booked_effort,
                                    'desklog_time'  => (($desklog_time != '') ? $desklog_time2 : $desklog_time)
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);

                $applicationSetting = $this->common_model->find_data('application_settings', 'row');
                $mark_later_after = $applicationSetting->mark_later_after;
                
                if ($getUser) {

                    $attn_date      = $requestData['attn_date'];
                    $orderBy[0]     = ['field' => 'id', 'type' => 'DESC'];
                    $checkAttn      = $this->common_model->find_data('attendances', 'row', ['user_id' => $uId, 'punch_date' => $attn_date], '', '', '', $orderBy);
                    if ($checkAttn) {
                        // $attendance_time = $checkAttn->attendance_time;


                        $attnDatas          = [];
                        $orderBy[0]         = ['field' => 'id', 'type' => 'asc'];
                        $attnList           = $this->common_model->find_data('attendances', 'array', ['user_id' => $uId, 'punch_date' => $attn_date], '', '', '', $orderBy);
                        $tot_attn_time      = 0;
                        if ($attnList) {
                            foreach ($attnList as $attnRow) {
                                if ($attnRow->status == 1) {
                                    $attnDatas[]          = [
                                        'punch_date'            => date_format(date_create($attn_date), "M d, Y"),
                                        'label'                 => 'In',
                                        'time'                  => date_format(date_create($attnRow->punch_in_time), "h:i A"),
                                        'address'               => (($attnRow->punch_in_address != '') ? $attnRow->punch_in_address : ''),
                                        'image'                 => getenv('app.uploadsURL') . 'user/' . $attnRow->punch_in_image,
                                        'type'                  => 1
                                    ];
                                }
                                if ($attnRow->status == 2) {
                                    $attnDatas[]          = [
                                        'punch_date'            => date_format(date_create($attn_date), "M d, Y"),
                                        'label'                 => 'In',
                                        'time'                  => date_format(date_create($attnRow->punch_in_time), "h:i A"),
                                        'address'               => (($attnRow->punch_in_address != '') ? $attnRow->punch_in_address : ''),
                                        'image'                 => getenv('app.uploadsURL') . 'user/' . $attnRow->punch_in_image,
                                        'type'                  => 1
                                    ];
                                    $attnDatas[]          = [
                                        'punch_date'            => date_format(date_create($attn_date), "M d, Y"),
                                        'label'                 => 'Out',
                                        'time'                  => (($attnRow->punch_out_time != '') ? date_format(date_create($attnRow->punch_out_time), "h:i A") : ''),
                                        'address'               => (($attnRow->punch_out_address != '') ? $attnRow->punch_out_address : ''),
                                        'image'                 => (($attnRow->punch_out_image != '') ? getenv('app.uploadsURL') . 'user/' . $attnRow->punch_out_image : ''),
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

                        if ($tot_attn_time < 240) {
                            $isAbsent   = 1;
                            $isHalfday  = 0;
                            $isFullday  = 0;
                            if ($getFirstAttn->punch_in_time > $mark_later_after) {
                                $isLate     = 1;
                            }
                        } elseif ($tot_attn_time >= 240 && $tot_attn_time < 480) {
                            $isAbsent   = 0;
                            $isHalfday  = 1;
                            $isFullday  = 0;

                            if ($getFirstAttn->punch_in_time > $mark_later_after) {
                                $isLate     = 1;
                            }
                        } elseif ($tot_attn_time >= 480) {
                            $isAbsent   = 0;
                            $isHalfday  = 0;
                            $isFullday  = 1;
                            if ($getFirstAttn->punch_in_time > $mark_later_after) {
                                $isLate     = 1;
                            }
                        }

                        $apiResponse        = [
                            'punch_date'            => date_format(date_create($checkAttn->punch_date), "M d, Y"),
                            'punch_in_time'         => date_format(date_create($checkAttn->punch_in_time), "h:i A"),
                            'punch_in_address'      => $checkAttn->punch_in_address,
                            'punch_in_image'        => getenv('app.uploadsURL') . 'user/' . $checkAttn->punch_in_image,
                            'punch_out_time'        => (($checkAttn->punch_out_time != '') ? date_format(date_create($checkAttn->punch_out_time), "h:i A") : ''),
                            'punch_out_address'     => (($checkAttn->punch_out_address != '') ? $checkAttn->punch_out_address : ''),
                            'punch_out_image'       => (($checkAttn->punch_out_image != '') ? getenv('app.uploadsURL') . 'user/' . $checkAttn->punch_out_image : ''),
                            'isAbsent'              => $isAbsent,
                            'isHalfday'             => $isHalfday,
                            'isFullday'             => $isFullday,
                            'isLate'                => $isLate,
                            'note'                  => (($checkAttn->note != '') ? $checkAttn->note : ''),
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
    public function getSingleAttendanceNew()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['attn_date', 'id'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $getUserId = $requestData['id'];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $getUserId, 'status' => '1']);

                $applicationSetting = $this->common_model->find_data('application_settings', 'row');
                $mark_later_after = $applicationSetting->mark_later_after;
                
                if ($getUser) {

                    $attn_date      = $requestData['attn_date'];
                    $orderBy[0]     = ['field' => 'id', 'type' => 'DESC'];
                    $checkAttn      = $this->common_model->find_data('attendances', 'row', ['user_id' => $getUserId, 'punch_date' => $attn_date], '', '', '', $orderBy);
                    if ($checkAttn) {
                        // $attendance_time = $checkAttn->attendance_time;


                        $attnDatas          = [];
                        $orderBy[0]         = ['field' => 'id', 'type' => 'asc'];
                        $attnList           = $this->common_model->find_data('attendances', 'array', ['user_id' => $getUserId, 'punch_date' => $attn_date], '', '', '', $orderBy);
                        $tot_attn_time      = 0;
                        if ($attnList) {
                            foreach ($attnList as $attnRow) {
                                if ($attnRow->status == 1) {
                                    $attnDatas[]          = [
                                        'punch_date'            => date_format(date_create($attn_date), "M d, Y"),
                                        'label'                 => 'In',
                                        'time'                  => date_format(date_create($attnRow->punch_in_time), "h:i A"),
                                        'address'               => (($attnRow->punch_in_address != '') ? $attnRow->punch_in_address : ''),
                                        'image'                 => getenv('app.uploadsURL') . 'user/' . $attnRow->punch_in_image,
                                        'type'                  => 1
                                    ];
                                }
                                if ($attnRow->status == 2) {
                                    $attnDatas[]          = [
                                        'punch_date'            => date_format(date_create($attn_date), "M d, Y"),
                                        'label'                 => 'In',
                                        'time'                  => date_format(date_create($attnRow->punch_in_time), "h:i A"),
                                        'address'               => (($attnRow->punch_in_address != '') ? $attnRow->punch_in_address : ''),
                                        'image'                 => getenv('app.uploadsURL') . 'user/' . $attnRow->punch_in_image,
                                        'type'                  => 1
                                    ];
                                    $attnDatas[]          = [
                                        'punch_date'            => date_format(date_create($attn_date), "M d, Y"),
                                        'label'                 => 'Out',
                                        'time'                  => (($attnRow->punch_out_time != '') ? date_format(date_create($attnRow->punch_out_time), "h:i A") : ''),
                                        'address'               => (($attnRow->punch_out_address != '') ? $attnRow->punch_out_address : ''),
                                        'image'                 => (($attnRow->punch_out_image != '') ? getenv('app.uploadsURL') . 'user/' . $attnRow->punch_out_image : ''),
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
                        $getFirstAttn       = $this->common_model->find_data('attendances', 'row', ['user_id' => $getUserId, 'punch_date' => $attn_date], '', '', '', $orderBy);

                        if ($tot_attn_time < 240) {
                            $isAbsent   = 1;
                            $isHalfday  = 0;
                            $isFullday  = 0;
                            if ($getFirstAttn->punch_in_time > $mark_later_after) {
                                $isLate     = 1;
                            }
                        } elseif ($tot_attn_time >= 240 && $tot_attn_time < 480) {
                            $isAbsent   = 0;
                            $isHalfday  = 1;
                            $isFullday  = 0;

                            if ($getFirstAttn->punch_in_time > $mark_later_after) {
                                $isLate     = 1;
                            }
                        } elseif ($tot_attn_time >= 480) {
                            $isAbsent   = 0;
                            $isHalfday  = 0;
                            $isFullday  = 1;
                            if ($getFirstAttn->punch_in_time > $mark_later_after) {
                                $isLate     = 1;
                            }
                        }

                        $apiResponse        = [
                            'punch_date'            => date_format(date_create($checkAttn->punch_date), "M d, Y"),
                            'punch_in_time'         => date_format(date_create($checkAttn->punch_in_time), "h:i A"),
                            'punch_in_address'      => $checkAttn->punch_in_address,
                            'punch_in_image'        => getenv('app.uploadsURL') . 'user/' . $checkAttn->punch_in_image,
                            'punch_out_time'        => (($checkAttn->punch_out_time != '') ? date_format(date_create($checkAttn->punch_out_time), "h:i A") : ''),
                            'punch_out_address'     => (($checkAttn->punch_out_address != '') ? $checkAttn->punch_out_address : ''),
                            'punch_out_image'       => (($checkAttn->punch_out_image != '') ? getenv('app.uploadsURL') . 'user/' . $checkAttn->punch_out_image : ''),
                            'isAbsent'              => $isAbsent,
                            'isHalfday'             => $isHalfday,
                            'isFullday'             => $isFullday,
                            'isLate'                => $isLate,
                            'note'                  => (($checkAttn->note != '') ? $checkAttn->note : ''),
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
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $note_date                  = date_format(date_create($requestData['note_date']), "Y-m-d");
            $note                       = $requestData['note'];
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);

            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
                    $checkAttns  = $this->common_model->find_data('attendances', 'array', ['user_id' => $uId, 'punch_date' => $note_date]);
                    $fields     = [
                        'note' => $note
                    ];
                    if ($checkAttns) {
                        foreach ($checkAttns as $checkAttn) {
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
    public function getProject()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $headerData         = $this->request->headers();
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId            = $getTokenValue['data'][1];
                $expiry         = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $order_by[0]    = array('field' => 'name', 'type' => 'ASC');
                $getProjects    = $this->common_model->find_data('project', 'array', ['status!=' => '13'], '', '', '', $order_by);
                if ($getProjects) {
                    foreach ($getProjects as $getProject) {
                        $project_status = $this->common_model->find_data('project_status', 'row', ['id' => $getProject->status]);
                        $client = $this->common_model->find_data('client', 'row', ['id' => $getProject->client_id]);
                        $apiResponse[]        = [
                            'id'              => $getProject->id,
                            'name'            => $getProject->name,
                            'type'           => $project_status->name,
                            'client_name'   => $this->pro->decrypt(($client) ? $client->name : ''),
                        ];
                    }
                    $apiStatus          = TRUE;
                    http_response_code(200);
                    $apiMessage         = 'Data Available !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(404);
                    $apiMessage         = 'Data Not Found !!!';
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
    public function getEffortType()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $headerData         = $this->request->headers();
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId            = $getTokenValue['data'][1];
                $expiry         = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $order_by[0]    = array('field' => 'name', 'type' => 'ASC');
                $getEfforts    = $this->common_model->find_data('effort_type', 'array', ['status=' => '1'], 'id,name,status', '', '', $order_by);
                if ($getEfforts) {
                    foreach ($getEfforts as $getEffort) {
                        $apiResponse[]        = [
                            'id'              => $getEffort->id,
                            'name'            => $getEffort->name,                            
                        ];
                    }
                    $apiStatus          = TRUE;
                    http_response_code(200);
                    $apiMessage         = 'Data Available !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(404);
                    $apiMessage         = 'Data Not Found !!!';
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
    public function getWorkStatus()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $headerData         = $this->request->headers();
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId            = $getTokenValue['data'][1];
                $expiry         = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $order_by[0]    = array('field' => 'name', 'type' => 'ASC');
                $getWorkStatus    = $this->common_model->find_data('work_status', 'array', ['is_schedule=' => '1'], '', '', '', $order_by);
                if ($getWorkStatus) {
                    foreach ($getWorkStatus as $getWork) {
                        $apiResponse[]        = [
                            'id'                => $getWork->id,
                            'name'              => $getWork->name, 
                            'background_color'  => $getWork->background_color,
                            'border_color'      => $getWork->border_color,                                                      
                        ];
                    }
                    $apiStatus          = TRUE;
                    http_response_code(200);
                    $apiMessage         = 'Data Available !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(404);
                    $apiMessage         = 'Data Not Found !!!';
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
    public function addTask()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['project_id', 'user_id', 'is_leave', 'description', 'date_added', 'hour', 'min', 'priority'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);

                if ($getUser) {
                    $department                = $this->common_model->find_data('team', 'row', ['user_id' => $uId]);
                    $project_id                = $requestData['project_id'];
                    if ($project_id != 0) {
                        $project = $this->common_model->find_data('project', 'row', ['id' => $project_id]);
                        $project_status            = $project->status;
                        $project_bill           = $project->bill;
                    } else {
                        $project = 0;
                        $project_status = 0;
                        $project_bill = 0;
                    }                                        
                    $user_id                   = $requestData['user_id'] ?? $uId; // Default to current user if not provided
                    $department_id             = $department ? $department->dep_id : 0;
                    $is_leave                  = $requestData['is_leave'];
                    $description               = $requestData['description'];
                    $date_added                = date_format(date_create($requestData['date_added']), "Y-m-d");
                    $hour                      = $requestData['hour'];
                    $min                       = $requestData['min'];
                    $priority                  = $requestData['priority'];
                    $created_at                = date('Y-m-d H:i:s');

                    if ($is_leave == 1) {
                        $postData            = [
                            'project_id'        => 0,
                            'status_id'         => 0,
                            'user_id'           => $user_id,
                            'dept_id'           => $department_id,
                            'description'       => "Half Day Leave Taken",
                            'date_added'        => $date_added,
                            'added_by'          => $uId,
                            'hour'              => 0,
                            'min'               => 0,
                            'bill'              => 1,
                            'work_status_id'    => 6,
                            'priority'          => $priority,
                            'next_day_task_action' => 1,
                            'is_leave'          => 1,
                            'created_at'        => $created_at
                        ];
                    } else if ($is_leave == 2) {
                        $postData            = [
                            'project_id'        => 0,
                            'status_id'         => 0,
                            'user_id'           => $user_id,
                            'dept_id'           => $department_id,
                            'description'       => "Full Day Leave Taken",
                            'date_added'        => $date_added,
                            'added_by'          => $uId,
                            'hour'              => 0,
                            'min'               => 0,
                            'bill'              => 1,
                            'work_status_id'    => 6,
                            'priority'          => $priority,
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
                            'added_by'          => $uId,
                            'hour'              => $hour,
                            'min'               => $min,
                            'bill'              => $project_bill,
                            'priority'          => $priority,
                            'created_at'        => $created_at
                        ];
                    }
                    $this->common_model->save_data('morning_meetings', $postData, '', 'id');
                    $apiResponse[]              = [
                        'tasks'           => $postData
                    ];
                    $apiStatus          = TRUE;
                    http_response_code(200);
                    $apiMessage         = 'Task added Successfully !!!';
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
    public function editTask()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['task_id', 'project_id', 'user_id', 'is_leave', 'description', 'date_added', 'hour', 'min', 'priority'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);

                if ($getUser) {
                    $task_id                 = $requestData['task_id'];
                    $department                = $this->common_model->find_data('team', 'row', ['user_id' => $uId]);
                    $project_id                = $requestData['project_id'];
                    $project                   = $this->common_model->find_data('project', 'row', ['id' => $project_id]);
                    $project_status            = $this->common_model->find_data('project_status', 'row', ['id' => $project->status]);
                    $project_bill              = $project->bill; 
                    $user_id                   = $requestData['user_id'] ?? $uId; // Default to current user if not provided
                    $department_id             = $department ? $department->dep_id : 0;
                    $is_leave                  = $requestData['is_leave'];
                    $description               = $requestData['description'];
                    $date_added                = date_format(date_create($requestData['date_added']), "Y-m-d");
                    $hour                      = $requestData['hour'];
                    $min                       = $requestData['min'];
                    $priority                  = $requestData['priority'];
                    $created_at                = date('Y-m-d H:i:s');

                    if ($is_leave == 1) {
                        $postData            = [
                            'id'           => $task_id,
                            'project_id'        => 0,
                            'status_id'         => 0,
                            'user_id'           => $user_id,
                            'dept_id'           => $department_id,
                            'description'       => "Half Day Leave Taken",
                            'date_added'        => $date_added,
                            'added_by'          => $uId,
                            'hour'              => 0,
                            'min'               => 0,
                            'bill'              => 1,
                            'work_status_id'    => 6,
                            'priority'          => $priority,
                            'next_day_task_action' => 1,
                            'is_leave'          => 1,                            
                            'updated_at'        => $created_at
                        ];
                    } else if ($is_leave == 2) {
                        $postData            = [
                            'id'           => $task_id,
                            'project_id'        => 0,
                            'status_id'         => 0,
                            'user_id'           => $user_id,
                            'dept_id'           => $department_id,
                            'description'       => "Full Day Leave Taken",
                            'date_added'        => $date_added,
                            'added_by'          => $uId,
                            'hour'              => 0,
                            'min'               => 0,
                            'bill'              => 1,
                            'work_status_id'    => 6,
                            'priority'          => $priority,
                            'next_day_task_action' => 1,
                            'is_leave'          => 2,                            
                            'updated_at'        => $created_at
                        ];
                    } else {                        
                        $postData            = [
                            'id'           => $task_id,
                            'project_id'        => $project_id,
                            'status_id'         => $project_status->id,
                            'user_id'           => $user_id,
                            'dept_id'           => $department_id,
                            'description'       => $description,
                            'date_added'        => $date_added,
                            'added_by'          => $uId,
                            'hour'              => $hour,
                            'min'               => $min,
                            'bill'              => $project_bill,
                            'priority'          => $priority,
                            'work_status_id'    => 0,
                            'is_leave'          => $is_leave, 
                            'next_day_task_action' => 0, // Assuming next_day_task_action is not needed for updates
                            'updated_at'        => $created_at                            
                        ];
                    }
                    $this->common_model->save_data('morning_meetings', $postData, $task_id, 'id');
                    $apiResponse[]              = [
                        'tasks'           => $postData
                    ];
                    $apiStatus          = TRUE;
                    http_response_code(200);
                    $apiMessage         = 'Task update Successfully !!!';
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
    public function getTasks()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['no_of_days'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            $no_of_days                 = $requestData['no_of_days'];
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
                    $last7Days          = $this->getLastNDaysAscending($no_of_days, 'Y-m-d');
                    if (!empty($last7Days)) {
                        for ($t = 0; $t < count($last7Days); $t++) {
                            $loopDate                   = $last7Days[$t];
                            $tasks                      = [];
                            $total_time                 = 0;

                            $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                            $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                            $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
                            $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $uId, 'morning_meetings.date_added' => $loopDate], 'project.name as project_name,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.effort_id,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at', $join1, '', $order_by1);
                            if ($getTasks) {
                                foreach ($getTasks as $getTask) {
                                    $tothour                = $getTask->hour * 60;
                                    $totmin                 = $getTask->min;
                                    $totalMin               = ($tothour + $totmin);
                                    // $booked_effort          = intdiv($totalMin, 60).'.'. ($totalMin % 60);
                                    $booked_effort          = $totalMin;
                                    $total_time             += $booked_effort;

                                    $work_status_id         = $getTask->work_status_id;
                                    $getWorkStatus          = $this->common_model->find_data('work_status', 'row', ['id' => $work_status_id], 'name,background_color,border_color');

                                    $tasks[]            = [
                                        'project_name'          => $getTask->project_name,
                                        'description'           => $getTask->description,
                                        'hour'                  => $getTask->hour,
                                        'min'                   => $getTask->min,
                                        'user_name'             => $getTask->user_name,
                                        'is_leave'              => $getTask->is_leave,
                                        'background_color'      => (($getWorkStatus) ? $getWorkStatus->background_color : ''),
                                        'border_color'          => (($getWorkStatus) ? $getWorkStatus->border_color : ''),
                                        'work_status_name'      => (($getWorkStatus) ? $getWorkStatus->name : ''),
                                        'created_at'            => date_format(date_create($getTask->created_at), "h:i a"),
                                    ];
                                }
                            }

                            $apiResponse[]              = [
                                'task_date'       => date_format(date_create($loopDate), "M d, Y"),
                                'total_time'      => intdiv($total_time, 60) . '.' . ($total_time % 60),
                                'tasks'           => $tasks
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
    public function getTasksNew()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['no_of_days', 'id'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            // pr($headerData['Key']);
            // pr(getenv('app.PROJECTKEY'));
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            $no_of_days                 = $requestData['no_of_days'];
            // pr($getTokenValue);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $getUserId = $requestData['id'];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $getUserId, 'status' => '1']);
                if ($getUser) {
                    $last7Days          = $this->getLastNDaysAscending($no_of_days, 'Y-m-d');
                    if (!empty($last7Days)) {
                        for ($t = 0; $t < count($last7Days); $t++) {
                            $loopDate                   = $last7Days[$t];
                            $tasks                      = [];
                            $total_time                 = 0;
                            $total_book_time            = 0;

                            $order_by1[0]               = array('field' => 'morning_meetings.priority', 'type' => 'DESC');
                            $join1[0]                   = ['table' => 'project', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'project_id', 'type' => 'LEFT'];
                            $join1[1]                   = ['table' => 'user', 'field' => 'id', 'table_master' => 'morning_meetings', 'field_table_master' => 'added_by', 'type' => 'INNER'];
                            $join1[2]                   = ['table' => 'timesheet', 'field' => 'assigned_task_id', 'table_master' => 'morning_meetings', 'field_table_master' => 'id', 'type' => 'LEFT'];
                            $getTasks                   = $this->common_model->find_data('morning_meetings', 'array', ['morning_meetings.user_id' => $getUserId, 'morning_meetings.date_added' => $loopDate], 'project.name as project_name, project.id as project_id,timesheet.description as booked_description,timesheet.hour as booked_hour,timesheet.min as booked_min,morning_meetings.description,morning_meetings.hour,morning_meetings.min,morning_meetings.dept_id,morning_meetings.user_id,morning_meetings.id as schedule_id, morning_meetings.date_added, morning_meetings.added_by, user.name as user_name,morning_meetings.work_status_id,morning_meetings.priority,morning_meetings.effort_id,morning_meetings.is_leave,morning_meetings.created_at,morning_meetings.updated_at', $join1, '', $order_by1);
                            // pr($getTasks);
                            if ($getTasks) {
                                foreach ($getTasks as $getTask) {
                                    $tothour                = $getTask->hour * 60;
                                    $totmin                 = $getTask->min;
                                    $totalMin               = ($tothour + $totmin);
                                    // $booked_effort          = intdiv($totalMin, 60).'.'. ($totalMin % 60);
                                    $booked_effort          = $totalMin;
                                    $total_time             += $booked_effort;

                                    $bookhour                = $getTask->booked_hour * 60;
                                    $bookmin                 = $getTask->booked_min;
                                    $totalbookedMin               = ($bookhour + $bookmin);
                                    // $booked_effort          = intdiv($totalMin, 60).'.'. ($totalMin % 60);
                                    $booked_time_effort          = $totalbookedMin;
                                    $total_book_time             += $booked_time_effort;

                                    $work_status_id         = $getTask->work_status_id;
                                    $getWorkStatus          = $this->common_model->find_data('work_status', 'row', ['id' => $work_status_id], 'name,background_color,border_color');

                                    $tasks[]            = [
                                        'task_id'               => $getTask->schedule_id,
                                        'project_id'            => $getTask->project_id,
                                        'project_name'          => $getTask->project_name,
                                        'description'           => $getTask->description,
                                        'booked_description'    => $getTask->booked_description,
                                        'booked_hour'           => $getTask->booked_hour,
                                        'booked_min'            => $getTask->booked_min,
                                        'hour'                  => $getTask->hour,
                                        'min'                   => $getTask->min,
                                        'priority'             => $getTask->priority,
                                        'date_added'            => date_format(date_create($getTask->date_added), "Y-m-d"),
                                        'user_name'             => $getTask->user_name,
                                        'user_id'               => $getUserId,
                                        'is_leave'              => $getTask->is_leave,
                                        'background_color'      => (($getWorkStatus) ? $getWorkStatus->background_color : ''),
                                        'border_color'          => (($getWorkStatus) ? $getWorkStatus->border_color : ''),                                        
                                        'work_status_name'      => (($getWorkStatus) ? $getWorkStatus->name : ''),
                                        'added_by'              => $getTask->added_by,
                                        'created_at'            => date_format(date_create($getTask->created_at), "M d, Y h:i a"),
                                        'updated_at'            => date_format(date_create($getTask->updated_at), "M d, Y h:i a"),
                                    ];
                                }
                            }

                            $apiResponse[]              = [
                                'task_date'             => date_format(date_create($loopDate), "M d, Y"),
                                'total_time'            => intdiv($total_time, 60) . '.' . ($total_time % 60),
                                'total_book_time'       => intdiv($total_book_time, 60) . '.' . ($total_book_time % 60),
                                'tasks'                 => $tasks
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
                // http_response_code($getTokenValue['data'][2]);
                http_response_code((int) $getTokenValue['data'][2]);
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
    public function addEffort()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['project_id', 'user_id', 'task_id', 'description', 'date_added', 'effort_type_id', 'hour', 'min', 'work_status_id'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId           = $getTokenValue['data'][1];
                $expiry        = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser       = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                $task_details  = $this->common_model->find_data('morning_meetings', 'row', ['id' => $requestData['task_id']]);                

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
                $date_added                = date_format(date_create($requestData['date_added']), "Y-m-d");                             
                $created_at                = date('Y-m-d H:i:s');
                $effort_type_id            = $requestData['effort_type_id'];
                $work_status_id            = $requestData['work_status_id'];
                if ($work_status_id == 2) {
                    $hour = 0;
                    $min = 0;
                } else {
                  $hour                      = $requestData['hour'];
                $min                       = $requestData['min'];   
                }         
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


                $apiResponse[]              = [
                        'efforts'           => $postData,
                        // 'finish_assign'     => $morningScheduleData2,
                    ];
                    $apiStatus          = TRUE;
                    http_response_code(200);
                    $apiMessage         = 'Effort added Successfully !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
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
    public static function geolocationaddress($lat, $long)
    {
        // $application_setting        = $this->common_model->find_data('application_settings', 'row');
        $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=AIzaSyBX7ODSt5YdPpUA252kxr459iV2UZwJwfQ";
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
        // pr($dataarray);
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
    public function getGeolocationDistance()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['latitude', 'longitude', 'userImage'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            $apiStatus          = FALSE;
            $apiMessage         = 'All Data Are Not Present !!!';
        }
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization              = $headerData['Authorization'];
            $app_access_token           = $this->extractToken($Authorization);
            $getTokenValue              = $this->tokenAuth($app_access_token);
            if ($getTokenValue['status']) {
                $uId        = $getTokenValue['data'][1];
                $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                $getUser    = $this->common_model->find_data('user', 'row', ['id' => $uId, 'status' => '1']);
                if ($getUser) {
                    $lat                        = $requestData['latitude'];
                    $long                       = $requestData['longitude'];
                    $attn_type                  = json_decode($getUser->attendence_type);

                    $application_setting        = $this->common_model->find_data('application_settings', 'row', ['id' => 1]);
                    $google_map_api_code        = $application_setting->google_map_api_code;
                    $apiKey                     = $google_map_api_code;

                    $latitudeFrom               = $lat;
                    $longitudeFrom              = $long;
                    $returnData                 = [];

                    if (in_array(0, $attn_type)) {
                        $apiMessage             = 'Attendance Status Enable !!!';
                        http_response_code(200);
                        $apiStatus              = TRUE;
                        $apiExtraField          = 'response_code';
                        $apiExtraData           = http_response_code();
                    } else {
                        for ($l = 0; $l < count($attn_type); $l++) {
                            $getOfficeLocation  = $this->common_model->find_data('office_locations', 'row', ['id' => $attn_type[$l]], 'latitude,longitude');
                            $latitude           = (($getOfficeLocation) ? $getOfficeLocation->latitude : '');
                            $longitude          = (($getOfficeLocation) ? $getOfficeLocation->longitude : '');

                            // Coordinates of the second point
                            // $latitudeTo     = '40.689247';
                            // $longitudeTo    = '-74.044502';
                            $latitudeTo     = $latitude;
                            $longitudeTo    = $longitude;
                            // Google Maps Distance Matrix API URL
                            $url            = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$latitudeFrom,$longitudeFrom&destinations=$latitudeTo,$longitudeTo&key=AIzaSyBX7ODSt5YdPpUA252kxr459iV2UZwJwfQ";
                            // Send a GET request to the API
                            $response       = file_get_contents($url);
                            $data           = json_decode($response, true);
                            // Extract distance from the response                                

                            if ($data['status'] === 'OK') {
                                if ($data['rows'][0]['elements'][0]['status'] === 'OK') {
                                    $distance = $data['rows'][0]['elements'][0]['distance']['value'];
                                    $returnData     = [
                                        'status'    => TRUE,
                                        'distance'  => $distance,
                                    ];
                                    $application_setting        = $this->common_model->find_data('application_settings', 'row', ['id' => 1]);
                                    $allow_punch_distance       = $application_setting->allow_punch_distance;
                                    if (!empty($returnData)) {
                                        if ($returnData['status']) {
                                            $distance = $returnData['distance'];
                                            if ($distance <= 1500) {
                                                $apiMessage             = 'Attendance Status Enable !!!';
                                                http_response_code(200);
                                                $apiStatus              = TRUE;
                                                $apiExtraField          = 'response_code';
                                                $apiExtraData           = http_response_code();
                                            } else {
                                                $apiMessage             = 'You are ' . ($distance / 1000) . ' kms away. Please stay within ' . $allow_punch_distance . ' meters from office !!!';
                                                http_response_code(200);
                                                $apiStatus              = FALSE;
                                                $apiExtraField          = 'response_code';
                                                $apiExtraData           = http_response_code();
                                            }
                                        } else {
                                            $apiMessage             = 'You are far away from office !!!';
                                            http_response_code(200);
                                            $apiStatus              = FALSE;
                                            $apiExtraField          = 'response_code';
                                            $apiExtraData           = http_response_code();
                                        }
                                    } else {
                                        $apiMessage             = 'You are far away from office !!!';
                                        http_response_code(200);
                                        $apiStatus              = FALSE;
                                        $apiExtraField          = 'response_code';
                                        $apiExtraData           = http_response_code();
                                    }
                                }
                            } else {
                                http_response_code(200);
                                $apiStatus          = FALSE;
                                $apiMessage         = 'You are far away from office !!!';
                                $apiExtraField      = 'response_code';
                                $apiExtraData       = http_response_code();
                            }
                        }
                    }
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(200);
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
    /* after login */

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
    public function getLastNDaysAscending($days, $format = 'd/m')
    {
        $m = date("m");
        $de = date("d");
        $y = date("Y");
        $dateArray = array();
        for ($i = 0; $i <= $days - 1; $i++) {
            $dateArray[] = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
        }
        return $dateArray;
        // return array_reverse($dateArray);
    }
    /*
    Get http response code
    Author : Subhomoy
    */
    private function getResponseCode($code = NULL)
    {
        if ($code !== NULL) {
            switch ($code) {
                case 100:
                    $text = 'Continue';
                    break;
                case 101:
                    $text = 'Switching Protocols';
                    break;
                case 200:
                    $text = 'OK';
                    break;
                case 201:
                    $text = 'Created';
                    break;
                case 202:
                    $text = 'Accepted';
                    break;
                case 203:
                    $text = 'Non-Authoritative Information';
                    break;
                case 204:
                    $text = 'No Content';
                    break;
                case 205:
                    $text = 'Reset Content';
                    break;
                case 206:
                    $text = 'Partial Content';
                    break;
                case 300:
                    $text = 'Multiple Choices';
                    break;
                case 301:
                    $text = 'Moved Permanently';
                    break;
                case 302:
                    $text = 'Moved Temporarily';
                    break;
                case 303:
                    $text = 'See Other';
                    break;
                case 304:
                    $text = 'Not Modified';
                    break;
                case 305:
                    $text = 'Use Proxy';
                    break;
                case 400:
                    $text = 'Unauthenticated Request !!!';
                    break;
                case 401:
                    $text = 'Token Not Found !!!';
                    break;
                case 402:
                    $text = 'Payment Required';
                    break;
                case 403:
                    $text = 'Token Has Expired !!!';
                    break;
                case 404:
                    $text = 'User Not Found !!!';
                    break;
                case 405:
                    $text = 'Method Not Allowed';
                    break;
                case 406:
                    $text = 'All Data Are Not Present !!!';
                    break;
                case 407:
                    $text = 'Proxy Authentication Required';
                    break;
                case 408:
                    $text = 'Request Time-out';
                    break;
                case 409:
                    $text = 'Conflict';
                    break;
                case 410:
                    $text = 'Gone';
                    break;
                case 411:
                    $text = 'Length Required';
                    break;
                case 412:
                    $text = 'Precondition Failed';
                    break;
                case 413:
                    $text = 'Request Entity Too Large';
                    break;
                case 414:
                    $text = 'Request-URI Too Large';
                    break;
                case 415:
                    $text = 'Unsupported Media Type';
                    break;
                case 500:
                    $text = 'Internal Server Error';
                    break;
                case 501:
                    $text = 'Not Implemented';
                    break;
                case 502:
                    $text = 'Bad Gateway';
                    break;
                case 503:
                    $text = 'Service Unavailable';
                    break;
                case 504:
                    $text = 'Gateway Time-out';
                    break;
                case 505:
                    $text = 'HTTP Version not supported';
                    break;
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
    private function extractToken($token)
    {
        $app_token = explode("Authorization: ", $token);
        $app_access_token = $app_token[1];
        return $app_access_token;
    }
    /* extract header token */
    /*
    Generate JWT tokens for authentication
    Author : Subhomoy
    */
    private static function generateToken($userId, $email, $phone)
    {
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
    private function tokenAuth($appAccessToken)
    {
        $this->db   = \Config\Database::connect();
        $headers    = apache_request_headers();
        if (isset($appAccessToken) && !empty($appAccessToken)) :
            $userdata = $this->matchToken($appAccessToken);
            // pr($userdata);
            // echo $appAccessToken;
            if ($userdata['status']) :
                $checkToken =  $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $appAccessToken]);
                // echo $this->db->getLastQuery();
                // pr($checkToken);
                if (!empty($checkToken)) :
                    if ($userdata['data']['exp'] && $userdata['data']['exp'] > time()) :
                        $tokenStatus = array(TRUE, $userdata['data']['id'], $userdata['data']['email'], $userdata['data']['phone'], $userdata['data']['exp']);
                    else :
                        $tokenStatus = array(FALSE, 'Token Has Expired !!!');
                    endif;
                else :
                    $tokenStatus = array(FALSE, 'Token Has Expired !!!');
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
    private static function matchToken($token)
    {
        // try{
        //     // $decoded    = JWT::decode($token, TOKEN_SECRET, 'HS256');
        //     $decoded    = JWT::decode($token, new Key(TOKEN_SECRET, 'HS256'));
        //     // pr($decoded);
        // } catch (\Exception $e) {
        //     //echo 'Caught exception: ',  $e->getMessage(), "\n";
        //     return array('status' => FALSE, 'data' => '');
        // }

        // return array('status' => TRUE, 'data' => $decoded);

        try {
            $key = "1234567890qwertyuiopmnbvcxzasdfghjkl";
            // $decoded = JWT::decode($token, $key, array('HS256'));
            $objOfJwt           = new CreatorJwt();
            $decoded   = $objOfJwt->DecodeToken($token);
            // $decodedData = (array) $decoded;
        } catch (\Exception $e) {
            // echo 'Caught exception: ',  $e->getMessage(), "\n";
            return array('status' => FALSE, 'data' => '');
        }
        return array('status' => TRUE, 'data' => $decoded);
    }
    // public function testnotification()
    // {   $device_type = 'IO';
    //     // $deviceToken = 'eyVgYIp_6UjnuHxHHWNA4J:APA91bHzlofx-hcT0dR07U4bZau7C0Gr8-dTSwPJpTTdNWGzDFdb0cMBRut0T3dXe4m1ojAIfSs0HhbpPS0ep4uHr8Zh2vpAWEJYbVKgXsMwLN6fke5TU3c'; // Example device token
    //     $deviceTokens = [
    //         'cIngd4RtRu-Akw7w3DtBzv:APA91bEI84X4Y5OmrhfUA6cWMuvcU17udBQef-LsSRe2kYnIsjU3J0-z19IijxFkFMWMcLt-VoOohnJT4YTZFhCAL5lwPFENFRLtb03mcNl3O-Rbfhgr_xY',
    //         'c9g_qq3Pm07MsbluZlAZVK:APA91bE9J4nYUJ1o5ieMYthDRrUAv4pkdPLNRlKCiw9HjKjteV2qYYREzFlBANryNsrYKgG2kWIq4hrOj-LIZmLck5NAQ3QurDogls8Q8JAlNJZ3zB-DTC0', // Add more tokens as needed
    //         'dH1dzsqwRo-W2xddfVgEff:APA91bFF_J8KzopsdTRNCaodnpO_OnxZlESalo5O98wAB24-iqorzxBVTm6-uwtkgeywyNt2SyeX2bL-gtPhuLh-9GFn6kVCc8LuT2ivLDs82gBdTRg6VN0',
    //     ];
    //     if (!empty($deviceToken)) {
    //         $title = 'Test IOS Notification';
    //         $body  = 'This is a test IOS notification sent from the API.';            
    //         $notification = $this->sendCommonPushNotification($deviceTokens, $title, $body, 'attendance', '', $device_type);            
    //         // var_dump($notification);
    //         pr($notification);
    //     }
    // }
    public function testnotification()
    {
        $AdminUsers         = $this->db->query("SELECT * FROM `user` WHERE `status` = '1' AND `type` IN ('SUPER ADMIN', 'ADMIN') ORDER BY `id` DESC")->getResult();
        foreach ($AdminUsers as $user) {
            $orderBy = [['field' => 'id', 'type' => 'DESC']];
            $userdevice = $this->common_model->find_data('ecomm_user_devices', 'row', ['user_id' => $user->id], '', '', '', $orderBy);
            if (!empty($userdevice) && isset($userdevice->fcm_token) && isset($userdevice->device_type)) {
                // Add the token and device_type for this user to the collective array
                $allLastUserDevices[] = [
                    'id' => $userdevice->user_id,
                    'token' => $userdevice->fcm_token,
                    'device_type' => $userdevice->device_type
                ];
            }
        }
        if (!empty($allLastUserDevices)) {
            $title = 'Test Notification';
            $body  = 'This is a test notification sent from the API.';
            $image = 'https://example.com/your-image.png'; // Optional: provide a valid image URL

            $allResults = [];
            foreach ($allLastUserDevices as $record) {
                $token = $record['token'];
                $device_type = $record['device_type'];

                // Call sendCommonPushNotification for each record
                $notificationResponse = $this->sendCommonPushNotification(
                    $token, // Pass single token
                    $title,
                    $body,
                    'attendance',
                    $image,
                    $device_type // Pass device type for this specific token
                );
                $allResults[$token] = $notificationResponse->getJSON();
            }
            pr($allResults); // Show results for all notifications
        } else {
            return $this->response->setJSON(['status' => false, 'message' => 'No device records provided for notification.']);
        }
    }
}
