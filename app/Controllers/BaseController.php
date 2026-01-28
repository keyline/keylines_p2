<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Psr\Log\LoggerInterface;
use App\Models\CommonModel;
use App\Libraries\Pro;
use Google_Client;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['common_helper'];
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;
    /**
     * @return void
     */

    protected function applyCorsHeaders()
    {
        header('Access-Control-Allow-Origin: http://localhost:3000');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->applyCorsHeaders();
        date_default_timezone_set('Asia/Kolkata');
        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();
        $this->common_model         = new CommonModel;
        $this->session              = \Config\Services::session();
        $this->uri                  = new \CodeIgniter\HTTP\URI();
        $this->db                   = \Config\Database::connect();
        $this->pro                  = new Pro();
    }
    public function layout_before_login($title,$page_name,$data)
    {
        $this->session              = \Config\Services::session();
        $data['session']            = $this->session;
        $data['Common_model']       = new CommonModel;
        $data['db']                 = \Config\Database::connect();
        $data['pro']                = new Pro();

        $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        $data['application_settings']   = $this->common_model->find_data('application_settings','row');
        $data['title']              = $title.'-'.$data['general_settings']->site_name;
        $data['page_header']        = $title;
        $data['head']               = view('admin/elements/before-head',$data);
        $data['maincontent']        = view('admin/maincontents/'.$page_name,$data);
        return view('admin/layout-before-login',$data);
    }
    public function layout_after_login($title,$page_name,$data)
    {
        $this->session              = \Config\Services::session();
        if(!$this->session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }

        $data['session']            = $this->session;
        $data['common_model']       = new CommonModel;
        $data['db']                 = \Config\Database::connect();
        $data['pro']                = new Pro();
        
        $user_id                    = $this->session->get('user_id');
        
        $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        $data['application_settings']   = $this->common_model->find_data('application_settings','row');
        $data['admin']              = $this->common_model->find_data('user','row', ['id' => $user_id]);
        $data['client']              = $this->common_model->find_data('client','row', ['id' => $user_id]);
        $data['title']              = $title.'-'.$data['general_settings']->site_name;
        $data['page_header']        = $title;
        $data['head']           = view('admin/elements/after-head',$data);
        $data['header']         = view('admin/elements/header',$data);
        $data['sidebar']        = view('admin/elements/sidebar',$data);
        $data['footer']         = view('admin/elements/footer',$data);
        $data['maincontent']    = view('admin/maincontents/'.$page_name,$data);
        return view('admin/layout-after-login',$data);
    }
    public function isJSON($string)
    {        
        $valid = is_string($string) && is_array(json_decode($string, true)) ? true : false;
        if (!$valid) {
            $this->response_to_json(FALSE, "Not JSON", 401);
        }
    }
    /* Process json from request */
    public function extract_json($key)
    {
        return json_decode($key, TRUE);
    }
    /* Methods to check all necessary fields inside a requested post body */
    public function validateArray($keys, $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }
    /*
     Set response message
     response_to_json = set_response
    */    
    public function response_to_json($success = TRUE, $message = "success", $data = NULL, $extraField = NULL, $extraData = NULL)
    {
        // Allow from any origin (for development)
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        $response = ["success" => $success, "message" => $message, "data" => $data];
        if ($extraField != NULL && $extraData != NULL) {
            $response[$extraField] = $extraData;
        }
        print json_encode($response);
        die;
    }
    public function responseJSON($data)
    {
        print json_encode($data);
        die;
    }
    // send email
        // public function sendMail($to_email, $email_subject, $mailbody, $attachment = '')
        // {
        //     $siteSetting        = $this->common_model->find_data('general_settings', 'row');
        //     $emailSetting       = \Config\Services::email();
        //     $from_email         = $siteSetting->from_email;
        //     $from_name          = $siteSetting->from_name;
        //     $emailSetting->SMTPHost = $siteSetting->smtp_host;
        //     $emailSetting->SMTPUser = $siteSetting->smtp_username;
        //     $emailSetting->SMTPPass = $siteSetting->smtp_password;
        //     $emailSetting->SMTPPort = $siteSetting->smtp_port;
        //     $emailSetting->protocol = 'smtp';
        //     $emailSetting->setFrom($from_email, $from_name);
        //     $emailSetting->setTo($to_email);
        //     $emailSetting->setCC('sudip.keyline@gmail.com', 'KDPL System');
        //     $emailSetting->setCC('subhomoysamanta1989@gmail.com', 'Subhomoy Samanta');
        //     $emailSetting->setCC('subhomoy@keylines.net', 'Subhomoy Samanta');
        //     $emailSetting->setCC('deblina@keylines.net', 'Deblina Das');
        //     $emailSetting->setSubject($email_subject);
        //     $emailSetting->setMessage($mailbody);
        //     if($attachment != ''){
        //         $emailSetting->attach($attachment);
        //     }
        //     $emailSetting->send();
        //     return true;
        // }
        public function sendMail($email, $subject, $message, $file = '')
        {
            // $generalSetting             = $this->common_model->find_data('general_settings', 'row');
            // $mailLibrary                = new PHPMailer(true);
            // $mailLibrary->CharSet       = 'UTF-8';
            // $mailLibrary->SMTPDebug     = 0;
            // $mailLibrary->IsSMTP();
            // $mailLibrary->Host          = $generalSetting->smtp_host;
            // $mailLibrary->SMTPAuth      = true;
            // $mailLibrary->Port          = $generalSetting->smtp_port;
            // $mailLibrary->Username      = $generalSetting->smtp_username;
            // $mailLibrary->Password      = $generalSetting->smtp_password;
            // $mailLibrary->SMTPSecure    = 'tls';
            // $mailLibrary->From          = $generalSetting->from_email;
            // $mailLibrary->FromName      = $generalSetting->from_name;
            // $mailLibrary->AddReplyTo($generalSetting->from_email, $generalSetting->from_name);
            // if(is_array($email)) :
            //     foreach($email as $eml):
            //         $mailLibrary->addAddress($eml);
            //     endforeach;
            // else:
            //     $mailLibrary->addAddress($email);
            // endif;
            // // $mailLibrary->addCC('sudip.keyline@gmail.com', 'KDPL System');
            // // $mailLibrary->addCC('subhomoy@keylines.net', 'Subhomoy Samanta');
            // // $mailLibrary->addCC('deblina@keylines.net', 'Deblina Das');
            // $mailLibrary->WordWrap      = 5000;
            // $mailLibrary->Subject       = $subject;
            // $mailLibrary->Body          = $message;
            // $mailLibrary->isHTML(true);
            // if (!empty($file)):
            //     $mailLibrary->AddAttachment($file);
            // endif;
            // return (!$mailLibrary->send()) ? false : true;
            $generalSetting = $this->common_model->find_data('general_settings', 'row');
            // print_r($generalSetting);exit;
            $mailLibrary = new PHPMailer(true);
            try {
                $mailLibrary->CharSet = 'UTF-8';
                $mailLibrary->SMTPDebug = 0;
                $mailLibrary->isSMTP();
                $mailLibrary->Host = $generalSetting->smtp_host;
                $mailLibrary->SMTPAuth = true;
                $mailLibrary->Port = $generalSetting->smtp_port;
                $mailLibrary->Username = $generalSetting->smtp_username;
                // $mailLibrary->Password = $generalSetting->smtp_password;
                $mailLibrary->Password = "85fhdgs58g";
                $mailLibrary->SMTPSecure = 'tls';
                $mailLibrary->From = $generalSetting->from_email;
                $mailLibrary->FromName = $generalSetting->from_name;
                $mailLibrary->AddReplyTo($generalSetting->from_email, $generalSetting->from_name);

                if (is_array($email)) {
                    foreach ($email as $eml) {
                        $mailLibrary->addAddress($eml);
                    }
                } else {
                    $mailLibrary->addAddress($email);
                }

                $mailLibrary->WordWrap = 5000;
                $mailLibrary->Subject = $subject;
                $mailLibrary->Body = $message;
                $mailLibrary->isHTML(true);

                if (!empty($file)) {
                    $mailLibrary->AddAttachment($file);
                }

                $mailLibrary->send();
                return ['status' => true, 'message' => 'Email sent successfully!'];
            } catch (Exception $e) {
                // If error, return status false and error message
                return ['status' => false, 'message' => 'Mailer Error: ' . $mailLibrary->ErrorInfo . '| Exception:' . $e->getMessage()];
            }
        }
    // send email
    // send sms
        public function sendSMS($mobileNo,$messageBody){
            $siteSetting    = $this->common_model->find_data('general_settings', 'row');
            $authKey        = $siteSetting->sms_authentication_key;        
            $senderId       = $siteSetting->sms_sender_id;        
            $route          = "4";
            $postData = array(
                'apikey'        => $authKey,
                'number'        => $mobileNo,
                'message'       => $messageBody,
                'senderid'      => $senderId,
                'format'        => 'json'
            );
            //API URL
            $url            = $siteSetting->sms_base_url;
            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => false,
                CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
            ));
            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            //get response
            $output = curl_exec($ch);
            //Print error if any
            if(curl_errno($ch))
            {
                echo 'error:' . curl_error($ch);
                return FALSE;
            } else {
                return TRUE;
            }
            curl_close($ch);
        }
    // send sms
    // send push notification
    protected function pushNotification($deviceToken = '', $messageData = array()){
        // $messageData = array(
        //     'body'          => $this->input->post('name') . ' uploaded !!!',
        //     'title'         => "New Video Uploaded !!!",
        //     'vibrate'       => 1,
        //     'sound'         => 1,
        //     'click_action'  => ""
        // );
        $siteSetting                = $this->common_model->find_data('general_settings', 'row');
        $firebase_server_key        = $siteSetting->firebase_server_key;        
        $fields                     = array(
            'to'            => $deviceToken,
            'notification'  => $messageData
        );
        $headers = array(
            'Authorization: key=' . $firebase_server_key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        $err    = curl_error($ch);
        curl_close($ch);
    }    

    public function getAccessToken($credentialsJson)
    {
        $client = new Google_Client();
        $client->setAuthConfig($credentialsJson);
        $client->addScope('https://www.googleapis.com/auth/cloud-platform');
        $client->setAccessType('offline');
        $client->fetchAccessTokenWithAssertion();

        return $client->getAccessToken();
    }

    public function sendFCMMessage($accessToken, $projectId, $message)
    {
        // pr($message);
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $headers = [
            'Authorization: Bearer ' . $accessToken['access_token'],
            'Content-Type: application/json',
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        return $response;
        // pr($response);
    }

    public function sendCommonPushNotification($tokens, $title, $body, $type = '', $image = '', $device_type)
    {
        try {
            // Decode credentials from .env
            $base64Credentials = getenv('FIREBASE_CREDENTIALS_BASE64');
            if (!$base64Credentials) {
                throw new Exception("Firebase credentials not found in environment variables.");
            }

            $json = base64_decode($base64Credentials);
            $credentialsArray = json_decode($json, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON format in decoded credentials.');
            }

            $projectId = $credentialsArray['project_id'];

            // Get access token
            $accessToken = $this->getAccessToken($credentialsArray);

            // Ensure $tokens is an array for consistent handling
            if (!is_array($tokens)) {
                $tokens = [$tokens];
            }

            $results = []; // To store individual notification results

            foreach ($tokens as $token) {
                 $messagePayload = [];
                 if ($device_type === 'ANDROID') {
                    $messagePayload = [
                        'message' => [
                            'token' => $token, // Individual token here
                            'data' => ['type' => $type],
                            'notification' => [
                                'title' => $title,
                                'body' => $body,
                            ],
                        ],
                    ];
                    if (!empty($image)) {
                        $messagePayload['message']['notification']['image'] = $image;
                    }
                }elseif ($device_type === 'IO') {
                    $messagePayload = [
                        'message' => [
                            'token' => $token, // Individual token here
                            'notification' => [
                                'title' => $title,
                                'body' => $body,
                            ],
                            'apns' => [
                                'headers' => [
                                    'apns-priority' => '10',
                                ],
                                'payload' => [
                                    'aps' => [
                                        'alert' => [
                                            'title' => $title,
                                            'body' => $body,
                                        ],
                                        'sound' => 'default',
                                        'mutable-content' => 1,
                                    ],
                                ],
                            ],
                        ],
                    ];
                    if (!empty($image)) {
                        $messagePayload['message']['apns']['fcm_options'] = [
                            'image' => $image
                        ];
                    }
                }else {
                    // Handle unsupported device type if necessary
                    $results[$token] = ['status' => false, 'error' => 'Unsupported device type'];
                    continue; // Skip to the next token
                }

                try {
                    $response = $this->sendFCMMessage($accessToken, $projectId, $messagePayload);
                    $results[$token] = ['status' => true, 'response' => json_decode($response, true)];
                } catch (Exception $e) {
                    $results[$token] = ['status' => false, 'error' => $e->getMessage()];
                } 
            }
           

            // Send notifications
            // Check if any notifications failed
            $allSucceeded = true;
            foreach ($results as $tokenResult) {
                if ($tokenResult['status'] === false) {
                    $allSucceeded = false;
                    break;
                }
            }

            if ($allSucceeded) {
                return $this->response->setJSON(['status' => true, 'message' => 'All push notifications sent successfully.', 'results' => $results]);
            } else {
                return $this->response->setJSON(['status' => false, 'message' => 'Some push notifications failed to send.', 'results' => $results]);
            }           

            // return $this->response->setJSON(['status' => true, 'message' => 'Push notification sent successfully.']);

        } catch (Exception $e) {
            return $this->response->setJSON(['status' => false, 'error' => $e->getMessage()]);
        }
    }
//     public function sendCommonPushNotification($token, $title, $body, $type = '', $image = '')
// {
//     try {
//         $base64Credentials = getenv('FIREBASE_CREDENTIALS_BASE64');
//         if (!$base64Credentials) {
//             throw new Exception("Firebase credentials not found.");
//         }

//         $json = base64_decode($base64Credentials);
//         $credentialsArray = json_decode($json, true);
//         if (json_last_error() !== JSON_ERROR_NONE) {
//             throw new Exception("Invalid JSON in credentials.");
//         }

//         $projectId = $credentialsArray['project_id'];
//         $accessToken = $this->getAccessToken($credentialsArray);

//         $message = [
//             'message' => [
//                 'token' => $token,
//                 'notification' => [
//                     'title' => $title,
//                     'body'  => $body,
//                 ],
//                 'data' => [
//                     'type' => $type,
//                     'title' => $title,
//                     'body'  => $body,
//                 ],
//                 'android' => [
//                     'notification' => [
//                         'title' => $title,
//                         'body'  => $body,
//                         'sound' => 'default',
//                         'image' => $image ?: null,
//                     ]
//                 ],
//                 'apns' => [
//                     'payload' => [
//                         'aps' => [
//                             'alert' => [
//                                 'title' => $title,
//                                 'body' => $body,
//                             ],
//                             'sound' => 'default',
//                             'mutable-content' => 1,
//                         ]
//                     ],
//                     'fcm_options' => [
//                         'image' => $image ?: null,
//                     ]
//                 ],
//             ]
//         ];

//         // Remove null image values if not set
//         if (empty($image)) {
//             unset($message['message']['android']['notification']['image']);
//             unset($message['message']['apns']['fcm_options']['image']);
//         }

//         $this->sendFCMMessage($accessToken, $projectId, $message);

//         return $this->response->setJSON(['status' => true, 'message' => 'Push notification sent.']);

//     } catch (Exception $e) {
//         return $this->response->setJSON(['status' => false, 'error' => $e->getMessage()]);
//     }
// }


    // send push notification
    public function checkModuleAccess($id){
        $this->db           = \Config\Database::connect();
        $this->common_model = new CommonModel();
        $this->session      = \Config\Services::session();
        $userId             = $this->session->get('user_id');
        $adminUser          = $this->common_model->find_data('sms_admin_user', 'row', ['id' => $userId]);
        $checkExist         = $this->common_model->find_data('permission_role_module_function', 'count', ['module_id' => $id, 'role_id' => $adminUser->role_id]);
		// echo $this->db->getLastQuery();die;
        // echo $checkExist;die;
        if($checkExist>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
	public function checkModuleFunctionAccess($module_id, $function_id){
        $this->db           = \Config\Database::connect();
        $this->common_model = new CommonModel();
        $this->session      = \Config\Services::session();
        $userId             = $this->session->get('user_id');
        $adminUser          = $this->common_model->find_data('sms_admin_user', 'row', ['id' => $userId]);
        $role_id = $adminUser->role_id;
        $checkExist         = $this->common_model->find_data('permission_role_module_function', 'count',['role_id' => $role_id, 'module_id' => $module_id, 'function_id' => $function_id]);
        // echo $this->db->getLastQuery();die;
        //echo $checkExist;die;
        if($checkExist>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
