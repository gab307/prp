<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\orm\dto;

/**
 * Description of EntityDTO
 *
 * @author gprieto
 */
class EntityDTO
{
    public $oDB;
    public $oLogger;

    function __construct($oDB = null, $oLogger = null)
    {
        $this->oDB     = $oDB;
        $this->oLogger = $oLogger;
    }
}
