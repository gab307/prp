<?php
// require the common configurations for all webservices

require_once '../../config/config.php';
// prpWS config file

global $aWebServicesPSR0;
$aWebServicesPSR0[] = __DIR__.'/../models/';