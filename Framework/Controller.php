<?php

require_once(__DIR__ . '/../settings.php');
require_once(__DIR__ . '/../Libs/Smarty/Smarty.class.php');
require_once(__DIR__.'/Constant.php');

class Controller{
    
    
    public $ViewFile;
    public $Context;//array();
    private $smarty;
    
    function __construct(){
        $this->smarty = new Smarty;
        $this->Context = array();
        $this->setupSmarty();
        $this->loadStatic();
    }
    
    
    private function assignPostVars(){
        foreach($_POST as $k => $v){
            $this->smarty->assign('_post_'.$k, $v);
        }
    }
    
    private function loadStatic(){
        $this->smarty->assign('static', STATIC_PATH);
    }
    
    private function setupSmarty(){
        $this->smarty->setTemplateDir(TEMPLATE_DIR);
    }
    
    
    private function fetchFromContext(){
        if(!empty($this->Context)){
            foreach ($this->Context as $key => $value) {
                $this->smarty->assign($key, $value);
            }
        }
        
        if(isset($_SESSION[SESSION_USER])){
            $this->smarty->assign(SESSION_USER, $_SESSION[SESSION_USER]);
        }
        
    }
    
    //Replace doubleunder for /
    private function convertRealPathViewFile(){
        $this->ViewFile = str_replace('__','/',$this->ViewFile);
    }
    
    public function Render(){
        $this->assignPostVars();
        $this->fetchFromContext();
        $this->convertRealPathViewFile();
        $this->smarty->display($this->ViewFile.'.tpl');
    }
    
    public function getname(){
        return "teste";
    }
    
    protected function redirectTo($page, $method = null, $args=null){
        if (empty($method)){
            header('Location: '.ROOT_URL.$page);
        }
    }
}