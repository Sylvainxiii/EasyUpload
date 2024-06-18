<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>

<style>
    * {
        color: antiquewhite;
        font-family: 'Poppins', sans-serif;
    }

    .background {
        background-color: #292929;
        height: 100vh;
        width: 100%;
        padding-top: 200px;
        padding-bottom: 200px;
    }

    form {
        margin: 25px 50px;
    }

    .title {
        margin: auto;
        width: -moz-fit-content;
        width: fit-content;
        text-align: center;
        color: antiquewhite;
        position: relative;
    }

    .title h1 {
        font-size: 70px;
        font-weight: 500;
        position: relative;
        z-index: 10;
    }

    .backgroundText {
        width: max-content;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .backgroundText span {
        display: inline-block;
        font-size: 150px;
        font-weight: 700;
        -webkit-text-stroke: 1px rgb(250, 235, 215, 0.3);
        opacity: 0;
        -webkit-text-fill-color: transparent;
        transform: translateY(100px);
        transition: transform 1s, opacity 0.25s, -webkit-text-stroke-color 0.25s;
    }

    .backgroundText span.active {
        transform: translateY(0px);
        opacity: 1;
    }

    .backgroundText span:nth-child(1) {
        transition-delay: 0.25s;
    }

    .backgroundText span:nth-child(2) {
        transition-delay: 0.5s;
    }

    .backgroundText span:nth-child(3) {
        transition-delay: 0.75s;
    }

    .backgroundText span:nth-child(4) {
        transition-delay: 1s;
    }

    .backgroundText span:nth-child(5) {
        transition-delay: 1.25s;
    }

    .backgroundText span:nth-child(6) {
        transition-delay: 1.5s;
    }

    .backgroundText span:nth-child(7) {
        transition-delay: 1.75s;
    }

    .backgroundText span:nth-child(8) {
        transition-delay: 2s;
    }

    .backgroundText:hover span {
        -webkit-text-stroke-color: #80b3a5;
    }

    .form {
        padding: 75px 50px;
    }

    .button-container {
        display: flex;
        justify-content: center;
    }

    button.btn.btn-primary {
        background-color: antiquewhite;
        color: #292929;
        border: none;
        text-decoration: none;
        margin-top: 20px;
    }

    button.btn.btn-primary:hover {
        background-color: lightgray;
        text-decoration: none;
    }

    p {
        margin-top: 50px;
        text-align: center;
    }
</style>

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
            <?php
            if (isset($_GET['file'])) {
                $file = urldecode($_GET['file']);
                echo '<p>Téléchargement du fichier : ' . htmlspecialchars($file) . '</p>';
                echo '<div class="button-container">';
                echo '<button type="button" class="btn btn-primary" onclick="window.location.href=\'Download.php?file=' . urlencode($file) . '\'">Télécharger</button>';
                echo '</div>';
            } else {
                echo '<p>Aucun fichier spécifié pour le téléchargement.</p>';
            }
            ?>
        </div>
    </div>
    <script>
        let spanTexts = document.getElementsByTagName("span");

        window.onload = function() {
            for (spanText of spanTexts) {
                spanText.classList.add("active");
            }
        }
    </script>
</body>
</body>

</html>