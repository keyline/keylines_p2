<?php

namespace App\Controllers\Api\Screenshots;

use App\Libraries\AuthTrait;
use App\Services\Screenshots\ScreenshotServices;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class ScreenshotsUploadController extends ResourceController
{
    use ResponseTrait;
    use AuthTrait;

    protected $imageService;

    public function __construct()
    {
        $this->imageService = new ScreenshotServices();
    }

    public function authCheck()
    {
        $headerData         = $this->request->headers();

        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization             = $headerData['Authorization'];
            $app_access_token          = $this->extractToken($Authorization);
            $authResponse              = $this->tokenAuth($app_access_token);
            if (!$authResponse['status']) {
                return $this->respond(['status' => false, 'message' => $authResponse['data']], 401);
            }

            // ______________________________________________________________


            // logical code goes here..

            return $this->respond([
                'status' => true,
                'message' => 'Token Verified',
                'user_id' => $this->userId,
                'email' => $this->userEmail
            ]);

            // ______________________________________________________________

        } else {
            return $this->respond(['status' => false, 'message' => 'Key Not Matched'], 401);
        }
    }


    public function uploadBase64()
    {
        $headerData         = $this->request->headers();

        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization             = $headerData['Authorization'];
            $app_access_token          = $this->extractToken($Authorization);
            $authResponse              = $this->tokenAuth($app_access_token);
            if (!$authResponse['status']) {
                return $this->respond(['status' => false, 'message' => $authResponse['data']], 401);
            }

            // _______________________________ MAIN CODE START _______________________________
            // raw JSON into an array
            $postData = $this->request->getJSON(true);

            if (! is_array($postData)) {
                return $this->fail(
                    ['error' => 'Invalid or missing JSON body.'],
                    ResponseInterface::HTTP_BAD_REQUEST
                );
            }

            // Define inline rules for JSON payload
            $rules = [
                'user_id'        => 'required|integer',
                'org_id'         => 'required|integer',
                'app_name'       => 'permit_empty|max_length[255]',
                'app_url'        => 'permit_empty|valid_url',
                'image.mime'     => 'required|in_list[image/jpg,image/jpeg,image/png]',
                // We expect just the Base64 characters (no "data:image/..." prefix).
                'image.data'     => 'required',
            ];


            //Validation instance and run it against $postData
            $validation = Services::validation();
            $validation->setRules($rules);

            if (! $validation->run($postData)) {
                // Collect all error messages
                return $this->fail($validation->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }



            try {
                // payload for the service
                $payload = [
                    'user_id'  => $postData['user_id'],
                    'org_id'   => $postData['org_id'],
                    'app_name' => $postData['app_name'] ?? null,
                    'app_url'  => $postData['app_url']  ?? null,
                    'image'    => [
                        'mime' => $postData['image']['mime'],
                        'data' => $postData['image']['data'],
                    ],
                ];

                $result = $this->imageService->upload($payload);

                return $this->respondCreated([
                    'status'  => 'success',
                    'message' => 'file upload successfully.'
                ]);
            } catch (Exception $e) {
                log_message('error', '[ScreenshotsUploadController::uploadBase64] ' . $e->getMessage());
                return $this->failServerError($e->getMessage());
            }
            // _______________________________ MAIN CODE END _______________________________

        } else {
            return $this->respond(['status' => false, 'message' => 'Key Not Matched'], 401);
        }
    }


    public function uploadFile()
    {

        $headerData         = $this->request->headers();

        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization             = $headerData['Authorization'];
            $app_access_token          = $this->extractToken($Authorization);
            $authResponse              = $this->tokenAuth($app_access_token);
            if (!$authResponse['status']) {
                return $this->respond(['status' => false, 'message' => $authResponse['data']], 401);
            }

            // _______________________________ MAIN CODE START _______________________________


            //  rules for form-data validation
            $rules = [
                // 'user_id'   => 'required|integer',
                'org_id'    => 'required|integer',
                'app_name'  => 'permit_empty|max_length[255]',
                'app_url'   => 'permit_empty|valid_url',
                'image'     => 'uploaded[image]'
                    . '|is_image[image]'
                    . '|max_size[image,2048]'
                    . '|mime_in[image,image/jpg,image/jpeg,image/png]',
            ];

            if (! $this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }

            try {

                // if($this->request->getFile('image') != ''){
                //     $payload = [
                //         'user_id'  => $this->userId, //$this->request->getPost('user_id'),
                //         'org_id'   => $this->request->getPost('org_id'),
                //         'app_name' => $this->request->getPost('app_name') ?? null,
                //         'app_url'  => $this->request->getPost('app_url')  ?? null,
                //         'image'    => $this->request->getFile('image'),
                //     ];
                // } else {
                //     $payload = [
                //         'user_id'  => $this->userId, //$this->request->getPost('user_id'),
                //         'org_id'   => $this->request->getPost('org_id'),
                //         'app_name' => $this->request->getPost('app_name') ?? null,
                //         'app_url'  => $this->request->getPost('app_url')  ?? null,
                //         'image'    => 'idle.jpg',
                //     ];
                // }
                pr($this->request->getPost(),0);
                pr($this->request->getFile(),0);
                die;
                $payload = [
                        'user_id'  => $this->userId, //$this->request->getPost('user_id'),
                        'org_id'   => $this->request->getPost('org_id'),
                        'app_name' => $this->request->getPost('app_name') ?? null,
                        'app_url'  => $this->request->getPost('app_url')  ?? null,
                        'image'    => $this->request->getFile('image'),
                    ];
                $result = $this->imageService->upload($payload);

                return $this->respondCreated([
                    'status'  => 'success',
                    'message' => 'file upload successfully.'
                ]);
            } catch (Exception $e) {
                log_message('error', '[AppController::createFromUpload] ' . $e->getMessage());
                return $this->failServerError($e->getMessage());
            }



            // _______________________________ MAIN CODE END _______________________________

        } else {
            return $this->respond(['status' => false, 'message' => 'Key Not Matched'], 401);
        }
    }




    // list all images
    public function list()
    {
        $data = $this->imageService->listAll();
        if (empty($data)) {
            return $this->respond([
                'status' => 'success',
                'message' => 'No images found.',
                'data' => []
            ]);
        } else {
            return $this->respond([
                'status' => 'success',
                'message' => 'Images retrieved successfully.',
                'data' => $data
            ]);
        }
    }


    public function settings()
    {
        $headerData         = $this->request->headers();
        if ($headerData['Key'] == 'Key: ' . getenv('app.PROJECTKEY')) {
            $Authorization             = $headerData['Authorization'];
            $app_access_token          = $this->extractToken($Authorization);
            $authResponse              = $this->tokenAuth($app_access_token);
            if (!$authResponse['status']) {
                return $this->respond(['status' => false, 'message' => $authResponse['data']], 401);
            }

            // _______________________________ MAIN CODE START _______________________________

            try {

                $result = $this->imageService->getSettings();

                return $this->respondCreated($result);
            } catch (Exception $e) {
                log_message('error', '[ScreenshotsUploadController::settings] ' . $e->getMessage());
                return $this->failServerError($e->getMessage());
            }

            // _______________________________ MAIN CODE END _______________________________

        } else {
            return $this->respond(['status' => false, 'message' => 'Key Not Matched'], 401);
        }
    }
}
