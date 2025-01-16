<?php

use DMirzorasul\Api\Controller\StatusController;
use DMirzorasul\Api\Routing\Route;
use DMirzorasul\Api\Controller\TaskController;

Route::get('/', TaskController::class, 'index');
Route::get('/tasks', TaskController::class, 'index');
Route::post('/tasks/store', TaskController::class, 'store');
// TODO: Add params via route
Route::post('/tasks/update', TaskController::class, 'update');
// TODO: Add params via route
Route::post('/tasks/delete', TaskController::class, 'delete');

// TODO: Add grouping urls with default classes and methods
Route::get('/statuses', StatusController::class, 'index');
Route::post('/statuses/store', StatusController::class, 'store');
// TODO: Add params via route
Route::post('/statuses/update', StatusController::class, 'update');
// TODO: Add params via route
Route::post('/statuses/delete', StatusController::class, 'delete');