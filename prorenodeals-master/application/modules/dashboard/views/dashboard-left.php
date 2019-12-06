<?php

$this->load->model('dashboard/dashboard_model');
$this->load->model('jobfeed/jobfeed_model');
$user = $this->session->userdata('user');
$user_id = $user[0]->user_id;
$completeness = $this->auto_model->getCompleteness($user[0]->user_id);

$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

if($logo==''){
	$logo=base_url("assets/images/user.png");
}else{
	if(file_exists('assets/uploaded/cropped_'.$logo)){
		$logo=base_url("assets/uploaded/cropped_".$logo);
	}else{
		$logo=base_url("assets/uploaded/".$logo);
	}
}

$rating=$this->dashboard_model->getrating_new($user[0]->user_id);

$available_hr = $this->autoload_model->getFeild('available_hr','user','user_id',$user[0]->user_id);
if(empty($available_hr)){
	$available_hr = '0.00';
}
$user_name=$this->auto_model->getFeild('fname','user','user_id',$user_id);
$user_name.= ' '.$this->auto_model->getFeild('lname','user','user_id',$user_id);	
$plan=$user[0]->membership_plan;

$avg_rating = get_user_rating($user_id);


$img = '';
if($plan==1){
	$img="FREE_img.png";	
}elseif($plan==2){
	$img="SILVER_img.png";	
}elseif($plan==3){
	$img="GOLD_img.png";	
}elseif($plan==4){
	$img="PLATINUM_img.png";	
}

$acc_balance=getField('acc_balance','user','user_id',$user[0]->user_id);
$user_wallet_id = get_user_wallet($user[0]->user_id);
$acc_balance=get_wallet_balance($user_wallet_id);
$accountType=$user[0]->account_type;		
$job_feed_count = $this->jobfeed_model->count_user_suggested_project($user[0]->user_id);
?>

<aside class="col-lg-2 col-md-3 col-12">
  <div class="left-panel"> 
   <div class="left-panel-body">
    <div class="c_details">
      <div class="profile">
        <div class="profile_pic"> <span><a href="<?php echo base_url('dashboard/profile_professional');?>"> <img src="<?php echo $logo;?>"></a></span></div>
      </div>
      <div class="profile-details text-center">
        <h4><a href="<?php echo base_url('dashboard/profile_professional');?>" class=""><?php echo $user_name;?></a></h4>
        <?php if($accountType == 'F'){ ?>
        <p hidden><?php echo format_money($available_hr); ?> hrs/week</p>
        <?php } ?>
        <?php /*
    for($i=1; $i<=5; $i++){ 
        if($i <= $avg_rating){
            echo '<i class="zmdi zmdi-star"></i>';
        }else{
            echo '<i class="zmdi zmdi-star-outline"></i>';
        }
    }
    */ ?>
        <div class="star-rating" data-rating="<?php echo $avg_rating; ?>"></div>
        <div class="progress profile_progress mb-3"  hidden>
          <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="<?php echo round($completeness);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($completeness);?>%"> <?php echo round($completeness);?> % </div>
        </div>
        
        <!-- <a href="<?php echo base_url('dashboard/profile_professional'); ?>" class="btn btn-site btn-sm btn-block"> Edit Profile</a>--></div>
    </div>
    <?php if($accountType == 'F'){ ?>
    <div class="myfund">
      <div class="body">
        <h5 class="hide">My Balance</h5>
        <a href="<?php echo base_url('myfinance/transaction'); ?>" class="btn-block btn btn-site">Balance</a><span style="padding:6px 0" class="pull-right hide"><?php echo CURRENCY. format_money($acc_balance);?></span> </div>
    </div>
    <div class="myfund">
      <?php 
    $pending_payment = $this->dashboard_model->getFreelancerPendingPaymentProject($user_id);
    $pending_payment = format_money($pending_payment,TRUE); 
    ?>
      <div class="body text-center border-bottom">
        <h5>Available Balance</h5>
        <h3><?php echo CURRENCY. format_money($acc_balance,TRUE);?></h3>
        <div class="spacer-10"></div>
        <h5>Work In Progress</h5>
        <h3><?php echo CURRENCY. $pending_payment; ?></h3>
      </div>
    </div>
    <?php }else{ ?>
    <div class="myfund">
      <div class="body">
        <h4 class="title-sm hide">My Fund</h4>
        <a href="<?php echo base_url('myfinance'); ?>" class="btn-block btn btn-site">Add Fund</a><span style="padding:6px 0" class="pull-right">
        <?php //echo CURRENCY. $acc_balance;?>
        </span> </div>
    </div>
    <div class="myfund">
      <?php 
    $pending_payment = $this->dashboard_model->getPendingPaymentProject($user_id);
    /* $pending_payment = format_money($pending_payment);  */
    ?>
      <div class="body text-center border-bottom">
        <h5 class="title-sm">Available Balance</h5>
        <h3><?php echo CURRENCY. format_money($acc_balance,TRUE);?></h3>
        <div class="spacer-10"></div>
        <h5 class="title-sm">On Hold Payment</h5>
        <h3><?php echo CURRENCY. format_money($pending_payment,TRUE); ?></h3>
      </div>
    </div>
    <?php } ?>
    <div class="mytracker hidden">
      <h5 class="heading">Time Tracker</h5>
      <div class="body"> <a href="<?php echo base_url('dashboard/tracker'); ?>" target="_blank" class="btn btn-site btn-sm">Download Timetracker</a> </div>
    </div>
    <ul class="list-group">
      <li><a href="<?php echo base_url('dashboard'); ?>"><i class="icon-feather-grid"></i> Dashboard</a></li>
      <?php if($accountType == 'F'){ ?>
      <li><a href="<?php echo base_url('jobfeed'); ?>"> <i class="icon-feather-file"></i>Job Feeds
        <?php if($job_feed_count > 0){ ?>
        <span class="badge badge-success float-right"><?php echo $job_feed_count; ?></span>
        <?php } ?>
        </a></li>
      
      <li><a href="<?php echo base_url('dashboard/profile_professional'); ?>"><i class="icon-feather-user"></i> My Profile</a></li>
      <li><a href="<?php echo base_url('dashboard/myproject_professional'); ?>"><i class="icon-feather-file"></i> My Projects</a></li>
      <li><a href="<?php echo base_url('dashboard/my_service'); ?>"><i class="icon-feather-settings"></i> My Services </a></li>
      <li><a href="<?php echo base_url('myfinance'); ?>"><i class="icon-feather-tag"></i> My Finance</a></li>
      <li><a href="<?php echo base_url('projectroom/resolution_center'); ?>"><i class="icon-feather-file"></i> Resolution Center</a></li>
      <li><a href="<?php echo base_url('favourite/fav_list?type=projects'); ?>"><i class="icon-feather-file"></i> My Favorite projects </a></li>
      <li><a href="<?php echo base_url('dashboard/support'); ?>"><i class="icon-feather-headphones"></i> Support</a></li>
      <li><a href="<?php echo base_url('dashboard/myfeedback'); ?>"><i class="icon-feather-star"></i> Rating &amp; Reviews</a></li>
      <li><a href="<?php echo base_url('dashboard/setting'); ?>"><i class="icon-feather-settings"></i> Account Settings</a></li>
      <li><a href="<?php echo base_url('user/logout'); ?>"><i class="icon-feather-log-out"></i> Logout</a></li>
      <?php }else{?>      
      <li><a href="<?php echo base_url('dashboard/profile_professional'); ?>"><i class="icon-feather-user"></i> My Profile</a></li>
      <li><a href="<?php echo base_url('favourite/favourite_contractors'); ?>"><i class="icon-feather-tag"></i> Favorite Contractors</a></li>
      <li><a href="<?php echo base_url('dashboard/myproject_client'); ?>"><i class="icon-feather-file"></i> My Projects</a></li>
      <li><a href="<?php echo base_url('myfinance'); ?>"><i class="icon-feather-tag"></i> My Finance</a></li>
      <li><a href="<?php echo base_url('projectroom/resolution_center'); ?>"><i class="icon-feather-file"></i> Resolution Center</a></li>
      <li><a href="<?php echo base_url('postjob'); ?>"><i class="icon-feather-file"></i> Post Project</a></li>
      <li><a href="<?php echo base_url('favourite/fav_list'); ?>"><i class="icon-feather-tag"></i> My Favorites</a></li>
      <li><a href="<?php echo base_url('dashboard/support'); ?>"><i class="icon-feather-headphones"></i> Support</a></li>
      <li><a href="<?php echo base_url('dashboard/myfeedback'); ?>"><i class="icon-feather-star"></i> Rating &amp; Reviews</a></li>
      <li><a href="<?php echo base_url('dashboard/setting'); ?>"><i class="icon-feather-settings"></i> Account Settings</a></li>
      <li><a href="<?php echo base_url('user/logout'); ?>"><i class="icon-feather-log-out"></i> Logout</a></li>
      <?php }?>
      <?php /*?> 
				<?php if($accountType == 'F'){ ?>  
				  <li>
					<span><a href="<?php echo base_url('dashboard/myproject_professional'); ?>"><i class="zmdi zmdi-assignment-check"></i> Project</a></span><br>
					<span class="hide"><a href="<?php echo base_url('dashboard/mycontest_entry'); ?>"><i class="zmdi zmdi-assignment-check"></i> Contest</a></span>
				</li>  												
				<li hidden><a href="<?php echo base_url('favourite'); ?>"><i class="zmdi zmdi-file"></i> Favourite Projects</a></li>	
				
				<?php }else{ ?>
				<li>
					<span><a href="<?php echo base_url('dashboard/myproject_client'); ?>"><i class="zmdi zmdi-assignment-check"></i> Project</a></span><br>
					<span class="hide"><a href="<?php echo base_url('dashboard/mycontest'); ?>"><i class="zmdi zmdi-assignment-check"></i> Contest</a></span>
				</li>
				<?php } ?>
				
				<li><a href="<?php echo base_url('projectroom/resolution_center'); ?>"><i class="zmdi zmdi-check"></i> Resolution Center</a></li>
				<li><a href="<?php echo base_url('invoice/list_all'); ?>"><i class="zmdi zmdi-file"></i> Invoices</a></li>		
				<li><a href="<?php echo base_url('myfinance'); ?>"><i class="zmdi zmdi-label"></i> My Finance</a></li>		
				<li><a href="<?php echo base_url('favourite/fav_list'); ?>"><i class="zmdi zmdi-label"></i> My Favorite</a></li>		
				
				<li class="hide"><a href="<?php echo base_url('membership'); ?>"><i class="zmdi zmdi-label"></i> Membership</a></li>
				  <li><a href="<?php echo base_url('dashboard/myfeedback'); ?>"><i class="zmdi zmdi-comment"></i> Rating & review</a></li>							  
				  <li><a href="<?php echo base_url('dashboard/setting'); ?>"><i class="zmdi zmdi-settings"></i> Settings</a></li>
				  <li><a href="<?php echo base_url('dashboard/support'); ?>"><i class="zmdi zmdi-settings"></i> Support/Feedback</a></li>
				  <li><a href="<?php echo base_url('testimonial'); ?>"><i class="zmdi zmdi-comments"></i> Give Testimonial</a></li>
				  <li><a href="<?php echo base_url('dashboard/closeacc'); ?>"><i class="zmdi zmdi-account"></i> Close Account</a></li>   <?php */?>
    </ul>
    </div>
  </div>
</aside>
<script>
$(document).ready(function(){      
  var w = $(window).width();
  if(w > 768){
		$('#mainpage').css('min-height', 920);
		var height = $('#mainpage').height();
		$('.left-panel').css('min-height', height);	
	 }else{
		 $('.mobile-menu').show();
	 }
	 $('.mobile-menu').click(function() {
	 $('.left-panel').slideToggle(300);
	});
	//$(".left_panel").niceScroll();
});
</script> 
