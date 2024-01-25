<?php

namespace Src\Routes\Employee;

use Src\Controllers\DocumentController;
use Src\Middleware\UserIsEmployee;

class Documents
{
    static $list = [
        'path' => 'documents',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DocumentController::class,
                'function' => 'list',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => DocumentController::class,
                'function' => 'count',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => DocumentController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
