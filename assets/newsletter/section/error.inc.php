<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright 2009 Silentweb [http://www.silentweb.ca]. All Rights Reserved.

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in licence.html
	$Id: error.inc.php 481 2009-11-29 16:21:11Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))		exit;
if(!$_SESSION["isAuthenticated"])	exit;

if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
	@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRequested file was not found: ".$SECTION."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
}
?>
<h1>Document Not Found</h1>
The requested document was not found. Please return the to main page.