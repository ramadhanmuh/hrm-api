<?php

namespace Src\Requests;

use Src\Configurations\AvailableDocumentType;
use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;

class UpdateDocumentRequest
{
    public $input = [
        'name' => null,
        'status' => null,
        'mime' => null
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
            'name' => ValidationHelper::stringHandler($this->input['name']),
            'status' => ValidationHelper::requiredHandler($this->input['status'], 'Status'),
            'mime' => ValidationHelper::stringHandler($this->input['mime'], 'Mime')
        ];

        if ($status['mime'] === true) {
            $status['mime'] = 'Mime tidak tersedia.';

            $availableMime = AvailableDocumentType::get();

            foreach ($availableMime as $value) {
                if ($this->input['mime'] === $value['mime']) {
                    $status['mime'] = true;
                }
            }
        }

        if ($status['status'] === true) {
            $status['status'] = ValidationHelper::integerTypeHandler(
                $this->input['status'], 'Status'
            );

            if ($status['status'] === true && $this->input['status'] !== 0 && $this->input['status'] !== 1) {
                $status['status'] = 'Status hanya boleh berisi 0 (Tidak Wajib) atau 1 (Wajib)';
            }
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        if ($this->validation['status']) {
            $this->input['updatedAt'] = TimeHelper::createTimeNow();
        }
    }
}
