<?php

declare(strict_types=1);

namespace App\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailService
{
    public static function send(
        string $sendTo,
        string $sendFrom,
        string $downloadFile,
        string $messagePerso = '',
    ): void {
        $recipients = self::parseRecipients($sendTo);

        $countFail = 0;

        foreach ($recipients as $recipient) {
            try {
                $mail = self::mailer();

                $mail->addAddress($recipient);
                $mail->Subject = 'EasyUpload: Réception de fichiers';
                $mail->Body = self::destTemplate(
                    $recipient,
                    $sendFrom,
                    $downloadFile,
                    $messagePerso,
                );

                $mail->send();

            } catch (\Throwable $e) {
                $countFail++;
            }
        }

        self::sendSenderReport(
            $sendFrom,
            $sendTo,
            $countFail,
            count($recipients),
        );
    }

    private static function sendSenderReport(
        string $sender,
        string $recipients,
        int $fails,
        int $total,
    ): void {
        try {
            $mail = self::mailer();

            $mail->addAddress($sender);

            if ($fails === 0) {
                $subject = 'Vos fichiers ont été correctement transférés';
                $success = true;
            } elseif ($fails === $total) {
                $subject = 'Vos fichiers n’ont pas pu être transférés';
                $success = false;
            } else {
                $subject = 'Vos fichiers ont été partiellement transférés';
                $success = false;
            }

            $mail->Subject = $subject;
            $mail->Body = self::senderTemplate(
                $sender,
                $recipients,
                $success,
            );

            $mail->send();

        } catch (\Throwable $e) {
            // volontairement silencieux
            // throw $e;
        }
    }

    private static function mailer(): PHPMailer
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'] ?? 'localhost';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'] ?? '';
        $mail->Password = $_ENV['MAIL_PASSWORD'] ?? '';
        $mail->Port = (int) ($_ENV['MAIL_PORT'] ?? 587);

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);

        $mail->setFrom(
            $_ENV['MAIL_FROM'] ?? $mail->Username,
            $_ENV['MAIL_FROM_NAME'] ?? 'EasyUpload',
        );

        $mail->setLanguage(
            'fr',
            dirname(__DIR__, 2) . '/vendor/phpmailer/phpmailer/language/',
        );

        // debugmode
        if ($_ENV['ENVIRONMENT'] == "DEV" || $_ENV['ENVIRONMENT'] == "DEBUG") {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        }

        return $mail;
    }

    private static function parseRecipients(string $emails): array
    {
        $items = array_map('trim', explode(',', $emails));

        return array_values(
            array_filter($items, static fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL)),
        );
    }

    private static function destTemplate(
        string $recipient,
        string $sender,
        string $downloadFile,
        string $messagePerso,
    ): string {
        $baseUrl = rtrim($_ENV['WEB_URL'] ?? '', '/');
        $downloadLink = $baseUrl . '/download?file=' . urlencode($downloadFile);

        $messageBlock = '';

        if ($messagePerso !== '') {
            $safe = nl2br(htmlspecialchars($messagePerso));

            $messageBlock = "
                <hr>
                <p><strong>Message de {$sender}</strong></p>
                <p>{$safe}</p>
            ";
        }

        return "
        <html>
        <body style='font-family:Arial,sans-serif'>
            <h2>Bonjour {$recipient},</h2>

            <p>{$sender} souhaite vous transmettre des documents.</p>

            <p>
                <a href='{$downloadLink}'>
                    Télécharger les documents
                </a>
            </p>

            <p>Le lien est valable 7 jours.</p>

            {$messageBlock}

            <p>L'équipe EasyUpload</p>
        </body>
        </html>
        ";
    }

    private static function senderTemplate(
        string $sender,
        string $recipients,
        bool $success,
    ): string {
        $safeRecipients = nl2br(htmlspecialchars($recipients));

        $message = $success
            ? "Vos fichiers ont bien été envoyés à :"
            : "Un problème est survenu lors de l'envoi vers :";

        return "
        <html>
        <body style='font-family:Arial,sans-serif'>
            <h2>Bonjour {$sender},</h2>

            <p>{$message}</p>

            <p>{$safeRecipients}</p>

            <p>Merci d'avoir utilisé EasyUpload.</p>
        </body>
        </html>
        ";
    }
}
