<?php

declare(strict_types=1);

namespace App\Services;

class UploadService
{
    public static function handle($request): array
    {
        $files = $_FILES['files'] ?? null;

        if (!$files) {
            throw new \Exception('Aucun fichier reçu');
        }

        $message = self::clean($_POST['messageEmailTextarea'] ?? '');
        $emetteur = self::clean($_POST['expediteurEmail'] ?? '');
        $destinataire = self::clean($_POST['destEmail'] ?? '');

        $date = date("Y-m-d H:i:s");

        $repoName = md5($emetteur . $destinataire . $date);
        $repoPath = __DIR__ . '/../../storage/uploads/' . $repoName;

        mkdir($repoPath, 0777, true);

        $errors = [];

        $count = count($files['tmp_name']);

        for ($i = 0; $i < $count; $i++) {

            $tmp = $files['tmp_name'][$i];
            $name = $files['name'][$i];
            $size = $files['size'][$i];

            if (!$tmp || !is_uploaded_file($tmp)) {
                continue;
            }

            if ($size > 536870912) {
                $errors[] = "Fichier trop lourd: $name";
                continue;
            }

            move_uploaded_file($tmp, $repoPath . "/" . $name);
        }

        if (!empty($errors)) {
            throw new \Exception(json_encode($errors));
        }

        ZipService::create($repoPath, $repoName);

        MailService::send(
            $destinataire,
            $emetteur,
            $repoName,
            $message,
        );

        return [
            'repository' => $repoName,
            'path' => $repoPath,
        ];
    }

    private static function clean(string $data): string
    {
        return htmlspecialchars(trim($data));
    }
}
