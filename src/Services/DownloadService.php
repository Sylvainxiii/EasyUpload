<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Response;

class DownloadService
{
    public static function send(string $file): void
    {
        $file = urldecode($file);

        // validation sécurité (comme ton ancien code)
        if (!preg_match('/^[^.][-a-z0-9_.]*$/i', $file)) {
            Response::status(400);
            echo "Nom de fichier invalide";
            return;
        }

        $filepath = __DIR__ . '/../../storage/uploads/' . $file . '/' . $file . '.zip';

        if (!file_exists($filepath)) {
            Response::status(404);
            echo "Fichier non trouvé";
            return;
        }

        Response::download(
            $filepath,
            basename($filepath),
            'application/zip',
        );
    }
}
