<?php

use Dotenv\Dotenv;
function dotEnv($path) {
  $dotenv = Dotenv::createImmutable($path);
  $dotenv->load();
};

?>