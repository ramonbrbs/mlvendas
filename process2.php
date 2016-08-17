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

R::debug();


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
}

//$anuncios_pendentes = R::find('anuncio', 'status_id = :id', array(':id' => $status_pendente->id));

function retornarFotos($a){
    $retorno = array();
    for($i = 1; $i<=6;$i++){
        if (isset($a->{'foto'.$i})){
            $retorno[] = array('source' => $a->{'foto'.$i} );
        }
    }
    return $retorno;
}
echo "2";

$contasPendentes = R::getAll( 'SELECT DISTINCT mlaccount_id FROM anuncio WHERE status_id = 1' );

$stringPendentes = '(';
echo "pt2\n";
var_dump($stringPendentes);
foreach($contasPendentes as $k =>$c){
    echo("pt4\n");
    var_dump($contasPendentes);
    echo("pt4\n");
    $date1 = date('"Y-m-d H:i:s"',strtotime('-24 hours'));
    $date2 = date("Y-m-d H:i:s");
    $anuncios_ultimas_24 = R::count('anuncio', 'mlaccount_id = :mlaccount AND datepost BETWEEN :date1 AND :date2', array(':mlaccount' => $c['mlaccount_id'], ':date1' => $date1, ':date2'=> $date2));
    if($anuncios_ultimas_24 > MAX_ANUN_DAY){
        echo "unsetou";
        unset($contasPendentes[$k]);
    }else{
        $stringPendentes =  $stringPendentes . $c .',';
        echo "-asdasd";
        var_dump($stringPendentes);
    }
}
$stringPendentes = rtrim($stringPendentes, ",");
$stringPendentes = $stringPendentes . ")";
$time = time();
R::exec("UPDATE anuncio SET pid=$time WHERE status_id = 1 AND mlaccount_id IN ".$stringPendentes." ORDER BY RAND() LIMIT 1000");
echo "1";
$anuncios = R::find('anuncio', "pid = $time");


foreach($anuncios as $a){
            
    if (!isset($a->categoriaid)){
        $id = resolverCategoria($a->categoria);
        $a->categoriaid = $id;
        R::store($a);
    }
    $anuncio = array();
        $anuncio['title'] = $a->titulo;
        $anuncio['category_id'] = $a->categoriaid;
        $anuncio['description'] = $a->descricao;
        $anuncio['price'] = round($a->preco, 2);
        $anuncio['currency_id'] = 'BRL';
        $anuncio['available_quantity'] = $a->estoque;
        $images = retornarFotos($a);
        $anuncio['pictures'] = $images;
        $anuncio['video_id'] = $a->youtube;
        $anuncio['condition'] = 'new';
        //$anuncio['buying_mode'] = 'buy_it_now';
        if (strtoupper($a->tipo) == 'PREMIUM'){
            $anuncio['listing_type_id'] = 'gold_pro';
        }else{
            $anuncio['listing_type_id'] = 'gold_special';
        }
        
        if(strtoupper($a->frete_gratis) == 'SIM'){
            $anuncio['shipping']= array();
            $anuncio['shipping']['free_shipping'] = true;
            $anuncio['shipping']['free_methods'] = array();
            $anuncio['shipping']['free_methods'][0]['id'] = 100009;
            $anuncio['shipping']['free_methods'][0]['rule'] = array('free_mode'=>'country', 'value'=>null);
        }
        $accML = new MLAccount();
        $accML->Load($a->mlaccount_id);
        $accML->checkRefreshToken();
        $result = $meli->post('/items/validate', $anuncio, array('access_token' => $accML->access_token));
        if ($result['httpCode'] == 204){
            
            $result = $meli->post('/items', $anuncio, array('access_token' => $accML->access_token));
            $a->status = $status_anunciado;
            $a->permalink = $result['body']->permalink;
            $a->json = json_encode($anuncio);
            $a->datepost = date("Y-m-d H:i:s");
            R::store($a);
        }else{
            foreach($result['body']->cause as $e){
                $a->error .= $e->message;
                $a->status = $status_erro;
                R::store($a);
            }
            
        }
        //exit();
}