<?php

require 'vendor/autoload.php';

include_once 'src/dotEnv.php';
include_once 'src/log.php';

dotEnv(__DIR__);

$title = $_ENV['MAIL_FROM_NAME'];
include_once 'src/_header.php';
include_once 'src/accueil.php';
include_once 'src/_footer.php';
