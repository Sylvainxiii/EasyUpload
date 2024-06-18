<?php
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    echo 'Téléchargement du fichier : ' . htmlspecialchars($file) . '<br>';
    echo '<a href="Download.php?file=' . urlencode($file) . '">Télécharger</a>';
} else {
    echo 'Aucun fichier spécifié pour le téléchargement.';
}
