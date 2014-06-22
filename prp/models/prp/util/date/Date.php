<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace prpWS\util\date;
/**
 * Description of Date
 *
 * @author gprieto
 */
class Date
{
    public function getPHPDate() {
        return date('d-m-Y', mktime());
    }
}
