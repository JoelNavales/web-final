<?php

declare(strict_types=1);

return [
    'default' => 'sqlite',

    'connections' => [
        'sqlite' => [
            'database' => __DIR__ . '/../storage/database.sqlite',
        ],

        'mysql' => [
            'host'     => '127.0.0.1',
            'port'     => 3306,
            'database' => 'task_manager',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8mb4',
        ],
    ],
];
