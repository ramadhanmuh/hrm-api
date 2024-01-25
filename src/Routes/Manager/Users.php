<?php

namespace Src\Routes\Manager;

use Src\Controllers\Manager\UserController;
use Src\Middleware\UserIsManager;

class Users
{
    static $list = [
        'path' => 'users',
        'list' => [
            [
                'path' => '',
                'method' => 'GET',
                'controller' => UserController::class,
                'function' => 'list',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'POST',
                'controller' => UserController::class,
                'function' => 'create',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => UserController::class,
                'function' => 'count',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => UserController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => UserController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => UserController::class,
                'function' => 'delete',
                'middleware' => [UserIsManager::class]
            ],
        ]
    ];
}
