<?php
require_once(__DIR__.'/User.php');
require_once(__DIR__.'/MLAccount.php');
require_once(__DIR__.'/StatusAnuncio.php');

class CopiaConta{
    public $id;
    public $contaDe;
    public $contaPara;
    public $offset;
    public $limit;
    public $pid;
    public $status;
}