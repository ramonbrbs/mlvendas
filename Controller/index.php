<?php
require_once(__DIR__.'/../Framework/Controller.php');
require_once(__DIR__.'/../Framework/Auth.php');
require_once(__DIR__.'/../Entity/User.php');


class Index extends Controller{
    
    function __construct(){
        parent::__construct();
        $this->ViewFile = 'index';
    }
    
    function Index(){
        if(!empty($_POST)){
            
            $user = new User();
            $user->login = $_POST['login'];
            $user->plainPassword = $_POST['plainPassword'];
            if (!Auth::AuthUser($user->login, $user->plainPassword)){
                $this->Context['auth_failed'] = true;
            }else{
                $this->redirectTo('contas-ml','add');
            }
            
        }
        $this->Render();
    }
    
    function Funct($a,$b){
        echo "$a $b";
    }
    
}