<?php
require_once(__DIR__.'/Framework/Controller.php');
require_once(__DIR__.'/Framework/Auth.php');
require_once(__DIR__.'/Framework/Constant.php');
require_once(__DIR__.'/Entity/User.php');
require_once(__DIR__.'/Entity/Attribute.php');
require_once(__DIR__.'/Entity/Anuncio.php');
require_once(__DIR__.'/Entity/MLAccount.php');
require_once(__DIR__.'/settings.php');
require_once(__DIR__.'/Libs/MercadoLivre/meli.php');
require_once(__DIR__.'/Libs/RedBean/setup.php');
set_time_limit(0);


$status_pendente = R::load('statusanuncio',1);
$status_anunciado = R::load('statusanuncio',2);
$status_erro = R::load('statusanuncio',3);
$status_execucao = R::load('statusanuncio',4);

$meli = new Meli(ML_APP_ID, ML_APP_SECRET_KEY);

function retornarFotos($a){
        $retorno = array();
        for($i = 1; $i<=8;$i++){
            if (isset($a->{'foto'.$i})){
                $retorno[] = array('source' => $a->{'foto'.$i} );
            }
        }
        return $retorno;
    }
    R::debug(false);
try{
    
    $anuncios_pendentes = R::find('anuncio', 'status_id = :id LIMIT 100', array(':id' => $status_pendente->id));
    
    
    
        var_dump(count($anuncios_pendentes));
        $date1 = date('Y-m-d H:m:s',strtotime('-24 hours'));
        $date2 = date('Y-m-d H:m:s');

        
        
        foreach($anuncios_pendentes as $a){
            
            
            $anuncio = array();
                $anuncio['title'] = $a->titulo;
                $anuncio['seller_custom_field'] = $a->sku;
                $anuncio['category_id'] = $a->categoria;
                $anuncio['description'] = $a->descricao;
                $anuncio['price'] = $a->preco;
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
                $anuncio['warranty'] = $a->garantia;
                $anuncio['attributes'] = array();
                
                if(!empty($a->modelo)){
                    $anuncio['attributes'][] = new Attribute("MODEL", $a->modelo);
                }
                
                if(!empty($a->marca)){
                    $anuncio['attributes'][] = new Attribute("BRAND", $a->marca);
                }
                if(!empty($a->codbar)){
                    $anuncio['attributes'][] = new Attribute("EAN", $a->codbar);
                }
                
                if(strtoupper($a->frete_gratis) == 'SIM'){
                    $anuncio['shipping']= array();
                    $anuncio['shipping']['free_shipping'] = true;
                    $anuncio['shipping']['free_methods'] = array();
                    $anuncio['shipping']['free_methods'][0]['id'] = 100009;
                    $anuncio['shipping']['free_methods'][0]['rule'] = array('free_mode'=>'country', 'value'=>null);
                }elseif(true) {
                    
                    $anuncio['shipping']= array();
                    $anuncio['shipping']['free_shipping'] = true;
                    $anuncio['shipping']['free_methods'] = array();
                    $anuncio['shipping']['free_methods'][0]['id'] = 100009;
                    $anuncio['shipping']['free_methods'][0]['rule'] = array('free_mode'=>'exclude_region', 'value'=>array('BR-NO','BR-NE'));
                }
                $accML = new MLAccount();
                
                
                $accML->Load($a->mlaccount_id);
                $accML->checkRefreshToken();
                $result = $meli->post('/items/validate', $anuncio, array('access_token' => $accML->access_token));
                
                var_dump($result);
                $a->json = json_encode($anuncio);
                if ($result['httpCode'] == 204){
                    
                    $result = $meli->post('/items', $anuncio, array('access_token' => $accML->access_token));
                    $a->status = $status_anunciado;
                    $a->permalink = $result['body']->permalink;
                    $a->json = json_encode($anuncio);
                    R::store($a);
                }else{
                    foreach($result['body']->cause as $e){
                        $a->error .= $e->message;
                        $a->status = $status_erro;
                        R::store($a);
                    }
                    R::store($a);
                    
                }
                //exit();
        }
    
    }catch (Exception $e) {
        print("/////error \n");
        var_dump($e);
    }