<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright 2009 Silentweb [http://www.silentweb.ca]. All Rights Reserved.

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in licence.html
	$Id: message.inc.php 520 2011-03-11 20:58:47Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))	exit;
if(!$_SESSION["isAuthenticated"])	exit;

$COLLAPSED	= explode(",", $_COOKIE["display"]["message"]["collapsed"]);
$totalrows	= false;
$seeking	= array();
$seek		= false;
$action		= false;

switch($_GET["action"]) {
	case "copy" :
		if(strlen(trim($_POST["id"])) < 1) {
			$ERROR++;
			$ERRORSTR[] = "There was no message id found in the copy request. Please try again, but specify a message id.";
			if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
				@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tNo message id was found in the copy message request.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
			}
		}
		if(strlen(trim($_POST["title"])) < 1) {
			$ERROR++;
			$ERRORSTR[] = "There was no message title found in the copy request. Please try again, but specify a message title.";
			if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
				@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tNo new message title was found in the copy message request.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
			}
		}

		$query	= "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_title`='".checkslashes($_POST["title"])."'";
		$result	= $db->GetRow($query);
		if($result) {
			$ERROR++;
			$ERRORSTR[] = "The new message title that you have entered already exists in the database. Please try again, but specify a unique message title.";
			if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
				@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThe provided message title was non-unique.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
			}
		}

		$query	= "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes($_POST["id"])."'";
		$result	= $db->GetRow($query);
		if(!$result) {
			$ERROR++;
			$ERRORSTR[] = "The message id that was specified in the copy request could not be found in the database. Please try again, but specify a valid message id.";
			if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
				@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThe requested message id [".checkslashes($_POST["id"])."] does not exist in the database. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
			}
		}

		?>
		<h1>Copy Message</h1>
		<?php
		if(!$ERROR) {
			$query	= "INSERT INTO `".TABLES_PREFIX."messages` (`message_id`, `message_date`, `message_title`, `message_subject`, `message_from`, `message_reply`, `message_priority`, `text_message`, `text_template`, `html_message`, `html_template`, `attachments`) VALUES (NULL, '".time()."', '".trim(checkslashes($_POST["title"]))."', '".addslashes($result["message_subject"])."', '".addslashes($result["message_from"])."', '".addslashes($result["message_reply"])."', '".addslashes($result["message_priority"])."', '".addslashes($result["text_message"])."', '', '".addslashes($result["html_message"])."', '', '');";
			if($db->Execute($query)) {
				$ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".$db->Insert_Id()."\'', 5000)";

				$SUCCESS++;
				$SUCCESSSTR[] = "You have successfully copied <strong>".html_encode(checkslashes($_POST["title"], 1))."</strong>.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=message&action=view&id=".$db->Insert_Id()."\">click here</a> if you prefer not to wait.";

				echo display_success($SUCCESSSTR);
			} else {
				$ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".$_POST["id"]."\'', 5000)";

				$ERROR++;
				$ERRORSTR[] = "Unable to copy your message to the new message title. Please check your error log for more information. ".$db->ErrorMsg();

				if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
					@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to copy the old message to the new Message Title. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
				}

				echo display_error($ERRORSTR);
			}
		} else {
			$ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".$_POST["id"]."\'', 5000)";
			echo display_error($ERRORSTR);
		}
	break;
	case "delete" :
		?>
		<h1>Message Removal</h1>
		<?php
		if($_POST["confirmed"] == "true") {
			if((@is_array($_POST["ids"])) && (@count($_POST["ids"]) > 0)) {
				$ONLOAD[] = "setTimeout('window.location=\'index.php?section=message\'', 5000)";

				foreach($_POST["ids"] as $message_id) {
					$can_delete = true;
					if($message_id == $_SESSION["config"][PREF_POSTSUBSCRIBE_MSG]) {
						$ERROR++;
						$ERRORSTR[]	= "This message is marked as being the message which will be sent to subscribers after they successfully subscribe to your mailing list.";
						$can_delete	= false;
					} elseif($message_id == $_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG]) {
						$ERROR++;
						$ERRORSTR[]	= "This message is marked as being the message which will be sent to subscribers after they successfully unsubscribe from your mailing list.";
						$can_delete	= false;
					}

					if($can_delete) {
						$query = "DELETE FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes($message_id)."'";
						if(!$db->Execute($query)) {
							if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
								@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete message id [".$message_id."]. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
							}
							$ERROR++;
							$ERRORSTR[] = "Unable to delete message id [".$message_id."] from the database.";
						} else {
							$SUCCESS++;
						}
					}
				}
				if($ERROR) {
					echo display_error($ERRORSTR);
				} elseif($SUCCESS) {
					$SUCCESSSTR[] = "You have successfully deleted ".$SUCCESS." message".(($SUCCESS != 1) ? "s" : "")." from the database.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=message\">click here</a> if you prefer not to wait.";
					echo display_success($SUCCESSSTR);
				}
			} else {
				header("Location: index.php?section=message");
				exit;
			}
		} else {
			if((is_array($_POST["ids"])) && (count($_POST["ids"]))) {
				echo display_notice(array("Please confirm that you wish to delete the following <strong>".count($_POST["ids"])." message".((count($_POST["ids"]) != 1) ? "s" : "")."</strong> from ListMessenger."));
				?>
				<form action="index.php?section=message&action=delete" method="post">
				<input type="hidden" name="confirmed" value="true" />
				<table class="tabular" cellspacing="0" cellpadding="1" border="0">
				<colgroup>
					<col style="width: 3%" />
					<col style="width: 21%" />
					<col style="width: 40%" />
					<col style="width: 36%" />
				</colgroup>
				<thead>
					<tr>
						<td>&nbsp;</td>
						<td>Creation Date</td>
						<td>Message Title</td>
						<td class="close">Message Subject</td>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="4" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
							<input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=message'" />
							<input type="submit" value="Confirm" class="button" />
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php
					foreach($_POST["ids"] as $message_id) {
						if($message_id = (int) $message_id) {
							$can_delete = false;
							
							if(!in_array($message_id, array($_SESSION["config"][PREF_POSTSUBSCRIBE_MSG], $_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG]))) {
								$can_delete	= true;
							}

							$query	= "SELECT `message_date`, `message_title`, `message_subject` FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes($message_id)."'";
							$result	= $db->GetRow($query);
							if($result) {
								echo "<tr onmouseout=\"this.style.backgroundColor='#FFFFFF'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
								echo "	<td style=\"white-space: nowrap\">".(($can_delete) ? "<input type=\"checkbox\" name=\"ids[]\" value=\"".checkslashes($message_id)."\" checked=\"checked\" />" : "<img src=\"./images/pixel.gif\" alt=\"\" title=\"\" width=\"18\" height=\"18\" />")."</td>\n";
								echo "	<td class=\"cursor\">".display_date($_SESSION["config"][PREF_DATEFORMAT], $result["message_date"])."</td>\n";
								echo "	<td class=\"cursor\">".html_encode(limit_chars($result["message_title"], 38))."</td>\n";
								echo "	<td class=\"cursor\">".html_encode(limit_chars($result["message_subject"], 30))."</td>\n";
								echo "</tr>\n";
							}
						}
					}
					?>
				</tbody>
				</table>
				</form>
				<?php
			} else {
				header("Location: index.php?section=message");
				exit;
			}
		}
	break;
	case "edit" :
		if((isset($_GET["id"])) && ((int) trim($_GET["id"]))) {
			$query	= "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes(trim($_GET["id"]))."'";
			$result	= $db->GetRow($query);
			if($result) {
				if($_POST["save_changes"]) {
					if(strlen(trim($_POST["from"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "Your from address seems to be empty, please make sure you format it correctly!<br /><strong>Example:</strong> &quot;My Name&quot; &lt;email@domain.com&gt;";
					}
					if(strlen(trim($_POST["reply"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "Your reply-to address seems to be empty, please make sure you format it correctly!<br /><strong>Example:</strong> &quot;My Name&quot; &lt;email@domain.com&gt;";
					}
					if(strlen(trim($_POST["title"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "Your internal message title seems to be empty, please enter a title for this message that uniquely identifies it in your message centre.";
					}
					if(strlen(trim($_POST["subject"])) < 1) {
						$_POST["subject"] = "(no subject)";
					}
					if(strlen(trim($_POST["priority"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "Please be sure to select a priority for this message. By default this is set to Normal and for the most part, probably shouldn't change.";
					}
					if(strlen(trim($_POST["text_message"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "It seems that you have not entered a text version of your message. ListMessenger requires a text version of your message because it uses a multi-part alternative message format when sending messages. Because it sends in this format, if a text version of the message isn't present and a subscriber's e-mail client isn't configured for HTML messages, the subscriber will see nothing but a blank e-mail.<br /><br />For more information, please visit our <a href=\"http://www.listmessenger.com/index.php/faq\" target=\"_blank\">Frequently Asked Questions</a>.";
					}

					if(!$ERROR) {
						$query	= "UPDATE `".TABLES_PREFIX."messages` SET `message_title`='".checkslashes($_POST["title"])."', `message_subject`='".checkslashes($_POST["subject"])."', `message_from`='".checkslashes($_POST["from"])."', `message_reply`='".checkslashes($_POST["reply"])."', `message_priority`='".checkslashes($_POST["priority"])."', `text_message`='".checkslashes($_POST["text_message"])."', `text_template`='', `html_message`='".((trim(strip_tags($_POST["html_message"])) != "") ? checkslashes($_POST["html_message"]) : "")."', `html_template`='', `attachments`='' WHERE `message_id`='".checkslashes($_POST["message_id"])."';";
						if($db->Execute($query)) {
							header("Location: ./index.php?section=message&action=view&id=".$_POST["message_id"]);
							exit;
						} else {
							if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
								@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to save draft message. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
							}
							$ERROR++;
							$ERRORSTR[] = "Unable to save your changes to this message because there was an error updating the database. The database server said: ".$db->ErrorMsg();
						}
					}
				}

				/**
				 * Add all message variables from defined function.
				 */
				add_sidebar_variables();
				
				?>
				<h1>Edit Message <span style="font-size: 11px">[<?php echo html_encode(checkslashes($result["message_title"], 1)); ?>]</span></h1>
				<?php
				if($ERROR) {
					echo display_error($ERRORSTR);
				} elseif($SUCCESS) {
					echo display_success($SUCCESSSTR);
				}
				?>
				<form action="index.php?section=message&action=edit&id=<?php echo html_encode($_GET["id"]); ?>" method="post" id="compose_message">
				<input type="hidden" name="message_id" value="<?php echo html_encode($_GET["id"]); ?>" />
				<table style="width: 100%; margin: 3px" cellspacing="0" cellpadding="1" border="0">
				<colgroup>
					<col style="width: 25%" />
					<col style="width: 75%" />
				</colgroup>
				<tfoot>
					<tr>
						<td colspan="2" style="border-bottom: 1px #666666 dotted;">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<div style="width: 98%; padding-top: 5px; text-align: right">
								<input type="button" name="cancel" class="button" value="Cancel" onclick="window.location='index.php?section=message&action=view&id=<?php echo html_encode($_GET["id"]); ?>'" />
								<input type="submit" name="save_changes" class="button" value="Save Changes" />
							</div>
						</td>
					</tr>
				</tfoot>		
				<tbody>
					<tr>
						<td>
							<?php echo create_tooltip("From", "<strong>Field Name: <em>From</em></strong><br />This is the from name and e-mail address that the end user will see when viewing your message.<br /><br /><strong>Tip:</strong><br />Make sure you keep the formatting of the from address the same.", true); ?>
						</td>
						<td><input type="text" class="text-box" style="width: 350px" name="from" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["from"], 1)) : html_encode(checkslashes($result["message_from"], 1))); ?>" onkeypress="return handleEnter(this, event)" /></td>
					</tr>
					<tr>
						<td>
							<?php echo create_tooltip("Reply-to", "<strong>Field Name: <em>Reply-to</em></strong><br />This is the reply-to name and e-mail address that the end user will see when replying to your message.<br /><br /><strong>Tip:</strong><br />Make sure you keep the formatting of the reply-to address the same.", true); ?>
						</td>
						<td><input type="text" class="text-box" style="width: 350px" name="reply" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["reply"], 1)) : html_encode(checkslashes($result["message_reply"], 1))); ?>" onkeypress="return handleEnter(this, event)" /></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td>
							<?php echo create_tooltip("Internal Message Title", "<strong>Field Name: <em>Internal Message Title</em></strong><br />This is an internal identifier for you, the administrator, so you can easily identify this message in the Message Centre. This field will never been seen by an end-user, it is available to the administrator.", true); ?>
						</td>
						<td><input type="text" class="text-box" style="width: 350px" id="title" name="title" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["title"], 1)) : html_encode(checkslashes($result["message_title"], 1))); ?>" onkeypress="return handleEnter(this, event)" /></td>
					</tr>
					<tr>
						<td>
							<?php echo create_tooltip("Message Subject", "<strong>Field Name: <em>Message Subject</em></strong><br />This is the subject of the message that you are composing.<br /><br /><strong>Tip:</strong><br />Keep in mind, you can use e-mail variables in the subject as well as the body for personalization."); ?>
						</td>
						<td><input type="text" class="text-box" style="width: 350px" name="subject" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["subject"], 1)) : html_encode(checkslashes($result["message_subject"], 1))); ?>" onkeypress="return handleEnter(this, event)" /></td>
					</tr>
					<tr>
						<td>
							<?php echo create_tooltip("Message Priority", "<strong>Field Name: <em>Message Priority</em></strong><br />This is the level of priority of the message. Please note, that you will almost always want this set to Normal because if you set it to High, you will have a greater chance of spam filters considering your message as spam."); ?>
						</td>
						<td>
							<select name="priority" onkeypress="return handleEnter(this, event)">
							<option value="1"<?php echo (($_POST) ? (($_POST["priority"] == "1") ? " selected=\"selected\"" : "") : (($result["message_priority"] == "1") ? " selected=\"selected\"" : "")); ?>>Highest</option>
							<option value="3"<?php echo (($_POST) ? (($_POST["priority"] == "3") ? " selected=\"selected\"" : "") : (($result["message_priority"] == "3") ? " selected=\"selected\"" : "")); ?>>Normal</option>
							<option value="5"<?php echo (($_POST) ? (($_POST["priority"] == "5") ? " selected=\"selected\"" : "") : (($result["message_priority"] == "5") ? " selected=\"selected\"" : "")); ?>>Lowest</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" style="padding: 0px; margin: 0px">
							<table style="width: 98%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td>
									<?php echo create_tooltip("Text Version", "<strong>Field Name: <em>Text Version</em></strong><br />This is the plain text version of your message and it is a required field. If you plan on sending an HTML version, you must include a text version containing either the text of the HTML message or an explanation as to where the user can view the HTML version with their web-browser.", true); ?>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-right: 3px">
							<div class="msg_container">
								<textarea id="text_message" name="text_message" rows="10" cols="80" autocomplete="off" class="resizable"><?php echo (($_POST) ? html_encode(checkslashes($_POST["text_message"], 1)) : html_encode(checkslashes($result["text_message"], 1))); ?></textarea>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" style="padding: 0px; margin: 0px">
							<table style="width: 98%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td>
									<?php echo create_tooltip("HTML Version", "<strong>Field Name: <em>HTML Version</em></strong><br />This is the optional HTML version of your message. ".((($_SESSION["config"][PREF_USERTE] != "disabled") && ($RTE_ENABLED)) ? "You have the Rich Text Editor enabled, so you can just type your message, changing the font size and colour as you would with any text editor." : "You have the Rich Text Editor disabled, so your message must be provided to this box in pre formatted HTML.")); ?>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="msg_container">
								<textarea id="html_message" name="html_message" rows="20" cols="80" autocomplete="off"><?php echo clean_input((($_POST) ? $_POST["html_message"] : $result["html_message"]), array("trim", "encode", "slashtestremove")); ?></textarea>
								<?php
								if($RTE_ENABLED) {
									rte_display();
								}
								?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td>
							<?php echo create_tooltip("File Attachments", "<strong>Field Name: <em>File Attachments</em></strong><br />You can add attachments to your message by clicking the \"Browse\" button, selecting the file from your computer and clicking \"Upload File\".<br /><br />If you would like to attach a file that has been previously uploaded, simply click the \"Online Files\" button and then select from one of your existing files.<br /><br /><strong>Important Notice:</strong><br />This feature is only available in ListMessenger Pro."); ?>
						</td>
						<td>
							<div class="msg_container">
								<div style="float: left">
									<input type="file" name="attachment" size="16" disabled="true" />
								</div>
								<div style="float: right">
									<input type="submit" name="attach_file" class="button-disabled" value="Upload File" onclick="alert('File attachment support is only available in ListMessenger Pro.');" />&nbsp;
									<input type="button" name="online_file" class="button-disabled" value="Online Files" onclick="alert('File attachment support is only available in ListMessenger Pro.');" />
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
				</form>
				<?php
 			} else {
				if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
					@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the provided message id [".$_GET["id"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
				}
				$ERROR++;
				$ERRORSTR[]	= "Unable to find any message in the Message Centre with an ID of [".$_GET["id"]."].<br /><br />Please <a href=\"./index.php?section=message\">click here</a> to return to the Message Centre.";
				echo display_error($ERRORSTR);
			}
		} else {
			header("Location: index.php?section=message");
			exit;
		}
	break;
	case "send" :
		if((isset($_GET["id"])) && ((int) trim($_GET["id"]))) {
			$query	= "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id` = '".(int) trim($_GET["id"])."'";
			$result	= $db->GetRow($query);
			if($result) {
				
				$SEND_TYPE	= "";
				
				if((isset($_GET["type"])) && (in_array($tmp_send_type = clean_input($_GET["type"], array("trim", "lowercase")), array("group", "subscriber", "address")))) {
					$SEND_TYPE = $tmp_send_type;
				}
				
				/**
				 * Initiate message session information.
				 */
				$_SESSION["message_details"] 						= array();
				$_SESSION["message_details"]["message_id"]			= $result["message_id"];
				$_SESSION["message_details"]["message_title"]		= $result["message_title"];
				$_SESSION["message_details"]["message_subject"]		= $result["message_subject"];
				$_SESSION["message_details"]["message_from"]		= $result["message_from"];
				$_SESSION["message_details"]["message_reply"]		= $result["message_reply"];
				$_SESSION["message_details"]["message_priority"]	= $result["message_priority"];
				$_SESSION["message_details"]["text_message"]		= $result["text_message"];
				$_SESSION["message_details"]["text_template"]		= 0;
				$_SESSION["message_details"]["html_message"]		= $result["html_message"];
				$_SESSION["message_details"]["html_template"]		= 0;
				$_SESSION["message_details"]["attachments"]			= "";

				require_once("classes/lm_mailer.class.php");

				try {
					$mail			= new LM_Mailer($_SESSION["config"]);
					$mail->Priority	= $_SESSION["message_details"]["message_priority"];

					$from_pieces	= explode("\" <", $_SESSION["message_details"]["message_from"]);
					$mail->From     = substr($from_pieces[1], 0, (strlen($from_pieces[1]) - 1));
					$mail->FromName	= substr($from_pieces[0], 1, (strlen($from_pieces[0])));

					$reply_pieces	= explode("\" <", $_SESSION["message_details"]["message_reply"]);
					$mail->AddReplyTo(substr($reply_pieces[1], 0, (strlen($reply_pieces[1]) - 1)), substr($reply_pieces[0], 1, (strlen($reply_pieces[0]))));

					$date			= time();
					$subject		= $_SESSION["message_details"]["message_subject"];

					$html_template	= $_SESSION["message_details"]["html_template"];
					$html_message	= $_SESSION["message_details"]["html_message"];

					$text_template	= $_SESSION["message_details"]["text_template"];
					$text_message	= $_SESSION["message_details"]["text_message"];
				} catch (Exception $e) {
					$ERROR++;
					$ERRORSTR[] = $e->getMessage();
				}

				/**
				 * Check if we are sending this to a subscriber or to a group.
				 */
				switch ($SEND_TYPE) {
					case "subscriber" :
						$subscriber_id = 0;
						
						if((isset($_POST["subscriber_id"])) && ($tmp_subscriber_id = clean_input($_POST["subscriber_id"], array("trim", "int")))) {
							$query	= "SELECT * FROM `".TABLES_PREFIX."users` WHERE `users_id` = ".$db->qstr($tmp_subscriber_id);
							$result	= $db->GetRow($query);
							if($result) {
								$subscriber_id	= $result["users_id"];
							} else {
								$ERROR++;
								$ERRORSTR[] = "The subscriber you have selected to send this message to no longer exists in your database.";
							}
						}
						
						if(!$ERROR) {
							$user_data = get_custom_data($subscriber_id, array("messageid" => $_SESSION["message_details"]["message_id"]), $_SESSION["config"]);

							try {
								$mail->AddCustomHeader("List-Help: <".$_SESSION["config"][PREF_PROGURL_ID]."public/help.php>");
								$mail->AddCustomHeader("List-Owner: <mailto:".$mail->From."> (".$mail->FromName.")");
								$mail->AddCustomHeader("List-Unsubscribe: <".$_SESSION["config"][PREF_PROGURL_ID]."public/unsubscribe.php?addr=".$user_data["email"].">");
								$mail->AddCustomHeader("List-Archive: <".$_SESSION["config"][PREF_PROGURL_ID]."public/archive.php>");
								$mail->AddCustomHeader("List-Post: NO");

								$mail->Subject = custom_data($user_data, $subject);

								if(strlen(trim($html_message)) > 0) {
									$mail->Body = custom_data($user_data, unsubscribe_message(insert_template("html", $html_template, $html_message), "html", $_SESSION["config"]));
									$mail->AltBody = custom_data($user_data, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", $_SESSION["config"]));
								} else {
									$mail->Body = custom_data($user_data, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", $_SESSION["config"]));
								}

								$mail->ClearAllRecipients();
								$mail->AddAddress($user_data["email"], $user_data["name"]);

								if((!@$mail->IsError()) && (@$mail->Send())) {
									$SUCCESS++;
									$SUCCESSSTR[] = "This message has been successfully sent to <strong>".((trim($user_data["name"]) != "") ? "&quot;".html_encode($user_data["name"])."&quot; &lt;".html_encode($user_data["email"])."&gt;" : $user_data["email"])."</strong> from the <strong>".html_encode($user_data["groupname"])."</strong> group.<br /><br />You will be automatically redirected to the message in 5 seconds or <a href=\"index.php?section=message&action=view&id=".$_SESSION["message_details"]["message_id"]."\">click here</a> if you prefer not to wait.";

									$query	= "INSERT INTO `".TABLES_PREFIX."queue` VALUES (NULL, '".(int) trim($_GET["id"])."', '".time()."', '".time()."', '".addslashes(serialize(array("subscriber" => $subscriber_id)))."', '1', '1', 'Complete')";
									$result	= $db->Execute($query);
								} else {
									if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
										@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send test message to ".$email_address.". LM_Mailer responded: ".$mail->ErrorInfo."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
									}

									throw new Exception("This message to <strong>".$user_data["email"]."</strong> could not be sent.<br /><br />The sending engine responded with:<br /><div style=\"margin: 2px; padding: 3px; border: 1px #666666 solid; background-color: #EEEEEE; font-size: 12px\">".$mail->ErrorInfo."</div><br />You may want try changing the method that ListMessenger uses to send e-mail.<br /><br /><a href=\"index.php?section=message&action=view&id=".$_SESSION["message_details"]["message_id"]."\">Click here</a> to return to your message.");
								}
							} catch (Exception $e) {
								$ERROR++;
								$ERRORSTR[] = $e->getMessage();
							}
						}
						
						$ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".$_SESSION["message_details"]["message_id"]."\'', 5000)";
							
						if($ERROR) {
							echo display_error($ERRORSTR);
						}
							
						if($SUCCESS) {
							echo display_success($SUCCESSSTR);
						}

						/**
						 * Remove the message details from the PHP session.
						 */
						unset($_SESSION["message_details"]);
					break;
					case "address" :
						$email_name = "";
						$email_address = "";
						
						if((isset($_POST["subscriber_address"])) && ($tmp_email_address = clean_input($_POST["subscriber_address"]))) {
							if(valid_address($tmp_email_address)) {
								$email_name		= "";
								$email_address	= $tmp_email_address;
							} else {
								$email_pieces	= explode("\" <", $tmp_email_address);
								
								$email_name		= substr($email_pieces[0], 1, (strlen($email_pieces[0])));
								$email_address	= substr($email_pieces[1], 0, (strlen($email_pieces[1]) - 1));
								
								if(!valid_address($email_address)) {
									$ERROR++;
									$ERRORSTR[] = "The e-mail address that you have provided (<strong>".html_encode($email_address)."</strong>) appears to be invalid.<br /><br />Please enter the destination e-mail contact as either <tt>email@address.com</tt> or <tt>&quot;Firstname Lastname&quot; &lt;email@address.com&gt;</tt> in the <strong>Send To Subscriber</strong> field to continue.";
								}
							}
						} else {
							$ERROR++;
							$ERRORSTR[] = "You have selected to send a message to a single e-mail address, but you have not provided a valid address to send it to.<br /><br />Please enter a destination e-mail address as either <tt>email@address.com</tt> or <tt>&quot;Firstname Lastname&quot; &lt;email@address.com&gt;</tt> in the <strong>Send To Subscriber</strong> field to continue.";
						}
						
						if(!$ERROR) {
							require_once("classes/lm_mailer.class.php");

							try {
								$mail->AddCustomHeader("List-Help: <".$_SESSION["config"][PREF_PROGURL_ID]."public/help.php>");
								$mail->AddCustomHeader("List-Owner: <mailto:".$mail->From."> (".$mail->FromName.")");
								$mail->AddCustomHeader("List-Unsubscribe: <".$_SESSION["config"][PREF_PROGURL_ID]."public/unsubscribe.php?addr=".$email_address.">");
								$mail->AddCustomHeader("List-Archive: <".$_SESSION["config"][PREF_PROGURL_ID]."public/archive.php>");
								$mail->AddCustomHeader("List-Post: NO");

								$mail->Subject	= custom_data(false, $subject, array("email_address" => $email_address));

								if(strlen(trim($html_message)) > 0) {
									$mail->Body		= custom_data(false, unsubscribe_message(insert_template("html", $html_template, $html_message), "html", $_SESSION["config"]), array("email_address" => $email_address));
									$mail->AltBody	= custom_data(false, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", $_SESSION["config"]), array("email_address" => $email_address));
								} else {
									$mail->Body		= custom_data(false, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", $_SESSION["config"]), array("email_address" => $email_address));
								}

								$mail->ClearAllRecipients();
								$mail->AddAddress($email_address, $email_name);

								if((!@$mail->IsError()) && (@$mail->Send())) {
									$SUCCESS++;
									$SUCCESSSTR[] = "This message has been successfully sent to <strong>".$email_address."</strong>.<br /><br />You will be automatically redirected to the message in 5 seconds or <a href=\"index.php?section=message&action=view&id=".$_SESSION["message_details"]["message_id"]."\">click here</a> if you prefer not to wait.";
								} else {
									if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
										@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send test message to ".$email_address.". LM_Mailer responded: ".$mail->ErrorInfo."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
									}

									throw new Exception("This message to <strong>".$email_address."</strong> could not be sent.<br /><br />The sending engine responded with:<br /><div style=\"margin: 2px; padding: 3px; border: 1px #666666 solid; background-color: #EEEEEE; font-size: 12px\">".$mail->ErrorInfo."</div><br />You may want try changing the method that ListMessenger uses to send e-mail.<br /><br /><a href=\"index.php?section=message&action=view&id=".$_SESSION["message_details"]["message_id"]."\">Click here</a> to return to your message.");
								}
							} catch (Exception $e) {
								$ERROR++;
								$ERRORSTR[] = $e->getMessage();
							}
						}
						
						$ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".$_SESSION["message_details"]["message_id"]."\'', 5000)";
							
						if($ERROR) {
							echo display_error($ERRORSTR);
						}
							
						if($SUCCESS) {
							echo display_success($SUCCESSSTR);
						}

						/**
						 * Remove the message details from the PHP session.
						 */
						unset($_SESSION["message_details"]);
					break;
					case "group" :
					default :
						if((isset($_POST["groups"])) && (is_array($_POST["groups"])) && (count($_POST["groups"]))) {
							$all_groups	= array();

							foreach($_POST["groups"] as $group_id) {
								$groups		= array();
								$groups[]	= (int) trim($group_id);

								groups_inarray((int) trim($group_id), $groups);

								foreach($groups as $group_id) {
									if($group_id = (int) $group_id) {
										$all_groups[] = $group_id;
									}
								}

								unset($groups);
							}

							$all_groups	= array_unique($all_groups);

							$query		= "SELECT `users_id`, `email_address` FROM `".TABLES_PREFIX."users` WHERE `group_id` IN ('".implode("', '", $all_groups)."') GROUP BY `email_address`";
							$results	= $db->GetAll($query);
							if($results) {
								$total_subscribers = @count($results);

								if(!(int) $total_subscribers) {
									$ONLOAD[]	= "setTimeout('window.location=\'index.php?section=message&action=view&id=".html_encode(trim($_GET["id"]))."\'', 5000)";

									$ERROR++;
									$ERRORSTR[]	= "The group or groups which you have selected to send this message to do not contain any subscribers. Please select a group which contains some subscribers and try again.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=message&action=view&id=".trim($_GET["id"])."\">click here</a> if you prefer not to wait.";

									echo display_error($ERRORSTR);

									if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
										@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to prepare the send because the selected groups didn't contain any users.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
									}
								} else {
									if(($total_subscribers > 175) && ($total_subscribers <= 200)) {
										$NOTICE++;
										$NOTICESTR[] = "Your ListMessenger Light subscriber base is approaching the 200 recommended subscriber limit.<br /><br />This can be stressful on your server because this Light version was not designed to handle lists of more than 200 subscribers. Please upgrade to ListMessenger Pro at: <a href=\"http://www.listmessenger.com\" target=\"_blank\">http://www.listmessenger.com</a>";

										echo display_notice($NOTICESTR);
									} elseif($total_subscribers > 200) {
										$ERROR++;
										$ERRORSTR[] = "You appear to be using ListMessenger Light to send a message to more than 200 subscribers.<br /><br />This can be very stressful on your server because ListMessenger Light was not designed to handle lists of this size. Please upgrade to ListMessenger Pro at: <a href=\"http://www.listmessenger.com\" target=\"_blank\">http://www.listmessenger.com</a>";

										echo display_error($ERRORSTR);

										if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
											@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tAttempted to send a message to a group larger than 200 subscribers with ListMessenger Light. Please upgrade to ListMessenger Pro.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
										}
									}

									$sent_messages	= 0;

									if(!$ERROR) {
										$query = "INSERT INTO `".TABLES_PREFIX."queue` VALUES (NULL, '".(int) trim($_GET["id"])."', '".time()."', '0', '".addslashes(serialize($all_groups))."', '0', '".(int) $total_subscribers."', 'Sending');";
										if(($db->Execute($query)) && ($queue_id = $db->Insert_Id())) {
											foreach($results as $result) {
												if($user_data = get_custom_data($result["users_id"])) {
													if((is_array($user_data)) && (valid_address($user_data["email"]))) {
														$mail->AddCustomHeader("List-Help: <".$_SESSION["config"][PREF_PUBLIC_URL].$_SESSION["config"][ENDUSER_HELP_FILENAME].">");
														$mail->AddCustomHeader("List-Owner: <mailto:".$mail->From."> (".$mail->FromName.")");
														$mail->AddCustomHeader("List-Unsubscribe: <".$_SESSION["config"][PREF_PUBLIC_URL].$_SESSION["config"][ENDUSER_UNSUB_FILENAME]."?addr=".$user_data["email"].">");
														$mail->AddCustomHeader("List-Archive: <".$_SESSION["config"][PREF_PUBLIC_URL].$_SESSION["config"][ENDUSER_ARCHIVE_FILENAME].">");
														$mail->AddCustomHeader("List-Post: NO");

														$mail->Subject = custom_data($user_data, $subject);

														if(strlen(trim($html_message)) > 0) {
															$mail->Body = custom_data($user_data, unsubscribe_message(insert_template("html", $html_template, $html_message), "html", $_SESSION["config"]));
															$mail->AltBody = custom_data($user_data, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", $_SESSION["config"]));
														} else {
															$mail->Body = custom_data($user_data, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", $_SESSION["config"]));
														}

														$mail->ClearAddresses();
														$mail->AddAddress($user_data["email"], $user_data["name"]);

														if((!@$mail->IsError()) && (@$mail->Send())) {
															$sent_messages++;
														} else {
															$ERROR++;
															$ERRORSTR[] = "Unable to send message to ".html_encode($user_data["email"]).".";

															if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
																@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send message to ".$user_data["email"].". PHPMailer said: ".$mail->ErrorInfo."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
															}
														}
														$mail->ClearCustomHeaders();
													}
												}
											}

											$query = "UPDATE `".TABLES_PREFIX."queue` SET `status` = 'Complete', `progress` = '".(int) $sent_messages."' WHERE `queue_id` = '".(int) $queue_id."'";
											if(!$db->Execute($query)) {
												if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
													@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to update queue status in the queue table. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
												}
											} else {
												$ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".trim($_GET["id"])."\'', ".(($NOTICE) ? "20000" : "5000").")";

												if($ERRROR >= $total_subscribers) {
													echo display_error($ERRORSTR);
												} else {
													$SUCCESS++;
													$SUCCESSSTR[] = "You have successfully sent this message to ".html_encode(($total_subscribers - $ERROR))." subscriber".(($total_subscribers != 1) ? "s" : "").", and will now be redirected back to the message window.<br /><br />If you prefer not to wait, please <a href=\"index.php?section=message&action=view&id=".trim($_GET["id"])."\">click here</a>.";

													echo display_success($SUCCESSSTR);
												}
											}
										}
									}
								}
							} else {
								$ERROR++;
								$ERRORSTR[] = "Unable to execute the database query to gather the selected groups. Please ensure you've selected a group to send the message to and try again. See your error log for more information.<br /><br />You will be automatically redirected in 10 seconds, or <a href=\"index.php?section=message&action=view&id=".trim($_GET["id"])."\">click here</a> if you prefer not to wait.";

								echo display_error($ERRORSTR);

								if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
									@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to proceed with send because of a database error. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
								}
							}
						} else {
							$ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".trim($_GET["id"])."\'', 10000)";

							$ERROR++;
							$ERRORSTR[] = "If you would like to send a message one or more of your groups, please select at least one group from the <strong>Send To Group(s)</strong> select box in the Message Centre.<br /><br />You will be automatically redirected in 10 seconds, or <a href=\"index.php?section=message&action=view&id=".(int) trim($_GET["id"])."\">click here</a> if you prefer not to wait.";

							echo display_error($ERRORSTR);
						}

						/**
						 * Remove the message details from the PHP session.
						 */
						unset($_SESSION["message_details"]);
					break;
				}
			} else {
				if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
					@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the provided message id [".$_GET["id"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
				}

				$ERROR++;
				$ERRORSTR[]	= "Unable to find any message in the Message Centre with an ID of [".$_GET["id"]."].<br /><br />Please <a href=\"./index.php?section=message\">click here</a> to return to the Message Centre and select a valid message.";
				
				echo display_error($ERRORSTR);
			}
		} else {
			header("Location: index.php?section=message");
			exit;
		}
	break;
	case "view" :
		if((isset($_GET["id"])) && ((int) trim($_GET["id"]))) {
			$can_delete	= true;
			$query		= "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes(trim($_GET["id"]))."'";
			$result		= $db->GetRow($query);
			if($result) {
				$ONLOAD[] = "\$('#tab-pane-1').tabs()";

				if($result["message_id"] == $_SESSION["config"][PREF_POSTSUBSCRIBE_MSG]) {
					$NOTICE++;
					$NOTICESTR[]	= "This message is marked as being the message which will be sent to subscribers after they successfully subscribe to your mailing list.";
					$can_delete	= false;
				} elseif($result["message_id"] == $_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG]) {
					$NOTICE++;
					$NOTICESTR[]	= "This message is marked as being the message which will be sent to subscribers after they successfully unsubscribe from your mailing list.";
					$can_delete	= false;
				}

				if($result["attachments"] != "") {
					$msg_attachment = @unserialize($result["attachments"]);
				}

				// Turn the HTML message into a session so we can pass it to the preview script.
				if(trim(strip_tags($result["html_message"])) != "") {
					$_SESSION["html_message"] = urlencode(checkslashes(trim(insert_template("html", $result["html_template"], $result["html_message"])), 1));
				} else {
					unset($_SESSION["html_message"]);
				}

				$group_select = groups_inselect(0);
				?>
				<script type="text/javascript">
				function messageDelete() {
					<?php if($can_delete) : ?>
					var is_confirmed = confirm('Are you sure that you want to delete this message?\n\nPress OK to continue with the delete.');
					if (is_confirmed == true) {
						$('#deletemessage').submit();
					}
					<?php else : ?>
					alert('You cannot delete this message because it is marked as being the message that will be sent to a subscriber after a subscribe or unsubcribe action has taken place.\n\nIf you would like to delete this message, please remove this option from Preferences first.');
					<?php endif; ?>
					return;
				}

				function messageCopy() {
					var curTitle	= '<?php echo addslashes($result["message_title"]); ?>';
					var newTitle	= prompt('Please enter the Message Title of the new message you are creating.', curTitle);
					
					if (newTitle == '') {
						alert('You must enter a Message Title for the new message.\n\nPlease click OK and try again once you enter a title.');
						messageCopy();
					} else if(newTitle == curTitle) {
						alert('You cannot keep your new Message Title the same as the old one.\n\nPlease click OK and try again with a unique title.');
						messageCopy();
					} else if(newTitle) {
						$('#copymessage_title').val(newTitle);
						$('#copymessage').submit();
					}

					return;
				}

				function messageSend() {
					if($('#subscriber_address').val() != '') {
						if($('#subscriber_id').val() != '') {
							var is_confirmed = confirm('Please confirm that you wish to send this message to following subscriber:\n\n' + $('#subscriber_address').val() + '\n\nPress OK to send this message.');
							if (is_confirmed == true) {
								$('#sendmessage_subscriber_id').val($('#subscriber_id').val());
								
								if($('#sendmessage_subscriber_id').val() != '') {
									$('#sendmessage_subscriber').submit();
								}
							}
						} else {
							var is_confirmed = confirm('Please confirm that you wish to send this message to following e-mail address:\n\n' + $('#subscriber_address').val() + '\n\nPlease note:\nThis e-mail address does not appear to be a subscriber in your database, so any e-mail variables you may have used in this message will appear blank to recipient.\n\nPress OK to continue to send this message.');
							if (is_confirmed == true) {
								$('#sendmessage_subscriber_address').val($('#subscriber_address').val());
								
								if($('#sendmessage_subscriber_address').val() != '') {
									$('#sendmessage_address').submit();
								}
							}
						}
					} else {
						$('#sendmessage_group').submit();
					}
				}
				</script>

				<h1>Message Centre <span style="font-size: 11px">[<?php echo html_encode(checkslashes($result["message_title"], 1)); ?>]</span></h1>
				<div style="text-align: right">
					<form>
					<input type="button" name="copy" class="button" value="Copy Message" onclick="messageCopy()" />
					<input type="button" name="edit" class="button" value="Edit Message" onclick="window.location='index.php?section=message&action=edit&id=<?php echo html_encode($_GET["id"]); ?>'" />
					<input type="button" name="delete" class="button" value="Delete Message" onclick="messageDelete()" />
					</form>
				</div>
				<br />
				<?php
				if($ERROR) {
					echo display_error($ERRORSTR);
				}
				?>
				<div style="display: <?php echo (in_array("msgSend", $COLLAPSED) ? "none" : "inline"); ?>" id="opened_msgSend">
					<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
					<tr>
						<td class="cursor" style="height: 15px; background-image: url('./images/table-head-on.gif'); background-color: #EEEEEE; border-bottom: 1px #CCCCCC solid" onclick="toggle_section('msgSend', 1, '<?php echo javascript_cookie(); ?>', 'message')">
							<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td style="width: 95%; text-align: left"><span class="search-on">Message Sending Options</span></td>
								<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('msgSend', 1, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-hide.gif" width="9" height="9" alt="Hide" title="Hide Sending Options" border="0" /></a></td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding: 5px">
							<form action="index.php?section=message&action=send&type=group&id=<?php echo html_encode($_GET["id"]); ?>" method="post" id="sendmessage_group">
							<input type="hidden" id="subscriber_id" value="" />
							<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td class="form-row-nreq" style="vertical-align: top">
									<?php echo create_tooltip("Send To Subscriber", "<strong><em>Send To Address</em></strong><br />This feature allows you to send your newsletter to a specific subscriber in your database rather than sending it out to an entire group. You can use this feature to send your newsletter out to a subscriber who may have missed a previous message, or so that you can send yourself test messages before sending to the group."); ?>
								</td>
								<td>
									<input type="text" id="subscriber_address" name="subscriber_address" value="" style="width: 350px" onchange="$('#subscriber_id').val('')" />
									<script type="text/javascript">
									$(document).ready(function() {
										$('#subscriber_address').autocomplete({
											source: './api/subscribers.api.php',
											minLength: 2,
											open: function(event, ui) {
												$('.ui-autocomplete li.ui-menu-item:odd').addClass('odd');
											},
											select: function(event, ui) {
												$('#subscriber_id').val(ui.item.users_id);
												$('#subscriber_address').val(((ui.item.name != ' ') ? '"' + ui.item.name + '" <' + ui.item.email_address + '>' : ui.item.email_address));
												return false;
											}
										}).data('autocomplete')._renderItem = function(ul, item) {
												item.label_name = item.name.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>");
												item.label_email = item.email_address.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>");

												return $('<li></li>')
														.data('item.autocomplete', item)
														.append('<a>' + ((item.name != ' ') ? '&quot;' + item.label_name + '&quot; &lt;' + item.label_email + '&gt' : item.label_email) + '<br />Group: ' + item.group_name + '</a>')
														.appendTo(ul);
										};
									});
									</script>
								</td>
							</tr>
							<?php if($group_select != "") : ?>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td class="form-row-nreq" style="vertical-align: top">
									<?php echo create_tooltip("Send To Group(s)", "<strong><em>Send To Group(s):</em></strong><br />To send your newsletter out to your subscribers select one or more groups from the \"Send To Groups\" select box and click the \"Send Message\" button to proceed.<br /><br />ListMessenger will create a new queue in the Queue Manager that contains all of the subscribers in the group or groups you have selected.<br /><br />A few things to note:<ol><li>Each subscriber will only receive a single copy of the newsletter during this send, meaning that if the same e-mail address appears in multiple groups they will still only receive the newsletter once.</li><li>If you have hierarchical groups (i.e. groups that contain sub-groups) and you select a parent group, ListMessenger will automatically select subscribers from all child groups.</li></ol>"); ?>
								</td>
								<td>
									<select name="groups[]" multiple="multiple" size="8" style="width: 354px">
									<?php echo $group_select; ?>
									</select>
								</td>
							</tr>
							<?php else : ?>
							<tr>
								<td colspan="2">
									<br /><br />
									<?php echo display_notice(array("You currently do not have any groups present in your database to send this message to.<br /><br />Please <a href=\"index.php?section=manage-groups&action=add\" style=\"font-weight: bold\">click here</a> to create a new group, which normally resides under Manage Groups.")); ?>
								</td>
							</tr>
							<?php endif; ?>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right; padding-top: 5px">
									<input type="button" value="Send Message" class="button" onclick="messageSend()"/>
								</td>
							</tr>
							</table>
							</form>
							<br />
						</td>
					</tr>
					</table>
				</div>
				<div style="display: <?php echo (!in_array("msgSend", $COLLAPSED) ? "none" : "inline"); ?>" id="closed_msgSend">
					<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
					<tr>
						<td class="cursor" style="height: 15px; background-image: url('./images/table-head-off.gif'); background-color: #EEEEEE" onclick="toggle_section('msgSend', 0, '<?php echo javascript_cookie(); ?>', 'message')">
							<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td style="width: 95%; text-align: left"><span class="search-off">Message Sending Options</span></td>
								<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('msgSend', 0, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-show.gif" width="9" height="9" alt="Show" title="Show Sending Options" border="0" /></a></td>
							</tr>
							</table>
						</td>
					</tr>
					</table>
				</div>
				<br />

				<div style="display: <?php echo (in_array("msgContents", $COLLAPSED) ? "none" : "inline"); ?>" id="opened_msgContents">
					<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
					<tr>
						<td class="cursor" style="height: 15px; background-image: url('./images/table-head-on.gif'); background-color: #EEEEEE; border-bottom: 1px #CCCCCC solid" onclick="toggle_section('msgContents', 1, '<?php echo javascript_cookie(); ?>', 'message')">
							<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td style="width: 95%; text-align: left"><span class="search-on">Message Contents</span></td>
								<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('msgContents', 1, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-hide.gif" width="9" height="9" alt="Hide" title="Hide Contents" border="0" /></a></td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding: 5px">
							<table style="width: 100%; margin: 3px" cellspacing="0" cellpadding="1" border="0">
							<tr>
								<td class="form-row-nreq" style="width: 25%">From:&nbsp;</td>
								<td style="width: 75%"><?php echo html_encode(checkslashes($result["message_from"], 1)); ?></td>
							</tr>
							<tr>
								<td class="form-row-nreq" style="width: 25%">Reply-to:&nbsp;</td>
								<td style="width: 75%"><?php echo html_encode(checkslashes($result["message_reply"], 1)); ?></td>
							</tr>
							<tr>
								<td class="form-row-nreq" style="width: 25%">Message Subject:&nbsp;</td>
								<td style="width: 75%"><?php echo html_encode(checkslashes($result["message_subject"], 1)); ?></td>
							</tr>
							<tr>
								<td class="form-row-nreq" style="width: 25%">Priority:&nbsp;</td>
								<td style="width: 75%">
									<?php
									switch($result["message_priority"]) {
										case "1" :
											echo "Highest";
										break;
										case "3" :
											echo "Normal";
										break;
										default :
											echo "Lowest";
										break;
									}
									?>
								</td>
							</tr>
							</table>
							<br />

							<div id="tab-pane-1">
								<ul>
									<li><a href="#fragment-1"><span>Text Version</span></a></li>
									<li><a href="#fragment-2"><span>HTML Version</span></a></li>
								</ul>
								<div id="fragment-1">
									<?php echo checkslashes(wordwrap(nl2br(html_encode(trim(insert_template("text", $result["text_template"], $result["text_message"])))), $_SESSION["config"][PREF_WORDWRAP], "<br />", 1), 1); ?>
								</div>
								<div id="fragment-2">
									<?php
									if((isset($_SESSION["html_message"])) && ($_SESSION["html_message"])) {
										?>
										<iframe src="./preview.php" width="100%" height="400" style="border:0; margin:0; padding:0"></iframe>
										<div style="padding-top: 10px; text-align: right">
											<button id="new_window">New Window</button>
										</div>
										<div style="display: none;" id="preview_window" title="HTML Message Preview"><iframe src="./preview.php" width="100%" height="100%" style="border:0; margin:0; padding:0"></iframe></div>
										<script type="text/javascript">
										$(document).ready(function(){
											$('#preview_window').dialog({
												title: 'HTML Message Preview',
												modal: true,
												autoOpen: false,
												height: ($(window).height() - 100),
												width: ($(window).width() - 100),
												resizable: true,
												draggable: false
											});

											$('#new_window').click(function() {
												$('#preview_window').dialog('open');
												return false;
											});
										});
										</script>
										<?php
									} else {
										echo display_notice(array("There is currently no HTML version of this message present, which is fine; your subscribers will simply receive your message as plain text. If you would like to add an HTML version, simply click the Edit Message button; otherwise, you can ignore this."));
									}
									?>
								</div>
							</div>
							<br />
						</td>
					</tr>
					</table>
				</div>
				<div style="display: <?php echo (!in_array("msgContents", $COLLAPSED) ? "none" : "inline"); ?>" id="closed_msgContents">
					<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
					<tr>
						<td class="cursor" style="height: 15px; background-image: url('./images/table-head-off.gif'); background-color: #EEEEEE" onclick="toggle_section('msgContents', 0, '<?php echo javascript_cookie(); ?>', 'message')">
							<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td style="width: 95%; text-align: left"><span class="search-off">Message Contents</span></td>
								<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('msgContents', 0, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-show.gif" width="9" height="9" alt="Show" title="Show Message Contents" border="0" /></a></td>
							</tr>
							</table>
						</td>
					</tr>
					</table>
				</div>
				<br />
				<form action="index.php?section=message&action=copy" method="post" id="copymessage">
				<input type="hidden" id="copymessage_id" name="id" value="<?php echo html_encode($_GET["id"]); ?>" />
				<input type="hidden" id="copymessage_title" name="title" value="" />
				</form>
				<form action="index.php?section=message&action=delete" method="post" id="deletemessage">
				<input type="hidden" id="deletemessage_id" name="ids[]" value="<?php echo html_encode($_GET["id"]); ?>" />
				<input type="hidden" name="confirmed" value="true" />
				</form>
				<form action="index.php?section=message&action=send&type=subscriber&id=<?php echo html_encode($_GET["id"]); ?>" method="post" id="sendmessage_subscriber">
				<input type="hidden" id="sendmessage_subscriber_id" name="subscriber_id" value="" />
				</form>
				<form action="index.php?section=message&action=send&type=address&id=<?php echo html_encode($_GET["id"]); ?>" method="post" id="sendmessage_address">
				<input type="hidden" id="sendmessage_subscriber_address" name="subscriber_address" value="" />
				</form>
				<?php
			} else {
				if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
					@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the provided message id [".$_GET["id"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
				}
				$ERROR++;
				$ERRORSTR[]	= "Unable to find any message in the Message Centre with an ID of [".$_GET["id"]."].<br /><br />Please <a href=\"./index.php?section=message\">click here</a> to return to the Message Centre and select a valid message.";
				echo display_error($ERRORSTR);
			}
		} else {
			header("Location: index.php?section=message");
			exit;
		}
	break;
	default :
		?>
		<div style="display: <?php echo (in_array("search", $COLLAPSED) ? "none" : "inline"); ?>" id="opened_search">
			<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
			<tr>
				<td class="cursor" style="height: 15px; background-image: url('./images/table-head-on.gif'); background-color: #EEEEEE; border-bottom: 1px #CCCCCC solid" onclick="toggle_section('search', 1, '<?php echo javascript_cookie(); ?>', 'message')">
					<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td style="width: 95%; text-align: left"><span class="search-on">Quick Search</span></td>
						<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('search', 1, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-hide.gif" width="9" height="9" alt="Hide" title="Hide Search" border="0" /></a></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<form action="index.php" method="get">
					<input type="hidden" name="section" value="message" />
					<table style="width: 100%; height: 25px" cellspacing="0" cellpadding="2" border="0">
					<tr>
						<td style="width: 100px" class="search-heading">Message Search:</td>
						<td>
							<select name="f">
							<option value="title"<?php echo (($_GET["f"] == "title") ? " selected=\"selected\"" : ""); ?>>Internal Title</option>
							<option value="subject"<?php echo (($_GET["f"] == "subject") ? " selected=\"selected\"" : ""); ?>>Message Subject</option>
							<option value="text"<?php echo (($_GET["f"] == "text") ? " selected=\"selected\"" : ""); ?>>Text Version</option>
							<option value="html"<?php echo (($_GET["f"] == "html") ? " selected=\"selected\"" : ""); ?>>HTML Version</option>
							</select>
						</td>
						<td>
							<select name="t">
							<option value="contains"<?php echo (($_GET["t"] == "contains") ? " selected=\"selected\"" : "") ?>>Contains</option>
							<option value="equals"<?php echo (($_GET["t"] == "equals") ? " selected=\"selected\"" : "") ?>>Equals</option>
							</select>
						</td>
						<td>
							<input type="text" class="text-box" style="width: 150px" name="q" value="<?php echo checkslashes($_GET["q"], 1); ?>" />
						</td>
						<td style="text-align: right">
							<input type="submit" value="Search" class="button" />
						</td>
					</tr>
					</table>
					</form>
				</td>
			</tr>
			</table>
		</div>
		<div style="display: <?php echo (!in_array("search", $COLLAPSED) ? "none" : "inline"); ?>" id="closed_search">
			<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
			<tr>
				<td class="cursor" style="height: 15px; background-image: url('./images/table-head-off.gif'); background-color: #EEEEEE" onclick="toggle_section('search', 0, '<?php echo javascript_cookie(); ?>', 'message')">
					<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td style="width: 95%; text-align: left"><span class="search-off">Quick Search</span></td>
						<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('search', 0, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-show.gif" width="9" height="9" alt="Show" title="Show Search" border="0" /></a></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</div>
		<h1>Message Centre</h1>
		<?php
		// Setup "Sort By Field" Information
		if(isset($_GET["sort"])) {
			$_SESSION["display"]["message"]["sort"] = checkslashes($_GET["sort"]);
			setcookie("display[message][sort]", checkslashes($_GET["sort"]), PREF_COOKIE_TIMEOUT);
		} elseif((!isset($_SESSION["display"]["message"]["sort"])) && (isset($_COOKIE["display"]["message"]["sort"]))) {
			$_SESSION["display"]["message"]["sort"] = $_COOKIE["display"]["message"]["sort"];
		} else {
			if(!isset($_SESSION["display"]["message"]["sort"])) {
				$_SESSION["display"]["message"]["sort"] = "date";
				setcookie("display[message][sort]", "date", PREF_COOKIE_TIMEOUT);
			}
		}

		// Setup "Sort Order" Information
		if(isset($_GET["order"])) {
			switch($_GET["order"]) {
				case "asc" :
					$_SESSION["display"]["message"]["order"] = "ASC";
				break;
				case "desc" :
				default :
					$_SESSION["display"]["message"]["order"] = "DESC";
				break;
			}
			setcookie("display[message][order]", $_SESSION["display"]["message"]["order"], PREF_COOKIE_TIMEOUT);
		} elseif((!isset($_SESSION["display"]["message"]["order"])) && (isset($_COOKIE["display"]["message"]["order"]))) {
			$_SESSION["display"]["message"]["order"] = $_COOKIE["display"]["message"]["order"];
		} else {
			if (!isset($_SESSION["display"]["message"]["order"])) {
				$_SESSION["display"]["message"]["order"] = "DESC";
				setcookie("display[message][order]", "DESC", PREF_COOKIE_TIMEOUT);
			}
		}

		// Set the internal variables used for sorting, ordering and in pagination.
		$sort		= $_SESSION["display"]["message"]["sort"];
		$order		= $_SESSION["display"]["message"]["order"];
		$perpage	= (($_SESSION["config"][PREF_PERPAGE_ID] > 0) ? $_SESSION["config"][PREF_PERPAGE_ID] : 25);

		// Begin Query String
		if((strlen($_GET["q"]) > 0) && (strlen($_GET["t"]) > 0) && (strlen($_GET["f"]) > 0)) {
			$seeking["search"] = true;
			switch($_GET["f"]) {
				case "title" :
					$seek .= " WHERE `message_title`";
				break;
				case "subject" :
					$seek .= " WHERE `message_subject`";
				break;
				case "text" :
					$seek .= " WHERE `text_message`";
				break;
				case "html" :
					$seek .= " WHERE `html_message`";
				break;
				default :
					$seek .= " WHERE `message_title`";
				break;
			}
			switch($_GET["t"]) {
				case "contains" :
					$seek .= "LIKE'%".checkslashes($_GET["q"])."%'";
				break;
				case "equals" :
					$seek .= "='".checkslashes($_GET["q"])."'";
				break;
				default :
					$seek .= "LIKE'%".checkslashes($_GET["q"])."%'";
				break;
			}
		}

		$query		= "SELECT COUNT(*) AS `totalrows` FROM `".TABLES_PREFIX."messages`".$seek;
		$result		= $db->GetRow($query);
		$totalrows	= $result["totalrows"];

		// Get the total number of pages that we need to display.
		if($totalrows <= $perpage) {
			$totalpages = 1;
		} elseif (($totalrows % $perpage) == 0) {
			$totalpages = (int) ($totalrows / $perpage);
		} else {
			$totalpages = (int) ($totalrows / $perpage) + 1;
		}

		// Check to see what page to output.
		if(isset($_GET["vp"])) {
			if((int) $_GET["vp"]) {
				if(($_GET["vp"] >= 1) && ($_GET["vp"] <= $totalpages)) {
					$page = $_GET["vp"];
				} else {
					$page = 1;
				}
			} else {
				$page = 1;
			}
		} else {
			$page = 1;
		}

		$prev_page	= $page - 1;
		$next_page	= $page + 1;
		$page_start	= ($perpage * $page) - $perpage;

		// Get the colomn names of the sorted by colomn.
		switch($sort) {
			case "title" :
				$sortby	= "`message_title`";
			break;
			case "subject" :
				$sortby	= "`message_subject`";
			break;
			case "date" :
			default :
				$sortby	= "`message_date`";
			break;
		}

		$query		= "SELECT `message_id`, `message_date`, `message_title`, `message_subject` FROM `".TABLES_PREFIX."messages`".$seek." ORDER BY ".$sortby." ".strtoupper($order)." LIMIT ".$page_start.", ".$perpage;
		$results	= $db->GetAll($query);
		if($results) {
			?>
			<table style="width: 100%" cellspacing="0" cellpadding="1" border="0">
			<tr>
				<td style="width: 50%; text-align: left">
					<form action="index.php" method="get">
					<input type="hidden" name="section" value="message" />
					<?php
					if($seeking["search"]) {
						echo "	<input type=\"hidden\" name=\"q\" value=\"".html_encode($_GET["q"])."\" />\n";
						echo "	<input type=\"hidden\" name=\"t\" value=\"".html_encode($_GET["t"])."\" />\n";
						echo "	<input type=\"hidden\" name=\"f\" value=\"".html_encode($_GET["f"])."\" />\n";
					}
					?>
					<table cellspacing="1" cellpadding="1" border="0">
					<tr>
						<td>Showing Page</td>
						<td><input type="text" name="vp" value="<?php echo html_encode($page); ?>" class="text-box" style="width: 25px" /></td>
						<td>of <?php echo html_encode($totalpages); ?>.</td>
					</tr>
					</table>
					</form>
				</td>
				<td style="width: 50%">
					<div style="float: right">
					<?php
					if($totalpages > 1) {
						?>
						<table cellspacing="1" cellpadding="1" border="0">
						<tr>
							<td style="width: 22px; text-align: left; white-space: nowrap">
								<?php
								if($prev_page) {
									echo "<a href=\"index.php?".replace_query(array("vp" => 1))."\"><img src=\"./images/record-first-on.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"First Page\" title=\"Back to first page.\" /></a>";
									echo "<a href=\"index.php?".replace_query(array("vp" => $prev_page))."\"><img src=\"./images/record-back-on.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"Page ".$prev_page.".\" title=\"Back to page ".$prev_page.".\" /></a>";
								} else {
									echo "<img src=\"./images/record-first-off.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"\" />";
									echo "<img src=\"./images/record-back-off.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"\" />";
								}
								?>
							</td>
							<td style="white-space: nowrap">
								<div style="float: center">
								<?php
								echo "<form action=\"index.php?".replace_query()."\" name=\"changepage\" method=\"GET\">\n";
								echo "<input type=\"hidden\" name=\"section\" value=\"message\" />\n";
								if($seeking["search"]) {
									echo "	<input type=\"hidden\" name=\"q\" value=\"".html_encode($_GET["q"])."\" />\n";
									echo "	<input type=\"hidden\" name=\"t\" value=\"".html_encode($_GET["t"])."\" />\n";
									echo "	<input type=\"hidden\" name=\"f\" value=\"".html_encode($_GET["f"])."\" />\n";
								} elseif($seeking["group"]) {
									echo "	<input type=\"hidden\" name=\"g\" value=\"".$_GET["g"]."\" />";
								}
								echo "<select name=\"vp\" onchange=\"document.changepage.submit();return;\"".(($totalpages <= 1) ? " DISABLED" : "").">\n";
								if(!$totalpages) {
									echo "<option value=\"\" selected=\"selected\">Page 1</option>\n";
								} else {
									for($i = 1; $i < $totalpages; $i++) {
										if($i == $page) {
											echo "<option value=\"".$i."\" selected=\"selected\">Viewing Page ".$i."</option>\n";
										} else {
											echo "<option value=\"".$i."\">Page ".$i."</option>\n";
										}
									}
									if(($totalrows % $perpage) != 0) {
										if($i == $page) {
											echo "<option value=\"".$i."\" selected=\"selected\">Viewing Page ".$i."</option>\n";
										} else {
											echo "<option value=\"".$i."\">Page ".$i."</option>\n";
										}
									}
								}
								echo "</select>\n";
								echo "</form>\n";
								?>
								</div>
							</td>
							<td style="width: 22px; text-align: right; white-space: nowrap">
								<?php
								if($page < $totalpages) {
									echo "<a href=\"index.php?".replace_query(array("vp" => $next_page))."\"><img src=\"./images/record-next-on.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"Page ".$next_page.".\" title=\"Forward to page ".$next_page.".\" /></a>";
									echo "<a href=\"index.php?".replace_query(array("vp" => $totalpages))."\"><img src=\"./images/record-last-on.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"Last Page\" title=\"Forward to last page.\" /></a>";
								} else {
									echo "<img src=\"./images/record-next-off.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"\" />";
									echo "<img src=\"./images/record-last-off.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"\" />";
								}
								?>
							</td>
						</tr>
						</table>
						<?php
					}
					?>
					</div>
				</td>
			</tr>
			</table>
			
			<form action="index.php?section=message&amp;action=delete" method="post">
			<table class="tabular" cellspacing="0" cellpadding="1" border="0">
			<colgroup>
				<col style="width: 3%" />
				<col style="width: 21%" />
				<col style="width: 40%" />
				<col style="width: 36%" />
			</colgroup>
			<thead>
				<tr>
					<td>&nbsp;</td>
					<td class="<?php echo (($sort == "date") ? "on" : "off"); ?>"><?php echo order_link("date", "Creation Date", $order, $sort); ?></td>
					<td class="<?php echo (($sort == "title") ? "on" : "off"); ?>"><?php echo order_link("title", "Message Title", $order, $sort); ?></td>
					<td class="close <?php echo (($sort == "subject") ? "on" : "off"); ?>"><?php echo order_link("subject", "Message Subject", $order, $sort); ?></td>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="4" style="border-top: 1px #333333 dotted; padding-top: 5px">
						<input type="checkbox" name="selectall" value="1" onclick="selection(this, 'ids[]')" style="vertical-align: middle" />&nbsp;
						<input type="submit" class="button" value="Delete Selected" style="vertical-align: middle" />
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
			foreach($results as $result) {
				$can_delete = true;
				if(($result["message_id"] == $_SESSION["config"][PREF_POSTSUBSCRIBE_MSG]) || ($result["message_id"] == $_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG])) {
					$can_delete = false;
				}
				echo "<tr onmouseout=\"this.style.backgroundColor='#FFFFFF'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
				echo "	<td style=\"white-space: nowrap\">".(($can_delete) ? "<input type=\"checkbox\" name=\"ids[]\" value=\"".$result["message_id"]."\" />" : "<img src=\"./images/pixel.gif\" alt=\"\" title=\"\" width=\"18\" height=\"18\" />")."</td>\n";
				echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".display_date($_SESSION["config"][PREF_DATEFORMAT], $result["message_date"])."</td>\n";
				echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".html_encode(limit_chars($result["message_title"], 38))."</td>\n";
				echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".html_encode(limit_chars($result["message_subject"], 30))."</td>\n";
				echo "</tr>\n";
			}
			?>
			</tbody>
			</table>
			</form>
			<?php
			$_SESSION["display"]["message"]["lastpage"] = $page;
		} else {
			?>
			<h2>No Messages Found</h2>
			<div class="generic-message">
				There are no composed e-mail messages in your ListMessenger database.
				<br /><br />
				To compose a new message click the <strong>Compose Message</strong> button at the top of the page.
			</div>
			<?php
		}
	break;	// End of default switch.
}
?>