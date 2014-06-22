<?php
/**
 * Subscriber class
 *
 * PHP version 5
 */

/**
 * Subscriber class
 */
class Session extends MappedEntity
{
    protected $oMapper;

    public function __construct(SessionDTO $dto)
    {
        parent::__construct($dto->oDb);

        $iUserId = $dto->iUserId;
        $sIp     = $dto->sIp;
        $sHttpSessionId = $dto->sHttpSessionId;

        $this->oMapper = SessionMapper::getInstance($this->oDb);

        try {
            if ($iUserId !== '' && $sIp !== '') {
                $aParams = array('user_id'         => $iUserId,
                                 'http_session_id' => $sHttpSessionId,
                                 'ip'              => $sIp);
                $this->loadByParams($aParams);
            }
        }
        catch (Exception $e) {
            $msg = $e->getMessage();
        }
    }
}