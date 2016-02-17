<?php
require_once(__DIR__.'/../Framework/Controller.php');
require_once(__DIR__.'/../Framework/Auth.php');
require_once(__DIR__.'/../Framework/Constant.php');
require_once(__DIR__.'/../Entity/User.php');
require_once(__DIR__.'/../Entity/MLAccount.php');
require_once(__DIR__.'/../settings.php');
require_once(__DIR__.'/../Libs/MercadoLivre/meli.php');


class Contas_ML extends Controller{

    function __construct(){
        parent::__construct();
        $this->ViewFile = 'upload';
        
    }
    
    function Index(){
        if(!empty($_POST)){
            
        }
    }
}