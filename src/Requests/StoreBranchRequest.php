<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Branch;

class StoreBranchRequest
{
    public $input = [
        'id' => null,
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
            'name' => ValidationHelper::stringHandler($this->input['name'])
        ];

        if ($status['id'] === true) {
            $data = Branch::getOneByColumn(
                Branch::$table, 'name', 'id', $this->input['id']
            );

            if (
                Branch::getOneByColumn(
                    Branch::$table, 'name', 'id', $this->input['id']
                ) !== null
            ) $status['id'] = 'Id sudah digunakan.';
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        return $this->validation;
    }
}
