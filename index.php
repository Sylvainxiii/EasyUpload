<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
                    <label for="destEmail" class="form-label">Email destinataire</label>
                    <input type="email" class="form-control custom-input" id="destEmail" name="destEmail" required>
                </div>
                <div class="mb-3">
                    <label for="sourceEmail" class="form-label">Votre Email</label>
                    <input type="email" class="form-control custom-input" id="sourceEmail" name="sourceEmail" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" id="send" name="submit" value="send" disabled>Send</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src='index.js'></script>
</html>