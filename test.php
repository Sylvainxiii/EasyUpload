<?php

use Dotenv\Dotenv;

//Load Composer's autoloader
require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable('./');
$dotenv->load();


// include "";

/**
 * TEST
 */

 // dotenv is file
 // content dotenv

 // *.php


?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test CT</title>
</head>
<body>
  
<h1>Test CT</h1>

<div><?php echo $_ENV['TEST_MAIL'] ?></div>
<div><a href="<?php echo $_ENV['TEST_FILE'] ?>" target="_blank" rel="noopener noreferrer">TEST_FILE</a></div>

</body>
</html>