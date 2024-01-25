<?php

namespace Src\Requests;

use finfo;
use Src\Configurations\AvailableDocumentType;
use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Document;
use Src\Models\Employee;
use Src\Models\EmployeeDocument;

class UpdateEmployeeDocumentRequest
{
    public $input = [
        'employeeId' => null,
        'documentId' => null,
        'file' => null
    ],  $fileValue = null,
        $fileExtension,
        $document,
        $validation = [
            'status' => true,
            'messages' => []
        ],
        $id;

    public function __construct($id) {
        $this->id = $id;
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    private function validate() {
        $status = [
            'employeeId' => ValidationHelper::idHandler($this->input['employeeId'], 'Karyawan'),
            'documentId' => ValidationHelper::idHandler($this->input['documentId'], 'Dokumen')
        ];

        $employeeIdIsAvailable = 1;

        if ($status['employeeId'] === true) {
            if (Employee::getOneByColumn(Employee::$table, 'id', 'id', $this->input['employeeId']) === null) {
                $status['employeeId'] = 'Karyawan tidak ditemukan.';
                $employeeIdIsAvailable = 0;
            }
        }

        $documentIdIsAvailable = 1;

        if ($status['documentId'] === true) {
            $this->document = Document::getOneByColumn(Document::$table, 'mime', 'id', $this->input['documentId']);

            if ($this->document === null) {
                $documentIdIsAvailable = 0;
                $status['documentId'] = 'Dokumen tidak ditemukan.';
            } else {
                if ($employeeIdIsAvailable) {
                    if (EmployeeDocument::getOneByEmployeeAndDocumentWithoutSomeId($this->input['employeeId'], $this->input['documentId'], $this->id) !== null) {
                        $status['documentId'] = 'Dokumen sudah digunakan.';
                        $documentIdIsAvailable = 0;
                    }
                }
            }
        }

        if ($this->input['file'] !== null) {
            $status['file'] = ValidationHelper::stringTypeHandler($this->input['file'], 'Berkas');

            if ($status['file'] === true) {
                $this->input['file'] = explode(';base64,', $this->input['file']);

                $this->fileValue = base64_decode(end($this->input['file']), true);

                if ($this->fileValue && $this->fileValue !== '') {
                    if ($documentIdIsAvailable) {
                        // Buat objek finfo
                        $finfo = new finfo(FILEINFO_MIME_TYPE);
    
                        // Tentukan MIME type dari konten biner
                        $mime = $finfo->buffer($this->fileValue);
    
                        $availableDocumentType = AvailableDocumentType::get();

                        foreach ($availableDocumentType as $documentType) {
                            if ($documentType['mime'] === $this->document['mime'])
                                $this->fileExtension = $documentType['extension'];
                        }

                        if ($mime !== $this->document['mime']) {
                            $status['file'] = 'Berkas wajib memiliki ekstensi ' . $this->fileExtension . '.';
                        }
                    }
                } else {
                    $status['file'] = 'Berkas wajib berformat base64.';
                }
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
