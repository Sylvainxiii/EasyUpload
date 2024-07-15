<?php

function connexionBDD(){
    try {
        $db = new PDO($_ENV['DB_CONNECTION'] . ':' . '../' . $_ENV['DB_DATABASE']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
    return $db;
}

function insertPieceJointe($emmeteur, $destinataire, $date, $repositoryPath)
{
    try {
        $db = connexionBDD();
        $stmt = $db->prepare("INSERT INTO piece_jointe (email_emmeteur, email_destinataire, date_creation, chemin) VALUES (:emmeteur, :destinataire, :date_creation, :chemin)");
        $stmt->bindParam(':emmeteur', $emmeteur);
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


