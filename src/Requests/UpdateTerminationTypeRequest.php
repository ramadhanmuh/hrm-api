<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;

class UpdateTerminationTypeRequest
{
    public $input = [
        'name' => null,
        'description' => null
    ], $validation = [
        'status' => true,
        'messages' => []
    ];

    public function __construct() {
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    private function validate() {
        $status = [
            'name' => ValidationHelper::stringHandler(
                $this->input['name']
            ),
            'description' => ValidationHelper::stringHandler(
                $this->input['description'], 'Deskripsi', 65535
            ),
        ];

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );
    }
}
