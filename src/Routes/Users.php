<?php

namespace Src\Routes;

use Src\Controllers\AuthController;
use Src\Controllers\UserController;
use Src\Middleware\LoginLimitation;

class Users
{
    static $list = [
        'path' => 'users',
        'list' => [
            [
                'path' => 'login',
                'method' => 'POST',
                'controller' => AuthController::class,
                'function' => 'authenticate',
                'middleware' => [
                    LoginLimitation::class
                ]
            ],
            [
                'path' => 'start',
                'method' => 'GET',
                'controller' => UserController::class,
                'function' => 'start',
                'middleware' => []
            ],
        ]
    ];
}
