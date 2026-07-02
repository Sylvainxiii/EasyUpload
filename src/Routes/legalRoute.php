<?php

use App\Controllers\LegalController;

/** @var \App\Core\Router $router */

$router->get('/mentions-legales', [App\Controllers\LegalController::class, 'legal']);
$router->get('/confidentialite', [App\Controllers\LegalController::class, 'privacy']);
$router->get('/cgu', [App\Controllers\LegalController::class, 'cgu']);
// $router->get('/cgv', [$legalController, 'cgv']);
