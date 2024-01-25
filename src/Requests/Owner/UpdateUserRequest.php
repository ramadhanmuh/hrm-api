<?php

namespace Src\Requests\Owner;

use Src\Helpers\RequestHelper;
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
    ];

    private $id;

    public function __construct($id) {
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->id = $id;
        $this->validate();
    }

    private function validate() {
        $status = [
            'email' => $this->emailHandler(),
            'password' => !$this->input['password'] || is_string($this->input['password'])
                            ? true
                            : 'Kata Sandi hanya boleh bertipe string.',
            'name' => ValidationHelper::stringHandler($this->input['name']),
            'role' => $this->roleHandler(),
            'status' => $this->statusHandler()
        ];

        if (strlen($this->input['password']) > 255) {
            $status['password'] = 'Kata Sandi tidak boleh memiliki karakter lebih dari 255.';
        }

        foreach ($status as $key => $value) {
            if (is_string($value)) {
                $this->validation['status'] = false;
                $this->validation['message'][$key] = $value;
            }
        }

        return $this->validation;
    }

    private function emailHandler() {
        $status = ValidationHelper::emailHandler($this->input['email']);

        if (is_string($status)) {
            return $status;
        }

        return User::getOneByColumnWithException(User::$table, 'name', [
            'column' => 'email',
            'value' => $this->input['email']
        ], [
            'column' => 'id',
            'value' => $this->id
        ]) !== null ? 'Email sudah digunakan.' : true;
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
