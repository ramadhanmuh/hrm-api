<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\User;

class ForgotPasswordRequest
{
    public $input = [
        'email' => null
    ],
    $validation = [
        'status' => true,
        'messages' => []
    ], $user;

    function __construct() {
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    /**
     * Untuk validasi input yang dikirim pengguna
     * 
     * @return array Sebuah hasil validasi
     */
    private function validate() {
        $status['email'] = ValidationHelper::requiredHandler($this->input['email'], 'Email');

        if ($status['email'] === true) {
            $status['email'] = ValidationHelper::emailFormatHandler($this->input['email'], 'Email');
        }

        if ($status['email'] === true) {
            $this->user = User::getOneByColumn(
                User::$table, 'name, status', 'email',
                $this->input['email']
            );

            if ($this->user === null) {
                $status['email'] = 'Email tidak ditemukan.';
            } else {
                if ($this->user['status'] !== 1) {
                    $status['email'] = 'Email wajib milik pengguna yang sedang aktif.';
                }
            }
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );
    }
}
