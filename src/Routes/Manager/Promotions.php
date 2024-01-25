<?php

namespace Src\Routes\Manager;

use Src\Controllers\PromotionController;
use Src\Middleware\UserIsManager;

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
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '',
                'method' => 'GET',
                'controller' => PromotionController::class,
                'function' => 'list',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => 'count',
                'method' => 'GET',
                'controller' => PromotionController::class,
                'function' => 'count',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'PUT',
                'controller' => PromotionController::class,
                'function' => 'update',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'GET',
                'controller' => PromotionController::class,
                'function' => 'getOne',
                'middleware' => [ UserIsManager::class ]
            ],
            [
                'path' => '$',
                'method' => 'DELETE',
                'controller' => PromotionController::class,
                'function' => 'delete',
                'middleware' => [ UserIsManager::class ]
            ],
        ]
    ];
}
