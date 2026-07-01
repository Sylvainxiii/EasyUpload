<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TurnstileService;
use App\Core\Request;
use App\Core\View;
use App\Core\Env;

class TurnstileController
{
    private $turnstileService;

    public function __construct(TurnstileService $service)
    {
        $this->turnstileService = $service;
    }

    public function page(Request $request): void
    {
        View::render('pages/TunrstilePage', [
            'title'       => Env::get('APP_NAME', 'EasyUpload'),
            'description' => 'Partage de fichiers simple et sécurisé.',
            'appName'     => Env::get('APP_NAME', 'EasyUpload'),
            'baseUrl'     => Env::get('APP_URL', ''),
            'method'      => $request->method(),
        ]);
    }

    public function challenge(Request $request)
    {
        header('Content-Type: application/json');

        $token = $_POST['cf-turnstile-response'] ?? '';
        $remoteip = $this->turnstileService->getClientIp();

        if ($this->turnstileService->validateToken($token, $remoteip)) {
            $this->turnstileService->setVerified();

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $redirectUrl = $_SESSION['requested_url'] ?? '/';
            unset($_SESSION['requested_url']);

            echo json_encode(['success' => true, 'redirect' => $redirectUrl]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid token']);
        }
    }
}
