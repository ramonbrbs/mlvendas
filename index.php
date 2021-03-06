<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once(__DIR__.'/urls.php');
session_start();
$parameters = explode('/', $_SERVER['REQUEST_URI']);

foreach($parameters as $k =>$p){
    $pos = strpos($p,'?');
    if ( $pos != false){
        $parameters[$k] = substr($parameters[$k],0, $pos);
    }

    if (empty($p)){
        unset($parameters[$k]);
    }
}

if (empty($parameters)){
    $parameters[0] = '';
}

$URL_RULES = Urls::$URL_RULES;
foreach($URL_RULES as $path => $controller){
    
    reset($parameters);
    if ($parameters[key($parameters)] == $path){
        $controller = new $controller;
        switch(count($parameters)){
            case 1:
                call_user_func_array(array($controller, 'Index'), array());
                break;
            default:
                reset($parameters);
                unset($parameters[key($parameters)]);
                reset($parameters);
                $method = $parameters[key($parameters)];
                unset($parameters[key($parameters)]);
                call_user_func_array(array($controller, $method ) , $parameters);
                break;
                
        }
            
    }
        

    
}