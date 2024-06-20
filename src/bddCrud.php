<?php 

function insertBdd($emmeteur, $destinataire, $date, $repositoryPath){
    try {
        $db = new PDO($_ENV['DB_CONNECTION'] . ':' . '../' . $_ENV['DB_DATABASE']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("INSERT INTO piece_jointe (email_emmeteur, email_destinataire, date_creation, chemin) VALUES (:emmeteur, :destinataire, :date_creation, :chemin)");
        $stmt->bindParam(':emmeteur', $emmeteur);
        $stmt->bindParam(':destinataire', $destinataire);
        $stmt->bindParam(':date_creation', $date);
        $stmt->bindParam(':chemin', $repositoryPath);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}  


// // READ
// $stmt = $db->query("SELECT * FROM piece_jointe");
// $pieces_jointes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // UPDATE
// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'update') {
//     $id = securize($_POST['id']);
//     $emmeteur = securize($_POST['user_email']);
//     $destinataire = securize($_POST['recipient_email']);

//     $stmt = $db->prepare("UPDATE piece_jointe SET email_emmeteur = :emmeteur, email_destinataire = :destinataire WHERE id = :id");
//     $stmt->bindParam(':emmeteur', $emmeteur);
//     $stmt->bindParam(':destinataire', $destinataire);
//     $stmt->bindParam(':id', $id);

//     $stmt->execute();
// }

// // DELETE
// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
//     $id = securize($_POST['id']);

//     $stmt = $db->prepare("DELETE FROM piece_jointe WHERE id = :id");
//     $stmt->bindParam(':id', $id);

//     $stmt->execute();
// }