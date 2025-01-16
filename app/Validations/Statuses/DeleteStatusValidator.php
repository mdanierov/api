<?php

namespace DMirzorasul\Api\Validations\Statuses;

use DMirzorasul\Api\Validations\AbstractValidator;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeleteStatusValidator extends AbstractValidator
{
    public $id;

    public function rules(): array
    {
        return [
            'id' => [
                new NotBlank(),
            ],
        ];
    }
}