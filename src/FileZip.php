<?php
require_once 'log.php';
function createZip($repositoryPath, $repositoryName, $files)
{
  $filesNames = array_map('basename', $files);

  $zip = new ZipArchive();
    // On crée l’archive.
    if ($zip->open($repositoryPath . '/' . $repositoryName . '.zip', ZipArchive::CREATE) == TRUE) {
      // Ajout d’un fichier.
      setLog('Transforme en fichier Zip','TRACE');
      for ($i = 0; $i < count($files); $i = $i + 1) {
        if (file_exists($files[$i])) {
          $zip->addFile($files[$i], $filesNames[$i]);
        }
      }
      // Et on referme l'archive.
      $zip->close();
    } else {
      echo 'Impossible d&#039;ouvrir &quot;' . $repositoryName . '.zip&quot;';
    }
  // Traitement des erreurs avec un switch(), par exemple.
}
