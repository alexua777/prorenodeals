<?php
// content language (en = English)
header('Content-language: en');
// last modified
$time = filemtime("index.php");
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $time).' GMT');

// Disable caching of the current document:
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Pragma: no-cache');

require_once("../configs/path.php");
$dark = "#0080C0";
$light = "#A8D3FF";
$td_bgcolor = "#F7F7F7";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><?=ucwords($dotcom)?> Control System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="NOINDEX, NOFOLLOW" />
	<base target="_self" />
	
	<link href="css/style.css" rel="stylesheet" type="text/css" />
    <script language="javascript" src="../js/script.js" type="text/javascript"></script>
	<script language="javascript" src="js/sortabletable.js" type="text/javascript"></script>
	
	<?php if($_SESSION['admin_id']) { ?>
	<link rel="stylesheet" type="text/css" href="css/cssverticalmenu.css" />
	<script type="text/javascript" src="js/cssverticalmenu.js" language="javascript"></script>	
	<?php } ?>
</head>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="96%" align="center">
  <tr>
	<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
	<td width="10" height="11"><img src="images/lc.gif" width="10" height="11" border="0" alt="" /></td>
	<td width="966" style="border-top:solid 1px #111111;" bgcolor="<?php echo $td_bgcolor; ?>"><img width="1" height="1" alt="" src="images/spacer.gif" /></td>
	<td><img src="images/rc.gif" width="10" height="11" border="0" alt="" /></td>
  </tr>
  <tr bgcolor="<?php echo $td_bgcolor; ?>">
	<td colspan="3" style="border-left:solid 1px #111111; border-right:solid 1px #111111;" height="500" valign="top">
	<table cellpadding="0" cellspacing="0" border="0" width="98%" align="center">
	  <tr>
		<td colspan="2" align="left" valign="top">
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
		  <tr>
			<td width="11"><img src="images/lft_curve.gif" width="11" height="108" /></td>
			<td height="53" valign="middle" background='images/background.jpg'>&nbsp;&nbsp;
			<b><span class="lnk" style="color:#ffffff; font-size:24px;"><?=ucwords($dotcom)?> Control System</span></b></td>
			<td width="225" class="lnk" valign="middle" align="right" style="padding-right:20px;" background='images/background.jpg'><?=copyright("admin_header")?>&nbsp;</td>
			<td width="11"><img src="images/right_curve.gif" width="11" height="108" /></td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td height="3" colspan="2" bgcolor="<?=$dark?>"></td>
	  </tr>
	  <tr bgcolor="#006fa4"><!--today row-->
		<td class="lnk" style="padding-left:10px; color:#FFFFFF;border-bottom:solid 1px silver"><strong><?php echo"Today: " . date("dS F, Y"); ?></strong></td>
    	<td height="35" align="right" class="lnk" style="border-bottom:solid 1px silver"><?php if($_SESSION['admin_id']) { ?>
		<a href="./index.php" title="Index" class="lnk_white"><strong>Admin Home</strong></a>  <?php } ?>
		<a href="help.php" title="View Site" target="_blank" class="lnk_white"><strong>Help</strong></a>				<a href="../index.php" title="View Site" target="_blank" class="lnk_white"><strong>View Site</strong></a>  
		<?php if($_SESSION['admin_id']) { ?>
		<a href="password_change.php" title="Password Change" class="lnk_white"><strong>Password Change</strong></a>  
		<a href="#" title='Logout' class='lnk_white' onClick="javascript:if(confirm('You are going to logout?')){window.location = 'logout.php';}"><b>Logout</b></a>
		<?php } else { ?>
		<a href="login.php" title="Sign In" class="lnk_white"><strong>Sign In</strong></a>
		<?php } ?>
		&nbsp;</td>
	  </tr>
	</table>
	
	<table border="0" width="100%" cellpadding="4" cellspacing="0">
	  <tr>
		<td width="200" align="left" valign="top" style="padding-left:10px; padding-top:10px;">
		<?php if($_SESSION['admin_id'] && $page_name!='admin_help') { require_once("leftmenu.php"); } ?></td>
		<td align="left" valign="top" style="padding-left:10px; padding-top:10px; padding-right:10px;">
		
		<?php if(substr_count($_SERVER['PHP_SELF'], "index.php")) { ?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  <?php 
		  $row_admin = mysql_fetch_array(mysql_query("select * from ".$prev."team where id = '".$_SESSION['team_id']."'"));
		  ?>
          <tr>
			<td align="left"><a href="index.php"><img src="images/adim.png" alt="No Preview" border="0" /></a></td>
			<td align="left" class="lnk" style="padding-bottom:10px; color:<?=$dark?>;"><span style="font-size:18px;">Hello, 
			<?php if($_SESSION['admin_type']=='S') { print ucwords($row_admin[fname]).' '.ucwords($row_admin[lname]).' (Admin!)'; } elseif($_SESSION['admin_type']=='X') {print ucwords($row_admin[fname]).' '.ucwords($row_admin[lname]).' (Sub-Admin!)';}?> </span><br />
			<span style="font-size:13px;">Welcome to your control panel. Here you can manage and modify every aspect of your this website.<br />
			You will find a quick snapshot of your website including some useful features.</span></td>
		  </tr>
		</table>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="4" bgcolor="<?=$dark?>"><img width="1" height="1" alt="" src="images/spacer.gif" /></td>
		  </tr>
		</table><br />
		<?php } ?>