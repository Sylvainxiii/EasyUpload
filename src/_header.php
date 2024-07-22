<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="../style.css">
</head>

<body>

	<div>
		<header>
			<div>
				<img src="<?= (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]/favicon.ico" ?>" alt="logo">
				<h1><?= strtoupper($_ENV['MAIL_FROM_NAME']) ?></h1>
			</div>

			<button class="btn btn-primary btn-connexion" disabled>
				<div>
					Se connecter
				</div>
				<i class="bi bi-person-fill-lock"></i>
			</button>
		</header>
		<main>

			<div>
				<!-- Modal Spinner -->
				<div hidden id="spin" class='modals'>
					<div class="spinner-border" role="status">
						<span class="sr-only"></span>
					</div>
				</div>

				<!-- Modal Empty File -->
				<div class="modal fade" id="modalEmptyFile1" tabindex="-1" role="dialog" aria-labelledby="modalEmptyFileLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content" id='mesModals'>
							<div class="modal-header">
								<h5 class="modal-title" id="modalEmptyFileLabel">Erreur d'upload de fichiers</h5>
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
			<!-- DEBUT div background -->
			<div class="background">
				<div class="title">
					<h1><?= strtoupper($_ENV['FIRST_NAME']) ?></h1>
					<div class="backgroundText">
						<?php
						foreach (str_split(strtoupper($_ENV['LAST_NAME'])) as $char) {
							echo "<span>$char</span>";
						};
						?>
					</div>
				</div>
			</div>