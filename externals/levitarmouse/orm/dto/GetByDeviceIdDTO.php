<?php

/**
 * GetByDeviceIdDTO class
 *
 * PHP version 5
 *
 * @package   ORM
 * @author    Gabriel Prieto <gab307@gmail.com>
 * @copyright 2012 LM
 * @link      LM
 */

namespace apps\models\orm\dto;

/**
 * GetByDeviceIdDTO class
 *
 * @package   ORM
 * @author    Gabriel Prieto <gab307@gmail.com>
 * @copyright 2012 LM
 * @link      LM
 */
class GetByDeviceIdDTO
{

    public $unitAddress;
    public $serialNumber;
    public $smartCard;
    public $additionalId;

    function __construct($unitAddress, $serialNumber, $smartCard, $additionalId = '')
    {
        $this->unitAddress  = $unitAddress;
        $this->serialNumber = $serialNumber;
        $this->smartCard    = $smartCard;
        $this->additionalId = $additionalId;
    }

}

?>
