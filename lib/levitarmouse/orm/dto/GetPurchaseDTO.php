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
class GetPurchaseDTO extends EntityDTO
{
    public $purchseId;
    public $date;
    public $description;
    public $entityId;
    public $categoryId;
    public $userId;
    public $storeId;
    public $stadistics;
//    public $installments;
    public $automatic;
//    public $deleted;

//    function __construct($oDB, $oLogger, $purchseId, $userId)
    function __construct($oDB, $oLogger)
    {
        parent::__construct($oDB, $oLogger);
//        $this->purchseId = $purchseId;
//        $this->userId    = $userId;
    }

}