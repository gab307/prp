<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB
 *
 * @author gabriel
 */
class DB
{
    public function __construct() {
        ;
    }
    
    public function select($sQuery)
    {
        // examples
        $stmt = Database :: prepare($sQuery.';');
        $stmt->execute();
        $aReturn = $stmt->fetchAll();
        $stmt->closeCursor();
        return $aReturn;
    }
    
    public function execute($sQuery)
    {
        // examples
        $stmt = Database :: prepare($sQuery.';');
        $stmt->execute();
//        $aReturn = $stmt->fetchAll();
//        $stmt->closeCursor();
        return $aReturn;
    }
}

?>
