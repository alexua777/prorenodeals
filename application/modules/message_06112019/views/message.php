<?php // echo $breadcrumb;?> 

<script src="<?=JS?>mycustom.js"></script>
<style type="text/css">
.remove_fav {
    color: #52bf28
}
 .messagtext2.unread {
    background: #EAE1E1;
}
.select2-container.select2-container--default.select2-container--open{
	    z-index: 999999999;
}
#myModal2 .nice-select{
	display: none;
}
.select2{
	width: 100% !important;
}	
.posted_by_name span{
	font-size: 14px;
}

.leftWidth {
	height: 468px;
	overflow: auto;
}
.left_User {
   height: 516px;
   overflow: auto;
   padding-top: 15px;
}
.posted_by_name .col-sm-2.col-xs-12{
	padding-right: 0;
}

.col-3-outer {
    border: none;
}

.info.grey {
    border: 1px solid #b9b3b3;
    padding: 10px;
    margin-top: 16px;
    background: #f3efef;
    /* text-align: center; */
    border-left: 3px solid #b9b3b3;
    font-weight: bold;
}

</style>
<link rel="stylesheet" href="<?php echo ASSETS.'css/select2.min.css'?>" type="text/css"/>
<script type="text/javascript">
	var createroom=function(){
		var data=$('#newroom').serialize();
		
		$.post( "<?php echo base_url('message/addroom')?>",data).success(function(response){
			$('#newroom').find("input[type=text], textarea").val("");
			$("#myModal").find('.close').trigger('click');
			response=jQuery.parseJSON(response);
			console.log(response.message);
			$('#allrooms').append(response.room);
			roomdetails(response.data);
		});
	};
	var roomdetails=function(roomid){
		var data={roomid:roomid};
		$.post( "<?php echo base_url('message/roomusers')?>",data).success(function(response){
			
			$('#roompeople').html(response);
		});
	}
	var addusertoroom=function(){
		var data=$('#addusers').serialize();
		data=data+'&roomid='+$('#hiddenroom').val();
		console.log($('#hiddenroom').val());
		$.post( "<?php echo base_url('message/addusers')?>",data).success(function(response){
			$('#addusers').find("select").val("");
			$("#myModal2").find('.close').trigger('click');
			roomdetails($('#hiddenroom').val());
		});
	}
</script>

<div id="myModal2" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" style="border-radius:0px;">
			<form action="" method="post" id="addusers">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" onclick="javascript:$('#myModal2').modal('hide');">&times;</button>
					<h4 class="modal-title"><?php echo __('message_add_user_to_room','Add users to room'); ?></h4>
				</div>
				<div class="modal-body">
				
					<div class="form-group">
						<label for="room_name"><b><?php echo __('message_choose_users','Choose users'); ?></b></label> <br/>
						<select id="example-getting-started" name="roomusers[]" multiple="multiple">
						    <?php foreach($allusers as $user){?>
						    	<option value="<?php echo $user['user_id'];?>"><?php echo $user['fname'].' '.$user['lname'] ;?></option>
						    	<?php }?>
						</select> 
						<!-- <input type="text" id="peopleauto" name="roomusers[]"> -->
						<input type="hidden" id="hiddenroom" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="addusertoroom()"><?php echo __('message_add_users','Add Users'); ?></button>
					<button type="button" data-dismiss="modal" class="btn btn-default" onclick="javascript:$('#myModal2').modal('hide');"><?php echo __('message_close','Close'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="">
<div class="container-fluid">
<div class="outer row">

<aside class="col-md-3 col-sm-4 col-xs-12 p-0">
<div class="sidebar unique-sidebar">

<?php //echo $leftpanel;?>

<div class="well-style">
<ul class="right-ic hide">
<li>
<button type="button" class="toggle_btn btn btn-primary-outline active" data-tab="chat"><i class="fa fa-comments"></i></button><button type="button" class="toggle_btn btn btn-secondary-outline" data-tab="list"><i class="fa fa-tasks"></i></button>
</li>
<li class="pull-right hidden">
<a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a>
</li>
</ul>
</div>

<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content" style="border-radius:0px;">
<form action="" method="post" id="newroom">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" onclick="javascript:$('#myModal').modal('hide');">&times;</button>
<h4 class="modal-title">Create a New Room</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label for="room_name">Room Name</label>
<input type="text" class="form-control" id="room_name" name="room_name" placeholder="What do you want to call this room ?">
</div>
<div class="form-group">
<label for="people">Topic</label>
<input type="text" class="form-control" id="topic" name="topic" placeholder="Add a topic to the room">
</div>
<div class="form-group">
<label for="people">Message</label>
<textarea name="msg" style="min-height: 100px" placeholder="Type your message..." class="form-control"></textarea>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="createroom()">Create</button>
<button type="button" class="btn btn-default" onclick="javascript:$('#myModal').modal('hide');">Close</button>
</div>
</form>
</div>

</div>
</div>

<div id="fav_msg_modal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content" style="border-radius:0px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="javascript:$('#fav_msg_modal').modal('hide');">&times;</button>
		<h4 class="modal-title"><?php echo __('message_favorite_message','Favorite message'); ?></h4>
	</div>
	
	<div class="modal-body clearfix">
		<p>Demo message</p>	
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" onclick="javascript:$('#fav_msg_modal').modal('hide');"><?php echo __('message_close','Close'); ?></button>
	</div>

</div>

</div>
</div>

<div class="profile_right">
<!--Message Start-->

<div class="editprofile msg-left">
<!--<div class="messagtext"><h2><strong>PROJECTS</strong></h2></div>-->

<!--Auto Compleate-->
<div class="left-autocomplete">
<div class="input-group input-group-lg hide">
<span class="input-group-addon"><i class="fa fa-search"></i></span>
<input class="form-control searchinput" placeholder="<?php echo __('message_search','Search'); ?>" type="text" id="tags" style="background:none;">
</div>

<!--dropdown-->
<select style="display: none;" id="select_msg">
<option value=""><?php echo __('message_recent','Recent'); ?></option>
<option value="N"><?php echo __('message_unread','Unread'); ?></option>
<!--<option value="4">Potato</option>-->
</select>
<div class="nice-select wide" tabindex="0" id="select-msg">
<span class="current"><?php echo __('message_recent','Recent'); ?></span><ul class="list"><li data-value="" class="option selected focus"><?php echo __('message_recent','Recent'); ?></li><li data-value="N" class="option"><?php echo __('message_unread','Unread'); ?></li></ul></div>
<!--dropdown-->

</div>
<!--Auto Compleate-->
<div class="clearfix"></div>
<script>
function rampage(projectid,senderid , ele){
var window_w = $(window).width();
if(window_w <= 767){
	var detail_frg = $('.chat-section');
	var list_frg = $('.sidebar');
	list_frg.hide();
	detail_frg.removeClass('hidden-xs');
}	
$('.left_User').find('.active').removeClass('active');
$(ele).addClass('active');

$(ele).parents('.messagtext2').find('.msg-count').hide();
/* $(ele).parents('.messagtext2').find('#unread').html("");
$(ele).parents('.messagtext2').find('#unread').hide(); */

	var evt = window.event;
	evt.preventDefault();
	
	$.ajax({
		type:"POST",
		url:"<?php echo VPATH;?>message/detailsmsg/"+projectid+"/"+senderid,
		success:function(data){

		var actionURL = "<?php echo VPATH;?>message/details/"+senderid+'/'+projectid;   
		$("#project_id").val(projectid);
		$("#recipient_id").val(senderid);	
		//$("#output").hide();
		//$("#output2").show();
		$("#msg_content").html(data);
		$("#myform").attr('action',actionURL);
		$("#myform").show();
		myscroll();
		$(".leftWidth").niceScroll();	
			history.pushState('', '', '<?php echo base_url('message/browse')?>/'+projectid+'/'+senderid);

		}
		
	});
	
	return false;
}

$(document).ready(function(){
$(window).load(function() {
$('span.menu').addClass('active');
});
$("a#anchor").click(function(){
$("a.active").removeClass("active");
$(this).addClass("active");
});
});
</script>
<span id="lft_content">
<div class="left_User">
<?php
$user=$this->session->userdata('user');


$names = array();
if(count($all_messages)>0){

foreach($all_messages as $key=>$val) {   
if($val['project_id'] == ''){
	continue;
}   
$project_name=htmlentities($this->auto_model->getFeild('title','projects','project_id',$val['project_id']));
if(empty($project_name)){
	$project_name = 'Project Deleted';
}
//Sender
if($val['sender_id'] != $user_id){
	$sender_fname=htmlentities($this->auto_model->getFeild('fname','user','user_id',$val['sender_id']));
	$sender_lname=htmlentities($this->auto_model->getFeild('lname','user','user_id',$val['sender_id'])); 
}else{
	$sender_fname=htmlentities($this->auto_model->getFeild('fname','user','user_id',$val['recipient_id']));
	$sender_lname=htmlentities($this->auto_model->getFeild('lname','user','user_id',$val['recipient_id'])); 
}


$nm['label'] = htmlentities($sender_fname." ".$sender_lname);

if(strlen($project_name) > 30){
	$p_nm = substr($project_name, 0, 30).'...';
	$nm['label'] .= " - ".$p_nm ;
}else{
	$nm['label'] .= " - ".$project_name ;
}

$nm['value'] = htmlentities($sender_fname." ".$sender_lname);
$nm['project'] = $val['project_id'];
if($val['sender_id'] == $user_id){
	$nm['sender'] = $val['recipient_id'];
}else{
	$nm['sender'] = $val['sender_id'];
}

array_push($names , $nm);
//Receiver


$recipient_fname=htmlentities($this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id));
$recipient_lname=htmlentities($this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id)); 

$val['sender_user'] = '';
if($val['sender_id'] != $user_id){
	$val['sender_user']  = $val['sender_id'];
}else{
	$val['sender_user']  = $val['recipient_id'];
}

if(($val['sender_user'] > 0 == false)){
	continue;
}

?>

<div class="messagtext2" id="msg_project_<?php echo $val['project_id'];?>">
<?php
if($val['unread_msg'] > 0)
{
 
?>
<div class="msg-count"><span class="notification" id="head_noti" style=""><?php echo ($val['unread_msg'] > 0) ? $val['unread_msg'] : ''; ?></span></div>
<?php
}
?>

<div class="setting-circle dropdown hidden"><i class="fa fa-ellipsis-h"></i>
	<button class="menu_hide btn btn-xs btn-site" style="display:none;" data-project="<?php echo $val['project_id'];?>"><?php echo __('message_hide','Hide'); ?></button>
</div>
<a href="#" id="anchor" onclick="rampage('<?php echo $val['project_id'];?>','<?php echo $val['sender_user'];?>' , $(this));" class="<?php echo ($val['project_id'] == $project_id && $val['sender_user'] == $project_user) ? 'active' : '';?>" data-project-id="<?php echo $project_id;?>" data-project-user="<?php echo $project_user; ?>">
<i class="far fa-comment"></i>
<span class="menu"><?php echo $sender_fname; ?> , <?php echo $recipient_fname;?></span>
<p><?php if(isset($project_name)){ echo strlen($project_name) > 25 ? substr($project_name, 0, 25).'...' : $project_name; }?></p></a>
<?php 
$result = $this->db->query("SELECT message FROM `serv_message` WHERE project_id='".$val['project_id']."' order by id desc limit 1");
$data=filter_data($result->row_array());?>
<p style="font-weight:normal;padding:5px 0px; display:none;"><?php if(strlen($data['message'])>10){ echo substr($data['message'],0,10).'....'; } else { echo $data['message']; } ?></p>

</div> 
<?php }  } else { ?>
<div class="myprotext"><p><strong style="padding: 36px; position: relative; width: 100%;"><?php echo __('message_no_projects_found','No Projects found!'); ?></strong></p></div>
<?php } ?>	 	 
<p id="pagi">
<?php  

if(isset($links))
{                     
//echo $links;   
}
?> 
</p>

</div>
<?php if(count($all_messages)> $per_page){ ?>
<a href="javascipt:void(0);" class="btn btn-warning btn-block" id="l_more_lft_msg"><?php echo __('message_load_more','Load more'); ?></a>
<?php } ?>
<!--Message End-->
</span>

<span id="lft_content2" style="display:none;">
<div class="left_User">
<h3 style="margin:0px; padding-left: 10px;"><?php echo strtoupper(__('message_favorites','FAVORITES')); ?></h3>
<p style="padding: 20px; "><a href="#" data-toggle="modal" data-target="#fav_msg_modal"><?php echo __('message_favorite_message','Favorite Messages'); ?></a></p>
<h3 style="margin:0px; padding-left: 10px;"><?php echo strtoupper(__('message_interviews','INTERVIEWS')); ?></h3>
<?php
$user=$this->session->userdata('user');


//$names = array();
if(count($all_messages)>0){
foreach($all_messages as $key=>$val) {      
$project_name=filter_data($this->auto_model->getFeild('title','projects','project_id',$val['project_id']));

//Sender
if($val['sender_id'] != $user_id){
	$sender_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$val['sender_id']));
	$sender_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$val['sender_id'])); 
}else{
	$sender_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$val['recipient_id']));
	$sender_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$val['recipient_id'])); 
}

//Receiver
$recipient_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id));
$recipient_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id)); 


$val['sender_user'] = '';
if($val['sender_id'] != $user_id){
	$val['sender_user']  = $val['sender_id'];
}else{
	$val['sender_user']  = $val['recipient_id'];
}

?>

<div class="messagtext2">
<div class="setting-circle dropdown"><i class="fa fa-ellipsis-h"></i></div>
<p><a id="anchor" href="#" onclick="rampage('<?php echo $val['project_id'];?>','<?php echo $val['sender_user'];?>' , $(this));"><span class="menu"><?php echo $sender_fname; ?> , <?php echo $recipient_fname;?></span></a></p>
<?php 
$result = $this->db->query("SELECT message FROM `serv_message` WHERE project_id='".$val['project_id']."' order by id desc limit 1");
$data=$result->row_array();?>
<a id="anchor" href="#" onclick="rampage('<?php echo $val['project_id'];?>','<?php echo $val['sender_user'];?>' , $(this));"><?php if(isset($project_name)){ echo strlen($project_name) > 25 ? substr($project_name, 0, 25).'...' : $project_name;}?></a>

</div> 
<?php }  } else { ?>
<div class="myprotext"><p><strong style="padding: 36px; position: relative; width: 100%;"><?php echo __('message_no_projects_found','No Projects found!'); ?></strong></p></div>
<?php } ?>	 	 
<p id="pagi">
<?php  

if(isset($links))
{                     
//echo $links;   
}
?> 
</p>
<div class="clearfix"></div>

</div>
<!--Message End-->
</span>
</div>
</div>                       

<!-- Left Section End -->
</div>
</aside>

<aside class="col-md-9 col-sm-8 col-xs-12 p-0">
<div class="chat-section unique-left hidden-xs" id="msg_content">
<div class="top-setting-bar">
<?php if($project_id){ $project_info = filter_data($project_info); 
$user_info = filter_data($user_info);
$receiver_logo = $user_info['logo'];
if($receiver_logo && file_exists('./assets/uploaded/cropped_'.$receiver_logo)){
	$receiver_logo = 'cropped_'.$receiver_logo;
}
$logo=($receiver_logo)?'uploaded/'.$receiver_logo:'images/user.png';
$last_seen=$user_info['last_seen'];    
$status=((time()-60) > $last_seen)?false:true;
?>
<div class="message-avatar">
<figure class="profile-imgEc">
<img src="<?php echo ASSETS.$logo?>" alt="">
<?php if($status) {?>
<div class="online-sign"></div>
<?php }else{?>
	<div class="online-sign" style="background:#ddd"></div>
	<?php }?>
</figure>
</div>
<h3><a href="javascript:void(0)" class="backArrow" onclick="showListFragment()"><i class="fas fa-arrow-left"></i></a> <?php echo !empty($user_info['fname']) ? $user_info['fname'].' '.$user_info['lname'] : '';?> <span class="star-style"><i class="fa fa-star"></i></span><br/>
<?php 
$p_link = base_url('jobdetails/details/'.$project_id.'/'.seo_string($project_info['title']));
$p_sts = getField('status', 'projects', 'project_id', $project_id);
if(is_bidder($user_id, $project_id)){
	$p_link = base_url('projectroom/freelancer/overview/'.$project_id);
}
if(is_employer($user_id, $project_id)  && ($p_sts != 'O' && $p_sts != 'E' && $p_sts != 'S')){
	$p_link = base_url('projectroom/employer/overview/'.$project_id);
}
?>
<small> <a href="<?php echo $p_link; ?>"><?php echo !empty($project_info['title']) ? $project_info['title'] : '';?></a></small>
</h3>

<?php } ?>

<ul class="pull-right hide">
<?php if(count($messages) > 0){ ?>
<li class="mar-lft-10"><a href="#" title="<?php echo __('message_files','Files'); ?>" class="toggle_file"><i class="fa fa-file"></i></a></li>
<li class="mar-lft-10"><a href="#" title="<?php echo __('message_people','People'); ?>" class="toggle_user"><i class="fa fa-user"></i></a></li>
<?php } ?>
</ul>
</div>

<!--ProfileRight Start-->
<div class="profile_right profile_right_mofify">
<!--MessageDetais Start-->

<div class="row">
<div class="col-sm-8 col-12" id="msg_wrap">
<div class="editprofile whiteBg message-content" id="output" >
<?php 
if(!empty($project_id)){
$sender = $user_info['fname']. ' '.$user_info['lname'] ;
$project_name=$project_info['title'];

}
?>
<div class="leftWidth message-content-inner">

<?php

$user = '';
$user2 = '';
$admin_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$user_id));
$admin_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$user_id));

$u1_logo = $this->auto_model->getFeild('logo','user','user_id',$user_id);
if($u1_logo && file_exists('./assets/uploaded/cropped_'.$u1_logo)){
	$u1_logo = 'cropped_'.$u1_logo;
}
$u1_logo = ($u1_logo) ? 'uploaded/'.$u1_logo : 'images/user.png';
$u1_last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$user_id);     
$u2_last_seen = $u2_logo = $u2_status = '';
$u1_status=((time()-60) > $u1_last_seen)?false:true;

$user = $admin_fname." ".$admin_lname;


$p_user_f=$this->auto_model->getFeild('fname','user','user_id',$project_user);
$p_user_l=$this->auto_model->getFeild('lname','user','user_id',$project_user);


$user2 = filter_data($p_user_f . " ". $p_user_l);
$u2_logo = $this->auto_model->getFeild('logo','user','user_id',$project_user);
if($u2_logo && file_exists('./assets/uploaded/cropped_'.$u2_logo)){
	$u2_logo = 'cropped_'.$u2_logo;
}
$u2_logo = ($u2_logo) ? 'uploaded/'.$u2_logo  : 'images/user.png';
$u2_last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$project_user);     
$u2_status=((time()-60) > $u2_last_seen)?false:true;
	
	
$people = array();

if(count($messages)>0) { foreach($messages as $key=>$val) {
$sender_fname=filter_data($this->auto_model->getFeild('fname','user','user_id',$val['sender_id']));

$sender_lname=filter_data($this->auto_model->getFeild('lname','user','user_id',$val['sender_id']));
$sender_logo=filter_data($this->auto_model->getFeild('logo','user','user_id',$val['sender_id']));
if($sender_logo && file_exists('./assets/uploaded/cropped_'.$sender_logo)){
	$sender_logo = 'cropped_'.$sender_logo;
}
$logo=($sender_logo)?'uploaded/'.$sender_logo:'images/user.png';

$last_seen=$this->auto_model->getFeild('last_seen','user','user_id',$val['sender_id']);     
$status=((time()-60) > $last_seen)?false:true;
?>

<p class="message-time-sign chat_date"><?php echo date('d M, Y H:i:s',strtotime($val['add_date']));?></p>
<div class="message-bubble <?php echo $val['sender_id']==$user_id ? 'me' : 'other';?>" id="message_one_<?php echo $val['id']?>">
<div class="message-bubble-inner">
<?php if($val['sender_id']!=$user_id) {?>
<div class="message-avatar">
<figure class="profile-imgEc">
<img src="<?php echo ASSETS.$logo?>" alt="">
<?php if($status) {?>
<div class="online-sign"></div>
<?php }else{?>
	<div class="online-sign" style="background:#ddd"></div>
	<?php }?>
</figure>
</div>
<?php } ?>
<div class="message-text">
<!--<div class="arrow"></div>-->
<!--<em><a target="_blank" href="<?php // echo VPATH."clientdetails/showdetails/".$val['sender_id'] ?>"><?php // if($val['sender_id']==$user_id){echo "Me";}else{echo ucwords($sender_fname)." ".ucwords($sender_lname);}?></a></em>-->
<div id="txt_msg">
<p><?php echo $val['message'];?>

<?php if(isset($val['attachment'])){ ?>

<a href="<?php echo VPATH;?>assets/question_file/<?php echo $val['attachment']?>" target="_blank"><?php echo $val['attachment'];?></a>

<?php } ?>
<?php if($val['sender_id']==$user_id){ ?><span class="chat_date <?php echo $val['read_status'] == 'Y' ? '' : 'sent_msg'; ?>"><?php echo $val['read_status'] == 'Y' ? '<i class="zmdi zmdi-check-all"></i>' : '<i class="zmdi zmdi-check"></i>'; ?></span><?php } ?>
</p> 
</div>

<span class="starred">
<?php
if(!in_array($val['id'] , $fav_msg)){
?>
<i class="fa fa-star add_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
<?php
}else{
?>
<i class="fa fa-star remove_fav" style="cursor:pointer" data-msg-id="<?php echo $val['id']?>"></i>
<?php	
}
?>
</span>
</div>


</div>
<div class="clearfix"></div>
</div>

<?php } }  else {

echo "<div class='noConversation'>".__('message_no_conversation_yet','No conversation yet..')."</div>";	

}

?>
</div>
<div class="loaded " style="display:none;text-align: right;padding: 5px;position: absolute;right: 0px;margin-top: 10px;margin-right: 90px;z-index: 99;"><i class="fa fa-spinner fa-spin "></i></div>
</div>
<div class="editprofile editprofile-form">

<?php  
$page_url=current_url();
$exp=explode('/',$page_url);
$expLastValue= end($exp);
?>

<form method="post" name="uploadmessage"  id="myform" action="" enctype="multipart/form-data" style="<?php if(empty($project_id) || empty($project_user)){ ?>display:none; <?php } ?>">

<input type="hidden" name="recipient_id" id="recipient_id" value="<?php if(isset($project_user)){ echo $project_user;}?>"/>

<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $user_id;?>"/>

<input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id; ?>"/>
<input type="hidden" name="page_id" id="page_id" value="<?php if(isset($page_number)) { echo $page_number;}?>"/>

<div class="acount_form inputBox">
<div class="input-group">
<textarea id="message" name="message" class="form-control" placeholder="Write your message here"></textarea>
<!--<div class="acount_form linkButton"><input type="file" name="userfile" size="30" class="acount-input"></div>-->
<span class="input-group-btn">
    <span class="btn btn-default btn-file"><i class="fa fa-paperclip"></i>
    <input type="file" name="userfile" onchange="update_file_count(this);">
	<span id="filecount" class="badge" style="hidden"></span>
    </span>
</span>
<span class="input-group-btn">
    <button type="submit" name="submit" id="newsubmit" class="btn btn-default" title=""><i class="fa fa-paper-plane"></i></button>
    <!--<input type="button" name="button" class="btn-normal btn-color submit bottom-pad2" value="Cancel" onClick="javascript:window.history.back(-1);">-->    
</span>
</div>

<div class="error-msg2" style="margin:0"><?php echo form_error('message'); ?></div>

  
</div>

</form>

</div>
</div>
 <?php if($project_id){ ?>   
<div class="col-sm-4 col-12 p-0 hidden-xs hide" id="more_people">
<div class="col-3-outer">
<h3><?php echo __('message_people','People'); ?> <!--<span class="pull-right" data-toggle="modal" data-target="#myModal2"><a href="#"><i class="fa fa-plus"></i></a></span>--></h3>
<div id="roompeople"></div>
<div class="conversation_loop">
<div class="media">
<div class="media-left">
<figure class="profile-imgEc">
<img src="<?php echo ASSETS.$u1_logo;?>" alt="">
<?php if($u1_status){ ?>
<div class="online-sign"></div>
<?php } else{ ?>
<div class="online-sign" style="background:#ddd"></div>
<?php } ?>
<div class="online-sign"></div>

</figure>
</div>

<div class="media-body media-middle">
<?php echo ucwords($user); ?><br> 
</div>
</div>
</div>

<div class="conversation_loop">
<div class="media">
<div class="media-left">
<figure class="profile-imgEc">
<img src="<?php echo ASSETS.$u2_logo;?>" alt="">
<?php if($u2_status){ ?>
<div class="online-sign"></div>
<?php } else{ ?>
<div class="online-sign" style="background:#ddd"></div>
<?php } ?>
</figure>
</div>
<div class="media-body media-middle">
<?php echo ucwords($user2);?><br>
</div>
</div>
</div>

</div>
</div>


<div class="col-sm-4 col-12 hidden-xs" id="files_list">
<div class="col-3-outer">
<h3><?php echo __('message_files','Files'); ?></h3>
<div class="attachment_sec">
<?php 
if(isset($messages) AND count($messages) > 0){
		foreach($messages as $k => $v){
			if(!empty($v['attachment'])){
				echo '<p><a class="" href="'.VPATH.'assets/question_file/'.$v['attachment'].'" target="_blank">'.$v['attachment'].'</a></p>';
			}
		}
}
?>
</div>

</div>
</div>

<?php } ?>
</div>    
</div>


<?php /*
<div class="messageBox">
<div class="acount_form inputBox"><textarea rows="3" id="message" name="message" class="acount-input"></textarea>
<div class="error-msg2"><?php echo form_error('message'); ?></div>
</div>
<div class="acount_form linkButton"><input type="file" name="userfile" size="30" class="acount-input"><br/><h3><span style="color:red;width:100%;float:left">File must be zip ,jpg ,jpeg ,gif ,png ,doc ,docx ,pdf ,xls ,xlsx ,txt.</span></h3></div>
</div>
<div class="masg3">
<input type="submit" name="submit" id="newsubmit" class="btn-normal btn-color submit submitnew bottom-pad2" title="" value="Submit" >
<input type="button" name="button" class="btn-normal btn-color submit bottom-pad2" value="Cancel" onClick="javascript:window.history.back(-1);">
</div>   
*/?>
</form>

</div>

</aside>

</div>
</div>

</div>

<script src="<?php echo JS;?>jquery.nicescroll.min.js"></script>
<script>
$(document).ready(function() {  	    
	$(".leftWidth").niceScroll();
	$(".left_User").niceScroll();
});
  
  function showListFragment(){
	  
	var window_w = $(window).width();
	 if(window_w <= 768){
		 var detail_frg = $('.chat-section');
		 var list_frg = $('.sidebar');
		 list_frg.show();
		 detail_frg.addClass('hidden-xs');
	  }  
  }
</script>
<!--<script src="<?php // echo JS;?>jquery.min.js"></script>-->
<script>

$(document).ready(function(){
$('.toggle_btn').click(function(){
$('.toggle_btn').removeClass('active');
$(this).addClass('active');
var tab = $(this).attr('data-tab');
if(tab == 'list'){
$('#lft_content').hide();
$('#lft_content2').show();
$('#select-msg').hide();
}
if(tab == 'chat'){
$('#lft_content2').hide();
$('#lft_content').show();
$('#select-msg').show();
}
});

});
var interview = [
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"},
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"},
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"},
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"},
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"},
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"},
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"}
];

var rooms = [
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"},
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"},
{"user" : "Host , SmartBuzz" , "project" : "Website development" , "lst_msg" : "I will work on this project"}
];

function load_list(){
html = '';
html += '<div class="left_User">';
if(interview.length > 0){
html += '<h3>Interviews</h3>';
$.each(interview , function(index , item){
if(item['lst_msg'].length > 18){
msg = item['lst_msg'].substring(0 , 10) + "...";
}else{
msg = item['lst_msg'];
}
html += '<div class="messagtext2"><div class="setting-circle dropdown"><i class="fa fa-ellipsis-h"></i></div><p><a id="anchor" onclick="alert(\'loading..\');"><span class="menu">'+item['user']+'</span></a></p><h4><a id="anchor" onclick="alert(\'loading..\');" style="cursor: pointer;">'+item['project']+'<br><p style="font-weight:normal;padding:5px 0px;">'+msg+'</p></a></h4></div>';
});
}

if(rooms.length > 0){
html += '<h3>Rooms</h3>';
$.each(rooms , function(index , item){
if(item['lst_msg'].length > 18){
msg = item['lst_msg'].substring(0 , 10) + "...";
}else{
msg = item['lst_msg'];
}
html += '<div class="messagtext2"><div class="setting-circle dropdown"><i class="fa fa-ellipsis-h"></i></div><p><a id="anchor" onclick="alert(\'loading..\');"><span class="menu">'+item['user']+'</span></a></p><h4><a id="anchor" onclick="alert(\'loading..\');" style="cursor: pointer;">'+item['project']+'<br><p style="font-weight:normal;padding:5px 0px;">'+msg+'</p></a></h4></div>';
});
}

html += '</div>';

$('#lft_content').html(html); 
}
</script>


<script type="text/javascript">
$(document).ready(function(){
function addStyleAttribute($element, styleAttribute) {
$element.attr('style', $element.attr('style') + '; ' + styleAttribute);
}
$("#output2").hide();
$('.submitnew').attr('disabled',true);
$('.submitnew').attr('title','Please enter a message');
$('.submitnew').attr('disabled',true);
$('.submitnew').css("background", "#f2f2f2");
$('.submitnew').css("border", "1px solid #ccc");
addStyleAttribute($('.submitnew'), 'color: #999 !important');
$('.submitnew').css("border-radius", "0");
addStyleAttribute($('.submitnew'), 'text-shadow: none !important');
$('.submitnew').css("box-shadow", "none !important");
$('.submitnew').css("font-size", "14px");

$(document).on('keydown' , '#message' , function(e){
	if(e.which == 13){
		e.preventDefault();
		send_msg();
	}
});

$(document).on('click' , '#newsubmit' , function(e){
	e.preventDefault();
	send_msg();
});

$(document).on('keyup' , '#message' , function(){
//$('#message').keyup(function(){
if($(this).val().length !=0){
$('.submitnew').attr('disabled', false); 
$('.submitnew').attr('title','');
$('.submitnew').css("background", "rgba(0, 0, 0, 0) linear-gradient(#8abc08, #597a03) repeat scroll 0 0");
$('.submitnew').css("border", "1px solid #597a03");
$('.submitnew').css("color", "#fff");
$('.submitnew').css("border-radius", "3px");
$('.submitnew').css("padding", "5px");
$('.submitnew').css("width", "19%");
}
else
{

$('.submitnew').attr('disabled', true); 
$('.submitnew').attr('title','Please enter a message');			
$('.submitnew').attr('disabled',true);
$('.submitnew').css("background", "#f2f2f2");
$('.submitnew').css("border", "1px solid #ccc");
addStyleAttribute($('.submitnew'), 'color: #999 !important');
$('.submitnew').css("border-radius", "0");
addStyleAttribute($('.submitnew'), 'text-shadow: none !important');
$('.submitnew').css("box-shadow", "none !important");
$('.submitnew').css("font-size", "14px");		

}
})
});
</script>
<script src="<?=JS?>jquery.nice-select.min.js"></script>
<link rel="stylesheet" href="<?=CSS?>nice-select.css" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script>
$(document).ready(function() {
setInterval(refresh_chat , 2000);

$('select').niceSelect();      


$(document).on('click' , '.add_fav' , function(){
var msg_id = $(this).attr('data-msg-id');
add_msg_fav(msg_id , $(this));
});

$(document).on('click' , '.remove_fav' , function(){
var msg_id = $(this).attr('data-msg-id');
remove_msg_fav(msg_id , $(this));
});


$(document).on('click' , '.toggle_user' , function(){
	var ele = $('#msg_wrap');
	var ele2 = $('#more_people');
	if(ele2.is(':visible')){
		ele2.hide();
		ele.removeClass('col-sm-8');
		ele.addClass('col-sm-12');
	}else{
		ele2.show();
		$('#files_list').hide();
		ele.removeClass('col-sm-12');
		ele.addClass('col-sm-8');
	}
	/*$('#files_list').hide();
	var ele = $('#msg_wrap');
	var ele2 = $('#more_people');
	if(ele.is('.col-sm-12')){
		ele.removeClass('col-sm-12');
		ele.addClass('col-sm-8');
		ele2.show();
	}else if(ele.is('.col-sm-8')){
		ele.removeClass('col-sm-8');
		ele.addClass('col-sm-12');
		ele2.hide();
	}*/
});

$(document).on('click' , '.toggle_file' , function(){
	var ele = $('#msg_wrap');
	var ele2 = $('#files_list');
	if(ele2.is(':visible')){
		ele2.hide();
		ele.removeClass('col-sm-8');
		ele.addClass('col-sm-12');
	}else{
		ele2.show();
		$('#more_people').hide();
		ele.removeClass('col-sm-12');
		ele.addClass('col-sm-8');
	}
	/*$('#more_people').hide();
	
	if(ele.is('.col-sm-12')){
		ele.removeClass('col-sm-12');
		ele.addClass('col-sm-8');
		ele2.show();
	}else if(ele.is('.col-sm-8')){
		
		ele2.hide();
	}*/
});


$('#select_msg').change(function(){
	var val = $(this).val();
	var url = "<?php echo VPATH; ?>message/get_left_msg/"+val;
	var active_project = $('#lft_content').find('a.active').attr('data-project-id');
	var project_user = $('#lft_content').find('a.active').attr('data-project-user');
	if(active_project && project_user){
		url += '?active_project='+active_project;
		url += '&project_user='+project_user;
	}
	$.get(url , function(data){
		$('#lft_content .left_User').html(data);
	});
});

$(document).on('click' , '.dropdown' , function(){
	//alert('sdfsf');
	$(this).find('.menu_hide').toggle();
});

$(document).on('click' , '.menu_hide' , function(){
	var ele = $(this);
	var msg_p = $(this).attr('data-project');
	$.get('<?php echo VPATH;?>message/hide_msg/'+msg_p , function(res){
		if(res == 1){
			ele.parents('.messagtext2').remove();
		}
	});
	
});

$('#fav_msg_modal').on('show.bs.modal' , function(){
	var content_bx = $(this).find('.modal-body');
	$.ajax({
		url:"<?php echo VPATH;?>message/get_fav_msg",
		beforeSend: function(){
			content_bx.html('<p>Loading....</p>');
		},
		success: function(res){
			content_bx.html(res);
		}
	});
});

$('#l_more_lft_msg').click(function(e){
	e.preventDefault();
	load_more_msg();
});

});    
</script>
<script>

var freelancers = <?php echo json_encode($names);?>;
/* $( "#tags" ).autocomplete({
source: availableTags
});*/

var normalize = function( term ) {
var ret = "";
for ( var i = 0; i < term.length; i++ ) {
ret += term.charAt(i);
}
return ret;
};


$( "#tags" ).autocomplete({
	source: function( request, response ) {
		var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
		response( $.grep( freelancers, function( value ) {
		value = value.label || value.value || value;
		return matcher.test( value ) || matcher.test( normalize( value ) );
		}) );
	},
	select: function( event, ui) {
		$(this).val(ui.item.value);
		$('#prj_id').val(ui.item.project);
		$('#sndr_id').val(ui.item.sender);
		location.href = "<?php echo VPATH;?>message/browse"+"/"+ui.item.project+"/"+ui.item.sender;
	}
});



function add_msg_fav(msg_id , ele){
if(typeof msg_id == 'undefined'){
return false;
}
$.ajax({
type:"POST",
url:"<?php echo VPATH;?>message/add_fav/"+msg_id,
success: function(res){
if(res == 1){
		ele.removeClass('add_fav');
		ele.removeClass('fa-star');
		ele.addClass('remove_fav');
		ele.addClass('fa-star');
	}
}
});
}


function refresh_chat(){
	var senderid = $('#recipient_id').val();
	var projectid = $('#project_id').val(); 
	$.get("<?php echo VPATH;?>message/update_msg" , function(data){
		if(data == 1){
			$('#select_msg').change();
			loadUnreadMsg(projectid,senderid);
			/* rampage(projectid,senderid); */
		}
	});
}

function loadUnreadMsg(projectid,senderid){
	$.get('<?php echo base_url('message/unread_msg');?>?project_id='+projectid+'&user_id='+senderid, function(res){
		if(res != 0){
			$('#output').find('.leftWidth').append(res);
			$('#output').find('.sent_msg').html('Seen');
			myscroll();
			$('#msg_project_'+projectid).find('.msg-count').hide();
		}
		
	});
}

function remove_msg_fav(msg_id , ele){
if(typeof msg_id == 'undefined'){
return false;
}
$.ajax({
type:"POST",
url:"<?php echo VPATH;?>message/remove_fav/"+msg_id,
success: function(res){
	if(res == 1){
		ele.removeClass('remove_fav');
		ele.removeClass('fa-star');
		ele.addClass('add_fav');
		ele.addClass('fa-star');
	}
}
});
}

var msg_limit = <?php echo $offset ? $offset : 0;?>;
function load_more_msg(){
	$.get("<?php echo VPATH;?>message/load_more_lft/"+msg_limit , function(data){
		if(data != 0){
			$('#lft_content').find('.left_User').append(data);
			msg_limit += <?php echo $offset ? $offset : 10;?>;
		}
	});
}
var vcnt=0;
function send_msg(){
	vcnt=vcnt+1;
	var templ=$('.message_template').html();
	$('.loaded').show();
	document.activeElement.blur();
	//$('.leftWidth').append(templ);
	var msg = $('#message').val();
	var formdata = new FormData($('#myform')[0]);
	var f_count = $('#myform').find('[type="file"]')[0].files.length;
	if(msg.trim() != '' || f_count > 0){
		$.ajax({
			type:"POST",
			url:"<?php echo VPATH;?>message/send_msg",
			data: formdata,
			processData: false,
			contentType: false ,
			dataType: 'json' ,
			success: function(res){
				$('#myform')[0].reset();
				if(res.status=='OK'){
					$('.loaded').hide();
					templ=templ.replace('{MESSAGE}',res.message);
					templ=templ.replace('{DATE}',res.date);
					templ=templ.replace('{ID}',res.add_fav);
					if(res.attach!=''){
						templ=templ.replace('{ATTACH}','view attach');
						$('.attachment_sec').append('<p><a class="" href="<?php echo VPATH;?>/assets/question_file/'+res.attach+'" target="_blank">'+res.attach+'</a></p>');
					}else{
						templ=templ.replace('{ATTACH}','');
					}
					
					templ=templ.replace('{ATTACH_LINK}',res.attach);
					$('.noConversation').remove();
					$('.leftWidth').append(templ);
				}else{
					console.log('fail');
				}
				//$('.leftWidth').append(res);
				 $('#message').val('');
				 $('#message').keyup();
				 $('#message').focus();
				 
				 $('#filecount').hide();
				
				$('.left_User').find('.active').removeClass('active');
				var project_id = $('#project_id').val();
				var project_user = $('#recipient_id').val();
				/* console.log('project id: ' + project_id);
				console.log('project user: ' + project_user); */
				$('.left_User').find('.messagtext2').find('[data-project-id="'+project_id+'"]').filter('[data-project-user="'+project_user+'"]').addClass('active');
				myscroll();
				$('#select_msg').change();	
				
			}
			});
	}
}

function roomdetails(room_id){
$('#hiddenroom').val(room_id);
$.ajax({
type:"POST",
url:"<?php echo VPATH;?>message/detailmsgroom/"+room_id,
success:function(data){

var actionURL = "<?php echo VPATH;?>message/details/"+room_id;   
//$("#project_id").val(projectid);
//$("#recipient_id").val(senderid);	
//$("#output").hide();
//$("#output2").show();
$("#msg_content").html(data);
$("#myform").attr('action',actionURL);
$('#recipient_id').val('room');
$('#project_id').val(room_id);

}
});
return false;
}


</script>
<!-- <script type="text/javascript" src="<?php echo ASSETS.'js/bootstrap-multiselect.js'?>"></script> -->
<!-- <script type="text/javascript" src="<?php echo ASSETS.'js/bootstrap-tagsinput.js'?>"></script>
<script type="text/javascript" src="<?php echo ASSETS.'js/typeahead.bundle.js'?>"></script>

<script type="text/javascript" src="<?php echo ASSETS.'js/perfect-scrollbar.js'?>"></script>  -->
<script type="text/javascript">
    $(document).ready(function() {
			var data = [];
			$("#example-getting-started").select2({
			  //tags: true,
			  data: data,
			  placeholder: "Select members",
			})
    });
	
	$(window).load(function() {
	myscroll();
	})
	function myscroll(){
	$('.leftWidth').stop().animate({
		  scrollTop: $('.leftWidth')[0].scrollHeight
		}, 800);
	}
	
	function update_file_count(e){
		if($(e)[0].files.length > 0){
			$('#filecount').html($(e)[0].files.length).show();
		}else{
			$('#filecount').html('');
			$('#filecount').hide();
		}
	}
</script> 
<?php if($load_first){ ?>
	<script>
	$(document).ready(function(){
		$('#lft_content').find('.messagtext2:first-child').find('a').click();
	});
	
	</script>
	
<?php } ?>

<div class="message_template hide">
	<div class="conversation_loop me">						
		<div class="media-body">
			<div class="info-conversation">
				<div class="messge_body" id="txt_msg">
					<p>{MESSAGE}</p>
					<a href="<?php echo VPATH;?>/assets/question_file/{ATTACH_LINK}" target="_blank">{ATTACH}</a>
				</div>
			</div>
			<p class="chat_date sent_msg">Sent</p>
			<p class="chat_date">{DATE}</p>
		</div>

		<div class="media-right media-middle">
			<i class="fa fa-star add_fav" style="cursor:pointer" data-msg-id="{ID}"></i>
		</div>
	</div>
</div>