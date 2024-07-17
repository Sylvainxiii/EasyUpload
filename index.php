<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$title = $_ENV['MAIL_FROM_NAME'];
include 'src/_header.php';
?>

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

				<input type="email" placeholder="example@example.com" value='' class="form-control custom-input" id="destEmail" name="destEmail">
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

<?php
include 'src/_footer.php';
?>