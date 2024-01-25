<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Employee;
use Src\Models\WorkHistory;

class StoreWorkHistoryRequest
{
    public $input = [
        'id' => null,
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
            'id' => ValidationHelper::idHandler($this->input['id']),
            'employeeId' => ValidationHelper::idHandler($this->input['employeeId'], 'Karyawan'),
            'dateOfJoin' => ValidationHelper::timeHandler($this->input['dateOfJoin'], 'Tanggal Bergabung')
        ];

        if  (
                $status['id'] === true
                && WorkHistory::getOneByColumn(
                    WorkHistory::$table, 'id', 'id', $this->input['id']
                ) !== null
            ) {
            $status['id'] = 'Id sudah digunakan.';
        }

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
            $this->input['createdAt'] = TimeHelper::createTimeNow();
            $this->input['updatedAt'] = $this->input['createdAt'];
        }
    }
}
