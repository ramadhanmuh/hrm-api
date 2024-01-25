<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Branch;

class UpdateDepartmentRequest
{
    public $input = [
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
            'branchId' => ValidationHelper::idHandler($this->input['branchId'], 'Cabang'),
            'name' => ValidationHelper::stringHandler($this->input['name'])
        ];

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
