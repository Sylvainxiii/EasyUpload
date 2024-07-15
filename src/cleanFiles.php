<?php
require 'vendor/autoload.php';
include 'bddCrud.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$db = connexionBDD();

// Durée de vie des enregistrements en secondes (7 jours)
$duration = 60 * 60 * 24 * 7;
// Date limite de suppression des enregistrements
$expiration = time() - $duration;

// Convertir la date limite en format SQL
$expirationDate = date('Y-m-d H:i:s', $expiration);

// Requête pour supprimer les enregistrements expirés
$stmt = $db->prepare("DELETE FROM piece_jointe WHERE date_creation < :expirationDate");
$stmt->bindParam(':expirationDate', $expirationDate);
$stmt->execute();

echo "Les enregistrements ont été supprimés avec succès.";

$handle = fopen('log.txt', 'a+');
fwrite($handle, date('Y-m-d H:i:s') . " Les enregistrements ont été supprimés avec succès.\n");
fclose($handle);
