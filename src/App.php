<?php

namespace DMirzorasul\Api;

use DI\Container;
use DI\ContainerBuilder;
use DMirzorasul\Api\Routing\Routing;
use Doctrine\DBAL\Exception;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        if (null === $request) {
            $request = Request::createFromGlobals();
        }

        $this->setup($request);

        $response = $this->handle($request);
        $response->send();
    }

    /**
     * @throws \Exception
     */
    private function setup(Request $request): void
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/../config/di.php');

        $this->container = $builder->build();
        $this->container->set(Request::class, $request);
    }

    /**
     * @throws Exception
     * @throws \ReflectionException
     */
    private function handle(?Request $request): Response
    {
        $method = $request->getMethod();
        $path   = $request->getPathInfo();

        $matchedControllerInfo = $this->routing->getMatchedController($method, $path);
        if ($matchedControllerInfo) {
            $controllerClass = $matchedControllerInfo['class'];
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