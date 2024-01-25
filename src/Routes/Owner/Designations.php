<?php

namespace Src\Routes\Owner;

use Src\Controllers\DesignationController;
use Src\Middleware\UserIsOwner;

class Designations
{
    static $list = [
        'path' => 'designations',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => DesignationController::class,
                'function' => 'create',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => DesignationController::class,
                'function' => 'list',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => DesignationController::class,
                'function' => 'count',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => DesignationController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => DesignationController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => DesignationController::class,
                'function' => 'delete',
                'middleware' => [UserIsOwner::class]
            ],
        ]
    ];
}
