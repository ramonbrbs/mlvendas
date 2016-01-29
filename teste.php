<?php

require(__DIR__.'/Entity/User.php');

$user = new User();
$user->name = "Ramon Barbosa";
$user->plainPassword = '123456';
$user->login = 'ramonflmr';
$user->email = 'ramonflmr@gmail.com';


var_dump($user->register());