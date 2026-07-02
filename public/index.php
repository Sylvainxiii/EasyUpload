<?php

declare(strict_types=1);

define('PROJECT_ROOT', dirname(__DIR__));

use App\Core\Request;
use App\Core\Router;
use App\Services\TurnstileService;
use App\Middlewares\TurnstileMiddleware;
use Dotenv\Dotenv;

require_once PROJECT_ROOT . '/vendor/autoload.php';

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = PROJECT_ROOT . '/src/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require_once $file;
    }
});

$dotenv = Dotenv::createImmutable(PROJECT_ROOT);
$dotenv->load();

// Web-cron : doit tourner après dotenv (il a besoin de $_ENV['DB_DATABASE'])
require_once('../src/webcron.php');

$request = new Request();
$router = new Router();

require_once PROJECT_ROOT . '/src/Routes/TurnstileRoute.php';
require_once PROJECT_ROOT . '/src/Routes/legalRoute.php';

$router->get('/', [
    App\Controllers\HomeController::class,
    'index',
]);

$router->get('/download', [
    App\Controllers\DownloadController::class,
    'show',
]);

$router->get('/download/file', [
    App\Controllers\DownloadController::class,
    'file',
]);

$router->get('/login', [
    App\Controllers\AuthController::class,
    'loginPage',
]);

$router->post('/upload', [
    App\Controllers\UploadController::class,
    'store',
]);

$router->post('/login', [
    App\Controllers\AuthController::class,
    'login',
]);

$router->post('/logout', [
    App\Controllers\AuthController::class,
    'logout',
]);

$turnstileService = new TurnstileService();
$turnstileMiddleware = new TurnstileMiddleware($turnstileService);
$turnstileMiddleware->handle($request->uri());

$router->dispatch($request);
