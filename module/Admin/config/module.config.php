<?php
namespace Admin;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/admin[/:controller][/:action][/:id][-:propertyId]',
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
            'account' => Controller\Factory\AccountControllerFactory::class,
            'category' => Controller\Factory\CategoryControllerFactory::class,
            'comparison-tool' => Controller\Factory\ComparisonToolControllerFactory::class,
            'feed' => Controller\Factory\FeedControllerFactory::class,
            'bolt' => Controller\Factory\BoltControllerFactory::class,
            'product' => Controller\Factory\ProductControllerFactory::class,
            'promotioncode' => Controller\Factory\PromotioncodeControllerFactory::class,
            'todo' => Controller\Factory\TodoControllerFactory::class
        ],
        'invokables' => [
            'Admin\Controller\Index' => Controller\IndexController::class
        ]
    ],
    'form_elements' => [
        'factories' => [
            'accommodationFieldset' => Form\Product\Factory\AccommodationFieldsetFactory::class,
            'accountForm' => Form\Account\Factory\AccountFormFactory::class,
            'categoryForm' => Form\Category\Factory\CategoryFormFactory::class,
            'comparisonToolForm' => Form\ComparisonTool\Factory\ComparisonToolFormFactory::class,
            'feedFieldset' => Form\Product\Factory\FeedFieldsetFactory::class,
            'feedForm' => Form\Feed\Factory\FeedFormFactory::class,
            'linkForm' => Form\Feed\Factory\LinkFormFactory::class,
            'boltForm' => Form\Bolt\Factory\BoltFormFactory::class,
            'boltSizeFieldset' => Form\Bolt\Factory\BoltSizeFieldsetFactory::class,
            'productFilter' => Filter\Product\Factory\ProductFilterFactory::class,
            'productForm' => Form\Product\Factory\ProductFormFactory::class,
            'propertyFieldset' => Form\Product\Factory\PropertyFieldsetFactory::class,
            'workItemForm' => Form\WorkItem\Factory\WorkItemFormFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
