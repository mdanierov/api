<?php

namespace DMirzorasul\Api\Controller;

use DMirzorasul\Api\Validations\Tasks\CreateTaskValidator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    /**
     * @throws Exception
     */
    public function index(): Response
    {
        $tasks = $this->connection->fetchAllAssociative('SELECT * FROM `tasks`');

        return new JsonResponse($tasks);
    }

    public function store(CreateTaskValidator $validator): Response
    {
        return new JsonResponse($validator->validated());
    }
}