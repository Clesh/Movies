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
    const CONTROLLER_BASE_PATH = 'controllers/';
    protected $config;

    function __construct($configPath)
    {
        $this->loadConfig($configPath);
    }

    public function processUrl()
    {
        $url = $this->getUrl();
        $method = $this->getMethod();
        $controllerName = '';
        $params = array();

        /** @var $route Route */
        foreach ($this->config as $route)
        {
            if(!($tmpParams = $route->processPath($url,$method)))
                continue;

            $controllerName = $route->getControllerName();
            $params = $tmpParams;
            break;
        }

        $controller = $this->loadController($controllerName);
        return call_user_func_array($controller,$params);
    }

    protected function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    protected function getUrl()
    {
        $url = $_GET['customUrl'];
        //$url = ltrim($url,'api/');
        $url = trim($url,'/');
        return $url;
    }

    protected function loadConfig($path)
    {
        $configArray=json_decode(file_get_contents($path));
        $config=array();
        $this->walkObjectProperties($configArray,function($value, $key)use(&$config){
            if(!isset($value->url) || !isset($value->controller) || !isset($value->method))
                return;
            $config[] = new Route($value->url,$value->controller,$value->method);
        });

        $this->config = $config;
    }

    protected function walkObjectProperties($obj,$cb,$key = null)
    {
        if (is_object($obj))
        {
            foreach ($obj as $x => $value)
            {
                $this->walkObjectProperties($value, $cb, $x);
            }
        }
        else
            return;

        if($key)
            $cb($obj,$key);
    }

    /**
     * @param $controllerName
     * @return string
     */
    protected function processControllerPath($controllerName)
    {
        $controllerPath = $this::CONTROLLER_BASE_PATH . $controllerName;
        return $controllerPath;
    }

    /**
     * @param $controllerName
     * @return callable
     * @throws \Exception
     */
    protected function loadController($controllerName)
    {
        $controllerPath = $this->processControllerPath($controllerName);
        if (!file_exists($controllerPath))
            throw new \Exception("Controller not found: path={$controllerPath}");
        /** @var $controller \Closure */
        $controller = require($controllerPath);
        return $controller;
    }
}