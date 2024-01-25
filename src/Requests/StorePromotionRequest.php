<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Designation;
use Src\Models\Employee;
use Src\Models\Promotion;

class StorePromotionRequest
{
    public $input = [
        'id' => null,
        'employeeId' => null,
        'designationId' => null,
        'title' => null,
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
            'id' => ValidationHelper::idHandler($this->input['id']),
            'employeeId' => ValidationHelper::idHandler($this->input['employeeId'], 'Karyawan'),
            'designationId' => ValidationHelper::idHandler($this->input['designationId'], 'Jabatan'),
            'title' => ValidationHelper::stringHandler($this->input['title'], 'Judul'),
            'date' => ValidationHelper::timeHandler($this->input['date'], 'Tanggal'),
            'description' => ValidationHelper::stringHandler($this->input['description'], 'Deskripsi', 65535)
        ];

        if ($status['id'] === true && Promotion::getOneByColumn(Promotion::$table, 'id', 'id', $this->input['id']) !== null) {
            $status['id'] = 'Id sudah digunakan.';
        }

        if ($status['employeeId'] === true && Employee::getOneByColumn(Employee::$table, 'id', 'id', $this->input['employeeId']) === null) {
            $status['employeeId'] = 'Karyawan tidak ditemukan.';
        }

        if ($status['designationId'] === true && Designation::getOneByColumn(Designation::$table, 'id', 'id', $this->input['designationId']) === null) {
            $status['designationId'] = 'Jabatan tidak ditemukan.';
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
