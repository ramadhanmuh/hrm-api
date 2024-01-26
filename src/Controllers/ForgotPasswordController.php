<?php

namespace Src\Controllers;

use Src\Configurations\Environment;
use Src\Helpers\ResponseHelper;
use Src\Requests\ForgotPasswordRequest;

class ForgotPasswordController
{
    function send() {
        $request = new ForgotPasswordRequest;

        if (!$request->validation['status']) {
            return ResponseHelper::createBadRequest($request->validation['messages']);
        }

        // Konfigurasi email
        $to = $request->input['email'];
        $subject = 'Lupa Kata Sandi';
        $message = 'Isi pesan';

        // Header email
        $headers = "From: " . Environment::$value['mailFromAddress'] . "\r\n";
        $headers .= "Reply-To: " . Environment::$value['mailFromAddress'] . "\r\n";
        $headers .= "Content-Type: text/html\r\n";

        // Konfigurasi server SMTP
        $smtpServer = Environment::$value['mailHost'];
        $smtpPort = Environment::$value['mailPort']; // Ganti dengan port SMTP yang sesuai (misalnya 587 untuk TLS)

        // Informasi akun SMTP
        $smtpUsername = Environment::$value['mailUsername'];
        $smtpPassword = Environment::$value['mailPassword'];

        // Inisialisasi koneksi ke server SMTP
        $smtpConnection = fsockopen($smtpServer, $smtpPort, $errno, $errstr, 30);

        if (!$smtpConnection) {
            if (Environment::$value['production']) {
                return ResponseHelper::createInternalServerError();
            }

            die("Koneksi ke server SMTP gagal: $errstr ($errno)");
        }

        // Baca pesan selamat datang dari server
        $response = fgets($smtpConnection, 515);
        echo $response;

        // Kirim perintah EHLO untuk memulai sesi dengan server SMTP
        fputs($smtpConnection, "EHLO example.com\r\n");
        $response = fgets($smtpConnection, 515);
        echo $response;

        // Autentikasi jika diperlukan
        fputs($smtpConnection, "AUTH LOGIN\r\n");
        $response = fgets($smtpConnection, 515);
        echo $response;

        // Kirim username
        fputs($smtpConnection, base64_encode($smtpUsername) . "\r\n");
        $response = fgets($smtpConnection, 515);
        echo $response;

        // Kirim password
        fputs($smtpConnection, base64_encode($smtpPassword) . "\r\n");
        $response = fgets($smtpConnection, 515);
        echo $response;

        // Kirim perintah MAIL FROM
        fputs($smtpConnection, "MAIL FROM: <$smtpUsername>\r\n");
        $response = fgets($smtpConnection, 515);
        echo $response;

        // Kirim perintah RCPT TO
        fputs($smtpConnection, "RCPT TO: <$to>\r\n");
        $response = fgets($smtpConnection, 515);
        echo $response;

        // Kirim perintah DATA
        fputs($smtpConnection, "DATA\r\n");
        $response = fgets($smtpConnection, 515);
        echo $response;

        // Kirim email
        fputs($smtpConnection, "Subject: $subject\r\n");
        fputs($smtpConnection, "$headers\r\n");
        fputs($smtpConnection, "\r\n$message\r\n.\r\n");

        $response = fgets($smtpConnection, 515);
        echo $response;

        // Tutup koneksi
        fclose($smtpConnection);

        echo 'Berhasil mengirim email.';

        return ResponseHelper::createOK([
            'email' => $request->input['email']
        ], 'Berhasil mengirim pesan ke email pengguna.');
    }
}
