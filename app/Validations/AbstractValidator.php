<?php

namespace DMirzorasul\Api\Validations;

use DMirzorasul\Api\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

abstract class AbstractValidator extends Request
{
    private bool $isValidated = false;

    /**
     * @throws \Exception
     */
    public function validate(): void
    {
        $violations = [];
        $validator  = Validation::createValidator();

        foreach ($this->rules() as $field => $validations) {
            $errors = $validator->validate($this->$field, $validations);
            if ($errors->count() > 0) {
                $violations[$field] = $errors;
            }
        }

        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }

        $this->isValidated = true;
    }

    public function validated(): array
    {
        if (!$this->isValidated) {
            return [];
        }

        $values = [];
        foreach ($this->rules() as $field => $validations) {
            $values[$field] = $this->$field;
        }

        return $values;
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