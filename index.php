<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$title = 'EasyUpload';
include 'src/_header.php';
?>



<body>
	<div>
		<!-- Modal Spinner -->
		<div class='modals'>
			<div hidden id="spin" class="spinner-border" role="status">
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
			<form id="uploadForm" method="post" enctype="multipart/form-data">
				<!-- stockage du chemin du dossier racine pour utilisation en js -->
				<input type="hidden" id="weburl" value="<?= $_ENV['WEB_URL'] ?>">
				<input type="hidden" name="action" value="create">
				<div class="mb-3">
					<div class="custom-file">
						<label class="custom-file-label" for="fichier" id="fileNameLabel">Choisir des fichiers</label>
						<input type="file" class="custom-file-input" id="fichier" name="files[]" multiple required onchange='updateFileLabel()'>

					</div>
				</div>
				<div class="mb-3">
					<label for="destEmail" class="form-label">Email destinataire: <span class="email-count">0</span></label>
					<div class="email-list"></div>

					<button class="email-add">🞦</button>
					<!-- use attribute `multiple` ? -->
					<input type="email" placeholder="example@example.com" value='' class="form-control custom-input" id="destEmail" name="destEmail">
				</div>
				<div class="mb-3">
					<label for="sourceEmail" class="form-label">Votre Email</label>
					<input type="email" value='' class="form-control custom-input" id="sourceEmail" name="sourceEmail" required>
				</div>
				<div>
					<button type="submit" class="btn btn-primary" id="send" name="submit" value="send" disabled>Send</button>
				</div>

			</form>
		</div>
	</div>
<?php
include 'src/_footer.php';
?>