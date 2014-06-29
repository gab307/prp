<?php


//class LM_Autoloader
//{
//    protected static $aPSR0Bases;
//
//    public function __construct($oConfig)
//    {
//        ;
//    }

//    public static function autoloadPSR_0($sFullClassName)
    function autoloadPSR_0($sFullClassName)
    {
        global $aWebServicesPSR0;

        if (is_array($aWebServicesPSR0)) {
            foreach ($aWebServicesPSR0 as $key => $value) {

                $aSteps = explode('\\', $sFullClassName);
                if ($aSteps) {
                    $sFile = $value.implode('/', $aSteps).'.php';

                    if (file_exists($sFile)) {
                        require_once $sFile;
                        return;
                    }
                }
            }
        }


    }

//}
spl_autoload_register('autoloadPSR_0');