<?php
namespace Login;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/login[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => 'Login\Controller\Index',
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            'Login\Controller\Index' => Controller\Factory\IndexControllerFactory::class,
        ]
    ],
    'form_elements' => [
        'factories' => [
            'loginForm' => Form\Index\Factory\IndexFormFactory::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
