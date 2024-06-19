

		if (file_exists($filepath)) {
			// Désactiver la sortie buffer pour télécharger le fichier zip
			if (ob_get_level()) {
				ob_end_clean();
			}

			// Forcer le téléchargement du fichier
			header('Content-Description: File Transfer');
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filepath));

			// Lire et envoyer le fichier
			readfile($filepath);
			exit;
		} else {
			http_response_code(404);
			die("Fichier non trouvé.");
		}
	} else {
		die("Le téléchargement ne peut aboutir : format de nom de fichier invalide.");
	}
}
=======
<?php
$filepath = '../uploads/'.$_GET['file'].'/'.$_GET['file'].'.zip';

header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($filepath));
	readfile($filepath);

?>

