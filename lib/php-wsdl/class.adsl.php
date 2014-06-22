<?php

require_once '../../config/config.php';
require_once '../../xdsl/classes/DB.php';
require_once('../../xdsl/classes/Model.php');
use xdsl\classes\Model;
use xdsl\classes\DB;
use apps\core\Config;

if(basename($_SERVER['SCRIPT_FILENAME'])==basename(__FILE__))
	exit;

class Adsl{
	/**
	 * getAdslServicesInfoFromLine
	 *
	 * @param integer $org_id
	 * @param string $line
     *
     * @return object
	 */
	public function getAdslServicesInfoFromLine($org_id, $line){

		$database = array ('user' => 'iwaymonitor', 'pass' => 'iwjaja', 'sid' => 'QW_GT');

		$db    = DB::getInstance($database);
		$model = new Model($db);

		$rows = $model->getAdslServicesInfoFromLine($org_id, $line);
		if (array_key_exists(0, $rows))
		{
			$rows = $rows[0];
		}

		return $rows;

	}

}
