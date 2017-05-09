<?php
require_once(__DIR__.'/User.php');
require_once(__DIR__.'/MLAccount.php');
require_once(__DIR__.'/StatusAnuncio.php');

class CopiaConta{
    public $id;
    public $contaDe;
    public $contaPara;
    public $status;
    
    /*
    private function translateToBD(){
        if (!isset($this->id)){
            $u = R::dispense('copiaconta');
        }else{
            $u = R::load('copiaconta', $this->id);
        }
        
        $u->contaFrom = $this->contaDe;
        $u->contaTo = $this->contaPara;
        $y->status = $this->status;
    }
    
    private function translateFromBD($u){
        $this->id = $u->id;
        $this->contaFrom = $u->contaDe;
        $this->contaTo = $u->contaPara;
        $this->status = $u->status;
    }*/
}