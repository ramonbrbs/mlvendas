<?php

require_once(__DIR__.'/../Libs/RedBean/setup.php');
require_once(__DIR__.'/User.php');
require_once(__DIR__.'/../Libs/MercadoLivre/meli.php');

class MLAccount{
    public $id;
    public $nickname;
    public $userid;
    public $access_token;
    public $expires;
    public $refresh_token;
    
    public $owner;
    
    
    private function translateFromBD($u){
        $this->id = $u->id;
        $this->nickname = $u->nickname;
        $this->userid = $u->userid;
        $this->access_token = $u->access_token;
        $this->expires = $u->expires;
        $this->refresh_token = $u->refresh_token;
        $this->owner = $u->owner_id;
    }
    
    private function translateToBD(){
        if (!isset($this->id)){
            $u = R::dispense('mlaccount');
        }else{
            $u = R::load('mlaccount', $this->id);
        }
        $u->nickname = $this->nickname;
        $u->userid = $this->userid;
        $u->access_token = $this->access_token;
        $u->expires = $this->expires;
        $u->refresh_token = $this->refresh_token;
        $owner = new User();
        $owner->load($this->owner);
        $u->owner = $owner->load($this->owner);;
        return $u;
    }
    
    public function Save(){
        $acc = $this->translateToBD();
        $this->id = R::store($acc);
    }
    
    public function CreateTable(){
        $u = R::dispense('mlaccount');
        $u->nickname = "asdasd";
        $u->userid = 213123213;
        $u->access_token = 'APP_USR-6212068024248421-102707-31dab50df36c53d3d2fc2c06afe0b614__L_B__-25255785';
        $u->expires = 1445968457;
        $u->refresh_token = 'TG-562f65e8e4b0cd0ea1918d94-25255785';
        $owner = R::load('user',1);
        $u->owner = $owner;
        R::store($u);
    }
    
    public function GetNickname(){
        $this->checkRefreshToken();
        $params = array('access_token' => $this->access_token);
        $meli = $this->getMeli();
        $result = $meli->get("/users/me", $params);
        if ($result['httpCode'] == 200){
            $this->nickname = $result['body']->nickname;
        }
        $this->Save();
    }
    
    public function GetListAnuncio($status, $offset, $query){
        $retorno = array();
        $this->checkRefreshToken();
        $meli = $this->getMeli();
        $params = array('access_token' => $this->access_token, 'status' => $status, 'limit' => 20);
        if(! empty($query)){
            $params['query'] = $query;
        }
        $result = $meli->get("/users/$this->userid/items/search", $params);
        if ($result['httpCode'] == 200){
            $retorno['total'] = $result['body']->paging->total;
            $retorno['results'] = $result['body']->results;
        }
        return $retorno;
    }
    
    public static function AccountsByOwner($id){
        $result = array();
        $accs = R::find('mlaccount', 'owner_id = :owner_id', ['owner_id' => $id]);
        return $accs;
    }
    
    
    public function RemoveAccount(){
        if($this->UserHaveAccount($this->id)){
            $acc = R::load('mlaccount', $this->id);
            R::trash($acc);
            return true;
        }else{
            return ['not_valid' => 'Usuário não possui esta conta'];
        }
        
    }
    
    public function UserHaveAccount($idAcc){
        $acc = R::findOne('mlaccount', 'id = :id AND owner_id = :owner_id', [':id' => $idAcc, ':owner_id' => $this->owner]);
        return (isset($acc));
    }
    
    public function AddAccount(){
        $registered = R::findOne('mlaccount', 'userid = :userid AND owner_id = :owner_id', [':userid' => $this->userid, ':owner_id' => $this->owner]);
        if (!isset($registered)){
            $this->Save();
            return $this->id;
        }else{
            return ['Conta Registrada' => 'Está conta já foi registrada para este usuário'];
        }
        
    }
    
    public function Load($id){
        $u = R::load('mlaccount', (integer)$id);
        $this->translateFromBD($u);
        return $u;
    }
    
    private function getMeli(){
        return new Meli(ML_APP_ID, ML_APP_SECRET_KEY, $this->access_token, $this->refresh_token);
    }
    
    public function checkRefreshToken(){
        $meli = $this->getMeli();
        if ($this->expires < time()){
            $refresh = $meli->refreshAccessToken();
            if ($refresh['httpCode'] == 200){
                $this->access_token = $refresh['body']->access_token;
                $this->expires = time() + $refresh['body']->expires_in;
                $this->refresh_token = $refresh['body']->refresh_token;
            }
            $this->Save();
        }
        
    }
    
    public function PostAnuncio(){
        $this->checkRefreshToken();
        $params = array('access_token' => $this->access_token);
        $meli = $this->getMeli();
        $result = $meli->get("/users/me", $params);
        
    }
}