<?php

namespace Src\Routes\Manager;

use Src\Controllers\TerminationTypeController;
use Src\Middleware\UserIsManager;

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
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => TerminationTypeController::class,
                'function' => 'list',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => TerminationTypeController::class,
                'function' => 'count',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => TerminationTypeController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => TerminationTypeController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => TerminationTypeController::class,
                'function' => 'delete',
                'middleware' => [UserIsManager::class]
            ],
        ]
    ];
}
