<?php
require '../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

$title = 'Télécharger';
include '_header.php';
?>

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
<?php
include '_footer.php';
?>
