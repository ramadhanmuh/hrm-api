<?php

namespace Src\Helpers;

use Src\Configurations\Environment;

class StringHelper
{
    public static function hash($string) {
        // Hash menggunakan algoritma MD5
        $hash = md5($string . Environment::$value['hashKey']);

        // Ubah hash menjadi format huruf dan angka saja menggunakan base64_encode
        $hash = base64_encode($hash);

        // Hapus karakter-karakter yang tidak diinginkan (misalnya, karakter khusus)
        $hash = preg_replace('/[^a-zA-Z0-9]/', '', $hash);

        return $hash;
    }

    public static function createToken($length = 32) {
        // Membuat string unik sepanjang $length karakter
        $uniqueString = md5(uniqid(mt_rand(), true));

        // Pastikan panjang string adalah $length karakter
        if (strlen($uniqueString) < $length) {
            $uniqueString = str_pad($uniqueString, $length, '0', STR_PAD_RIGHT);
        } elseif (strlen($uniqueString) > $length) {
            $uniqueString = substr($uniqueString, 0, $length);
        }

        return $uniqueString;
    }

    // Fungsi untuk mengenkripsi string
    static function encrypt(string $string) {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            $keyChar = Environment::$value['hashKey'][$i % strlen(Environment::$value['hashKey'])];
            $result .= chr(ord($char) ^ ord($keyChar));
        }
        return base64_encode($result);
    }
    
    // Fungsi untuk mendekripsi string
    static function decrypt($encrypted) {
        $result = '';
        $encrypted = base64_decode($encrypted);
        for ($i = 0; $i < strlen($encrypted); $i++) {
            $char = $encrypted[$i];
            $keyChar = Environment::$value['hashKey'][$i % strlen(Environment::$value['hashKey'])];
            $result .= chr(ord($char) ^ ord($keyChar));
        }
        return $result;
    }

    static function createSlug($text) {
        // Menghapus karakter khusus
        $text = preg_replace('/[^a-zA-Z0-9]+/', '-', $text);
        
        // Menghilangkan tanda strip di awal dan akhir teks
        $text = trim($text, '-');
        
        // Mengonversi huruf menjadi huruf kecil semua
        $text = strtolower($text);
        
        return $text;
    }

    static function specialCharacterToStripe($string) : string {
        return trim(preg_replace('/[^a-zA-Z0-9]+/', 'a', $string));
    }
}
