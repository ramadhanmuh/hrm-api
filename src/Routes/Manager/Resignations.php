<?php

namespace Src\Routes\Manager;

use Src\Controllers\ResignationController;
use Src\Middleware\UserIsManager;

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
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => ResignationController::class,
                'function' => 'list',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => ResignationController::class,
                'function' => 'count',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => ResignationController::class,
                'function' => 'update',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => ResignationController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => ResignationController::class,
                'function' => 'delete',
                'middleware' => [ UserIsManager::class ]
            ],
        ]
    ];
}
