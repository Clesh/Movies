<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 08.06.14
 * Time: 15:39
 */

namespace core\formatter;


/**
 * Class Formatter
 * @package core\formatter
 */
class Formatter
{
    /**
     * @var string
     */
    protected $data;
    /**
     * @var string
     */
    protected $format;

    /**
     * @param string $data
     * @param string $format
     */
    function __construct($data, $format)
    {
        $this->data = $data;
        $this->format = strtoupper($format);
    }

    /**
     * @return string
     */
    function __toString()
    {
        $output = '';
        switch($this->format)
        {
            case 'JSON':
                $output = $this->toJSON();
                break;
        }
        return $output;
    }


    /**
     * @return string
     */
    protected function toJSON()
    {
        return json_encode($this->data);
    }
}