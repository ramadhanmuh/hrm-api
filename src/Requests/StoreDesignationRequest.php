<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Department;
use Src\Models\Designation;

class StoreDesignationRequest
{
    public $input = [
        'id' => null,
        'departmentId' => null,
        'name' => null
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
            'departmentId' => ValidationHelper::idHandler($this->input['departmentId'], 'Departemen'),
            'name' => ValidationHelper::stringHandler($this->input['name'])
        ];

        if ($status['id'] === true) {
            $data = Designation::getOneByColumn(
                Designation::$table, 'name', 'id', $this->input['id']
            );

            if ($data !== null) {
                $status['id'] = 'Id sudah digunakan.';
            }
        }

        if ($status['departmentId'] === true) {
            $data = Department::getOneByColumn(
                Department::$table, 'name', 'id', $this->input['departmentId']
            );

            if ($data === null) {
                $status['departmentId'] = 'Departemen tidak ditemukan.';
            }
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );
    }
}
