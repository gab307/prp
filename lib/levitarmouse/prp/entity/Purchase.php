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
class Purchase extends \levitarmouse\orm\EntityModel
{
    public function __construct(\levitarmouse\orm\dto\GetPurchaseDTO $dto)
    {
        parent::__construct($dto);

        if ($dto->purchseId) {
            $result  = $this->oMapper->getById(new \levitarmouse\orm\dto\GetByIdDTO($dto->purchseId));
            $this->fill($result);
        }


//        if ($dto->userId) {
//            $this->oMapper->getById($dto->userId);
//        } else {
//            if ($dto->userName && $dto->hashedPassword) {
//                $rs = $this->oMapper->getByUsernameAndPassword($dto->userName, $dto->hashedPassword);
//                $this->fill($rs);
//            }
//        }
    }
}
