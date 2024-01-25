<?php

namespace Src\Controllers;

use Src\Helpers\ResponseHelper;
use Src\Helpers\StringHelper;
use Src\Helpers\TimeHelper;
use Src\Models\User;
use Src\Models\UserToken;
use Src\Requests\LoginUserRequest;

class AuthController
{
    /**
     * Untuk proses mengindetifikasi pengguna dan membuat token
     * 
     * @return void Jika proses berhasil, akan dikirim token
     */
    function authenticate() {
        $request = new LoginUserRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['message']);
        }

        $user = User::getOneByColumn(
            User::$table, 'id, email, password, status', 'email',
            $request->input['email']
        );

        if ($user === null) {
            return ResponseHelper::createUnauthorized('Pengguna tidak ditemukan.');
        }

        if (!password_verify($request->input['password'], $user['password'])) {
            return ResponseHelper::createUnauthorized('Pengguna tidak ditemukan.');
        }

        if (!$user['status']) {
            return ResponseHelper::createUnauthorized('Pengguna tidak aktif.');
        }

        $now = TimeHelper::createTimeNow();

        $userToken = [
            'userId' => $user['id'],
            'token' => StringHelper::createToken(),
            'createdAt' => $now,
            'expiredAt' => $now + 21600
        ];

        UserToken::insertOne(UserToken::$table, $userToken);
        
        return ResponseHelper::createOK([
            'email' => $user['email'],
            'token' => $userToken['token'],
            'expiredAt' => $userToken['expiredAt']
        ], 'Berhasil melakukan autentikasi.');
    }
}
