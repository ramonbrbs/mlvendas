<?php

class Session {
    public static function Create (){
        session_unset();
        session_destroy();
        setcookie("PHPSESSID",                // Name
          session_id(),         // Value
          strtotime("+1 hour"), // Expiry
          "/");                // HTTP Only
        
        session_start();
        session_regenerate_id(true);
        $_SESSION['shash'] = sha1("trevvomaster");
        $_SESSION['USER_IP'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['TIME'] = microtime(true);
        
    }
    
    public static function VerifySession(){

        if (($_SESSION['shash'] == sha1("trevvomaster")) && ($_SESSION['USER_IP'] == $_SERVER['REMOTE_ADDR']) && ($_SESSION['USER_AGENT'] == $_SERVER['HTTP_USER_AGENT']) && ((microtime(true)-$_SESSION['TIME'])<1200)){
            
            $_SESSION['TIME'] = microtime(true);
            return true;
        }else{
            
            session_unset();
            session_destroy();
            return false;
        
        }
    }
    
    public static function Destroy(){

        session_destroy();
    }
    
    
}