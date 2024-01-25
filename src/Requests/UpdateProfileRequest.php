<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\User;

class UpdateProfileRequest
{
    public $input = [
        'email' => null,
        'name' => null,
        'currentPassword' => null
    ],
    $validation = [
        'status' => true,
        'messages' => []
    ];

    private $id;

    function __construct($id) {
        $this->id = $id;
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    /**
     * Untuk validasi input yang dikirim pengguna
     */
    private function validate() {
        $status = [
            'email' => ValidationHelper::emailHandler($this->input['email']),
            'name' => ValidationHelper::stringHandler($this->input['name']),
            'currentPassword' => ValidationHelper::requiredHandler($this->input['currentPassword'], 'Kata Sandi Sekarang')
        ];

        if ($status['email'] === true) {
            $user = User::getOneByColumnWithException(
                User::$table, 'id', [
                    'column' => 'email',
                    'value' => $this->input['email']
                ], [
                    'value' => $this->id,
                    'column' => 'id'
            ]);

            $status['email'] = $user === null ? true : 'Email sudah digunakan.';
        }

        if ($status['currentPassword'] === true) {
            $user = User::getOneByColumn(
                User::$table, 'password', 'id', $this->id
            );
            
            $status['currentPassword'] = password_verify($this->input['currentPassword'], $user['password'])
                ? true
                : 'Kata Sandi Sekarang tidak benar.';
        }

        foreach ($status as $key => $value) {
            if ($value !== true) {
                $this->validation['status'] = false;
                $this->validation['messages'][$key] = $value;
            }
        }
    }
}
