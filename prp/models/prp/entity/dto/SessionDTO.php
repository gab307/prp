<?php

/*
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */

/**
 * Description of UserDTO
 *
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */
class SessionDTO
{
    public $oDb;
    public $iSessionId;
    public $iUserId;
    public $sHttpSessionId;
    public $sIp;

    function __construct($oDb, $iSessionId = '', $iUserId = '', 
                         $sHttpSessionId = '', $sIp = '') {
        $this->oDb = $oDb;
        $this->iSessionId     = $iSessionId;
        $this->iUserId        = $iUserId;
        $this->sHttpSessionId = $sHttpSessionId;
        $this->sIp            = $sIp;
    }
}