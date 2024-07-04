<?php 
$title = 'Document';
include '_header.php';
?>

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
            <?php
            if (isset($_GET['file'])) {
                $file = urldecode($_GET['file']);
                echo '<p>Téléchargement du fichier : ' . htmlspecialchars($file) . '</p>';
                echo '<div class="button-container">';
                echo '<button type="button" class="btn btn-primary" onclick="window.location.href=\'Download.php?file=' . urlencode($file) . '\'">Télécharger</button>';
                echo '</div>';
            } else {
                echo '<p>Aucun fichier spécifié pour le téléchargement.</p>';
            }
            ?>
        </div>
    </div>
    <script>
        let spanTexts = document.getElementsByTagName("span");

        window.onload = function() {
            for (spanText of spanTexts) {
                spanText.classList.add("active");
            }
        }
    </script>
</body>
</body>

</html>