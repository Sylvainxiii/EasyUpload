<?php

include('src/fileZip.php');
include('src/envoieMail.php');

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// try {
//     $db = new PDO($_ENV['DB_CONNECTION'] . ':' . $_ENV['DB_DATABASE']);
//     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
//     exit;
// }

// // Sécuriser les données entrantes
// function securize($data)
// {
//     return htmlspecialchars(stripslashes(trim($data)));
// }

// // CREATE
// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'create') {
//     $emmeteur = securize($_POST['user_email']);
//     $destinataire = securize($_POST['recipient_email']);
//     $date = date("Y-m-d H:i:s");
//     $repositoryName = md5($_POST['recipient_email'].$_POST['user_email'].date("Y-m-d H:i:s"), false);
//     $repositoryPath = './uploads/' . $repositoryName;

//     $stmt = $db->prepare("INSERT INTO piece_jointe (email_emmeteur, email_destinataire, date_creation, chemin) VALUES (:emmeteur, :destinataire, :date_creation, :chemin)");
//     $stmt->bindParam(':emmeteur', $emmeteur);
//     $stmt->bindParam(':destinataire', $destinataire);
//     $stmt->bindParam(':date_creation', $date);
//     $stmt->bindParam(':chemin', $repositoryPath);

//     if ($stmt->execute()) {
//         mkdir($repositoryPath, 0777, true);
//         $tmpName = $_FILES['fichier']['tmp_name'];
//         $name = $_FILES['fichier']['name'];
//         for ($i = 0; $i < count($tmpName); $i++) {
//             if (!empty($tmpName[$i]) && is_uploaded_file($tmpName[$i])) {
//                 move_uploaded_file($tmpName[$i], $repositoryPath . "/" . $name[$i]);
//             }
//         }
//         $files = glob($repositoryPath . "/*");
//         createZip($repositoryPath, $repositoryName, $files);
//         envoieMail($destinataire, $emmeteur, $repositoryName);
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="background">
        <div class="title">
            <h1>CLONE</h1>
            <div class="backgroundText">
                <span class='active' >T</span>
                <span class='active' >R</span>
                <span class='active' >A</span>
                <span class='active' >N</span>
                <span class='active' >S</span>
                <span class='active' >F</span>
                <span class='active' >E</span>
                <span class='active' >R</span>
            </div>
        </div>
        <div class="form">
            <form id="uploadForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">
                <div class="mb-3">
                    <div class="custom-file">
                        <label class="custom-file-label" for="fichier" id="fileNameLabel">Choisir des fichiers</label>
                        <input type="file" class="custom-file-input" id="fichier" name="files[]" multiple required onchange='updateFileName()'>

                    </div>
                </div>
                <div class="mb-3">
                    <label for="recipient-email" class="form-label">Email destinataire</label>
                    <input type="email" class="form-control custom-input" id="recipient-email" name="recipient_email" required>
                </div>
                <div class="mb-3">
                    <label for="mail" class="form-label">Votre Email</label>
                    <input type="email" class="form-control custom-input" id="mail" name="user_email" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary"  name="submit" value="send">Send</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src='index.js'></script>
<script src='uploads.js'></script>
</html>