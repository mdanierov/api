<?php

namespace DMirzorasul\Api;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use DMirzorasul\Api\Routing\Route;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class App
{
    public function __construct(
        private ?Container $container
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws \ReflectionException
     * @throws DependencyException
     */
    public function handle(Request $request): Response
    {
        $method = $request->getMethod();
        $path   = $request->getPathInfo();

        $matchedControllerInfo = Route::getMatchedController($method, $path);
        if (!$matchedControllerInfo) {
            // TODO: Add Exception.
            return new JsonResponse('not found', 404);
        }

        $controllerClass  = $matchedControllerInfo['class'];
        $controllerMethod = $matchedControllerInfo['method'];

        if (!class_exists($controllerClass)) {
            // TODO: Add Exception
        }

        if (!method_exists($controllerClass, $controllerMethod)) {
            // TODO: Add Exception
        }

        try {
            $controller = $this->container->get($controllerClass);
        } catch (Exception $exception) {
            // TODO: Add Exception.
            dd($exception);
        }

        try {
            $response = $this->container->call([ $controller, $controllerMethod ]);
        } catch (Exception $exception) {
            // TODO: Add Exception.
            dd($exception);
        }

        return $response;
    }
}