<?php

namespace Src\Middleware;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Models\UserToken;
use Src\Systems\Middleware;

class UserIsManager extends Middleware
{
    function run() {
        $headers = getallheaders();

        if ($headers && array_key_exists('Authorization', $headers) && strpos($headers['Authorization'], 'Bearer ') === 0) {
            $token = substr($headers['Authorization'], 7);

            $user = UserToken::getWithUserByActiveToken($token);

            if ($user === null) {
                return ResponseHelper::createUnauthorized('Pengguna tidak diautentikasi.');
            }

            if ($user['role'] !== 'Pengelola') {
                return ResponseHelper::createForbidden();
            }

            RequestHelper::$value['userId'] = $user['userId'];

            return $this->continue;
        }
        
        return ResponseHelper::createUnauthorized('Token tidak ditemukan.');
    }
}
