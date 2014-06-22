<?php

require_once('class.soapdemo.php');
require_once('class.adsl.php');

// Initialize the PhpWsdl class
require_once('class.phpwsdl.php');

if ((isset($_GET['output']) && $_GET['output'] == 'json'))
{
	if (isset($_GET['method']))
	{
		$adsl = new Adsl();

		$collectParams = false;
		$arrayParams = array();

		foreach ($_GET as $key => $val)
		{
			if ($collectParams) $arrayParams[] = $val;
			if ($key == 'method') $collectParams = true;
		}

        header('Content-type: text/json');
        header('Content-type: application/json');

		echo json_encode(call_user_func_array(array($adsl, $_GET['method']), $arrayParams));
	}
}
else
{
	$soap=PhpWsdl::CreateInstance(
		null,								// PhpWsdl will determine a good namespace
		null,								// Change this to your SOAP endpoint URI (or keep it NULL and PhpWsdl will determine it)
		'./cache',							// Change this to a folder with write access
		Array(								// All files with WSDL definitions in comments
			'class.adsl.php'
		),
		null,								// The name of the class that serves the webservice will be determined by PhpWsdl
		null,								// This demo contains all method definitions in comments
		null,								// This demo contains all complex types in comments
		false,								// Don't send WSDL right now
		false);								// Don't start the SOAP server right now

	// Disable caching for demonstration
	ini_set('soap.wsdl_cache_enabled',0);	// Disable caching in PHP
	PhpWsdl::$CacheTime=0;					// Disable caching in PhpWsdl

	// Run the SOAP server
	if($soap->IsWsdlRequested())			// WSDL requested by the client?
		$soap->Optimize=false;				// Don't optimize WSDL to send it human readable to the browser

	$soap->RunServer();						// Finally, run the server
}