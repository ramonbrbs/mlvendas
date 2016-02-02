<?php

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

foreach($URL_RULES as $path => $controller){
    
    reset($parameters);
    if ($parameters[key($parameters)] == $path){
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