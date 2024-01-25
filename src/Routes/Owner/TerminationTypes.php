<?php

namespace Src\Routes\Owner;

use Src\Controllers\TerminationTypeController;
use Src\Middleware\UserIsOwner;

class TerminationTypes
{
    static $list = [
        'path' => 'termination-types',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => TerminationTypeController::class,
                'function' => 'create',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => TerminationTypeController::class,
                'function' => 'list',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => TerminationTypeController::class,
                'function' => 'count',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => TerminationTypeController::class,
                'function' => 'update',
                'middleware' => [UserIsOwner::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => TerminationTypeController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsOwner::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => TerminationTypeController::class,
                'function' => 'delete',
                'middleware' => [UserIsOwner::class]
            ],
        ]
    ];
}
