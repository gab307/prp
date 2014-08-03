<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\prp\webservice;

/**
 * Description of Response
 *
 * @author gabriel
 * 
 * @pw_element integer $errorId Error Id
 * @pw_element string $errorCode Error code
 * @pw_element string $errorDescription Error Description
 * @pw_complex Response
 */
class Response
{

    const NO_ERRORS               = 'NO_ERRORS';
    const TOKEN_IS_REQUIRED       = 'TOKEN_IS_REQUIRED';
    const VALID_TOKEN_IS_REQUIRED = 'VALID_TOKEN_IS_REQUIRED';
    const LOGIN_IS_REQUIRED = 'LOGIN_IS_REQUIRED';
    const UNAUTHORIZED_ACCESS = 'UNAUTHORIZED_ACCESS';

    private $_errors;
    public $errorId;
    public $errorCode;
    public $errorDescription;

    protected function init()
    {
        if (isset($this->_errors)) {
            return;
        }
        $this->_errors = array(self::NO_ERRORS => array('id' => 0, 'description' => ''));
        $this->_errors = array(self::TOKEN_IS_REQUIRED => array('id' => 1, 'description' => 'The token is required'));
        $this->_errors = array(self::VALID_TOKEN_IS_REQUIRED => array('id' => 2, 'description' => 'The token is invalid'));
        $this->_errors = array(self::LOGIN_IS_REQUIRED => array('id' => 3, 'description' => 'Login is required'));
        $this->_errors = array(self::UNAUTHORIZED_ACCESS => array('id' => 4, 'description' => 'Unauthorized access'));
    }

    public function setError($code)
    {
        $this->init();

        $this->errorCode        = $code;
        $this->errorId          = $this->_errors[$code]['id'];
        $this->errorDescription = $this->_errors[$code]['description'];
    }

}
