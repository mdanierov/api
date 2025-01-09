<?php

use DI\Container;
use DMirzorasul\Api\Env\Env;
use DMirzorasul\Api\Validations\AbstractValidator;
use Symfony\Component\HttpFoundation\Request;

return [
    Request::class => Request::createFromGlobals(),

    Env::class => function (Container $container) {
        $path = $container->get('kernel.project_dir') . '/.env';

        return new Env($path);
    },

    AbstractValidator::class => DI\factory(function (Container $container, $requestedName) {
        dd(1);
        return $requestedName::createFromGlobals();
    }),
];