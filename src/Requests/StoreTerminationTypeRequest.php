<?php

namespace Src\Requests;

use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\TerminationType;

class StoreTerminationTypeRequest
{
    public $input = [
        'id' => null,
        'name' => null,
        'description' => null
    ], $validation = [
        'status' => true,
        'messages' => []
    ], $model;

    public function __construct() {
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    private function validate() {
        $status = [
            'id' => ValidationHelper::idHandler($this->input['id']),
            'name' => ValidationHelper::stringHandler(
                $this->input['name']
            ),
            'description' => ValidationHelper::stringHandler(
                $this->input['description'], 'Deskripsi', 65535
            ),
        ];

        if ($status['id'] === true) {
            $data = TerminationType::getOneByColumn(
                TerminationType::$table, 'name', 'id', $this->input['id']
            );

            if ($data !== null) $status['id'] = 'Id sudah digunakan.';
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );
    }
}
