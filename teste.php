<?php

require("Framework/Controller.php");

$c = new Controller();

var_dump(call_user_func_array(array($c, 'getname'), array()));