<?php

namespace levitarmouse\core\database;

class PDOProxy
{
    private static $_link = null;

    private function __construct($dbConfig)
    {
        $driver     = $dbConfig ["db_driver"];
        $dsn        = "{$driver}:";
        $user       = $dbConfig ["db_user"];
        $password   = $dbConfig ["db_password"];
        $options    = $dbConfig ["db_options"];
        $attributes = $dbConfig ["db_attributes"];

        $dsns = array();
        foreach ($dbConfig ["dsn"] as $k => $v) {
            $dsns[] = "{$k}={$v}";
        }
        $dsn = $dsn . implode(';', $dsns);

        $opciones = array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );

        self::$_link = new \PDO($dsn, $user, $password, $opciones);

//        foreach ($attributes as $k => $v) {
//            $link->setAttribute(constant("PDO::{$k}")
//                , constant("PDO::{$v}"));
//        }
        return;
    }

    private static function _init($dbConfig)
    {
        $instance = null;
        if (self :: $_link) {
            $instance = self;
        }
        else {
            $instance = new PDOProxy($dbConfig);
        }
        return $instance;
    }

    public static function getInstance($dbConfig)
    {
        $instance = self::_init($dbConfig);

        return $instance;
    }

//    public function __call($name, $args)
//    {
//        if (self::$link) {
//            $callback = array(self :: $link, $name);
//            return call_user_func_array($callback, $args);
//        }
//    }
//
//    public static function __callStatic($name, $args)
//    {
//        if (self::$link) {
//
//            return call_user_func_array($name, $args);
//        }
//    }

//    protected static functoin execute($sSql)
//    {
//
//    }

    protected static function prepare($sSql)
    {
        $link = self::$_link;
        $stmt = $link->prepare($sSql);
        return $stmt;
    }

    public function select($sQuery)
    {
        $stmt    = self::prepare($sQuery . ';');
        $stmt->execute();
        $aReturn = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $stmt    = null;
        return $aReturn;
    }

    public function execute($sQuery)
    {
        // examples
        $stmt = self :: prepare($sQuery . ';');
        $result = $stmt->execute();
//        $aReturn = $stmt->fetchAll();
//        $stmt->closeCursor();
        return $result;
    }

}
