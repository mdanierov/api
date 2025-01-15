<?php

namespace DMirzorasul\Api\Controller;

use DMirzorasul\Api\Validations\Tasks\CreateTaskValidator;
use DMirzorasul\Api\Validations\Tasks\DeleteTaskValidator;
use DMirzorasul\Api\Validations\Tasks\UpdateTaskValidator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController
{
    public function __construct(
        private readonly Connection $connection,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function index(): Response
    {
        $tasks = $this->connection->fetchAllAssociative('SELECT * FROM `tasks`');

        return new JsonResponse($tasks);
    }

    /**
     * @throws Exception
     */
    public function store(CreateTaskValidator $validator): Response
    {
        $result = $this->connection->insert('tasks', $validator->validated());

        return new JsonResponse([
            'result' => $result,
        ]);
    }

    /**
     * @throws Exception
     */
    public function update(UpdateTaskValidator $validator): Response
    {
        $data = $validator->validated();
        // TODO: Dont allow update id field
        // unset($data['id']);
        $result = $this->connection->update('tasks', $data, ['id' => $validator->id]);

        return new JsonResponse([
            'result' => $result,
        ]);
    }

    /**
     * @throws Exception
     */
    public function delete(DeleteTaskValidator $deleteTaskValidator): Response
    {
        $result = $this->connection->delete('tasks', ['id' => $deleteTaskValidator->id]);

        return new JsonResponse([
            'result' => $result,
        ]);
    }
}