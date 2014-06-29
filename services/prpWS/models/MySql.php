<?php

class MySql
{
    public function connect()
    {
        $pdo = new PDO($dsn, $username, $passwd, $options);
    }
}