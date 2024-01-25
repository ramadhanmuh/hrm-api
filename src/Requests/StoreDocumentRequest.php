<?php

namespace Src\Requests;

use Src\Configurations\AvailableDocumentType;
use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Document;

class StoreDocumentRequest
{
    public $input = [
        'id' => null,
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
            'id' => ValidationHelper::idHandler($this->input['id']),
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

        if ($status['id'] === true) {
            $data = Document::getOneByColumn(
                Document::$table, 'name', 'id', $this->input['id']
            );

            if ($data !== null) {
                $status['id'] = 'Id sudah digunakan.';
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
            $this->input['createdAt'] = TimeHelper::createTimeNow();
            $this->input['updatedAt'] = $this->input['createdAt'];
        }
    }
}
