<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Core\Response;
use App\Services\DownloadService;

class DownloadController
{
    public function show(Request $request): void
    {
        $file = $request->query('file');

        if (!$file) {
            View::render('pages/download', [
                'error' => 'Aucun fichier spécifié',
            ]);
            return;
        }

        View::render('pages/download', [
            'file' => $file,
        ]);
    }

    public function file(Request $request): void
    {
        $file = $request->query('file');

        if (!$file) {
            Response::status(400);
            echo 'Paramètre manquant';
            return;
        }

        DownloadService::send($file);
    }
}
