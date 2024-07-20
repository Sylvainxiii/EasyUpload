<?php

require 'log.php';
function connexionBDD(){
    try {
        $db = new PDO($_ENV['DB_CONNECTION'] . ':' . '../' . $_ENV['DB_DATABASE']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        setLog(1,'Connexion à la base de données');
    } catch (PDOException $e) {
        setLog(5,"Connection failed: " . $e->getMessage());
        //echo "Connection failed: " . $e->getMessage();
        exit;
    }
    return $db;
}

function insertPieceJointe($emetteur, $destinataire, $date, $repositoryPath)
{
    try {
        $db = connexionBDD();
        $stmt = $db->prepare("INSERT INTO piece_jointe (email_emmeteur, email_destinataire, date_creation, chemin) VALUES (:emetteur, :destinataire, :date_creation, :chemin)");
        $stmt->bindParam(':emetteur', $emetteur);
        $stmt->bindParam(':destinataire', $destinataire);
        $stmt->bindParam(':date_creation', $date);
        $stmt->bindParam(':chemin', $repositoryPath);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Upload failed: " . $e->getMessage();
        exit;
    }
}  

function deletePieceJointe(){
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

}


