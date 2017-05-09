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
    try {
        $pid = time();
        R::exec("UPDATE copiapagina SET pid = $pid WHERE pid IS NULL LIMIT 1");
        
        $pagina = R::findOne('copiapagina', 'pid = ?',[$pid]);
        if($pagina != null){
            $mlaccount = new MLAccount();
            $mlaccount->Load($pagina->contade);
            $mlaccount->checkRefreshToken();
            
            $meli = new Meli(ML_APP_ID, ML_APP_SECRET_KEY);
            $idConta = $mlaccount->userid;
            $anuncios = $meli->get("/users/$idConta/items/search", array('access_token' => $mlaccount->access_token, 'limit'=> 100, 'offset' => $pagina->offset));
            $anuncios_lista = $anuncios['body']->results;
            var_dump($anuncios_lista);
            var_dump($pagina->offset);
            foreach($anuncios_lista as $a){
                $contapara = R::load('mlaccount', $pagina->contapara);
                
                $anuncio = R::dispense('anuncio');
                $anuncio_req = $meli->get("/items/$a", array('access_token' => $mlaccount->access_token));
                $anuncio_ml = $anuncio_req['body'];
                $anuncio->status_id = 1;
                if($anuncio_ml->status == "active"){
                    echo "foi";
                    $anuncio->titulo = $anuncio_ml->title;
                $anuncio->preco = $anuncio_ml->price;
                $anuncio->estoque = $anuncio_ml->initial_quantity;
                $anuncio->youtube = $anuncio_ml->video_id;
                if($anuncio_ml->listing_type_id == "gold_pro"){
                    $anuncio->tipo = "PREMIUM";
                }else{
                    $anuncio->tipo = $anuncio_ml->listing_type_id;
                }
                $anuncio->categoriaid = $anuncio_ml->category_id;
                $anuncio->mlaccount_id = $contapara->id;
                $anuncio->owner_id = $contapara->owner_id;
                
                if($anuncio_ml->shipping->free_shipping == true){
                    $anuncio->frete_gratis = "SIM";
                }else{
                    $anuncio->frete_gratis = "NÃO";
                }
                
                $anuncio->descricao = $meli->get("/items/$a/description", array('access_token' => $mlaccount->access_token))['body']->text;
                for($i = 1; $i<= count($anuncio_ml->pictures);$i++){
                    $foto = "foto".$i;
                    $anuncio->$foto = $anuncio_ml->pictures[$i-1]->url;
                }
                
                R::store($anuncio);
                }else{
                    echo "nada";
                }
                
                
            }
            exit();
        }
    } catch (Exception $e) {
        echo $e;
        file_put_contents('log_processa_pagina.txt', $e , FILE_APPEND);
    }
    
    
}


