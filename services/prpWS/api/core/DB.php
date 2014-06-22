Here is an singleton PDO example:

###### config.ini ######
db_driver=mysql
db_user=root
db_password=924892xp

[dsn]
host=localhost
port=3306
dbname=localhost

[db_options]
PDO::MYSQL_ATTR_INIT_COMMAND=set names utf8

[db_attributes]
ATTR_ERRMODE=ERRMODE_EXCEPTION
############

<?php

class Database {

    private static $link = null;

    private static function getLink() {
        if (self :: $link) {
            return self :: $link;
        }

        $ini = _BASE_DIR . "config.ini";
        $parse = parse_ini_file($ini, true);

        $driver = $parse ["db_driver"];
        $dsn = "${driver}:";
        $user = $parse ["db_user"];
        $password = $parse ["db_password"];
        $options = $parse ["db_options"];
        $attributes = $parse ["db_attributes"];

        foreach ($parse ["dsn"] as $k => $v) {
            $dsn .= "${k}=${v};";
        }

        self :: $link = new PDO($dsn, $user, $password, $options);

        foreach ($attributes as $k => $v) {
            self :: $link->setAttribute(constant("PDO::{$k}")
                    , constant("PDO::{$v}"));
        }

        return self :: $link;
    }

    public static function __callStatic($name, $args) {
        $callback = array(self :: getLink(), $name);
        return call_user_func_array($callback, $args);
    }

}