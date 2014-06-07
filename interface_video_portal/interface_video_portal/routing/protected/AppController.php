<?php

use Routing\Router;

class AppController
{
    /**
     * @var \Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function homeAction()
    {
        echo self::render('home');
    }

    public function aboutAction()
    {
        echo self::render('about');
    }

    public function contactsAction()
    {
        echo self::render('contacts');
    }

    public function userAction($id)
    {
        echo self::render('user', array('id' => $id));
    }

    public function error404Action()
    {
        header("HTTP/1.0 404 Not Found");
        echo self::render('error404');
    }

    protected function request($data)
    {
        echo $data;
    }

    protected function render($template, array $vars = array())
    {
        $root = __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;

        $templatePath = $root . $template . '.php';

        if (!is_file($templatePath)) {
            throw new \InvalidArgumentException(sprintf('Template "%s" not found in "%s"', $template, $templatePath));
        }

        extract($vars);

        $router = $this->router;

        ob_start();
        ob_implicit_flush(0);

        try {
            require($templatePath);
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }
}