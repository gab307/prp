<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\orm\dto;

/**
 * Description of GetFiltered
 *
 * @author gprieto
 */
class GetByFilterDTO extends DTO
{

    public function getFilter()
    {
        return $this->getAttribs();
    }
}
