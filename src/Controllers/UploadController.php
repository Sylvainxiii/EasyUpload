<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\UploadService;

class UploadController
{
    public function store(Request $request): void
    {
        try {
            $result = UploadService::handle($request);

            Response::json([
                'success' => true,
                'data' => $result,
            ]);

        } catch (\Throwable $e) {

            Response::status(500);

            Response::json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
