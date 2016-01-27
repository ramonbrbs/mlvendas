<?php
require_once(__DIR__.'/../Framework/Controller.php');

class Index extends Controller{
    
    function __construct(){
        parent::__construct();
        $this->ViewFile = 'index';
    }
    
    function Index(){
        $this->Render();
    }
    
    function Funct($a,$b){
        echo "$a $b";
    }
    
}