<?php

namespace DMirzorasul\Api;

use DI\Container;
use DI\ContainerBuilder;
use DMirzorasul\Api\Routing\Routing;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

readonly class App
{
    private ?Container $container;

    public function __construct(
        private Routing $routing,
    ) {
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function run(?Request $request = null): void
    {
        $this->setup();

        if (null === $request) {
            $request = Request::createFromGlobals();
        }

        $response = $this->handle($request);
        $response->send();
    }

    /**
     * @throws \Exception
     */
    private function setup(): void
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/../config/di.php');

        $this->container = $builder->build();
    }

    /**
     * @throws Exception
     */
    private function handle(?Request $request): Response
    {
        $method = $request->getMethod();
        $path   = $request->getPathInfo();

        $matchedControllerInfo = $this->routing->getMatchedController($method, $path);
        if ($matchedControllerInfo) {
            $controllerClass  = $matchedControllerInfo['class'];
            $controllerMethod = $matchedControllerInfo['method'];

            // Controller dynamisch erstellen
            if (class_exists($controllerClass) && method_exists($controllerClass, $controllerMethod)) {
                $controller = $this->container->get($controllerClass);
                return call_user_func([ $controller, $controllerMethod ], $request);
            }
        }

        return new JsonResponse('no found', 404);
    }
}