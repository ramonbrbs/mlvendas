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

$meli = new Meli(ML_APP_ID, ML_APP_SECRET_KEY);
class Lista extends Controller{
    
    function __construct(){
        
        parent::__construct();
        $this->Context['accounts'] = MLAccount::AccountsByOwner($_SESSION[SESSION_USER]->id);
        $a = new Anuncio();
        $this->Context['anuncios_pendentes_count'] = $a->AnunciosCountPendentesByOwner($_SESSION[SESSION_USER]->id);
    }
    
    public function SelecionarConta(){
        $this->ViewFile = 'lista__selecionarconta';
        $this->Context['status'] = $_GET['status'];
        $this->render();
    }
    
    public function RecadastrarAjax(){
        $selecionarTodos = isset($_POST['selecionarTodos']);
        $status = $_POST['status'];
        $conta = $_POST['conta'];
        $descricao = $_POST['descricao'];
        $checked = $_POST['checked'];
        
        $mlacc = new MLAccount();
        $mlacc->Load($conta);
        $mlacc->checkRefreshToken();
        
        
        if(empty(selecionarTodos)){
            foreach($checked as $anuncio){
                $params = array('access_token' => $this->access_token);
                $meli = new Meli(ML_APP_ID, ML_APP_SECRET_KEY);
                $meli->get("items/$anuncio/relist", $params);
            }
        }
        
    }
    
    public function PausarAjax(){
        $selecionarTodos = isset($_POST['selecionarTodos']);
        $status = $_POST['status'];
        $conta = $_POST['conta'];
        $descricao = $_POST['descricao'];
        $checked = $_POST['checked'];
        
        $mlacc = new MLAccount();
        $mlacc->Load($conta);
        $mlacc->checkRefreshToken();
        if(empty($selecionarTodos)){
            foreach($checked as $anuncio){
                $params = array('access_token' => $this->access_token);
                $body = array('status' => 'paused');
                $resultado = $meli->put("items/$anuncio",$body, $params);
                var_dump($resultado);
            }
        }
    }
    
    public function Busca(){
        $this->ViewFile = 'lista__busca';
        $this->Context['statuses'] = [''];
        $conta = $_GET['conta'];
        //$status = $_GET['status']; //pending , active, paused, closed//
        $page = $_GET['page'];
        $sku = $_GET['sku'];
        $descricao = $_GET['descricao'];
        if(empty($_GET['page'])){
            $_SESSION['busca'] = array();
            $page = 1;
        }
        $offset = ($page - 1) * 20;
        $acc = new MLAccount();
        $acc->Load($conta);
        
        $status = $_GET['status'];
        $resultado = $acc->GetListAnuncio($status, $offset,$sku, $query);
        
        $this->Context['itens'] = $resultado['items'];
        $this->Context['total'] = $resultado['total'];
        $this->Context['qtd_pags'] = ceil($resultado['total'] / 20);
        $this->Context['conta'] = $conta;
        $this->Context['status'] = $status;
        $this->render();
    }
    
    public function BuscaPendenteAjax(){
        $conta = $_GET['conta'];
        $start = $_GET['start'];
        $descricao = $_GET['descricao'];
        $sku = $_GET['sku'];
        
        $resultado = $acc->GetListAnuncio($status, $start,$sku, $descricao);
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
}