<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

return [
    Connection::class => function () {
        // TODO: Add via ENV
        $connectionParams = [
            'path'   => __DIR__ . '/../../var/data.sqlite', // Path to the SQLite database file
            'driver' => 'pdo_sqlite',
        ];

        return DriverManager::getConnection($connectionParams);
    },
];