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
class UserDTO extends \prp\entity\dto\DTO
{
    public $sUserName;
    public $sUserPass;

    function __construct($oDb, $sUserName = '', $sUserPass = '')
    {
        $this->oDb = $oDb;
        $this->sUserName = $sUserName;
        $this->sUserPass = $sUserPass;
    }

}

?>
