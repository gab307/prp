<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\prp\entity;

/**
 * Description of SessionModel
 *
 * @author gprieto
 */
class UserModel extends \levitarmouse\orm\MapperEntityModel
{
    public function getByUsernameAndPassword($userName, $hashedPassword)
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
            $sWhere .= " AND user_name = :user_name ";
            $sWhere .= " AND password = :password ";

            $aBnd['user_name'] = $userName;
            $aBnd['password'] = $hashedPassword;

            $sSql .= $sFrom . $sWhere;

            // Logging
//            foreach ($aBnd as $field => $value) {
                //                $sLogValues .= @$field.'->['.$value.'] ';
//            }
            //            $this->oLogger->logDbChanges("select from {$tableName} where {$sLogValues}", 'SELECT');

            $aResult = $this->select($sSql, $aBnd);

            //            $this->oLogger->logDbChanges("result: ".serialize($aResult));

            if (is_array($aResult) && count($aResult) > 0) {
                return $aResult[0];
            }
        }
        return array();

    }
}
