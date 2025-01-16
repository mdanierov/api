<?php

namespace DMirzorasul\Api\Controller;

use DMirzorasul\Api\Validations\Statuses\CreateStatusValidator;
use DMirzorasul\Api\Validations\Statuses\DeleteStatusValidator;
use DMirzorasul\Api\Validations\Statuses\UpdateStatusValidator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StatusController
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
        $tasks = $this->connection->fetchAllAssociative('SELECT * FROM `statuses`');

        return new JsonResponse($tasks);
    }

    /**
     * @throws Exception
     */
    public function store(CreateStatusValidator $validator): Response
    {
        $result = $this->connection->insert('statuses', $validator->validated());

        return new JsonResponse([
            'result' => $result,
        ]);
    }

    /**
     * @throws Exception
     */
    public function update(UpdateStatusValidator $validator): Response
    {
        $data = $validator->validated();
        // TODO: Dont allow update id field
        // unset($data['id']);
        $result = $this->connection->update('statuses', $data, ['id' => $validator->id]);

        return new JsonResponse([
            'result' => $result,
        ]);
    }

    /**
     * @throws Exception
     */
    public function delete(DeleteStatusValidator $validator): Response
    {
        $result = $this->connection->delete('statuses', ['id' => $validator->id]);

        return new JsonResponse([
            'result' => $result,
        ]);
    }
}