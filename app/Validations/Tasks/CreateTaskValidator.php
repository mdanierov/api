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
        ];
    }
}