<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

include('src/titleAnimation.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $_ENV['MAIL_FROM_NAME'] ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">

	<script type="module" src='index.js'></script>
</head>

<body>
	<div>
		<!-- Modal Spinner -->
		<div hidden id="spin" class='modals'>
			<div class="spinner-border" role="status">
				<span class="sr-only"></span>
			</div>
		</div>

		<!-- Modal Empty File -->
		<div class="modal fade" id="modalEmptyFile1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" id='mesModals'>
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Erreur d'upload de fichiers</h5>
					</div>
					<div class="modal-body">
						Veuillez uploader un fichier
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary button-modal" data-dismiss="modal">Fermer</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="background">

		<?= titleAnimation() ?>

		<div class="form">
			<form id="uploadForm" method="post" enctype="multipart/form-data">
				<!-- stockage du chemin du dossier racine pour utilisation en js -->
				<input type="hidden" id="weburl" value="<?= $_ENV['WEB_URL'] ?>">
				<input type="hidden" name="action" value="create">
				<div class="mb-3">
					<div class="custom-file">
						<label class="custom-file-label" for="fichier" id="fileNameLabel">Choisir des fichiers</label>
						<input type="file" class="custom-file-input" id="fichier" name="files[]" multiple required>

					</div>
				</div>
				<div class="mb-3">
					<label for="destEmail" class="form-label">Email destinataire: <span class="email-count">0</span></label>
					<div class="email-list"></div>

					<input type="email" placeholder="example@example.com Enter" value='' class="form-control custom-input" id="destEmail" name="destEmail">
				</div>
				<div class="mb-3">
					<label for="sourceEmail" class="form-label">Votre Email</label>
					<input type="email" value='' class="form-control custom-input" id="sourceEmail" name="sourceEmail" required>
				</div>
				<div>
					<input type="submit" class="btn btn-primary" id="send" name="submit" value="send" disabled>
				</div>
			</form>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>