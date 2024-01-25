<?php

namespace Src\Helpers;

class ValidationHelper
{
    static function requiredHandler($input, $label) {
        if ($input === null || $input === '') {
            return $label . ' wajib diisi.';
        }

        return true;
    }

    static function stringTypeHandler($input, $label) {
        if (is_string($input)) {
            return true;
        }

        return $label . ' wajib bertipe string.';
    }

    static function emailFormatHandler($input, $label) {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        
        return $label . ' wajib berformat email.';
    }

    static function idHandler($input, $label = 'Id') {
        if ($input === '' || $input === null) {
            return $label . ' wajib diisi.';
        }

        if (is_string($input)) {
            return preg_match(
                    '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
                    $input
                ) ?
                true :
                $label . ' wajib berformat UUID.';
        }
        
        return $label . ' wajib bertipe string';
    }

    static function emailHandler($input, $label = 'Email') {
        if ($input === null) {
            return $label . ' wajib diisi.';
        }

        if (is_string($input)) {
            if (strlen($input) > 255) {
                return $label . ' tidak boleh punya karakter lebih dari 255.';
            }

            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                return true;
            }

            return $label . ' wajib berformat email.';
        }
        
        return $label . ' wajib bertipe string.';
    }

    static function stringHandler($input, $label = 'Nama', $maxLength = 255) {
        if ($input === null) {
            return $label . ' wajib diisi.';
        }
        
        if (is_string($input)) {
            if (strlen($input) > $maxLength) {
                return $label . ' tidak boleh punya karakter lebih dari ' . number_format($maxLength, 0, ',' . '.');
            }

            return true;
        }

        return $label . ' wajib bertipe string.';
    }

    static function integerTypeHandler($input, $label) {
        if (is_int($input)) {
            return true;
        }

        return $label . ' wajib bertipe integer.';
    }

    static function setValidation($validation, $status) {
        foreach ($status as $key => $value) {
            if ($value !== true) {
                $validation['status'] = false;
                $validation['messages'][$key] = $value;
            }
        }

        return $validation;
    }

    static function onlyLettersNumbersDash($input, $label = 'Id', $maxLength = 255) {
        // Pattern untuk hanya mengizinkan karakter huruf, angka, dan strip
        // Memeriksa apakah input sesuai dengan pattern
        if (!preg_match('/^[a-zA-Z0-9\-]+$/', $input)) {
            return $label . ' wajib diisi dan hanya boleh berkarakter angka, huruf, dan strip.';
        }

        if (strlen($input) > $maxLength) {
            return $label . ' tidak boleh punya panjang lebih dari ' .
                    number_format($maxLength, 0, ',', '.') .
                    ' karakter.';
        }
        
        return true;  // input valid
    }

    static function timeHandler($input, $label) {
        if ($input === null || $input === false || $input === '') {
            return $label . ' wajib diisi.';
        }

        if (!is_int($input)) {
            return $label . ' wajib bertipe integer.';
        }

        if ($input < 0) {
            return $label . ' wajib lebih dari -1.';
        }

        if ($input > 18446744073709552000) {
            return $label . ' wajib kurang dari 18.446.744.073.709.552.000.';
        }

        return true;
    }
}
