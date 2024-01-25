<?php

namespace Src\Routes\Employee;

use Src\Controllers\EmployeeDocumentController;
use Src\Middleware\UserIsEmployee;

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
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => EmployeeDocumentController::class,
                'function' => 'list',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => EmployeeDocumentController::class,
                'function' => 'count',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => EmployeeDocumentController::class,
                'function' => 'update',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => EmployeeDocumentController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => EmployeeDocumentController::class,
                'function' => 'delete',
                'middleware' => [UserIsEmployee::class]
            ],
            [
                'path' => '$',
                'list' => [
                    [
                        'path' => 'open',
                        'method' => 'GET',
                        'controller' => EmployeeDocumentController::class,
                        'function' => 'open',
                        'middleware' => [ UserIsEmployee::class ],
                    ]
                ]
            ],
        ]
    ];
}
