<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Employee;

class UpdateWorkHistoryRequest
{
    public $input = [
        'employeeId' => null,
        'dateOfJoin' => null
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
            'dateOfJoin' => ValidationHelper::timeHandler($this->input['dateOfJoin'], 'Tanggal Bergabung')
        ];

        if  (
                $status['employeeId'] === true
                && Employee::getOneByColumn(
                    Employee::$table, 'id', 'id', $this->input['employeeId']
                ) === null
            ) {
            $status['employeeId'] = 'Karyawan tidak ditemukan.';
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        if ($this->validation['status']) {
            $this->input['updatedAt'] = TimeHelper::createTimeNow();
        }
    }
}
