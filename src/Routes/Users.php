<?php

namespace Src\Routes;

use Src\Controllers\AuthController;
use Src\Controllers\ForgotPasswordController;
use Src\Controllers\UserController;
use Src\Middleware\ForgotPasswordLimitation;
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
                'path' => 'forgot-password',
                'method' => 'POST',
                'controller' => ForgotPasswordController::class,
                'function' => 'send',
                'middleware' => [
                    ForgotPasswordLimitation::class
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
