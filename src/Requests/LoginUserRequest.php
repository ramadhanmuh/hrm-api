<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;

class LoginUserRequest
{
    public $input = [
        'email' => null,
        'password' => null
    ],
    $validation = [
        'status' => true,
        'messages' => []
    ];

    public function __construct() {
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    /**
     * Untuk validasi input yang dikirim pengguna
     * 
     * @return array Sebuah hasil validasi
     */
    private function validate() {
        $status = [
            'email' => ValidationHelper::requiredHandler($this->input['email'], 'Email'),
            'password' => ValidationHelper::requiredHandler($this->input['password'], 'Kata Sandi')
        ];

        if ($status['email'] === true) {
            $status['email'] = ValidationHelper::emailFormatHandler($this->input['email'], 'Email');
        }

        if ($status['password'] === true) {
            $status['password'] = ValidationHelper::stringTypeHandler($this->input['password'], 'Kata Sandi');
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        return $this->validation;
    }
}
