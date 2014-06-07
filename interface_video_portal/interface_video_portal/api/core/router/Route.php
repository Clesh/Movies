<?php


namespace core\router;


/**
 * Class Route
 * @package core\router
 */
class Route
{

    /**
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $templatePath;
    /**
     * @var string
     */
    protected $method;
    /**
     * @var string
     */
    protected $controllerName;

    /**
     * @param string $path
     * @param string $controllerName
     * @param string $method
     */
    function __construct($path, $controllerName, $method)
    {
        $this->method = $method;
        $this->controllerName = $controllerName;
        $this->path = $path;
        $this->processTemplate();
    }

    /**
     * @param string $path
     * @param string $method
     * @return bool
     */
    public function testPath($path,$method)
    {
        return (bool)preg_match($this->templatePath, $path) && $method == $this->method;
    }

    public function processParams($path)
    {
        $params = array();
        $pathArray = $this->parsePathToArray($path);
        $templateArray = $this->parsePathToArray($this->path);

        for($i = 0; $i != count($pathArray); $i++)
        {
            if(!($paramName = $this->parseParamName($templateArray[$i])))
                continue;

            $params[$paramName] = $pathArray[$i];
        }

        return $params;
    }

    protected function parseParamName($str)
    {
        if(!preg_match('/^{[0-9A-z]+}$/',$str))
            return false;

        return rtrim(ltrim($str,'{'),'}');
    }

    protected function parsePathToArray($path)
    {
        $pathParts = array();

        foreach (explode('/', $path) as $slashPart)
        {
            foreach (explode('.', $slashPart) as $pointsPart)
            {
                $pathParts[] = $pointsPart;
            }
        }

        return $pathParts;
    }

    /**
     *
     */
    protected function processTemplate()
    {
        $template = $this->path;
        $template = preg_quote($template, '/');
        $template = preg_replace('/\\\\{[0-9A-z]+\\}/i', '[0-9A-z]+', $template);
        $template = '/^' . $template . '$/';
        $this->templatePath = $template;
    }


} 