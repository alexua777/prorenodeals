<?php

/*
 * Sample bootstrap file.
 */

// Include the composer autoloader
if(!file_exists(__DIR__ .'/vendor/autoload.php')) {
	echo "The 'vendor' folder is missing. You must run 'composer update --no-dev' to resolve application dependencies.\nPlease see the README for more information.\n";
	exit(1);
}


require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/common.php';

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

$apiContext = getApiContext();


/**
 * Helper method for getting an APIContext for all calls
 *
 * @return PayPal\Rest\ApiContext
 */
function getApiContext() {
	
	// ### Api context
	// Use an ApiContext object to authenticate 
	// API calls. The clientId and clientSecret for the 
	// OAuthTokenCredential class can be retrieved from 
	// developer.paypal.com

	$apiContext = new ApiContext(
		new OAuthTokenCredential(
			'Ae_VPxBHf_yFXZyOYrmEHxk6jgN3IcI6EQYumMgVJ-Mkq4vzNIlcbVbzmg2A',
			'EEpt_RAnJ87WRxugGz6H30BqH5EZ-Aq5xwKFyWBBaSu7AyXZbgYIOZrEMWus'
			/*'Af708xCNjwaE-vwXvs0gZM_pqa0y2amQJVR4Rei3OwIhB85N5zz_FdQGqij2',
			'EHDi7RB6RAWyNUB7ahHJo3xiXDYkg8xTWMKMCu89QJLSUQiAq59z0afN9vf9'*/
		)
	);



	// #### SDK configuration
	
	// Comment this line out and uncomment the PP_CONFIG_PATH
	// 'define' block if you want to use static file 
	// based configuration

	$apiContext->setConfig(
		array(
			'mode' => 'sandbox',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => true,
			'log.FileName' => '../PayPal.log',
			'log.LogLevel' => 'FINE'
		)
	);
	
	/*
	// Register the sdk_config.ini file in current directory
	// as the configuration source.
	if(!defined("PP_CONFIG_PATH")) {
		define("PP_CONFIG_PATH", __DIR__);
	}
	*/

	return $apiContext;
}
