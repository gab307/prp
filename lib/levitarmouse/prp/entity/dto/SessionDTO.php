<?php
/*
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */

namespace levitarmouse\prp\entity\dto;

/**
 * Description of UserDTO
 *
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */
class SessionDTO extends \levitarmouse\orm\dto\EntityDTO
{
//    public $oDb;
//    public $oLogger;
    public $sessionId;
//    public $userId;
//    public $sHttpSessionId;
//    public $sIp;

    function __construct($oDB, $oLogger, $iSessionId = null
//        , $iUserId = null,
    /* $sHttpSessionId = '', */
//        $sIp = null
        )
    {
        parent::__construct($oDB, $oLogger);

//        $this->oDb        = $oDb;
        $this->sessionId = $iSessionId;
//        $this->userId    = $iUserId;
//        $this->sHttpSessionId = $sHttpSessionId;
//        $this->sIp        = $sIp;
    }

}
