<?php

namespace DMirzorasul\Api;

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
    public function __construct(
        private Routing $routing,
    ) {
    }

    /**
     * @throws Exception
     */
    public function run(?Request $request = null): void
    {
        if (null === $request) {
            $request = Request::createFromGlobals();
        }

        $response = $this->handle($request);
        $response->send();
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
                $controller = new $controllerClass($this->getConnection(), Validation::createValidator());

                return call_user_func([ $controller, $controllerMethod ], $request);
            }
        }

        return new JsonResponse('no found', 404);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    private function getConnection(): Connection
    {
        $connection = DriverManager::getConnection([
            'path'   => __DIR__ . '/../database.sqlite', // Path to the SQLite database file
            'driver' => 'pdo_sqlite',
        ]);

        if (!file_exists(__DIR__ . '/../database.sqlite')) {
                throw new \Exception('Database not found');
        }

        $this->createTables($connection);

        return $connection;
    }

    /**
     * @throws Exception
     */
    private function createTables(Connection $conn): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS tasks (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT NOT NULL
                )";

        $conn->executeStatement($sql);
    }
}