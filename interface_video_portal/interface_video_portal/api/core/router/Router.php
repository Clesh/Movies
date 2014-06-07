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
        $url = $_GET['customUrl'];
        // code
        /** @var $controller \Closure */
        $controller = require('controllers/images/get.php');
        return $controller('11','json');
    }
}