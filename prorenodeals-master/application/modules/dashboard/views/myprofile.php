<style>
.icon-round{		
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


<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/chosen/chosen.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/chosen/chosen.jquery.min.js" type="text/javascript"></script>

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
					
				}else{
					$('#file_type_error').show();
					$('#file_type_error').html(res.error);
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
					
				}else{
					$('#bgfile_type_error').show();
					$('#bgfile_type_error').html(res.error);
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
<div class="parallax-banner-sm" style="background-image:url()">
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
<!-- profile background pic upload modal END --> 

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
<?php // $this->load->view('left_sidebar'); ?>
<section class="sec">
<div class="container">
<div class="row">    
    <aside class="col-lg-8 col-12">  
    <div class="card">
    <div class="card-header"><h4><i class="icon-feather-user site-text"></i> About <?php echo get_full_name($user_login);?> <a href="#" class="float-right" data-toggle="modal" data-target="#overviewModal"><i class="icon-feather-edit-3"></i></a></h4></div>
    	<div class="card-body">
      	            				
		<p><?php echo $overview;?></p> 
        </div>
    </div>
    
    <div class="listing"> 	        
        <article class="block panel panel-default hide"> 
        <div class="panel-heading">
        	<h4 class="block-title"><?php echo __('myprofile_work_experience','Work Experience'); ?>: <a href="javascript:void(0)" class="edit hidden" data-toggle="modal" data-target="#myModal2"><i class="zmdi zmdi-edit"></i></a></h4>
        </div>
        <div class="panel-body">
        <p><?php //echo $work_experience;?></p>
		
		<div id="experienceWrapperAll">
			<div id="experienceWrapper">
				<?php if(count($experiences) > 0){foreach($experiences as $k => $v){ ?>
				<div id="experience_<?php echo $v['experience_id'];?>">
					<h4><?php echo $v['title'];?>
					<a class="pull-right icon-round" data-experience-data='<?php echo htmlentities(json_encode($v), ENT_QUOTES);?>' data-experience-id="<?php echo $v['experience_id'];?>" onclick="editExperience(this)" title="<?php echo __('myprofile_edit','Edit'); ?>"><i class="zmdi zmdi-edit"></i></a> <a class="pull-right icon-round" data-experience-id="<?php echo $v['experience_id'];?>" onclick="deleteExperience(<?php echo $v['experience_id'];?>)" title="<?php echo __('myprofile_delete','Delete'); ?>"><i class="zmdi zmdi-delete"></i></a>
					</h4>
					<p><b><?php echo $v['company'];?></b> <?php echo $v['start_year'];?> - <?php echo $v['currently_working'] == 'Y' ? __('myprofile_present','Present') : $v['end_year'];?></p>
					<p><?php echo $v['summary'];?></p>
				</div>
				<?php } }else{ ?>
				<div id="no_experience"><p><b><?php echo __('myprofile_no_experience_added_yet','No experience added yet'); ?></b></p></div>
				<?php } ?>
				
			</div>
			<div class="btn-wrapper">
				<button type="button" class="btn btn-site" onclick="addNewExperience()"> <i class="fa fa-plus"></i> <?php echo __('myprofile_add_experience','Add Experience'); ?> </button>
			</div>
		</div>
		
		<form class="form" id="experienceForm" style="display:none;">
			  <div class="form-group">
				<label for="exp_title"><?php echo __('myprofile_title','Title'); ?></label>
				<input type="text" class="form-control" id="exp_title" name="title">
				<div class="error-msg13" id="exp_titleError"></div>
			 </div>
			  
			  <div class="form-group">
				<label for="exp_company"><?php echo __('myprofile_company','Company'); ?></label>
				<input type="text" class="form-control" id="exp_company" name="company">
				<div class="error-msg13" id="exp_companyError"></div>
			 </div>
			 
			
			   <div class="form-group">
				<label for="exp_start_year"><?php echo __('myprofile_start_year','Start Year'); ?></label>
				<select class="form-control" name="start_year" id="exp_start_year">
					<?php for($i=date('Y'); $i >= 1970; $i--){ ?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
					<?php } ?>
				</select>
				<div class="error-msg13" id="exp_start_yearError"></div>
			  </div>
			  <div class="form-group">
			  <div class="checkbox checkbox-inline">
				<input type="checkbox" name="currently_working" id="currently_working" class="magic-checkbox" value="Y" onchange="toggleExpEndYear(this);"> <label for="currently_working"><?php echo __('myprofile_currently_working_here','currently working here'); ?></label>
			  </div>
              </div>
  
			   <div class="form-group" id="exp_end_year_wrapper">
				<label for="exp_end_year"><?php echo __('myprofile_end_year','End Year'); ?></label>
				<select class="form-control" name="end_year" id="exp_end_year">
					<?php for($i=date('Y'); $i >= 1970; $i--){ ?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
					<?php } ?>
				</select>
				<div class="error-msg13" id="exp_end_yearError"></div>
			  </div>
			  
			  <div class="form-group">
				<label for="exp_summary"><?php echo __('myprofile_summery','Summary'); ?></label>
				<textarea class="form-control" name="summary" id="exp_summary"></textarea>
				<div class="error-msg13" id="exp_summaryError"></div>
			  </div>
			  
			  <div class="form-group">
				<button type="button" class="btn btn-site" onclick="saveExperience()" id="save-experience-btn"><?php echo __('myprofile_save','Save'); ?></button>&nbsp;
				<button type="button" class="btn btn-grey" onclick="cancelExperience()" id="cancel-education-btn"><?php echo __('myprofile_cancel','Cancel'); ?></button>
			  </div>			  			  
			  </form>
			  
		</div>  
        </article>
		
		<article class="block panel panel-default hide"> 
        <div class="panel-heading">
	        <h4 class="block-title"><?php echo __('myprofile_education','Education'); ?>: <a href="#" class="edit hidden" data-toggle="modal" data-target="#myModal3"><i class="zmdi zmdi-edit"></i></a></h4>
        </div>
        <div class="panel-body">
        <p><?php // echo $education;?></p>
		
		<div id="educationWrapperAll">
		<div id="educationWrapper">
		<?php if(count($educations) > 0){foreach($educations as $k => $v){ 
		$c = $this->auto_model->getFeild('Name', 'country', 'Code', $v['country']);
		$u = $this->auto_model->getFeild('university', 'university', 'university_id', $v['university']);
		?>
		<div id="education_<?php echo $v['education_id'];?>">
			<h4><?php echo $v['degree'];?> <a class="pull-right icon-round" data-education-data='<?php echo htmlentities(json_encode($v), ENT_QUOTES);?>' data-education-id="<?php echo $v['education_id'];?>" onclick="editEducation(this)" title="<?php echo __('myprofile_edit','Edit'); ?>"><i class="zmdi zmdi-edit"></i></a> <a class="pull-right icon-round" data-education-id="<?php echo $v['education_id'];?>" onclick="deleteEducation(<?php echo $v['education_id'];?>)" title="<?php echo __('myprofile_delete','Delete'); ?>"><i class="zmdi zmdi-delete"></i></a></h4><p><b><?php echo $u;?> , <?php echo $c;?></b> <?php echo $v['start_year'];?>-<?php echo $v['end_year'];?> </p>
		
		</div>
		<?php } }else{ ?>
		<div id="no_education"><p><b><?php echo __('myprofile_you_have_not_added_any_education_yet','You have not added any education yet.'); ?></b></p></div>
		<?php } ?>
		
		</div>
		<div class="btn-wrapper">
			<button type="button" class="btn btn-site" onclick="addNewEducation()"> <i class="fa fa-plus"></i> <?php echo __('myprofile_add_educaton','Add Education'); ?> </button>
		</div>
		</div>
		<form class="form form-horizontal" id="educationForm" style="display:none">
			  <div class="form-group">
				<label for="edu_country"><?php echo __('myprofile_country','Country') ?></label>
				<?php
				$country = $this->autoload_model->getCountry();
				?>
				<select name="country" class="form-control" id="edu_country">
					<option value=""><?php echo __('myprofile_choose_country','Choose country'); ?></option>
					<?php if(count($country) > 0){foreach($country as $k => $v){ ?>
					<option value="<?php echo $v['code'];?>"><?php echo $v['name'];?></option>
					<?php } } ?>
					
				</select>
				<div class="error-msg13" id="edu_countryError"></div>
              </div>
			  
			  <div class="form-group">

				<label for="edu_college"><?php echo __('myprofile_university_college','University/College'); ?></label>
				<select name="university" class="form-control" id="edu_univeristy">
					<option value=""><?php echo __('myprofile_choose_university','Choose university'); ?></option>
					<?php if(count($university) > 0){foreach($university as $k => $v){ ?>
					<option value="<?php echo $v['university_id'];?>"><?php echo $v['university'];?></option>
					<?php } } ?>
					
				</select>
				<div class="error-msg13" id="edu_univeristyError"></div>
			  </div>
			  
			  <div class="form-group">
				<label for="edu_degree"><?php echo __('myprofile_degree','Degree') ?></label>
				<input type="text" class="form-control" id="edu_degree" name="degree">
				<div class="error-msg13" id="edu_degreeError"></div>
			  </div>
			  <div class="row">
               <div class="col-sm-6 col-12">
               <div class="form-field">
				<label for="edu_start_year"><?php echo __('myprofile_start_year','Start Year') ?></label>
				<select class="form-control" name="start_year" id="edu_start_year">
					<?php for($i=date('Y'); $i >= 1970; $i--){ ?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
					<?php } ?>
				</select>
				<div class="error-msg13" id="edu_start_yearError"></div>
                </div>
               </div>
               <div class="col-sm-6 col-12">
               <div class="form-field">
				<label for="edu_end_year"><?php echo __('myprofile_end_year','End Year'); ?></label>
				<select class="form-control" name="end_year" id="edu_end_year">
					<?php for($i=date('Y'); $i >= 1970; $i--){ ?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
					<?php } ?>
				</select>
				<div class="error-msg13" id="edu_end_yearError"></div>
                </div>
			  </div>
			  </div>			  			   
			  
			  <div class="form-group">
				<button type="button" class="btn btn-site" onclick="saveEducation()" id="save-education-btn"><?php echo __('myprofile_save','Save'); ?></button>&nbsp;
				<button type="button" class="btn btn-grey" onclick="cancelEducation()" id="cancel-education-btn"><?php echo __('myprofile_cancel','Cancel'); ?></button>		
              </div>			  
			  
			  </form>
		</div>
        </article>
        <div class="card">
        <div class="card-header"><h4><i class="icon-feather-percent site-text"></i> Skills <a href="javascript:void(0)" class="float-right" onclick="$('#editSkillForm').show(); $('#skill_list').hide(); "><i class="icon-feather-edit-3"></i></a></h4></div>
            <div class="card-body">
            <div id="skill_list">
			<ul class="skills mb-0">                    
			<?php 
			  if(count($user_skill)){
				foreach($user_skill as $k => $v){
			?>
			   <li><span>
				  <?php echo $v['skill'];?>
			  </span> </li>
			<?php
					 
			  } } 
			  else{ 
			?>
				<li><span><?php echo __('myprofile_skill_not_set_yet','Skill Not Set Yet'); ?></span> </li>
			<?php  
			  }
		   ?>
			</ul>
			</div>
            <div id="edit_skill">
				<form id="editSkillForm" style="display:none;">
					<?php 
					$selected_skills_array = array();
					$skill = $this->db->limit(100)->get('skills')->result_array();
					if($user_skill){
						foreach($user_skill as $k => $v){
							$selected_skills_array[] = $v['skill_id'];
						}
					}
					?>
					<select class="form-control inputtag" name="user_skills[]" multiple>
					<?php if(count($skill) > 0){foreach($skill as $k => $v){ ?>
						<option value="<?php echo $v['id']; ?>" <?php echo in_array($v['id'], $selected_skills_array) ? 'selected="selected"' : '';?>><?php echo $v['skill_name']; ?></option>
					<?php } } ?>
					</select>
					<div class="clearfix"></div>
					<br/>
					 <div class="form-group">
					  <div>
						<button type="button" class="btn btn-site" onclick="saveUserSkill();"><?php echo __('myprofile_save','Save'); ?></button>&nbsp;
						<button type="button" class="btn btn-grey" onclick="$('#editSkillForm').hide(); $('#skill_list').show(); "><?php echo __('myprofile_cancel','Cancel'); ?></button>
					  </div>
				  </div>
			  </form>
			</div>
            </div>
        </div>
        
        
        <article class="block panel panel-default hide"> 
        <div class="panel-heading">
	        <h4 class="block-title"><?php echo __('myprofile_certificates','Certificates'); ?> <a href="#" class="edit hidden" data-toggle="modal" data-target="#myModal4"><i class="zmdi zmdi-edit"></i></a> </h4>
        </div>
        <div class="panel-body">
			<div id="certificationWrapperAll">
			<div id="certificationWrapper">
				<?php if(count($certificates) > 0){foreach($certificates as $k => $v){ ?>
				<div id="certificate_<?php echo $v['certificate_id'];?>">
				<h4><?php echo $v['title'];?> ( <?php echo $v['duration'];?> <?php echo __('myprofile_month','month'); ?>)
				<a class="pull-right icon-round" title="<?php echo __('myprofile_edit','Edit'); ?>" data-certificate-id="<?php echo $v['certificate_id'];?>" data-certificate-data='<?php echo htmlentities(json_encode($v), ENT_QUOTES);?>' onclick="editCertification(this)"><i class="zmdi zmdi-edit"></i></a>
				
				<a class="pull-right icon-round" title="<?php echo __('myprofile_delete','Delete'); ?>" data-certificate-id="<?php echo $v['certificate_id'];?>" onclick="deleteCertificate(<?php echo $v['certificate_id'];?>)"><i class="zmdi zmdi-delete"></i></a>
				</h4>
				<p><?php echo $v['institute']; ?></p>
				</div>
				<?php } } ?>
				
			</div>
			<div class="btn-wrapper">
				<button type="button" class="btn btn-site" onclick="addNewCertification()"> <i class="fa fa-plus"></i> <?php echo __('Add Certification','Add Certification'); ?> </button>
			</div>
		</div>
		
		<form class="form" id="certificationForm" style="display:none;">
			  <div class="form-group">
				<label for="exp_title"><?php echo __('myprofile_title','Title'); ?></label>
				<input type="text" class="form-control" id="cer_title" name="title">
				<div class="error-msg13" id="cer_titleError"></div>
			 </div>
			  
			  <div class="form-group">
				<label for="exp_title"><?php echo __('myprofile_institute','Institute'); ?></label>
				<input type="text" class="form-control" id="cer_institute" name="institute">
				<div class="error-msg13" id="cer_instituteError"></div>
			 </div>
			 
			   <div class="form-group">
				<label for="exp_start_year"><?php echo __('myprofile_duration_in_month','Duration (in month)'); ?></label>
				<select class="form-control" name="duration" id="cer_duration">
					<?php for($i=6; $i<= 24; $i=$i+6){ ?>
					<option value="<?php echo $i;?>"><?php echo $i;?> <?php echo __('myprofile_month','month'); ?></option>
					<?php } ?>
				</select>
				<div class="error-msg13" id="cer_durationError"></div>
			  </div>
			  
			  <div class="form-group">
				<button type="button" class="btn btn-site" onclick="saveCertification()" id="save-certificate-btn"><?php echo __('myprofile_save','Save'); ?></button>&nbsp;
				<button type="button" class="btn btn-grey" onclick="cancelCertification()" id="cancel-certificate-btn"><?php echo __('myprofile_cancel','Cancel'); ?></button>
			  </div>
			  
			  </form>
		</div>
        </article>
        
        <article class="card"> 
        <div class="card-header">
        	<h4><i class="icon-feather-image site-text"></i> <?php echo __('myprofile_portfolio','Portfolio'); ?> <a href="javascript:void(0)" data-toggle="modal" data-target="#addPortfolioModal" class="float-right"><i class="icon-feather-plus"></i></a> <a href="<?php echo VPATH;?>dashboard/editportfolio" class="float-right" style="margin-left:10px; margin-right:10px"><i class="icon-feather-settings"></i></a></h4>
		</div>
        <div class="card-body">
		<?php if(count($user_portfolio)>0){ ?>
		
        <div class="portfolio row row-10" id="masonryG">
		<?php   
			foreach($user_portfolio as $key=>$val){
			$extension = end(explode(".", $val['thumb_img'])); 
			if($extension!="zip" && $extension!="doc" && $extension!="docx" && $extension!="pdf" && $extension!="xls" && $extension!="xlsx" && $extension!="txt"){  
			$portfolio_image = NO_IMAGE_PORTFOLIO;
			if(file_exists('./assets/portfolio/'.$val['thumb_img'])){
				$portfolio_image = VPATH."assets/portfolio/".$val['thumb_img'];
			}
		?>
        
		 <article class="col-sm-4 col-12">
        	<div class="itm">
        	<img src="<?php echo $portfolio_image;?>" alt="" class="img-fluid">
			
			 <a href="#" data-toggle="modal" data-target="#portfolioModal" class="show_big" data-image="<?php echo $portfolio_image;?>">
            <div class="hover_itm">
            <h5 class="port_title"><?php echo $val['title'];?></h5>
            <p class="port_dscr" style="max-height:80px; overflow:hidden"><?php echo $val['description'];?>.</p>
            <!--<a href="#" class="btn btn-sm" style="display:none;">Read More</a>-->
            </div>
			</a>			
            </div>
            </article>
        
			<?php } } ?>
        </div>

		<?php } ?>        
        </div>
        </article>
		
		
		<article class="card"> 
        <div class="card-header">
        	<h4><i class="icon-feather-file-text site-text"></i> <?php echo __('myprofile_document','Documents and Licenses'); ?></h4></div>
    		<div class="card-body">
        	<div data-ajaxify="<?php echo base_url('dashboard/load_ajax?page=user_document&user='.$user_id);?>"></div>
            </div>    
		</article>
		
		<article class="block panel panel-default hidden"> 
        <div class="panel-heading">
	        <h4 class="block-title"><?php echo __('myprofile_other_portfolio','Other Portfolio'); ?></h4>
        </div>
        <div class="panel-body">
		<?php if(count($user_portfolio)>0){ ?>
		
        <ul>
		<?php   
			foreach($user_portfolio as $key=>$val){
			$extension = end(explode(".", $val['thumb_img'])); 
			if($extension=="zip" && $extension=="doc" && $extension=="docx" && $extension=="pdf" && $extension=="xls" && $extension=="xlsx" && $extension=="txt"){  
		?>
		 <li><a style="cursor: pointer;" href="<?php echo VPATH."assets/portfolio/".$val['thumb_img'];?>" target="_blank" class="skilslinks"><?php echo $val['title'];?></a> <br>
			<span><?php echo $val['description'];?></span>
		</li> 
			<?php } } ?>
        </ul>
		<?php } ?>
        </div>
        </article>
		
 </div>
       
       <article class="card compact-list-layout"> 
        <div class="card-header">
        <h4><i class="icon-feather-star site-text"></i> <?php echo __('myprofile_reviews_and_ratings','Reviews & Ratings'); ?></h4></div>
		

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
        <div class="job-listing-company-logo">
              	<img src="<?php echo $user_logo;?>" alt="" class="rounded-circle" />   
              </div>
              <div class="job-listing-description">       
        <h4><?php
          echo $this->auto_model->getFeild('title','projects','project_id',$val['project_id']);      
        ?></h4>
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
       
        <div class="star-rating" data-rating="<?php echo round($avg_rating, 1); ?>"></div>
        <p><a href="javascript:void(0)" class="seeAll">See all skills rating <i class="zmdi zmdi-chevron-down"></i></a></p>
        <div class="ratingtext" style="display:none">
        
	   
	   <p><span>Skills: </span>
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['skills']){
				echo ' <i class="zmdi zmdi-star"></i>';
			}else{
				echo ' <i class="zmdi zmdi-star-outline"></i>';
			}
		}
		?>
	   </p>
	   
	    <p><span>Quality of works: </span>
		<?php
		for($i=1; $i<=5; $i++){
			if($i <= $val['quality_of_work']){
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
        <div class="ratingreview">
        	<p class="text-muted"><?php echo __('myprofile_no_review_yet','No Review Yet.'); ?></p>
        </div>
            <?php
        }
         
        ?>
        </article>		
    
    </aside>
    <aside class="col-lg-4 col-12">		
    	<div class="profileEdit">                      
     <?php  if($user_id==$user_login) { ?>              
        <a href="<?php echo base_url('findjob')?>" class="btn btn-site btn-lg btn-block hidden"><i class="zmdi zmdi-case"></i> <?php echo __('myprofile_find_job','Find Job'); ?></a>
        <a href="#" class="btn btn-success btn-lg btn-block hidden" data-toggle="modal" data-target="#inviteModal"><i class="zmdi zmdi-cocktail"></i> <?php echo __('myprofile_emp_invite','Invite'); ?></a>        
        <?php }else{ ?>
         <a href="#" class="btn btn-success btn-lg btn-block hidden"><i class="zmdi zmdi-case"></i> <?php echo __('myprofile_emp_post_job','Post Job'); ?> </a>
        <a href="#" class="btn btn-site btn-lg btn-block hidden"><i class="zmdi zmdi-account"></i> <?php echo __('myprofile_emp_hire_me','Hire Me'); ?> </a>
        <?php  } ?>
        
        <div class="spacer-60 visible-under-992"></div>
        <article class="card">
            <div class="card-header">
                <h4><i class="icon-feather-shield site-text"></i> <?php echo __('dashboard_profileprofessional_verifications','Verifications'); ?></h4>
            </div>
        <div class="card-body text-center"> 
        
        <li class="hidden"><i class="zmdi zmdi-facebook-box"></i>
     Facebook Connected <span class="pull-right"><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="Verified" style="color:#0c0;line-height:20px"></i></span></li>
        <li class="d-none"><i class="zmdi zmdi-smartphone"></i> Payment Verified
          <?php if($u_row['payment_verified'] == 'Y'){ echo '<span>Verified</span>'; }else{ ?>
          <button class="btn btn-sm btn-site pull-right"><?php echo __('myprofile_verify','Verify'); ?></button>
          <?php } ?>
        </li>
        <li>
        <i class="zmdi zmdi-email"></i> <?php echo __('myprofile_email_verified','Email Verified'); ?>
          <?php if($u_row['email_verified'] == 'Y'){ echo '<span><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="Verified" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
          <button class="btn btn-sm btn-site" onclick="verify('email')"><?php echo __('myprofile_verify','Verify'); ?></button>
          <?php } ?>
        </li>
        <li class="d-none">
    <i class="zmdi zmdi-smartphone"></i> <?php echo __('myprofile_phone_verified','Phone Verified'); ?>
          <?php if($u_row['phone_verified'] == 'Y'){ echo '<span><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="Verified" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
          <button class="btn btn-sm btn-site" onclick="verify('phone')"><?php echo __('myprofile_verify','Verify'); ?></button>
          <?php } ?>
        </li>
      </div>
      </article>              
        
      </div>

	<div class="panel panel-default hidden">
        <div class="panel-heading">
            <h4><?php echo __('myprofile_certifications','Certifications'); ?></h4>
        </div>
        <div class="panel-body">
            <a class="btn btn-site btn-block"><?php echo __('myprofile_get_certificate','Get Certified'); ?></a>
            <br>
            <p><?php echo __('myprofile_you_do_not_have_any_certifications','You do not have any certifications.'); ?></p>
        </div>
    </div>
    
    <div class="panel panel-default" hidden>
        <div class="panel-heading">
            <h4><?php echo __('myprofile_my_top_skills','My Top Skills'); ?></h4>
        </div>
        <div class="panel-body" style="padding:0; margin:-1px 0 0">
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
				<li class="list-group-item"><?php echo __('myprofile_no_skills_found','No Skills found'); ?></li>
				<?php } ?>
            </ul>
        </div>
    </div>
	</aside>   
</div>

</div>
</section>
<script src="<?=JS?>masonry.min.js"></script>
<script>
  $(function(){
    var $container = $('#masonryG');
    $container.imagesLoaded( function(){
      $container.masonry({
        itemSelector : '.col-sm-4'
      });
    });
  
  });
</script>

<!-- Content End -->
<!-- Skill Modal -->
<div class="modal fade" id="skillModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title"><?php echo __('myprofile_select_skills','Select Skills'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
       
       <div class="row-10">
       	<aside class="col-sm-9 col-12">
        	<div class="input-group" style="margin-bottom:10px">
            	<span class="input-group-addon"><i class="fa fa-search"></i></span>
        		<input type="text" class="form-control" placeholder="<?php echo __('myprofile_search_your_skills','Search your skills'); ?>" onkeyup="uskill.searchSkill(this.value)"/>
                
            </div>
			
			<div class="parent_skill_wrapper">
				 <ul class="parent_skill">
				  <?php foreach ($parent_skill as $row){ ?>
				  
						<li><a href="javacript:void(0)" data-parent-id="<?php echo !empty($row['id']) ? $row['id'] : ''; ?>" data-name="<?php echo !empty($row['skill_name']) ?$row['skill_name'] : 'N/A'; ?>" onclick="uskill.getChieldSkill(this,<?php echo !empty($row['id']) ? $row['id'] : ''; ?>)"><?php echo !empty($row['skill_name']) ?$row['skill_name'] : 'N/A'; ?></a></li>
						
					<?php } ?>
					<div class="clearfix"></div>
			   </ul>
			</div>
			
			<div class="child_skill_wrapper" style="display:none;">
				<a href="javascript:void(0)" onclick="uskill.hideChildPanel(); uskill.showParentPanel();"><i class="fa fa-arrow-left"></i> <?php __('myprofile_back','Back'); ?></a>
				<h4 id="parent_skill_name"><?php echo __('myprofile_accountants_and_consultents','Accountants &amp; Consultants'); ?></h4>
				<div id="child_skill_list_wrapper">
			  
				</div>
			</div>
        </aside>
        <aside class="col-sm-3 col-12">        	
        	<h4><?php echo __('myprofile_selected_skills','Selected Skills'); ?></h4>
            <p><?php echo __('myprofile_you_can_see_your_selected_skills_here','You can see your selected skills here'); ?></p>
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
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('myprofile_cancel','Cancel'); ?></button>
        <button type="button" class="btn btn-info" onclick="uskill.submitUserSkills()"><?php echo __('myprofile_save','Save'); ?></button>
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
      <h5 class="modal-title"><?php echo __('myprofile_add_portfolio','Add Portfolio'); ?></h5>
        <button type="button" class="close" onclick="$('#addPortfolioModal').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
		<div class="modal-body">
    <div class="success alert-success alert" style="display:none"><?php echo __('myprofile_your_message_has_been_sent_successfully','Your message has been sent successfully.'); ?></div>    
    <span id="agree_termsError" class="error-msg2" style="display:none"></span>
        
   
    
	<input type="hidden" readonly="readonly" class="form-control"  value="" name="pid" id="pid" />
    <div class="form-group">
    	<label><?php echo __('myprofile_title','Title'); ?> : </label>
        <input type="text" class="form-control" size="30" value="" name="title" id="title" tooltipText="Enter Title" /> 
		
    <span id="titleError" class="error-msg2"></span>
    </div>
    <div class="form-group">
    <label><?php echo __('myprofile_description','Description'); ?> :</label>
	<textarea class="form-control" name="description" id="description" rows="3" style="min-width:56%" tooltipText="Enter Description" ></textarea>
    <span id="descriptionError" class="error-msg2"></span>
    </div>
    
    <div class="form-group">
        <label><?php echo __('myprofile_tags','Tags'); ?></label>
        <input type="text" class="form-control" size="30" name="tags"  id="tags" value="" tooltipText="Enter Tags" /> 
        <span id="tagsError" class="error-msg2"></span>
    </div>
    
    <div class="form-group">
        <label><?php echo __('myprofile_url','URL'); ?></label>
        <input type="text" class="form-control" size="30" name="url" id="url"  value="" tooltipText="Enter URL" />  
        <span id="urlError" class="error-msg2"></span>        
    </div>
    
    <div class="form-group">
    <label><?php echo __('myprofile_portfolio','Portfolio'); ?> :</label>
    <div class="clearfix"></div>
    <img id="uploded_img" alt="" /> 
    <span id="img_name"></span>
    <span id="userfileError" class="error" style="color:red;"></span>
	<img id="loading" src="<?php echo VPATH;?>assets/images/loading.gif" style="display:none;margin:10px;">
    <span id="original_imgError" class="error-msg2"></span>
    <div class="masg2">        
    <div class="input-group" style="margin-bottom:8px">
		<input type="hidden" name="original_img" value="" id="original_img_name"/>
		<input type="hidden" name="thumb_img" value="" id="thumb_img_name"/>
        <label class="input-group-prepend">
           <!-- <span class="btn btn-grey">
                Browse&hellip; <input type="file" class="form-control" size="30" name="userfile" id="userfile" onchange="movefile(this)" style="display: none;" multiple>
            </span>-->
			 <span class="btn btn-outline-success">
                <?php echo __('myprofile_browse','Browse'); ?>&hellip; <input type="file" class="form-control" size="30" name="userfile" onchange="dashboard.uploadPortfolioFile(this)" style="display: none;">
            </span>
        </label>
        <input type="text" class="form-control" readonly>
    </div>       
       
    </div>
    
    <span style="color:red;float:left;width:100%;">
	jpg, png , and jpeg files are allowed</span>
 
    </div>                
    </div>
      
     
     <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-info" id="submit-check" onclick="addFormPost()">Save</button>
      </div>-->
	   <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="$('#addPortfolioModal').modal('hide');"><?php echo __('myprofile_cancel','Cancel'); ?></button>
        <button type="submit" class="btn btn-site"><?php echo __('myprofile_save','Save'); ?></button>
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
      <h5 class="modal-title"><?php echo __('myprofile_change_profile_picture','Change Profile Picture'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" onclick="$('#profileModal').modal('hide')"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
		  <div style="width: 100%;">
    
			  <form id="profile_pic_upload_form">
				<div class="file_upload_bx">
					<input type="file" id="profile_pic_file" onchange="pf.upload(this);"/>
                    <i class="icon-feather-camera"></i>
				</div>
				<input id="profile_pic_file_name" type="hidden"/>
				<p class="error center" style="display:none; color:#f00" id="file_type_error"><?php echo __('myprofile_invalid_files_type','Invalid file type'); ?></p>
				<div class="progress" id="profile_pic_progress" style="display:none;">
					  
					   <div class="progress-bar determinate" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
				  </div>
			  </form>
			  <div id="crop_image_wrapper" style="display:none;">
				<img id="profile_pic_crop" style="max-width: 100%;"/>
			  </div>
			</div>
      </div>
    <div class="modal-footer" id="p_m_footer" style="display:none;">
      <a href="javascript:void(0);" class="btn btn-site" id="crop_image_btn" onclick="pf.cropImage();"><?php echo __('myprofile_save','Save'); ?></a>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="coverModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title"><?php echo __('myprofile_change_cover_photo','Change Cover Photo'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" onclick="$('#coverModal').modal('hide')"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
		<div style="width: 100%;">
		  <form id="bg_pic_upload_form">
		   <div class="file_upload_bx">
				<input type="file" onchange="pf.uploadBg(this);"/>
				<input id="bg_pic_file_name" type="hidden"/>
				<i class="icon-feather-camera"></i>
			</div>
			<p class="error center" style="display:none" id="bgfile_type_error"><?php echo __('myprofile_invalid_files_type','Invalid file type'); ?></p>
			  <div class="progress" id="profile_bg_progress" style="display:none;">
				  <div class="progress-bar determinate" role="progressbar" aria-valuemin="0" aria-valuemax="100">
				  </div>
				</div>
			  
		  </form>
		  <div id="bg_crop_image_wrapper" style="display:none;">
			<img id="bg_pic_crop" style="max-width: 100%;"/>
		  </div>
		</div>
      </div>
     <div class="modal-footer" id="pb_m_footer" style="display:none;">
      <a href="javascript:void(0);" class="btn btn-site" onclick="pf.cropBgImage();"><?php echo __('myprofile_save','Save'); ?></a>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Send a private message</h5>
        <button type="button" class="close" data-dismiss="modal" onclick="$('#inviteModal').modal('hide')"><span aria-hidden="true">&times;</span></button>
        
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
            <div class="input-group">
              <span class="input-group-addon">₹</span>
              <input type="number" class="form-control" value="250" style="padding-right:0" />
              <span class="input-group-addon" style="padding:0; background:none"><select style="height:32px; border:none; padding:0 6px"><option>INR</option><option>EUR</option><option>USD</option></select></span>
            </div>
            </div>
            <div class="col-sm-5 col-12">
            <div class="input-group"> 	
            <input type="number" class="form-control" value="12" style="padding-right:0" />
            <span class="input-group-addon">hr/week</span>
            </div>
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

<div class="modal fade" id="overviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<form action="" method="post">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title"><?php echo __('myprofile_overview','Overviews'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" onclick="$('#overviewModal').modal('hide')"><span aria-hidden="true">&times;</span></button>
        
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
      <h5 class="modal-title"><?php echo __('myprofile_work_experience','Work experience'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" onclick="$('#myModal2').modal('hide')"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
       <textarea name="work_experience" class="form-control"><?php echo $work_experience;?></textarea>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#myModal2').modal('hide');"><?php echo __('myprofile_emp_close','Close'); ?></button>
        <button type="submit"  class="btn btn-site"><?php echo __('myprofile_emp_save','Save'); ?></button>
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
        <button type="button" class="close" data-dismiss="modal" onclick="$('#myModal3').modal('hide')"><span aria-hidden="true">&times;</span></button>
        
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
        <button type="button" class="close" data-dismiss="modal" onclick="$('#myModal4').modal('hide')"><span aria-hidden="true">&times;</span></button>
        
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
      <h5 class="modal-title"><?php //echo $val['title'];?></h5>
        <button type="button" onclick="jQuery('#portfolioModal').modal('hide');" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-8 col-12">
                <img src="<?php echo ASSETS;?>portfolio/Hydrangeas.jpg" alt="" class="img-fluid" id="port_big_img" style="width:100%;">
            </div>    
            <div class="col-sm-4 col-12">
            <div class="profile_pic pic-sm">
              <span>
				<img alt="" src="<?php echo get_user_logo($user_login);  ?>"  class="img-circle">
                </span>
            </div>
        	<div class="pull-left">
				<?php
				$user_city = get_user_city($user_login);
				?>
            	<h4><?php echo get_full_name($user_login);?></h4>
                <p><?php echo $user_city; ?></p>      
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
      <div class="modal-footer" style="text-align:left;">       
		
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog modal-sm">     
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title"><?php echo __('myprofile_verification','Verification'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="jQuery('#verifyModal').modal('hide');">&times;</button>
        
      </div>
      <div class="modal-body">
        <div id="processing">
          <p class="text-center"><?php echo __('myprofile_processing','Processing...'); ?>...</p>
        </div>
        <div id="email_verification_section" class="verifySection">
          <p><?php echo __('myprofile_click_here','click here'); ?><b><?php echo $user[0]->email; ?></b>. <span class="hidden"><?php echo __('myprofile_if_this_is_not_your_email_then','If this is not your email then'); ?> <a href="#"><?php echo __('myprofile_click_here','click here'); ?></a> <?php echo __('myprofile_to_change_your_email_address','to change your email address'); ?></span> </p>
        </div>
        <div id="phone_verification_section" class="verifySection">
          <form id="phone_verify_form" class="verifySection">
            <input type="text" id="phone_no" value="" placeholder="Enter 10 digit phone/mobile number" class="form-control"/>
            <span id="phoneError" class="rerror"></span>
            
            <button type="button" class="btn btn-site btn-block" onclick="verify_phone();" style="margin-top:15px"><?php echo __('myprofile_send_verification_code','Send Verification Code'); ?></button>
          </form>
          
          <form id="phone_code_verify_form" class="verifySection">
            <p><?php echo __('myprofile_send_verification_code_into_number_text','A verification code has sent to your phone/mobile number . Please enter the code to verify your phone/mobile.'); ?> </p>
            <input type="text" id="phone_ver_code" name="phone_ver_code" value="" placeholder="<?php echo __('myprofile_enter_the_verification_code','Enter the verification code'); ?>" class="form-control"/>
            <input type="hidden" id="phone_num" name="phone_num"/>
            <span id="phoneCodeError" class="rerror"></span>
            <button type="button" class="btn btn-success" onclick="verify_phone_code();"><?php echo __('myprofile_verify','Verify'); ?></button>
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
      <h5 class="modal-title"><?php echo __('myprofile_edit_hour','Edit hour'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" onclick="$('#hourly_rateModal').modal('hide');">&times;</button>
        
      </div>
      <div class="modal-body">
          <div class="form-group">
             <label><?php echo __('myprofile_hour_per_week','Hour/week'); ?>:</label>
             <input type="number" name="available_week" class="form-control" value="<?php echo !(empty($available_hr)) ? number_format($available_hr) : '' ; ?>" min="1" max="168"/>
		  </div>    			
			<label><?php echo __('myprofile_hourly_rate','Hourly rate'); ?>:</label>
			<div class="input-group">
			
			  <span class="input-group-addon" id="basic-addon1"><?php echo CURRENCY;?></span>
			  <input type="text" placeholder="Hourly rate" aria-label="hourlyrate" aria-describedby="basic-addon1" name="hourly_rate" class="form-control" value="<?php echo !(empty($hourly_rate)) ? number_format($hourly_rate, 2) : '' ; ?>">
			</div>
			
			<br/>
		  <button type="submit" class="btn btn-site btn-block" name="submit" value="edit_hour"><?php echo __('dashboard_submit','Submit'); ?></button>	          
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
		$(form).find('[type="submit"]').attr('disabled', 'disabled');
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
				$(form).find('[type="submit"]').removeAttr('disabled');
			}
		});
		
	};
	
	ret.uploadPortfolioFile = function(ele){
		var file = $(ele)[0].files[0];
		var allowed_file_types = ["image/jpg", "image/jpeg", "image/png"];
		if(allowed_file_types.indexOf(file.type) == -1){
			$('#userfileError').html('<p>The filetype you are attempting to upload is not allowed.</p>');
			return;
		}else{
			$('#userfileError').html('');
		}
		
		if(file){
			$('.error').empty();
			var fdata = new FormData();
			fdata.append('userfile', file);
			$('#loading').show();
			$.ajax({
				url : '<?php echo base_url('dashboard/updatePortfolioFile')?>',
				data: fdata,
				type: 'POST',
				dataType: 'json',
				contentType: false,
				processData: false,
				success: function(res){
					$('#loading').hide();
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
			$('#phoneError').html('Please enter a valid phone number');
		}else if($('#phone_no').val().trim().length !=  10){
			$('#phoneError').html('Please enter a valid phone number');
		}else if(isNaN($('#phone_no').val().trim())){
			$('#phoneError').html('Please enter a valid phone number');
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
						$('#phone_verification_status_section').html('<p>Invalid Code <button onclick="verify(\'phone\')" class="btn btn-primary">Try Again</button></p>');
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
		$('#exp_titleError').html('<?php echo __('myprofile_Please_enter_title','Please enter title'); ?>');
		submitform = false;
	}else{
		$('#exp_titleError').html('');
	}
	
	if(exp_company == ''){
		$('#exp_companyError').html('<?php echo __('myprofile_Please_enter_company','Please enter company'); ?>');
		submitform = false;
	}else{
		$('#exp_companyError').html('');
	}
	
	
	if(exp_start_year == ''){
		$('#exp_start_yearError').html('<?php echo __('myprofile_Please_choose_start_year','Please choose start year'); ?>');
		submitform = false;
	}else{
		$('#exp_start_yearError').html('');
	}
	
	var checked = $('input[name="currently_working"]').prop('checked');
	if(!checked){
		if(exp_end_year == ''){
			$('#exp_end_yearError').html('<?php echo __('myprofile_Please_choose_end_year','Please choose end year'); ?>');
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
		$('#exp_titleError').html('<?php echo __('myprofile_Please_enter_title','Please enter title'); ?>');
		submitform = false;
	}else{
		$('#exp_titleError').html('');
	}
	
	if(exp_company == ''){
		$('#exp_companyError').html('<?php echo __('myprofile_Please_enter_company','Please enter company'); ?>');
		submitform = false;
	}else{
		$('#exp_companyError').html('');
	}
	
	
	if(exp_start_year == ''){
		$('#exp_start_yearError').html('<?php echo __('myprofile_Please_choose_start_year','Please choose start year'); ?>');
		submitform = false;
	}else{
		$('#exp_start_yearError').html('');
	}
	
	var checked = $('input[name="currently_working"]').prop('checked');
	if(!checked){
		if(exp_end_year == ''){
			$('#exp_end_yearError').html('<?php echo __('myprofile_Please_choose_end_year','Please choose end year'); ?>');
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
			var portfolio_modal = $('#portfolioModal');
			var img = $(this).attr('data-image');
			var dscr = $(this).find('p.port_dscr').text();
			var title =  $(this).find('h5.port_title').text();
			portfolio_modal.find('#port_big_img').attr('src' , img);
			portfolio_modal.find('#port_dscr').html(dscr);
			portfolio_modal.find('.modal-title').html(title);
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


<script>
	$(document).ready(function(){
		$('.inputtag').chosen({width: "100%"});
	});
	
	function saveUserSkill(){
		var f = $('#editSkillForm').serialize();
		$.ajax({
			url : '<?php echo base_url('dashboard/update_skill_ajax_new')?>',
			type : 'POST',
			data : f,
			dataType : 'JSON',
			success : function(data){
				var html  = '';
				if(data.status == 1){
					
					if(data.selected_skill.length > 0){
						for(var i in data.selected_skill){
							var skill_url = '<?php echo base_url('findtalents')?>?skills[]='+data.selected_skill[i].id;
							html += '<li><a href="javascript:void(0)">'+data.selected_skill[i].skill_name+'</a></li>';
						}
					}
					
					$('#skill_list').find('ul.skills').html(html);
					$('#editSkillForm').hide(); 
					$('#skill_list').show(); 
				}
			}
		});
		
	}
</script>