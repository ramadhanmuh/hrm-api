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

class StoreEmployeeDocumentRequest
{
    public $input = [
        'id' => null,
        'employeeId' => null,
        'documentId' => null,
        'file' => null
    ],  $fileValue = null,
        $fileExtension,
        $document,
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
            'employeeId' => ValidationHelper::idHandler($this->input['employeeId'], 'Karyawan'),
            'documentId' => ValidationHelper::idHandler($this->input['documentId'], 'Dokumen'),
            'file' => ValidationHelper::requiredHandler($this->input['file'], 'Berkas')
        ];
        
        if ($status['id'] === true) {
            if (EmployeeDocument::getOneByColumn(EmployeeDocument::$table, 'id', 'id', $this->input['id']) !== null) {
                $status['id'] = 'Id sudah digunakan.';
            }
        }

        if ($status['employeeId'] === true) {
            $status['employeeId'] = Employee::getOneByColumn(
                Employee::$table, 'id', 'id', $this->input['employeeId']
            ) === null ? 'Karyawan tidak ditemukan' : true;
        }

        $documentIdIsAvailable = 1;

        if ($status['documentId'] === true) {
            $this->document = Document::getOneByColumn(
                Document::$table, 'mime', 'id', $this->input['documentId']
            );

            if ($this->document === null) {
                $documentIdIsAvailable = 0;
                $status['documentId'] = 'Dokumen tidak ditemukan.';
            } else {
                if ($status['employeeId'] === true) {
                    $employeeDocument = EmployeeDocument::getOneByEmployeeAndDocument($this->input['employeeId'], $this->input['documentId']);
    
                    if ($employeeDocument !== null) {
                        $status['documentId'] = 'Dokumen sudah dibuat.';
                        $documentIdIsAvailable = 0;
                    }
                }
            }
        }

        if ($status['file'] === true) {
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
            $this->input['createdAt'] = TimeHelper::createTimeNow();
            $this->input['updatedAt'] = $this->input['createdAt'];
        }
    }
}
