<?php
/**
 * TvLogger class
 *
 * PHP version 5
 *
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */

/**
 * TvLogger class
 *
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */
class Logger
{
    private $_oLogger;
    private $_aTrace;

    public function __construct()
    {
//        $find           = iwt_finder();
//        $this->_oLogger = $find->any('IWT_Logger');
    }

    public function logInfo($sLog = '')
    {
        $this->_append($sLog, 0);
    }

    public function logWarning($sLog = '')
    {
        $this->_append($sLog, 1);
    }

    public function logError($sLog = '')
    {
        $this->_append($sLog, 2);
    }

    public function logDebug($sLog = '')
    {
        $this->_append($sLog, 3);
    }

//    public function logTroubleshooting($sLog = '')
//    {
//        if (TvConfig::LOG_TROUBLESHOOTING) {
//            $this->_append('TROUBLESHOOTING '.$sLog, 3);
//        }
//    }
//
    public function logDetectChanges($sLog = '')
    {
//        if (TvConfig::LOG_DETECT_CHANGES) {
            $this->_append('DETECT_CHANGES '.$sLog, 3);
//        }
    }

    private function _append($sLog, $iLevel = 0)
    {
        $this->_aTrace = debug_backtrace();

        switch ($iLevel) {
            default:
            case 0:
                $sLevel = "INFO";
                break;
            case 1:
                $sLevel = "WARNING";
                break;
            case 2:
                $sLevel = "ERROR";
                break;
            case 3:
                $sLevel = "DEBUG";
                break;
        }

        $sLogger = ROOT_PATH.'logs/prpWs-logger-messages.log';
        $sString = "[{$sLevel}]-[".mktime()."]->$sLog\n";
        error_log($sString, 3, $sLogger);
        return;
    }
}