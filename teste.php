<?php

require(__DIR__.'/Entity/User.php');
require(__DIR__.'/Entity/MLAccount.php');

$acc = new MLAccount();
$acc->createTable();


