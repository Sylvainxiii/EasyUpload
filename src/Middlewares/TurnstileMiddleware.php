<?php

namespace App\Middlewares;

use App\Services\TurnstileService;

class TurnstileMiddleware
{
    private $turnstileService;

    public function __construct(TurnstileService $service)
    {
        $this->turnstileService = $service;
    }

    public function handle($uri)
    {
        if (
            !$this->turnstileService->isVerified()
            && $uri != '/challenge'
            && !str_starts_with($uri, '/.well-known/')
        ) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['requested_url'] = $uri;

            header('Location: /challenge');
        }
    }
}
