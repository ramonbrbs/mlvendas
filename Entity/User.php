<?php

require_once(__DIR__.'/../Libs/RedBean/setup.php');

class User
{
    public $id;
    public $name;
    public $password;
    public $plainPassword;
    public $login;
    public $email;
    
    
    
    private function translateFromBD($u){
        $this->id = $u->id;
        $this->name = $u->name;
        $this->password = $u->password;
        $this->login = $u->login;
        $this->email = $u->email;
    }
    
    private function translateToBD($u){
        $u = R::dispense('user');
        $u->name = $this->name;
        $u->password = sha1($this->plainPassword);
        $u->login = $this->login;
        $u->email = $this->email;
        return $u;
    }
    
    public function createTable(){
        $u = R::dispense('user');
        $u->name = 'teste';
        $u->password = sha1('asjdojsd');
        $u->login = 'adsiasjdsa';
        $u->email = "ramon@rasad.com";
        R::store($u);
    }
    
    public function load($id){
        $u = R::load('user', $id);
        $this->translateFromBD($u);
        return $u;
    }
    
    
    public function authenticate(){
        $u = R::findOne('user', 'login = :login AND password = :password', [':login' => $this->login, ':password' => sha1($this->plainPassword)]);
        if (!$u == null){
            $this->translateFromBD($u);
            return $u->id;
        }
        
        return false;
            
    }
    
    
    
    public function register(){
        $errors = array();
        
        if( strlen($this->name) < 6 )
            $errors['name'] = 'Nome deve ter no mínimo 6 caracteres';
        
        if( strlen($this->plainPassword) < 6 )
            $errors['plainPassword'] = 'Senha deve ter no mínimo 6 caracteres';
            
        if( strlen($this->login) < 6 )
            $errors['login'] = 'Login deve ter no mínimo 6 caracteres';
            
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
            $errors['email'] = 'Email inválido';
        
        if (empty($this->errors)){
            $byLogin = R::findOne('user', 'login = ?',[ $this->login ]);
            $byEmail = R::findOne('user', 'login = ?',[ $this->email ]);
            
            if ($byLogin != null)
                $errors['login'] = 'Nome de usuário já utilizado';
            
            if ($byEmail != null)
                $errors['email'] = 'Email já utilizado';
        }
        
        if (empty($errors)){
            $user = R::dispense('user');
            $user->name = $this->name;
            $user->password = sha1($this->plainPassword);
            $user->login = $this->login;
            $user->email = $this->email;
            
            return R::store($user);
        }
        
        return $errors;
        
    }
}