<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Designation;
use Src\Models\Employee;

class UpdateEmployeeRequest
{
    public $input = [
        'registrationNumber' => null,
        'designationId' => null,
        'name' => null,
        'phone' => null,
        'email' => null,
        'dateOfBirth' => null,
        'gender' => null,
        'address' => null,
        'dateOfJoin' => null,
        'bankAccountHolderName' => null,
        'bankAccountNumber' => null,
        'bankName' => null
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

    private function validate() {
        $status = [
            'registrationNumber' => ValidationHelper::onlyLettersNumbersDash($this->input['registrationNumber'], 'Nomor Induk'),
            'designationId' => ValidationHelper::idHandler($this->input['designationId'], 'Jabatan'),
            'name' => ValidationHelper::stringHandler($this->input['name']),
            'phone' => ValidationHelper::stringHandler($this->input['phone'], 'Nomor Telepon'),
            'email' => ValidationHelper::emailHandler($this->input['email']),
            'dateOfBirth' => ValidationHelper::timeHandler($this->input['dateOfBirth'], 'Tanggal Lahir'),
            'gender' => ValidationHelper::requiredHandler($this->input['gender'], 'Jenis Kelamin'),
            'address' => ValidationHelper::stringHandler($this->input['address'], 'Alamat', 65535),
            'dateOfJoin' => ValidationHelper::timeHandler($this->input['dateOfJoin'], 'Tanggal Bergabung'),
            'bankAccountHolderName' => ValidationHelper::stringHandler($this->input['bankAccountHolderName'], 'Nama Akun Bank'),
            'bankAccountNumber' => ValidationHelper::stringHandler($this->input['bankAccountNumber'], 'Nomor Akun Bank'),
            'bankName' => ValidationHelper::stringHandler($this->input['bankName'], 'Nama Bank'),
        ];

        if ($status['registrationNumber'] === true) {
            if (Employee::getOneByColumnWithException(Employee::$table, 'id', [
                'column' => 'registrationNumber',
                'value' => $this->input['registrationNumber']
            ], [
                'value' => $this->id,
                'column' => 'id'
            ]) !== null) {
                $status['registrationNumber'] = 'Nomor Induk sudah digunakan.';
            }
        }

        if ($status['designationId'] === true) {
            if (Designation::getOneByColumn(
                Designation::$table, 'id', 'id', $this->input['designationId']
            ) === null) {
                $status['designationId'] = 'Jabatan tidak ditemukan.';
            }
        }

        if ($status['email'] === true) {
            if (Employee::getOneByColumnWithException(Employee::$table, 'id', [
                'column' => 'email',
                'value' => $this->input['email']
            ], [
                'value' => $this->id,
                'column' => 'id'
            ]) !== null) {
                $status['email'] = 'Email sudah digunakan.';
            }
        }

        if ($status['phone'] === true) {
            if (Employee::getOneByColumnWithException(Employee::$table, 'id', [
                'column' => 'phone',
                'value' => $this->input['phone']
            ], [
                'value' => $this->id,
                'column' => 'id'
            ]) !== null) {
                $status['phone'] = 'Nomor telepon sudah digunakan.';
            }
        }

        if ($status['gender'] === true && ($this->input['gender'] !== 'Pria' && $this->input['gender'] !== 'Wanita')) {
            $status['gender'] = 'Jenis Kelamin hanya boleh diisi Pria dan Wanita.';
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        if ($this->validation['status']) {
            $this->input['updatedAt'] = TimeHelper::createTimeNow();
        }
    }
}
