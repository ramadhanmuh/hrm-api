<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Branch;
use Src\Models\Department;

class StoreDepartmentRequest
{
    public $input = [
        'id' => null,
        'branchId' => null,
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
            'branchId' => ValidationHelper::idHandler($this->input['branchId'], 'Cabang'),
            'name' => ValidationHelper::stringHandler($this->input['name'])
        ];

        if ($status['id'] === true) {
            $data = Department::getOneByColumn(
                Department::$table, 'name', 'id', $this->input['id']
            );

            if ($data !== null) {
                $status['id'] = 'Id sudah digunakan.';
            }
        }

        if ($status['branchId'] === true) {
            $data = Branch::getOneByColumn(
                Branch::$table, 'name', 'id', $this->input['branchId']
            );

            if ($data === null) {
                $status['branchId'] = 'Cabang tidak ditemukan.';
            }
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );
    }
}
