<?php

use core\router\Route;
use core\router\Router;

$autoloadFun = require 'core/autoload/autoload.php';

spl_autoload_register($autoloadFun);

$o = new Router('config.json');
echo $o->processUrl();

//$route = new Route('professions/{cat}/cle/{id}.{format}', 'prof', 'GET');
//$a=$route->processPath('professions/trolol/1.json','GET');
//$a=$route->processPath('professions/trolol/cle/1.json', 'GET');



//echo $_GET['customUrl'];


