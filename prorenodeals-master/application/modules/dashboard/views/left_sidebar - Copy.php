<?php

$user=$this->session->userdata('user');

$u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified', 'from' => 'user', 'where' => array('user_id' => $user[0]->user_id)));

$logo = get_user_logo($user[0]->user_id);
$avg_rating = get_user_rating($user_id);

?>



<div class="col-md-4 col-12" style="border:1px solid #e0e0e0; padding:15px; min-height:520px">

  <div class="left_sidebar">

    <div class="profile" style="padding-top:0">

      <div class="profile_pic"> 

      <a href="javascript:void(0)" class="profile-pic-cam" title="<?php echo __('myprofile_emp_update_profile_picture','Update profile picture'); ?>"><i class="zmdi zmdi-hc-2x zmdi-camera" style="line-height: 0.5;vertical-align: middle;" onclick="$('#profileModal').modal('show');"></i></a>     

        <span>
			<img alt="" src="<?php echo $logo;?>"  class="img-circle">
	    </span>

		 <?php if($verify=='Y'){ ?>

		<a class="btn- approved" style="opacity:1;border-radius:15px" title="<?php echo __('myprofile_emp_approved','APPROVED'); ?>"><i class="zmdi zmdi-thumb-up"></i></a>

		 <?php }  ?>

       </div>       

    </div>

    	

    <div class="profile-details" style="padding:0">

	<?php /*if($account_type == 'F'){ ?>

	<p class="" style="background-color: #5e7f98; padding: 6px 15px; color: #fff;"><i class="zmdi zmdi-label-box"></i> <?php echo __('myprofile_emp_available','Available'); ?> <span class="pull-right"><?php echo $available_hr;?> <?php echo __('myprofile_emp_hr_per_week','hr/week'); ?> <a href="javascript:void(0);" data-toggle="modal" data-target="#hourly_rateModal" style="color:#fff"><i class="zmdi zmdi-edit"></i></a></span></p>

	<?php }*/ ?>

    

      <?php 

			if($this->session->userdata('user')){

			$userid=$this->session->userdata('user');

			$user_login=$userid[0]->user_id; 

		?>

      <?php  if($user_id==$user_login) { ?>

      <a href="<?php echo base_url('dashboard/editprofile_professional')?>" class="edit_info pull-right"><i class="zmdi zmdi-edit"></i></a>

      <?php } ?>

      <?php }  ?>

     
      <div class="star-rating" data-rating="<?php echo $avg_rating; ?>"></div>

      <?php 

		$this->load->model('clientdetails/clientdetails_model');

	   $flag=$this->auto_model->getFeild("code2","country","Code",$user_country);

	   $flag=  strtolower($flag).".png";

	   // echo $city.", ".$country;

	   if(is_numeric($city)){

		   $city = getField('Name', 'city', 'ID', $city);

	   }

	   $c = getField('Name', 'country', 'Code',$user_country);
	   $reg_date = getField('reg_date', 'user', 'user_id',$user_id);
		
	?>

    <ul class="profile-list">

        <li><i class="zmdi zmdi-account-box"></i> Member since <?php echo date('d M, Y', strtotime($reg_date));?></li>
		<li><?php echo get_user_city($user_id); ?></li>

		<?php if($account_type == 'F'){ ?>

        <li hidden><i class="zmdi zmdi-time"></i> <?php echo __('myprofile_emp_hourly_rate','Hourly Rate'); ?>: <?php echo CURRENCY; ?><?php echo $hourly_rate;?>

		<?php  if($user_id==$user_login) { ?>

      <a href="#hourly_rateModal" data-toggle="modal" class="pull-right" hidden><i class="zmdi zmdi-edit" style="font-size:15px; min-width:0"></i> Edit</a>

      <?php } ?>

		</li>

		<?php } ?>

        <li><i class="zmdi zmdi-sign-in"></i> <?php echo __('myprofile_emp_last_logged_on','Last logged on'); ?>: <?php echo date('d M,Y',strtotime($ldate));?></li>

		

		<?php 

		if($account_type == 'E'){ 

			$this->load->model('jobdetails/jobdetails_model');

			$user_totalproject = $this->jobdetails_model->gettotaluserproject($user_id);

			$total_posted = $this->dashboard_model->getProjectStatics($user_id);

			

			if(count($total_posted) > 0){foreach($total_posted as $k => $v){

			?>

		 <li><i class="zmdi zmdi-label"></i><?php echo $v['name'] ?> : <?php echo $v['y'] ?></li>

		<?php } } ?>

		
		 <li><i class="zmdi zmdi-label"></i><?php echo __('myprofile_emp_posted_jobs','Posted Jobs'); ?>: <?php echo $user_totalproject;?></li>

		 

		 <li><i class="zmdi zmdi-label"></i><?php echo __('myprofile_emp_sidebar_total_spent','Total Spent'); ?>: <?php echo CURRENCY;?><?php echo get_project_spend_amount($user_id);?></li>

		 

		<?php  } ?>

		<?php if($account_type == 'F'){ ?>

        <li><i class="zmdi zmdi-label"></i> <?php echo __('myprofile_emp_amount_earned','Amount Earned'); ?>: <?php echo CURRENCY;?> <?php echo get_earned_amount($user_id);?></li>

		

        <li><i class="zmdi zmdi-label"></i> <?php echo __('myprofile_completed_projects','Completed Projects'); ?>: <?php echo get_freelancer_project($user_id, 'C');?></li>

		 <li><a href="<?=VPATH?>findjob/"><i class="zmdi zmdi-search"></i> <?php echo __('myprofile_emp_browse_jobs','Browse jobs'); ?></a></li>

        <li><a href="<?php echo base_url('favourite'); ?>"><i class="zmdi zmdi-favorite"></i> <?php echo __('myprofile_emp_favorite_projects','Favourite Projects'); ?></a></li>

		 

		<?php }else{  ?>

		 <li><a href="<?=VPATH?>findtalents/"><i class="zmdi zmdi-search"></i> <?php echo __('myprofile_','Browse Contractors'); ?></a></li>

		<?php } ?>

       

      

    </ul>        

   
    </div>

  </div>

</div>







