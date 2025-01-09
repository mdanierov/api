<?php

use DMirzorasul\Api\Routing\Route;
use DMirzorasul\Api\Controller\TaskController;

Route::get('/', TaskController::class, 'index');
Route::get('/tasks', TaskController::class, 'index');
Route::post('/tasks/store', TaskController::class, 'store');