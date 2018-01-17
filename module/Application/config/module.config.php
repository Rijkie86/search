<?php
namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
return array(
    'doctrine' => [
        'authentication' => [
            'orm_default' => [
                'object_manager' => \Doctrine\ORM\EntityManager::class,
                'identity_class' => \Application\Entity\User::class,
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function (\Application\Entity\User $user, $password) {
                    return password_verify($password, $user->getPassword());
                }
            ]
        ],
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Dashboard',
                'route' => 'home'
            ],
            [
                'label' => 'Feed',
                'route' => 'admin',
                'controller' => 'feed',
                'pages' => [
                    [
                        'label' => 'Overview',
                        'route' => 'admin',
                        'controller' => 'feed',
                        'action' => 'index'
                    ],
                    [
                        'label' => 'New',
                        'route' => 'admin',
                        'controller' => 'feed',
                        'action' => 'create'
                    ]
                ]
            ],
            [
                'label' => 'Category',
                'route' => 'admin',
                'controller' => 'category',
                'pages' => [
                    [
                        'label' => 'Overview',
                        'route' => 'admin',
                        'controller' => 'category',
                        'action' => 'index'
                    ],
                    [
                        'label' => 'New',
                        'route' => 'admin',
                        'controller' => 'category',
                        'action' => 'create'
                    ],
                    [
                        'label' => 'Matchen',
                        'route' => 'admin',
                        'controller' => 'category',
                        'action' => 'match'
                    ]
                ]
            ],
            [
                'label' => 'Object',
                'route' => 'admin',
                'pages' => [
                    [
                        'label' => 'Bolts',
                        'route' => 'admin',
                        'pages' => [
                            [
                                'label' => 'Overview',
                                'route' => 'admin',
                                'controller' => 'bolt',
                                'action' => 'index'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'label' => 'Promotion code',
                'route' => 'admin',
                'controller' => 'promotioncode',
                'pages' => [
                    [
                        'label' => 'Overview',
                        'route' => 'admin',
                        'controller' => 'promotioncode',
                        'action' => 'index'
                    ],
                    [
                        'label' => 'Create',
                        'route' => 'admin',
                        'controller' => 'promotioncode',
                        'action' => 'create'
                    ]
                ]
            ],
            [
                'label' => 'Product',
                'route' => 'admin',
                'controller' => 'product',
                'pages' => [
                    [
                        'label' => 'Overview',
                        'route' => 'admin',
                        'controller' => 'product',
                        'action' => 'index'
                    ],
                    [
                        'label' => 'New',
                        'route' => 'admin',
                        'controller' => 'product',
                        'action' => 'create'
                    ]
                ]
            ],
            [
                'label' => 'Account',
                'route' => 'admin',
                'controller' => 'account',
                'pages' => [
                    [
                        'label' => 'Overview',
                        'route' => 'admin',
                        'controller' => 'account',
                        'action' => 'index'
                    ],
                    [
                        'label' => 'New',
                        'route' => 'admin',
                        'controller' => 'account',
                        'action' => 'create'
                    ]
                ]
            ],
            [
                'label' => 'To Do List',
                'route' => 'admin',
                'controller' => 'todo',
                'pages' => [
                    [
                        'label' => 'Overview',
                        'route' => 'admin',
                        'controller' => 'todo',
                        'action' => 'index'
                    ],
                    [
                        'label' => 'New',
                        'route' => 'admin',
                        'controller' => 'todo',
                        'action' => 'create'
                    ]
                ]
            ],
            [
                'label' => 'Website',
                'route' => 'home'
            ]
        ]
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => 'index',
                        'action' => 'index'
                    ]
                ]
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => 'index',
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'index' => array(
                    'options' => array(
                        'route' => 'index',
                        'defaults' => array(
                            'controller' => 'console',
                            'action' => 'index'
                        )
                    )
                ),
                'promotioncode' => array(
                    'options' => array(
                        'route' => 'promotioncode',
                        'defaults' => array(
                            'controller' => 'console',
                            'action' => 'promotioncode'
                        )
                    )
                ),
                'elasticsearch' => array(
                    'options' => array(
                        'route' => 'elasticsearch',
                        'defaults' => array(
                            'controller' => 'console',
                            'action' => 'elasticsearch'
                        )
                    )
                ),
                'feed-list' => array(
                    'options' => array(
                        'route' => 'feed-list',
                        'defaults' => array(
                            'controller' => 'console',
                            'action' => 'feed-list'
                        )
                    )
                ),
                'update-feed-list' => array(
                    'options' => array(
                        'route' => 'update-feed-list',
                        'defaults' => array(
                            'controller' => 'console',
                            'action' => 'update-feed-list'
                        )
                    )
                ),
                'insert-products' => array(
                    'options' => array(
                        'route' => 'insert-products [<programId>]',
                        'defaults' => array(
                            'controller' => 'console',
                            'action' => 'insert-products'
                        )
                    )
                ),
                'delete' => array(
                    'options' => array(
                        'route' => 'delete [<programId>]',
                        'defaults' => array(
                            'controller' => 'console',
                            'action' => 'delete'
                        )
                    )
                )
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            'index' => Controller\Factory\IndexControllerFactory::class,
            'console' => Controller\Factory\ConsoleControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            'navigation' => \Zend\Navigation\Service\DefaultNavigationFactory::class,
            
            'authorize' => Permissions\AuthorizeFactory::class,
            'accountService' => Service\Factory\AccountServiceFactory::class,
            'boltService' => Service\Factory\BoltServiceFactory::class,
            'brandService' => Service\Factory\BrandServiceFactory::class,
            'categoryService' => Service\Factory\CategoryServiceFactory::class,
            'elasticsearchService' => Service\Factory\ElasticsearchServiceFactory::class,
            'feedService' => Service\Factory\FeedServiceFactory::class,
            'feedCategoryValueService' => Service\Factory\FeedCategoryValueServiceFactory::class,
            'productService' => Service\Factory\ProductServiceFactory::class,
            'propertyService' => Service\Factory\PropertyServiceFactory::class,
            'todoService' => Service\Factory\TodoServiceFactory::class,
            'websiteService' => Service\Factory\WebsiteServiceFactory::class
        ]
    ],
    'view_helpers' => [
        'factories' => [
            'isAllowed' => View\Helper\Factory\IsAllowedFactory::class
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/new',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            // 'layout/layout' => __DIR__ . '/../view/layout/shop.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml'
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
);
