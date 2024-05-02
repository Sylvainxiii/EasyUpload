<?php
$tmpName = isset($_FILES['fichier']['tmp_name']) ? $_FILES['fichier']['tmp_name'] : "";
$name = isset($_FILES['fichier']['name']) ? $_FILES['fichier']['name'] : "";
$chemin_dans_bdd = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($tmpName) && is_uploaded_file($tmpName)) {
        if (move_uploaded_file($tmpName, './uploads/' . $name)) {
            $chemin_dans_bdd = 'uploads/' . $name;
        }
    }
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
                <div class="mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="fichier" name="fichier[]" multiple required onchange="updateFileName()">
                        <label class="custom-file-label" for="fichier" id="fileNameLabel">Choisir des fichiers</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="recipient-email" class="form-label">Email destinataire</label>
                    <input type="email" class="form-control custom-input" id="recipient-email" name="recipient_email" value="celine.pro.morel@gmail.com" required>
                </div>
                <div class="mb-3">
                    <label for="mail" class="form-label">Email</label>
                    <input type="email" class="form-control custom-input" id="mail" name="user_email" value="celine.pro.morel@gmail.com" required>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" value="send" onclick="submitFormAndReload()">Send</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>