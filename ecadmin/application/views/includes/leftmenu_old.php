<table width="100%" cellpadding="0" cellspacing="0" class="table">
  <tr style="height:30px;">
	<td align="left" class="header_tr" bgcolor="<?=$light?>" style="padding-left:10px;">Main Menu</td>
  </tr>
  <tr>
	<td bgcolor="<?=$dark?>"><img src="images/divide.JPG" width="100%" height="2" alt="menu divider" /></td>
  </tr>
  <tr>
	<td align="left">
<?php
$rws_query = "SELECT * FROM ".$prev."adminmenu
				WHERE status = 'Y'
				AND parent_id = 0
				ORDER BY ord ASC, name ASC";
$rws = mysql_query( $rws_query ) or die("Menu error: ".mysql_error());
if( @mysql_num_rows( $rws ) ) {
?>
<ul id="verticalmenu" class="glossymenu" style="width:99.3%;">
<?php
	while($rw = @mysql_fetch_array($rws)) {
		$main_name = stripslashes( $rw['name'] );
		$img = $rw['pic'];

		if(empty($rw['pic']) || !file_exists($rw['pic'])) {
			$img = "images/altimage.png";
		}

		if(!empty($rw['url']))
			$admin_url = $rw['url'];
		else
			$admin_url = "#";
		if(($_SESSION['admin_type']=='X')&&($main_name=='Sub-Admin Management'))
		{
		}
		else
		{
			if($main_name=='Support Ticket')
			{
				echo '<li><a href="'.$admin_url.'" target=\'_blank\'><img src="'.$img.'" width="16" height="16" border="0" alt="'.$main_name.'" />&nbsp;&nbsp;<span class="lnk">'.$main_name.'</span></a>';
			}
			elseif($main_name=='NewsLetter')
			{
				echo '<li><a href="'.$admin_url.'" target=\'_blank\'><img src="'.$img.'" width="16" height="16" border="0" alt="'.$main_name.'" />&nbsp;&nbsp;<span class="lnk">'.$main_name.'</span></a>';
			}
			else
			{
			echo '<li><a href="'.$admin_url.'"><img src="'.$img.'" width="16" height="16" border="0" alt="'.$main_name.'" />&nbsp;&nbsp;<span class="lnk">'.$main_name.'</span></a>';
			}


		$rs_query = "SELECT * FROM ".$prev."adminmenu
						WHERE status = 'Y'
						AND parent_id = '".$rw['id']."'
						ORDER BY ord ASC, name ASC";
		$rs = mysql_query($rs_query);

		if(@mysql_num_rows($rs))
		{
			echo "<ul>";

			while($d = @mysql_fetch_array($rs))
			{
				$sub_name = stripslashes( $d['name'] );
				$sub_pic = $d['pic'];

				if(empty($d['pic']) || !file_exists($d['pic'])) {
					$sub_pic = $img;
				}

				if(!empty($d['url']))
					$admin_url2 = $d['url'];
				else
					$admin_url2 = "#";

				echo '<li><a href="'.$admin_url2.'"><img src="'.$sub_pic.'" width="16" height="16" border="0" alt="'.$sub_name.'" />&nbsp;&nbsp;<span class="lnk">'.$sub_name.'</span></a></li>';
			}

			echo "</ul>";
		}
		echo "</li>";
		}
	}
?>
</ul>
<?php } ?>
	</td>
  </tr>
</table>