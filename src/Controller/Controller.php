<?php

namespace DMirzorasul\Api\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class Controller
{
    public function __construct(
        protected readonly Connection $connection,
        protected readonly ValidatorInterface $validator
    ) {
    }

    protected function responseJson(mixed $data, int $status = Response::HTTP_OK): Response
    {
        return new JsonResponse($data, $status);
    }
}