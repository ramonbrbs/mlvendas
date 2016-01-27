<?php

require_once(__DIR__ . '/../settings.php');
require_once(__DIR__ . '/../Libs/Smarty/Smarty.class.php');


class Controller{
    
    
    public $ViewFile;
    public $Context;//array();
    private $smarty;
    
    function __construct(){
        $this->smarty = new Smarty;
        $this->setupSmarty();
    }
    
    
    private function setupSmarty(){
        $this->smarty->setTemplateDir(TEMPLATE_DIR);
    }
    
    
    private function fetchFromContext(){
        if(!empty($this->Context)){
            foreach ($this->$Context as $key => $value) {
                $this->smarty->assign($key, $value);
            }
        }
        
    }
    
    //Replace doubleunder for /
    private function convertRealPathViewFile(){
        $ViewFile = str_replace('__','/',$ViewFile);
    }
    
    public function Render(){
        $this->fetchFromContext();
        $this->convertRealPathViewFile();
        $this->smarty->display($this->ViewFile.'.tpl');
    }
    
    public function getname(){
        return "teste";
    }
}