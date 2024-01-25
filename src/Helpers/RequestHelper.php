<?php

namespace Src\Helpers;

use Src\Systems\Router;

class RequestHelper
{
    static $value = [];

    /**
     * Untuk mendapatkan isi segmen rute yang dituju
     * 
     * @param int $key Nomor kunci array
     * 
     * @return string Isi segmen
     */
    static function getSegmentContent($key) {
        return Router::$segments[$key];
    }

    /**
     * Untuk mendapatkan isi parameter berupa string berdasarkan kata kunci
     * 
     * @param string $key Nama kata kunci parameter
     * @param $default Isi bawaan
     * 
     * @return $default Isi dari parameter
     */
    static function getStringParameter($key, $default = false) {
        $value = array_key_exists($key, $_GET) ? $_GET[$key] : $default;
        
        if ($value !== $default && !is_string($value)) {
            $value = $default;
        }

        return $value;
    }

    /**
     * Untuk mendapatkan isi parameter berupa array berdasarkan kata kunci
     * 
     * @param string $key Nama kata kunci parameter
     * @param $default Isi bawaan
     * 
     * @return $default Isi dari parameter
     */
    static function getArrayParameter($key, $default = false) {
        $value = [];

        $parameters = array_key_exists($key, $_GET) ? $_GET[$key] : $default;

        if (is_array($parameters)) {
            foreach ($parameters as $parameter) {
                if ( is_string($parameter) && count($value) < 21 ) $value[] = $parameter;
            }
        } else {
            $value = $default;
        }

        return $value;
    }

    /**
     * Mendapatkan parameter limit
     * 
     * @return integer Jumlah yang ingin didapatkan
     */
    static function getLimitParameter() {
        $value = array_key_exists('limit', $_GET) ? intval($_GET['limit']) : 20;

        if ($value < 1 || $value > 20) {
            $value = 20;
        }

        return $value;
    }

    /**
     * Mendapatkan paramater offset
     * 
     * @return integer Index yang ingin dimulai
     */
    static function getOffsetParameter() {
        $value = array_key_exists('offset', $_GET) ? intval($_GET['offset']) : 0;

        if ($value < 0 || $value > 1000) {
            $value = 0;
        }

        return $value;
    }

    /**
     * Mendapatkan paramater yang berformat angka
     * 
     * @param $key Kata kunci parameter
     * @param $default Isi bawaan
     * 
     * @return string Isi parameter
     */
    static function getNumericParameter($key, $default = false) {
        if (array_key_exists($key, $_GET)) {
            if (is_numeric($_GET[$key])) {
                return $_GET[$key];
            }
        }

        return $default;
    }

    /**
     * Mendapatkan paramater yang berformat string dan tersedia
     * 
     * @param string $key Kata kunci parameter
     * @param array $availableValues Isi yang tersedia
     * @param $default Isi bawaan
     * 
     * @return string Isi parameter
     */
    static function getStringParameterWithAvailableValue($key, $availableValues, $default = null) {
        if (array_key_exists($key, $_GET)) {
            if (in_array($_GET[$key], $availableValues)) {
                return $_GET[$key];
            }
        }

        return $default;
    }

    static function getSelectParameter($availableValues) {
        if (!array_key_exists('select', $_GET) || !is_array($_GET['select'])) {
            return $availableValues;
        }

        $values = [];

        foreach ($_GET['select'] as $value) {
            if (in_array($value, $availableValues)) {
                $values[] = $value;
            }
        }

        return $values === [] ? $availableValues : $values;
    }

    /**
     * Membetulkan memeriksa isi array dan membetulkan isi array jika tidak ada dalam pilihan array
     * 
     * @param array $array Paramater bertipe data array yang ingin diperiksa dan dibetulkan
     * @param array $availableValues Isi parameter yang tersedia
     * 
     * @return array Hasil pemeriksaan berupa array baru atau $array atau $availableValues
     */
    static function checkAndFixArrayValue($array, $availableValues) {
        if ($array !== $availableValues) {
            $values = [];

            foreach ($array as $value) {
                if ( in_array($value, $availableValues) ) $values[] = $value;
            }

            if ($values === []) {
                return $availableValues;
            }

            return $values;
        }

        return $array;
    }

    /**
     * Untuk mendapatkan input berformat JSON
     * 
     * @param array $defaultRequest Input bawaan saat input kosong
     * 
     * @return array Hasil proses mendapatkan input
     */
    static function getJSONInput($defaultRequest) {
        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (!empty($jsonData)) {
            foreach ($jsonData as $key => $value) {
                if (array_key_exists($key, $defaultRequest)) {
                    $defaultRequest[$key] = $value;
                }
            }
        }

        return $defaultRequest;
    }
}
