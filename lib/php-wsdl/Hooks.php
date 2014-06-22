<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hooks
 *
 * @author gprieto
 */
class Hooks
{
    public static function Login($params = null)
    {
        $user = $params['user'];
        $pass = $params['password'];

        if ($user == 'demo' && $pass == 'demo') {
            return true;
        } else {
            return false;
        }
    }


}
