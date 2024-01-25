<?php

namespace Src\Routes\Manager;

use Src\Controllers\TerminationController;
use Src\Middleware\UserIsManager;

class Terminations
{
    static $list = [
        'path' => 'terminations',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => TerminationController::class,
                'function' => 'create',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => TerminationController::class,
                'function' => 'list',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => TerminationController::class,
                'function' => 'count',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => TerminationController::class,
                'function' => 'update',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => TerminationController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => TerminationController::class,
                'function' => 'delete',
                'middleware' => [ UserIsManager::class ]
            ],
        ]
    ];
}
