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
    
    public function Busca(){
        $this->ViewFile = 'lista__busca';
        $this->Context['statuses'] = [''];
        $conta = $_GET['conta'];
        //$status = $_GET['status']; //pending , active, paused, closed//
        $page = $_GET['page'];
        $query = $_GET['query'];
        if(empty($_GET['page'])){
            $page = 1;
        }
        $offset = ($page - 1) * 20;
        $acc = new MLAccount();
        $acc->Load($conta);
        
        $status = $_GET['status'];
        $resultado = $acc->GetListAnuncio($status, $offset, $query);
        
        $this->Context['itens'] = $resultado['items'];
        $this->Context['total'] = $resultado['total'];
        $this->Context['qtd_pags'] = ceil($resultado['total'] / 20);
        $this->Context['conta'] = $conta;
        $this->Context['status'] = $status;
        $this->render();
    }
}