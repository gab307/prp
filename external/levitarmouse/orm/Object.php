<?php
/**
 * Object class
 *
 * PHP version 5
 *
 * @package   ORM
 * @author    Gabriel Prieto <gab307@gmail.com>
 * @copyright 2012 LM
 * @link      LM
 */

namespace levitarmouse\orm;

use \Exception;

/**
 * Object class
 *
 * @package   ORM
 * @author    Gabriel Prieto <gab307@gmail.com>
 * @copyright 2012 LM
 * @link      LM
 */
class Object
{
    public function __call($name, $arguments)
    {
        throw new Exception('ORM_ERROR_METHOD_DOES_NOT_EXIST ['.$name.']');
    }

//    public function __callStatic($name, $arguments)
//    {
//        throw new Exception('ERROR_STATIC_METHOD_DOES_NOT_EXIST ['.$name.']');
//    }

    public function __isset($name)
    {
//        throw new Exception('ERROR_PROPERTY_DOES_NOT_EXIST ['.$name.']');
//        return 'ERROR_PROPERTY_DOES_NOT_EXIST ['.$name.']';
    }

    public function __unset($name)
    {
//        throw new Exception('ERROR_PROPERTY_DOES_NOT_EXIST ['.$name.']');
//        return 'ERROR_PROPERTY_DOES_NOT_EXIST ['.$name.']';
    }
}
