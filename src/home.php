<?php 
$title = 'CloneTransfert';
include '_header.php';
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
				<h1>CLONE</h1>
				<div class="backgroundText">
					<span class='active'>T</span>
					<span class='active'>R</span>
					<span class='active'>A</span>
					<span class='active'>N</span>
					<span class='active'>S</span>
					<span class='active'>F</span>
					<span class='active'>E</span>
					<span class='active'>R</span>
				</div>
			</div>
			<div class="form">
				<form id="uploadForm" method="post" enctype="multipart/form-data">
					<input type="hidden" name="action" value="create">
					<div class="mb-3">
						<div class="custom-file">
							<label class="custom-file-label" for="fichier" id="fileNameLabel">Choisir des fichiers</label>
							<input type="file" class="custom-file-input" id="fichier" name="files[]" multiple required onchange='updateFileName()'>

						</div>
					</div>
					<div class="mb-3">
						<label for="destEmail" class="form-label">Email destinataire</label>
						<input type="email" value='johntchen.mos@gmail.com' class="form-control custom-input" id="destEmail" name="destEmail" required>
					</div>
					<div class="mb-3">
						<label for="sourceEmail" class="form-label">Votre Email</label>
						<input type="email" value='screfield@gmail.com' class="form-control custom-input" id="sourceEmail" name="sourceEmail" required>
					</div>
					<div>
						<button type="submit" class="btn btn-primary" id="send" name="submit" value="send" disabled>Send</button>
					</div>

				</form>
			</div>
		</div>

<?php
include '_footer.php';
?>