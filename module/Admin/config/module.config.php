<?php
namespace Admin;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/admin[/:controller][/:action][/:id]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            'category' => 'Admin\Controller\Factory\CategoryControllerFactory',
            'feed' => Controller\Factory\FeedControllerFactory::class,
            'bolt' => Controller\Factory\BoltControllerFactory::class,
            'product' => Controller\Factory\ProductControllerFactory::class
        ],
        'invokables' => [
            'Admin\Controller\Index' => Controller\IndexController::class
        ]
    ],
    'form_elements' => [
        'factories' => [
            'categoryForm' => Form\Category\Factory\CategoryFormFactory::class,
            'feedForm' => Form\Feed\Factory\FeedFormFactory::class,
            'boltForm' => Form\Bolt\Factory\BoltFormFactory::class,
            'boltSizeFieldset' => Form\Bolt\Factory\BoltSizeFieldsetFactory::class,
            'productForm' => Form\Product\Factory\ProductFormFactory::class,
            'propertyFieldset' => Form\Product\Factory\PropertyFieldsetFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
