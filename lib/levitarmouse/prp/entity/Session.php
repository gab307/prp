<?php
/**
 * Subscriber class
 *
 * PHP version 5
 */

namespace levitarmouse\prp\entity;

/**
 * Subscriber class
 * 
 * @param string $session_id
 * @param string $session_start
 * @param string $last_update
 * @param string $user_id
 * @param string $remote_addr
 * @param string $status
 * 
 */
class Session extends \levitarmouse\orm\EntityModel
{
    const STATUS_IDLE = null;
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    public function __construct(dto\SessionDTO $dto)
    {
        parent::__construct($dto);

        $this->session_id = $dto->sessionId;
//        $iUserId = $dto->iUserId;
//        $sIp     = $dto->sIp;
//        $token   = $dto->
//        $sHttpSessionId = $dto->sHttpSessionId;

//        $this->oMapper = SessionMapper::getInstance($this->oDb);

        try {
            if ($this->session_id) {

//                $filterDTO = new \levitarmouse\orm\dto\GetByFilterDTO();

//                $filterDTO->session_id = $sessionId;

                $this->getBySessionId($this->session_id);

//                $this->getByFilter($filterDTO);

            }



//            if ($iUserId !== '' && $sIp !== '') {
//                $aParams = array('user_id'         => $iUserId,
////                                 'http_session_id' => $sHttpSessionId,
//                                 'ip'              => $sIp);
//                $this->loadByParams($aParams);
//            }
        }
        catch (Exception $e) {
            $msg = $e->getMessage();
        }
    }

    public function getBySessionId($sessionId)
    {
        $result = $this->oMapper->getBySessionId($sessionId);

        $this->fill($result);

        return;
    }

    public function update()
    {
        $this->last_update = \levitarmouse\orm\Mapper::SQL_SYSDATE_STRING;
        $result = $this->modify();
        return;
    }

    public function isActive()
    {
        $bActive = null;
        $status = $this->status;
        if ($status == self::STATUS_ACTIVE) {
            $bActive = true;
        } else {
            $bActive = false;
        }
        return $bActive;
    }

    public function isIdle()
    {
        $bIdle = null;
        $status = $this->status;
        if ($status == self::STATUS_IDLE) {
            $bIdle = true;
        } else {
            $bIdle = false;
        }
        return $bIdle;
    }
}