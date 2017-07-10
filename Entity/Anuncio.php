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
    public $file;
    public $fretereal;
    
    //novos
    public $condicao;
    public $garantia;
    public $marca;
    public $modelo;
    public $codbar;
    public $foto7;
    public $foto8;
    
    
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
    
    public static function AnunciosPendentesByOwner($id,$start = null,$len = null,$search = null){
        if (isset($search)){
            $acc = R::find('anuncio', "owner_id = :owner_id AND status_id = :pendente AND titulo LIKE :titulo LIMIT $start,$len ",[':titulo'=> '%'.$search.'%', 'owner_id' => $id, ':pendente' => 1]);
            return $acc;
        }
        if(isset($start)){
            $acc = R::find('anuncio', "owner_id = :owner_id AND status_id = :pendente LIMIT $start,$len ",['owner_id' => $id, ':pendente' => 1]);
            return $acc;
        }
        
        
        $accs = R::find('anuncio', 'owner_id = :owner_id AND status_id = :pendente', ['owner_id' => $id, ':pendente' => 1]);
        return $accs;
        
        /*
        $result = array();
        $accs = R::find('anuncio', 'owner_id = :owner_id AND status_id = :pendente', ['owner_id' => $id, ':pendente' => 1]);
        return $accs;*/
    }
    
    public static function AnunciosCountPendentesByOwner($id, $search = null){
        $result = array();
        if (isset($search)){
            return R::count('anuncio', 'owner_id = :owner_id AND status_id = :pendente AND titulo LIKE :titulo', [':titulo'=> '%'.$search.'%','owner_id' => $id, ':pendente' => 1]);
        }else{
            return R::count('anuncio', 'owner_id = :owner_id AND status_id = :pendente', ['owner_id' => $id, ':pendente' => 1]);
        }
        
        
        //$accs = R::count('anuncio', 'owner_id = :owner_id AND status_id = :pendente', ['owner_id' => $id, ':pendente' => 1]);
        //return $accs;
    }
    
    public static function AnunciosErroByOwner($id,$start = null,$len = null,$search = null){
        if (isset($search)){
            $acc = R::find('anuncio', "owner_id = :owner_id AND status_id = :erro AND titulo LIKE :titulo LIMIT $start,$len ",[':titulo'=> '%'.$search.'%', 'owner_id' => $id, ':erro' => 3]);
            return $acc;
        }
        if(isset($start)){
            $acc = R::find('anuncio', "owner_id = :owner_id AND status_id = :erro LIMIT $start,$len ",['owner_id' => $id, ':erro' => 3]);
            return $acc;
        }
        
        
        $accs = R::find('anuncio', 'owner_id = :owner_id AND status_id = :erro', ['owner_id' => $id, ':erro' => 3]);
        return $accs;
        //$result = array();
        //$accs = R::find('anuncio', 'owner_id = :owner_id AND status_id = :erro', ['owner_id' => $id, ':erro' => 3]);
        //return $accs;
    }
    
    public static function AnunciosCountErroByOwner($id, $search=null){
        if (isset($search)){
            return R::count('anuncio', 'owner_id = :owner_id AND status_id = :erro AND titulo LIKE :titulo', [':titulo'=> '%'.$search.'%','owner_id' => $id, ':erro' => 3]);
        }else{
            return R::count('anuncio', 'owner_id = :owner_id AND status_id = :erro', ['owner_id' => $id, ':erro' => 3]);
        }
        
        
        
        //$accs = R::count('anuncio', 'owner_id = :owner_id AND status_id = :erro', ['owner_id' => $id, ':erro' => 3]);
        //return $accs;
    }
    
    public static function AnunciosAnunciadoByOwner($id,$start = null,$len = null,$search = null){
        $result = array();
        if (isset($search)){
            $acc = R::find('anuncio', "owner_id = :owner_id AND status_id = :anunciado AND titulo LIKE :titulo LIMIT $start,$len ",[':titulo'=> '%'.$search.'%', 'owner_id' => $id, ':anunciado' => 2]);
            return $acc;
        }
        if(isset($start)){
            $acc = R::find('anuncio', "owner_id = :owner_id AND status_id = :anunciado LIMIT $start,$len ",['owner_id' => $id, ':anunciado' => 2]);
            return $acc;
        }
        
        
        $accs = R::find('anuncio', 'owner_id = :owner_id AND status_id = :anunciado', ['owner_id' => $id, ':anunciado' => 2]);
        return $accs;
    }
    
    public static function AnunciosCountAnunciadoByOwner($id,$search = null){
        
        $result = array();
        if (isset($search)){
            return R::count('anuncio', 'owner_id = :owner_id AND status_id = :anunciado AND titulo LIKE :titulo', [':titulo'=> '%'.$search.'%','owner_id' => $id, ':anunciado' => 2]);
        }else{
            return R::count('anuncio', 'owner_id = :owner_id AND status_id = :anunciado', ['owner_id' => $id, ':anunciado' => 2]);
        }
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
        $this->foto7 = $u->foto7;
        $this->foto8 = $u->foto8;
        $this->youtube = $u->youtube;
        $this->tipo = $u->tipo;
        $this->frete_gratis = $u->frete_gratis;
        $this->norte_nordeste = $u->norte_nordeste;
        $this->file = $u->file;
        $this->mlaccount = $u->mlaccount;
        $this->owner = $u->owner;
        $this->status = $u->status;
        $this->fretereal = $u->fretereal;
        $this->condicao = $u->condicao;
        $this->garantia = $u->garantia;
        $this->marca = $u->marca;
        $this->modelo = $u->modelo;
        $this->codbar = $u->codbar;
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
        $u->foto7 = $this->foto7;
        $u->foto8 = $this->foto8;
        $u->youtube = $this->youtube;
        $u->tipo = $this->tipo;
        $u->frete_gratis = $this->frete_gratis;
        $u->norte_nordeste = $this->norte_nordeste;
        $u->file = $this->file;
        $u->fretereal = $this->fretereal;
        $u->condicao = $this->condicao;
        $u->garantia = $this->garantia;
        $u->marca = $this->marca;
        $u->modelo = $this->modelo;
        $u->codbar = $this->codbar;
        
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