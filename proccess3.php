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
set_time_limit(0);

$running = R::getAll('SELECT DISTINCT pid FROM anuncio where status_id = 1');
if( count($running) >= 4){
    exit();
}

$status_pendente = R::load('statusanuncio',1);
$status_anunciado = R::load('statusanuncio',2);
$status_erro = R::load('statusanuncio',3);
$status_execucao = R::load('statusanuncio',4);


$meli = new Meli(ML_APP_ID, ML_APP_SECRET_KEY);

function resolverCategoria($categorias){
    try {
        $categoriaBD = R::findOne('categoria', 'name = :name', array(':name' => $categorias));
        if (isset($categoriaBD)){
            return $categoriaBD->categoriaid;
        }
        
        $meli = new Meli(ML_APP_ID, ML_APP_SECRET_KEY);
        $catArray = explode("/",$categorias);
        $ultima = '';
        for ($i = 0; $i<count($catArray);$i++){
            
            $list = array();
            if ($i == 0){
                $result = $meli->get("/sites/MLB/categories");
                $list = $result['body'];
            }else{
                $result = $meli->get("/categories/".$ultima);
                $list = $result['body']->children_categories;
            }
            
            
            foreach ($list as $cat){
                
                if ($cat->name == trim($catArray[$i])){
                    $ultima = $cat->id;
                    break;
                }
            }
            
            if ($i == (count($catArray) -1)){
                $categoria = R::dispense('categoria');
                $categoria->name = $categorias;
                $categoria->categoriaid = $ultima;
                R::store($categoria);
                return $ultima;
            }
            
            
        }
        
    } catch (Exception $e) {
        throw $e;
    }
    
}


function retornarFotos($a){
    try {
        $retorno = array();
        for($i = 1; $i<=6;$i++){
            if (isset($a->{'foto'.$i})){
                $retorno[] = array('source' => $a->{'foto'.$i} );
            }
        }
        return $retorno;
        
    } catch (Exception $e ) {
        file_put_contents('log_processa.txt', $e , FILE_APPEND);
    }
    
}