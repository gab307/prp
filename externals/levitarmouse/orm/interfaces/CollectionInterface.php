<?php
/**
 * Colection interface
 *
 * PHP version 5
 *
 * @category  FrontEnd
 * @package   ORM
 * @created   May 23, 2014
 * @author    Gabriel Prieto <gabriel.pietro@levitarmouse.com>
 * @copyright 2014 Levitarmouse
 * @license   levitarmouse http://www.levitarmouse.com
 * @link      http://www.levitarmouse.com
 *
 */

namespace levitarmouse\orm\interfaces;

use levitarmouse\orm\dto\GetByExampleDTO;
/**
 * Interface CollectionInterface
 *
 * description
 *
 * PHP version 5
 *
 * @category  FrontEnd
 * @package   ORM
 * @created   May 23, 2014
 * @author    Gabriel Prieto <gabriel.pietro@levitarmouse.com>
 * @copyright 2014 Levitarmouse
 * @license   levitarmouse http://www.levitarmouse.com
 * @link      http://www.levitarmouse.com
 *
 */
interface CollectionInterface
{
    //public function getAll(\levitarmouse\orm\dto\GetAllDTO $dto);
    public function getAll();

    public function getFiltered();

    public function getByExample(GetByExampleDTO $exampleDTO);
}
