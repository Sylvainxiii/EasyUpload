<?php
if (isset($_REQUEST["file"])) {
	$file = urldecode($_REQUEST["file"]);

	// echo "Nom de fichier décodé : $file<br>";

	if (preg_match('/^[^.][-a-z0-9_.]*$/i', $file)) {
		$filepath = "../uploads/" . $file . '/' . $file . '.zip';

		// echo "Chemin complet du fichier : $filepath<br>";

		if (file_exists($filepath)) {
			// Désactiver la sortie buffer
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
