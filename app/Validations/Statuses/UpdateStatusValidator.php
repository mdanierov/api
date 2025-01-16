<?php

namespace DMirzorasul\Api\Validations\Statuses;

use DMirzorasul\Api\Validations\AbstractValidator;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateStatusValidator extends AbstractValidator
{
    public $id;

    public function rules(): array
    {
        return [
            'id' => [
                new NotBlank(),
            ],
            'name' => [
                new NotBlank(),
            ],
            'priority' => [
                // TODO: Custom Constraint or function by adding or checking this type of fields
            ]
        ];
    }
}