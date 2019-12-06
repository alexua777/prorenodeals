<style>
.icon-round {
	margin-left: 10px;
}
 @media (min-width: 992px) {
 .modal-sm {
 width: 400px;
}
}
</style>
<link href="<?php echo CSS;?>cropper.css" rel="stylesheet"/>
<script src="<?php echo JS;?>cropper.js"></script>

<script src="<?=JS?>mycustom.js"></script>
<script src="<?=JS?>jquery.lightbox.min.js"></script>
<script>

	var pf = {

		allowed_types : ["image/jpg", "image/png", "image/jpeg"]

	};

	pf.upload = function(ele){

		var files = $(ele)[0].files;

	

		if(this.allowed_types.indexOf(files[0].type) < 0){

			$('#file_type_error').show();

			return;

		}

		$('#file_type_error').hide();

		$('#profile_pic_progress').show();

		var fdata = new FormData();

		fdata.append('file', files[0]);

		$.ajax({

			xhr: function() {

					var xhr = new window.XMLHttpRequest();



					xhr.upload.addEventListener("progress", function(evt) {

					  if (evt.lengthComputable) {

						var percentComplete = evt.loaded / evt.total;

						percentComplete = parseInt(percentComplete * 100);

						$('#profile_pic_progress').find('.determinate').css('width', percentComplete+'%');

						if (percentComplete === 100) {

							$('#profile_pic_progress').hide();

							$('#profile_pic_progress').find('.determinate').css('width', '0%');

						}



					  }

					}, false);



					return xhr;

			},

			url: '<?php echo base_url('dashboard/upload_profile_pic');?>',

			data: fdata,

			type: 'POST',

			processData: false,

			contentType: false,

			dataType: 'json',

			success: function(res){

				if(res['result'] == 1){

					$('#profile_pic_upload_form').hide();

					$('#crop_image_wrapper').show();

					$('#profile_pic_crop').attr('src', '<?php echo ASSETS.'uploaded';?>/'+res['file_name']);

					$('#profile_pic_file_name').val(res['file_name']);

					$('#p_m_footer').show();

					$('#profile_pic_crop').cropper({

						  aspectRatio: 1/1,

						  minContainerWidth: 350,

						  minContainerHeight: 350,

						  minCanvasWidth: 200,

						  minCanvasHeight: 200,

						  minCropBoxWidth: 150,

					      minCropBoxHeight: 150

					});

					

				}

				

			}

		});

		

	};

	

	pf.cropImage = function(){

		var img_data = $('#profile_pic_crop').cropper('getData', true);

		var profile_img = $('#profile_pic_file_name').val();

		$.ajax({

			url: '<?php echo base_url('dashboard/crop_image')?>',

			data: {image: profile_img, height: img_data.height, width: img_data.width, x_pos: img_data.x, y_pos : img_data.y},

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['result'] == 1){

					location.reload();

				}

			}

		});

	}

	

	

	pf.uploadBg = function(ele){

		var files = $(ele)[0].files;

		var fdata = new FormData();

		if(this.allowed_types.indexOf(files[0].type) < 0){

			$('#bgfile_type_error').show();

			return;

		}

		$('#bgfile_type_error').hide();

		$('#profile_bg_progress').show();

		fdata.append('file', files[0]);

		$.ajax({

			xhr: function() {

					var xhr = new window.XMLHttpRequest();



					xhr.upload.addEventListener("progress", function(evt) {

					  if (evt.lengthComputable) {

						var percentComplete = evt.loaded / evt.total;

						percentComplete = parseInt(percentComplete * 100);

						$('#profile_bg_progress').find('.determinate').css('width', percentComplete+'%');

						if (percentComplete === 100) {

							$('#profile_bg_progress').hide();

							$('#profile_bg_progress').find('.determinate').css('width', '0%');

						}



					  }

					}, false);



					return xhr;

			},

			url: '<?php echo base_url('dashboard/upload_profile_pic');?>',

			data: fdata,

			type: 'POST',

			processData: false,

			contentType: false,

			dataType: 'json',

			success: function(res){

				console.log(res);

				if(res['result'] == 1){

					$('#bg_pic_upload_form').hide();

					$('#bg_crop_image_wrapper').show();

					$('#bg_pic_crop').attr('src', '<?php echo ASSETS.'uploaded';?>/'+res['file_name']);

					$('#bg_pic_file_name').val(res['file_name']);

					$('#pb_m_footer').show();

					$('#bg_pic_crop').cropper({

						  aspectRatio: 16/8,

						  minContainerWidth: 350,

						  minContainerHeight: 350,

						  minCanvasWidth: 200,

						  minCanvasHeight: 200,

						  minCropBoxWidth: 150,

					      minCropBoxHeight: 100

					});

					

				}

				

			}

		});

		

	};

	

	

	pf.cropBgImage = function(){

		var img_data = $('#bg_pic_crop').cropper('getData', true);

		var profile_img = $('#bg_pic_file_name').val();

		$.ajax({

			url: '<?php echo base_url('dashboard/crop_image_bg')?>',

			data: {image: profile_img, height: img_data.height, width: img_data.width, x_pos: img_data.x, y_pos : img_data.y},

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['result'] == 1){

					location.reload();

				}

			}

		});

	}

	

</script>

<?php

$bg_pic= $this->auto_model->getFeild("profile_bg_pic","user","user_id",$user_id);

$bg_full_path = ASSETS.'images/coverphoto.jpg';

if(!empty($bg_pic)){

	if(file_exists('assets/uploaded/bgcropped_'.$bg_pic)){

		$bg_full_path = ASSETS.'uploaded/bgcropped_'.$bg_pic;

	}else if(file_exists('assets/uploaded/'.$bg_pic)){

		$bg_full_path = ASSETS.'uploaded/'.$bg_pic;

	}
}

if($rating[0]['num'] > 0){
	$avg_rating=$rating[0]['avg']/$rating[0]['num'];
}else{
	$avg_rating=0;
}


?>
<?php /*?>
<div class="parallax-banner-sm" style="background-image:url(<?php echo $bg_full_path;?>)">
  <div class="container">
    <div class="posRelative">    

    <ol class="breadcrumb">

      <li><a href="<?php echo base_url();?>">Home</a></li>

      <li><a href="<?php echo base_url('findtalents');?>">Find Freelancers</a></li>

      <li class="active">PROFILE</li>

    </ol>    

    </div>
  </div>
</div><?php */?>

<div class="single-page-header freelancer-header">
	<div class="container">
    <div class="single-page-header-inner">
    	<?php
		$user=$this->session->userdata('user');
		$u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified', 'from' => 'user', 'where' => array('user_id' => $user[0]->user_id)));

		?>

        <?php 
			if($this->session->userdata('user')){
			$userid=$this->session->userdata('user');
			$user_login=$userid[0]->user_id; 
		}
   		?>
        <?php

			$user=$this->session->userdata('user');
			
			$u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified', 'from' => 'user', 'where' => array('user_id' => $user[0]->user_id)));
			
			$logo = get_user_logo($user[0]->user_id);
			$avg_rating = get_user_rating($user_id);
		
		?>
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
        <div class="left-side">
                <div class="header-image freelancer-avatar">
                	<img src="<?php echo $logo;?>" alt="">
                    <a href="javascript:void(0)" class="profile-pic-cam" title="<?php echo __('myprofile_emp_update_profile_picture','Update profile picture'); ?>"><i class="zmdi-hc-2x icon-feather-camera" style="line-height: 0.5;vertical-align: middle;" onclick="$('#profileModal').modal('show');"></i></a> 
                </div>
                <div class="header-details">
                    <h3><?php echo $fname.' '.$lname;?>
                    <?php  if($user_id==$user_login) { ?>
                
                      <a href="<?php echo base_url('dashboard/editprofile_professional')?>"><i class="icon-feather-edit"></i></a>
                
                      <?php } ?>
                      <span><?php echo $slogan;?></span>  
                    </h3>
                    
                    <div class="star-rating" data-rating="<?php echo $avg_rating; ?>"></div>
                    <ul>
                        <li><i class="icon-feather-map-pin"></i> <span><?php echo get_user_city($user_id); ?></span></li>
                        <?php if($verify=='Y'){ ?>
                        <li><div class="verified-badge-with-title" title="<?php echo __('myprofile_emp_approved','APPROVED'); ?>"> Verified</div></li>
						<?php }  ?>
                    </ul>
                    <a href="javascript:void(0)" class="btn btn-sm btn-cover" onclick="$('#coverModal').modal('show');"><i class="icon-feather-edit" style="line-height: 0.5;vertical-align: middle;"></i> <?php echo __('myprofile_cover_photo','Cover Photo'); ?> </a>
                </div>
            </div>
        </div>		
	</div>
    <div class="single-page-footer">
    <div class="container">
    
	<ul class="profile-list">

        <li><i class="icon-feather-user"></i> Member since: <span><?php echo date('d M, Y', strtotime($reg_date));?></span></li>		

		<?php if($account_type == 'F'){ ?>

        <li hidden><i class="icon-feather-clock"></i> <?php echo __('myprofile_emp_hourly_rate','Hourly Rate'); ?>: <span><?php echo CURRENCY; ?><?php echo $hourly_rate;?></span>

		<?php  if($user_id==$user_login) { ?>

      <a href="#hourly_rateModal" data-toggle="modal" class="pull-right" hidden><i class="zmdi zmdi-edit" style="font-size:15px; min-width:0"></i> Edit</a>

      <?php } ?>

		</li>

		<?php } ?>

        <li><i class="icon-feather-log-in"></i> <?php echo __('myprofile_emp_last_logged_on','Last logged on'); ?>: <span><?php echo date('d M,Y',strtotime($ldate));?></span></li>

		

		<?php 

		if($account_type == 'E'){ 

			$this->load->model('jobdetails/jobdetails_model');

			$user_totalproject = $this->jobdetails_model->gettotaluserproject($user_id);

			$total_posted = $this->dashboard_model->getProjectStatics($user_id);

			

			if(count($total_posted) > 0){foreach($total_posted as $k => $v){

			?>

		 <li><i class="icon-feather-tag"></i> <?php echo $v['name'] ?> : <span><?php echo $v['y'] ?></span></li>

		<?php } } ?>

		
		 <li><i class="icon-feather-tag"></i> <?php echo __('myprofile_emp_posted_jobs','Posted Jobs'); ?>: <span><?php echo $user_totalproject;?></span></li>

		 

		 <li><i class="icon-feather-tag"></i> <?php echo __('myprofile_emp_sidebar_total_spent','Total Spent'); ?>: <span><?php echo CURRENCY;?><?php echo get_project_spend_amount($user_id);?></span></li>

		 

		<?php  } ?>

		<?php if($account_type == 'F'){ ?>

        <li><i class="icon-feather-tag"></i> <?php echo __('myprofile_emp_amount_earned','Amount Earned'); ?>: <span><?php echo CURRENCY;?> <?php echo get_earned_amount($user_id);?></span></li>

		

        <li><i class="icon-feather-tag"></i> <?php echo __('myprofile_completed_projects','Completed Projects'); ?>: <span><?php echo get_freelancer_project($user_id, 'C');?></span></li>

		<?php /*?><li><a href="<?=VPATH?>findjob/"><i class="zmdi zmdi-search"></i> <?php echo __('myprofile_emp_browse_jobs','Browse jobs'); ?></a></li>

        <li><a href="<?php echo base_url('favourite'); ?>"><i class="zmdi zmdi-favorite"></i> <?php echo __('myprofile_emp_favorite_projects','Favourite Projects'); ?></a></li>
<?php */?>
		 

		<?php }else{  ?>

		 <?php /*?><li><a href="<?=VPATH?>findtalents/"><i class="zmdi zmdi-search"></i> <?php echo __('myprofile_','Browse Contractors'); ?></a></li><?php */?>

		<?php } ?>

    </ul>
    </div>
    </div>
    <div class="background-image-container" style="background-image: url('<?php echo $bg_full_path;?>');"></div>
</div>

<!-- profile background pic upload modal END -->
<section class="sec">
  <div class="container">
    <?php /*?><div class="profile-section"> <a href="javascript:void(0)" class="btn btn-cover" onclick="$('#coverModal').modal('show');"><!--<img src="<?php// echo IMAGE;?>camera-icon.png" alt="Cover Photo" />--><i class="zmdi zmdi-hc-2x zmdi-camera" style="line-height: 0.5;vertical-align: middle;"></i> <?php echo __('myprofile_emp_change_cover_photo','Change cover photo'); ?></a>
      <div class="clearfix">
        <aside class="col-md-9 col-sm-12 col-12">
          <div class="row">
            <?php $this->load->view('left_sidebar'); ?>
            <?php

		$user=$this->session->userdata('user');

		$u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified', 'from' => 'user', 'where' => array('user_id' => $user[0]->user_id)));



		?>
            <?php 

			if($this->session->userdata('user')){

			$userid=$this->session->userdata('user');

			$user_login=$userid[0]->user_id; 

		}

   		?>
            <div class="col-md-8 mt-3">
              <h4><?php echo $fname." ".$lname;?> <a href="#" class="edit_info pull-right" data-toggle="modal" data-target="#myModal"><i class="zmdi zmdi-edit"></i></a></h4>
              <p><?php echo $overview;?></p>
            </div>
          </div>
        </aside>
        <aside class="col-md-3 col-12 pull-right secondary_info">
          <div class="profileEdit">
            <?php  if($user_id==$user_login) { ?>
            <a href="<?php echo base_url('findjob')?>" class="btn btn-site btn-lg btn-block hidden"><i class="zmdi zmdi-case"></i> <?php echo __('myprofile_emp_find_job','Find Job'); ?></a> <a href="#" class="btn btn-success btn-lg btn-block hidden" data-toggle="modal" data-target="#inviteModal"><i class="zmdi zmdi-cocktail"></i> <?php echo __('myprofile_emp_invite','Invite'); ?></a>
            <?php }else{ ?>
            <a href="#" class="btn btn-success btn-lg btn-block hidden"><i class="zmdi zmdi-case"></i> <?php echo __('myprofile_emp_post_job','Post Job'); ?></a> <a href="#" class="btn btn-site btn-lg btn-block hidden"><i class="zmdi zmdi-account"></i> <?php echo __('myprofile_emp_hire_me','Hire Me'); ?></a>
            <?php  } ?>
            <br />
            <h4><?php echo __('dashboard_profileprofessional_verifications','Verifications'); ?></h4>
            <ul class="list-group">
              <li class="list-group-item hidden"><i class="zmdi zmdi-facebook-box"></i> Facebook Connected <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="Verified" style="color:#0c0;line-height:20px"></i></span></li>
              <li class="list-group-item d-none"><i class="zmdi zmdi-smartphone"></i> Payment Verified
                <?php if($u_row['payment_verified'] == 'Y'){ echo '<span class="pull-right f-12">Verified</span>'; }else{ ?>
                <button class="btn btn-xs btn-site pull-right">Verify</button>
                <?php } ?>
              </li>
              <li class="list-group-item"> <i class="zmdi zmdi-email"></i> <?php echo __('myprofile_emp_email_verified','Email Verified'); ?>
                <?php if($u_row['email_verified'] == 'Y'){ echo '<span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="Verified" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
                <button class="btn btn-xs btn-site pull-right" onclick="verify('email')"><?php echo __('myprofile_emp_verify','Verify'); ?></button>
                <?php } ?>
              </li>
              <li class="list-group-item d-none"> <i class="zmdi zmdi-smartphone"></i> <?php echo __('myprofile_emp_phone_verified','Phone Verified'); ?>
                <?php if($u_row['phone_verified'] == 'Y'){ echo '<span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="Verified" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
                <button class="btn btn-xs btn-site pull-right" onclick="verify('phone')"><?php echo __('myprofile_emp_verify','Verify'); ?></button>
                <?php } ?>
              </li>
            </ul>
          </div>
        </aside>
      </div>
    </div><?php */?>
    <div class="row">
      <aside class="col-lg-8 col-12">
        <div class="listing">
          <article class="card">
            <div class="card-header">
              <h4><i class="icon-feather-briefcase site-text"></i> <?php echo __('myprofile_emp_job_history','Job History'); ?> <a href="<?php echo base_url('postjob')?>" class="float-right btn btn-site btn-sm"><?php echo __('myprofile_emp_post_job','Post Job'); ?></a></h4>
            </div>
            <div class="card-body">
              <h4><?php echo __('myprofile_emp_completed_project','Completed project'); ?></h4>
              <table class="table">
                <?php if(count($completed_projects) > 0){foreach($completed_projects as $k => $v){ ?>
                <tr>
                  <td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']); ?>"><?php echo $v['title']; ?></a></td>
                  <td><?php echo $v['project_type'] == 'F' ? __('myprofile_emp_fixed','Fixed') : __('myprofile_emp_hourly','Hourly'); ?></td>
                  <td><?php echo __('myprofile_emp_posted_on','Posted on'); ?> : <?php echo date('d M, Y', strtotime($v['post_date'])); ?></td>
                </tr>
                <?php } }else{  ?>
                <tr>
                  <td colspan="10"><?php echo __('myprofile_emp_no_completed_project','No completed project'); ?></td>
                </tr>
                <?php } ?>
              </table>
              <h4><?php echo __('myprofile_emp_open_project','Open project'); ?></h4>
              <table class="table">
                <?php if(count($open_projects) > 0){foreach($open_projects as $k => $v){ ?>
                <tr>
                  <td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']); ?>"><?php echo $v['title']; ?></a></td>
                  <td><?php echo $v['project_type'] == 'F' ? __('myprofile_emp_fixed','Fixed') : __('myprofile_emp_hourly','Hourly'); ?></td>
                  <td><?php echo __('myprofile_emp_posted_on','Posted on'); ?> : <?php echo date('d M, Y', strtotime($v['post_date'])); ?></td>
                </tr>
                <?php } }else{  ?>
                <tr>
                  <td colspan="10"><?php echo __('myprofile_emp_no_open_project','No open project'); ?></td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </article>
</div>


		<!-- Rating and review start -->
		<div class="card compact-list-layout">
        <div class="card-header">
		<h4><i class="icon-feather-star site-text"></i> <?php echo __('myprofile_reviews_and_ratings','Reviews & Ratings'); ?></h4></div>
        <div class="card-body_">
		<?php

        if(count($review)>0){ 

		//get_print($review);

        ?>
            
            <!--Rating Review-->
            
            <?php

        foreach($review as $key => $val){  

              

            $username=$this->auto_model->getFeild('username','user','user_id',$val['review_to_user']);      

           $given_name=$this->auto_model->getFeild('fname','user','user_id',$val['review_by_user']);    
            $given_name.=' ';   
			$given_name.=$this->auto_model->getFeild('lname','user','user_id',$val['review_by_user']);
			$given_name = get_full_name($val['review_by_user']);
			$user_logo = get_user_logo($val['review_by_user']);

          $country=$this->auto_model->getFeild('country','user','user_id',$val['review_by_user']);
			$flag=$this->auto_model->getFeild("code2","country","Code",$country);
			$flag=  strtolower($flag).".png";
			$country_name = getField('Name', 'country', 'Code',$country);

        ?>
            <div class="job-listing ratingreview">
              <div class="job-listing-details">
              <div class="job-listing-company-logo"> <img src="<?php echo $user_logo;?>" alt="" class="rounded-circle" />                
              </div>
              <div class="job-listing-description">
                <h4>
                  <?php

          echo $this->auto_model->getFeild('title','projects','project_id',$val['project_id']);      

        ?>
                </h4>
                <div class="ratingAll">
                    <?php /*
                            for($i=1; $i<=5; $i++){
                    
                                if($i <= $val['average']){
                    
                                    echo ' <i class="zmdi zmdi-star"></i>';
                    
                                }else{
                    
                                    echo ' <i class="zmdi zmdi-star-outline"></i>';        
                                }
                            }
                    */ ?>
                  <div class="star-rating" data-rating="<?php echo round($avg_rating); ?>"></div>
                  <p><a href="javascript:void(0)" class="seeAll">See all skills rating <i class="zmdi zmdi-chevron-down"></i></a></p>
                  <div class="ratingtext" style="display:none">
                    <p><span>Behaviour:</span>
                      <?php

		for($i=1; $i<=5; $i++){

			if($i <= $val['behaviour']){

				echo ' <i class="zmdi zmdi-star"></i>';

			}else{

				echo ' <i class="zmdi zmdi-star-outline"></i>';

			}

		}

		?>
                    </p>
                    <p><span>Payment:</span>
                      <?php

		for($i=1; $i<=5; $i++){

			if($i <= $val['payment']){

				echo ' <i class="zmdi zmdi-star"></i>';

			}else{

				echo ' <i class="zmdi zmdi-star-outline"></i>';

			}

		}

		?>
                    </p>
                    <p><span>Availability: </span>
                      <?php

		for($i=1; $i<=5; $i++){

			if($i <= $val['availablity']){

				echo ' <i class="zmdi zmdi-star"></i>';

			}else{

				echo ' <i class="zmdi zmdi-star-outline"></i>';

			}

		}

		?>
                    </p>
                    <p><span>Communication: </span>
                      <?php

		for($i=1; $i<=5; $i++){

			if($i <= $val['communication']){

				echo ' <i class="zmdi zmdi-star"></i>';

			}else{

				echo ' <i class="zmdi zmdi-star-outline"></i>';

			}

		}

		?>
                    </p>
                    <p><span>Cooperation: </span>
                      <?php

		for($i=1; $i<=5; $i++){

			if($i <= $val['cooperation']){

				echo ' <i class="zmdi zmdi-star"></i>';

			}else{

				echo ' <i class="zmdi zmdi-star-outline"></i>';

			}

		}

		?>
                    </p>
                  </div>
                </div>
                <p><?php echo $val['comment'];?></p>
              </div>
              </div>
              <div class="job-listing-footer">
              	<ul>
                	<li><span><?php echo __('posted_by','Posted by');?>: <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $val['review_by_user'];?>"><?php echo ucwords( $given_name);?></a></span></li>
                    <li><span><i class="icon-feather-map-pin"></i> <?php echo $country_name; ?> <img class="flag" src="<?php echo IMAGE;?>cuntryflag/<?php echo $flag;?>" alt="" width="20"></span></li>
                	<li><span><i class="icon-feather-calendar"></i> <?php echo date('d M,Y',strtotime($val['added_date']));?></span></li>                    
                </ul>
              </div>
            </div>
            
            <!--Rating Review End-->
            
            <?php        

          }    

        } else{

             ?>
            
            <!--Rating Review-->
              <p class="text-muted"><?php echo __('myprofile_no_review_yet','No Review Yet.'); ?></p>
        
            <?php

        }

         

        ?>
        </div>
        </div>
        
      </aside>
      <aside class="col-sm-4 col-12">
        <div class="panel panel-default hidden">
          <div class="panel-heading">
            <h4>Certifications</h4>
          </div>
          <div class="card-body"> <a class="btn btn-site btn-block">Get Certified</a> <br>
            <p>You do not have any certifications.</p>
          </div>
        </div>
        <?php /*?><div class="panel panel-default">
          <div class="panel-heading">
            <h4><?php echo __('myprofile_emp_my_top_skills','My Top Skills'); ?></h4>
          </div>
          <div class="card-body" style="padding:0; margin:-1px 0 0">
            <ul class="list-group">
              <?php 

				if(!empty($user_skill)){ 

				

				foreach($user_skill as $key => $val){   

				?>
              <li class="list-group-item"><a href="<?php echo base_url('findtalents/browse').'/'.$this->auto_model->getcleanurl($val['parent_skill_name']).'/'.$val['parent_skill_id'].'/'.$this->auto_model->getcleanurl($val['skill']).'/'.$val['skill_id'];?>"><?php echo $val['skill'];?></a> <span class="badge hidden">100</span></li>
              <?php

				}

				}else{ 

				?>
              <li class="list-group-item">No Skills found</li>
              <?php } ?>
            </ul>
          </div>
        </div><?php */?>
      </aside>
    </div>
  </div>
</section>

<!-- Content End --> 

<!-- Skill Modal -->

<div class="modal fade" id="skillModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select Skills</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row-10">
          <aside class="col-sm-9 col-12">
            <div class="input-group" style="margin-bottom:10px"> <span class="input-group-addon"><i class="fa fa-search"></i></span>
              <input type="text" class="form-control" placeholder="Search your skills" onkeyup="uskill.searchSkill(this.value)"/>
            </div>
            <div class="parent_skill_wrapper">
              <ul class="parent_skill">
                <?php foreach ($parent_skill as $row){ ?>
                <li><a href="javacript:void(0)" data-parent-id="<?php echo !empty($row['id']) ? $row['id'] : ''; ?>" data-name="<?php echo !empty($row['skill_name']) ?$row['skill_name'] : 'N/A'; ?>" onclick="uskill.getChieldSkill(this,<?php echo !empty($row['id']) ? $row['id'] : ''; ?>)"><?php echo !empty($row['skill_name']) ?$row['skill_name'] : 'N/A'; ?></a></li>
                <?php } ?>
                <div class="clearfix"></div>
              </ul>
            </div>
            <div class="child_skill_wrapper" style="display:none;"> <a href="javascript:void(0)" onclick="uskill.hideChildPanel(); uskill.showParentPanel();"><i class="fa fa-arrow-left"></i> Back</a>
              <h4 id="parent_skill_name">Accountants &amp; Consultants</h4>
              <div id="child_skill_list_wrapper"> </div>
            </div>
          </aside>
          <aside class="col-sm-3 col-12">
            <h4>Selected Skills</h4>
            <p>You can see your selected skills here</p>
            <div class="spacer-15"></div>
            <form action="" id="submitUserSkillform">
              <div id="selected_skills_wrapper">
                <ul>
                  <li>
                    <input class="jbchk" name="user_skill[]" type="checkbox" id="chk_1" onclick="return gettotal(this.id);" value="330|332">
                    <label for="chk_1">Academic Writing</label>
                  </li>
                  <li>
                    <input class="jbchk" name="user_skill[]" type="checkbox" id="chk_2" onclick="return gettotal(this.id);" value="330|332">
                    <label for="chk_2">Academic Writing</label>
                  </li>
                  <li>
                    <input class="jbchk" name="user_skill[]" type="checkbox" id="chk_3" onclick="return gettotal(this.id);" value="330|332">
                    <label for="chk_3">Academic Writing</label>
                  </li>
                </ul>
              </div>
            </form>
          </aside>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-info" onclick="uskill.submitUserSkills()">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Portfolio Modal -->

<div class="modal fade" id="addPortfolioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="portfolioForm" onsubmit="dashboard.savePortfolio(this, event);">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title">Add Portfolio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="success alert-success alert" style="display:none">Your message has been sent successfully.</div>
            <span id="agree_termsError" class="error-msg2" style="display:none"></span>
            <input type="hidden" readonly="readonly" class="form-control"  value="" name="pid" id="pid" />
            <div class="form-group">
                <label>Title : </label>
                <input type="text" class="form-control" size="30" value="" name="title" id="title" tooltipText="Enter Title" />
                <span id="titleError" class="error-msg2"></span> 
            </div>
            <div class="form-group">
                <label>Description :</label>
                <textarea class="form-control" name="description" id="description" rows="3" style="min-width:56%" tooltipText="Enter Description" ></textarea>
                <span id="descriptionError" class="error-msg2"></span> 
            </div>
            <div class="form-group">
                <label>Tags</label>
                <input type="text" class="form-control" size="30" name="tags"  id="tags" value="" tooltipText="Enter Tags" />
                <span id="tagsError" class="error-msg2"></span> 
            </div>
            <div class="form-group">
                <label>URL</label>
                <input type="text" class="form-control" size="30" name="url" id="url"  value="" tooltipText="Enter URL" />
                <span id="urlError" class="error-msg2"></span> 
            </div>
            <div class="form-group">
                <label>Portfolio :</label>
                <div class="clearfix"></div>
                <img id="uploded_img" class="img-thumbnail"/> <span id="img_name"></span> <span id="userfileError" class="error" style="color:red;"></span> <span id="original_imgError" class="error-msg2"></span>
                <div class="masg2">
                  <div class="input-group" style="margin-bottom:8px">
                    <input type="hidden" name="original_img" value="" id="original_img_name"/>
                    <input type="hidden" name="thumb_img" value="" id="thumb_img_name"/>
                    <label class="input-group-btn"> 
                      
                      <!-- <span class="btn btn-grey">

                Browse&hellip; <input type="file" class="form-control" size="30" name="userfile" id="userfile" onchange="movefile(this)" style="display: none;" multiple>

            </span>--> 
                      
                      <span class="btn btn-grey"> Browse&hellip;
                      <input type="file" class="form-control" size="30" name="userfile" onchange="dashboard.uploadPortfolioFile(this)" style="display: none;">
                      </span> </label>
                    <input type="text" class="form-control" readonly>
                  </div>
                </div>
                <img id="loading" src="<?php echo VPATH;?>assets/images/loading.gif" style="display:none;margin:10px;"> <span style="color:red;float:left;width:100%;"> jpg, png , jpeg and gif files are allowed.</span> 
            </div>
          </div>
        
        
        <!-- <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

        <button type="button" class="btn btn-info" id="submit-check" onclick="addFormPost()">Save</button>

      </div>-->
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-site">Save</button>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- Modal -->

<div class="modal fade"  id="profileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Profile Picture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div style="width: 100%;">
          <form id="profile_pic_upload_form">
            <div class="file_upload_bx">
              <input type="file" id="profile_pic_file" onchange="pf.upload(this);"/>
              <i class="icon-feather-camera"></i> </div>
            <input id="profile_pic_file_name" type="hidden"/>
            <p class="error center" style="display:none; color:#f00" id="file_type_error">Invalid file type</p>
            <div class="progress" id="profile_pic_progress" style="display:none;">
              <div class="progress-bar determinate" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </form>
          <div id="crop_image_wrapper" style="display:none;"> <img id="profile_pic_crop" style="max-width: 100%;"/> </div>
        </div>
      </div>
      <div class="modal-footer" id="p_m_footer" style="display:none;"> <a href="javascript:void(0);" class="btn btn-site" id="crop_image_btn" onclick="pf.cropImage();">Save</a> </div>
    </div>
  </div>
</div>
<div class="modal fade" id="coverModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Cover Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div style="width: 100%;">
          <form id="bg_pic_upload_form">
            <div class="file_upload_bx">
              <input type="file" onchange="pf.uploadBg(this);"/>
              <input id="bg_pic_file_name" type="hidden"/>
              <i class="icon-feather-camera"></i> </div>
            <p class="error center" style="display:none" id="bgfile_type_error">Invalid file type</p>
            <div class="progress" id="profile_bg_progress" style="display:none;">
              <div class="progress-bar determinate" role="progressbar" aria-valuemin="0" aria-valuemax="100"> </div>
            </div>
          </form>
          <div id="bg_crop_image_wrapper" style="display:none;"> <img id="bg_pic_crop" style="max-width: 100%;"/> </div>
        </div>
      </div>
      <div class="modal-footer" id="pb_m_footer" style="display:none;"> <a href="javascript:void(0);" class="btn btn-site" onclick="pf.cropBgImage();">Save</a> </div>
    </div>
  </div>
</div>
<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Send a private message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <textarea rows="4" class="form-control" placeholder="Hi manager2015, I noticed your profile and would like to offer you my project. We can discuss any details over chat." style="margin-bottom:10px"></textarea>
        <select class="form-control" style="margin-bottom:10px">
          <option>Project name here</option>
        </select>
        <div class="clearfix"></div>
        <h5>My Budget (Minimum: <i class="fa fa-inr hide"></i> ₹ 600)</h5>
        <div class="checkbox radio-inline" style="margin:0">
          <input type="radio" class="magic-radio" name="price" id="1" checked="">
          <label for="1"> Set Fixed Price</label>
        </div>
        <div class="checkbox radio-inline" style="margin:0">
          <input type="radio" class="magic-radio" name="price" id="2">
          <label for="2"> Set An Hourly Rate</label>
        </div>
        <div class="spacer-15"></div>
        <form class="form-horizontal">
          <div class="form-group row-5">
            <div class="col-sm-7 col-12">
              <div class="input-group"> <span class="input-group-addon">₹</span>
                <input type="number" class="form-control" value="250" style="padding-right:0" />
                <span class="input-group-addon" style="padding:0; background:none">
                <select style="height:32px; border:none; padding:0 6px">
                  <option>INR</option>
                  <option>EUR</option>
                  <option>USD</option>
                </select>
                </span> </div>
            </div>
            <div class="col-sm-5 col-12">
              <div class="input-group">
                <input type="number" class="form-control" value="12" style="padding-right:0" />
                <span class="input-group-addon">hr/week</span> </div>
            </div>
          </div>
        </form>
        
        <!--<form action="" class="form-horizontal">

    <div class="form-group">

        <div class="col-sm-8">

            <input type="text" class="form-control" placeholder="MinVal">

        </div>

        <div class="col-sm-4">

            <input type="text" class="form-control" placeholder="MaxVal">

        </div>

    </div>

</form>-->
        
        <div class="checkbox checkbox-inline">
          <input class="magic-checkbox" name="termsandcondition" id="confirm" value="Y" type="checkbox">
          <label for="confirm" style="font-size:12px">Please send me bids from other freelancers if my project is not accepted.</label>
        </div>
        <a href="#" class="btn btn-success btn-block" style="margin:5px 0">Hire Now</a>
        <p style="font-size:12px">By clicking the button, you have read and agree to our Terms &amp; Conditions and Privacy Policy.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <form action="" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo __('myprofile_emp_overview','Overviews'); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <textarea name="overview" class="form-control" rows="6"><?php echo $overview;?></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#myModal').modal('hide');"><?php echo __('myprofile_emp_close','Close'); ?></button>
          <button type="submit"  class="btn btn-site"><?php echo __('myprofile_emp_save','Save'); ?></button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <form action="" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Work experience</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <textarea name="work_experience" class="form-control"><?php echo $work_experience;?></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#myModal2').modal('hide');">Close</button>
          <button type="submit"  class="btn btn-site">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <form action="" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Education</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <textarea name="education" class="form-control"><?php echo $education;?></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#myModal3').modal('hide');">Close</button>
          <button type="submit"  class="btn btn-site">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <form action="" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Certificates</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <textarea name="certification" class="form-control"><?php echo $certification;?></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#myModal4').modal('hide');">Close</button>
          <button type="submit"  class="btn btn-site">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="portfolioModal" tabindex="-1" role="dialog" aria-labelledby="portmyModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <?php //echo $val['title'];?>
        </h5>
        <button type="button" onclick="jQuery('#portfolioModal').modal('hide');" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-8 col-12"> <img src="<?php echo ASSETS;?>portfolio/Hydrangeas.jpg" alt="" class="img-responsive" id="port_big_img" style="width:100%;"> </div>
          <div class="col-sm-4 col-12">
            <div class="profile_pic pic-sm"> <span>
              <?php

        

                if($logo!='' && file_exists('assets/uploaded/cropped_'.$logo))

        

                {

        

                ?>
              <img alt="" src="<?php echo VPATH;?>assets/uploaded/<?php echo 'cropped_'.$logo;?>"  class="img-circle">
              <?php

        

                }

        

                else

        

                {

        

                ?>
              <img alt="" src="<?php echo VPATH;?>assets/images/face_icon.gif"  class="img-circle">
              <?php } ?>
              </span> </div>
            <div class="pull-left">
              <?php 

			   $flag=$this->auto_model->getFeild("code2","country","Code",$user_country);

			   $flag=  strtolower($flag).".png";

			   // echo $city.", ".$country;

			   if(is_numeric($city)){

				   $city = getField('Name', 'city', 'ID', $city);

			   }

			   $c = getField('Name', 'country', 'Code',$user_country);

			?>
              <h4><?php echo $fname." ".$lname;?></h4>
              <p><img src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>" alt=""> &nbsp;<span><?php echo $city; ?>,</span> <?php echo $c; ?></p>
            </div>
            <a href="#" class="hidden btn btn-site btn-lg btn-block"><i class="zmdi zmdi-account"></i> Hire Me</a>
            <div class="spacer-10"></div>
            <p class="hidden"><b>Hourly Rate:</b> <?php echo CURRENCY;?><?php echo $rate;?></p>
            <h5>About the project</h5>
            <ul class="skills hidden">
              <li><a href="#">Graphic Design</a></li>
            </ul>
            <p id="port_dscr"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="text-align:left;"> </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog modal-sm"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo __('myprofile_emp_verification','Verification'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="jQuery('#verifyModal').modal('hide');">&times;</button>
      </div>
      <div class="modal-body">
        <div id="processing">
          <p class="text-center"><?php echo __('myprofile_emp_processing','Processing...'); ?></p>
        </div>
        <div id="email_verification_section" class="verifySection">
          <p><?php echo __('myprofile_emp_verification_link_send_to_your_register_email','Verification link has been successfully send  to your registered email id'); ?> <b><?php echo $user[0]->email; ?></b>. <span class="hidden"><?php echo __('myprofile_emp_if_this_is_not_your_email_then','If this is not your email then'); ?> <a href="javascript:void(0);"><?php echo __('myprofile_emp_click_here','click here'); ?></a> <?php echo __('myprofile_emp_to_change_your_email_address','to change your email address'); ?></span> </p>
        </div>
        <div id="phone_verification_section" class="verifySection">
          <form id="phone_verify_form" class="verifySection">
            <input type="text" id="phone_no" value="" placeholder="<?php echo __('myprofile_emp_enter_10_degit_phone_mobile_number','Enter 10 digit phone/mobile number'); ?>" class="form-control"/>
            <span id="phoneError" class="rerror"></span>
            <button type="button" class="btn btn-site btn-block" onclick="verify_phone();" style="margin-top:15px"><?php echo __('myprofile_emp_send_verification_code','Send Verification Code'); ?></button>
          </form>
          <form id="phone_code_verify_form" class="verifySection">
            <p><?php echo __('myprofile_emp_send_verification_code_into_number_text','A verification code has sent to your phone/mobile number . Please enter the code to verify your phone/mobile.'); ?> </p>
            <input type="text" id="phone_ver_code" name="phone_ver_code" value="" placeholder="<?php echo __('myprofile_emp_enter_the_verification_code','Enter the verification code'); ?>" class="form-control"/>
            <input type="hidden" id="phone_num" name="phone_num"/>
            <span id="phoneCodeError" class="rerror"></span>
            <button type="button" class="btn btn-success" onclick="verify_phone_code();"><?php echo __('myprofile_emp_verify','Verify'); ?></button>
          </form>
          <div id="phone_verification_status_section"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="hourly_rateModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <form action="" method="post" class="form-horizontal">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit hour</h5>
          <button type="button" class="close" data-dismiss="modal" onclick="$('#myModal').modal('hide');">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Hour/week:</label>
              <input type="number" name="available_week" class="form-control" value="<?php echo !(empty($available_hr)) ? number_format($available_hr) : '' ; ?>" min="1" max="168"/>

          </div>
          <label>Hourly rate:</label>
          <div class="input-group"> <span class="input-group-addon" id="basic-addon1"><?php echo CURRENCY;?></span>
            <input type="text" placeholder="Hourly rate" aria-label="hourlyrate" aria-describedby="basic-addon1" name="hourly_rate" class="form-control" value="<?php echo !(empty($hourly_rate)) ? number_format($hourly_rate, 2) : '' ; ?>">
          </div>
          <br/>
          <button type="submit" class="btn btn-site btn-block" name="submit" value="edit_hour">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>

$(document).ready(function(){ 

$('.seeAll').click(function(){

	var content=$(this).closest('.ratingAll').find('.ratingtext');

	if(content.is(':visible')){

		content.hide();

	}else{

		$('.ratingtext').hide();

		content.show();

	}

});

}); 

</script> 
<script>

var dashboard = (function($){

	var PORTFOLIO_PATH = '<?php echo base_url('assets/portfolio')?>/';

	var ret = {};

	

	ret.savePortfolio = function(form, evt){

		$('.error-msg2').empty();

		evt.preventDefault();

		var fdata = $(form).serialize();

		$.ajax({

			url: '<?php echo base_url('dashboard/save_new_portfolio');?>',

			data: fdata,

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res.status == 0){

					for(var i in res.errors){

						$('#'+i+'Error').html(res.errors[i]);

					}

				}else{

					location.reload();

				}

			}

		});

		

	};

	

	ret.uploadPortfolioFile = function(ele){

		var file = $(ele)[0].files[0];

		if(file){

			$('.error').empty();

			var fdata = new FormData();

			fdata.append('userfile', file);

			$.ajax({

				url : '<?php echo base_url('dashboard/updatePortfolioFile')?>',

				data: fdata,

				type: 'POST',

				dataType: 'json',

				contentType: false,

				processData: false,

				success: function(res){

					if(res.status == 1){

						$('#original_img_name').val(res.data.original_img);

						$('#thumb_img_name').val(res.data.thumb_img);

						$('#uploded_img').attr('src', PORTFOLIO_PATH + res.data.thumb_img);

						$('#img_name').html(res.data.original_img);

					}else{

						for(var i in res.error){

							$('#'+i+'Error').html(res.error[i]);

							$('#original_img_name').val('');

							$('#thumb_img_name').val('');

						}

					}

				}

				

			});

		}

	};

	

	return ret;

	

	

})(jQuery);



</script> 
<script>

	(function($){

		

		window.uskill = {};

		

		uskill.skill_limit = <?php echo $total_plan_skill;?>;

		

		uskill.hideParentPanel = function(){

			$('#skillModal').find('.parent_skill_wrapper').slideUp('fast');

		};

		

		uskill.showParentPanel = function(){

			$('#skillModal').find('.parent_skill_wrapper').slideDown('fast');

		};

		

		uskill.showChildPanel = function(){

			$('#skillModal').find('.child_skill_wrapper').slideDown('fast');

		};

		

		uskill.hideChildPanel = function(){

			$('#skillModal').find('.child_skill_wrapper').slideUp('fast');

		};

		

		

		uskill.saved_skills = <?php echo json_encode($user_skill)?>;

		uskill.skill_ids = [];

		

		uskill.getSkillId = function(skills){

			var tmp_skill_id = [];

			if(skills.length > 0){

				for(var i in skills){

					tmp_skill_id.push(skills[i].skill_id);

					

				}

			}

			

			return tmp_skill_id;

		};

		

		uskill.skill_ids = uskill.getSkillId(uskill.saved_skills);

		

		uskill.getChieldSkill = getChieldSkill;

		

		

		uskill.loadSelectedSkill = function(){

			var html = '<ul class="selected_skill">';

			if(uskill.saved_skills.length > 0){

				for(var i in uskill.saved_skills){

					

					html += '<li id="selected_skill_item_'+uskill.saved_skills[i].skill_id+'"><input class="magic-checkbox" name="user_skill[]" onclick="uskill.checkSelected(this, event)" type="checkbox" id="selected_skill_'+uskill.saved_skills[i].skill_id+'" checked="checked" value="'+uskill.saved_skills[i].parent_skill_id+'|'+uskill.saved_skills[i].skill_id+'" data-skill-name="'+uskill.saved_skills[i].skill+'"><label for="selected_skill_'+uskill.saved_skills[i].skill_id+'">'+uskill.saved_skills[i].skill+'</label></li>';

					

					

				}

			}

			html += '</ul>';

			$('#selected_skills_wrapper').html(html);

		};

		

		uskill.init = function(){

			this.loadSelectedSkill();

		};

		

		uskill.checkSelected = function(ele, e){

			var checked = $(ele).prop('checked');

			var val_str = $(ele).val().split('|');

			var val = val_str[1];

			var parent = val_str[0];

			var skill_name = $(ele).data('skillName');

			

			if(checked){

				

				if(uskill.skill_ids.length >= uskill.skill_limit){

					

					// prevent from being checked;

					e.preventDefault();

					alert('Please upgrade your membership plan to add more skills in your profile.');

					return;

				

				}

				

				if($('#selected_skills_wrapper').find('#selected_skill_item_'+val).length == 0){

					

					var html = '<li id="selected_skill_item_'+val+'"><input class="magic-checkbox" name="user_skill[]" type="checkbox" id="selected_skill_'+val+'" checked="checked" value="'+parent+'|'+val+'" data-skill-name="'+skill_name+'" onclick="uskill.checkSelected(this, event)"><label for="selected_skill_'+val+'">'+skill_name+'</label></li>';

					

					$('#selected_skills_wrapper').find('ul').append(html);

					

					uskill.skill_ids.push(val);

					

					

				}

				

			}else{

				

				$('#selected_skills_wrapper').find('#selected_skill_item_'+val).remove();

				$('#child_skill_list_wrapper').find('#child_skill_'+val).removeAttr('checked');

				var ind = uskill.skill_ids.indexOf(val);

			

				uskill.skill_ids.splice(ind, 1);

			}

			

		};

		

		var srchReq;

		

		uskill.searchSkill = function(term){

			

			if(term == ''){

				uskill.showParentPanel();

				uskill.hideChildPanel();

				return false;

			}

			$('#parent_skill_name').html('Showing results for <i>' + term+'</i>');

			

			if(srchReq){

				srchReq.abort();

			}

			

			srchReq = $.ajax({

				url : '<?php echo base_url('dashboard/searchSkill')?>',

				type : 'POST',

				data : {term: term},

				dataType: 'JSON',

				success : function(res){

					if(res['status'] == 'Y'){

						

						uskill.hideParentPanel();

						uskill.showChildPanel();

						

						var html = '<ul class="child_skill">';

						if(res.data.length > 0){

							for(var i in res.data){

								

								var checked = '';

								

								if(uskill.skill_ids.indexOf(res.data[i].id) != -1){

									checked = 'checked="checked"';

								}

								

								html += '<li><input class="magic-checkbox" name="user_skill[]" onclick=" uskill.checkSelected(this, event)" type="checkbox" id="child_skill_'+res.data[i].id+'" '+checked+' value="'+res.data[i].parent+'|'+res.data[i].id+'" data-skill-name="'+res.data[i].skill_name+'"><label for="child_skill_'+res.data[i].id+'">'+res.data[i].skill_name+'</label></li>';

							}

						}

						html += '</ul>';

						$('#child_skill_list_wrapper').html(html);

					}else{

						

						var html = '<p>Sorry , no result found</p>';

						$('#child_skill_list_wrapper').html(html);

					}

				}

			});

		};

		

		function getChieldSkill(ele,id){

			

			if(!id){

				return false;

			}

			

			var parent_skill_name = $(ele).data('name') || '';

			

			$('#parent_skill_name').html(parent_skill_name);

			$.ajax({

				url : '<?php echo base_url('dashboard/getChieldSkill')?>',

				type : 'POST',

				data : {id: id},

				dataType: 'JSON',

				success : function(res){

					if(res['status'] == 'Y'){

						

						uskill.hideParentPanel();

						uskill.showChildPanel();

						

						var html = '<ul class="child_skill">';

						if(res.data.length > 0){

							for(var i in res.data){

								

								var checked = '';

								

								if(uskill.skill_ids.indexOf(res.data[i].id) != -1){

									checked = 'checked="checked"';

								}

								

								html += '<li><input class="magic-checkbox" name="user_skill[]" onclick=" uskill.checkSelected(this, event)" type="checkbox" id="child_skill_'+res.data[i].id+'" '+checked+' value="'+res.parent+'|'+res.data[i].id+'" data-skill-name="'+res.data[i].skill_name+'"><label for="child_skill_'+res.data[i].id+'">'+res.data[i].skill_name+'</label></li>';

							}

						}

						html += '</ul>';

						$('#child_skill_list_wrapper').html(html);

						

					}else{

						

						var html = '<p>Sorry , no result found</p>';

						$('#child_skill_list_wrapper').html(html);

					}

				}

			});

		}

		

		uskill.submitUserSkills = function(){

			

			var skills = $('#submitUserSkillform').serializeArray();

			console.log(skills);

			$.ajax({

				url : '<?php echo base_url('dashboard/updateskillajax')?>',

				type : 'POST',

				data : {user_skill : skills},

				dataType : 'JSON',

				success : function(data){

					if(data.status == 1){

						

						window.location.reload()

					}

				}

			});

		};

		

	

		

		uskill.init();

		

	})(jQuery);

	





</script> 
<script>

	function verify(type){

		

		var $ = jQuery;

		

		$('.verifySection').hide();

		if(type == 'email'){

			

			

			$('#processing').show();

			$.ajax({

				url : '<?php echo base_url('dashboard/email_verify')?>',

				type : 'POST',

				dataType: 'JSON',

				success : function(res){

					if(res['status'] == 1){

						$('#email_verification_section').show();

						

					}

				}

			});

			

		

			

			

		}else if(type == 'phone'){

			

			$('#phone_verification_section').show();

			$('#phone_verify_form').show();

			$('#processing').hide();

			$('#phone_verification_status_section').hide();

			/*$('#processing').show();

			$.ajax({

				url : '<?php echo base_url('dashboard/phone_verify')?>',

				type : 'POST',

				dataType: 'JSON',

				success : function(res){

					

					if(res['status'] == 1){

						$('#phone_verification_section').show();

						$('#phone_verify_form').show();

					}

				}

			});*/

			

			

			

		}

		

		$('#verifyModal').modal('show');

	}

	

	function verify_phone(){

		var $ = jQuery;

		if($('#phone_no').val().trim() == ''){

			$('#phoneError').html('<?php echo __('myprofile_emp_please_enter_a_valid_phone_number','Please enter a valid phone number'); ?>');

		}else if($('#phone_no').val().trim().length !=  10){

			$('#phoneError').html('<?php echo __('myprofile_emp_please_enter_a_valid_phone_number','Please enter a valid phone number'); ?>');

		}else if(isNaN($('#phone_no').val().trim())){

			$('#phoneError').html('<?php echo __('myprofile_emp_please_enter_a_valid_phone_number','Please enter a valid phone number'); ?>');

		}else{

			$('#phoneError').html('');

			var p_num = $('#phone_no').val();

			

			$.ajax({

				url : '<?php echo base_url('dashboard/phone_verify')?>',

				type : 'POST',

				data: {phone : p_num},

				dataType: 'JSON',

				success : function(res){

					if(res['status'] == 1){

						$('.verifySection').hide();

						$('#phone_verification_section').show();

						$('#phone_code_verify_form').show();

						$('#phone_num').val(res['phone']);

					}

				}

			});

		}

	}

	

	function verify_phone_code(){

			var $ = jQuery;

		$('#processing').show();

		

		var fdata = $('#phone_code_verify_form').serialize();

		$.ajax({

				url : '<?php echo base_url('dashboard/phone_code_verify')?>',

				type : 'POST',

				data: fdata,

				dataType: 'JSON',

				success : function(res){

					$('#processing').hide();

					$('#phone_code_verify_form').hide();

					if(res['status'] == 1){

						location.reload();

					}else{

						$('#phone_verification_status_section').html('<p><?php echo __('myprofile_emp_invalid_code','Invalid Code'); ?> <button onclick="verify(\'phone\')" class="btn btn-primary"><?php echo __('myprofile_emp_try_again','Try Again'); ?></button></p>');

						$('#phone_verification_status_section').show();

					}

					

				}

			});

	}

</script> 
<script type="text/javascript">

	jQuery(document).ready(function($){

		$("a[id^='parent_']").click(function(e){

			e.preventDefault();

			var parent = $(this).attr('data-child');

			$('#child_'+parent).toggle();

		});

	});	

</script> 
<script>



function saveCertification(){

	var $ = jQuery;

	var f = $('#certificationForm'),

		fdata = f.serialize(),

		cer_title = $('#cer_title').val(),

		cer_duration = $('#cer_duration').val(),

		cer_institute = $('#cer_institute').val(),

		

		submitform = true;

		

	if(cer_title == ''){

		$('#cer_titleError').html('Please enter title');

		submitform = false;

	}else{

		$('#cer_titleError').html('');

	}

	

	if(cer_duration == ''){

		$('#cer_durationError').html('Please choose duration');

		submitform = false;

	}else{

		$('#cer_durationError').html('');

	}

	

	if(cer_institute == ''){

		$('#cer_instituteError').html('Please enter institute');

		submitform = false;

	}else{

		$('#cer_instituteError').html('');

	}

	

	if(submitform){

		$.ajax({

			url : '<?php echo base_url('dashboard/saveCertificate')?>',

			data: fdata,

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['status'] == 1){

					f[0].reset();

					addCertification(res['data'], res['certificate_id']);

					$('#certificationWrapperAll').show();

					$('#certificationForm').hide();

				}

			}

		});

	}

	

}



function saveEditCertification(edu_id){

	var $ = jQuery;

	var f = $('#certificationForm'),

		fdata = f.serialize(),

		cer_title = $('#cer_title').val(),

		cer_duration = $('#cer_duration').val(),

		cer_institute = $('#cer_institute').val(),

		submitform = true;

		

	if(cer_title == ''){

		$('#cer_titleError').html('Please enter title');

		submitform = false;

	}else{

		$('#cer_titleError').html('');

	}

	

	if(cer_duration == ''){

		$('#cer_durationError').html('Please choose duration');

		submitform = false;

	}else{

		$('#cer_durationError').html('');

	}

	

	if(cer_institute == ''){

		$('#cer_instituteError').html('Please enter institute');

		submitform = false;

	}else{

		$('#cer_instituteError').html('');

	}

	

	if(submitform){

		$.ajax({

			url : '<?php echo base_url('dashboard/editCertificate')?>/'+edu_id,

			data: fdata,

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['status'] == 1){

					f[0].reset();

					replaceCertification(res['data'], edu_id);

					$('#certificationWrapperAll').show();

					$('#certificationForm').hide();

				}

			}

		});

	}

	

}



function addCertification(data, edu_id){

	var $ = jQuery;

	var edu_data = $.parseJSON(data);

	var html = '<div id="certificate_'+edu_id+'"><h4>'+edu_data.title+' ('+edu_data.duration +' month ) <a class="pull-right icon-round" data-certificate-data=\''+data+'\' data-certificate-id="'+edu_id+'" onclick="editCertification(this)" title="Edit"><i class="zmdi zmdi-edit"></i></a> <a class="pull-right icon-round" data-certificate-id="'+edu_id+'" onclick="deleteCertificate('+edu_id+')" title="Delete"><i class="zmdi zmdi-delete"></i></a></h4><p>'+edu_data.institute+'</p></div>';

	

	$('#certificationWrapper').append(html);

	

	$('#no_certification').remove();

}



function replaceCertification(data, edu_id){

	var $ = jQuery;

	var edu_data = $.parseJSON(data);

	var html = '<div id="certificate_'+edu_id+'"><h4>'+edu_data.title+' ('+edu_data.duration +' month ) <a class="pull-right icon-round" data-certificate-data=\''+data+'\' data-certificate-id="'+edu_id+'" onclick="editCertification(this)" title="Edit"><i class="zmdi zmdi-edit"></i></a> <a class="pull-right icon-round" data-certificate-id="'+edu_id+'" onclick="deleteCertificate('+edu_id+')" title="Delete"><i class="zmdi zmdi-delete"></i></a></h4><p>'+edu_data.institute+'</p></div>';

	

	$('#certificate_'+edu_id).replaceWith(html);

}



function editCertification(ele){

	var $  = jQuery;

	var edu_data = $(ele).data('certificateData'),

		edu_id = $(ele).data('certificateId');

		

	$('#cer_title').val(edu_data.title);

	$('#cer_duration').val(edu_data.duration);

	$('#cer_institute').val(edu_data.institute);

	

	$('#save-certificate-btn').attr('onclick', 'saveEditCertification('+edu_id+')');

	$('#certificationWrapperAll').hide();

	$('#certificationForm').show();

}



function addNewCertification(){

	var $ = jQuery;

	$('#certificationWrapperAll').hide();

	$('#certificationForm').show();

	$('#save-certificate-btn').attr('onclick', 'saveCertification()');

}



function cancelCertification(){

	var $ = jQuery;

	$('#certificationForm')[0].reset();

	$('#certificationWrapperAll').show();

	$('#certificationForm').hide();

}



function deleteCertificate(c_id){

	var $ = jQuery;

	if(c_id != ''){

		$.ajax({

			url : '<?php echo base_url('dashboard/delete_certificate')?>',

			data: {c_id : c_id},

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['status'] == 1){

					$('#certificate_'+c_id).remove();

				}

			}

		});

	}

	

}



/* ---------------------------------------------------- */

function saveEducation(){

	var $ = jQuery;

	var f = $('#educationForm'),

		fdata = f.serialize(),

		edu_country = $('#edu_country').val(),

		edu_univeristy = $('#edu_univeristy').val(),

		edu_degree = $('#edu_degree').val(),

		edu_start_year = $('#edu_start_year').val(),

		edu_end_year = $('#edu_end_year').val(),

		submitform = true;

		

	if(edu_country == ''){

		$('#edu_countryError').html('Please choose countrry');

		submitform = false;

	}else{

		$('#edu_countryError').html('');

	}

	

	if(edu_univeristy == ''){

		$('#edu_univeristyError').html('Please choose university/college');

		submitform = false;

	}else{

		$('#edu_univeristyError').html('');

	}

	

	if(edu_degree == ''){

		$('#edu_degreeError').html('Please enter degree');

		submitform = false;

	}else{

		$('#edu_degreeError').html('');

	}

	

	if(edu_start_year == ''){

		$('#edu_start_yearError').html('Please choose start year');

		submitform = false;

	}else{

		$('#edu_start_yearError').html('');

	}

	

	if(edu_end_year == ''){

		$('#edu_end_yearError').html('Please choose end year');

		submitform = false;

	}else{

		$('#edu_end_yearError').html('');

	}

	

	if(submitform){

		$.ajax({

			url : '<?php echo base_url('dashboard/saveEducation')?>',

			data: fdata,

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['status'] == 1){

					f[0].reset();

					addEducation(res['data'], res['education_id']);

					$('#educationWrapperAll').show();

					$('#educationForm').hide();

				}

			}

		});

	}

	

}



function saveEditEducation(edu_id){

	var $ = jQuery;

	var f = $('#educationForm'),

		fdata = f.serialize(),

		edu_country = $('#edu_country').val(),

		edu_univeristy = $('#edu_univeristy').val(),

		edu_degree = $('#edu_degree').val(),

		edu_start_year = $('#edu_start_year').val(),

		edu_end_year = $('#edu_end_year').val(),

		submitform = true;

		

	if(edu_country == ''){

		$('#edu_countryError').html('Please choose countrry');

		submitform = false;

	}else{

		$('#edu_countryError').html('');

	}

	

	if(edu_univeristy == ''){

		$('#edu_univeristyError').html('Please choose university/college');

		submitform = false;

	}else{

		$('#edu_univeristyError').html('');

	}

	

	if(edu_degree == ''){

		$('#edu_degreeError').html('Please enter degree');

		submitform = false;

	}else{

		$('#edu_degreeError').html('');

	}

	

	if(edu_start_year == ''){

		$('#edu_start_yearError').html('Please choose start year');

		submitform = false;

	}else{

		$('#edu_start_yearError').html('');

	}

	

	if(edu_end_year == ''){

		$('#edu_end_yearError').html('Please choose end year');

		submitform = false;

	}else{

		$('#edu_end_yearError').html('');

	}

	

	if(submitform){

		$.ajax({

			url : '<?php echo base_url('dashboard/editEducation')?>/'+edu_id,

			data: fdata,

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['status'] == 1){

					f[0].reset();

					replaceEducation(res['data'], edu_id);

					$('#educationWrapperAll').show();

					$('#educationForm').hide();

				}

			}

		});

	}

	

}



function addEducation(data, edu_id){

	var $ = jQuery;

	var edu_data = $.parseJSON(data);

	var u = $('#edu_univeristy').find('[value="'+edu_data.university+'"]').text();

	var c = $('#edu_country').find('[value="'+edu_data.country+'"]').text();

	var html = '<div id="education_'+edu_id+'"><h3>'+edu_data.degree+' <a class="pull-right icon-round" data-education-data=\''+data+'\' data-education-id="'+edu_id+'" onclick="editEducation(this)" title="Edit"><i class="zmdi zmdi-edit"></i></a> <a class="pull-right icon-round" data-education-id="'+edu_id+'" onclick="deleteEducation('+edu_id+')" title="Delete"><i class="zmdi zmdi-delete"></i></a></h3><p><b>'+u+' , '+c+'</b> '+edu_data.start_year+'-'+edu_data.end_year+' </p></div>';

	

	$('#educationWrapper').append(html);

	

	$('#no_education').remove();

}



function replaceEducation(data, edu_id){

	var $ = jQuery;

	var edu_data = $.parseJSON(data);

	var u = $('#edu_univeristy').find('[value="'+edu_data.university+'"]').text();

	var c = $('#edu_country').find('[value="'+edu_data.country+'"]').text();

	var html = '<div id="education_'+edu_id+'"><h4>'+edu_data.degree+' <a class="pull-right icon-round" data-education-data=\''+data+'\' data-education-id="'+edu_id+'" onclick="editEducation(this)" title="Edit"><i class="zmdi zmdi-edit"></i></a> <a class="pull-right icon-round" data-education-id="'+edu_id+'" onclick="deleteEducation('+edu_id+')" title="Delete"><i class="zmdi zmdi-delete"></i></a></h4><p><b>'+u+' , '+c+'</b> '+edu_data.start_year+'-'+edu_data.end_year+' </p></div>';

	

	$('#education_'+edu_id).replaceWith(html);

}



function editEducation(ele){

	var $  = jQuery;

	var edu_data = $(ele).data('education-data'),

		edu_id = $(ele).data('education-id');

		

	$('#edu_country').val(edu_data.country);

	$('#edu_univeristy').val(edu_data.university);

	$('#edu_degree').val(edu_data.degree);

	$('#edu_start_year').val(edu_data.start_year);

	$('#edu_end_year').val(edu_data.end_year);

	

	$('#save-education-btn').attr('onclick', 'saveEditEducation('+edu_id+')');

	$('#educationWrapperAll').hide();

	$('#educationForm').show();

}



function addNewEducation(){

	var $ = jQuery;

	$('#educationWrapperAll').hide();

	$('#educationForm').show();

	$('#save-education-btn').attr('onclick', 'saveEducation()');

}



function cancelEducation(){

	var $ = jQuery;

	$('#educationForm')[0].reset();

	$('#educationWrapperAll').show();

	$('#educationForm').hide();

}



function deleteEducation(edu_id){

	var $ = jQuery;

	if(edu_id != ''){

		$.ajax({

			url : '<?php echo base_url('dashboard/delete_education')?>',

			data: {edu_id : edu_id},

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['status'] == 1){

					$('#education_'+edu_id).remove();

				}

			}

		});

	}

	

}



function toggleExpEndYear(e){

	var $ = jQuery;

	var checked = $(e).prop('checked');

	if(checked){

		$('#exp_end_year_wrapper').hide();

	}else{

		$('#exp_end_year_wrapper').show();

	}

}





function saveExperience(){

	var $ = jQuery;

	var f = $('#experienceForm'),

		fdata = f.serialize(),

		exp_title = $('#exp_title').val(),

		exp_company = $('#exp_company').val(),

		exp_start_year = $('#exp_start_year').val(),

		exp_end_year = $('#exp_end_year').val(),

		submitform = true;

		

	if(exp_title == ''){

		$('#exp_titleError').html('Please enter title');

		submitform = false;

	}else{

		$('#exp_titleError').html('');

	}

	

	if(exp_company == ''){

		$('#exp_companyError').html('Please enter company');

		submitform = false;

	}else{

		$('#exp_companyError').html('');

	}

	

	

	if(exp_start_year == ''){

		$('#exp_start_yearError').html('Please choose start year');

		submitform = false;

	}else{

		$('#exp_start_yearError').html('');

	}

	

	var checked = $('input[name="currently_working"]').prop('checked');

	if(!checked){

		if(exp_end_year == ''){

			$('#exp_end_yearError').html('Please choose end year');

			submitform = false;

		}else{

			$('#exp_end_yearError').html('');

		}

	}

	

	

	if(submitform){

		$.ajax({

			url : '<?php echo base_url('dashboard/saveExperience')?>',

			data: fdata,

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['status'] == 1){

					f[0].reset();

					$('input[name="currently_working"]').change();

					addExperience(res['data'], res['experience_id']);

					$('#experienceWrapperAll').show();

					$('#experienceForm').hide();

				}

			}

		});

	}

	

}





function saveEditExperience(exp_id){

	var $ = jQuery;

	var f = $('#experienceForm'),

		fdata = f.serialize(),

		exp_title = $('#exp_title').val(),

		exp_company = $('#exp_company').val(),

		exp_start_year = $('#exp_start_year').val(),

		exp_end_year = $('#exp_end_year').val(),

		submitform = true;

		

	if(exp_title == ''){

		$('#exp_titleError').html('Please enter title');

		submitform = false;

	}else{

		$('#exp_titleError').html('');

	}

	

	if(exp_company == ''){

		$('#exp_companyError').html('Please enter company');

		submitform = false;

	}else{

		$('#exp_companyError').html('');

	}

	

	

	if(exp_start_year == ''){

		$('#exp_start_yearError').html('Please choose start year');

		submitform = false;

	}else{

		$('#exp_start_yearError').html('');

	}

	

	var checked = $('input[name="currently_working"]').prop('checked');

	if(!checked){

		if(exp_end_year == ''){

			$('#exp_end_yearError').html('Please choose end year');

			submitform = false;

		}else{

			$('#exp_end_yearError').html('');

		}

	}

	

	

	if(submitform){

		$.ajax({

			url : '<?php echo base_url('dashboard/editExperience')?>/'+exp_id,

			data: fdata,

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['status'] == 1){

					f[0].reset();

					$('input[name="currently_working"]').change();

					replaceExperience(res['data'], exp_id);

					$('#experienceWrapperAll').show();

					$('#experienceForm').hide();

				}

			}

		});

	}

	

}





function addExperience(data, exp_id){

	var $ = jQuery;

	var edu_data = $.parseJSON(data),

	end = (typeof edu_data.currently_working != 'undefined' && edu_data.currently_working == 'Y') ? 'Present' : edu_data.end_year;

	var html = '<div id="experience_'+exp_id+'"><h3>'+edu_data.title+' <a class="pull-right icon-round" data-experience-data=\''+data+'\' data-experience-id="'+exp_id+'" onclick="editExperience(this)" title="Edit"><i class="zmdi zmdi-edit"></i></a> <a class="pull-right icon-round" data-experience-id="'+exp_id+'" onclick="deleteExperience('+exp_id+')" title="Delete"><i class="zmdi zmdi-delete"></i></a></h3><p><b>'+edu_data.company+'</b> '+edu_data.start_year+'-'+end+' </p><p>'+edu_data.summary+'</p></div>';

	

	$('#experienceWrapper').append(html);

	

	$('#no_experience').remove();

}



function replaceExperience(data, exp_id){

	var $ = jQuery;

	var edu_data = $.parseJSON(data),

	end = (typeof edu_data.currently_working != 'undefined' && edu_data.currently_working == 'Y') ? 'Present' : edu_data.end_year;

	var html = '<div id="experience_'+exp_id+'"><h4>'+edu_data.title+' <a class="pull-right icon-round" data-experience-data=\''+data+'\' data-experience-id="'+exp_id+'" onclick="editExperience(this)" title="Edit"><i class="zmdi zmdi-edit"></i></a> <a class="pull-right icon-round" data-experience-id="'+exp_id+'" onclick="deleteExperience('+exp_id+')" title="Delete"><i class="zmdi zmdi-delete"></i></a></h4><p><b>'+edu_data.company+'</b> '+edu_data.start_year+'-'+end+' </p><p>'+edu_data.summary+'</p></div>';

	

	$('#experience_'+exp_id).replaceWith(html);

	

	$('#no_experience').remove();

}





function editExperience(ele){

	var $  = jQuery;

	var exp_data = $(ele).data('experience-data'),

		exp_id = $(ele).data('experience-id');

		

	$('#exp_title').val(exp_data.title);

	$('#exp_company').val(exp_data.company);

	$('#exp_start_year').val(exp_data.start_year);

	$('#exp_summary').val(exp_data.summary);

	

	if(exp_data.currently_working == 'Y'){

		$('input[name="currently_working"]').prop('checked', 'checked');

		$('input[name="currently_working"]').change();

	}else{

		$('#exp_end_year').val(exp_data.end_year);

	}

	

	$('#save-experience-btn').attr('onclick', 'saveEditExperience('+exp_id+')');

	$('#experienceWrapperAll').hide();

	$('#experienceForm').show();

}



function addNewExperience(){

	var $ = jQuery;

	$('#experienceWrapperAll').hide();

	$('#experienceForm').show();

	$('#save-experience-btn').attr('onclick', 'saveExperience()');

}



function cancelExperience(){

	var $ = jQuery;

	$('#experienceForm')[0].reset();

	$('#experienceWrapperAll').show();

	$('#experienceForm').hide();

}



function deleteExperience(exp_id){

	var $ = jQuery;

	if(exp_id != undefined && exp_id != ''){

		$.ajax({

			url : '<?php echo base_url('dashboard/delete_experience')?>',

			data: {exp_id : exp_id},

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res['status'] == 1){

					$('#experience_'+exp_id).remove();

				}

			}

		});

	}

	

}





</script> 
<script type="text/javascript">

	jQuery(document).ready(function($){

		$('.show_big').click(function(e){

			var img = $(this).attr('data-image');

			var dscr = $(this).find('p.port_dscr').text();

			var title =  $(this).find('h5.port_title').text();

			$('#port_big_img').attr('src' , img);

			$('#port_dscr').html(dscr);

			$('#portmyModalLabel').html(title);

		});

	});

</script> 
<script>



function save(){

	//var val = $(this).

}



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

				}

				else

				{

					jQuery("#allprojects").html('<b>You dont have any open projects to invite</b>');	

					jQuery("#sbmt").hide();	

				}

			}

		});

}

function hdd()

{

	var free_id=jQuery("#freelancer_id").val();

	var project_id=jQuery(".prjct").val();

	var page='clientdetails';

	window.location.href='<?php echo VPATH;?>invitetalents/invitefreelancer/'+free_id+'/'+project_id+'/'+'/'+page+'/';	

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

				}

				else

				{

					jQuery("#allprojects2").html('<b>You dont have any open projects to invite</b>');	

					jQuery("#sbmt2").hide();	

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

</script> 

<!-- Portfolio script--> 

<script type="text/javascript" src="<?php echo VPATH; ?>assets/js/ajaxfileupload.js"></script>
<?php 

$script_url=VPATH."dashboard/uploadportfolio/";

 ?>
<script>



function addFormPost(){ 

FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>dashboard/checkportfolioajax",'addport_frm');

}

   

 function movefile(evt){ 

       var n=document.getElementById('userfile').files[0];    

	

      // $("#loading").show();

        $.ajaxFileUpload({

            url:'<?php echo $script_url;?>',

            secureuri:false,

            fileElementId:'userfile',

            dataType: 'json',

            data:{name:n.name, id:$("#pid").val()},

            success: function (data){

                $("#pid").val(data.pid);

                $("#img_name").text("("+data.msg+")");

                $("#uploded_img").attr("src","<?php echo VPATH."assets/portfolio/"?>"+data.msg);

                

                

		//$("#loading").hide();

               // window.location.href="<?php echo VPATH;?>dashboard/editportfolio";                

            }

    });

     

  }    

	</script> 

<!--End Of portfolio script -->