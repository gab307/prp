<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\core\database;

/**
 * Description of DB
 *
 * @author gabriel
 */
class Database
{
    public  $oDb;

    public function __construct($oProxy) {
        $this->oDb = $oProxy;
    }

    public function selectWithBindings($sSql, $aBindings)
    {
        foreach ($aBindings as $key => $value) {
            $bLike = strlen(strstr($value, '{{LIKE}}')) > 1;
            if ($bLike) {
                $value = str_replace('{{LIKE}}', '%', $value);
            }
            $sSql = str_replace(':'.$key, "'".$value."'", $sSql);
        }

        $aReturn = $this->oDb->select($sSql);
        return $aReturn;
    }

    public function select($sQuery)
    {
        $aReturn = $this->oDb->select($sQuery);
        return $aReturn;
    }

    public function executeWithBindings($sSql, $aBindings)
    {
        foreach ($aBindings as $key => $value) {
            $sSql = str_replace(':'.$key, "'".$value."'", $sSql);
        }

        $aReturn = $this->oDb->execute($sSql);
        return $aReturn;
    }

    public function execute($sQuery)
    {
        $aReturn = $this->oDb->execute($sQuery);
        return $aReturn;
    }
}