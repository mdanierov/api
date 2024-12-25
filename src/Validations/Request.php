<?php

namespace DMirzorasul\Api\Validations;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\Validator\Validation;

abstract class Request extends SymfonyRequest
{
    public abstract function rules(): array;

    /**
     * @throws \Exception
     */
    public function validate(): array
    {
        $violations = [];
        $validator  = Validation::createValidator();
        foreach ($this->rules() as $field => $validations) {
            $violations[] = $validator->validate($this->$field, $validations);
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
}