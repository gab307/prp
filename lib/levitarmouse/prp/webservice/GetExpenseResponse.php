<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\prp\webservice;

/**
 * Description of GetExpenseResponse
 *
 * @author gprieto
 *
 * @pw_element integer $errorId Error Id
 * @pw_element string $errorCode Error code
 * @pw_element string $errorDescription Error Description
 * @pw_element ExpensesGroup $expensesGroup expensesGroup
 * @pw_complex GetExpenseResponse
 */
class GetExpenseResponse extends Response
{
    public $expensesGroup;

    public function __construct()
    {
        $this->expensesGroup = new ExpensesGroup();
    }

    public function addExpense($expense)
    {
        $this->expensesGroup->addExpense($expense);
    }
}
