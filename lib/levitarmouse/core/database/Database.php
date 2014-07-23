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
//                $bLike = true;
                $value = str_replace('{{LIKE}}', '%', $value);
            }

//            if ($bLike) {
//                $sSql = str_replace('= :'.$key, "LIKE '".$value."'", $sSql);
//            } else {
                $sSql = str_replace(':'.$key, "'".$value."'", $sSql);
//            }
        }

        $aReturn = $this->oDb->select($sSql);
//        // examples
//        $stmt = Database :: prepare($sQuery.';');
//        $stmt->execute();
//        $aReturn = $stmt->fetchAll();
//        $stmt->closeCursor();
        return $aReturn;
    }

    public function select($sQuery)
    {
        $aReturn = $this->oDb->select($sQuery);
//        // examples
//        $stmt = Database :: prepare($sQuery.';');
//        $stmt->execute();
//        $aReturn = $stmt->fetchAll();
//        $stmt->closeCursor();
        return $aReturn;
    }

    public function executeWithBindings($sSql, $aBindings)
    {
        foreach ($aBindings as $key => $value) {
            $sSql = str_replace(':'.$key, "'".$value."'", $sSql);
        }

        $aReturn = $this->oDb->execute($sSql);
//        // examples
//        $stmt = Database :: prepare($sQuery.';');
//        $stmt->execute();
//        $aReturn = $stmt->fetchAll();
//        $stmt->closeCursor();
        return $aReturn;
    }

    public function execute($sQuery)
    {
        $aReturn = $this->oDb->execute($sQuery);
//        // examples
//        $stmt = Database :: prepare($sQuery.';');
//        $stmt->execute();
////        $aReturn = $stmt->fetchAll();
////        $stmt->closeCursor();
        return $aReturn;
    }
}