<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\prp\entity;

/**
 * Description of User
 *
 * @author gprieto
 */
class User extends \levitarmouse\orm\EntityModel
{
    public function __construct(dto\UserDTO $dto)
    {
        parent::__construct($dto);

        if ($dto->userId) {
            $this->oMapper->getById($dto->userId);
        } else {
            if ($dto->userName && $dto->hashedPassword) {
                $rs = $this->oMapper->getByUsernameAndPassword($dto->userName, $dto->hashedPassword);
                $this->fill($rs);
            }
        }
    }
}
