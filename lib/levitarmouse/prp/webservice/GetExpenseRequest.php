<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\prp\webservice;

/**
 * Description of GetExpenseRequest
 *
 * @author gprieto
 *
 * @pw_element string $token Token
 * @pw_element string $user_name User Name
 * @pw_element string $category_name Category Name
 * @pw_element string $entity_name Entity Name
 * @pw_element string $store_name Store Name
 * @pw_element string $date Date of purchase
 * @pw_element string $description Part of purchase description
 * @pw_complex GetExpenseRequest
 */
class GetExpenseRequest
{
    public $token;
    public $user_name;
    public $category_name;
    public $entity_name;
    public $store_name;
    public $date;
    public $description;
}
