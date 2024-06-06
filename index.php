<?php
include('src/FileZip.php');

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $db = new PDO($_ENV['DB_CONNECTION'] . ':' . $_ENV['DB_DATABASE']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Sécuriser les données entrantes
function securize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// CREATE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'create') {
    $emmeteur = securize($_POST['user_email']);
    $destinataire = securize($_POST['recipient_email']);
    $date = date("Y-m-d H:i:s");
    $repositoryName = md5($_POST['recipient_email'].$_POST['user_email'].date("Y-m-d H:i:s"), false);
    $repositoryPath = './uploads/' . $repositoryName;

    $stmt = $db->prepare("INSERT INTO piece_jointe (email_emmeteur, email_destinataire, date_creation, chemin) VALUES (:emmeteur, :destinataire, :date_creation, :chemin)");
    $stmt->bindParam(':emmeteur', $emmeteur);
    $stmt->bindParam(':destinataire', $destinataire);
    $stmt->bindParam(':date_creation', $date);
    $stmt->bindParam(':chemin', $repositoryPath);

    if ($stmt->execute()) {
        mkdir($repositoryPath, 0777, true);
        $tmpName = $_FILES['fichier']['tmp_name'];
        $name = $_FILES['fichier']['name'];
        for ($i = 0; $i < count($tmpName); $i++) {
            if (!empty($tmpName[$i]) && is_uploaded_file($tmpName[$i])) {
                move_uploaded_file($tmpName[$i], $repositoryPath . "/" . $name[$i]);
            }
        }
        $files = glob($repositoryPath . "/*");
        createZip($repositoryPath, $repositoryName, $files);
        header("Location: src/EnvoieMail.php?recipient_email=" . $_POST['recipient_email']."&user_email=".$_POST['user_email'].'&file='.$repositoryName);
    }
}

// READ
$stmt = $db->query("SELECT * FROM piece_jointe");
$pieces_jointes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// UPDATE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = securize($_POST['id']);
    $emmeteur = securize($_POST['user_email']);
    $destinataire = securize($_POST['recipient_email']);

    $stmt = $db->prepare("UPDATE piece_jointe SET email_emmeteur = :emmeteur, email_destinataire = :destinataire WHERE id = :id");
    $stmt->bindParam(':emmeteur', $emmeteur);
    $stmt->bindParam(':destinataire', $destinataire);
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}

// DELETE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = securize($_POST['id']);

    $stmt = $db->prepare("DELETE FROM piece_jointe WHERE id = :id");
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <script>
        let spanTexts = document.getElementsByTagName("span");

        window.onload = function() {

            for (spanText of spanTexts) {
                spanText.classList.add("active");
            }
        }

        function submitFormAndReload() {
            document.getElementById("uploadForm").action = "index.php";
            document.getElementById("uploadForm").submit();
            setTimeout(function() {
                location.reload();
            }, 1000);
        }

        function updateFileName() {
            const input = document.getElementById('fichier');
            const label = document.getElementById('fileNameLabel');
            const files = input.files;

            if (files.length === 0) {
                label.textContent = 'Choisir des fichiers';
            } else if (files.length === 1) {
                label.textContent = files[0].name;
            } else {
                let fileNameString = '';
                for (let i = 0; i < files.length; i++) {
                    fileNameString += files[i].name;
                    if (i !== files.length - 1) {
                        fileNameString += ', ';
                    }
                }
                label.textContent = fileNameString;
            }
        }
    </script>
</head>

<body>
    <div class="background">
        <div class="title">
            <h1>CLONE</h1>
            <div class="backgroundText">
                <span>T</span>
                <span>R</span>
                <span>A</span>
                <span>N</span>
                <span>S</span>
                <span>F</span>
                <span>E</span>
                <span>R</span>
            </div>
        </div>
        <div class="form">
            <form id="uploadForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">
                <div class="mb-3">
                    <div class="custom-file">
                        <label class="custom-file-label" for="fichier" id="fileNameLabel">Choisir des fichiers</label>
                        <input type="file" class="custom-file-input" id="fichier" name="fichier[]" multiple required onchange="updateFileName()">

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
                    <button type="button" class="btn btn-primary" value="send" onclick="submitFormAndReload()">Send</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>