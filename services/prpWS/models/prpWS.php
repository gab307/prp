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
class prpWS
{
    /**
     * GetPHPDate
     *
     * @return string
     */
    public function getPHPDate()
    {
        $date = new \levitarmouse\util\date\Date();

        return $date->getPHPDate();
    }

    /**
     * Hello
     *
     * @return string
     */
    public function hello()
    {
        session_start();
        $sessionId = session_id();
        $sessionId = 'g4hq1cfj4vnuluv8t8329rm421';

        $dbConfig = array(
            'dsn'           => array('host' => 'localhost', 'dbname' => 'prp'),
            'db_driver'     => 'mysql',
            'db_user'       => 'root',
            'db_password'   => 'root',
            'db_options'    => '',
            'db_attributes' => '',
        );

        $oProxy = \levitarmouse\core\database\PDOProxy::getInstance($dbConfig);
        $oDb = new levitarmouse\core\database\Database($oProxy);

//        $rs = $oDb->select('SELECT * FROM prp_user where user_id = 1');

        $sessionDto = new SessionDTO($oDb, null, $sessionId );
        $oSession = new Session($sessionDto);

        if ($oSession->exists()) {

        } else {
            $oSession->session_id = $sessionId;
            $oSession->create();
        }

        return $sessionId;
    }


    /**
     *
     * @param string $sUser      User Name
     * @param string $sSessionId SessionId
     * @param string $token      Token
     *
     * @return array $return Token
     */
    public function hello_v1()
    {
        $aDbConfig = array(
            'dsn'           => array('host' => 'localhost', 'dbname' => 'prp'),
            'db_driver'     => 'mysql',
            'db_user'       => 'root',
            'db_password'   => 'root',
            'db_options'    => '',
            'db_attributes' => '',
        );

        $oDbProxy = levitarmouse\core\database\PDOProxy::getInstance($aDbConfig);

        $oDb = new levitarmouse\core\database\Database($oDbProxy);

//        if ($token) {
//            // validate and update token
//        } else {
//            // generate and store token
//        }

        session_start();

        $aRs = $oDb->select("SELECT * FROM prp_user where user_name like '%GAB%'");

        $oDTO = new UserDTO($oDb, $sUser);
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
        $oDTO     = new SessionDTO($oDb, '', $oUser->userId, $httpSessionId, $_SERVER['REMOTE_ADDR']);
        $oSession = new Session($oDTO);

        $oResponse = new HelloReponse();

        if (!$oSession->exists() && $oUser->exists()) {
            $oSession->userId        = $oUser->userId;
            $oSession->token         = md5(microtime());
            $oSession->httpSessionId = $httpSessionId;
            $oSession->ip            = $_SERVER['REMOTE_ADDR'];
            $oSession->lastUpdate    = Config::SYSDATE_STRING;
            $oSession->create();
            $oResponse->message      = 'Bienvenido';
        }
        else {
            $oResponse->message = 'otra vez sopa';
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
    public function login($userName, $passToken)
    {

        $oHelloResponse = new LoginReponse();

        $userName = utf8_decode($userName);

        // separador = d6985f552e1f38bc02a74d36c9719de6
        $separador  = Config::SEPARADOR;
        $aPassToken = explode($separador, $passToken);

        $sSessionId = $aPassToken[0];
        $sUserPass  = $aPassToken[1];

        try {
            if ($userName == '' || $sUserPass == '') {
                throw new Exception('NICK_NAME_OR_PASSTOKEN_EMPTY');
            }

            $oDb = new DB();

            $oUserDTO = new UserDTO($oDb, $userName, $sUserPass);
            $oUser    = new User($oUserDTO);

            if ($oUser->exists()) {
                $sNewToken = md5(rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999));
                $sNewToken.= $separador . $oUser->userId;
                $sNewToken.= $separador . $sSessionId;
                $oDTO      = new SessionDTO($oDb, $sSessionId, 0, $sSessionId, $_SERVER['REMOTE_ADDR']);
                $oSession  = new Session($oDTO);

                if ($oSession->exists()) {
                    $oSession->userId = $oUser->userId;
                    $oSession->token  = $sNewToken;
                    $oSession->modify();

                    $oResponse->hello = utf8_encode('Hello ' . $oUser->realName . '!');
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
        $userName       = $userName;
        $aToken         = explode(Config::SEPARADOR, $token);
        $sOpToken       = $aToken[0];
        $iUserId        = $aToken[1];
        $sHttpSessionId = $aToken[2];
        $remoteIp       = $_SERVER['REMOTE_ADDR'];

        $oDb = new DB();

        $oSessionDTO = new SessionDTO($oDb, '', $iUserId, $sHttpSessionId, $remoteIp);
        $oSession    = new Session($oSessionDTO);

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
