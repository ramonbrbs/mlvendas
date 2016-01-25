<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require(__DIR__ .'/rb.php');

R::setup( 'mysql:host=base2.trevvo.com.br;dbname=admin_ml','admin_ml', 'ml@2015'); //for both mysql or mariaDB
