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
 * 
 * @param string $user_id       = USER_ID
 * @param string $real_name     = REAL_NAME
 * @param string $user_name     = USER_NAME
 * @param string $mail          = MAIL
 * @param string $password      = PASSWORD
 * @param string $image         = IMAGE
 * @param string $disable       = DISABLE
 * @param string $theme_id      = THEME_ID
 * @param string $logued        = LOGUED
 * @param string $creation_date = CREATION_DATE
 * @param string $last_login    = LAST_LOGIN
 * @param string $token         = TOKEN
 */
class User extends \levitarmouse\orm\EntityModel
{
    public function __construct(dto\UserDTO $dto)
    {
        parent::__construct($dto);

        if ($dto->userId) {
            $rs = $this->oMapper->getById($dto->userId);
            $this->fill($rs);
        } else {
            if ($dto->userName && $dto->hashedPassword) {
                $rs = $this->oMapper->getByUsernameAndPassword($dto->userName, $dto->hashedPassword);
                $this->fill($rs);
            }
        }
    }
}
