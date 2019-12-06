<?php // echo $breadcrumb;?> 

<script src="<?=JS?>mycustom.js"></script>
<style type="text/css">
.add_fav {
	color: #999
}
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
.left_User > ul {
   height: 450px;
}
.col-3-outer {
    border: none;
}

.info.grey {
    border: 1px solid #b9b3b3;
    padding: 10px;
    margin-top: 15px;
    background-color: #f3efef;
    font-weight: bold;
}
#Translatemodal textarea{
	height: auto;
    overflow: auto;
    line-height: 20px;
    min-height: 75px;
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


<div class="dashboard-container">

<div class="dashboard-content-container">
<div class="dashboard-content-inner">

<div class="messages-container">
<div class="messages-container-inner">
<aside class="messages-inbox">
<div class="messages-headline">
    <div class="input-with-icon">
            <input id="autocomplete-input" type="text" class="form-control" placeholder="<?php echo __('search','Search');?>">
        <i class="icon-material-outline-search"></i>
    </div>
    <!--Auto Compleate-->
<div class="left-autocomplete">
<div class="input-group input-group-lg hide">
<span class="input-group-addon"><i class="fa fa-search"></i></span>
<input class="form-control searchinput" placeholder="<?php echo __('message_search','Search'); ?>" type="text" id="tags" style="background:none;">
</div>

<!--dropdown-->
<select class="selectpicker hide-tick" id="select_msg">
<option value=""><?php echo __('message_recent','Recent'); ?></option>
<option value="N"><?php echo __('message_unread','Unread'); ?></option>
<!--<option value="4">Potato</option>-->
</select>
<div class="nice-select wide" tabindex="0" id="select-msg" style="display: none;">
<span class="current"><?php echo __('message_recent','Recent'); ?></span><ul class="list"><li data-value="" class="option selected focus"><?php echo __('message_recent','Recent'); ?></li><li data-value="N" class="option"><?php echo __('message_unread','Unread'); ?></li></ul></div>
<!--dropdown-->

</div>
<!--Auto Compleate-->
<div class="clearfix"></div>
</div>

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
			
			$("#msg_content").html(data);
			$("#myform").attr('action',actionURL);
			$("#myform").show();
			myscroll();
			//$(".leftWidth").niceScroll();	
			history.pushState('', '', '<?php echo base_url('message/browse')?>/'+projectid+'/'+senderid);

		}
		
	});
	$('#msg_project_'+projectid+'_u_'+senderid).find('.msg-count').hide();
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
	$('#lft_content .left_User ul li:first-child').find('a').click();
});
</script>
<span id="lft_content">
<div class="left_User">
<ul>
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

<li id="msg_project_<?php echo $val['project_id'];?>_u_<?php echo $val['sender_user']; ?>">
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
<a href="#" id="anchor" onclick="rampage('<?php echo $val['project_id'];?>','<?php echo $val['sender_user'];?>' , $(this));" class="<?php echo ($val['project_id'] == $project_id && $val['sender_user'] == $project_user) ? 'active' : '';?>">
<div class="message-avatar"><i class="icon-feather-message-square"></i></div>
<div class="message-by">
    <div class="message-by-headline">
        <h5><?php echo $sender_fname; ?> , <?php echo $recipient_fname;?></h5>
    </div>
    <p><?php if(isset($project_name)){ echo strlen($project_name) > 25 ? substr($project_name, 0, 25).'...' : $project_name; }?></p>
</div>
</a>
<?php 
$result = $this->db->query("SELECT message FROM `serv_message` WHERE project_id='".$val['project_id']."' order by id desc limit 1");
$data=filter_data($result->row_array());?>
<p style="font-weight:normal;padding:5px 0px; display:none;"><?php if(strlen($data['message'])>10){ echo substr($data['message'],0,10).'....'; } else { echo $data['message']; } ?></p>

</li> 
<?php }  } else { ?>
<div class="myprotext"><p><strong style="padding: 36px; position: relative; width: 100%;"><?php echo __('message_no_projects_found','No Projects found!'); ?></strong></p></div>
<?php } ?>	 
</ul>
</div>	 
<p id="pagi">
<?php  

if(isset($links))
{                     
//echo $links;   
}
?> 
</p>


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

<div class="messagtext2 abc">
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
</aside>

<aside class="message-content">
	<div class="chat-section unique-left hidden-xs" id="msg_content"></div>
</aside>

</div>
</div>
</div>
</div>
</div>

<script src="<?php echo JS;?>jquery.nicescroll.min.js"></script>
<script>
$(document).ready(function() {  	    
	//$(".leftWidth").niceScroll();
	//$(".left_User").niceScroll();
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
html += '<div class="messagtext2 def"><div class="setting-circle dropdown"><i class="fa fa-ellipsis-h"></i></div><p><a id="anchor" onclick="alert(\'loading..\');"><span class="menu">'+item['user']+'</span></a></p><h4><a id="anchor" onclick="alert(\'loading..\');" style="cursor: pointer;">'+item['project']+'<br><p style="font-weight:normal;padding:5px 0px;">'+msg+'</p></a></h4></div>';
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
html += '<div class="messagtext2 ghi"><div class="setting-circle dropdown"><i class="fa fa-ellipsis-h"></i></div><p><a id="anchor" onclick="alert(\'loading..\');"><span class="menu">'+item['user']+'</span></a></p><h4><a id="anchor" onclick="alert(\'loading..\');" style="cursor: pointer;">'+item['project']+'<br><p style="font-weight:normal;padding:5px 0px;">'+msg+'</p></a></h4></div>';
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

$('select:not(.ignore)').niceSelect();      


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


/*$( "#tags" ).autocomplete({
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
});*/



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
			$('#load_conversation').find('.message-content-inner').append(res);
			myscroll();
			$('#msg_project_'+projectid).find('.msg-count').hide();
			$('#msg_wrap').find('.msg_unseen_icon').attr('class', 'zmdi zmdi-check-all site-text msg_seen_icon');
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
	
	document.activeElement.blur();
	//$('.leftWidth').append(templ);
	var msg = $('#message').val();
	var formdata = new FormData($('#myform')[0]);
	var f_count = $('#myform').find('[type="file"]')[0].files.length;
	if(msg.trim() != '' || f_count > 0){
		$('.loaded').show();
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
					$('#no_msg_element').hide();
					templ=templ.replace('{MESSAGE}',res.message);
					templ=templ.replace('{DATE}',res.date);
					templ=templ.replace('{ID}',res.add_fav);
					templ=templ.replace('{TIME}',res.time);
					if(res.attach!=''){
						templ=templ.replace('{ATTACH}','view attach');
						$('.attachment_sec').append('<p><a class="" href="<?php echo VPATH;?>/assets/question_file/'+res.attach+'" target="_blank">'+res.attach+'</a></p>');
					}else{
						templ=templ.replace('{ATTACH}','');
					}
					
					templ=templ.replace('{ATTACH_LINK}',res.attach);
					$('#load_conversation').append(templ);
				}else{
					console.log('fail');
				}
				//$('.leftWidth').append(res);
				 $('#message').val('');
				 $('#message').keyup();
				 $('#message').focus();
				 
				 $('#filecount').hide();
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
	$('#load_conversation').stop().animate({
		  scrollTop: $('#load_conversation')[0].scrollHeight
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

<script>
$(document).ready(function(){
	<?php if($load_first){ ?>
	$('#lft_content').find('.messagtext2:first-child').find('a').click();
	<?php }else{  ?>
	var project_id = '<?php echo $project_id;?>';
	var project_user = '<?php echo $project_user;?>';
	var ele = $('#msg_project_'+project_id+'_u_'+project_user).find('a');
	rampage(project_id, project_user, ele);
	
	<?php } ?>
});


function clickFileChooser(){
	$('#file_chooser').click();
}

$(document).on('change', '#file_chooser', function(){
	
	var file = $(this)[0].files[0];
	console.log(file);
	
	sendFile(file);
	
});

function sendFile(){
	$('.error').html('');
	var f = $('#myform');
	var fdata = new FormData($(f)[0]);
	$('.loaded').show();
	$.ajax({
		url: '<?php echo base_url('message/send_attachment')?>',
		data: fdata,
		type: 'POST',
		dataType: 'JSON',
		contentType: false,
		processData: false,
		cache: false,
		
		success: function(res){ 
			if(res.status == 0){
				if(res.attachmentError != ''){
					$('#fileTypeError').html(res.attachmentError);
					return;
				}
			}else{
				$('.loaded').hide();
				var last_msg = res.last_message;
				var attachment = JSON.parse(last_msg.attachment);
				var attachment_html = '';
				
				if(attachment.is_image == 1){
					attachment_html = '<img src="<?php echo ASSETS.'question_file'?>/'+attachment.file_name+'" class="materialboxed responsive-img" style="max-width:200px"/>';
					
				}else{
					attachment_html = '<a href=<?php echo ASSETS.'question_file'?>/'+attachment.file_name+'" target="_blank"><img src="'+get_file_icon(attachment.file_name)+'" alt=""> '+attachment.org_file_name+'</a> <a href="<?php echo ASSETS.'question_file'?>/'+attachment.file_name+'" target="_blank" download><i class="zmdi zmdi-download zmdi-20x"></i></a><div class=""><small>'+Math.round(attachment.file_size)+' KB</small></div>';
				}
				
				var templ=$('.message_template').html();
				templ=templ.replace('{MESSAGE}',res.message);
				templ=templ.replace('{DATE}',res.add_date);
				templ=templ.replace('{ID}',res.add_fav);
				templ=templ.replace('{TIME}',res.time);
				templ=templ.replace('{ATTACH}',attachment_html);
				
				$('#load_conversation').append(templ);
				
				var file = '<a href="<?php echo ASSETS.'question_file'?>/'+attachment.file_name+'">'+attachment.org_file_name+'</a>';
				$('#files_list').find('.attachment_sec').append(file);
				
				myscroll();
			}
			
		}
	});
	
}
	
	
function get_file_icon(file_name){
	var icons = {
		'doc' : '<?php echo DOC_ICON;?>',
		'docx' : '<?php echo DOC_ICON;?>',
		'pdf' : '<?php echo PDF_ICON;?>',
		'txt' : '<?php echo TXT_ICON;?>',
	};
	var default_file_icon = '<?php echo COMMON_ICON; ?>';
	
	var file_part = file_name.split('.');
	var file_ext = file_part.pop().trim().toLowerCase();
	var file_icon = '';
	
	if(typeof icons[file_ext] != 'undefined'){
		file_icon = icons[file_ext];
	}else{
		file_icon = default_file_icon;
	}
	
	return file_icon;
}
function openTranslate(){
	$('#Translatemodal').modal('show');
}
</script>


<div class="message_template hide">
	<div class="message-bubble me">						
		<div class="message-bubble-inner">	
        	<div class="message-text">
			<div class="file_attach">
				{ATTACH}
			</div>		
			<p>
				{MESSAGE}
			<span class="msgTime">{TIME} <i class="zmdi zmdi-check grey-text msg_unseen_icon"></i></span>
			</p>
			<span class="starred">
				<i class="zmdi zmdi-star add_fav" style="cursor:pointer" data-msg-id="{ID}"></i>
			</span>
            </div>
            <div class="clearfix"></div>
		</div>
	</div>
</div>
