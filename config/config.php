<?php

if (!defined('ROOT_PATH')) {
    define("ROOT_PATH", realpath(__DIR__."/../")."/");
}
$root_path = ROOT_PATH;

if (!defined('EXTERNALS_PATH')) {
    define("EXTERNALS_PATH", ROOT_PATH.'externals/');
}
$externals_path = EXTERNALS_PATH;

if (!defined('LIB_PATH')) {
    define("LIB_PATH", ROOT_PATH.'lib/');
}
$lib_path = LIB_PATH;

if (!defined('CONFIG_PATH')) {
    define("CONFIG_PATH", ROOT_PATH.'config/');
}
$config_path = CONFIG_PATH;

if (!defined('SERVICE_PATH')) {
    define("SERVICE_PATH", ROOT_PATH.'services/');
}
$service_path = SERVICE_PATH;

//$service_assurance = SA_BASE;
//
//if (!defined('AUTOLOAD_PATH')) {
//    define('AUTOLOAD_PATH', SA_BASE.'Autoload.php');
//}
//$autoload_path = AUTOLOAD_PATH;



if (!defined('LARAVEL_PATH')) {
    define('LARAVEL_PATH', ROOT_PATH.'laravel/');
}
$laravel_path = LARAVEL_PATH;

if (!defined('LARAVEL_AUTOLOAD_PATH')) {
    define('LARAVEL_AUTOLOAD_PATH', LARAVEL_PATH.'vendor/autoload.php');
}
$laravel_autoload_path = LARAVEL_AUTOLOAD_PATH;


$aWebServicesPSR0 = array();
$aWebServicesPSR0[] = EXTERNALS_PATH;
//SERVICE_PATH.'prpWS/models',
//);

/**
 * Carga el autoloader de classes
 */
//require_once $autoload_path;

require_once 'Autoload.php';

require_once $laravel_autoload_path;
