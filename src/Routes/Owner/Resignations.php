<?php

namespace Src\Routes\Owner;

use Src\Controllers\ResignationController;
use Src\Middleware\UserIsOwner;

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
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => ResignationController::class,
                'function' => 'list',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => ResignationController::class,
                'function' => 'count',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => ResignationController::class,
                'function' => 'update',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => ResignationController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => ResignationController::class,
                'function' => 'delete',
                'middleware' => [ UserIsOwner::class ]
            ],
        ]
    ];
}
