<?php
/**
 * LoadByCrmIdDTO class
 *
 * PHP version 5
 *
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */

/**
 * LoadByCrmIdDTO class
 *
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */
class LoadByNameDTO
{
    public $sName;

    public function __construct($sName)
    {
        $this->sName   = $sName;
    }
}