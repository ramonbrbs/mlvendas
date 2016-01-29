<?php
require_once(__DIR__.'/../Framework/Controller.php');

class Index extends Controller{
    
    function __construct(){
        parent::__construct();
        $this->ViewFile = 'index';
    }
    
    function Index(){
        if(!empty($_POST)){
            
        }
        $this->Render();
    }
    
    function Funct($a,$b){
        echo "$a $b";
    }
    
}