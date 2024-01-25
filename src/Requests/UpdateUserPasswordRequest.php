<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\User;

class UpdateUserPasswordRequest
{
    public $input = [
        'currentPassword' => null,
        'newPassword' => null,
        'passwordConfirmation' => null
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
            'currentPassword' => ValidationHelper::stringHandler($this->input['currentPassword'], 'Kata Sandi Sekarang'),
            'newPassword' => ValidationHelper::stringHandler($this->input['newPassword'], 'Kata Sandi Baru'),
            'passwordConfirmation' => $this->input['newPassword'] === $this->input['passwordConfirmation'] ? true : 'Konfirmasi Kata Sandi tidak benar.'
        ];

        if ($status['currentPassword'] === true) {
            $data = User::getOneByColumn(User::$table, 'password', 'id', $this->id);

            $status['currentPassword'] = password_verify(
                $this->input['currentPassword'], $data['password']
            ) ? true : 'Kata Sandi Sekarang tidak benar.';
        }

        $this->validation = ValidationHelper::setValidation($this->validation, $status);
    }
}
