<?php

require_once(__DIR__.'/../Libs/RedBean/setup.php');

class MLAccount{
    public $id;
    public $user_id;
    public $access_token;
    public $expires;
    public $refresh_token;
    
    public $owner;
    
    
    private function translateFromBD($u){
        $this->id = $u->id;
        $this->user_id = $u->user_id;
        $this->access_token = $u->access_token;
        $this->expires = $u->expires;
        $this->refresh_token = $u->refresh_token;
        $this->owner = $u->owner;
    }
    
    private function translateToBD($u){
        $u = R::dispense('mlaccount');
        $u->user_id = $this->user_id;
        $u->access_token = $this->access_token;
        $u->expires = $this->access_token;
        $u->refresh_token = $this->refresh_token;
        $u->owner = $this->owner;
        return $u;
    }
    
    public function CreateTable(){
        $u = R::dispense('mlaccount');
        $u->access_token = 'APP_USR-6212068024248421-102707-31dab50df36c53d3d2fc2c06afe0b614__L_B__-25255785';
        $u->expires = 1445968457;
        $u->refresh_token = 'TG-562f65e8e4b0cd0ea1918d94-25255785';
        $owner = R::load('user',1);
        $u->owner = $owner;
        R::store($u);
    }
    
    public function AddAccount(){
        $acc = $this->translateFromBD($acc);
        return R::store($acc);
    }
}