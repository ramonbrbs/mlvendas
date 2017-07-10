<?php

class Attribute{
    
    public $id;
    public $value_name;
    
    function __construct($i, $v) {
       $this->id=$i;
       $this->value_name = $v;
   }
}