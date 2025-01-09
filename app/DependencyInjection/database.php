<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

return [
    Connection::class => function () {
        /**
         * $connectionParams = [
         * 'url' => str_replace(
         * '%kernel.project_dir%',
         * $container->get('kernel.project_dir'),
         * $env->getString('DATABASE_URL')
         * ), // Korrektes URL-Schema
         * ];
         */

        // TODO: Add via ENV
        $connectionParams = [
            'path'   => __DIR__ . '/../../var/data.sqlite', // Path to the SQLite database file
            'driver' => 'pdo_sqlite',
        ];

        return DriverManager::getConnection($connectionParams);
    },
];