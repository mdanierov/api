<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

return [
    Connection::class => function () {
        $connection = DriverManager::getConnection([
            'path'   => __DIR__ . '/../database.sqlite', // Path to the SQLite database file
            'driver' => 'pdo_sqlite',
        ]);

        if (!file_exists(__DIR__ . '/../database.sqlite')) {
            throw new \Exception('Database not found');
        }

        // TODO: Implement via migrations
        $sql = "CREATE TABLE IF NOT EXISTS tasks (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT NOT NULL
                )";

        $connection->executeStatement($sql);

        return $connection;
    },

    ValidatorInterface::class => function () {
        return Validation::createValidator();
    },
];