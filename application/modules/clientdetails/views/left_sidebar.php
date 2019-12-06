
<?php
$user=$this->session->userdata('user');
?>
<aside class="col-md-4 col-12" style="border:1px solid #e0e0e0; padding:15px; min-height:520px">
<div class="left_sidebar">
  <div class="u_details">
    <div class="profile">
      <div class="profile_pic"> <span>
        <?php
    
            if($logo!='')
    
            {
				if(file_exists('assets/uploaded/cropped_'.$logo)){
					$logo = 'cropped_'.$logo;
				}
    
            ?>
        <img alt="" src="<?php echo VPATH;?>assets/uploaded/<?php echo $logo;?>"  class="rounded-circle">
        <?php
    
            }
    
            else
    
            {
    
            ?>
        <img alt="" src="<?php echo VPATH;?>assets/images/user.png"  class="rounded-circle">
        <?php } ?>
        </span>
        <?php if($verify=='Y'){ ?>
        <a href="javascript:void(0)" class="btn- approved" style="opacity:1;border-radius:15px" title="<?php echo strtoupper(__('clientdetails_sidebar_approved','APPROVED')); ?>"><i class="zmdi zmdi-thumb-up"></i></a>
        <?php }  ?>
      </div>
    </div>
      <?php 
			if($this->session->userdata('user')){
			$userid=$this->session->userdata('user');
			$user_login=$userid[0]->user_id;
			$u_acc_type =  $userid[0]->account_type;			
		?>
      <?php  if($user_id==$user_login) { ?>
      <a href="<?php echo base_url('dashboard/editprofile_professional')?>" class="pull-right"><i class="zmdi zmdi-edit"></i> <?php echo __('clientdetails_sidebar_edit','Edit'); ?></a>
      <?php } ?>
      <?php }  ?>
      <h4 class="text-center"><?php echo get_full_name($user_id);?></h4>
      
     
      <div class="text-center"><div class="star-rating" data-rating="<?php echo get_user_rating($user_id); ?>"></div></div>
      
      <ul class="profile-list">
		<li><?php echo get_user_city($user_id); ?></li>
		
        <li><i class="icon-feather-log-in"></i> <?php echo __('clientdetails_sidebar_last_logged_on','Last logged on'); ?>: <?php echo date('d M,Y',strtotime($ldate));?></li>
        <?php 
		if($account_type == 'E'){ 
			$this->load->model('jobdetails/jobdetails_model');
			$user_totalproject = $this->jobdetails_model->gettotaluserproject($user_id);
			$total_posted = $this->dashboard_model->getProjectStatics($user_id);
			if(count($total_posted) > 0){foreach($total_posted as $k => $v){
		?>
        <li><i class="icon-feather-briefcase"></i> <?php echo $v['name'] ?> : <?php echo $v['y'] ?></li>
        <?php } } ?>
        <li><i class="icon-feather-briefcase"></i> <?php echo __('clientdetails_sidebar_posted_job','Posted Job'); ?>: <?php echo $user_totalproject;?></li>
        <li><i class="icon-feather-dollar-sign"></i> <?php echo __('clientdetails_sidebar_total_spent','Total Spent'); ?>: <?php echo CURRENCY;?><?php echo get_project_spend_amount($user_id);?></li>
        <?php  } ?>
        <?php if($account_type == 'F'){ ?>
        <li hidden><i class="icon-feather-clock"></i> <?php echo __('clientdetails_sidebar_hourly_rate','Hourly Rate'); ?>: <?php echo CURRENCY;?><?php echo $rate;?></li>
        <li><i class="icon-feather-briefcase"></i> <?php echo __('clientdetails_sidebar_amount_earned','Amount Earned'); ?>: <?php echo CURRENCY;?> <?php echo get_earned_amount($user_id);?></li>
        <li><i class="icon-feather-briefcase"></i> <?php echo __('clientdetails_sidebar_completed_project','Completed Project'); ?>: <?php echo get_freelancer_project($user_id, 'C');?></li>
        <?php } ?>
      </ul>
	<?php
	 if($this->session->userdata('user')){
	 $userid=$this->session->userdata('user');
	 $user_login=$userid[0]->user_id;
	 if($user_id!=$user_login && $account_type == 'F') {
	?>
     <a href="#" onclick="javascript:void(0)" data-target="#inviteModal" data-toggle="modal" class="btn btn-site btn-block"><i class="zmdi zmdi-account"></i> Invite</a>
      <a href="javascript:void(0)" class="btn btn-site btn-block" data-toggle="modal" data-target="#myModal2" style="cursor: pointer;" onclick="setProject2('<?php echo $user_id;?>','<?php echo $user_login;?>')" hidden><i class="fa fa-user-plus"></i> <?php echo __('clientdetails_sidebar_send_message','Send Message'); ?></a>
      <?php $user = $this->session->userdata('user'); if($user){ $login_user_id = $user[0]->user_id; }else{ $login_user_id = ''; } $action = 'add'; $fav_cls = ''; if(is_fav($user_id, 'FREELANCER', $login_user_id)){ $action = 'remove'; $fav_cls = 'bookmarked'; } ?>
      <a href="javascript:void(0)" class="btn btn-secondary btn-block mark-fav-button <?php echo $fav_cls;?>" data-object-id="<?php echo $user_id;?>" data-object-type="FREELANCER" data-action="<?php echo $action;?>"><i class="fa fa-heart"></i> Favourite</a>
	<?php
	}
	}
	?>
  </div>
</div>
</aside>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('clientdetails_sidebar_select_your_project_to_invite_freelancer','Select Your project to invite freelancer'); ?></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="freelancer_id" id="freelancer_id" value=""/>
        <div id="allprojects"></div>
      </div>
      <div class="modal-footer"> 
        <!--<button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#myModal').modal('hide');">Close</button>-->
        <button type="button" onclick="hdd()" id="sbmt" class="btn btn-site"><?php echo __('clientdetails_sidebar_invite','Invite'); ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="$('#myModal2').modal('hide');">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('clientdetails_sidebar_send_message_to_freelancer','Send message to freelancer'); ?></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="freelancer_id2" id="freelancer_id2" value=""/>
        <div class="cost_timing">
          <div class="cost_form_box">
            <label id="select_project_label"><?php echo __('clientdetails_sidebar_select_your_project','Select Your Project'); ?></label>
            <div id="allprojects2"></div>
          </div>
        </div>
        <div class="divide15"></div>
        <div class="cost_timing" id="message_wrapper">
          <div class="cost_form_box">
            <label><?php echo __('clientdetails_sidebar_your_message','Your Message'); ?></label>
            <textarea rows="4" cols="" name="msg_details" id="msg_details" class="cost_input form-control"></textarea>
            <span id="detailsError" class="rerror" style="float: left; display:none; color:red"><?php echo __('clientdetails_sidebar_enter_your_message_first','Enter Your Message First'); ?></span> </div>
        </div>
      </div>
      <div class="modal-footer" style="border-top:none !important"> 
        <!--<button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#myModal2').modal('hide');">Close</button>-->
        <button type="button" onclick="hdd2()" id="sbmt2" class="btn btn-site"><?php echo __('clientdetails_sidebar_send_message','Send Message'); ?></button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$("a[id^='parent_']").click(function(e){
			e.preventDefault();
			var parent = $(this).attr('data-child');
			$('#child_'+parent).toggle();
		});
	});
	
	
	function setProject(user_id,project_user)
{
	//alert(user_id+' '+project_user);
	jQuery("#freelancer_id").val(user_id);
	var datastring="user_id="+project_user;
	jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/getProject",
		success:function(return_data){
			//alert(return_data);
				if(return_data!=0)
				{
					jQuery("#allprojects").html('');	
					jQuery("#allprojects").html(return_data);
					jQuery("#sbmt").show();
					jQuery("#message_wrapper").show();
				}
				else
				{
					jQuery("#allprojects").html('<b><?php echo __('clientdetails_sidebar_you_dont_have_any_open_projects_to_invite','You dont have any open projects to invite'); ?></b>');	
					jQuery("#sbmt").hide();	
					jQuery("#message_wrapper").hide();	
				}
			}
		});
}

function setProject2(user_id,project_user)
{
	//alert(user_id+' '+project_user);
	jQuery("#freelancer_id2").val(user_id);
	var datastring="user_id="+project_user;
	jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/getProject",
		success:function(return_data){
			//alert(return_data);
				if(return_data!=0)
				{
					jQuery("#allprojects2").html('');	
					jQuery("#allprojects2").html(return_data);
					jQuery("#sbmt2").show();
					jQuery("#message_wrapper").show();
					jQuery("#select_project_label").show();	
				}
				else
				{
					jQuery("#allprojects2").html("<b>You don't have any open project to send message</b>");	
					jQuery("#sbmt2").hide();	
					jQuery("#message_wrapper").hide();	
					jQuery("#select_project_label").hide();	
				}
			}
		});
}



function hdd2()
{
	var free_id=jQuery("#freelancer_id2").val();
	var project_id=jQuery(".prjct").val();
	var message=jQuery("#msg_details").val();	
	if(message=='')
	{
		jQuery("#detailsError").css("display", "block");
		setTimeout( "jQuery('#detailsError').hide();",3000 );		
	}
	else
	{
		var datastring="freelancer_id="+free_id+"&projects_id="+project_id+"&message="+message;
		jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/sendMessagenew",
		success:function(return_data){
			window.location.href='<?php echo VPATH;?>clientdetails/showdetails/'+free_id+'/';
			}
		});
		//window.location.href='<?php echo VPATH;?>clientdetails/sendMessage/'+free_id+'/'+project_id+'/'+'/'+encodeURI(message)+'/';	
	}
}


function hdd()
{
	var free_id=jQuery("#freelancer_id").val();
	var project_id=jQuery(".prjct").val();
	var page='clientdetails';
	window.location.href='<?php echo VPATH;?>invitetalents/invitefreelancer/'+free_id+'/'+project_id+'/'+'/'+page+'/';	
}


function fetch_project(project_user)
{
	jQuery.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>clientdetails/getProject",
		success:function(return_data){
			//alert(return_data);
				if(return_data!=0)
				{
					
					jQuery("#allprojects2").html(return_data);
					
				}
				else{
					jQuery("#allprojects2").html("<b><?php echo __('clientdetails_sidebar_you_dont_have_any_projects','You dont have any open project'); ?></b>");	
				
				}
			}
		});
}


</script> 
