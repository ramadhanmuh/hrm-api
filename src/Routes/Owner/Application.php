<?php

namespace Src\Routes\Owner;

use Src\Controllers\ApplicationController;
use Src\Middleware\UserIsOwner;

class Application
{
    static $list = [
        'path' => 'application',
        'list' => [
            [
                'path' => '',
                'method' => 'PUT',
                'controller' => ApplicationController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
        ]
    ];
}
