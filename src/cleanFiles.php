<?php
try {
    $db = new PDO('sqlite:bdd.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

    echo "Les enregistrements expirés ont été supprimés avec succès.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
