<?php

require_once(__DIR__.'/Framework/Controller.php');
require_once(__DIR__.'/Framework/Auth.php');
require_once(__DIR__.'/Framework/Constant.php');
require_once(__DIR__.'/Entity/User.php');
require_once(__DIR__.'/Entity/Anuncio.php');
require_once(__DIR__.'/Entity/MLAccount.php');
require_once(__DIR__.'/settings.php');
require_once(__DIR__.'/Libs/MercadoLivre/meli.php');
require_once(__DIR__.'/Libs/RedBean/setup.php');

while(true){
    $conta = R::findOne('copiaconta', 'status_id = ?', [1]);
    $conta->status_id = 4;
    R::store($conta);
    
    $accML = new MLAccount();
    $accML->Load($conta->contade);
    $accML->checkRefreshToken();
    
    
    $meli = new Meli(ML_APP_ID, ML_APP_SECRET_KEY);
    $idConta = $accML->userid;
    $anuncios = $meli->get("/users/$idConta/items/search", array('access_token' => $accML->access_token, 'limit'=> 100));
    $paginas = round(($anuncios['body']->paging->total / 100) + 0.51);
    
    for($i = 1;$i<=$paginas;$i++){
        $copiapagina = R::dispense('copiapagina');
        $copiapagina->contade = $conta->contade;
        $copiapagina->contapara = $conta->contapara;
        $copiapagina->offset = ($i-1)*100;
        $copiapagina->limit = 100;
        $copiapagina->status = R::load('statusanuncio',1);
        $copiapagina->pid = null;
        R::store($copiapagina);
    }
    var_dump($anuncios['body']->paging->total);
    
    exit();
}

