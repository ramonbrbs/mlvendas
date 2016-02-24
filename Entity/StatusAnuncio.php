<?php

require_once(__DIR__.'/../Libs/RedBean/setup.php');

class StatusAnuncio{
    
    const STATUS_PENDENTE = 'STATUS_PENDENTE';
    const STATUS_ANUNCIADO = 'STATUS_ANUNCIADO';
    const STATUS_ERRO = 'STATUS_ERRO';
    const STATUS_EXECUCAO = 'STATUS_EXECUCAO';
    
    
    public $id;
    public $name;
    
    private function translateFromBD($u){
        $this->id = $u->id;
        $this->name = $u->name;
        
    }
    
    private function translateToBD($u){
        if (!isset($this->id)){
            $u = R::dispense('statusanuncio');
        }else{
            $u = R::load('statusanuncio', $this->id);
        }
        $u->name = $this->name;
        
        return $u;
    }
    
    public function FindByName($statusName){
        $a = R::findOne('statusanuncio', 'name = :name', [':name' => $statusName]);
        $this->translateFromBD($a);
        return $a;
    }
    
    public function CreateTable(){
        $a = R::dispense('statusanuncio');
        $a->name = self::STATUS_PENDENTE;
        R::store($a);
        
        $a = R::dispense('statusanuncio');
        $a->name = self::STATUS_ANUNCIADO;
        R::store($a);
        
        $a = R::dispense('statusanuncio');
        $a->name = self::STATUS_ERRO;
        R::store($a);
        
    }
    
}