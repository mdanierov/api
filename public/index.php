<?php

use DMirzorasul\Api\App;

require __DIR__ . '/../vendor/autoload.php';

$routing = require './config/routes.php';

$app = new App($routing);
try {
    $app->run();
} catch (Exception $exception) {
    var_dump($exception->getMessage());
    die();
}

exit();