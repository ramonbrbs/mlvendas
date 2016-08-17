<?php

require(__DIR__.'/Entity/StatusAnuncio.php');
require(__DIR__.'/Entity/Anuncio.php');
require(__DIR__.'/Entity/MLAccount.php');


$a = new Anuncio();
$a->sku = "a4s5d6as465dsa";
$a->titulo = "anuncio ahsdshaihsaid asd asd sad as as";
$a->num_letras = 23;

//file_put_contents('log.txt',json_encode($_GET));
//var_dump($_GET);

//$acc = R::find('anuncio', 'status_id = 3 LIMIT 0,100');
//var_dump($acc);