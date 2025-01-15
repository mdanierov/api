<?php

namespace DMirzorasul\Api\Validations\Tasks;

use DMirzorasul\Api\Validations\AbstractValidator;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeleteTaskValidator extends AbstractValidator
{
    public $id;

    public function rules(): array
    {
        return [
            'id' => [
                // TODO: Add Constraint to check id on the table.
                new NotBlank(),
            ],
        ];
    }
}