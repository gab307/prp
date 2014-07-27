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
 * @author gprieto
 */
class Entity
{
    public function __construct($values)
    {
        if ($values) {
            $this->fill($values);
        }
    }

    public function fill($item)
    {
        if (is_array($item)) {
            return $this->fillByArray($item);
        }

        if (is_object($item)) {
            return $this->fillByObject($item);
        }
    }

    protected function fillByObject($object)
    {
        if (is_object($object) && $object) {
//            $array = array();
            foreach ($object as $attrib => $value) {
                if (property_exists($this, $attrib)) {
                    $this->$attrib = $value;
                }
            }
        }
        return;
    }

    protected function fillByArray($array)
    {
        if (is_array($array) && $array) {
//            $array = array();
            foreach ($array as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
        return;
    }
}
