<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\User;

class DeleteProfileRequest
{
    public $input = [
        'password' => false
    ],
    $validation = [
        'status' => true,
        'messages' => []
    ];

    private $id;

    public function __construct($id) {
        $this->id = $id;

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
            'password' => ValidationHelper::stringHandler($this->input['password'], 'Kata Sandi')
        ];

        if ($status['password'] === true) {
            $data = User::getOneByColumn(User::$table, 'password', 'id', $this->id);

            $status['password'] = password_verify($this->input['password'], $data['password'])
                                    ? true
                                    : 'Kata Sandi tidak benar.';
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );
    }
}
