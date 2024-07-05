<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title; ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="../src/style.css">
</head>

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