<?php

namespace DMirzorasul\Api\Validations;

use DMirzorasul\Api\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

abstract class AbstractValidator extends Request
{
    /**
     * @throws \Exception
     */
    public function validate(): array
    {
        $violations = [];
        $validator  = Validation::createValidator();

        foreach ($this->rules() as $field => $validations) {
            $violations[$field] = $validator->validate($this->$field, $validations);
        }

        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }

        return $violations;
    }

    public static function createFromGlobals(): static
    {
        $request = parent::createFromGlobals();

        foreach ($request->rules() as $field => $validation) {
            $request->$field = $request->getPayload()->get($field);
        }

        return $request;
    }

    public abstract function rules(): array;
}