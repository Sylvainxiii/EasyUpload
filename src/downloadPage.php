<?php
require '../vendor/autoload.php';
include_once 'dotEnv.php';
require_once 'log.php';
dotEnv("../");

$title = 'Télécharger';
include '_header.php';
?>

<div class="form">
    <?php
    if (isset($_GET['file'])) {
        $file = urldecode($_GET['file']);
        setLog('Page de téléchargement','TRACE');
        echo '<p>Téléchargement du fichier : ' . htmlspecialchars($file) . '</p>';
        echo '<div class="button-container">';
        echo '<button type="button" class="btn btn-primary" onclick="window.location.href=\'Download.php?file=' . urlencode($file) . '\'">Télécharger</button>';
        echo '</div>';
    } else {
        echo '<p>Aucun fichier spécifié pour le téléchargement.</p>';
        setLog('Aucun fichier spécifié pour le téléchargement','TRACE');
    }
    ?>
</div>
<?php
include '_footer.php';
?>
