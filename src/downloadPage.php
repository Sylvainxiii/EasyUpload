<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>

 
<body>
    <div class="background">
        <div class="title">
            <h1>EASY</h1>
            <div class="backgroundText">
                <span>U</span>
                <span>P</span>
                <span>L</span>
                <span>O</span>
                <span>A</span>
                <span>D</span>
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
        // Effet du nom du site

document.addEventListener('DOMContentLoaded', () => {
    const spans = document.querySelectorAll('.backgroundText span');

    spans.forEach((span, index) => {
        setTimeout(() => {
            span.classList.add('active');
        }, (index + 1) * 250); // L'ajustement du délai d'animation pour chaque span
    });
});

    </script>
</body>
 

</html>