<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionModel
 *
 * @author gprieto
 */
class SessionModel extends levitarmouse\orm\MapperEntityModel
{
    public function getBySessionId($sessionId)
    {
        $sSchema      = $this->getSchema();
        $sMainTable   = $this->getTableName();

        if ($sMainTable) {

            $aaFieldCompares = array();
            $aBnd = array();

            if (MYSQL) {
                $sSql = "SELECT @rownum:=@rownum+1 AS ROWNUM";
            }
            elseif (ORACLE) {
                $sSql = "SELECT ROWNUM";
            }

            foreach ($this->aFieldMapping as $classAttrib => $dbField) {

                $sTemp = " {$dbField} ";

                if (isset($this->aFieldMappingRead)) {
                    if (array_key_exists($dbField, $this->aFieldMappingRead)) {
                        $sTemp = ' ' . $this->aFieldMappingRead[$dbField] . ' ';
                    }
                }
                $sSql .= ", {$sTemp} ";

                if (isset($filterDTO->$classAttrib)) {
                    $aaFieldCompares[$dbField] = $filterDTO->$classAttrib;
                }
            }
            $tableName = ($sSchema) ? $sSchema . '.' . $sMainTable : $sMainTable;

            if (MYSQL) {
                $sFrom  = " FROM (SELECT @rownum:=0) r, {$tableName} ";
            }
            if (ORACLE) {
                $sFrom  = " FROM {$tableName} ";
            }

            $sWhere  = ' WHERE 1 = 1';
            $sWhere .= " AND session_id = :session_id ";
            $aBnd['session_id'] = $sessionId;

            $sSql .= $sFrom . $sWhere;

            // Logging
//            foreach ($aBnd as $field => $value) {
                //                $sLogValues .= @$field.'->['.$value.'] ';
//            }
            //            $this->oLogger->logDbChanges("select from {$tableName} where {$sLogValues}", 'SELECT');

            $aResult = $this->select($sSql, $aBnd);

            //            $this->oLogger->logDbChanges("result: ".serialize($aResult));

            if (is_array($aResult)) {
                return $aResult;
            }
        }
        return array();

    }
}
