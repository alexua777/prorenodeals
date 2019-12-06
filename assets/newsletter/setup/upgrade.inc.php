<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright 2009 Silentweb [http://www.silentweb.ca]. All Rights Reserved.

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in licence.html
	$Id: upgrade.inc.php 529 2011-03-21 02:39:04Z matt.simpson $
*/

if (!defined("IN_SETUP")) exit;

$PAGE = (int) ((isset($_GET["p"])) ? trim($_GET["p"]) : 1);

// Error Checking
switch ($PAGE) {
	case 3 :
		if (!isset($_GET["refresh"])) {
			if ((!$_POST["previous_version"]) || (!in_array($_POST["previous_version"], $PREVIOUS_VERSIONS))) {
				$ERROR++;
				$ERRORSTR[]	= "You have not provided a valid previous version to upgrade from. Please go back and choose your current version of ListMessenger to upgrade from.";
				$PAGE = 2;
			} else {
				/*
					This will be changed to ADOdb's XML schema.
				*/
				if ($LMDATABASE["upgrade"][$_POST["previous_version"]]["new"] != "") {

					// PREFERENCES CONTENT
					$query	= "ALTER TABLE `".TABLES_PREFIX."preferences` RENAME `".TABLES_PREFIX."preferences_tmp`;";
					if ($db->Execute($query)) {
						$query		= "SELECT `preference_id`, `preference_value` FROM `".TABLES_PREFIX."preferences_tmp` ORDER BY `preference_id` ASC";
						$results	= $db->GetAll($query);
						if ($results) {
							$PREFERENCES = array();
							
							foreach ($results as $result) {
								$constant_name = @array_search($result["preference_id"], $PREFERENCE_MAP[$_POST["previous_version"]]);
								if (($constant_name) && (@constant($constant_name))) {
									$PREFERENCES[@constant($constant_name)] = str_replace("\\\\", "\\", addslashes($result["preference_value"]));
								}
							}

							/**
							 * Change the password to the MD5 hash value.
							 */
							$PREFERENCES[PREF_ADMPASS_ID] = md5($PREFERENCES[PREF_ADMPASS_ID]);
							
							// New Required Preferences (version specific).
							switch ($_POST["previous_version"]) {
								case "1.0.0" :
									// No special preferences settings required.
								break;
								case "0.9.5" :
									$PREFERENCES[REG_DOMAIN]		= checkslashes(trim($_POST["preferences"][REG_DOMAIN]));
									$PREFERENCES[PREF_PROGURL_ID]	= (($_SERVER["HTTPS"] == "On") ? "https://" : "http://").$_SERVER["HTTP_HOST"].str_replace("setup.php", "", $_SERVER["PHP_SELF"]);
									$PREFERENCES[REG_NAME]			= checkslashes(trim($_POST["preferences"][REG_NAME]));
									$PREFERENCES[REG_EMAIL]			= checkslashes(trim($_POST["preferences"][REG_EMAIL]));
									$PREFERENCES[REG_SERIAL]		= checkslashes(trim($_POST["preferences"][REG_SERIAL]));
								break;
								case "0.9.4" :
									$PREFERENCES[REG_DOMAIN]		= checkslashes(trim($_POST["preferences"][REG_DOMAIN]));
									$PREFERENCES[PREF_PROGURL_ID]	= (($_SERVER["HTTPS"] == "On") ? "https://" : "http://").$_SERVER["HTTP_HOST"].str_replace("setup.php", "", $_SERVER["PHP_SELF"]);
									$PREFERENCES[REG_NAME]			= checkslashes(trim($_POST["preferences"][REG_NAME]));
									$PREFERENCES[REG_EMAIL]			= checkslashes(trim($_POST["preferences"][REG_EMAIL]));
									$PREFERENCES[REG_SERIAL]		= checkslashes(trim($_POST["preferences"][REG_SERIAL]));
								break;
								case "0.9.3" :
									$PREFERENCES[REG_DOMAIN]		= checkslashes(trim($_POST["preferences"][REG_DOMAIN]));
									$PREFERENCES[PREF_PROGURL_ID]	= (($_SERVER["HTTPS"] == "On") ? "https://" : "http://").$_SERVER["HTTP_HOST"].str_replace("setup.php", "", $_SERVER["PHP_SELF"]);
									$PREFERENCES[REG_NAME]			= checkslashes(trim($_POST["preferences"][REG_NAME]));
									$PREFERENCES[REG_EMAIL]			= checkslashes(trim($_POST["preferences"][REG_EMAIL]));
									$PREFERENCES[REG_SERIAL]		= checkslashes(trim($_POST["preferences"][REG_SERIAL]));
								break;
								case "0.5.0" :
									$PREFERENCES[REG_DOMAIN]		= checkslashes(trim($_POST["preferences"][REG_DOMAIN]));
									$PREFERENCES[PREF_PROGURL_ID]	= (($_SERVER["HTTPS"] == "On") ? "https://" : "http://").$_SERVER["HTTP_HOST"].str_replace("setup.php", "", $_SERVER["PHP_SELF"]);
									$PREFERENCES[REG_NAME]			= checkslashes(trim($_POST["preferences"][REG_NAME]));
									$PREFERENCES[REG_EMAIL]			= checkslashes(trim($_POST["preferences"][REG_EMAIL]));
									$PREFERENCES[REG_SERIAL]		= checkslashes(trim($_POST["preferences"][REG_SERIAL]));
								break;
							}

							// Get and process the query from databases.inc.php
							$search = array();
							$replace = array();
							$lmdb = $LMDATABASE["upgrade"][$_POST["previous_version"]]["new"];

							foreach ($PREFERENCES as $preference_id => $preference_value) {
								$id = @count($search);
								$search[$id] = "%preferences[".$preference_id."]%";
								$replace[$id] = checkslashes(trim($preference_value));
							}

							$id = count($search);
							$search[$id] = "%TABLES_PREFIX%";
							$replace[$id] = TABLES_PREFIX;

							$id = count($search);
							$search[$id] = "%TABLES_ENGINE%";
							$replace[$id] = (defined("TABLES_ENGINE") ? TABLES_ENGINE : "MyISAM");

							$lmdb = str_replace($search, $replace, $lmdb);
							$lmdb = str_replace("\r", "\n", $lmdb);
							$lmdb = trim(str_replace("\n\n", "\n", $lmdb));
							$queries = explode("\n", $lmdb);

							foreach ($queries as $query) {
								if ($query != "") {
									if (!$db->Execute(trim($query))) {
										$ERROR++;
										$ERRORSTR[]	= "Unable to execute this database query. Your database server responded with: ".$db->ErrorMsg();
										$PAGE		= 2;
									}
								}
							}

							if (!$ERROR) {
								// VERSION SPECIFIC UPGRADES
								switch ($_POST["previous_version"]) {
									case "1.0.0" :
										require_once(dirname(__FILE__)."/versions/1.0.0.inc.php");
									break;
									case "0.9.5" :
										require_once(dirname(__FILE__)."/versions/0.9.5.inc.php");
									break;
									case "0.9.4" :
										require_once(dirname(__FILE__)."/versions/0.9.4.inc.php");
									break;
									case "0.9.3" :
										require_once(dirname(__FILE__)."/versions/0.9.3.inc.php");
									break;
									case "0.5.0" :
										require_once(dirname(__FILE__)."/versions/0.5.0.inc.php");
									break;
								}

								if (!$ERROR) {
									$lmdb = $LMDATABASE["upgrade"][$_POST["previous_version"]]["cleanup"];
									$lmdb = str_replace("%TABLES_PREFIX%", TABLES_PREFIX, $lmdb);
									$lmdb = str_replace("\r", "\n", $lmdb);
									$lmdb = trim(str_replace("\n\n", "\n", $lmdb));
									$queries = explode("\n", $lmdb);

									foreach ($queries as $query) {
										if ($query != "") {
											if (!$db->Execute(trim($query))) {
												$NOTICE++;
												$NOTICESTR[] = "Unable to execute a database query. Your database server responded with: ".$db->ErrorMsg();
											}
										}
									}

									$SUCCESS++;
									$SUCCESSSTR[] = "You have successfully upgraded to ListMessenger ".VERSION_TYPE." ".VERSION_INFO;
								}

							} else {
								$query = "ALTER TABLE `".TABLES_PREFIX."preferences_tmp` RENAME `".TABLES_PREFIX."preferences`;";
								if ($db->Execute($query)) {
									$SUCCESS++;
									$SUCCESSSTR[] = "Successfully restored your old preferences table.";
								}
							}

						} else {
							// Fatal error, get out of here.
						}
					} else {
						// Fatal error, get out of here.
					}

					if (@function_exists("fsockopen")) {
						if (!$ERROR) {
							require_once("./includes/classes/talkback/class.talkback.php");

							$talk = array();
							$talk["full_name"] = $PREFERENCES[REG_NAME];
							$talk["email_address"] = $PREFERENCES[REG_EMAIL];
							$talk["domain_name"] = $PREFERENCES[REG_DOMAIN];
							$talk["age"] = $_POST["age"];
							$talk["serial_number"] = $PREFERENCES[REG_SERIAL];
							$talk["version_number"]	= VERSION_INFO;
							$talk["version_type"] = VERSION_TYPE;
							$talk["server_admin"] = $_SERVER["SERVER_ADMIN"];
							$talk["server_ip"] = $_SERVER["SERVER_ADDR"];
							$talk["server_host"] = $_SERVER["HTTP_HOST"];
							$talk["remote_ip"] = $_SERVER["REMOTE_ADDR"];
							if ($_POST["environment_status"] == "true") {
								$talk["php_version"] = phpversion();
								$talk["php_safemode"] = @ini_get("safe_mode");
								$talk["php_globals"] = @ini_get("register_globals");
								$talk["php_maxexec"] = @ini_get("max_execution_time");
								$talk["server_soft"] = $_SERVER["SERVER_SOFTWARE"];
								$talk["client_browser"]	= $_SERVER["HTTP_USER_AGENT"];
							}
							$talking = new TalkBack("registration", $talk);
							$result = @$talking->post();
							switch ($result) {
								case "0" :
									$NOTICE++;
									$NOTICESTR[] = "ListMessenger was unable to register with the registration server.<br /><br />ListMessenger will function normally either way, but we will give you a shiny gold star if you would be so kind as to e-mail it to us: <a href=\"mailto:talkback@listmessenger.com?subject=Registration\">talkback@listmessenger.com</a>.\n";
								break;
								case "1" :
									// Successful Registration
									$SUCCESS++;
									$SUCCESSSTR[] = "You have successfully registered your installation of ListMessenger with our registration server. Thank you very much and we hope you enjoy our product!";
								break;
								case "2" :
									$NOTICE++;
									$NOTICESTR[] = "Thank you for re-submitting your registration information; we have successfully received it.\n";
								break;
								case "666" :
									$ERROR++;
									$ERRORSTR[]	= "Please remove this attempted installation of ListMessenger from this system immediately, as some data provided to us has been black-listed by our administrators. This issue may stem from previous ListMessenger abuse, compalints or a licence infringement.<br /><br />If you believe you have received this message in error, we sincerely apologize for the inconvenience and would happy to discuss the matter with you; please contact <a href=\"mailto:talkback@listmessenger.com\">talkback@listmessenger.com</a> for more information.";
									$PAGE		= 2;
								break;
								default :
									$NOTICE++;
									$NOTICESTR[] = "ListMessenger was unable to register with the registration server.<br /><br />ListMessenger will function normally either way, but we will give you a shiny gold star if you would be so kind as to e-mail it to us: <a href=\"mailto:talkback@listmessenger.com?subject=Registration\">talkback@listmessenger.com</a>.\n";
								break;
							}
						}
					} else {
						$NOTICE++;
						$NOTICESTR[] = "ListMessenger was unable to register with the registration server because your hosting provider or server administrator has disabled PHP's fsockopen() function.<br /><br />ListMessenger will function normally either way, but we will give you a shiny gold star if you would be so kind as to e-mail it to us: <a href=\"mailto:talkback@listmessenger.com?subject=Registration\">talkback@listmessenger.com</a>.\n";
					}

				} else {
					$ERROR++;
					$ERRORSTR[]	= "It appears as though the ListMessenger database embedded into this file is corrupt or non-existent. Please try unpacking the ListMessenger distribution again.";
					$PAGE = 2;
				}
			}
		}
	break;
	case 2 :
	case 1 :
	default :
		if ((!$_POST["previous_version"]) || (!in_array($_POST["previous_version"], $PREVIOUS_VERSIONS))) {
			$ERROR++;
			$ERRORSTR[]	= "You have not provided a valid previous version to upgrade from. Please go back and choose your current version of ListMessenger to upgrade from.";
			$PAGE = 1;
		}
	break;
}

// Display Page
switch ($PAGE) {
	case 3 :
		$PASSED = true;
		?>
		<?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
		<?php echo (($NOTICE) ? display_notice($NOTICESTR) : ""); ?>
		<?php echo (($SUCCESS) ? display_success($SUCCESSSTR) : ""); ?>
		<h2>Upgrade Successful</h2>
		You have successfully upgraded to ListMessenger <?php echo VERSION_TYPE." ".VERSION_INFO ?>. One final step is setting up a few directory permissions so as ListMessenger is able to read and write some important data such as backups, restores, imports, exports, etc.
		<br /><br />
		<h2>Directory Permissions</h2>
		<ul class="setup">
		<?php
		if (!@is_writable($LMDIRECTORY."private/backups/")) {
			$PASSED	= false;
			echo "<li class=\"error-message\">\n";
			echo "	ListMessenger Directory: private/backups is <strong style=\"color: #CC0000\">not writable</strong>.\n";
			echo "	<div class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px; margin-top: 5px\">chmod 777 ".$LMDIRECTORY."private/backups/</div>";
			echo "</li>\n";
		} else {
			echo "<li class=\"success-message\">\n";
			echo "	ListMessenger Directory: private/backups is <strong style=\"color: #669900\">writable</strong>.\n";
			echo "</li>\n";
		}

		if (!@is_writable($LMDIRECTORY."private/logs/")) {
			$PASSED	= false;
			echo "<li class=\"error-message\">\n";
			echo "	ListMessenger Directory: private/logs is <strong style=\"color: #CC0000\">not writable</strong>.\n";
			echo "	<div class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px; margin-top: 5px\">chmod 777 ".$LMDIRECTORY."private/logs/</div>";
			echo "</li>\n";
		} else {
			echo "<li class=\"success-message\">\n";
			echo "	ListMessenger Directory: private/logs is <strong style=\"color: #669900\">writable</strong>.\n";
			echo "</li>\n";
		}

		if (!@is_writable($LMDIRECTORY."private/tmp/")) {
			$PASSED	= false;
			echo "<li class=\"error-message\">\n";
			echo "	ListMessenger Directory: private/tmp is <strong style=\"color: #CC0000\">not writable</strong>.\n";
			echo "	<div class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px; margin-top: 5px\">chmod 777 ".$LMDIRECTORY."private/tmp/</div>";
			echo "</li>\n";
		} else {
			echo "<li class=\"success-message\">\n";
			echo "	ListMessenger Directory: private/tmp is <strong style=\"color: #669900\">writable</strong>.\n";
			echo "</li>\n";
		}

		if (!@is_writable($LMDIRECTORY."public/files/")) {
			$PASSED	= false;
			echo "<li class=\"error-message\">\n";
			echo "	ListMessenger Directory: public/files is <strong style=\"color: #CC0000\">not writable</strong>.\n";
			echo "	<div class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px; margin-top: 5px\">chmod 777 ".$LMDIRECTORY."public/files/</div>";
			echo "</li>\n";
		} else {
			echo "<li class=\"success-message\">\n";
			echo "	ListMessenger Directory: public/files is <strong style=\"color: #669900\">writable</strong>.\n";
			echo "</li>\n";
		}

		if (!@is_writable($LMDIRECTORY."public/images/")) {
			$PASSED	= false;
			echo "<li class=\"error-message\">\n";
			echo "	ListMessenger Directory: public/images is <strong style=\"color: #CC0000\">not writable</strong>.\n";
			echo "	<div class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px; margin-top: 5px\">chmod 777 ".$LMDIRECTORY."public/images/</div>";
			echo "</li>\n";
		} else {
			echo "<li class=\"success-message\">\n";
			echo "	ListMessenger Directory: public/images is <strong style=\"color: #669900\">writable</strong>.\n";
			echo "</li>\n";
		}
		?>
		</ul>

		<form action="./setup.php?step=5&type=upgrade&p=3&refresh" method="GET">
		<table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
		<tr>
			<td colspan="2" style="text-align: right; border-top: 2px #CCC solid; padding-top: 5px">
				<?php
				if ($PASSED) {
					echo "<input type=\"button\" value=\"Completed\" class=\"button\" onclick=\"window.location='./index.php'\" />\n";
				} else {
					echo "<input type=\"button\" value=\"Refresh\" class=\"button\" onclick=\"window.location='./setup.php?step=5&type=new&p=3&refresh'\" />\n";
					echo "<input type=\"button\" value=\"Skip\" class=\"button\" onclick=\"window.location='./index.php'\" />\n";
				}
				?>
			</td>
		</tr>
		</table>
		</form>
		<?php
	break;
	case 2 :
	case 1 :
	default :
		$AUTHCODE = md5(time());
		?>
		<?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
		<?php echo (($NOTICE) ? display_notice($NOTICESTR) : ""); ?>
		<?php echo (($SUCCESS) ? display_success($SUCCESSSTR) : ""); ?>
		<form action="setup.php?step=5&type=upgrade&p=3" method="POST">
		<input type="hidden" name="preferences[<?php echo REG_SERIAL ?>]" value="<?php echo html_encode($AUTHCODE) ?>" />
		<input type="hidden" name="preferences[<?php echo REG_DOMAIN ?>]" value="<?php echo html_encode($DOMAIN) ?>" />
		<input type="hidden" name="preferences[<?php echo REG_NAME ?>]" value="<?php echo html_encode($NAME) ?>" />
		<input type="hidden" name="preferences[<?php echo REG_EMAIL ?>]" value="<?php echo html_encode($EMAIL) ?>" />
		<input type="hidden" name="previous_version" value="<?php echo html_encode($_POST["previous_version"]); ?>" />

		<fieldset>
		<legend class="page-subheading">ListMessenger Upgrade Registration</legend>
		<table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
		<tr>
			<td style="width: 40%" class="form-row-nreq">Registered Name:</td>
			<td style="width: 60%"><input type="text" class="text-box" style="width: 250px" name="preferences[<?php echo REG_NAME; ?>]" value="<?php echo html_encode(trim($_POST["preferences"][REG_NAME])); ?>" autocomplete="off" /></td>
		</tr>
		<tr>
			<td style="width: 40%" class="form-row-req">Enter Age:</td>
			<td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="age" value="<?php echo (($ERROR) ? checkslashes(trim($_POST["age"]), 1) : ""); ?>" autocomplete="off" /></td>
		</tr>
		<tr>
			<td style="width: 40%" class="form-row-nreq">Registered E-Mail Address:</td>
			<td style="width: 60%"><input type="text" class="text-box" style="width: 250px" name="preferences[<?php echo REG_EMAIL; ?>]" value="<?php echo html_encode(trim($_POST["preferences"][REG_EMAIL])); ?>" autocomplete="off" /></td>
		</tr>
		<tr>
			<td style="width: 40%" class="form-row-nreq">Registered Domain:</td>
			<td style="width: 60%"><input type="text" class="text-box" style="width: 250px" name="preferences[<?php echo REG_DOMAIN; ?>]" value="<?php echo html_encode(trim($_SERVER["HTTP_HOST"])); ?>" autocomplete="off" /></td>
		</tr>
		<tr>
			<td style="width: 40%" class="form-row-nreq">Provide Environment Information</td>
			<td style="width: 60%"><input type="checkbox" name="environment_status" value="true"<?php echo (($ERROR) ? (($_POST["environment_status"] == "true") ? " checked=\"checked\"" : "") : " checked=\"checked\""); ?> /></td>
		</tr>
		<tr>
			<td style="width: 100%; padding-left: 5px" class="small-grey" colspan="2">
 				By having this box checked you will be sending the ListMessenger development team the following information: PHP version, PHP safe mode status, PHP register globals status, PHP max execution time, web server software and what browser you use. This information is used by our developers to see how our software is being deployed and rest assured it is not given to any third-parties.
			</td>
		</tr>
		</table>
		</fieldset>
		<div class="generic-message" style="margin-top: 15px">
			<strong>Important Note:</strong> Depending on the size of your mailing list and how much data you have in your ListMessenger database clicking &quot;Proceed&quot; may take a little while. As a benchmark a list of around 7000 testing subscribers takes roughly 60 seconds to upgrade on our development server.
		</div>
		<table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
		<tr>
			<td style="text-align: right; border-top: 2px #CCC solid; padding-top: 5px">
				<input type="submit" name="save" class="button" value="Proceed" />
			</td>
		</tr>
		</table>
		</form>
		<?php
	break;
}