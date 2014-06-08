<?php

namespace core\router;
use core\formatter\Formatter;


/**
 * Class Router
 * @package core\router
 */
class Router
{
    /**
     *
     */
    const CONTROLLER_BASE_PATH = 'controllers/';
    /**
     * @var Route[]
     */
    protected $config;

    /**
     * @param string $configPath
     */
    function __construct($configPath)
    {
        $this->loadConfig($configPath);
    }

    /**
     * @return string
     */
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
        return new Formatter(call_user_func_array($controller,$params),$params['format']);
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    protected function getUrl()
    {
        $url = $_GET['customUrl'];
        //$url = ltrim($url,'api/');
        $url = trim($url,'/');
        return $url;
    }

    /**
     * @param string $path
     */
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

    /**
     * @param mixed $obj
     * @param string $cb
     * @param null $key
     */
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
     * @param string $controllerName
     * @return string
     */
    protected function processControllerPath($controllerName)
    {
        $controllerPath = $this::CONTROLLER_BASE_PATH . $controllerName;
        return $controllerPath;
    }

    /**
     * @param string $controllerName
     * @return \Closure callable
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