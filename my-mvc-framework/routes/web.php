<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\TaskController;
use snap\Http\Router;

return static function (Router $router): void {
    $router->register('GET',  '/',                   [HomeController::class, 'index']);
    $router->register('GET',  '/tasks',              [TaskController::class, 'index']);
    $router->register('GET',  '/tasks/create',       [TaskController::class, 'create']);
    $router->register('POST', '/tasks',              [TaskController::class, 'store']);
    $router->register('GET',  '/tasks/{id}',         [TaskController::class, 'show']);
    $router->register('GET',  '/tasks/{id}/edit',    [TaskController::class, 'edit']);
    $router->register('POST', '/tasks/{id}/update',  [TaskController::class, 'update']);
    $router->register('POST', '/tasks/{id}/delete',  [TaskController::class, 'destroy']);
};
