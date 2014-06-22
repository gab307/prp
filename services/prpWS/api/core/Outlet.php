<?php
/**
 * Outlet class
 *
 * PHP version 5
 *
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */

/**
 * Outlet class
 *
 * @package   prpWS
 * @author    Gabriel Prieto <gabriel@levitarmouse.com>
 * @copyright Levitarmouse.com 2012
 * @link      www.levitarmouse.com
 */
class Outlet
{
    private static $_bForceReload = false;

    private static $_aInstantiatedObjects = array();

    private static $_oDb;

    /**
     * __construct
     *
     * @param object $oDb DbConnection
     *
     * @return none
     */
    protected function __construct($oDb)
    {
        self::$_oDb = $oDb;
    }

    /**
     * getInstance
     *
     * @param object $oDb DbConnection
     *
     * @return StbSpaceMapper
     */
    public static function getInstance($oDb)
    {
        static $instance;
        if ($instance === null)
        {
            $instance = new Outlet($oDb);
        }
        return $instance;
    }

    /**
     * Recupera del diccionario, el objeto buscado según el alias,
     * si no lo localiza, lo instancia, lo indexa y luego lo devuelve
     *
     * @param type $sAlias             Alias para el diccionario
     * @param type $oDTO               DTO del objeto buscado
     * @param type $sClassName         Objeto buscado
     * @param type $sOverrideAliasWith Reemplazar el alias por el valor del atributo indicado
     * @param type $sDuplicateIn       Enlazar la entrada a otro atributo para poder localizar el objeto por otro indice
     *
     * @return Instancia de $sClassName
     */
    public static function getInstanceOf($sAlias, $oDTO = null, $sClassName = '')
    {
        $defugInfo = self::$_aInstantiatedObjects;
        $wantedObject = null;
        if ($sAlias != '') {
            if (isset(self::$_aInstantiatedObjects[$sAlias.'_'.$sClassName])) {
                $wantedObject = self::$_aInstantiatedObjects[$sAlias.'_'.$sClassName];
                if ($sClassName != '') {
                    if (!($wantedObject instanceof $sClassName)) {
                        $wantedObject = null;
                    }
                }
            }
            else {
                if (class_exists($sClassName) ) {
                    if ($oDTO) {
                        $wantedObject = new $sClassName($oDTO);
                    }
                    else {
                        $wantedObject = new $sClassName();
                    }
                }

                if ($wantedObject) {
                    self::$_aInstantiatedObjects[$sAlias.'_'.$sClassName] = $wantedObject;
                }
            }
        }
        return $wantedObject;
    }

    /**
     * Agrega una instancia a la collección
     *
     * @param type $sAlias             Alias para el diccionario
     * @param type $sClassName         Objeto buscado
     *
     * @return boolean
     */
    public static function addInstanceOf($sAlias, $sClassName, $oInstance)
    {
        if ($sAlias != '' && $sClassName && is_object($oInstance) )  {
            self::$_aInstantiatedObjects[$sAlias.'_'.$sClassName] = $oInstance;
            return true;
        }
        return false;
    }
}

?>
