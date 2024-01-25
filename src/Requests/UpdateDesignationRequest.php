<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Department;

class UpdateDesignationRequest
{
    public $input = [
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
            'departmentId' => ValidationHelper::idHandler($this->input['departmentId'], 'Departemen'),
            'name' => ValidationHelper::stringHandler($this->input['name'])
        ];

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
