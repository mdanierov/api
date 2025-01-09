<?php

use DI\Container;
use DMirzorasul\Api\Env\Env;
use Symfony\Component\HttpFoundation\Request;

return [
    Request::class => Request::createFromGlobals(),

    Env::class => function (Container $container) {
        // TODO: Use const for kernel.project_dir and for .env
        $path = $container->get('kernel.project_dir') . '/' . '.env';

        return new Env($path);
    },
];