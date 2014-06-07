<?php

use core\router\Router;

$autoloadFun = require 'core/autoload/autoload.php';

spl_autoload_register($autoloadFun);

$o = new Router();
echo $o->parseUrl();

echo $_GET['customUrl'];


