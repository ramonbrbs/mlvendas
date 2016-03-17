<?php
require_once(__DIR__.'/../Framework/Controller.php');
require_once(__DIR__.'/../Framework/Auth.php');
require_once(__DIR__.'/../Framework/Constant.php');
require_once(__DIR__.'/../Entity/User.php');
require_once(__DIR__.'/../Entity/Anuncio.php');
require_once(__DIR__.'/../Entity/MLAccount.php');
require_once(__DIR__.'/../Entity/StatusAnuncio.php');
require_once(__DIR__.'/../settings.php');
require_once(__DIR__.'/../Libs/MercadoLivre/meli.php');
require_once(__DIR__.'/../Libs/PhpExcel/PHPExcel/IOFactory.php');

class Fila extends Controller{

    function __construct(){
        parent::__construct();
        $this->ViewFile = 'fila__upload';
        $this->Context['accounts'] = MLAccount::AccountsByOwner($_SESSION[SESSION_USER]->id);
        $a = new Anuncio();
        $this->Context['anuncios_pendentes_count'] = count($a->AnunciosCountPendentesByOwner($_SESSION[SESSION_USER]->id));
    }
    
    public function Pendentes(){
        $this->ViewFile = 'fila__pendentes';
        $a = new Anuncio();
        $this->Context['anuncios'] = $a->AnunciosPendentesByOwner($_SESSION[SESSION_USER]->id);
        $this->Render();
    }
    
    public function Erro(){
        $this->ViewFile = 'fila__erro';
        $a = new Anuncio();
        $this->Context['anuncios'] = $a->AnunciosErroByOwner($_SESSION[SESSION_USER]->id);
        $this->Render();
    }
    
    public function Ok(){
        $this->ViewFile = 'fila__ok';
        $a = new Anuncio();
        $this->Context['anuncios'] = $a->AnunciosAnunciadoByOwner($_SESSION[SESSION_USER]->id);
        $this->Render();
    }
    
    public function Index(){
        $this->ViewFile = 'fila__index';
        $a = new Anuncio();
        $this->Context['anuncios_pendentes'] = count($a->AnunciosCountPendentesByOwner($_SESSION[SESSION_USER]->id));
        $this->Context['anuncios_erro'] = count($a->AnunciosErroByOwner($_SESSION[SESSION_USER]->id));
        $this->Context['anuncios_ok'] = count($a->AnunciosCountAnunciadoByOwner($_SESSION[SESSION_USER]->id));
        $this->Render();
    }
    
    function Upload(){
        $this->ViewFile = 'fila__upload';
        if(!empty($_FILES)){
            
            //$fileName = __DIR__.'/../upload/'.time().'.xls';
            //move_uploaded_file($_FILES["file"]["tmp_name"], $fileName);
            $objPHPExcel = PHPExcel_IOFactory::load($_FILES["file"]["tmp_name"]);
            
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            for ( $i=1;$i<4;$i++){
                unset($sheetData[$i]);
            }
            foreach($sheetData as $item){
                if (isset($item['B']) and !empty($item['B'])){
                    $anuncio = new Anuncio();
                    $anuncio->sku = $item['A'];
                    $anuncio->titulo = $item['B'];
                    $anuncio->num_letras = $item['C'];
                    $anuncio->categoria = $item['D'];
                    $anuncio->descricao = $item['E'];
                    $anuncio->preco = $item['F'];
                    $anuncio->estoque = $item['G'];
                    $anuncio->foto1 = $item['H'];
                    $anuncio->foto2 = $item['I'];
                    $anuncio->foto3 = $item['J'];
                    $anuncio->foto4 = $item['K'];
                    $anuncio->foto5 = $item['L'];
                    $anuncio->foto6 = $item['M'];
                    $anuncio->youtube = $item['N'];
                    $anuncio->tipo = $item['O'];
                    $anuncio->frete_gratis = $item['P'];
                    $anuncio->norte_nordeste = $item['Q'];
                    $anuncio->status = StatusAnuncio::STATUS_PENDENTE;
                    $anuncio->owner = $_SESSION[SESSION_USER]->id;
                    $anuncio->mlaccount = $_POST['mlaccount'];
                    $anuncio->Save();
                }
                
            }
            //var_dump($sheetData);
            
            
        }
        $this->Render();
        
    }
}