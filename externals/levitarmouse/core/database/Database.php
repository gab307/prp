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

?>
