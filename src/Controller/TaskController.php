<?php

namespace DMirzorasul\Api\Controller;

use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationInterface;

class TaskController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Response
    {
        $tasks = $this->connection->fetchAllAssociative('SELECT * FROM `tasks`');

        return $this->responseJson($tasks);
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {

        $title = $request->request->get('title');

        $violations = $this->validator->validate($title, [
            new NotBlank(),
        ]);

        if ($violations->count() > 0) {
            $messages = array_map(fn(ConstraintViolationInterface $violation) => $violation->getMessage(),
                iterator_to_array($violations));

            return new JsonResponse($messages, Response::HTTP_BAD_REQUEST);
        }

        $sql = "INSERT INTO `tasks` (`title`) VALUES (?);";

        $this->connection->executeStatement($sql, [
            $title,
        ]);

        return new JsonResponse([
            'message' => 'task created',
        ]);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request): JsonResponse
    {
        $data = [];

        $data['title'] = $request->request->get('title');
        $data['id']    = $request->request->get('id');

        $errors = [];
        foreach ($data as $key => $value) {
            $violations = $this->validator->validate($value, [
                new NotBlank(),
            ]);

             $messages = array_map(fn(ConstraintViolationInterface $violation) => $violation->getMessage(),
                iterator_to_array($violations));

             if (count($messages) > 0) {
                 $errors[$key] = $violations;
             }
        }

        if (count($errors) > 0) {
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
        }

        $sql = 'UPDATE `tasks` SET `title` = ? WHERE `id` = ?';

        $isSuccessfully = (bool) $this->connection->executeStatement($sql, [
            $data['title'],
            $data['id']
        ]);

        return new JsonResponse([
            'successfully' => $isSuccessfully
        ]);
    }

    /**
     * @throws Exception
     */
    public function delete(Request $request): JsonResponse {
        $id = $request->request->get('id');

        $violations = $this->validator->validate($id, [
            new NotBlank(),
        ]);

        if ($violations->count() > 0) {
            $messages = array_map(fn(ConstraintViolationInterface $violation) => $violation->getMessage(),
                iterator_to_array($violations));

            return new JsonResponse($messages, Response::HTTP_BAD_REQUEST);
        }

        $sql = 'DELETE FROM `tasks` WHERE `id` = ?';

        $isSuccessfully = (bool) $this->connection->executeStatement($sql, [
            $id
        ]);

        return new JsonResponse([
            'successfully' => $isSuccessfully
        ]);
    }
}