<?php

use DMirzorasul\Api\Controller\TaskController;
use DMirzorasul\Api\Routing\Routing;

$routing = new Routing();

$routing->get('/tasks', TaskController::class, 'index');
$routing->post('/tasks/store', TaskController::class, 'store');
$routing->post('/tasks/update', TaskController::class, 'update');
$routing->post('/tasks/delete', TaskController::class, 'delete');

return $routing;