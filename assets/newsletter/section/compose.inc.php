<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright 2009 Silentweb [http://www.silentweb.ca]. All Rights Reserved.

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in licence.html
	$Id: compose.inc.php 514 2011-03-09 19:59:51Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))		exit;
if(!$_SESSION["isAuthenticated"])	exit;

$STEP 			= $_GET["step"];
$msg_attachment	= (($_POST["msg_attachment"]) ? $_POST["msg_attachment"] : array());

if($_POST["back"]) {
	$STEP = $_GET["step"] - 2;
}

// Error checking step switch.
switch($STEP) {
	case "2" :
		if($_POST["save_draft"]) {
			$query	= "INSERT INTO `".TABLES_PREFIX."messages` (`message_id`, `message_date`, `message_title`, `message_subject`, `message_from`, `message_reply`, `message_priority`, `text_message`, `text_template`, `html_message`, `html_template`, `attachments`) VALUES (NULL, '".time()."', '".checkslashes($_POST["title"])."', '".checkslashes($_POST["subject"])."', '".checkslashes($_POST["from"])."', '".checkslashes($_POST["reply"])."', '".checkslashes($_POST["priority"])."', '".checkslashes($_POST["text_message"])."', '', '".((trim(strip_tags($_POST["html_message"])) != "") ? checkslashes($_POST["html_message"]) : "")."', '', '');";
			if($db->Execute($query)) {
				$id = $db->Insert_ID();
				if($id) {
					header("Location: ./index.php?section=message&id=".$id);
					exit;
				} else {
					if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
						@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the insert ID of the previous query, redirecting to the Message Centre instead.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
					}
					header("Location: ./index.php?section=message");
					exit;
				}
			} else {
				$STEP = 1;
				if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
					@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to save draft message. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
				}
				$ERROR++;
				$ERRORSTR[] = "Unable to save your message as a draft because there was an error inserting it into the database. The database server said: ".$db->ErrorMsg();
			}
		} elseif($_POST["save_proceed"]) {
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
			// If there's an error, go back a step.
			if($ERROR) {
				$STEP = 1;
			}
		}
	break;
	case "3" :
		if($_POST["save_proceed"]) {
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
				$query	= "INSERT INTO `".TABLES_PREFIX."messages` (`message_id`, `message_date`, `message_title`, `message_subject`, `message_from`, `message_reply`, `message_priority`, `text_message`, `text_template`, `html_message`, `html_template`, `attachments`) VALUES (NULL, '".time()."', '".checkslashes($_POST["title"])."', '".checkslashes($_POST["subject"])."', '".checkslashes($_POST["from"])."', '".checkslashes($_POST["reply"])."', '".checkslashes($_POST["priority"])."', '".checkslashes($_POST["text_message"])."', '".checkslashes($_POST["text_template"])."', '".((trim(strip_tags($_POST["html_message"])) != "") ? checkslashes($_POST["html_message"]) : "")."', '".checkslashes($_POST["html_template"])."', '".((is_array($_POST["msg_attachment"])) ? checkslashes(serialize($_POST["msg_attachment"])) : "")."');";
				if($db->Execute($query)) {
					$id = $db->Insert_ID();
					if($id) {
						header("Location: ./index.php?section=message&action=view&id=".$id);
						exit;
					} else {
						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the insert ID of the previous query, redirecting to the Message Centre instead.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}
						header("Location: ./index.php?section=message");
						exit;
					}
				} else {
					$STEP = 1;
					if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
						@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to save draft message. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
					}
					$ERROR++;
					$ERRORSTR[] = "Unable to save your message as a draft because there was an error inserting it into the database. The database server said: ".$db->ErrorMsg();
				}
			} else {
				$STEP = 2;
			}
		}
	break;
	default :
	break;
}

// Body content step switch.
switch($STEP) {
	case "2" :
		$COLLAPSED = explode(",", $_COOKIE["display"]["compose"]["collapsed"]);

		$ONLOAD[] = "\$('#tab-pane-1').tabs()";

		// Turn the HTML message into a session so we can pass it to the preview script.
		if (trim(strip_tags($_POST["html_message"])) != "") {
			if (isset($_POST["html_template"]) && (int) $_POST["html_template"]) {
				$_SESSION["html_message"] = urlencode(checkslashes(trim(insert_template("html", $_POST["html_template"], $_POST["html_message"])), 1));
			} else {
				$_SESSION["html_message"] = urlencode(checkslashes(trim($_POST["html_message"]), 1));
			}
		} else {
			unset($_SESSION["html_message"]);
		}
		?>
		<h1>Compose Message</h1>
		<?php
		if($ERROR) {
			echo display_error($ERRORSTR);
		}
		?>
		Please confirm the contents of your message by reviewing it below. You can toggle back and forth between Text Version and HTML Version using the tabs.
		<br /><br />
		<table style="width: 100%; margin: 3px" cellspacing="0" cellpadding="1" border="0">
		<tr>
			<td class="form-row-nreq" style="width: 25%">From:&nbsp;</td>
			<td style="width: 75%"><?php echo html_encode(checkslashes($_POST["from"], 1)); ?></td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="width: 25%">Reply-to:&nbsp;</td>
			<td style="width: 75%"><?php echo html_encode(checkslashes($_POST["reply"], 1)); ?></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="width: 25%">Internal Title:&nbsp;</td>
			<td style="width: 75%"><?php echo html_encode(checkslashes($_POST["title"], 1)); ?></td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="width: 25%">Message Subject:&nbsp;</td>
			<td style="width: 75%"><?php echo html_encode(checkslashes($_POST["subject"], 1)); ?></td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="width: 25%">Priority:&nbsp;</td>
			<td style="width: 75%">
				<?php
				switch($_POST["priority"]) {
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
				<?php
				if (isset($_POST["text_template"]) && (int) $_POST["text_template"]) {
					echo checkslashes(wordwrap(nl2br(html_encode(trim(insert_template("text", $_POST["text_template"], $_POST["text_message"])))), $_SESSION["config"][PREF_WORDWRAP], "<br />", 1), 1);
				} else {
					echo checkslashes(wordwrap(nl2br(html_encode(trim($_POST["text_message"]))), $_SESSION["config"][PREF_WORDWRAP], "<br />", 1), 1);
				}
				?>
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
					echo display_notice(array("There is currently no HTML version of this message present, which is fine; your subscribers will simply receive your message as plain text. If you would like to add an HTML version, simply click the back button; otherwise, you can ignore this."));
				}
				?>
			</div>
		</div>
		<br />
		<table style="width: 100%; margin: 3px" cellspacing="0" cellpadding="1" border="0">
		<tr>
			<td style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px" colspan="2">
				<form action="index.php?section=compose&step=3" method="post">
				<input type="hidden" name="from" value="<?php echo html_encode(checkslashes($_POST["from"], 1)); ?>" />
				<input type="hidden" name="reply" value="<?php echo html_encode(checkslashes($_POST["reply"], 1)); ?>" />
				<input type="hidden" name="title" value="<?php echo html_encode(checkslashes($_POST["title"], 1)); ?>" />
				<input type="hidden" name="subject" value="<?php echo html_encode(checkslashes($_POST["subject"], 1)); ?>" />
				<input type="hidden" name="priority" value="<?php echo html_encode(checkslashes($_POST["priority"], 1)); ?>" />
				<input type="hidden" name="text_message" value="<?php echo html_encode(checkslashes($_POST["text_message"], 1)); ?>" />
				<input type="hidden" name="html_message" value="<?php echo html_encode(checkslashes($_POST["html_message"], 1)); ?>" />
				<input type="submit" name="back" class="button" value="Back" />&nbsp;
				<input type="submit" name="save_proceed" class="button" value="Proceed" />
				</form>
			</td>
		</tr>
		</table>
		<?php
	break;
	default :
		/**
		 * Add all message variables from defined function.
		 */
		add_sidebar_variables();
		
		?>
		<h1>Compose Message</h1>
		<?php
		if($ERROR) {
			echo display_error($ERRORSTR);
		} elseif($SUCCESS) {
			echo display_success($SUCCESSSTR);
		}
		?>
		<form action="index.php?section=compose&step=2" method="post" id="compose_message">
		<input type="hidden" id="online_filename" name="online_filename" value="" />
		<?php
		if(count($msg_attachment) > 0) {
			foreach($msg_attachment as $id => $filename) {
				echo "<input type=\"hidden\" name=\"msg_attachment[".$id."]\" value=\"".$filename."\" />\n";
			}
		}
		?>
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
						<input type="submit" name="save_draft" class="button" value="Save as Draft" />&nbsp;
						<input type="submit" name="save_proceed" class="button" value="Proceed" />
					</div>
				</td>
			</tr>
		</tfoot>		
		<tbody>
			<tr>
				<td>
					<?php echo create_tooltip("From", "<strong>Field Name: <em>From</em></strong><br />This is the from name and e-mail address that the end user will see when viewing your message.<br /><br /><strong>Tip:</strong><br />Make sure you keep the formatting of the from address the same.", true); ?>
				</td>
				<td><input type="text" class="text-box" style="width: 350px" name="from" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["from"], 1)) : html_encode("\"".$_SESSION["config"][PREF_FRMNAME_ID]."\" <".$_SESSION["config"][PREF_FRMEMAL_ID].">")); ?>" onkeypress="return handleEnter(this, event)" /></td>
			</tr>
			<tr>
				<td>
					<?php echo create_tooltip("Reply-to", "<strong>Field Name: <em>Reply-to</em></strong><br />This is the reply-to name and e-mail address that the end user will see when replying to your message.<br /><br /><strong>Tip:</strong><br />Make sure you keep the formatting of the reply-to address the same.", true); ?>
				</td>
				<td><input type="text" class="text-box" style="width: 350px" name="reply" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["reply"], 1)) : html_encode("\"".$_SESSION["config"][PREF_FRMNAME_ID]."\" <".$_SESSION["config"][PREF_RPYEMAL_ID].">")); ?>" onkeypress="return handleEnter(this, event)" /></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td>
					<?php echo create_tooltip("Internal Message Title", "<strong>Field Name: <em>Internal Message Title</em></strong><br />This is an internal identifier for you, the administrator, so you can easily identify this message in the Message Centre. This field will never been seen by an end-user, it is available to the administrator.", true); ?>
				</td>
				<td><input type="text" class="text-box" style="width: 350px" id="title" name="title" value="<?php echo html_encode(checkslashes($_POST["title"], 1)); ?>" onkeypress="return handleEnter(this, event)" /></td>
			</tr>
			<tr>
				<td>
					<?php echo create_tooltip("Message Subject", "<strong>Field Name: <em>Message Subject</em></strong><br />This is the subject of the message that you are composing.<br /><br /><strong>Tip:</strong><br />Keep in mind, you can use e-mail variables in the subject as well as the body for personalization."); ?>
				</td>
				<td><input type="text" class="text-box" style="width: 350px" name="subject" value="<?php echo html_encode(checkslashes($_POST["subject"], 1)); ?>" onkeypress="return handleEnter(this, event)" /></td>
			</tr>
			<tr>
				<td>
					<?php echo create_tooltip("Message Priority", "<strong>Field Name: <em>Message Priority</em></strong><br />This is the level of priority of the message. Please note, that you will almost always want this set to Normal because if you set it to High, you will have a greater chance of spam filters considering your message as spam."); ?>
				</td>
				<td>
					<select name="priority" onkeypress="return handleEnter(this, event)">
					<option value="1"<?php echo (($_POST) ? (($_POST["priority"] == "1") ? " selected=\"selected\"" : "") : ""); ?>>Highest</option>
					<option value="3"<?php echo (($_POST) ? (($_POST["priority"] == "3") ? " selected=\"selected\"" : "") : " selected=\"selected\""); ?>>Normal</option>
					<option value="5"<?php echo (($_POST) ? (($_POST["priority"] == "5") ? " selected=\"selected\"" : "") : ""); ?>>Lowest</option>
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
						<textarea id="text_message" name="text_message" rows="10" cols="80" autocomplete="off" class="resizable"><?php echo html_encode(checkslashes($_POST["text_message"], 1)); ?></textarea>
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
						<textarea id="html_message" name="html_message" rows="20" cols="80" autocomplete="off"><?php echo ((isset($_POST["html_message"])) ? clean_input($_POST["html_message"], array("trim", "encode", "slashtestremove")) : ""); ?></textarea>
						<?php
						if($RTE_ENABLED) {
							rte_display("html_message");
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
					<?php echo create_tooltip("File Attachments", "<strong>Field Name: <em>File Attachments</em></strong><br />You can add attachments to your message by clicking the \"Browse\" button, selecting the file from your computer and clicking \"Upload File\".<br /><br />If you would like to attach a file that has been previously uploaded, simply click the \"Online Files\" button and then select from one of your existing files.<br /><br /><strong>Important Notice:</strong><br />This feature is only available in ListMessenger Pro.", false); ?>
				</td>
				<td>
					<div class="msg_container">
						<div style="float: left">
							<input type="file" name="attachment" size="16" disabled="true" />
						</div>
						<div style="float: right">
							<input type="button" name="attach_file" class="button" value="Upload File" onclick="alert('File attachment support is only available in ListMessenger Pro.');" />&nbsp;
							<input type="button" name="online_file" class="button" value="Online Files"  onclick="alert('File attachment support is only available in ListMessenger Pro.');" />
						</div>
					</div>
				</td>
			</tr>
		</tbody>
		</table>
		</form>
		<?php
	break;
}
?>