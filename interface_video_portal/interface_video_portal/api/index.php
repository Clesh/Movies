<?php

use core\router\Router;

$autoloadFun = require 'core/autoload/autoload.php';

spl_autoload_register($autoloadFun);

$router = new Router('config.json');
$response = $router->processUrl();
echo $response;