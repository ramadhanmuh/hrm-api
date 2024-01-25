<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;

class UpdateBranchRequest
{
    public $input = [
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
            'name' => ValidationHelper::stringHandler($this->input['name'])
        ];

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        return $this->validation;
    }
}
