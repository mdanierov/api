<?php

namespace DMirzorasul\Api\Validations\Task;

use DMirzorasul\Api\Validations\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskCreateRequest extends Request
{
    public string $title = '';

    public function rules(): array
    {
        return [
            'title' => [ new NotBlank() ],
        ];
    }
}