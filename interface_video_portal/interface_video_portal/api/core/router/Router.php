<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 07.06.14
 * Time: 22:07
 */

namespace core\router;


class Router
{
    protected $a;

    function __construct()
    {
        $a = 10;
    }

    public function parseUrl()
    {
        $config = array();
        $config[] = new Route('professions/{id}.{format}', 'controllers/images/get.php', 'GET');
        $config[] = new Route('professions/{cat}/{id}.{format}', 'prof2', 'POST');
        $config[] = new Route('professions/{cat}/cle/{id}.{format}', 'prof3', 'GET');

        //$url = $_GET['customUrl'];
        $url = 'professions/1.json';
        $method = 'GET';
        $controllerName = '';
        $params = array();

        /** @var $route Route */
        foreach ($config as $route)
        {
            if(!($tmpParams = $route->processPath($url,$method)))
                continue;

            $controllerName = $route->getControllerName();
            $params = $tmpParams;
            break;
        }

        /** @var $controller \Closure */
        $controller = require($controllerName);
        return call_user_func_array($controller,$params);
    }
}