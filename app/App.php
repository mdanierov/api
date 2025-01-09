<?php

namespace DMirzorasul\Api;

use DI\Container;
use DMirzorasul\Api\Routing\Route;
use Doctrine\DBAL\Exception;
use ReflectionMethod;
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
     * @throws Exception
     * @throws \ReflectionException
     */
    public function handle(Request $request): Response
    {
        $method = $request->getMethod();
        $path   = $request->getPathInfo();

        $matchedControllerInfo = Route::getMatchedController($method, $path);
        if ($matchedControllerInfo) {
            $controllerClass  = $matchedControllerInfo['class'];
            $controllerMethod = $matchedControllerInfo['method'];

            if (class_exists($controllerClass) && method_exists($controllerClass, $controllerMethod)) {
                $controller = $this->container->get($controllerClass);

                $reflection = new ReflectionMethod($controller, $controllerMethod);

                $params = array_map(
                    fn(\ReflectionParameter $parameter) => $this->container->get($parameter->getType()?->getName()),
                    $reflection->getParameters()
                );

                return $reflection->invokeArgs($controller, $params);
            }
        }

        return new JsonResponse('not found', 404);
    }
}