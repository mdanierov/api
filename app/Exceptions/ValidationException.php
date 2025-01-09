<?php

namespace DMirzorasul\Api\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends Exception
{
    public array $violations = [];

    public int   $status     = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct(array $violations, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->violations = $violations;
    }

    public function getErrors(): array
    {
        $errors = [];
        /** @var ConstraintViolationListInterface $value*/
        foreach ($this->violations as $key => $list) {
            $errors[$key] = array_map(fn(ConstraintViolationInterface $value) => $value->getMessage(), iterator_to_array($list));
        }

        return $errors;
    }
}