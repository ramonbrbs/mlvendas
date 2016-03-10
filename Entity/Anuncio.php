<?php
require_once(__DIR__.'/User.php');
require_once(__DIR__.'/MLAccount.php');
require_once(__DIR__.'/StatusAnuncio.php');


class Anuncio{
    public $id;
    public $sku;
    public $titulo;
    public $num_letras;
    public $categoria;
    public $descricao;
    public $preco;
    public $estoque;
    public $foto1;
    public $foto2;
    public $foto3;
    public $foto4;
    public $foto5;
    public $foto6;
    public $youtube;
    public $tipo;
    public $frete_gratis;
    public $norte_nordeste;
    public $erro;
    public $categoriaid;
    
    public $mlaccount;
    public $owner;
    public $status;
    
    
    public function Save(){
        $anun = $this->translateToBD();
        $this->id = R::store($anun);
    }
    
    public static function AnunciosByOwner($id){
        $result = array();
        $accs = R::find('anuncio', 'owner_id = :owner_id', ['owner_id' => $id]);
        return $accs;
    }
    
    public static function AnunciosPendentesByOwner($id){
        $result = array();
        $accs = R::find('anuncio', 'owner_id = :owner_id AND status_id = :pendente', ['owner_id' => $id, ':pendente' => 1]);
        return $accs;
    }
    
    public static function AnunciosErroByOwner($id){
        $result = array();
        $accs = R::find('anuncio', 'owner_id = :owner_id AND status_id = :erro', ['owner_id' => $id, ':erro' => 3]);
        return $accs;
    }
    
    public static function AnunciosAnunciadoByOwner($id){
        $result = array();
        $accs = R::find('anuncio', 'owner_id = :owner_id AND status_id = :anunciado', ['owner_id' => $id, ':anunciado' => 2]);
        return $accs;
    }
    
    public static function AnunciosCountByOwner($id){
        return R::count( 'anuncio', 'owner_id = :owner_id', ['owner_id' => $id]);
    }
    
    private function translateFromBD($u){
        $this->id = $u->id;
        $this->sku = $u->sku;
        $this->titulo = $u->titulo;
        $this->num_letras = $u->num_letras;
        $this->categoria = $u->categoria;
        $this->descricao = $u->descricao;
        $this->preco = $u->preco;
        $this->estoque = $u->estoque;
        $this->foto1 = $u->foto1;
        $this->foto2 = $u->foto2;
        $this->foto3 = $u->foto3;
        $this->foto4 = $u->foto4;
        $this->foto5 = $u->foto5;
        $this->foto6 = $u->foto6;
        $this->youtube = $u->youtube;
        $this->tipo = $u->tipo;
        $this->frete_gratis = $u->frete_gratis;
        $this->norte_nordeste = $u->norte_nordeste;
        $this->mlaccount = $u->mlaccount;
        $this->owner = $u->owner;
        $this->status = $u->status;
    }
    
    private function translateToBD(){
        if (!isset($this->id)){
            $u = R::dispense('anuncio');
        }else{
            $u = R::load('anuncio', $this->id);
        }
        $u->sku = $this->sku;
        $u->titulo = $this->titulo;
        $u->num_letras = $this->num_letras;
        $u->categoria = $this->categoria;
        $u->descricao = $this->descricao;
        $u->preco = $this->preco;
        $u->estoque = $this->estoque;
        $u->foto1 = $this->foto1;
        $u->foto2 = $this->foto2;
        $u->foto3 = $this->foto3;
        $u->foto4 = $this->foto4;
        $u->foto5 = $this->foto5;
        $u->foto6 = $this->foto6;
        $u->youtube = $this->youtube;
        $u->tipo = $this->tipo;
        $u->frete_gratis = $this->frete_gratis;
        $u->norte_nordeste = $this->norte_nordeste;
        
        
        $owner = new User();
        $owner->load($this->owner);
        $u->owner = $owner->load($this->owner);
        
        $mlaccount = new MLAccount();
        $u->mlaccount = $mlaccount->Load($this->mlaccount);
        
        $status = new StatusAnuncio();
        
        $u->status = $status->FindByName($this->status);
        return $u;
    }
}