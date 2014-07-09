<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\core\log;

/**
 * Description of Logger
 *
 * @author gprieto
 */
class Logger implements LoggerInterface
{
    /** @var \Monolog\Logger $_logger */
    static private $_logger = null;
    static private $_ready = false;

    public function __construct($name, $file)
    {
        $this->_init($name, $file);
        return self::$_logger;
    }


    private function _init($name, $file)
    {
        if (!self::$_ready) {
            self::$_logger = new \Monolog\Logger($name);
            self::$_logger->pushHandler(new \Monolog\Handler\StreamHandler($file, \Monolog\Logger::DEBUG));
            self::$_ready = true;
        }
    }

    public function logDebug($message)
    {
        self::$_logger->addDebug($message);
    }

    public function logWarning($message)
    {
        self::$_logger->addWarning($message);
    }

    public function logNotice($message)
    {
        self::$_logger->addNotice($message);
    }

    public function logInfo($message)
    {
        self::$_logger->addInfo($message);
    }

}
