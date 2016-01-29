<?php

require_once(__DIR__.'/Framework/Controller.php');
require_once(__DIR__.'/Controller/index.php');

/**
 * Responsable for map PATH => CONTROLLER
 */
$URL_RULES = array(
        '' => new Index(),
    );