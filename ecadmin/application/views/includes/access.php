<?php
session_start();
if(empty($_SESSION['admin_id']))
{
	header("Location: login.php");
	exit();
}
else
{
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
}

$main_icon_active_img	= '<img src="images/icon_active.gif" align="absmiddle" border="0" alt="active" title="Active" />';
$main_icon_inactive_img = '<img src="images/icon_inactive.gif" align="absmiddle" border="0" alt="inactive"  title="Inactive"/>';
$main_icon_edit_img		= '<img src="images/icon_edit.png" align="absmiddle" border="0" alt="edit" title="Edit" />';
$main_icon_del_img		= '<img src="images/delete.png" align="absmiddle" border="0" alt="del" title="Delete" />';
$main_icon_scrshot_img	= '<img src="images/icon_screenshot.gif" align="absmiddle" border="0" alt="screenshot" title="Screenshot" />';
$main_icon_sub_img	= '<img src="images/sub.jpg" align="absmiddle" border="0" alt="add subcategory" title="Add subcategory" />';
$main_icon_commission_img	= '<img src="images/commission.jpg" align="absmiddle" border="0" alt="View Commission" title="View Commission" />';
?>