<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    public static function status(int $code): void
    {
        http_response_code($code);
    }

    public static function redirect(string $url, int $status = 302): never
    {
        http_response_code($status);
        header('Location: ' . $url);
        exit;
    }

    public static function json(array $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        );

        exit;
    }

    public static function download(
        string $filepath,
        ?string $filename = null,
        string $contentType = 'application/octet-stream',
    ): never {
        if (!is_file($filepath)) {
            self::status(404);
            exit('File not found.');
        }

        $filename ??= basename($filepath);

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filepath));
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: 0');

        readfile($filepath);
        exit;
    }

    public static function text(string $content, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: text/plain; charset=utf-8');

        echo $content;
        exit;
    }
}
