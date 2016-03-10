<?php

require_once(__DIR__.'/Framework/Controller.php');
require_once(__DIR__.'/Controller/index.php');
require_once(__DIR__.'/Controller/contas_ml.php');
require_once(__DIR__.'/Controller/fila.php');
require_once(__DIR__.'/Controller/usuarios.php');

/**
 * Responsable for map PATH => CONTROLLER
 */
 
class Urls{
        public static $URL_RULES = array(
        '' => 'Index',
        'contas-ml' => 'Contas_ML',
        'fila' => 'Fila',
        'usuarios' => 'Usuarios'
    );
}
