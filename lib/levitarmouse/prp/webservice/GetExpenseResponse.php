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
 * @pw_complex ExpenseArray $expenses Expenses
 *
 * @pw_complex GetExpenseResponse
 */
class GetExpenseResponse
{
    public $expenses;

    public function __construct()
    {
        $this->expenses = array();
    }

    public function addExpense($expense)
    {
        $this->expenses[] = $expense;
    }
}
