<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\prp\webservice;

/**
 * Description of ExpensesGroup
 *
 * @author gprieto
 *
 * @pw_element integer $countExpenses Count Expenses
 * @pw_set minoccurs=0
 * @pw_set maxoccurs=unbounded
 * @pw_element Expense $expense Expenses
 * @pw_complex ExpensesGroup
 */
class ExpensesGroup
{
    public $countExpenses;
    public $expense;

    public function __construct()
    {
        $this->countExpenses = 0;
        $this->expense = array();
    }

    public function addExpense($expense)
    {
        $this->expense[] = $expense;
        $this->countExpenses = count($this->expense);
    }
}
