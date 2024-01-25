<?php

namespace Src\Controllers;

use Src\Helpers\ResponseHelper;
use Src\Helpers\TimeHelper;
use Src\Models\User;

class UserController
{
    function start() {
        $user = User::getOneByColumn(User::$table, User::$columns, 'id', '26c1fa9b-701c-4208-998e-023d2774d8c3');

        if ($user === null) {
            $input['id'] = '26c1fa9b-701c-4208-998e-023d2774d8c3';
            $input['email'] = 'pemilik@gmail.com';
            $input['password'] = password_hash('pemilik', PASSWORD_DEFAULT);
            $input['name'] = 'Nama Pemilik';
            $input['role'] = 'Pemilik';
            $input['status'] = 1;
            $input['createdAt'] = TimeHelper::createTimeNow();

            User::insertOne(User::$table, $input);

            return ResponseHelper::createSuccessGetData($input);
        }

        return ResponseHelper::createSuccessGetData($user);
    }
}
