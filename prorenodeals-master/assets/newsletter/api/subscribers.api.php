<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright 2009 Silentweb [http://www.silentweb.ca]. All Rights Reserved.

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in licence.html
	$Id: index.php 167 2008-02-10 21:26:33Z matt.simpson $
*/

// Setup PHP and start page setup.
	@ini_set("include_path", "../includes");
	@ini_set("allow_url_fopen", 1);
	@ini_set("session.name", md5(str_replace(DIRECTORY_SEPARATOR."api", "", dirname(__FILE__))));
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
	require_once("functions.inc.php");
	
	session_start();
	
	if((isset($_SESSION["isAuthenticated"])) || ((bool) $_SESSION["isAuthenticated"])) {
		$search_limit	= 50;
		$search_term	= "";
		
		if(isset($_POST["term"])) {
			$search_term = clean_input($_POST["term"], array("trim"));
		} elseif(isset($_GET["term"])) {
			$search_term = clean_input($_GET["term"], array("trim"));
		}
		
		if (isset($_POST["limit"])) {
			$search_limit = clean_input($_POST["limit"], array("trim", "int"));
		} elseif(isset($_GET["limit"])) {
			$search_limit = clean_input($_GET["limit"], array("trim", "int"));
		}
		
		if(($search_limit < 0) || ($search_limit > 100)) {
			$search_limit = 50;
		}

		$output = array();
		if($search_term) {
			$query = "	SELECT a.`users_id`, b.`group_name`, CONCAT_WS(' ', a.`firstname`, a.`lastname`) AS `name`, a.`email_address`
						FROM `".TABLES_PREFIX."users` AS a
						LEFT JOIN `".TABLES_PREFIX."groups` AS b
						on a.`group_id` = b.`groups_id`
						WHERE CONCAT_WS(' ', a.`firstname`, a.`lastname`) LIKE ".$db->qstr("%".$search_term."%")."
						OR a.`email_address` LIKE ".$db->qstr("%".$search_term."%")."
						OR CONCAT('\"', CONCAT_WS(' ', a.`firstname`, a.`lastname`), '\" <',a.`email_address`, '>') LIKE ".$db->qstr("%".$search_term."%")."
						GROUP BY a.`users_id`
						ORDER BY b.`group_name`, a.`lastname` ASC, a.`firstname` ASC
						LIMIT 0, ".$search_limit;
			$results = $db->GetAll($query);
			if ($results) {
				foreach ($results as $result) {
					$output[] = array(
						"users_id" => (int) $result["users_id"],
						"group_name" => utf8_encode($result["group_name"]),
						"name" => utf8_encode($result["name"]),
						"email_address" => $result["email_address"]
					);
				}
			}
		}

		echo json_encode($output);
	}