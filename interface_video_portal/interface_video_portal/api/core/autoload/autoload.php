<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 03.06.13
 * Time: 18:01 
 */

namespace core\autoload;


use Exception;

return
/**
 *
 */
function($class_name)
{
    // удаляем ненужные символы слева
    $class_name = ltrim($class_name, '\\');


    if(empty($class_name))
        throw new Exception('Class not found');

    //$names = explode('\\', $class_name, 2);
    $path = str_replace('\\', '/', $class_name);
    $path .= '.php';

    //TODO: Подумать над исключением
    /*if(!file_exists($path))
        throw new AutoloadException($class_name);*/

    if(file_exists($path))
        require($path);
};