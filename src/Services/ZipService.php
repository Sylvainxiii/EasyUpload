<?php

declare(strict_types=1);

namespace App\Services;

class ZipService
{
    public static function create(string $path, string $name): void
    {
        $zipPath = $path . '/' . $name . '.zip';

        $zip = new \ZipArchive();

        if ($zip->open($zipPath, \ZipArchive::CREATE) !== true) {
            throw new \Exception('Impossible de créer le zip');
        }

        foreach (glob($path . '/*') as $file) {
            if (!str_ends_with($file, '.zip')) {
                $zip->addFile($file, basename($file));
            }
        }

        $zip->close();
    }
}
