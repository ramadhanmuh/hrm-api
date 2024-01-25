<?php

namespace Src\Controllers\Manager;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Models\User;
use Src\Requests\CountUserRequest;
use Src\Requests\Manager\GetUserRequest;
use Src\Requests\Manager\StoreUserRequest;
use Src\Requests\Manager\UpdateUserRequest;

class UserController
{
    /**
     * Mendapatkan daftar pengguna
     * 
     * @return void
     */
    function list() {
        $request = new GetUserRequest;

        $data['rules'] = $request->input;

        $data['list'] = User::getWithoutPemilik($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function count() {
        $request = new CountUserRequest;

        $data['rules'] = $request->input; 

        $data['total'] = User::count($data['rules']);

        return ResponseHelper::createSuccessGetData($data);
    }

    function getOne() {
        $data = User::getOneByColumnWithException(
            User::$table, User::$columns, [
                'column' => 'id',
                'value' => RequestHelper::getSegmentContent(2)
            ], [
                'column' => 'role',
                'value' => 'Pemilik'
            ]
        );

        return $data === null
                ? ResponseHelper::createNotFound()
                : ResponseHelper::createSuccessGetData($data);
    }

    /**
     * Membuat pengguna
     */
    function create() {
        $request = new StoreUserRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        $request->input['password'] = password_hash($request->input['password'], PASSWORD_DEFAULT);

        User::insertOne(User::$table, $request->input);

        unset($request->input['password']);

        return ResponseHelper::createSuccessCreateData($request->input);
    }

    function update() {
        $id = RequestHelper::getSegmentContent(2);

        $data = User::getOneByColumnWithException(User::$table, 'id, password', [
            'column' => 'id',
            'value' => $id
        ], [
            'column' => 'role',
            'value' => 'Pemilik'
        ]);

        if ($data === null || $data['id'] === RequestHelper::$value['userId'])  {
            return ResponseHelper::createNotFound();
        }

        $request = new UpdateUserRequest($id);

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        if (!$request->input['password']) {
            $request->input['password'] = $data['password'];
        } else {
            $request->input['password'] = password_hash($request->input['password'], PASSWORD_DEFAULT);
        }

        User::updateOne(User::$table, $request->input, $id);

        unset($request->input['password']);

        return ResponseHelper::createSuccessUpdateData($request->input);
    }

    function delete() {
        $id = RequestHelper::getSegmentContent(2);

        $data = User::getOneByColumnWithException(User::$table, 'id', [
            'column' => 'id',
            'value' => $id
        ], [
            'column' => 'role',
            'value' => 'Peran'
        ]);

        if ($data === null || $data['id'] === RequestHelper::$value['userId'])  {
            return ResponseHelper::createNotFound();
        }

        User::deleteOne(User::$table, $id);

        return ResponseHelper::createSuccessDeleteData();
    }
}
