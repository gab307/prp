<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace levitarmouse\prp\entity;

use \levitarmouse\orm\dto\ModelDTO;
use \levitarmouse\orm\MapperEntityModel;

/**
 * Description of ExpenseModel
 *
 * @author gprieto
 */
class ExpensesModel extends MapperEntityModel
{
    public function __construct(ModelDTO $dto)
    {
        parent::__construct($dto);
    }

    public function getExpenses($params)
    {
        $query = <<<QUERY
            SELECT
            from_unixtime(pur.date) date,
            pur.purchase_id, pur.description,
            users.user_name,
            str.store_name,
            ent.entity_name,
            cat.category_name
             FROM prp.purchases  pur
            JOIN prp.users users ON users.user_id = pur.user_id
            JOIN prp.stores str ON str.store_id = pur.store_id
            JOIN prp.entity ent ON ent.entity_id = pur.entity_id
            JOIN prp.category cat ON cat.category_id = pur.category_id
            order by pur.date asc
QUERY;

        $result = $this->prepareAndSelect($query, $params);
        $count = count($result);
        return $result;
    }

}
