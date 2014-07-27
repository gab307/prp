<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\prp\entity;

/**
 * Description of Expense
 *
 * @param ExpenseModel $oMapper Mapper
 *
 * @author gprieto
 */
class Expense extends \levitarmouse\orm\EntityModel
{
//    protected $aExpenses;

    public function __construct(\levitarmouse\orm\dto\EntityDTO $dto)
    {
        parent::__construct($dto);
//        $this->aExpenses = array();
    }

    public function getExpenses($params)
    {
        $result = $this->oMapper->getExpenses($params);

        if ($result) {
            foreach ($result as $key => $value) {
                $obj = new Expense(new \levitarmouse\orm\dto\EntityDTO());
                $obj->fill($value);
                $this->aCollection[] = $obj;
            }
        }

        return $this->aCollection;
    }
}
