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

