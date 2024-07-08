<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$title = $_ENV['MAIL_FROM_NAME'];
include 'src/_header.php';


$url = $_SERVER['REQUEST_URI'];
if(!empty($url) && $url[-1] === "/"){
    // Retire le /
    $url = substr($url, 0, -1);
    echo($url);
    // Envoie code de redirection permanente
    http_response_code(301);

    // Redirige vers l'URL w/o /
    header('Location: '.  $url);
}

 

if ($url == 'http://wetransfert.test'){

	include 'src/accueil.php';
}
?>


	

<?php
include 'src/_footer.php';
?>
