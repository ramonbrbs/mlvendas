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
    
    function Copia(){
        $this->ViewFile = 'fila__copiaconta';
        $this->Context['accounts'] = MLAccount::AccountsByOwner($_SESSION[SESSION_USER]->id);
        if(!empty($_POST)){
            $contade = $_POST['mlaccountDe'];
            $contapara = $_POST['mlaccountPara'];
            $errors = array();
            if($_POST['mlaccountDe'] ==$_POST['mlaccountPara']){
                $errors[] = "Não é possível copiar para a mesma conta";
            }
            
            if(R::findOne('copiaconta', 'contade = ? AND contapara = ? AND status_id != ? ',[$contade, $contapara, 2]) != null){
                $errors[] = "Esta migração de anúncios já está sendo realizada";
            }
            R::debug(false);
            if(empty($errors)){
                
                $copia = R::dispense('copiaconta');
                $copia->contade = $_POST['mlaccountDe'];
                $copia->contapara = $_POST['mlaccountPara'];
                $copia->status = R::load('statusanuncio',1);
                R::store($copia);
            }
        }$this->Context['errors'] = $errors;
        $this->Render();
    }
    
    function __construct(){
        
        parent::__construct();
        $this->ViewFile = 'fila__upload';
        $this->Context['accounts'] = MLAccount::AccountsByOwner($_SESSION[SESSION_USER]->id);
        $a = new Anuncio();
        $this->Context['anuncios_pendentes_count'] = $a->AnunciosCountPendentesByOwner($_SESSION[SESSION_USER]->id);
    }
    
    public function Pendentes(){
        $this->ViewFile = 'fila__pendentes';
        $a = new Anuncio();
        $this->Context['anuncios'] = $a->AnunciosCountPendentesByOwner($_SESSION[SESSION_USER]->id);
        $this->Render();
    }
    
    public function PendentesAjax(){
        $search = $_GET['search']['value'];
        $start = $_GET['start'];
        $len = $_GET['length'];
        $anun = new Anuncio();
        
        $data = array();
        $anuncios =  $anun->AnunciosPendentesByOwner($_SESSION[SESSION_USER]->id,$start,$len,$search);
        foreach($anuncios as $a){
            $data[] = [$a->titulo, $a->sku,$a->mlaccount->nickname];
        }
        $response = array();
        $response['data'] = $data;
        $response['recordsTotal'] = $anun->AnunciosCountPendentesByOwner($_SESSION[SESSION_USER]->id);
        $response['recordsFiltered'] = $anun->AnunciosCountPendentesByOwner($_SESSION[SESSION_USER]->id, $search);
        $response['draw'] = (integer)$_GET['draw'];
       echo(json_encode($response));
        //echo('{ "draw": 1, "recordsTotal": 57, "recordsFiltered": 57, "data": [ [ "Angelica", "Ramos", "System Architect" ] ] }');
    }
    
    public function OkAjax(){
        $search = $_GET['search']['value'];
        $start = $_GET['start'];
        $len = $_GET['length'];
        $anun = new Anuncio();
        
        $data = array();
        $anuncios =  $anun->AnunciosAnunciadoByOwner($_SESSION[SESSION_USER]->id,$start,$len,$search);
        foreach($anuncios as $a){
            $data[] = [$a->titulo, $a->sku,$a->mlaccount->nickname, $a->permalink];
        }
        $response = array();
        $response['data'] = $data;
        
        $response['recordsTotal'] = $anun->AnunciosCountAnunciadoByOwner($_SESSION[SESSION_USER]->id);
        
        $response['recordsFiltered'] = $anun->AnunciosCountAnunciadoByOwner($_SESSION[SESSION_USER]->id, $search);        ////esponse['recordsFiltered'] = count($anuncios);
        $response['draw'] = (integer)$_GET['draw'];
       echo(json_encode($response));
    }
    
    public function Erro(){
        $this->ViewFile = 'fila__erro';
        $a = new Anuncio();
        $this->Context['anuncios'] = $a->AnunciosErroByOwner($_SESSION[SESSION_USER]->id);
        $this->Render();
    }
    
    public function ErrorAjax(){
        $search = $_GET['search']['value'];
        $start = $_GET['start'];
        $len = $_GET['length'];
        $anun = new Anuncio();
        
        $data = array();
        $anuncios =  $anun->AnunciosErroByOwner($_SESSION[SESSION_USER]->id,$start,$len,$search);
        foreach($anuncios as $a){
            $data[] = [$a->titulo, $a->sku,$a->mlaccount->nickname, $a->error];
        }
        $response = array();
        $response['data'] = $data;
        
        $response['recordsTotal'] = $anun->AnunciosCountErroByOwner($_SESSION[SESSION_USER]->id);
        
        $response['recordsFiltered'] = $anun->AnunciosCountErroByOwner($_SESSION[SESSION_USER]->id, $search);        ////esponse['recordsFiltered'] = count($anuncios);
        $response['draw'] = (integer)$_GET['draw'];
       echo(json_encode($response));
    }
    
    
    public function Ok(){
        $this->ViewFile = 'fila__ok';
        //$a = new Anuncio();
        ////$this->Context['anuncios'] = $a->AnunciosAnunciadoByOwner($_SESSION[SESSION_USER]->id);
        $this->Render();
    }
    
    public function Arquivo($arq, $usr){
        $this->ViewFile = 'fila__arquivo';
        $conta = R::load('mlaccount',$usr );
        
        $anuncios = R::find('anuncio', "file = :arquivo AND mlaccount_id = :mlaccount", array(':arquivo' => $arq, ':mlaccount' => $usr));
        
        $this->Context['anuncios'] = $anuncios;
        $this->Context['arquivo'] = $arq;
        $this->Context['conta'] = $conta->nickname;
        $this->Render();
    }
    
    public function Index(){
        $this->ViewFile = 'fila__index';
        $userid = $_SESSION[SESSION_USER]->id;
        $arquivosConta = R::getAll("SELECT A.file, MLA.nickname,A.mlaccount_id, COUNT(CASE A.status_id WHEN 2 THEN 1 ELSE null END) AS anunciado,COUNT(CASE A.status_id WHEN 3 THEN 1 ELSE null END) AS erro,COUNT(CASE A.status_id WHEN 1 THEN 1 ELSE null END) AS pendente FROM anuncio A
        JOIN mlaccount MLA on MLA.id = A.mlaccount_id
        WHERE file IS NOT NULL AND A.owner_id = $userid
        GROUP BY A.file, MLA.nickname, A.mlaccount_id
        ORDER BY A.id DESC");
        $this->Context['arquivosConta'] = $arquivosConta;
        
        
        $a = new Anuncio();
        $this->Context['anuncios_pendentes'] = $a->AnunciosCountPendentesByOwner($_SESSION[SESSION_USER]->id);
        $this->Context['anuncios_erro'] = $a->AnunciosCountErroByOwner($_SESSION[SESSION_USER]->id);
        $this->Context['anuncios_ok'] = $a->AnunciosCountAnunciadoByOwner($_SESSION[SESSION_USER]->id);
        $this->Render();
    }
    
    function Upload(){
        
        $this->ViewFile = 'fila__upload';
        $mlAccount = $_POST['mlaccount'];
        $errors = array();
        if(!empty($_FILES)){
            $f = $_FILES;
            for($i = 0; $i< count($_FILES['file']['name']);$i++){
                $nomeArquivo = $f['file']['name'][$i];
                if (R::count('anuncio', 'mlaccount_id = :mlAccount AND file = :nomeArquivo LIMIT 1', array(':mlAccount' => $mlAccount, ':nomeArquivo' => $nomeArquivo)) > 0){
                    $errors[] = "Arquivo já enviado para esta conta (Arquivo [$nomeArquivo] - Conta [$mlAccount]";
                }else{
                    $objPHPExcel = PHPExcel_IOFactory::load($f['file']['tmp_name'][$i]);
            
                    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                    for ( $j=1;$j<4;$j++){
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
                            $anuncio->file = $nomeArquivo;
                            $anuncio->Save();
                        }
                        
                    }
                }
            }
            
            
            $this->Context['errors'] = $errors;
            $this->Render();
            exit();
            
            
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
                    $anuncio->file = $_FILES['file']['name'];
                    $anuncio->Save();
                }
                
            }
            //var_dump($sheetData);
            
            
        }
        $this->Render();
        
    }
}