<?php

namespace Src\Middleware;

use Src\Helpers\RequestHelper;
use Src\Helpers\ResponseHelper;
use Src\Models\UserToken;
use Src\Systems\Middleware;

class ApplicationStatus extends Middleware
{
    function run() {
        $filePath = './src/Storage/Application/app';

        if (file_exists($filePath)) {
            $values = unserialize(file_get_contents($filePath));
        } else {
            $values = [
                'name' => 'HRM',
                'status' => 1
            ];
        }

        if ($values['status'] !== 1) {
            return ResponseHelper::createServiceUnavailable();
        }

        return $this->continue;
    }
}
