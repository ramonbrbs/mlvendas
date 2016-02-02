<?php
require_once(__DIR__.'/../Framework/Controller.php');
require_once(__DIR__.'/../Framework/Auth.php');
require_once(__DIR__.'/../Entity/User.php');
require_once(__DIR__.'/../Libs/MercadoLivre/meli.php');

class Contas_ML extends Controller{
    
    function __construct(){
        parent::__construct();
        $this->ViewFile = 'contas_ml__add_ml';
        $this->meli = new Meli('7330605392252389', 'pJ0LqBVTy4zEURTeoIHfU83TzsRfmhGu');
    }
    
    function Add(){
        $this->Context['url_meli'] = $this->meli->getAuthUrl(MELI_REDIRECT);
        $this->render();
    }
    
    function Callback(){
        $user = $this->meli->authorize($_GET['code'], MELI_REDIRECT);
        echo 'oi';
    }
}