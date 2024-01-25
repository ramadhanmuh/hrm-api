<?php

namespace Src\Routes\Employee;

use Src\Controllers\PromotionController;
use Src\Middleware\UserIsEmployee;

class Promotions
{
    static $list = [
        'path' => 'promotions',
        'list' => [
            [
                'path' => '',
                'method' => 'POST',
                'controller' => PromotionController::class,
                'function' => 'create',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => PromotionController::class,
                'function' => 'list',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => PromotionController::class,
                'function' => 'count',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => PromotionController::class,
                'function' => 'update',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => PromotionController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsEmployee::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => PromotionController::class,
                'function' => 'delete',
                'middleware' => [ UserIsEmployee::class ]
            ],
        ]
    ];
}
