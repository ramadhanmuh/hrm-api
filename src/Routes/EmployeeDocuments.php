<?php

namespace Src\Routes;

use Src\Controllers\EmployeeDocumentController;

class EmployeeDocuments
{
    static $list = [
        'path' => 'employee-documents',
        'list' => [
            [
                'path' => '$',
                'list' => [
                    [
                        'path' => 'open',
                        'method' => 'GET',
                        'controller' => EmployeeDocumentController::class,
                        'function' => 'open',
                        'middleware' => []
                    ]
                ]
            ],
        ]
    ];
}
