<?php

namespace Src\Routes\Manager;

use Src\Controllers\EmployeeDocumentController;
use Src\Middleware\UserIsManager;

class EmployeeDocuments
{
    static $list = [
        'path' => 'employee-documents',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => EmployeeDocumentController::class,
                'function' => 'create',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => EmployeeDocumentController::class,
                'function' => 'list',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => EmployeeDocumentController::class,
                'function' => 'count',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => EmployeeDocumentController::class,
                'function' => 'update',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => EmployeeDocumentController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => EmployeeDocumentController::class,
                'function' => 'delete',
                'middleware' => [UserIsManager::class]
            ],
            [
                'path' => '$',
                'list' => [
                    [
                        'path' => 'open',
                        'method' => 'GET',
                        'controller' => EmployeeDocumentController::class,
                        'function' => 'open',
                        'middleware' => [ UserIsManager::class ],
                    ]
                ]
            ],
        ]
    ];
}
