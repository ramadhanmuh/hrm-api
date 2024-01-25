<?php

namespace Src\Requests;

use finfo;
use Src\Helpers\RequestHelper;
use Src\Helpers\ValidationHelper;

class UpdateApplicationRequest
{
    public $input = [
        'name' => null,
        'status' => null,
        'desktopImage' => null,
        'tabletImage' => null,
        'mobileImage' => null,
    ],
    $validation = [
        'status' => true,
        'messages' => []
    ], $desktopImage, $tabletImage, $mobileImage;

    function __construct() {
        $this->input = RequestHelper::getJSONInput($this->input);
        $this->validate();
    }

    /**
     * Untuk validasi input yang dikirim pengguna
     * 
     * @return array Sebuah hasil validasi
     */
    private function validate() {
        $status = [
            'name' => ValidationHelper::stringHandler($this->input['name']),
            'status' => ValidationHelper::requiredHandler($this->input['status'], 'Status')
        ];

        if ($status['status'] === true) {
            $status['status'] = ValidationHelper::integerTypeHandler($this->input['status'], 'Status');
        }

        if ($status['status'] === true) {
            $status['status'] = $this->input['status'] === 0 || $this->input['status'] === 1 ? true : 'Status hanya boleh berisi 1 (Aktif) dan 0 (Tidak Aktif)';
        }

        if ($this->input['desktopImage'] !== null) {
            $status['desktopImage'] = $this->imageValidation('desktopImage', 'Gambar Desktop');
        }

        if ($this->input['tabletImage'] !== null) {
            $status['tabletImage'] = $this->imageValidation('tabletImage', 'Gambar Tablet');
        }

        if ($this->input['mobileImage'] !== null) {
            $status['mobileImage'] = $this->imageValidation('mobileImage', 'Gambar Seluler');
        }

        $this->validation = ValidationHelper::setValidation($this->validation, $status);
    }

    private function imageValidation($name, $label) {
        $status = true;

        if (!is_string($this->input[$name])) {
            $status = $label . ' wajib bertipe data string.';
        }

        if ($status === true) {
            $this->{$name} = explode(';base64,', $this->input[$name]);

            $this->{$name} = base64_decode(end($this->{$name}), true);

            if (!$this->{$name} || $this->{$name} === '') {
                $status = $label . ' wajib berformat base64.';
            }            
        }

        if ($status === true) {
            // Buat objek finfo
            $finfo = new finfo(FILEINFO_MIME_TYPE);

            $mime = $finfo->buffer($this->{$name});

            if ($mime !== 'image/png') {
                $status = $label . ' wajib berektensi png.';
            }
        }

        if ($status === true && strlen($this->{$name}) > 10485760) {
            $status = $label . ' maksimal berukuran 10 MB.';
        }

        return $status;
    }
}
