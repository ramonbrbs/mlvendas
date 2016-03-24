<?php

require(__DIR__.'/Entity/StatusAnuncio.php');
require(__DIR__.'/Entity/MLAccount.php');

//file_put_contents('log.txt',json_encode($_GET));
//var_dump($_GET);

$acc = R::find('anuncio', 'status_id = 3 LIMIT 0,100');
var_dump($acc);