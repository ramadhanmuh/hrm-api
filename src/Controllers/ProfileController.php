<?php

namespace Src\Controllers;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Helpers\TimeHelper;
use Src\Models\User;
use Src\Requests\DeleteProfileRequest;
use Src\Requests\UpdateProfileRequest;
use Src\Requests\UpdateUserPasswordRequest;

class ProfileController
{
    function get() {
        return ResponseHelper::createSuccessGetData(
            User::getOneByColumn(
                User::$table, User::$columns,
                'id', RequestHelper::$value['userId']
            )
        );
    }

    function update() {
        $id = RequestHelper::$value['userId'];

        $request = new UpdateProfileRequest($id);

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        unset($request->input['currentPassword']);

        $request->input['updatedAt'] = TimeHelper::createTimeNow();

        User::updateOne(User::$table, $request->input, $id);

        return ResponseHelper::createSuccessUpdateData($request->input);
}

    function delete() {
        $id = RequestHelper::$value['userId'];

        $request = new DeleteProfileRequest($id);

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        User::deleteOne(User::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }

    function updatePassword() {
        $id = RequestHelper::$value['userId'];

        $request = new UpdateUserPasswordRequest($id);

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        $input = [
            'password' => password_hash($request->input['newPassword'], PASSWORD_DEFAULT),
            'updatedAt' => TimeHelper::createTimeNow()
        ];

        User::updateOne(User::$table, $input, $id);

        return ResponseHelper::createSuccessUpdateData([
            'updatedAt' => $input['updatedAt']
        ]);
    }
}
