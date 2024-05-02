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
    </script>
</head>

<body>
    <div class="background">
        <form id="uploadForm" method="post" enctype="multipart/form-data">
            <fieldset>
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
                <div class="mb-3">
                    <label for="fichier">Images</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fichier" name="fichier" required>
                            <label class="custom-file-label" for="fichier">Choisir un fichier</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-email" class="form-label">Email destinataire</label>
                        <input type="email" id="recipient-email" name="recipient_email" value="celine.pro.morel@gmail.com" />
                        <div class="mb-3">
                            <label for="disabledSelect" class="form-label">Email</label>
                            <input type="email" id="mail" name="user_email" value="celine.pro.morel@gmail.com" />
                        </div>
                        <button type="button" class="btn btn-primary" onclick="submitFormAndReload()">Send</button>
                    </div>
            </fieldset>
        </form>
    </div>
</body>

</html>