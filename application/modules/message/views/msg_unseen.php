<?php
if(!function_exists('get_file_icon')){
	
	
	function get_file_icon($file_name=''){
		
		$icons = array(
			'doc' => DOC_ICON,
			'docx' => DOC_ICON,
			'pdf' => PDF_ICON,
			'txt' => TXT_ICON,
		);
		$default_file_icon = COMMON_ICON;
		
		$file_part = explode('.', $file_name);
		$file_ext = trim(end($file_part));
		
		if(!empty($icons[strtolower($file_ext)])){
			$file_icon = $icons[strtolower($file_ext)];
		}else{
			$file_icon = $default_file_icon;
		}
		
		return $file_icon;
		
	}
	
}

$lst_date = '';
if(count($unseen_msg)>0){

foreach($unseen_msg as $key => $val){
$sender_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$sendID));
$sender_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$sendID));    
$sender_logo=$this->auto_model->getFeild('logo','user','user_id',$val['sender_id']);

if($sender_logo && file_exists('assets/uploaded/cropped_'.$sender_logo)){
	$sender_logo = 'cropped_'.$sender_logo;
}

$logo=($sender_logo)?'uploaded/'.$sender_logo:'images/user.png';

$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$val['sender_id']);     
$status=((time()-60) > $last_seen)?false:true;
$reciever_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$user_id));
$reciever_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$user_id));

$attachment  = array();
if(!empty($val['attachment'])){
	$attachment  = (array) json_decode($val['attachment']);
	
}
 

if($lst_date != date('Y-m-d', strtotime($val['add_date']))){
 	$lst_date = date('Y-m-d', strtotime($val['add_date']));
	/* echo '<p class="chat_date"><span>'.date('d M, Y', strtotime($val['add_date'])).'</span></p>'; */
} 

?>

<div class="message-bubble <?php echo $val['sender_id'] == $user_id ? 'me' : 'other';?>">

<div class="message-bubble-inner">
<div class="message-text">
<?php if(!empty($attachment)){ ?>
	<div class="file_attach">
	<?php if($attachment['is_image'] == 1){ ?>
	<img src="<?php echo ASSETS.'question_file/'.$attachment['file_name'];?>" class="materialboxed responsive-img" style="max-width:200px"/>
	<?php }else{  ?>
	<a href="<?php echo ASSETS.'question_file/'.$attachment['file_name'];?>" target="_blank"><img src="<?php echo get_file_icon($attachment['file_name']);?>" alt=""> <?php echo $attachment['org_file_name'];?></a> <a href="<?php echo ASSETS.'question_file/'.$attachment['file_name'];?>" target="_blank" download><i class="zmdi zmdi-download zmdi-20x"></i></a>
	<div class=""><small><?php echo round($attachment['file_size']);?> KB</small></div>

	<?php } ?>
	</div>
<?php } ?>

<p><?php echo $val['message'];?>

<?php if(isset($val['attachment'])){ ?>

<a href="<?php echo VPATH;?>assets/question_file/<?php echo $attachment['file_name']?>" target="_blank"><?php echo  $attachment['org_file_name'];?></a>
<?php } ?>
<span class="msgTime">
<?php echo ucwords(date('h:i A',strtotime($val['add_date'])));?> 
<?php if($val['sender_id']==$user_id){ ?>
<?php echo $val['read_status'] == 'Y' ? '<i class="zmdi zmdi-check-all site-text"></i>' : '<i class="zmdi zmdi-check grey-text"></i>'; ?>
<?php } ?>
</span>


<span class="starred">
<?php
if(!in_array($val['id'] , $fav_msg)){
?>
<i class="zmdi zmdi-star add_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']; ?>"></i>
<?php
}else{
?>
<i class="zmdi zmdi-star remove_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']; ?>"></i>
<?php	
}
?>
</span>
</p> 
</div>
<div class="clearfix"></div>
</div>
</div>
<?php
}
}
?>