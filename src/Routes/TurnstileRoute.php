<?php

declare(strict_types=1);

/** @var \App\Core\Router $router */

$router->get('/challenge', [
    App\Controllers\TurnstileController::class,
    'page',
]);

$router->post('/challenge', [
    App\Controllers\TurnstileController::class,
    'challenge',
]);
