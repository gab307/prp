<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\orm\interfaces;

/**
 *
 * @author gprieto
 */
interface EntityInterface
{
    public function getById(\levitarmouse\orm\dto\GetByIdDTO $dto);
}