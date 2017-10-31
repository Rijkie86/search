<?php
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => 'ZcAeFR0ee0adysfigar0',
                    'dbname' => 'productsearch'
                ]
            ]
        ]
    ],
    'view_manager' => [
        'display_exceptions' => true
    ]
];

