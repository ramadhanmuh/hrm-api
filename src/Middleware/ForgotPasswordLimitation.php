<?php

namespace Src\Middleware;

use Src\Helpers\ResponseHelper;
use Src\Helpers\StringHelper;
use Src\Systems\Middleware;

class ForgotPasswordLimitation extends Middleware
{
    function run() {
        $ipAddress = getenv('REMOTE_ADDR');

        if (!is_string($ipAddress)) {
            return ResponseHelper::createForbidden('Layanan membutuhkan Alamat IP.');
        }

        $filePath = './src/Storage/ForgotPasswordLimitation/' . StringHelper::specialCharacterToStripe($ipAddress);

        if (file_exists($filePath)) {
            // Untuk membaca data dari berkas cache
            $cachedData = file_get_contents($filePath);

            // Mengembalikan data dari berkas cache yang bertipe data string menjadi array
            $cachedData = unserialize($cachedData);

            $now = time();

            // Jika pengguna masih melakukan permintaan kurang dari 4 kali
            if ($cachedData['total'] < 4) {
                // Jika masih belum waktu kadaluarsa
                if ($cachedData['expiredAt'] > $now) {
                    $cachedData['total']++;
                } else {
                    $cachedData['total'] = 1;
                    $cachedData['expiredAt'] = $now + 300;
                }

                file_put_contents($filePath, serialize($cachedData));

                return $this->continue;
            }

            if ($cachedData['expiredAt'] < $now) {
                $cachedData['total'] = 1;
                $cachedData['expiredAt'] = $now + 300;
                
                file_put_contents($filePath, serialize($cachedData));

                return $this->continue;
            }

            return ResponseHelper::createTooManyRequest();
        }
        
        $cachedData = [
            'total' => 1,
            'expiredAt' => time() + 300
        ];

        file_put_contents($filePath, serialize($cachedData));

        return $this->continue;
    }
}
