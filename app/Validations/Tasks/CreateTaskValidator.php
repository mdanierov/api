<?php

namespace DMirzorasul\Api\Validations\Tasks;

use DMirzorasul\Api\Validations\AbstractValidator;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateTaskValidator extends AbstractValidator
{
    public function rules(): array
    {
        return [
            'title' => [
                new NotBlank(),
            ],
            'status_id' => [
                // TODO: Define default value if param is not given.
                new NotBlank(),
            ],
            'due_date' => [],
            'priority' => [],
            'assigned_user_id' => [],
        ];
    }
}