<?php

namespace App\Libraries;

use Config\Database;
use App\Libraries\CreatorJwt;

trait AuthTrait
{
    protected $db;
    protected $userId;
    protected $userEmail;
    protected $userMobile;
    protected $userExpiry;
    protected $common_model;

    private function extractToken($token)
    {
        $app_token = explode("Authorization: ", $token);
        $app_access_token = $app_token[1] ?? null;
        return $app_access_token;
    }

    private function tokenAuth($appAccessToken)
    {
        $this->db = Database::connect();
        $this->common_model = model('App\Models\CommonModel'); // adjust path if needed

        if (!isset($appAccessToken) || empty($appAccessToken)) {
            return ['status' => false, 'data' => 'Token Not Found In Request !!!'];
        }

        $userdata = self::matchToken($appAccessToken);
        if (!$userdata['status']) {
            return ['status' => false, 'data' => 'Token Not Found !!!'];
        }

        $checkToken = $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $appAccessToken]);
        if (empty($checkToken)) {
            return ['status' => false, 'data' => 'Token Has Expired !!!'];
        }

        if ($userdata['data']['exp'] && $userdata['data']['exp'] > time()) {
            $this->userId     = $userdata['data']['id'];
            $this->userEmail  = $userdata['data']['email'];
            $this->userMobile = $userdata['data']['phone'];
            $this->userExpiry = $userdata['data']['exp'];

            return ['status' => true, 'data' => [
                $this->userId,
                $this->userEmail,
                $this->userMobile,
                $this->userExpiry,
            ]];
        }

        return ['status' => false, 'data' => 'Token Has Expired !!!'];
    }

    private static function matchToken($token)
    {
        try {
            $objOfJwt = new CreatorJwt();
            $decoded = $objOfJwt->DecodeToken($token);
        } catch (\Exception $e) {
            return ['status' => false, 'data' => ''];
        }

        return ['status' => true, 'data' => $decoded];
    }
}
