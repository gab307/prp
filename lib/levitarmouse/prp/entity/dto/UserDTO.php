<?php

namespace levitarmouse\prp\entity\dto;

class UserDTO extends \levitarmouse\orm\dto\EntityDTO
{
    public $userId;
    public $userName;
    public $hashedPassword;

    function __construct($oDB, $oLogger, $userId, $userName, $hashedPassword)
    {
        parent::__construct($oDB, $oLogger);

        $this->userId = $userId;
        $this->userName = $userName;
        $this->hashedPassword = $hashedPassword;
    }
}
