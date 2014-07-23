<?php
/**
 * GetByIdDTO class
 *
 * PHP version 5
 *
 * @package   ORM
 * @author    Gabriel Prieto <gab307@gmail.com>
 * @copyright 2012 LM
 * @link      LM
 */

namespace levitarmouse\orm\dto;

/**
 * GetByIdDTO class
 *
 * @package   ORM
 * @author    Gabriel Prieto <gab307@gmail.com>
 * @copyright 2012 LM
 * @link      LM
 */
class GetExpenseDTO extends EntityDTO
{
    public $purchseId;
    public $date;
    public $description;
    public $entity;
    public $category;
    public $user;
    public $store;
    public $stadistics;
    public $automatic;

    function __construct($oDB, $oLogger)
    {
        parent::__construct($oDB, $oLogger);
    }
}