<?php

namespace Src\Requests;

use finfo;
use Src\Configurations\AvailableDocumentType;
use Src\Helpers\RequestHelper;
use Src\Helpers\TimeHelper;
use Src\Helpers\ValidationHelper;
use Src\Models\Designation;
use Src\Models\Document;
use Src\Models\Employee;
use Src\Models\EmployeeDocument;

class StoreEmployeeRequest
{
    public $input = [
        'id' => null,
        'registrationNumber' => null,
        'designationId' => null,
        'name' => null,
        'phone' => null,
        'email' => null,
        'dateOfBirth' => null,
        'gender' => null,
        'address' => null,
        'dateOfJoin' => null,
        'bankAccountHolderName' => null,
        'bankAccountNumber' => null,
        'bankName' => null,
        'employeeDocuments' => null
    ],  $validation = [
        'status' => true,
        'messages' => []
    ],  $files = [];

    public function __construct() {
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    private function validate() {
        $status = [
            'id' => ValidationHelper::idHandler($this->input['id']),
            'registrationNumber' => ValidationHelper::onlyLettersNumbersDash($this->input['registrationNumber'], 'Nomor Induk'),
            'designationId' => ValidationHelper::idHandler($this->input['designationId'], 'Jabatan'),
            'name' => ValidationHelper::stringHandler($this->input['name']),
            'phone' => ValidationHelper::stringHandler($this->input['phone'], 'Nomor Telepon'),
            'email' => ValidationHelper::emailHandler($this->input['email']),
            'dateOfBirth' => ValidationHelper::timeHandler($this->input['dateOfBirth'], 'Tanggal Lahir'),
            'gender' => ValidationHelper::requiredHandler($this->input['gender'], 'Jenis Kelamin'),
            'address' => ValidationHelper::stringHandler($this->input['address'], 'Alamat', 65535),
            'dateOfJoin' => ValidationHelper::timeHandler($this->input['dateOfJoin'], 'Tanggal Bergabung'),
            'bankAccountHolderName' => ValidationHelper::stringHandler($this->input['bankAccountHolderName'], 'Nama Akun Bank'),
            'bankAccountNumber' => ValidationHelper::stringHandler($this->input['bankAccountNumber'], 'Nomor Akun Bank'),
            'bankName' => ValidationHelper::stringHandler($this->input['bankName'], 'Nama Bank'),
            'employeeDocuments' => $this->documentHandler()
        ];

        if ($status['id'] === true) {
            if (Employee::getOneByColumn(Employee::$table, 'id', 'id', $this->input['id']) !== null) {
                $status['id'] = 'Id sudah digunakan.';
            }
        }

        if ($status['registrationNumber'] === true) {
            if (Employee::getOneByColumn(Employee::$table, 'id', 'registrationNumber', $this->input['registrationNumber']) !== null) {
                $status['registrationNumber'] = 'Nomor Induk sudah digunakan.';
            }
        }

        if ($status['designationId'] === true) {
            if (Designation::getOneByColumn(Designation::$table, 'id', 'id', $this->input['designationId']) === null) {
                $status['designationId'] = 'Jabatan tidak ditemukan.';
            }
        }

        if ($status['email'] === true) {
            if (Employee::getOneByColumn(Employee::$table, 'id', 'email', $this->input['email']) !== null) {
                $status['email'] = 'Email sudah digunakan.';
            }
        }

        if ($status['phone'] === true) {
            if (Employee::getOneByColumn(Employee::$table, 'id', 'phone', $this->input['phone']) !== null) {
                $status['phone'] = 'Nomor Telepon sudah digunakan.';
            }
        }

        if ($status['gender'] === true) {
            if ($this->input['gender'] !== 'Pria' && $this->input['gender'] !== 'Wanita') {
                $status['gender'] = 'Jenis Kelamin hanya boleh diisi Pria dan Wanita.';
            }
        }

        $this->validation = ValidationHelper::setValidation(
            $this->validation, $status
        );

        if (!$this->validation['status']) {
            return;
        }

        $now = TimeHelper::createTimeNow();

        $this->input['createdAt'] = $now;
        $this->input['updatedAt'] = $now;

        if ($this->input['employeeDocuments'] !== null) {
            foreach ($this->input['employeeDocuments'] as $key => $value) {
                $this->input['employeeDocuments'][$key]['employeeId'] = $this->input['id'];
                $this->input['employeeDocuments'][$key]['createdAt'] = $now;
                $this->input['employeeDocuments'][$key]['updatedAt'] = $now;
            }
        }
    }

    private function documentHandler() {
        $documents = Document::getAll();

        if ($documents === null) {
            $this->input['employeeDocuments'] = null;
            return true;
        }

        $employeeDocumentsRequired = 0;

        foreach ($documents as $document) {
            if ($document['status'] === 1) {
                $employeeDocumentsRequired = 1;
            }
        }

        if (($this->input['employeeDocuments'] === null || count($this->input['employeeDocuments']) === 0)  && $employeeDocumentsRequired) {
            return ['Dokumen wajib diisi.'];
        }

        if (!is_array($this->input['employeeDocuments'])) {
            return ['Dokumen Karyawan wajib bertipe data array.'];
        }

        $totalDocuments = count($documents);

        if ($totalDocuments < count($this->input['employeeDocuments'])) {
            return ['Dokumen Karyawan batasnya sampai ' . $totalDocuments . '.'];
        }

        $number = 1;

        $errors = [];

        $availableDocumentType = AvailableDocumentType::get();

        foreach ($this->input['employeeDocuments'] as $employeeDocumentKey => $employeeDocumentValue) {
            $documentIdIsAvailable = 0;

            if (is_array($employeeDocumentValue)) {
                // Validasi id
                if (array_key_exists('id', $employeeDocumentValue)) {
                    if (is_string($employeeDocumentValue['id'])) {
                        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $employeeDocumentValue['id'])) {
                            if (EmployeeDocument::getOneByColumn(EmployeeDocument::$table, 'id', 'id', $employeeDocumentValue['id']) !== null) {
                                $errors[] = 'Id Dokumen Karyawan nomor ' . $number . ' sudah digunakan.';   
                            }
                        } else {
                            $errors[] = 'Id Dokumen Karyawan nomor ' . $number . ' wajib berformat UUID.';
                        }
                    } else {
                        $errors[] = 'Id Dokumen Karyawan nomor ' . $number . ' wajib bertipe data string.';    
                    }
                } else {
                    $errors[] = 'Id Dokumen Karyawan nomor ' . $number . ' wajib diisi.';
                }

                // Validasi id dokumen
                if (array_key_exists('documentId', $employeeDocumentValue)) {
                    if (is_string($employeeDocumentValue['documentId'])) {
                        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $employeeDocumentValue['documentId'])) {
                            foreach ($documents as $documentValue) {
                                if ($documentValue['id'] === $employeeDocumentValue['documentId']) {
                                    $documentIdIsAvailable = 1;
                                    break;
                                }
                            }

                            if (!$documentIdIsAvailable) {
                                $errors[] = 'Id Dokumen nomor ' . $number . ' tidak ditemukan.';
                            }
                        } else {
                            $errors[] = 'Id Dokumen nomor ' . $number . ' wajib berformat UUID.';
                        }
                    } else {
                        $errors[] = 'Id Dokumen nomor ' . $number . ' wajib bertipe data string.';    
                    }
                } else {
                    $errors[] = 'Id Dokumen nomor ' . $number . ' wajib diisi.';
                }

                // Validasi berkas
                if (array_key_exists('file', $employeeDocumentValue)) {
                    if (is_string($employeeDocumentValue['file'])) {
                        $file = explode(';base64,', $employeeDocumentValue['file']);

                        $file = base64_decode(end($file), true);

                        if ($file && $file !== '') {
                            // Buat objek finfo
                            $finfo = new finfo(FILEINFO_MIME_TYPE);

                            // Tentukan MIME type dari konten biner
                            $mime = $finfo->buffer($file);
                            
                            if ($documentIdIsAvailable) {
                                foreach ($documents as $documentValue) {
                                    if ($documentValue['id'] === $employeeDocumentValue['documentId']) {
                                        $extension = '';

                                        foreach ($availableDocumentType as $value) {
                                            if ($value['mime'] === $documentValue['mime']) {
                                                $extension .= $value['extension'];
                                            }
                                        }

                                        if ($mime === $documentValue['mime']) {
                                            $this->files[$employeeDocumentKey] = [
                                                'documentId' => $employeeDocumentValue['documentId'],
                                                'file' => $file,
                                                'extension' => $extension
                                            ];
                                        } else {
                                            $errors[] = 'Berkas Dokumen Karyawan nomor ' . $number . ' wajib memiliki ekstensi ' . $extension . '.';

                                            break;
                                        }
                                    }
                                }
                            }
                        } else {
                            $errors[] = 'Berkas Dokumen Karyawan nomor ' . $number . ' wajib berformat base64.';
                        }
                    } else {
                        $errors[] = 'Berkas Dokumen Karyawan nomor ' . $number . ' wajib bertipe data string.';
                    }
                } else {
                    $errors[] = 'Berkas Dokumen Karyawan nomor ' . $number . ' wajib diisi.';
                }

            } else {
                $errors[] = 'Dokumen Karyawan nomor ' . $number . ' wajib bertipe data array.';
            }

            $number++;
        }

        foreach ($documents as $document) {
            if ($document['status'] === 1) {
                $documentIsFilledIn = 0;

                foreach ($this->input['employeeDocuments'] as $employeeDocument) {
                    if ($employeeDocument['documentId'] === $document['id']) {
                        $documentIsFilledIn = 1;
                    }
                }

                if (!$documentIsFilledIn) {
                    $errors[] = 'Dokumen ' . $document['name'] . ' wajib diisi.';
                }
            }
        }

        return empty($errors) ? true : $errors;
    }
}
