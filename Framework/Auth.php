<?php

require_once(__DIR__.'/Session.php');
require_once(__DIR__.'/Constant.php');
require_once(__DIR__.'/../Entity/User.php');

class Auth{
    public static function AuthUser($login,$password){
        $u = new User();
        $u->login = $login;
        $u->plainPassword = $password;
        if ($u->authenticate()){
            if(!Session::VerifySession()){
                Session::Create();
            }
            $_SESSION[SESSION_USER] = $u;
            return true;
        }else{
            return false;
        }
    }
}