<?php

use DI\Container;
use DMirzorasul\Api\App;
use Symfony\Component\HttpFoundation\JsonResponse;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/routes.php';

/** @var Container $container */
$container = require dirname(__DIR__) . '/config/bootstrap.php';

/** @var App $app */
$app = $container->get(App::class);

try {
    /** @var \Symfony\Component\HttpFoundation\Response $response */
    $response = $container->call([ $app, 'handle' ]);
} catch (\DMirzorasul\Api\Exceptions\ValidationException $exception) {
    $response = new JsonResponse($exception->getErrors(), $exception->status);
}

$response->send();