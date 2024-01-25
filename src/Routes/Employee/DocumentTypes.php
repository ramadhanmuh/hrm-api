<?php

namespace Src\Routes\Employee;

use Src\Controllers\DocumentTypeController;
use Src\Middleware\UserIsEmployee;

class DocumentTypes
{
    static $list = [
        'path' => 'document-types',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DocumentTypeController::class,
                'function' => 'list',
                'middleware' => [UserIsEmployee::class]
            ]
        ]
    ];
}
