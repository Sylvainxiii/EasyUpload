<?php

require_once 'log.php';
include_once 'dotEnv.php';
dotEnv("../");
require_once '../vendor/autoload.php';
require_once 'EnvoieMail.php';

use App\Service\PHPMailService;

/**
 * Script de rappel J-1 avant suppression automatique des pièces jointes.
 * Logique : la suppression a lieu 7 jours après le dépôt.
 * Ce script repère les pièces jointes créées il y a exactement 6 jours au(x) destinataire(s).
 */

// ---------------------------------------------------------------
// PARAMÈTRES
// ---------------------------------------------------------------
$delais = 7;       // jours de conservation (doit correspondre au cron de suppression)
$unJour = 86400;   // secondes dans un jour
$now    = time();

$borneBasse = $now - ($delais * $unJour);              // créés avant J-7 : déjà supprimés
$borneHaute = $now - (($delais - 1) * $unJour);        // créés avant J-6 : supprimés demain

// ---------------------------------------------------------------
// CONNEXION BASE DE DONNÉES
// ---------------------------------------------------------------
try {
    $dbPath = __DIR__ . '/../' . $_ENV['DB_DATABASE'];
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    setLog("Connexion BDD échouée (rappel suppression) : " . $e->getMessage(), 'ERROR');
    exit(1);
}

// ---------------------------------------------------------------
// RECHERCHE DES PIÈCES JOINTES À J-1
// ---------------------------------------------------------------
setLog("Recherche des pièces jointes à J-1 de suppression", 'TRACE');

$stmt = $pdo->prepare(
    "SELECT * FROM piece_jointe WHERE date_creation > :basse AND date_creation <= :haute"
);
$stmt->execute(['basse' => $borneBasse, 'haute' => $borneHaute]);
$pieces = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($pieces)) {
    setLog("Aucune pièce jointe à J-1 de suppression aujourd'hui", 'TRACE');
    exit(0);
}

// ---------------------------------------------------------------
// ENVOI DES RAPPELS
// ---------------------------------------------------------------
foreach ($pieces as $piece) {
    envoyerRappelSuppression($piece);
}

// ---------------------------------------------------------------
// FONCTIONS
// ---------------------------------------------------------------

/**
 * Envoie un email de rappel au(x) destinataire(s)
 */
function envoyerRappelSuppression(array $piece): void
{
    $nomFichier   = basename($piece['chemin']);
    $downloadLink = $_ENV['WEB_URL'] . 'download/?file=' . $piece['chemin'];

    $tousLesEmails = array_unique(array_map('trim', explode(',', $piece['email_destinataire'])));

    $mail = emailSettings();

    foreach ($tousLesEmails as $email) {
        if (empty($email)) {
            continue;
        }
        try {
            $mail->addAddress($email, '');
            $mail->Subject = 'EasyUpload : Vos fichiers seront supprimés demain';
            $mail->Body    = templateRappelSuppression($email, $nomFichier, $downloadLink);

            if ($mail->send()) {
                setLog("Rappel J-1 envoyé à $email — fichier : $nomFichier (id={$piece['id']})", 'TRACE');
            }
            $mail->clearAllRecipients();
        } catch (Exception $e) {
            setLog("Erreur envoi rappel J-1 à $email (id={$piece['id']}) : " . $mail->ErrorInfo, 'ERROR');
            $mail->clearAllRecipients();
        }
    }
}

function getEmailStyles(): string
{
    return "
        .container {
            background-color: #292929;
            padding: 50px;
        }
        .box {
            max-width: 600px;
            border: 1px solid antiquewhite;
            border-radius: 5px;
            margin: 0 auto 20px auto;
            padding: 20px;
            overflow: hidden;
        }
        .logo {
            width: 100px;
            height: auto;
        }
        h2, p, pre, fieldset, legend {
            color: antiquewhite;
        }
        a {
            color: #83b4f3 !important;
        }
        tr, table, tbody {
            width: 100%;
        }
        .downloadButton {
            display: inline-block;
            text-align: center;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: #292929 !important;
            font-weight: bold;
            background-color: antiquewhite;
        }
        @media screen and (max-width: 600px) {
            .container { padding: 40px 20px; }
            .box       { padding: 20px 10px; }
            .logo      { width: 80px; }
            h2         { font-size: 1.2em; }
        }
    ";
}

/**
 * Génère le corps HTML de l'email de rappel J-1.
 */
function templateRappelSuppression(string $sendTo, string $nomFichier, string $downloadLink): string
{
    $styles = getEmailStyles();
    $link   = $_ENV['WEB_URL'];

    return <<<HTML
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <style>{$styles}</style>
    </head>
    <body>
        <div class="container">
            <div class="box">
                <table>
                    <tr>
                        <td align="right"><img src="https://i.goopics.net/kn2ydb.png" class="logo" alt="logo de EasyUpload"></td>
                        <td valign="bottom" align="left"><h2>Easy Upload</h2></td>
                    </tr>
                    <tr>
                        <td colspan="2"><h2>Bonjour {$sendTo},</h2></td>
                    </tr>
                    <tr>
                        <td colspan="2"><p>Le fichier <strong>{$nomFichier}</strong> sera automatiquement supprimé de nos serveurs <strong>demain</strong>.</p></td>
                    </tr>
                    <tr>
                        <td colspan="2"><p>Si vous souhaitez encore le récupérer, téléchargez-le dès aujourd'hui :</p></td>
                    </tr>
                    <tr>
                        <td colspan="2"><p style="text-align:center; margin: 20px 0;">
                            <a href="{$downloadLink}" class="downloadButton">Télécharger les documents</a>
                        </p></td>
                    </tr>
                    <tr>
                        <td colspan="2"><p>L'équipe EasyUpload.</p></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><a href="{$link}">Lien vers EasyUpload</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    </html>
    HTML;
}