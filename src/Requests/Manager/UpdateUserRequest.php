<?php

namespace Src\Requests\Manager;

use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\User;

class UpdateUserRequest
{
    public $input = [
        'email' => false,
        'password' => false,
        'name' => false,
        'role' => false,
        'status' => false
    ], $validation = [
        'status' => true,
        'messages' => []
    ], $id;

    public function __construct($id) {
        $this->id = $id;
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    private function validate() {
        $status = [
            'email' => $this->emailHandler(),
            'password' => $this->passwordHandler(),
            'name' => ValidationHelper::stringHandler($this->input['name']),
            'role' => $this->roleHandler(),
            'status' => $this->statusHandler()
        ];

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        if ($this->validation['status']) {
            $this->input['updatedAt'] = TimeHelper::createTimeNow();
        }
    }

    private function passwordHandler() {
        if (!$this->input['password']) {
            return true;
        }

        $status = ValidationHelper::stringTypeHandler(
            $this->input['password'], 'Kata Sandi'
        );

        if ($status !== true) {
            return $status;
        }

        if (strlen($this->input['password']) > 255) {
            return 'Kata Sandi tidak boleh punya karakter lebih dari 255.';
        }

        return true;
    }

    private function emailHandler() {
        $status = ValidationHelper::emailHandler($this->input['email']);

        if (is_string($status)) {
            return $status;
        }

        $user = User::getOneByColumnWithException(User::$table, 'id', [
            'column' => 'email',
            'value' => $this->input['email']
        ], ['column' => 'id', 'value' => $this->id]);

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

        if ($this->input['role'] !== 'Pengelola' && $this->input['role'] !== 'Karyawan') {
            return 'Peran hanya boleh Pengelola dan Karyawan.';
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
