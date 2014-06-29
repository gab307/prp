<?php
/**
 * Subscriber class
 *
 * PHP version 5
 */

/**
 * Subscriber class
 */
class Session extends levitarmouse\orm\EntityModel
{
    public function __construct(SessionDTO $dto)
    {
        parent::__construct($dto);

        $sessionId = $dto->sessionId;
//        $iUserId = $dto->iUserId;
//        $sIp     = $dto->sIp;
//        $token   = $dto->
//        $sHttpSessionId = $dto->sHttpSessionId;

//        $this->oMapper = SessionMapper::getInstance($this->oDb);

        try {
            if ($sessionId) {

                $filterDTO = new \levitarmouse\orm\dto\GetByFilterDTO();

                $filterDTO->session_id = $sessionId;

                $this->getByFilter($filterDTO);

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
}