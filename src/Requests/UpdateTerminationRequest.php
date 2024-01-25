<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Employee;
use Src\Models\TerminationType;

class UpdateTerminationRequest
{
    public $input = [
        'employeeId' => null,
        'terminationTypeId' => null,
        'noticeDate' => null,
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
            'terminationTypeId' => ValidationHelper::idHandler($this->input['terminationTypeId'], 'Tipe Penghentian'),
            'noticeDate' => ValidationHelper::timeHandler($this->input['noticeDate'], 'Tanggal Pemberitahuan'),
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

        if (
                $status['terminationTypeId'] === true
                && TerminationType::getOneByColumn(
                    TerminationType::$table, 'id', 'id', $this->input['terminationTypeId']
                ) === null
            ) {
            $status['terminationTypeId'] = 'Tipe Penghentian tidak ditemukan.';
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        if ($this->validation['status']) {
            $this->input['updatedAt'] = TimeHelper::createTimeNow();
        }
    }
}
