<style>
.icon-round{		
	margin-left: 10px;
}
.panel-body .list-group {
	margin-bottom:0
}
.panel-body .list-group-item {
    border-left: none;
	border-right:none
}
.mobile-menu {
	display:none
}
@media (min-width: 992px) {
.modal-sm {
    width: 400px;
}
}
</style>
<script src="<?=JS?>mycustom.js"></script>
<script src="<?=JS?>jquery.lightbox.min.js"></script>
<?php
if($rating[0]['num'] > 0){
	$avg_rating=$rating[0]['avg']/$rating[0]['num'];
}else{
	$avg_rating=0;
}
$bg_pic= $this->auto_model->getFeild("profile_bg_pic","user","user_id",$user_id);
$bg_full_path = ASSETS.'images/coverphoto.jpg';
if(!empty($bg_pic)){
	if(file_exists('assets/uploaded/bgcropped_'.$bg_pic)){
		$bg_full_path = ASSETS.'uploaded/bgcropped_'.$bg_pic;
	}else if(file_exists('assets/uploaded/'.$bg_pic)){
		$bg_full_path = ASSETS.'uploaded/'.$bg_pic;
	}
	
}
?>
<?php
$user=$this->session->userdata('user');
?>
<div class="single-page-header freelancer-header">
<div class="container">
<div class="single-page-header-inner">
    <div class="left-side">
        <div class="header-image freelancer-avatar">
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
        </div>
        <div class="header-details">
            <h3><?php echo get_full_name($user_id);?> <span><?php echo $slogan;?></span></h3>
            <div class="star-rating" data-rating="<?php echo get_user_rating($user_id); ?>"></div>
            <ul>                
                <li><i class="icon-feather-map-pin"></i> <?php echo get_user_city($user_id); ?></li>
				<?php if($verify=='Y'){ ?>
                <li><div class="verified-badge-with-title" title="<?php echo __('myprofile_emp_approved','APPROVED'); ?>"> Verified</div></li>
                <?php }  ?>
            </ul>
        </div>
    </div>
    <div class="right-side">
    <?php
	 if($this->session->userdata('user')){
	 $userid=$this->session->userdata('user');
	 $user_login=$userid[0]->user_id;
	 if($user_id!=$user_login && $account_type == 'F') {
	?>
     <a href="#" onclick="javascript:void(0)" data-target="#inviteModal" data-toggle="modal" class="btn btn-site"><i class="zmdi zmdi-account"></i> Invite</a><br />
      <a href="javascript:void(0)" class="btn btn-site" data-toggle="modal" data-target="#myModal2" style="cursor: pointer;" onclick="setProject2('<?php echo $user_id;?>','<?php echo $user_login;?>')" hidden><i class="fa fa-user-plus"></i> <?php echo __('clientdetails_sidebar_send_message','Send Message'); ?></a><br />
      <?php $user = $this->session->userdata('user'); if($user){ $login_user_id = $user[0]->user_id; }else{ $login_user_id = ''; } $action = 'add'; $fav_cls = ''; if(is_fav($user_id, 'FREELANCER', $login_user_id)){ $action = 'remove'; $fav_cls = 'bookmarked'; } ?>
      <a href="javascript:void(0)" class="btn btn-secondary mark-fav-button <?php echo $fav_cls;?>" data-object-id="<?php echo $user_id;?>" data-object-type="FREELANCER" data-action="<?php echo $action;?>"><i class="fa fa-heart"></i> Favourite</a>
	<?php
	}
	}
	?>
    </div>
</div>		
</div>
<div class="single-page-footer">
    <div class="container">
    <ul class="profile-list">		
        <li><i class="icon-feather-log-in"></i> <?php echo __('clientdetails_sidebar_last_logged_on','Last logged on'); ?>: <span><?php echo date('d M,Y',strtotime($ldate));?></span></li>
        <?php 
		if($account_type == 'E'){ 
			$this->load->model('jobdetails/jobdetails_model');
			$user_totalproject = $this->jobdetails_model->gettotaluserproject($user_id);
			$total_posted = $this->dashboard_model->getProjectStatics($user_id);
			if(count($total_posted) > 0){foreach($total_posted as $k => $v){
		?>
        <li><i class="icon-feather-briefcase"></i> <?php echo $v['name'] ?>: <span><?php echo $v['y'] ?></span></li>
        <?php } } ?>
        <li><i class="icon-feather-briefcase"></i> <?php echo __('clientdetails_sidebar_posted_job','Posted Job'); ?>: <span><?php echo $user_totalproject;?></span></li>
        <li><i class="icon-feather-dollar-sign"></i> <?php echo __('clientdetails_sidebar_total_spent','Total Spent'); ?>: <span><?php echo CURRENCY;?><?php echo get_project_spend_amount($user_id);?></span></li>
        <?php  } ?>
        <?php if($account_type == 'F'){ ?>
        <li hidden><i class="icon-feather-clock"></i> <?php echo __('clientdetails_sidebar_hourly_rate','Hourly Rate'); ?>: <span><?php echo CURRENCY;?><?php echo $rate;?></span></li>
        <li><i class="icon-feather-briefcase"></i> <?php echo __('clientdetails_sidebar_amount_earned','Amount Earned'); ?>: <span><?php echo CURRENCY;?> <?php echo get_earned_amount($user_id);?></span></li>
        <li><i class="icon-feather-briefcase"></i> <?php echo __('clientdetails_sidebar_completed_project','Completed Project'); ?>: <span><?php echo get_freelancer_project($user_id, 'C');?></span></li>
        <?php } ?>
      </ul>
	</div>
</div>    
<div class="background-image-container" style="background-image: url('<?php echo $bg_full_path;?>');"></div>
</div>

<section class="sec">
<div class="container">
<?php // $this->load->view('left_sidebar'); ?>
<div class="row">    
<aside class="col-sm-8 col-12">
    
 <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item"><a class="nav-link active" href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo __('talentdetails_email_overview','Overview'); ?></a></li>
    <li class="nav-item"><a class="nav-link" href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo __('talentdetails_portfolio','Portfolio'); ?></a></li>
    <li class="nav-item"><a class="nav-link" href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><?php echo __('talentdetails_reviews_and_ratings','Reviews & Ratings'); ?></a></li>
    <!--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>-->
  </ul>

  <!-- Tab panes -->
  <div class="tab-content mb-4">
    <div role="tabpanel" class="tab-pane active" id="home">
    <article class="card">
    <div class="card-header"><h4><i class="icon-feather-user site-text"></i> About <?php echo get_full_name($user_id);?></h4></div>
    <div class="card-body">
		<p><?php echo $overview;?></p>
    </div>
    </article>
    
    <article class="card">
        <div class="card-header">
	        <h4><i class="icon-feather-settings site-text"></i> <?php echo __('talentdetails_services','Services'); ?></h4>
        </div>
        <div class="card-body">
        <ul class="skills mb-0">    
			<?php

			if(!empty($user_skill)){ 
				
			  foreach($user_skill as $key => $val){  
			  
			  $skill_name=$val['skill_name'];
			  switch($lang){
				case 'arabic':
					$skill_name = !empty($val['arabic_skill_name'])? $val['arabic_skill_name'] : $val['skill_name'];
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$skill_name = !empty($val['spanish_skill_name'])? $val['spanish_skill_name'] : $val['skill_name'];
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$skill_name = !empty($val['swedish_skill_name'])? $val['swedish_skill_name'] : $val['skill_name'];
					break;
				default :
					$skill_name = $val['skill_name'];
					break;
			}
			  
			?>
			  <li><a href="<?php echo base_url('findtalents?skills[]='.$val['skill_id']);?>" class="skilslinks"><?php echo $skill_name;?></a></li>               
			<?php        
			  }    
			}
			else{
				  echo __('talentdetails_no_skill_set_yet','No Skill Set Yet'); 
			}
			 
			?>
		</ul>
        </div>
	</article>
        
	<div class="listing">
        
        <article class="panel panel-default block hide">
        <div class="panel-heading">
	        <h4 class="block-title"><?php echo __('talentdetails_work_experience','Work Experience'); ?>:</h4>
        </div>
        <div class="panel-body">
		<?php if(count($experiences) > 0){foreach($experiences as $k => $v){ ?>
			<div id="experience_<?php echo $v['experience_id'];?>">
			<h4 class="block-title"><?php echo $v['title'];?></h4>
				<p><b><?php echo $v['company'];?></b> <?php echo $v['start_year'];?> - <?php echo $v['currently_working'] == 'Y' ? 'Present' : $v['end_year'];?></p>
				<p><?php echo $v['summary'];?></p>
			</div>
			<?php } }else{ ?>
			<div id="no_experience"><p><b><?php echo __('talentdetails_no_experience_added_yet','No experience added yet'); ?></b></p></div>
			<?php } ?>
        </div>
        </article>
		
		<article class="panel panel-default block hide">
        <div class="panel-heading">
	        <h4 class="block-title"><?php echo __('talentdetails_education','Education'); ?>:</h4>
        </div>
        <div class="panel-body">
		<?php if(count($educations) > 0){foreach($educations as $k => $v){ 
		$c = $this->auto_model->getFeild('Name', 'country', 'Code', $v['country']);
		$u = $this->auto_model->getFeild('university', 'university', 'university_id', $v['university']);
		?>
		<div id="education_<?php echo $v['education_id'];?>">
			<h4><?php echo $v['degree'];?> </h4>
			<p><b><?php echo $u;?> , <?php echo $c;?></b> <?php echo $v['start_year'];?>-<?php echo $v['end_year'];?> </p>
		
		</div>
		<?php } }else{ ?>
		<div id="no_education"><p><b><?php echo __('talentdetails_you_have_not_added_any_education_yet','You have not added any education yet'); ?>.</b></p></div>
		<?php } ?>
        </div>
        </article>       
        
        <article class="panel panel-default block hide">
        <div class="panel-heading">
        	<h4 class="block-title"><?php echo __('talentdetails_certificate','Certificates'); ?></h4>
        </div>
        <div class="panel-body">
        	<?php if(count($certificates) > 0){foreach($certificates as $k => $v){ ?>
				<div id="certificate_<?php echo $v['certificate_id'];?>">
				<h4><?php echo $v['title'];?> ( <?php echo $v['duration'];?> <?php echo __('talentdetails_month','month'); ?>)
				</h4>
				<p><?php echo $v['institute']; ?></p>
				</div>
				<?php } }else{  ?>
				<p><?php echo __('talentdetails_no_certificates_added','No certificates added'); ?> </p>
				<?php } ?>
        </div>
        </article>
        
        
		<?php /*
		<h4><?php echo __('myprofile_document','Documents and Licenses'); ?></h4>
		<div data-ajaxify="<?php echo base_url('dashboard/load_ajax?page=user_document&user='.$user_id);?>"></div>*/?>
		
		<aside class="panel panel-default block hidden">
        <div class="panel-heading">
	        <h4 class="block-title"><?php echo __('talentdetails_other_portfolio','Other Portfolio'); ?></h4>
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
        </aside>
	    </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
        <div class="portfolio">                    
            <?php if(count($user_portfolio)>0){ ?>
            
            
            <div class="portfolio" id="masonryG_">
            <div class="row">
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
                <!--<a href="#" class="btn btn-sm">View More</a>-->
                           
                </div>
                </a>
                </div>
                </article>
                <?php } } ?>
            </div>
            </div>
            <?php } ?>            
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="messages">
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
       <div class="star-rating" data-rating="<?php echo round($avg_rating); ?>"></div>
        <p><a href="javascript:void(0)" class="seeAll">See all skills rating <i class="zmdi zmdi-chevron-down"></i></a></p>
        <div class="ratingtext" style="display:none">
        <div class="divider margin-top-10 margin-bottom-10"></div>
        
	   
	   <p><span>Skills:</span>
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
	   
	    <p><span>Quality of works:</span> 
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
	   
	   <p><span>Availability:</span> 
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
	   
	   <p><span>Communication:</span> 
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
	   
	    <p><span>Cooperation:</span> 
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
        <div class="job-listing-footer">
			<ul>
                <li><span><?php echo ucwords( $given_name);?></span></li>
                <li><span><i class="icon-feather-map-pin"></i> <?php echo $country_name; ?> <img class="flag" src="<?php echo IMAGE;?>cuntryflag/<?php echo $flag;?>" alt="" width="20"></span></li>
                <li><span><i class="icon-feather-calendar"></i> <?php echo date('d M,Y',strtotime($val['added_date']));?></span></li>
          	</ul>     
        
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
        
		
        
    </div>
    <!--<div role="tabpanel" class="tab-pane" id="settings">...</div>-->
  </div>
 
</aside>
<aside class="col-sm-4 col-12">		
	<div class="profileEdit">               
       
     <?php 
	 $lang=$this->session->userdata('lang');
			$u_row = get_row(array('select' => 'payment_verified,phone_verified,email_verified,abuse,spam', 'from' => 'user', 'where' => array('user_id' => $user_id)));
			if($this->session->userdata('user')){
				$userid=$this->session->userdata('user');
				$user_login=$userid[0]->user_id;
				$u_acc_type =  $userid[0]->account_type;
			}
			
		?>
        <div class="spacer-60 visible-under-992"></div>
        <article class="card">
        <div class="card-header">
	        <h4><i class="icon-feather-shield site-text"></i> Verifications</h4>
        </div>
        <div class="card-body text-center">                         
        <p class="hidden"><i class="zmdi zmdi-facebook-box"></i>
     <?php echo __('talentdetails_facebook_connected','Facebook Connected'); ?> <span><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="<?php echo __('talentdetails_verified','Verified'); ?>" style="color:#0c0;line-height:20px"></i></span></p>
        <p class="list-group-item hidden"><i class="zmdi zmdi-smartphone"></i> <?php echo __('talentdetails_facebook_payment_verified','Payment Verified'); ?>
          <?php if($u_row['payment_verified'] == 'Y'){ echo '<span>'.__('talentdetails_verified','Verified').'</span>'; }else{ ?>
          <span><i class="zmdi zmdi-hc-2x zmdi-close-circle" title="<?php echo __('talentdetails_unverified','Unverify'); ?>" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </p>
        <p><i class="zmdi zmdi-email"></i> <?php echo __('talentdetails_email_verified','Email Verified'); ?></p>
          <?php if($u_row['email_verified'] == 'Y'){ echo '<span><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="Verified" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
        <p><i class="zmdi zmdi-hc-2x zmdi-close-circle" title="Unverify" style="color:#f00;line-height:20px"></i></p>
        <?php } ?>
        
        <p class="hide">
    	<i class="zmdi zmdi-smartphone"></i> <?php echo __('talentdetails_phone_verified','Phone Verified'); ?>
          <?php if($u_row['phone_verified'] == 'Y'){ echo '<span><i class="zmdi zmdi-hc-2x zmdi-check-circle" title="'.__('talentdetails_verified','Verified').'" style="color:#0c0;line-height:20px"></i></span>'; }else{ ?>
          <span><i class="zmdi zmdi-hc-2x zmdi-close-circle" title="'.__('talentdetails_unverified','Unverify').'" style="color:#f00;line-height:20px"></i></span>
          <?php } ?>
        </p>

        
		<?php $this->load->model('report/report_model'); ?>
			<ul hidden>
			 <?php if($this->report_model->is_abuse($user_id, 'USER')){ ?>
			 <li><a href="#">Reported as abuse</a> <?php echo '('.$u_row['abuse'].')'; ?></li>
			 <?php }else{ ?>
			  <li><a href="<?php echo base_url('report/report_abuse/USER/'.$user_id); ?>?next=clientdetails/showdetails/<?php echo $user_id; ?>">Report Abuse</a> <?php echo '('.$u_row['abuse'].')'; ?></li>
			 <?php } ?>
			 
			  <?php if($this->report_model->is_spam($user_id, 'USER')){ ?>
			  <li><a href="#">Reported as spam</a> <?php echo '('.$u_row['spam'].')'; ?> </li>
			  <?php }else{ ?>
			   <li><a href="<?php echo base_url('report/report_spam/USER/'.$user_id); ?>?next=clientdetails/showdetails/<?php echo $user_id; ?>">Report Spam</a> <?php echo '('.$u_row['spam'].')'; ?> </li>
			 <?php } ?>
			</ul>
			</div>
            </article>
      </div> 
        	      
	<div class="panel panel-default hidden">
        <div class="panel-heading">
            <h4>Certifications</h4>
        </div>
        <div class="panel-body">
            <a href="javascript:void(0)" class="btn btn-site btn-block">Get Certified</a>
            <br>
            <p>You do not have any certifications.</p>
        </div>
    </div>
    
    <div class="panel panel-default" hidden>
        <div class="panel-heading">
            <h4>Top Skills</h4>
        </div>
        <div class="panel-body" style="padding:0; margin:-1px 0 0">
            <ul class="list-group">
				<?php 
				if(!empty($user_skill)){ 
				
				foreach($user_skill as $key => $val){   
				?>
				<li class="list-group-item"><a href="<?php echo base_url('findtalents?skills[]='.$val['skill_id']);?>"><?php echo $val['skill'];?></a> <span class="badge hidden">100</span></li>
				<?php
				}
				}else{ 
				?>
				<li class="list-group-item"><?php echo __('talentdetails_no_skills_found','No Skills found'); ?></li>
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
<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Send a private message</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="window.location.reload()">&times;</span></button>
        
    </div>
    <div class="modal-body">
		<?php
			$usr = $this->session->userdata('user');
			$user_project=$this->findtalents_model->getprojects($usr[0]->user_id);
			
		?>
		<form class="form-horizontal" id="project_invitation_form">
		<input type="hidden" name="freelancer_id" value="<?php echo $user_id;?>"/>
		<input type="hidden" name="employer_id" value="<?php echo $usr[0]->user_id;?>"/>
        <textarea rows="4" name="message" class="form-control" placeholder="Write your invitation" style="margin-bottom:10px">Hi <?php echo $fname; ?>, I noticed your profile and would like to offer you my project. We can discuss any details over chat.</textarea>
		
		
		<?php if(count($user_project) > 0){?>
        <select id="choosen_project" class="form-control" style="margin-bottom:10px" name="project_id" onchange="check_project_type();">
		<option value="">Choose project</option>
			<?php if(count($user_project) > 0){foreach($user_project as $k => $v){ ?>
				<option value="<?php echo $v['project_id'];?>" data-project-type="<?php echo $v['project_type'];?>"><?php echo $v['title']; ?></option>
			<?php } }  ?>
        
		</select>
		<?php }else{ ?>
		<p>You have no open project . <a href="<?php echo base_url('postjob?inv_user='.$user_id)?>">Post a project</a> now to invite this user </p>
		<?php } ?>
		
		<input type="hidden" name="project_type" id="project_type" value=""/>
        <div class="clearfix"></div>
        <!--<h5>My Budget (Minimum: <i class="fa fa-inr hide"></i> ₹ 600)</h5>-->
		
		<div id="invitation_price_type" hidden>
			<div class="checkbox radio-inline" style="margin:0; display:none;" id="fixed_rate">
			<input type="radio" class="magic-radio" id="1" checked="">
			<label for="1"> Set Fixed Price</label>
			</div>
			
			<div class="checkbox radio-inline" style="margin:0 ; display:none;" id="hourly_rate">
			<input type="radio" class="magic-radio" id="2" checked="">
			<label for="2"> Set An Hourly Rate</label>
			</div>
		</div>
        <div class="spacer-15"></div>
       
        <div class="form-group row-5" hidden>
		
            <div class="col-sm-7 col-12" id="invitation_amount_fixed" style="display:none;">
            <div class="input-group">
              <span class="input-group-addon"><?php echo CURRENCY; ?></span>
              <input type="number" class="form-control" name="amount_fixed" value="" style="padding-right:0" placeholder="150" />
              <span class="input-group-addon" style="padding:0; background:none"><select style="height:32px; border:none; padding:0 6px"><option>EUR</option></select></span>
            </div>
            </div>
			
            <div class="col-sm-5 col-12" id="invitation_amount_hourly" style="display:none;">
            <div class="input-group"> 	
            <input type="number" class="form-control" name="amount_hourly" value="" style="padding-right:0" placeholder=" 10"/>
            <span class="input-group-addon"><?php echo CURRENCY; ?>/hr</span>
            </div>
            </div>
        </div>
       
        <div class="checkbox checkbox-inline hide">
            <input class="magic-checkbox" name="condition" id="confirm" value="Y" type="checkbox">
            <label for="confirm" style="font-size:12px">Please send me bids from other freelancers if my project is not accepted.</label>
        </div>	
		<?php if(count($user_project) > 0){?>
        <button type="button" onclick="invite_user();" class="btn btn-success btn-block" style="margin:5px 0">Hire Now</button>
        <?php } ?>
		</form>    
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Select Your project to invite freelancer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <input type="hidden" name="freelancer_id" id="freelancer_id" value=""/>
        <div id="allprojects"></div>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        <button type="button" onclick="hdd()" id="sbmt" class="btn btn-primary">Invite</button>
      </div>
    </div>
  </div>
</div>



<script>

function invite_user(){
	var f = $('#project_invitation_form'),
		fdata = f.serialize();
	
	if(f.find('select[name="project_id"]').val() != ''){
		$.ajax({
			url : '<?php echo base_url('clientdetails/invite_user');?>',
			data: fdata,
			type: 'POST',
			dataType: 'JSON',
			success: function(res){
				if(res['status'] == 1){
					$('#inviteModal').find('.modal-body').html('<p>Invitation successfully send</p>');
				}
			}
		});
	}else{
		alert('Please choose a project first');
	}
}
function check_project_type(){
	
	var val = $('#choosen_project').val(),
		p_type = $('#choosen_project :selected').attr('data-project-type');
		$('#project_type').val(p_type);
		if(p_type == 'H'){
			$('#invitation_price_type').find('#fixed_rate').hide();
			$('#invitation_price_type').find('#hourly_rate').show();
			$('#invitation_amount_fixed').hide();
			$('#invitation_amount_hourly').show();
		}else{
			$('#invitation_price_type').find('#fixed_rate').show();
			$('#invitation_price_type').find('#hourly_rate').hide();
			$('#invitation_amount_fixed').show();
			$('#invitation_amount_hourly').hide();
		}
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
/*
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
*/
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


<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="portfolioModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title port_title"><?php echo $val['title'];?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#portfolioModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-7 col-12">
                <img src="<?php echo ASSETS;?>portfolio/Hydrangeas.jpg" alt="" class="img-fluid" id="port_big_img" style="width:100%;">
            </div>    
            <div class="col-sm-5 col-12">
            <div class="media mt-4">
            <div class="profile_pic pic-sm">
              <span>
			   <img alt="" src="<?php echo  get_user_logo($user_id); ?>"  class="rounded-circle">
               </span>
            </div>
        	<div class="media-body">
			<?php 
				$user_city = get_user_city($user_id);
			 ?>
			
            	<h4><?php echo get_full_name($user_id);?></h4>
                <p><?php echo $user_city; ?></p>      
            </div>
			</div>
			<?php if($account_type == 'F'){ ?>
            <a href="#" onclick="$('#portfolioModal').modal('hide');" data-target="#inviteModal" data-toggle="modal" class="btn btn-site btn-lg btn-block hide"><i class="zmdi zmdi-account"></i> Hire</a>
			<?php } ?>              
            <h5>About the project</h5>
            <p id="port_dscr"><?php echo $val['description'];?>.</p>
            </div>
        </div>
      </div>
      
    </div>
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