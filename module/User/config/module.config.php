<?php

declare(strict_types=1);

namespace User;

use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;
use User\Controller\AuthController;
use User\Controller\Factories\AuthControllerFactory;
use User\Controller\Factories\LoginControllerFactory;
use User\Controller\LoginController;

return [
    'router' => [
        'routes' => [
            'signup' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/signup',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action' => 'create',
                    ],
                ],
            ],
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => LoginController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],

    'controllers' =>[
        'factories' => [
            AuthController::class => AuthControllerFactory::class,
            LoginController::class => LoginControllerFactory::class,

        ],
    ],

    'view_manager'=> [
        'template_map' => [
            'Auth/create' => __DIR__ . '/../view/user/auth/create.phtml',
            'login/index'   => __DIR__ . '/../view/user/auth/login.phtml',
        ],
        'template_path_stack' =>[
            'user' => __DIR__ . '/../view'
        ]
    ]
];