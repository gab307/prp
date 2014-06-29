<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\orm\dto;

/**
 * Description of OrderByDTO
 *
 * @author gprieto
 */
class OrderByDTO
{
    CONST ASC = 'ASC';
    CONST DESC = 'DESC';
    
    public $asc;
    public $desc;

    function __construct()
    {

    }
}
