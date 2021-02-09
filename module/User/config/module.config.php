<?php

declare(strict_types=1);

namespace User;

use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;
use User\Controller\AuthController;
use User\Controller\Factories\AuthControllerFactory;

return [
    'router' => [
        'routes' => [
            'signup' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/signup',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action' => 'create'
                    ],
                ],
            ],
        ],
    ],

    'controllers' =>[
        'factories' => [
            AuthController::class => AuthControllerFactory::class,
        ],
    ],

    'view_manager'=> [
        'template_map' => [
            'Auth/create' => __DIR__ . '/../view/user/auth/create.phtml',
        ],
        'template_path_stack' =>[
            'user' => __DIR__ . '/../view'
        ]
    ]
];