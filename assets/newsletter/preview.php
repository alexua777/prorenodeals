<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright 2009 Silentweb [http://www.silentweb.ca]. All Rights Reserved.

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in licence.html
	$Id: preview.php 481 2009-11-29 16:21:11Z matt.simpson $
*/

// Setup PHP and start page setup.
	@ini_set("include_path", str_replace("\\", "/", dirname(__FILE__))."/includes");
	@ini_set("allow_url_fopen", 1);
	@ini_set("session.name", md5(dirname(__FILE__)));
	@ini_set("session.use_trans_sid", 0);
	@ini_set("session.cookie_lifetime", 0);
	@ini_set("session.cookie_secure", 0);
	@ini_set("session.referer_check", "");
	@ini_set("error_reporting",  E_ALL ^ E_NOTICE);
	@ini_set("magic_quotes_runtime", 0);

	require_once("pref_ids.inc.php");
	require_once("config.inc.php");
	require_once("classes/adodb/adodb.inc.php");
	require_once("dbconnection.inc.php");

	session_start();

	if((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) {
		if(isset($_SESSION["html_message"])) {
			echo urldecode($_SESSION["html_message"]);
		}
	}
?>
