<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of prpWS
 *
 * @author gabriel
 */
class prpWSPurchase
{
    /**
     * GetPHPDate
     *
     * @return string
     */
    public function getPHPDate()
    {
        $date = new \prpWS\util\date\Date();

        return $date->getPHPDate();
    }

    /**
     *
     * @param string $sUser      User Name
     * @param string $sSessionId SessionId
     *
     * @return array $return Token
     */
    public function hello($sUser, $sSessionId)
    {
//        return array('token' => session_id());

        $oDb = new DB();

        $oDTO = new UserDT($oDb, $sUser);
        if ($sUser == '' || $sSessionId == '') {
            $oDTO->sUserName = 'guest';
        }

        $oUser = new User($oDTO);

        if ($sSessionId == '') {
            $httpSessionId = md5(mktime());
        }
        else {
            $httpSessionId = $sSessionId;
        }
        $oDTO = new SessionDTO($oDb, '',
                               $oUser->userId,
                               $httpSessionId,
                               $_SERVER['REMOTE_ADDR']);
        $oSession = new Session($oDTO);

        $oResponse = new HelloReponse();

        if (!$oSession->exists() && $oUser->exists()) {
            $oSession->userId         = $oUser->userId;
            $oSession->token          = md5(microtime());
            $oSession->httpSessionId  = $httpSessionId;
            $oSession->ip             = $_SERVER['REMOTE_ADDR'];
            $oSession->lastUpdate     = Config::SYSDATE_STRING;
            $oSession->create();
            $oResponse->message   = 'Bienvenido';
        }
        else {
            $oResponse->message   = 'otra vez sopa';
        }

        $oResponse->token     = $oSession->token;
        $oResponse->sessionId = $oSession->httpSessionId;
        return $oResponse;
    }


    /**
     * login
     *
     * @param string $userName  User name
     * @param string $passToken Pass token
     *
     * @return LoginReponse $oResponse
     */
	public function login($userName, $passToken){

        $oHelloResponse = new LoginReponse();

        $userName = utf8_decode($userName);

        // separador = d6985f552e1f38bc02a74d36c9719de6
        $separador = Config::SEPARADOR;
        $aPassToken = explode($separador, $passToken);

        $sSessionId = $aPassToken[0];
        $sUserPass  = $aPassToken[1];

        try {
            if ($userName == '' || $sUserPass == '') {
                throw new Exception('NICK_NAME_OR_PASSTOKEN_EMPTY');
            }

            $oDb = new DB();

            $oUserDTO = new UserDTO($oDb, $userName, $sUserPass);
            $oUser = new User($oUserDTO);

            if ($oUser->exists()) {
                $sNewToken = md5(rand(1000, 9999).rand(1000, 9999).rand(1000, 9999));
                $sNewToken.= $separador.$oUser->userId;
                $sNewToken.= $separador.$sSessionId;
                $oDTO = new SessionDTO($oDb,
                                       $sSessionId,
                                       0,
                                       $sSessionId,
                                       $_SERVER['REMOTE_ADDR']);
                $oSession = new Session($oDTO);

                if ($oSession->exists()) {
                    $oSession->userId = $oUser->userId;
                    $oSession->token  = $sNewToken;
                    $oSession->modify();

                    $oResponse->hello = utf8_encode('Hello '.$oUser->realName.'!');
                    $oResponse->token = $sNewToken;
                }
                else {
                    $oResponse->hello = 'Goodbye';
                }
            }
            else {
                $oResponse->hello = 'Goodbye';
            }
        }
        catch (Exception $e) {
            $oResponse->hello = $e->getMessage();
            $oResponse->token = '';
        }

        return $oResponse;
	}

    /**
     * expense
     *
     * @param string $userName User Name
     * @param string $token    Token
     * @param string $xml      Request Information
     *
     * @return string identificador de error
     */
    public function expense($userName, $token, $xml)
    {
        $userName    = $userName;
        $aToken      = explode(Config::SEPARADOR, $token);
        $sOpToken    = $aToken[0];
        $iUserId     = $aToken[1];
        $sHttpSessionId = $aToken[2];
        $remoteIp = $_SERVER['REMOTE_ADDR'];

        $oDb = new DB();

        $oSessionDTO = new SessionDTO($oDb, '', $iUserId, $sHttpSessionId, $remoteIp);
        $oSession = new Session($oSessionDTO);

        if ($oSession->exists()) {
            $oSession->lastUpdate = Config::SQL_SYSDATE_STRING;

            $oDTO = new OperationRouterDTO($oDb, $oSession, $xml);

            $oRouter = new OperationRouter($oDTO);

            $sMessage = $oRouter->handle();


            $oSession->modify();
        }
        else {
            return 'Debes ingresar primero para poder operar';
        }

        return $sMessage;
    }
}
