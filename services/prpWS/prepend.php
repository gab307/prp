<?php

define('WS_ROOT', '/var/www/working_copies/trunk/gprieto_analisis_refactor_WS_v3/');

function __xdebug_stop()
{
    $data = xdebug_get_code_coverage();
    xdebug_stop_code_coverage();

    $dir = WS_ROOT.'code_coverage/';
    $file = sprintf('%s.code_coverage', $dir.microtime());
    $bytes = file_put_contents($file, serialize($data), FILE_APPEND);
}

if (function_exists('xdebug_start_code_coverage'))
{
//    xdebug_start_code_coverage(XDEBUG_CC_DEAD_CODE);
    xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
//    xdebug_start_code_coverage(XDEBUG_CC_DEAD_CODE);
//    xdebug_start_code_coverage(XDEBUG_CC_UNUSED);
//    xdebug_start_code_coverage();
    register_shutdown_function('__xdebug_stop');
}

?>
