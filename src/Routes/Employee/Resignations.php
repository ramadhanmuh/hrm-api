<?php

namespace Src\Routes\Employee;

use Src\Controllers\ResignationController;
use Src\Middleware\UserIsEmployee;

class Resignations
{
    static $list = [
        'path' => 'resignations',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => ResignationController::class,
                'function' => 'create',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => ResignationController::class,
                'function' => 'list',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => ResignationController::class,
                'function' => 'count',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => ResignationController::class,
                'function' => 'update',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => ResignationController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => ResignationController::class,
                'function' => 'delete',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
