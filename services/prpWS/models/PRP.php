<?php

use levitarmouse\core\database\Database;
use levitarmouse\core\database\PDOProxy;
use levitarmouse\core\encryption\Encryption;
use levitarmouse\core\log\Logger;
use levitarmouse\orm\dto\GetPurchaseDTO;
use levitarmouse\orm\Mapper;
use levitarmouse\prp\entity\dto\SessionDTO;
use levitarmouse\prp\entity\dto\UserDTO;
use levitarmouse\prp\entity\Expense;
use levitarmouse\prp\entity\Session;
use levitarmouse\prp\entity\User;
use levitarmouse\prp\webservice\Expense as Expense2;
use levitarmouse\prp\webservice\GetExpenseRequest;
use levitarmouse\prp\webservice\GetExpenseResponse;
use levitarmouse\prp\webservice\Response;
use levitarmouse\util\date\Date;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of prpWS
 *
 * @author gabriel
 */
class PRP
{

    protected $oDb;
    protected $oLogger;

    public function __construct()
    {
        $dbConfig  = array(
            'dsn'           => array('host' => 'localhost', 'dbname' => 'prp'),
            'db_driver'     => 'mysql',
            'db_user'       => 'root',
            'db_password'   => 'root',
            'db_options'    => '',
            'db_attributes' => '',
        );
        $oProxy    = PDOProxy::getInstance($dbConfig);
        $this->oDb = new Database($oProxy);

        $this->oLogger = new Logger('PRP', 'logs/messages.log');
    }

    /**
     * GetPHPDate
     *
     * @return string
     */
    public function getPHPDate()
    {
        $date = new Date();

        return $date->getPHPDate();
    }

    /**
     * Hello
     *
     * @param string $token Token
     *
     * @return object
     */
    public function hello($token)
    {
        session_start();
        if ($token) {
            $sessionId = $token;
            $bToken    = true;
        } else {
            $sessionId = session_id();
            $bToken    = false;
        }

        $sessionDto = new SessionDTO($this->oDb, $this->oLogger, $sessionId);
        $oSession   = new Session($sessionDto);

        if ($oSession->exists()) {
            $oSession->update();
        } else {
            if ($bToken) {
                $sessionId = null;
                session_destroy();
            } else {
                $oSession->session_start = Mapper::SQL_SYSDATE_STRING;
                $oSession->last_update   = Mapper::SQL_SYSDATE_STRING;
                $oSession->remote_addr   = $_SERVER['REMOTE_ADDR'];
                $oSession->status        = Session::STATUS_IDLE;
                $oSession->create();
            }
        }

        $return            = new stdClass();
        $return->sessionId = $sessionId;

        return $return;
    }

    /**
     * encryptionTest
     *
     * @param string $string
     *
     * @return object
     */
    public function encryptionTest($string)
    {
        $start      = microtime(true);
        $encryption = Encryption::encrypt($string, "123");
        //    $enc = new Illuminate\Encryption\Encrypter("123");
        $string2    = Encryption::decrypt($encryption, "123");
        //    $encryption = $enc->decrypt($encryption);
        $time       = microtime(true) - $start;

        $return         = new stdClass();
        $return->time   = $time;
        $return->encryt = $encryption;
        $return->decryt = $string2;

        return $return;
    }

    /**
     * login
     *
     * @param string $token token
     * @param string $userName  User name
     * @param string $password password
     *
     * @return LoginReponse $oResponse
     */
    public function login($token, $userName, $password)
    {
        try {

            if ($userName == '' || $password == '') {
                throw new Exception('NICK_NAME_OR_PASSTOKEN_EMPTY');
            }

            $oUserDTO = new UserDTO($this->oDb, $this->oLogger, null, $userName, $password);
            $oUser    = new User($oUserDTO);

            if ($oUser->exists()) {

                $sessionDto = new SessionDTO($this->oDb, $this->oLogger, $token);
                $oSession   = new Session($sessionDto);

                $bSessionExists   = $oSession->exists();
                $bSessionIsIdle   = $oSession->isIdle();
                $bSessionIsActive = $oSession->isActive();

                $message = '';
                if ($bSessionExists) {

                    if ($bSessionIsIdle) {
                        $oSession->session_start = Mapper::SQL_SYSDATE_STRING;
                        $oSession->last_update   = Mapper::SQL_SYSDATE_STRING;
                        $oSession->user_id       = $oUser->user_id;
                        $oSession->status        = Session::STATUS_ACTIVE;
                        $oSession->modify();

                        $message = 'Hello ' . $oUser->real_name;
                    } else if ($bSessionIsActive) {
                        $oSession->last_update = Mapper::SQL_SYSDATE_STRING;
                        $oSession->modify();
                        $message               = 'Hello ' . $oUser->real_name;
                    } else {
                        $message = 'Goodbye';
                    }
                } else {
                    $message = 'Goodbye';
                }
            } else {
                $message = 'Goodbye';
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        $oLoginResponse          = new LoginReponse();
        $oLoginResponse->message = utf8_encode($message);
        return $oLoginResponse;
    }

    /**
     * logout
     *
     * @param string $token token
     *
     * @return LoginReponse $oResponse
     */
    public function logout($token)
    {
        if (!$token) {
            return;
        }

        try {
            $sessionDto = new SessionDTO($this->oDb, $this->oLogger, $token);
            $oSession   = new Session($sessionDto);

            if ($oSession->exists()) {
                $oSession->last_update = Mapper::SQL_SYSDATE_STRING;
                $oSession->status      = Session::STATUS_INACTIVE;
                $oSession->modify();

                $message = 'Goodbye';

                /** eliminación de la session en el servidor * */
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(
                        session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
                    );
                }
                session_destroy();
            } else {
                $message = '';
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        $oLoginResponse          = new LoginReponse();
        $oLoginResponse->message = utf8_encode($message);
        return $oLoginResponse;
    }

    /**
     * GetExpense
     *
     * @param GetExpenseRequest $request
     *
     * @return GetExpenseResponse
     */
    public function getExpense($request)
    {
        $response = new GetExpenseResponse();
        try {
            $token = $request->token;

            if (empty($token)) {
                throw new \Exception('AUTHORITION_REQUIRED');
            }

            $sessionDto = new SessionDTO($this->oDb, $this->oLogger, $token);
            $oSession   = new Session($sessionDto);
            
            if ($oSession->exists()) {
                if ($oSession->status == Session::STATUS_ACTIVE) {
                    
                    $oUserDTO = new UserDTO($this->oDb, $this->oLogger, $oSession->user_id);
                    $oUser    = new User($oUserDTO);
                    
                    if ($oUser->exists() && $oUser->user_name == $request->user_name) {
                        
                        $params = array(
                            'category_name' => $request->category_name,
                            'entity_name'   => $request->entity_name,
                            'store_name'    => $request->store_name,
                            'user_name'     => $request->user_name
                        );

                        $dto      = new GetPurchaseDTO($this->oDb, $this->oLogger);
                        $expenses = new Expense($dto);
                        $expenses->getExpenses($params);

                        while ($return = $expenses->getNext()) {
                            //            if ($return) {
                            $expense = new Expense2($return->getAttribs());
                            $response->addExpense($expense);
                            //            }
                        }
                        $response->setError(Response::NO_ERRORS);
                    } else {
                        $response->setError(Response::UNAUTHORIZED_ACCESS);                        
                    }
                    
                } else {
                    $response->setError(Response::LOGIN_IS_REQUIRED);
                }
                
            } else {
                $response->setError(Response::VALID_TOKEN_IS_REQUIRED);                
            }

        } catch (Exception $ex) {
            $response->setError(Response::TOKEN_IS_REQUIRED);
        }

        return $response;
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
//    public function expense($userName, $token, $xml)
//    {
//        $userName       = $userName;
//        $aToken         = explode(Config::SEPARADOR, $token);
//        $sOpToken       = $aToken[0];
//        $iUserId        = $aToken[1];
//        $sHttpSessionId = $aToken[2];
//        $remoteIp       = $_SERVER['REMOTE_ADDR'];
//
//        $oDb = new DB();
//
//        $oSessionDTO = new SessionDTO($oDb, '', $iUserId, $sHttpSessionId, $remoteIp);
//        $oSession    = new Session($oSessionDTO);
//
//        if ($oSession->exists()) {
//            $oSession->lastUpdate = Config::SQL_SYSDATE_STRING;
//
//            $oDTO = new OperationRouterDTO($oDb, $oSession, $xml);
//
//            $oRouter = new OperationRouter($oDTO);
//
//            $sMessage = $oRouter->handle();
//
//
//            $oSession->modify();
//        }
//        else {
//            return 'Debes ingresar primero para poder operar';
//        }
//
//        return $sMessage;
//    }

    /**
     * MD5
     *
     * @param string $string string
     *
     * @return string
     */
    public function md5($string)
    {
        return md5($string);
    }

}
