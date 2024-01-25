<?php

namespace Src\Requests\Owner;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\User;

class StoreUserRequest
{
    public $input = [
        'id' => false,
        'email' => false,
        'password' => false,
        'name' => false,
        'role' => false,
        'status' => false
    ], $validation = [
        'status' => true,
        'messages' => []
    ];

    public function __construct() {
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    private function validate() {
        $status = [
            'id' => $this->idHandler(),
            'email' => $this->emailHandler(),
            'password' => ValidationHelper::stringHandler($this->input['password'], 'Kata Sandi'),
            'name' => ValidationHelper::stringHandler($this->input['name']),
            'role' => $this->roleHandler(),
            'status' => $this->statusHandler()
        ];

        foreach ($status as $key => $value) {
            if (is_string($value)) {
                $this->validation['status'] = false;
                $this->validation['message'][$key] = $value;
            }
        }

        return $this->validation;
    }

    private function idHandler() {
        $status = ValidationHelper::idHandler($this->input['id']);

        if (is_string($status)) {
            return $status;
        }

        $user = User::getOneByColumn(
            User::$table, User::$columns, 'id', $this->input['id']
        );

        if ($user === null) {
            return true;
        }

        return 'Id sudah digunakan.';
    }

    private function emailHandler() {
        $status = ValidationHelper::emailHandler($this->input['email']);

        if (is_string($status)) {
            return $status;
        }

        $user = User::getOneByColumn(
            User::$table, User::$columns, 'email', $this->input['email']
        );

        if ($user !== null) {
            return 'Email sudah digunakan.';
        }
        
        return true;
    }

    private function roleHandler() {
        $status = ValidationHelper::requiredHandler($this->input['role'], 'Peran');

        if (is_string($status)) {
            return $status;
        }

        if ($this->input['role'] !== 'Pemilik' && $this->input['role'] !== 'Pengelola' && $this->input['role'] !== 'Karyawan') {
            return 'Peran hanya boleh Pemilik, Pengelola, Karyawan.';
        }

        return true;
    }

    private function statusHandler() {
        $status = ValidationHelper::requiredHandler($this->input['status'], 'Status');

        if (is_string($status)) {
            return $status;
        }

        $status = ValidationHelper::integerTypeHandler($this->input['status'], 'Status');

        if (is_string($status)) {
            return $status;
        }

        if ($this->input['status'] !== 0 && $this->input['status'] !== 1) {
            return 'Status hanya boleh 1 (Aktif) dan 0 (Tidak Aktif).';
        }

        return true;
    }
}
