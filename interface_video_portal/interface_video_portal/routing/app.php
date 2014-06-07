<?php

require __DIR__ . '/protected/bootstrap.php';

use Routing\Router;
use Routing\MatchedRoute;

try {

    $router = new Router(GET_HTTP_HOST());
    $router->add('home', '/', 'AppController:homeAction');
    $router->add('about', '/about', 'AppController:aboutAction');
    $router->add('contacts', '/contacts', 'AppController:contactsAction');
    $router->add('user', '/user/(id:num)', 'AppController:userAction');

    $route = $router->match(GET_METHOD(), GET_PATH_INFO());

    if (null == $route) {
        $route = new MatchedRoute('AppController:error404Action');
    }

    list($class, $action) = explode(':', $route->getController(), 2);

    call_user_func_array(array(new $class($router), $action), $route->getParameters());

} catch (Exception $e) {

    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

    echo $e->getMessage();
    echo $e->getTraceAsString();
    exit;
}