<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Designation;
use Src\Models\Employee;
use Src\Models\Transfer;

class UpdateTransferRequest
{
    public $input = [
        'employeeId' => null,
        'designationId' => null,
        'date' => null,
        'description' => null
    ],
    $validation = [
        'status' => true,
        'messages' => []
    ];

    public function __construct() {
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    private function validate() {
        $status = [
            'employeeId' => ValidationHelper::idHandler($this->input['employeeId'], 'Karyawan'),
            'designationId' => ValidationHelper::idHandler($this->input['designationId'], 'Jabatan'),
            'date' => ValidationHelper::timeHandler($this->input['date'], 'Tanggal'),
            'description' => ValidationHelper::stringHandler($this->input['description'], 'Deskripsi', 65535)
        ];

        if  (
                $status['employeeId'] === true
                && Employee::getOneByColumn(
                    Employee::$table, 'id', 'id', $this->input['employeeId']
                ) === null
            ) {
            $status['employeeId'] = 'Karyawan tidak ditemukan.';
        }

        if  (
                $status['designationId'] === true
                && Designation::getOneByColumn(
                    Designation::$table, 'id', 'id', $this->input['designationId']
                ) === null
            ) {
            $status['designationId'] = 'Jabatan tidak ditemukan.';
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        if ($this->validation['status']) {
            $this->input['updatedAt'] = TimeHelper::createTimeNow();
        }
    }
}
