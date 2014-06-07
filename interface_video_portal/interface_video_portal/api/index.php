<?php

use core\router\Route;
use core\router\Router;

$autoloadFun = require 'core/autoload/autoload.php';

spl_autoload_register($autoloadFun);

$o = new Router();
echo $o->parseUrl();

$route = new Route('professions/{id}.{json}', 'prof', 'GET');
$a=$route->testPath('professions/1.json','GET');



echo $_GET['customUrl'];


