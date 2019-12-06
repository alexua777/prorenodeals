<?php    $l_user = $this->session->userdata('user');$user_id = $l_user[0]->user_id;$verified = getField('verify', 'user', 'user_id', $user_id);?><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53a028a2284897c6"></script>
<script type="text/javascript" src="<?php echo JS;?>jQuery-plugin-progressbar.js"></script>
<link href="<?php echo CSS;?>jQuery-plugin-progressbar.css" rel="stylesheet" type="text/css">
<style>
a.round-button.active {
	background-color: #0c0;
	color: #fff;
}
.zmdi-close-circle {
	color:#f00;
	line-height:34px;
	font-size:24px
}
.item.selected {
	background-color: #e2dfdf;
}
</style>
<?php $lang = $this->session->userdata('lang'); ?>
<script>
function invitecheck(){
	
	var fmail=$('#femail').val();
	var fname=$('#fname').val();
	var mymail=$('#mymail').val();
	var myname=$('#myname').val();
	var f=true;
        
        var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;        
        
	if(fmail==''){
		$('#femailError').html("<?php echo __('jobdetails_friends_email_cant_be_blank','Friends Email cant be left blank'); ?>");
		$('#femail').focus();
		f=false;	
	}
        if(fmail!=''){            
            if(!re.test(fmail)){  
		$('#femailError').html("<?php echo __('jobdetails_please_enter_a_valid_email','Please Enter a Valid Email'); ?>");
		$('#femail').focus();
		f=false;           
            }
        }        
	 if(fname==''){
		$('#fnameError').html("<?php echo __('jobdetails_friends_name_cant_be_blank','Friends Name cant be left blank'); ?>");
		$('#fname').focus();
		f=false;	
	}
	 if(mymail==''){
		$('#mymailError').html("<?php echo __('jobdetails_your_email_cant_be_blank','Your Email cant be left blank'); ?>");
		$('#mymail').focus();
		f=false;	
	}
        if(mymail!=''){            
            if(!re.test(mymail)){  
		$('#mymailError').html("<?php echo __('jobdetails_please_enter_a_valid_email','Please Enter a Valid Email'); ?>");
		$('#mymail').focus();
		f=false;         
            }
        }          
	if(myname==''){
		$('#mynameError').html("<?php echo __('jobdetails_friends_name_cant_be_blank','Friends Name cant be left blank'); ?>");
		$('#myname').focus();
		f=false;		
	}
	return f;	
}

</script>

<!-- Content Start -->

<script src="<?=JS?>mycustom.js"></script> 
<script type="text/javascript">
function bid_valid(){                           
	FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>jobdetails/check",'bidjob_frm');
}

function postQuestion(){                           
	FormPost('#ask_submit',"<?=VPATH?>","<?=VPATH?>jobdetails/checkquestion",'askquestion_frm');
}                    
</script>
<section id="mainpage">
<div class="container-fluid">
<div class="row">

<?php 
$login_user = $this->session->userdata('user');
?>
<?php if($login_user){ ?>
<?php $this->load->view('dashboard/dashboard-left'); ?> 
<?php }else{ ?>
<?php } ?>

<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb; ?>
<?php 
$this->load->model('clientdetails/clientdetails_model');
 $buget="";
/*  if($project[0]['buget_min']!=0 && $project[0]['buget_max']!=0 && $project[0]['buget_max'] !== $project[0]['buget_min']){ 
     $buget=CURRENCY." ".$project[0]['buget_min']. " To ".CURRENCY." ".$project[0]['buget_max'];     
 }else if($project[0]['buget_max'] == $project[0]['buget_min']){
	 $buget=CURRENCY." ".$project[0]['buget_min'];
 }
 else if($project[0]['buget_min']!=0 && $project[0]['buget_max']==0){ 
   $buget="Over ".CURRENCY." ".$project[0]['buget_min'];          
 }
 else if($project[0]['buget_min']==0 && $project[0]['buget_max']!=0){ 
   $buget="Less than ".CURRENCY." ".$project[0]['buget_max'];          
 }  */
$buget = get_project_budget($project[0]['project_id']);
?>
        <?php       
	 $now = time(); 
	 $your_date = strtotime($project[0]['expiry_date']);
	 $datediff = $your_date - $now;
	 $dayleft = floor($datediff/(60*60*24));            
	$posted_on = $this->auto_model->getFeild('post_date' , 'projects' , 'project_id' , $project[0]['project_id']);
?>
	<div class="row">
	<div class="col-lg-9 col-12">
    
        <div class="card">
          <div class="card-header">
          
            <h4 class="float-lg-left"><?php echo htmlentities($project[0]['title']);?></h4>

          <?php 
$is_fav = 0;
$user1=$this->session->userdata('user');
if($user1){
	$nuid = $user1[0]->user_id;
	$count = $this->db->where(array('user_id' => $nuid , 'type' => 'JOB', 'object_id' => $project[0]['project_id']))->count_all_results('favorite');
	if($count > 0){
		$is_fav = 1;
	}
}
if($is_fav > 0){
	$url = base_url('jobdetails/remove_fav/'.$project[0]['project_id']).'?return=jobdetails/details/'.$project[0]['project_id'].'/'.$this->auto_model->getcleanurl(htmlentities($project[0]['title']));
}else{
	$url = base_url('jobdetails/add_fav/'.$project[0]['project_id']).'?return=jobdetails/details/'.$project[0]['project_id'].'/'.$this->auto_model->getcleanurl(htmlentities($project[0]['title']));
}
?>
          
            <ul class="social-share float-lg-right">
              <li><a href="<?php echo $url;?>"><i class="fa fa-heart" style="<?php echo $is_fav > 0 ? 'color:orange;' : ''?>"></i></a></li>
              <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url('jobdetails/details/'.$project[0]['project_id'].'/'.$this->auto_model->getcleanurl(htmlentities($project[0]['title'])));?>" target="_blank"><i class="fab fa-facebook"></i></a></li>
              <li><a href="https://twitter.com/home?status=<?php echo base_url('jobdetails/details/'.$project[0]['project_id'].'/'.$this->auto_model->getcleanurl(htmlentities($project[0]['title'])));?>" target="_blank"><i class="fab fa-twitter-square"></i></a></li>
              <li><a href="https://plus.google.com/share?url=<?php echo base_url('jobdetails/details/'.$project[0]['project_id'].'/'.$this->auto_model->getcleanurl(htmlentities($project[0]['title'])));?>" target="_blank"><i class="fab fa-google-plus-square"></i></a></li>
              <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo base_url('jobdetails/details/'.$project[0]['project_id'].'/'.$this->auto_model->getcleanurl(htmlentities($project[0]['title'])));?>/&title=&summary=&source=" target="_blank"><i class="fab fa-linkedin-square"></i></a></li>
			 
            </ul>
			<?php $this->load->model('report/report_model'); ?>
			<ul hidden>
			 <?php if($this->report_model->is_abuse($project[0]['project_id'], 'PROJECT')){ ?>
			 <li><a href="#">Reported as abuse</a> <?php echo '('.$project[0]['abuse'].')'; ?></li>
			 <?php }else{ ?>
			  <li><a href="<?php echo base_url('report/report_abuse/PROJECT/'.$project[0]['project_id']); ?>?next=jobdetails/details/<?php echo $project[0]['project_id']; ?>">Report Abuse</a> <?php echo '('.$project[0]['abuse'].')'; ?></li>
			 <?php } ?>
			 
			  <?php if($this->report_model->is_spam($project[0]['project_id'], 'PROJECT')){ ?>
			  <li><a href="#">Reported as spam</a> <?php echo '('.$project[0]['spam'].')'; ?> </li>
			  <?php }else{ ?>
			   <li><a href="<?php echo base_url('report/report_spam/PROJECT/'.$project[0]['project_id']); ?>?next=jobdetails/details/<?php echo $project[0]['project_id']; ?>">Report Spam</a> <?php echo '('.$project[0]['spam'].')'; ?> </li>
			 <?php } ?>
			</ul>
			
          
        <div class="clearfix"></div>
            
          </div>
          <div class="card-body">
            
            <p><b class="h5"><?php echo __('jobdetails_project_summary','Project Summary'); ?>:</b> <?php echo  nl2br(htmlentities($project[0]['description']));?></p>
            <?php
			$healthy = explode(",",BAD_WORDS);
			$yummy   = array("[*****]");
			$project[0]['description'] = str_replace($healthy, $yummy, $project[0]['description']);
			?>
						<?php
			if(is_numeric($project[0]['sub_category'])){
				$eng_cat_name = $this->auto_model->getFeild('cat_name' , 'categories' , 'cat_id' ,$project[0]['sub_category']);
				switch($lang){
							case 'arabic':
								$arabic_cat_name = $this->auto_model->getFeild('arabic_cat_name' , 'categories' , 'cat_id' ,$project[0]['sub_category']);
								$categoryName = !empty($arabic_cat_name)? $arabic_cat_name : $eng_cat_name;
								break;
							case 'spanish':
								$spanish_cat_name = $this->auto_model->getFeild('spanish_cat_name' , 'categories' , 'cat_id' ,$project[0]['sub_category']);
								$categoryName = !empty($spanish_cat_name)? $spanish_cat_name : $eng_cat_name;
								break;
							case 'swedish':
								$swedish_cat_name = $this->auto_model->getFeild('swedish_cat_name' , 'categories' , 'cat_id' ,$project[0]['sub_category']);
								$categoryName = !empty($swedish_cat_name)? $swedish_cat_name : $eng_cat_name;
								break;
							default :
								$categoryName = $eng_cat_name;
								break;
						}
			}else{
				$project[0]['sub_category_name'] = $project[0]['sub_category'];
			}
			
			
			?>
            
			<?php 
			$additional_dscr = get_results(array('select' => '*', 'from' => 'project_description', 'where' => array('project_id' => $project[0]['project_id'])));
			
			if($additional_dscr){
				foreach($additional_dscr as $k => $v){
					$date = date('d/m/Y', strtotime($v['datetime']));
					$time = date('H:i', strtotime($v['datetime']));
					$dscr = str_replace($healthy, $yummy, $v['description']);
					
					echo "<h5><b>Additional info added on $date at $time</b></h5>";
					echo nl2br($dscr);
				}
			}
			?>
           <!-- <h4><?php // echo __('jobdetails_category','Category'); ?>: <span><?php echo  $categoryName;  ?></span></h4>-->
			
			<?php
			$exp_level = $project[0]['exp_level'];
			if(!empty($exp_level)){
				$exp_level_row = get_row(array('select' => '*', 'from' => 'experience_level', 'where' => array('id' => $exp_level)));
			}else{
				$exp_level_row =array();
			}
			?>
			
            <h4 class="hide"><?php echo __('jobdetails_experience_level','Experience level'); ?>: <span><?php echo  !empty($exp_level_row['name']) ? $exp_level_row['name'] . " <i style='font-size: 13px;'> (  {$exp_level_row['description']}  ) </i>" : 'N/A';  ?></span></h4>
			
			<?php if( $project[0]['project_type'] == 'H'){ ?>
			<h4>Approx Hours </h4>
			<?php echo $project[0]['hr_per_week'] > 0 ? $project[0]['hr_per_week'] : 'Not sure'; ?>
			<?php } ?>
			
			
            <?php
$skill_req = explode(',' , $project[0]['skills']);
?>
            <?php
$q = array(
	'select' => 's.skill_name,s.arabic_skill_name,s.spanish_skill_name,s.swedish_skill_name , s.id',
	'from' => 'project_skill ps',
	'join' => array(array('skills s' , 'ps.skill_id = s.id' , 'INNER')),
	'offset' => 200,
	'where' => array('ps.project_id' => $project[0]['project_id'])
);
$skills = get_results($q);

?>
            <h5><?php echo __('jobdetails_skills_and_knowledge','Skills and Knowledge'); ?>:</h5>
            <ul class="skills">
              <?php if(count($skills) > 0){foreach($skills as $v){ 
			  
			   $skill_name=$v['skill_name'];
			  switch($lang){
				case 'arabic':
					$skill_name = !empty($v['arabic_skill_name'])? $v['arabic_skill_name'] : $v['skill_name'];
					break;
				case 'spanish':
					
					$skill_name = !empty($v['spanish_skill_name'])? $v['spanish_skill_name'] : $v['skill_name'];
					break;
				case 'swedish':
					
					
					$skill_name = !empty($v['swedish_skill_name'])? $v['swedish_skill_name'] : $v['skill_name'];
					break;
				default :
					$skill_name = $v['skill_name'];
					break;
			}
			  
			  ?>
              <li><span><?php echo $skill_name;?></span></li>
              <?php } } ?>
            </ul>
            
            <ul class="job-list">
              	<li><b><?php echo __('jobdetails_posted_on','Posted on'); ?>:</b> <?php echo date('d-M-Y' , strtotime($posted_on));?></li>
                <li><b><?php echo __('jobdetails_budget','Budget'); ?>:</b> <?php echo $buget;?></li>
                <li hidden><b><?php echo __('jobdetails_project_type','Project Type'); ?>:</b> <?php echo $project[0]['project_type']=="F" ? __('jobdetails_fixed','Fixed') : __('jobdetails_hourly','Hourly'); ?></td>
                <li hidden><b><?php echo __('jobdetails_time','Time'); ?>:</b> <?php echo $dayleft;?> <?php echo __('jobdetails_days_left','days left'); ?></li>
                          
              	<li>
                <?php if(!empty($project[0]['project_start_on'])){ ?>
                <b>Project Start On:</b> <?php echo project_start_on($project[0]['project_start_on']);?></li>
                <?php } ?>
                <li>
                <?php if(!empty($project[0]['bidding_deadline']) && $project[0]['bidding_deadline'] != '0000-00-00'){ ?>
                
                  <b>Bidding Deadline:</b> <span class="red-text"><?php echo date('d M, Y', strtotime($project[0]['bidding_deadline'])); ?></span>
                
				<?php } ?>
                </li>				
              	<li><b>Postal Code:</b> <?php echo $project[0]['postal_code'];?></li>
                <li>
                <?php if(!empty($project[0]['attachment'])){ ?>
                <b>Attachments :</b>
                <?php
                $attacment = explode(',', $project[0]['attachment']);
                if($attacment){ 
                ?>
                <ul class="list">
                <?php foreach($attacment as $file){ 
                $file_url = base_url('assets/postjob_upload/'.$file);
                ?>
                <li><a href="<?php echo $file_url;?>" target="_blank"><?php echo $file;?></a></li>
                <?php } ?>
                </ul>
                <?php }else{ ?>
                <?php } ?>
                
                <?php } ?>
                </li>
            </ul>
			<!-- bid now button -->
            <div class="spacer-10"></div>
            <span>
			<?php
			$bidding_closed = false;
			
			$all_bidder = explode(',' , getField('bidder_id', 'projects', 'project_id', $project[0]['project_id']));
			$all_chosen = explode(',' , getField('chosen_id', 'projects', 'project_id', $project[0]['project_id']));
			$max_freelancer = getField('no_of_freelancer', 'projects', 'project_id', $project[0]['project_id']);
			if(empty($all_bidder[0]) && count($all_bidder) == 1){
				$all_bidder = array();
			}
			if($project[0]['project_type'] == 'F' && $max_freelancer == 0){
				$max_freelancer = 1;
			}
			$total_bidder = count($all_bidder);
			
			if($total_bidder >= $max_freelancer){
				$bidding_closed = true;
			}
			?>
			<?php if(!empty($uid) && !in_array($uid, $all_bidder) && !in_array($uid, $all_chosen) && !$bidding_closed){ ?>
			<?php 
			if($user[0]['user_id']!=$uid){
				
				/* if($available_bid > 0){
					echo '<p><b>Available bids :</b> '.$available_bid.' </p>';
				}else{
					echo '<p><b>You bid limit is over <a href="'.base_url('dashboard/bid_plan').'" target="_blank">click here</a> to buy more bid</b></p>';
				} */
				
				$available_bid = 100; /* default value because of no bid purchase */ 
			}
			?>
			
			<?php if(date_crossed($project[0]['bidding_deadline'])){ /* nothing to do */ }else{ ?>
			<?php if($user[0]['user_id']!=$uid && !$revised_user){  if($available_bid > 0){  ?>
			<a href="#" class="btn btn-site" id="bid_now_button"><?php echo __('Bid Now','BID NOW'); ?></a>
		  
		  <?php } }else{ if($user[0]['user_id']!=$uid && $revised_user){ ?>
		 
		  <a href="#" class="btn btn-site revised_bid_button"><?php echo __('jobdetails_revised_bid','REVISED BID'); ?></a>
		  <?php } }  ?>
	   
			<?php } ?>
			<?php } ?>
				
              <?php if(!$uid){ ?>
              <a href="<?php echo base_url('login');?>" class="btn btn-site btn-block"><?php echo __('jobdetails_invite_contractor','INVITE CONTRACTOR'); ?></a>
              <?php }else{ if($user[0]['user_id']==$uid){  ?>
              <a href="#" class="btn btn-site" data-toggle="modal" data-target="#inviteModal"><?php echo __('jobdetails_invite_contractor','Invite Now'); ?></a>
              <?php } } ?>
              </span>
			<!-- bid now button end -->
          </div>
        </div>	
			
			
			  
	<?php if($verified == 'N'){ ?>
	<div id="new_bid_panel" style="display:none;">
	<div class="alert alert-danger">
	  <strong>Error !</strong> Your account is not verified yet. You cannot bid until you verify your account. You must upload the required documents need for verification in order to verify your account.
	</div>
	</div>
	
	<?php } ?>
	
        <?php 
		$show_bid_panel = get('show_bid_panel');
		if($show_bid_panel){
			$panel_css = '';
		}else{
			$panel_css = 'display:none;';
		}
		if(isset($uid) && $verified == 'Y' && $user[0]['user_id']!=$uid && (($available_bid > 0) || $revised_user)){  
		?>
        <div class="card" id="new_bid_panel" style="<?php echo $panel_css; ?>">
          <div class="card-header">
            <h4><?php echo __('jobdetails_bid_project','Bid Project'); ?></h4>
          </div>
          <div class="card-body">			
			<?php if(!empty($revised_data[0]['note'])){ ?>
			<div class="alert alert-warning text-left" role="alert">
				<h4 class="mb-20">Revise Bid Request</h4><p><b>Requested Amount : </b><?php echo CURRENCY.$revised_data[0]['bid_amount_request']; ?></p>
				<p><?php echo $revised_data[0]['note']; ?></p>
				
			</div>
			<?php } ?>
	
            <form action="" method="post" id="bid_form">
              <?php if($project[0]['project_type']=='F'){ ?>
				<div style="display:none">
				<label><b>How do you want to be paid ? </b></label>
				<?php if(!$revised_user){ ?>
				<div class="form-group">
					<p>
						<input class="magic-radio" name="payment_at" type="radio" id="payment_at_milestone" value="M">
						<label for="payment_at_milestone" style="display:inherit">By milestone</label>
					</p>
					<p>
					<input class="magic-radio" name="payment_at" type="radio" id="payment_at_project" value="P" checked />
						<label for="payment_at_project" style="display:inherit">By project</label>
					</p>
				
				</div>
				<?php } ?>
				</div>				
				<div id="payment_project_wrapper" style="display:none;">
					<?php
					if(!empty($revised_milestone[0]['amount'])){
						$rev_milestone_amt = $revised_milestone[0]['amount'];
						$milestone_comm = (($rev_milestone_amt * SITE_COMMISSION)/(100+SITE_COMMISSION));
						$rev_milestone_amt = number_format(($rev_milestone_amt - $milestone_comm), 2, '.', '');
					}else{
						$milestone_comm = 0;
						$rev_milestone_amt = 0;
					}
					
					?>
					<div class="row row-10">
						<div class="col-md-4">
							<label><b>Bid Amount (paid to you)</b></label>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text"><?php echo CURRENCY; ?></span></div>
								<input type="text" name="amount[]" class="form-control required" value="<?php echo $rev_milestone_amt ; ?>" onkeypress="return isNumberKey(event)" oninput="checkAmount(this)"/>
							</div>
							 <input type="hidden" name="title[]" value="Project payment"/>
							 <input type="hidden" name="date[]"  value="0000-00-00" />
							 <div id="amountError" class="rerror"></div>
						</div>
						<div class="col-md-4">
							<label><b>Fee</b></label>
							<h3 class="mb-3"><?php echo SITE_COMMISSION; ?> %</h3> 
						</div>
						<div class="col-md-4">
						<label><b>Your bid amount</b></label>
						<h3 class="mb-3"><span id="project_pay_amount"><?php echo CURRENCY; ?>0.00</span></h3>
						</div>
					</div>
				</div>	
				
				<div id="payment_milestone_wrapper">
			<span id="milestone_wrapper">
              <?php 
			  $milestone_amt = 0;
			  if(!empty($revised_milestone) AND count($revised_milestone) > 0){ foreach($revised_milestone as $k => $v){ 
				$milestone_comm = (($v['amount'] * SITE_COMMISSION)/(100+SITE_COMMISSION));
				
				$v['amount'] = clean_money_format(($v['amount'] - $milestone_comm));
				$milestone_amt += $v['amount'];
			  ?>
              <div class="row row-10" id="row_<?php echo $k;?>">
                <div class="col-sm-4 col-12">
                  <div class="form-field">
                    <label for="title"><?php echo __('jobdetails_milestone_title','Milestone Title'); ?></label>
                    <input type="text" name="title[]"  class="form-control required" value="<?php echo !empty($v['title']) ? $v['title'] : '';?>"/>
                  </div>
                </div>
                <div class="col-sm-4 col-12">
                  <div class="form-field">
                    <label for="date"><?php echo __('jobdetails_due_date','Due Date'); ?></label>
                    <div class="input-group datepicker">
                    <input type="text" name="date[]" class="form-control required" value="<?php echo !empty($v['mpdate']) ? $v['mpdate'] : '';?>" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 col-12">
                  <div class="form-field">
                    <label for="amount"><?php echo __('jobdetails_amount','Amount'); ?> (paid to you)</label>
                    <input type="text" name="amount[]" class="form-control required" value="<?php echo !empty($v['amount']) ? $v['amount'] : '';?>" onkeypress="return isNumberKey(event)" oninput="checkAmountByMilestone()"/>
                  </div>
                </div>
                <?php if($k == 0){echo '<div class="col-sm-1"></div>'; }else{ ?>
                <div class="col-sm-1"><br>
                  <a href="javascript:void(0);" class="close_milestone" data-close="row_<?php echo $k;?>"><i class="zmdi zmdi-close-circle" aria-hidden="true"></i></a></div>
                <?php } ?>
              </div>
              <?php } }else{  ?>
              <div class="row row-10">
                <div class="col-sm-4 col-12">
                  <div class="form-field">
                    <label for="title"><?php echo __('jobdetails_milestone_title','Milestone Title'); ?></label>
                    <input type="text" name="title[]"  class="form-control required"/>
                  </div>
                </div>
                <div class="col-sm-4 col-12">
                  <div class="form-field">
                    <label for="date"><?php echo __('jobdetails_due_date','Due Date'); ?></label>
                    <div class="input-group datepicker">
                    <input type="text" name="date[]" class="form-control required" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                    
                  </div>
                </div>
                <div class="col-sm-3 col-12">
                  <div class="form-field">
                    <label for="amount"><?php echo __('jobdetails_amount','Amount'); ?> (paid to you) </label>
                    <input type="text" name="amount[]" class="form-control required"  onkeypress="return isNumberKey(event)" oninput="checkAmountByMilestone()" />
                  </div>
                </div>
                <div class="col-sm-1" style="display:none;"><br/>
                  <i class="fa fa-times" aria-hidden="true"></i></div>
              </div>
              <?php } ?>
              </span> 
			  <div class="row">
				<div class="col-sm-6">
					<p><b>Fee</b></p>
					<?php echo SITE_COMMISSION; ?> % 
				</div>
				<div class="col-sm-6">
					<?php
					$comm = ($milestone_amt * SITE_COMMISSION) / 100;
					$net_amount = $milestone_amt + $comm;
					?>
					<p><b>Your bid amount</b></p>
					$ <span id="milestone_pay_amt"><?php echo number_format($net_amount, 2);?></span>
				</div>
			  </div>
			  <a href="javascript:void(0);" id="add_more_milestone" class="btn btn-site btn-sm"><i class="zmdi zmdi-plus-circle"></i> <?php echo __('jobdetails_add_more_milestone','Add more milstone'); ?></a> <br />
              <br />
			  </div>	
			  
			  
              <?php }else{
				if($revised_user){
					$bid_amt = $revised_data[0]['bidder_amt'];
					$bid_amt_comm = (($bid_amt * SITE_COMMISSION)/(100+SITE_COMMISSION));
					$bid_amt = str_replace(',', '', number_format(($bid_amt - $bid_amt_comm), 2));
					$total_bid_amt = $revised_data[0]['bidder_amt'];
				}else{
					$bid_amt = 0;
					$bid_amt_comm = 0;
					$total_bid_amt = 0;
				}
				
			  ?>
              <div class="row">
				<div class="col-sm-6">
                	<div class="form-field">
					<label for="total_amount"><b><?php echo __('jobdetails_hourly_bid_amount','Hourly Bid Amount'); ?> (paid to you)</b></label>
					<div class="form-group input-group">  
					<span class="input-group-addon"><?php echo CURRENCY;?></span>
					<input type="text" value="<?php if($revised_user){echo $bid_amt;}?>" name="amount[]" id="total_amount" class="form-control"  onkeypress="return isNumberKey(event)" oninput="checkAmountByHourly()">
					</div>
					<span id="amountError" class="rerror"></span> 
                    </div>
				</div>
				<div class="col-sm-3">
					<label>Fee</label>
					<p><?php echo SITE_COMMISSION; ?>%</p>
				</div>
				<div class="col-sm-3">
					<label>Bid amount</label>
					<p><?php echo CURRENCY;?> <span id="hourly_pay_amt"><?php echo number_format($total_bid_amt, 2); ?></span></p>
				</div>
              </div>
				
				<div class="form-group">
                <label for=""><b>Approximate hours to do the job</b></label>
                <input type="number" value="<?php echo !empty($revised_data[0]['available_hr']) ? $revised_data[0]['available_hr'] : $project[0]['hr_per_week']; ?>" class="form-control" name="available_hr">
                <span id="available_hrError" class="rerror"></span> 
				</div>
				
              <?php } ?>
              <div class="form-group hide">
                <label><b><?php echo __('jobdetails_i_will_provide_update_status','I will provide update status'); ?></b></label>
                <select name="update_status" class="form-control">
                  <option value="daily"><?php echo __('jobdetails_daily','Daily'); ?></option>
                  <option value="weekly" <?php echo (!empty($revised_data[0]['update_status']) AND $revised_data[0]['update_status'] == 'weekly') ? 'selected="selected"' : '';?>><?php echo __('jobdetails_weekly','Weekly'); ?></option>
                  <option value="monthly" <?php echo (!empty($revised_data[0]['update_status']) AND $revised_data[0]['update_status'] == 'monthly') ? 'selected="selected"' : '';?>><?php echo __('jobdetails_monthly','Monthly'); ?></option>
                </select>
                <span id="deliveryError" class="rerror" style="float: left;"></span> </div>
              <?php 
		$u_skills = $this->dashboard_model->getUserSkills($uid);
		if(count($u_skills) > 0){
			foreach($u_skills as $k => $v){
				$u_skill_ids[] = $v['skill_id'];
			}
		}else{
			$u_skill_ids = array();
		}
		
		$matching_skills = array();
		
		if(count($skills) > 0){foreach($skills as $k => $v){ 
			if(in_array($v['id'], $u_skill_ids)){
				$matching_skills[] = $v;
			}
		} } ?>
              <div class="form-group">
                <label><b><?php echo __('jobdetails_matching_skills','Matching Skills'); ?></b></label>
                <ul class="skills">
                  <?php if(count($matching_skills) > 0){foreach($matching_skills as $k => $v){ ?>
                  <li><span><?php echo $v['skill_name'];?></span></li>
                  <?php } }else{  ?>
                  <li><?php echo __('jobdetails_no_matching_skills','No matching skills'); ?></li>
                  <?php } ?>
                </ul>
              </div>
              <input type="hidden" name="pid" value="<?php echo $project[0]['project_id']?>">
              <input type="hidden" name="bid" value="<?php echo $uid;?>">
              <input type="hidden" name="project_type" value="<?php echo $project[0]['project_type'];?>"/>
              <div class="form-group">
                <label><b><?php echo __('jobdetails_cover_letter','Cover Letter'); ?></b> <a data-toggle="tooltip" data-placement="left" title="Will only visible to employer"><i class="icon-feather-info"></i></a></label>
                <textarea rows="4" name="details" id="details" class="cost_input form-control"><?php if($revised_user){echo $revised_data[0]['details'];}?></textarea>
				
				<?php
				$p_questions = get_results(array('select' => '*', 'from' => 'project_questions', 'where' => array('project_id' => $project[0]['project_id'])));
				if(count($p_questions) > 0){ foreach($p_questions as $k => $v){  
				$prev_ans = $this->db->where(array('freelancer_id' => $uid, 'question_id' => $v['question_id']))->get('project_answers')->row_array();
				
				?>
				<div>
					<label><?php echo $v['question']; ?> <a data-toggle="tooltip" data-placement="left" title="Will only visible to employer"><i class="icon-feather-info"></i></a></label>
					<input type="hidden" name="questions_id[]" value="<?php echo $v['question_id']; ?>"/>
					<textarea rows="" cols="" name="freelancer_answer[]" class="form-control"><?php echo !empty($prev_ans['answer']) ? $prev_ans['answer'] : ''; ?></textarea>
				</div>	
				<?php } } ?>
					
              </div>
              <?php if($project[0]['project_type']=='F'){ ?>
              <div class="form-group">
                <label for="required_days"><b><?php echo __('jobdetails_days_required','Days Required'); ?></b></label>
                <input type="text" value="<?php if($revised_user){echo $revised_data[0]['days_required'];}?>" size="6" maxlength="3" name="required_days" id="required_days" class="form-control" onkeypress="return isNumberKey(event)">
                <span id="deliveryError" class="rerror" style="float: left;"></span> 
				</div>
				
				<div class="form-group hidden">
                <label for="required_days"><b><?php echo __('jobdetails_enable_excrow','Enable Excrow'); ?></b></label>
				<p>
					<input class="magic-radio" name="enable_escrow" type="radio" id="enable_excrow_no" value="0" checked>
					<label for="enable_excrow_no"><?php echo __('jobdetails_no','No'); ?></label>
				</p>
				<!--<p>
					<input class="magic-radio" name="enable_escrow" type="radio" id="enable_excrow_yes" value="1" <?php echo (!empty($revised_data[0]['enable_escrow']) && $revised_data[0]['enable_escrow'] == 1) ? 'checked="checked"' : '';?>>
					<label for="enable_excrow_yes"><?php echo __('jobdetails_yes','Yes'); ?></label>
				</p>-->
				<p>
					<input class="magic-radio" name="enable_escrow" type="radio" id="enable_excrow_yes" value="1" checked="checked" />
					<label for="enable_excrow_yes"><?php echo __('jobdetails_yes','Yes'); ?></label>
				</p>
				</div>
				
              <?php  } ?>
			  
			  
              <div class="form-group">
                <div class="input-group">
                  <label class="input-group-prepend"> <span class="btn btn-secondary"> <?php echo __('jobdetails_browse','Browse'); ?>&hellip;
                    <input type="file" class="browseimg-input" id="userfile" name="userfile" onchange="movebidfile(this)" style="display: none;" />
                    </span> </label>
                  <input type="text" class="form-control" readonly>
                  <input type="hidden" id="upload_file" name="upload_file1" value="<?php echo $revised_data[0]['attachment'] != '' ? $revised_data[0]['attachment'] : ''?>"/>
                </div>
                <div id="flist_div">
                  <?php if(!empty($revised_data[0]['attachment'])){ 
				$attachment_id = str_replace('.', '', $revised_data[0]['attachment']);
				?>
                  <div class="flisttext" id="<?php echo 'sp_'.$attachment_id;?>"><?php echo $revised_data[0]['attachment']; ?> <i class="zmdi zmdi-delete" onclick="removespan(this.id)" id="<?php echo $revised_data[0]['attachment']; ?>"></i> </div>
                  <?php } ?>
                </div>
                <!--<label style=" cursor:pointer; float:left;"> <img src="<?php// echo VPATH;?>assets/images/browseimg.png"/></label>--> 
              </div>
              <button type="submit" class="btn btn-site" id="save_bid"><?php echo __('jobdetails_submit','Submit'); ?></button>
            </form>
          </div>
        </div>
        <span id="bid_result"></span>
        <?php } ?>
        <?php if(isset($uid) && $uid == $owner_id){ ?>
        <?php if($totalbid!=0){ ?>
        <ul class="pull-right sorting">
          <li><span><?php echo strtoupper(__('jobdetails_sort_by','SORT BY')); ?>:</span></li>
          <li><a href="<?php echo base_url('jobdetails/details/'.$pid)?>?sort=bid&sortval=desc"><?php echo __('jobdetails_bid_amount_h_l','Bid Amount (H-L)'); ?></a></li>
          <li><a href="<?php echo base_url('jobdetails/details/'.$pid)?>?sort=bid&sortval=asc"><?php echo __('jobdetails_bid_amount_l_h',''); ?></a></li>
          <li><a href="<?php echo base_url('jobdetails/details/'.$pid)?>?sort=rating&sortval=desc"><?php echo __('jobdetails_ratings','Ratings'); ?></a></li>
        </ul>
        <?php } ?>
        <?php } ?>
        <?php /* if(count($bid_details) > 0){ */ ?>
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" href="#all_propasal" aria-controls="all_propasal" role="tab" data-toggle="tab"><?php echo __('jobdetails_all_proposals','All Proposals'); ?></a></li>
		  <li class="nav-item"><a class="nav-link" href="#invited_users" aria-controls="shortlisted_proposal" role="tab" data-toggle="tab"><?php echo __('jobdetails_invited','Invited'); ?></a></li>
          <?php if(isset($uid) && $uid == $owner_id){ ?>
          <li class="nav-item" style="display:none;"><a class="nav-link" href="#hidden_proposal" aria-controls="hidden_proposal" role="tab" data-toggle="tab"><?php echo __('jobdetails_hidden','Hidden'); ?> </a></li>
          <li class="nav-item" style="display:none;"><a class="nav-link" href="#shortlisted_proposal" aria-controls="shortlisted_proposal" role="tab" data-toggle="tab"><?php echo __('jobdetails_shortlisted','Shortlisted'); ?></a></li>
          
          <?php } ?>
        </ul>
        <?php /* } */ ?>
        <div class="tab-content">
          <div class="listings-container tab-pane fade show active" id="all_propasal" role="tabpanel">
            <?php 
	 $currentbidder_id=explode(",",$this->auto_model->getFeild('chosen_id','projects','project_id',$pid));
	 $bidder_arr = $bidder_id=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$pid));
  foreach($bid_details as $row){
	
		$bidder_acc_status = $this->auto_model->getFeild('status','user','user_id',$row['bidder_id']);
		if($bidder_acc_status != 'Y'){
		  continue;
		}
		
	  $bidder_details=$this->jobdetails_model->getuserdetails($row['bidder_id']);
	   $bidder_details[0]=filter_data($bidder_details[0]);
	  
	  $count_project= get_freelancer_project($row['bidder_id'], 'C');
	  $count_totalproject=$this->findtalents_model->countTotalProject_professional($row['bidder_id']);
	
      
?>
            <div class="job-listing proposal-list propal_<?php echo $row['id'];?>">
            <div class="job-listing-details">
                  <div class="job-listing-company-logo mr-3"> <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $row['bidder_id']?>">
                    <?php 
        if($bidder_details[0]['logo']!=""){ 
			if(file_exists('assets/uploaded/cropped_'.$bidder_details[0]['logo'])){
				$bidder_details[0]['logo']="cropped_".$bidder_details[0]['logo'];
			}
      ?>
                    <img src="<?php echo VPATH."assets/uploaded/".$bidder_details[0]['logo'];?>" alt="..." class="rounded-circle">
                    <?php  
        } else{ 
      ?>
                    <img src="<?php echo VPATH;?>assets/images/user.png" alt="" class="rounded-circle">
                    <?php } ?>
                    </a> </div>
        
               <div>
                <div class="job-listing-description">
                    <h4 class="job-listing-title"><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $row['bidder_id']?>"><?php echo $bidder_details[0]['fname']." ".$bidder_details[0]['lname'];?>
                      <?php if($project[0]['status']=="F" && in_array($row['bidder_id'],$currentbidder_id)){ ?>
                      <img src="<?php echo VPATH;?>assets/images/tick.png" alt="Selected"  title="<?php echo __('jobdetails_select_freelancer','Selected Freelancer'); ?>"  />
                      <?php  } ?>
                      <?php if(isset($uid)){ if($uid==$owner_id){ ?>
                      <a href="<?php echo VPATH;?>message/browse/<?php echo $pid;?>/<?php echo $row['bidder_id'];?>"><i class="fa fa-comments ml-4"></i> Chat</a>
                      <?php } else{ ?>
                      <?php } } ?>
                      </a> </h4>
                      
                    <?php 
      
       
       $slogan = $this->auto_model->getFeild('slogan','user','user_id',$bidder_details[0]['user_id']);
       /* $total_earning = $this->clientdetails_model->get_total_earning($bidder_details[0]['user_id']); */
       $total_earning = get_earned_amount($bidder_details[0]['user_id']);
     ?>
                    <p class="bio"><?php echo get_user_city($row['bidder_id']); ?></p>
                    <div class="star-rating" data-rating="<?php echo get_user_rating($row['bidder_id']); ?>"></div>
                    <div class="button-in-action clearfix">
                    <?php /*?><?php if(isset($uid)){ if($uid==$owner_id){ ?>
     <a href="<?php echo VPATH;?>message/index/0/<?php echo $row['bidder_id'];?>/<?php echo $pid;?>"><img src="<?php echo VPATH;?>assets/images/conversation.png" style="height:25px; width:25px;"></a><?php */?>
                    <?php  
      if(isset($uid) && $uid==$owner_id){
		
       if($project[0]['status']=="O" || $project[0]['status']=="F" || ($project[0]['project_type'] == 'H' && $project[0]['no_of_freelancer'] > count($bidder_arr))) {  /* //get_print($bidder_arr, false); echo $row['bidder_id']; */  ?>
                    <?php if(in_array($row['bidder_id'],$bidder_arr)){ ?>
                    <input type="button" value="Awarded" class="hidden btn btn-default">
                    <?php }else{ ?>
                    
					<?php if($row['bidder_amt'] > 0){ ?>
                    <button type="button" class="btn btn-sm btn-primary hire_sec_<?=$row['bidder_id']?>" onclick="setFreelancer('<?php echo $row['bidder_id']?>', '<?php echo $bidder_details[0]['fname']." ".$bidder_details[0]['lname'];?>', this);" data-escrow-enabled="<?php echo $row['enable_escrow']; ?>" data-href="<?php echo base_url('jobdetails/check_milestone/'.$row['id']); ?>" data-bid-id="<?php echo $row['id']; ?>">Award</button>
					
                    <?php } } ?>
                    <?php } 
     } 
     ?>
                    <?php
if(isset($uid) && $uid==$owner_id){
		if($project[0]['project_type'] == 'F'){
			if($row['bidder_amt'] > 0 && !in_array($row['bidder_id'],$bidder_arr)){
				/* echo '<a href="#" data-toggle="modal" data-target="#milestone" class="btn btn-sm btn-info show_milestone" data-href="'.base_url('jobdetails/viewmilesone/'.$row['id']).'" data-bid-id="'.$row['id'].'">Request New Bid</a>'; */
				echo '<a href="#" data-toggle="modal" data-target="#requestnewmilestone" class="btn btn-sm btn-info set_bid_id" data-href="'.base_url('jobdetails/viewmilesone/'.$row['id']).'" data-bid-id="'.$row['id'].'">Request New Bid</a>';
			}
			
		}
}
 ?>
                    <?php 	
	if(isset($uid) && $uid==$row['bidder_id']){
		if($project[0]['project_type'] == 'F'){
			if(!empty($row['note'])){
				/* echo '<a href="#" data-toggle="modal" data-target="#view_client_msg" id="view_client_msg_button" data-client-msg="'.htmlentities($row['note']).'" data-toggle="tooltip"><i class="zmdi zmdi-flag" data-toggle="tooltip" data-placement="bottom" data-original-title="Milestone" title="'.__('jobdetails_milestone','Milestone').'"></i></a>'; */
			}
			
		}
	}
 ?>
                    <?php if((isset($uid) && $uid == $owner_id) && !in_array($row['bidder_id'],$bidder_arr)){ ?>
                    <span class="proposal_action_button"> <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="moveToHidden('<?php echo $row['id'];?>', this)"><?php echo __('jobdetails_not_interest','Not interested'); ?></a>
                    <a href="javascript:void(0);" class="btn btn-sm btn-success" onclick="moveToShortlist('<?php echo $row['id'];?>', this)"><?php echo __('jobdetails_shortlist','Shortlist'); ?></a> </span>
                    <?php } ?>
                    
					
					<?php 
					$duration = '';
					if($project[0]['project_type'] == 'H'){
						$duration = $row['available_hr'] . ' hrs'; 
					}else{
						$duration = $row['days_required'] . ' days';
					}
					
					?>
                    </div>
					<p class="hide"><b>Provide Update:</b> <?php echo !empty($row['update_status']) ? $row['update_status'] : 'N/A'; ?></p>                   
					
                  </div>
                  <ul class="skills mb-2">
                    <?php 
		  $skill_list = $this->dashboard_model->getUserSkills($row['bidder_id']);
		
          if(!empty($skill_list) AND count($skill_list) > 0){ 
			foreach($skill_list as $key => $s){ 
                $sname=$s['skill'];             
          
        ?>
                    <li><a href="javascript:void(0);"><?php echo $sname;?></a></li>
                    <?php
           }       
          }
          else{ 
        ?>
                    <li><a href="#"><?php echo __('jobdetails_skills_not_set_yet','Skill Not Set Yet'); ?></a></li>
                    <?php  
          }
       ?>
                  </ul>
               </div>
              
				  <?php /*if(($uid == $row['bidder_id']) || ($uid == $project[0]['user_id'])){ ?>
					<?php if($row['enable_escrow'] == 1){ ?>
					<p class="text-center"><span class="label label-success">Escrow Enabled</span></p>
				  <?php  } }*/  ?>
				
                  <div class="text-md-right ml-sm-auto">
                    <?php
   if($project[0]['status']=="P" && in_array($row['bidder_id'],$bidder_id)) { ?>
                    <img src="<?php echo VPATH;?>assets/images/awarded.png" alt="Award" title="<?php echo __('jobdetails_job_awarded','Job Awarded'); ?>" class="award" />
                    <?php 
        }			
		
	?>
					
                    
                    <?php 
						$count_totalproject =  $count_totalproject == 0 ? 1 : $count_totalproject ;
						$success_prjct = (int) $count_project * 100 / (int) $count_totalproject;
        ?>
                    <div hidden class="circle-bar position" data-percent="<?php echo round($success_prjct);?>" data-duration="1000" data-color="#dedede,#29b6f6"></div>
                    <p hidden><?php echo __('jobdetails_job_success','Job Success'); ?><br>
                      <?php echo CURRENCY;?> <b><?php echo $bidder_details[0]['hourly_rate'];?> / hr</b><br>
					  </p>
					  <p><?php echo __('jobdetails_compleated_projects','Completed Project'); ?>: <b><?php echo $count_project;?></b></p>
                      <p><?php echo __('jobdetails_amount_earned','Amount Earned'); ?>: <b><?php echo CURRENCY. ' '.format_money($total_earning,TRUE); ?> </b> </p>
                  </div>
                

			  </div>
              <div class="job-listing-footer">              
              	<ul>
                	<?php  if((isset($uid) && $uid==$owner_id) || (isset($uid) && $uid==$row['bidder_id'])){ ?>
                    <li><?php echo __('jobdetails_bid_amount','Bid Amount'); ?>: <b><?php echo $row['total_amt'] > 0 ? CURRENCY . ' '.format_money(($row['bidder_amt']+$row['admin_fee'])) : 'Awaiting Bid Revision!';?></b></li>
                    <?php }else{  ?>
					<li><b><?php echo __('jobdetails_bid_amount','Bid Amount'); ?>:</b> <img src="<?php echo IMAGE;?>lock.png" width="30"/></li>
					<?php } ?>
                	<li><?php echo __('jobdetails_submitted_on','Submitted on'); ?>: <b><?php echo date("d F Y",strtotime($row['add_date']));?></b></li>
                    <li><span><?php echo __('jobdetails_duration','Duration'); ?>: <b><?php echo $duration; ?> </b></span></li>
                    <li><span><?php echo __('jobdetails_attachment','Attachment'); ?>:</span> <b><?php if($row['attachment']!="" && isset($uid) && ($uid==$owner_id || $uid==$row['bidder_id'])) { ?>
                      <a href="<?php echo VPATH;?>assets/jobbid_upload/<?php echo $row['attachment']; ?>" target="_blank"><?php echo __('jobdetails_available','Available'); ?></a>
                      <?php }else{ echo 'N/A'; }?></b></li>

                </ul>
              </div>
			  <?php /* if(($uid == $row['bidder_id']) || ($uid == $project[0]['user_id'])){ ?>
			  <div class="row">
				<div class="col-sm-12">
					<h3>Cover Letter</h3>
					<p><?php echo $row['details'];?></p>
					
					<?php
					$employer_question = $this->db->where('project_id', $project[0]['project_id'])->get('project_questions')->result_array();
					if(count($employer_question) > 0){
						foreach($employer_question as $qs){
							$freelancer_answer_row = $this->db->where(array('question_id' => $qs['question_id'], 'freelancer_id' => $row['bidder_id']))->get('project_answers')->row_array();
							
							echo '<b>'.$qs['question'].'</b>';
							echo '<p>';
							echo !empty($freelancer_answer_row['answer']) ? $freelancer_answer_row['answer'] : 'Not answered';
							echo '</p>';
						}
					}
					?>
					
				</div>
			  </div>
			  <?php } */ ?>
			  
            </div>
            <?php } ?>
          </div>
          <div class="listing tab-pane fade" id="hidden_proposal" role="tabpanel">
            <h4 class="title-sm"><?php echo __('jobdetails_hidden','Hidden'); ?></h4>
            <div class="content_hidden_proposal"></div>
          </div>
          <div class="listing findtalent tab-pane fade" id="shortlisted_proposal" role="tabpanel"> 
            <!--<h4 class="title-sm">Shortlisted</h4>-->
            <div class="content_shortlisted_proposal"> </div>
          </div>
		  
		   <div class="listing findtalent tab-pane fade" id="invited_users" role="tabpanel"> 
            <!--<h4 class="title-sm">Shortlisted</h4>-->
            <div class=""> 
				<?php 
				$all_invited = get_results(array('select' => '*', 'from' => 'new_inviteproject', 'where' => array('project_id' => $project[0]['project_id'])));
				if(count($all_invited) > 0){ foreach($all_invited as $k => $v){
				$user_det = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $v['freelancer_id'])));
				$pic = base_url('assets/images/user.png');
				if(!empty($user_det['logo'])){
					$pic = base_url('assets/uploaded/'.$user_det['logo']);
					if(file_exists('./assets/uploaded/cropped_'.$user_det['logo'])){
						$pic = base_url('assets/uploaded/cropped_'.$user_det['logo']);
					}
				}
				
			  $flag=$this->auto_model->getFeild("code2","country","Code",$user_det['country']);
			   $flag=  strtolower($flag).".png";
			   $bidder_city = $user_det['city'];
			   if(is_numeric($user_det['city'])){
				   $bidder_city = getField('Name', 'city', 'ID', $bidder_city);
			   }
				 $contry_info="";
			 
			   if($bidder_city!=""){ 
				   $contry_info.=$bidder_city.", ";
			   } 
			   $contry_info.$user_det['country'];
	   
				?>
				<div class="media">
					<div class="media-left mr-3">
						<img class="media-object" src="<?php echo $pic; ?>" alt="">
					</div>
					<div class="media-body">
						 <h4 class="media-heading">
							 <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $user_det['user_id']; ?>"><?php echo $user_det['fname']." ".$user_det['lname'];?>
							 </a> 
						 </h4>
						 <p class="bio"><?php echo get_user_city($user_det['user_id']); ?></p>
					</div>
				</div>
				<?php } }else{ ?>
				No invited freelancers
				<?php } ?>
				
				
			</div>
          </div>
        </div>
       
		<?php if($this->session->userdata('user')){ ?>
		<!-- question answer section -->
		
		<div data-ajaxify="<?php echo base_url('jobdetails/question_anwser?project_id='.$project[0]['project_id']);?>"></div>
		
		<!-- question answer section -->
		<?php } ?>
		
		
		
		
		
		
    </div>
    <div class="col-lg-3 col-12 dpl-0">    	
        
        <div class="card"> 
          <div class="card-header"><h4><?php echo __('jobdetails_about_customer','About Customer'); ?></h4></div>
          <div class="card-body c_details">
            <div class="profile">
              <div class="profile_pic"> <span>
                <?php
	if($user[0]['logo']!='')
	{
	if(file_exists('assets/uploaded/cropped_'.$user[0]['logo'])){
		$user[0]['logo']= "cropped_".$user[0]['logo'];
	}
	?>
                <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $user[0]['user_id'];?>"><img src="<?php echo VPATH;?>assets/uploaded/<?php echo $user[0]['logo'];?>"></a>
                <?php	
	}
	else
	{
	?>
                <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $user[0]['user_id'];?>"><img src="<?php echo VPATH;?>assets/images/user.png"></a>
                <?php	
	}
	?>
                </span> </div>
            </div>
            
            <div class="profile-details text-center">
              <h4><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $user[0]['user_id'];?>"><?php echo $user[0]['fname']." ".$user[0]['lname'];?></a></h4>
			  <div class="star-rating" data-rating="<?php echo get_user_rating($user[0]['user_id']); ?>"></div>
              
              <p><i class="icon-feather-map-pin"></i> <?php echo get_user_city($user[0]['user_id']); ?></p>
              <h5><?php echo __('jobdetails_job_posted','Jobs Posted'); ?></h5>
              <h3><?php echo $user_totalproject;?></h3>
              <div class="spacer-10"></div>
              <h5><?php echo __('jobdetails_completed_projects','Completed Projects'); ?></h5>
              <h3><?php echo $user[0]['com_project'];?></h3>
              <div class="spacer-10"></div>
              <h5><?php echo __('jobdetails_total_spent','Total Spent'); ?></h5>
              <h3><?php echo CURRENCY;?><?php echo format_money(get_project_spend_amount($user[0]['user_id']),TRUE);?></h3>
			  
            </div>
          </div>
        </div>
        
        <!-- similar jobs -->
          <?php
			$simjobs=$this->auto_model->getSimilarJobs('C',$project[0]['category'],$project[0]['project_id']);
			?>
       <div class="card"> 
          <div class="card-header"><h4 class="title-sm"><?php echo __('jobdetails_similar_jobs','Similar Jobs'); ?></h4></div>     
          <div class="card-body">
          <ul class="list-group list-group-x">
            <?php
			if(count($simjobs) > 0){ foreach($simjobs as $k => $v){ ?>
            <li><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $v['project_id'];?>"><?php echo ucwords($v['title']);?></a></li>
            <?php } }  ?>
          </ul>
		  </div>
		</div>
           <!-- / similar jobs -->

      </div>
      </div>
  </aside>
      <!--ProjectDetails Left End-->
      
      
	  

<!-- modals -->
	  
<div id="milestone" class="modal fade" role="dialog">
<div class="modal-dialog"> 
  
  <!-- Modal content-->
  <div class="modal-content">
	<div class="modal-header">
      <h5 class="modal-title">Bid Info</h5>
	  <button type="button" class="close" onclick="$('#milestone').modal('hide');">&times;</button>
	</div>
	<div class="modal-body" id="milestone_body">
	  <p>Some text in the modal.</p>
	</div>
	<div class="modal-footer">
	 <?php if($project[0]['status'] == 'O'){  ?>
	  <button type="button" class="btn btn-site" data-toggle="modal" data-target="#requestnewmilestone" onclick="$('#milestone').modal('hide');">Request New Bid</button>
	  <?php } ?>
	  <button type="button" class="btn btn-warning" onclick="$('#milestone').modal('hide');">Close</button>
	</div>
  </div>
</div>
</div>

<div id="view_client_msg" class="modal fade" role="dialog">
<div class="modal-dialog"> 
  <!-- Modal content-->
  <div class="modal-content">
	<div class="modal-header">
    <h5 class="modal-title">Change Milestone Request</h5>
	  <button type="button" class="close" onclick="$('#view_client_msg').modal('hide');">&times;</button>
	  
	</div>
	<div class="modal-body" id="client_msg_body">
	  <p>Some text in the modal.</p>
	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default" onclick="$('#view_client_msg').modal('hide');">Close</button>
	</div>
  </div>
</div>
</div>

<div id="requestnewmilestone" class="modal fade" role="dialog">
<div class="modal-dialog"> 
  
  <!-- Modal content-->
  <div class="modal-content" style="border-radius:0px;">
	<form action="" method="post" id="request_new_milestone_form">
	  <div class="modal-header">
      <h5 class="modal-title">Request New Bid</h5>
		<button type="button" class="close" onclick="$('#requestnewmilestone').modal('hide');">&times;</button>
		
	  </div>
	  <div class="modal-body" id="request_milestone_body">
		<input type="hidden" name="requested_bid_id" value=""/>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Bid Amount" name="bid_amount_request"/>
		</div>
		<div class="form-group">
			<textarea class="form-control" placeholder="Enter your comment here to request new milestone.." name="client_comment" maxlength="50"></textarea>
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="submit" class="btn btn-site" id="request_milestone_submit">Send Request</button>
		<button type="button" class="btn btn-warning" onclick="$('#requestnewmilestone').modal('hide');">Close</button>
	  </div>
	</form>
  </div>
</div>
</div>
<!-- / modals -->	
    </div>
    <!-- Main Content end--> 
    
  </div>
</section>
<div class="clearfix"></div>


<!-- Modal -->
<div id="hireFreelancer" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Award Contractor</h5>
        <button type="button" class="close" data-dismiss="modal" onclick="$('#hireFreelancer').modal('hide'); $('#hireResponse').html('');">&times;</button>        
      </div>
      <div class="modal-body">
        <p>Are you sure to award this job to <b><span id="choosen-flancer">Demo user</span></b> ? </p>
		<p class="note" id="is_enabled_escrow_para" hidden></p>
		<hr/>
		
		<div class="alert alert-primary" role="alert">
		 This amount will be deposited to secure admin account until job is complete and accepted by customer. The amount shall show as "On Hold" in customer wallet 
		</div>

		<div id="milestone_body_new">
        <p> Loading .. </p>
		  </div>
        <span id="hireResponse"></span> 
		</div>
      <!--<div class="modal-footer" id="hire_div">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#hireFreelancer').modal('hide'); $('#hireResponse').html('');">Cancel</button>
        <button type="button" class="btn btn-primary" id="accept-freelancer-btn">Accept</button>
      </div>-->
    </div>
  </div>
</div>

<div class="modal fade" id="inviteModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
       <div class="modal-header">
       		<h5 class="modal-title"><?php echo __('jobdetails_invite_contractor_to_this_project','Invite Contractor To this Project'); ?></h5>
			<button type="button" class="close" data-dismiss="modal" onclick="$('#inviteModal').modal('hide');">&times;</button>			
      </div>
      <div class="modal-body">
        <form  id="invite_user_form" method="post" class="form-horizontal">
          <input type="hidden" name="project_id" value="<?php echo $project[0]['project_id'];?>"/>
          <div class="ui fluid selection dropdown">
            <input type="hidden" name="user">
            <i class="dropdown icon"></i>
            <input type="text" class="form-control" placeholder="<?php echo __('jobdetails_search_user_by_name_or_email','Search user by name or email'); ?>" onkeyup="search_freelancer(this.value)"/>
            <div class="menu" id="freelancer_list" style="display:none"></div>
            <div class="menu" id="selected_freelancer_list" style="display:none"></div>
          </div>
          <div class="text-right">
            <button type="button" class="btn btn-site" id="invite_user_button" style="margin-top:20px" disabled><?php echo __('jobdetails_invite','Invite'); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">My Bid</h5>
        <button type="button" class="close close_link" data-dismiss="modal" aria-hidden="true" onclick="javascript:$('#myModal').modal('hide')">&times;</button>
        
      </div>
      <div class="modal-body">
        <?
      
				if($apprivestatus=='Y'){
      ?>
        <div class="browse_contract_right_box">
          <div class="success alert-success alert" style="display:none">Your message has been sent successfully.</div>
          <span id="agree_termsError" class="rerror error alert-error alert" style="display:none"></span>
          <input type="hidden" value="PlaceBid" name="submits">
          <input type="hidden" value="1405472863" id="projectid_hid_id" name="projectid_hid">
          <input type="hidden" value="P" id="bid_commitype_hid_id" name="bid_commitype_hid">
          <input type="hidden" value="5.00" id="bid_commission_hid_id" name="bid_commission_hid">
          <input type="hidden" value="" id="site_fee_hid_id" name="site_fee_hid">
          <?php 
       if(isset($uid) && $user[0]['user_id']!=$uid){
        $attributes = array('id' => 'bidjob_frm','class' => '','role'=>'form','name'=>'bidjob_frm','onsubmit'=>"disable");
        echo form_open('', $attributes);          
    ?>
          <div class="browse_contract_right form-horizontal" id="proposal_div">
            <div class="cost_timing">
              <div class="form-group">
                  <input type="hidden" name="pid" value="<?php echo $project[0]['project_id']?>">
                  <input type="hidden" name="bid" value="<?php echo $uid;?>">
                  <input type="hidden" name="project_type" value="<?php echo $project[0]['project_type'];?>"/>
				  
                  <label>Comments</label>
                  <textarea rows="" cols="" name="details" id="details" class="form-control"><?php if($revised_user){echo $revised_data[0]['details'];}?></textarea>
                  <span id="detailsError" class="rerror" style="float: left;"></span> 
              </div>
              <div class="form-group">
                  <label>My Bid</label>
                  <input type="text" onkeypress="return isNumberKey(event)" onblur="getbid(this.value);" value="<?php if($revised_user){echo $revised_data[0]['bidder_amt'];}?>" size="6" maxlength="6" id="client_bidamount" name="bidder_amt" class="form-control">
                  <span id="client_bidamountError" class="rerror" style="float: left;"></span> <span style="float: left;">Note: If the project pays hourly enter hourly rate here, otherwise enter total charge</span> 
              </div>
              <!--   <div class="form-group">
                    <h1><b>+ <?php echo $bidwin_charge;?>% Jobbid Fee : <span id="comission">$</span></b></h1>
                    <input type="text" readonly value="" size="3" maxlength="3" id="comission" name="comission" class="form-control">                   
                </div>-->
              <div class="form-group" style="display:none;">
                
                  <label>Charged to Client </label>
                  <input type="text" readonly value="<?php if(isset($uid) && $revised_user){echo $revised_data[0]['total_amt'];}?>" size="6" maxlength="6" id="bidamount" name="total_amt" class="form-control">
                
              </div>
              <?php if($project[0]['project_type']=='F'){ ?>
              <div class="form-group">         
                  <label>Days Required</label>
                  <input type="text" value="<?php if($revised_user){echo $revised_data[0]['days_required'];}?>" size="6" maxlength="3" name="days_required" id="delivery" class="form-control">
                  <span id="deliveryError" class="rerror" style="float: left;"></span> 
              </div>
              <?php
				  }
				?>
              <div class="form-group">
                  <div class="input-group">
                    <label class="input-group-btn"> <span class="btn btn-site btn-file"> Browse&hellip;
                      <input type="file" style="display: none;" id="userfile" name="userfile" onchange="movebidfile(this)">
                      </span> </label>
                    <input type="hidden" id="upload_file1" name="upload_file1" value="" >
                    <input type="text" class="form-control" readonly>
                  </div>
              </div>
              <!--<div class="form-group">
                <input type="file" class="browseimg-input" id="userfile" name="userfile" onchange="movebidfile(this)" />
                <input type="hidden" id="upload_file1" name="upload_file1" value="" >    
                
                 </div>-->
              
              <div class="acount_form">
                <input id="submit-check" class="btn btn-site" type="button" value="Apply to this Job" onclick="bid_valid()">
              </div>
            </div>
          </div>
          </form>
          <?php 
    }
  ?>
        </div>
        <? }else{?>
        <div class="alert alert-danger" style="width:100%">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> Your account not approve yet for bid on job. </div>
        <? }?>
      </div>
    </div>
  </div>
</div>


<script>
var LOADER = '<img src="<?php echo base_url('assets/img/loader.gif');?>" width="22"/>';


	function setFreelancer(bidder, f, ele){
		var $ = jQuery;
		$('#accept-freelancer-btn').removeAttr('disabled');
		$('#accept-freelancer-btn').html('Accept');
		var p_link = '<?php echo base_url('clientdetails/showdetails')?>/'+bidder;
		var is_escrowed = $(ele).data('escrowEnabled');
		$('#accept-freelancer-btn').attr("onclick", "prvdHire(this, '"+bidder+"')");
		$('#choosen-flancer').html('<a href="'+p_link+'" target="_blank">'+f+'</a>');
		$('#hireFreelancer').modal('show');
		if(is_escrowed == 1){
			$('#is_enabled_escrow_para').html('Escrow is enabled for this bid . If you approve this bid then milestone amount will be escrowed from your wallet.');
		}else{
			$('#is_enabled_escrow_para').html('');
		}
		
		var url = $(ele).attr("data-href");
		console.log(url);
		$('#milestone_body_new').html('Loading...');
		$.get(url , function(res){
			$('#milestone_body_new').html(res);
		});
			
	}

	/*$(function() {

		$( ".datepicker" ).datepicker();

	});*/
	
	function call_datepicker(){
		$('.datepicker').datetimepicker({
			format: 'YYYY-MM-DD',
		});

	}


	var count_row = 1;
	jQuery(document).ready(function($){
		
		$('#view_client_msg_button').click(function(){
			var msg = $(this).attr('data-client-msg');
			$('#client_msg_body').html(msg);
		});
		
		$('#request_milestone_submit').click(function(e){
			e.preventDefault();
			var ele = $(this);
			
			var data = $('#request_new_milestone_form').serialize();
			var $form = $('#request_new_milestone_form');
			var errors = '';
			if($form.find('[name="bid_amount_request"]').val().trim() == ''){
				errors += '<div>Please enter bid amount</div>';
			}
			if($form.find('[name="client_comment"]').val().trim() == ''){
				errors += '<div>Please enter comment</div>';
			}
			
			if(errors.length > 0){
				$.alert({
					title : 'Error !',
					content: '<div><b>Please Fix the following errors :</b></div>' + errors,
					type: 'red'
				});
				
				return;
			}
			ele.attr('disabled', 'disabled');
			$.ajax({
				url : '<?php echo base_url();?>jobdetails/request_new_milestone',
				data: data,
				type: 'POST',
				beforeSend: function(){
					$(ele).html('Requesting...');
				},
				success: function(res){
					ele.removeAttr('disabled');
					ele.html('Send Request');
					$('#request_milestone_body').html(res);
					location.reload();
				}
			});
		});
		
		$('.set_bid_id').click(function(){
			
			$('input[name="requested_bid_id"]').val($(this).attr('data-bid-id'));
			
		});
		
		$('.show_milestone').click(function(){
			var url = $(this).attr("data-href");
			$('#milestone_body').html('Loading...');
			$('input[name="requested_bid_id"]').val($(this).attr('data-bid-id'));
			$.get(url , function(res){
				$('#milestone_body').html(res);
			});
		});
		
		$('#add_more_milestone').click(function(){
			var html = '<div class="row-10" id="row_'+count_row+'"><div class="col-sm-4 col-12"><div class="form-group"><label for="title">Milestone Title</label><input type="text" name="title[]"  class="form-control required"/></div></div><div class="col-sm-4 col-12"><div class="form-group"><label for="date">Due Date</label><div class="input-group datepicker"><input type="text" name="date[]" class="form-control datepicker required" /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div><div class="col-sm-3 col-12"><div class="form-group"><label for="amount">Amount</label><input type="text" name="amount[]" class="form-control required" onkeypress="return isNumberKey(event)" oninput="checkAmountByMilestone()"/></div></div><div class="col-sm-1"><label style="display: block">&nbsp;</label><a href="javascript:void(0);" class="close_milestone" data-close="row_'+count_row+'"><i class="zmdi zmdi-close-circle"></i></a></div></div>';
			$('#milestone_wrapper').append(html);
			count_row++;
			call_datepicker();
		});
		
		$(document).on('click', '.close_milestone', function(e){
			e.preventDefault();
			var id = $(this).attr('data-close');
			$('#'+id).remove();
			checkAmountByMilestone();
		});
		
		$('#save_bid').click(function(e){
			e.preventDefault();
			var err = 0;
			var field_data = $('.required').not(':disabled');
	
			field_data.each(function(){
				var f_val = $(this).val();
				if (f_val == ''){
					err = 1;
				}
			});
			
			if(err > 0){
				alert('Please enter valid data');
				return;
			}
			
			var data = $('#bid_form').serialize();
			if(data != ''){
				$.ajax({
					url : '<?php echo VPATH;?>'+'jobdetails/save_bid',
					data: data,
					type: 'POST',
					dataType: 'json',
					beforeSend: function(){
						$('#save_bid').html('Saving...');
						$('#save_bid').attr('disabled', 'disabled');
					},
					success: function(res){
						
						if(res.status  == 1){
							location.reload();
						}else{
							
							for(var i in res.errors){
								
								$('#'+i+'Error').html(res.errors[i]);
							}
							
						}
						
						$('#save_bid').html('Submit');
						$('#save_bid').removeAttr('disabled');
						
					}
				});
			}
		});
		
		
		$('.revised_bid_button,#bid_now_button').click(function(e){
			e.preventDefault();
			
			$('#new_bid_panel').slideToggle();
			var offset_top = $('#new_bid_panel').offset().top-80;
			/*$(window).scrollTop(offset_top);*/
			 $('html, body').animate({
				scrollTop: offset_top
			 });
		});
		
	});
	
	function moveToHidden(proposal_id, ele){
		var $ = jQuery;
		var p = $('#all_propasal .propal_'+proposal_id).clone();
		p.find('.proposal_action_button').html('<a href="javascript:void(0);" class="round-button btn-del" title="Show" onclick="removeFromHidden(\''+proposal_id+'\')"><i class="zmdi zmdi-delete"></i></a>');
		$('.content_hidden_proposal').append(p);
		$('#all_propasal .propal_'+proposal_id).hide();
		$('[href="#hidden_proposal"]').parent().show();
		
	}
	
	function removeFromHidden(proposal_id){
		var $ = jQuery;
		$('#all_propasal .propal_'+proposal_id).show();
	
		$('#hidden_proposal .propal_'+proposal_id).remove();
		if($('.content_hidden_proposal .media').length == 0){
			$('[href="#hidden_proposal"]').parent().hide();
			$('[href="#all_propasal"]').click();
		}
		
		
	}
	
	function moveToShortlist(proposal_id, ele){
		var $ = jQuery;
		var p = $('#all_propasal .propal_'+proposal_id).clone();
		p.find('.proposal_action_button').html('<a href="javascript:void(0);" class="btn btn-sm btn-success active unshortlist" title="Unshortlist" onclick="removeFromShortlist(\''+proposal_id+'\', this)" data-toggle="tooltip" data-placement="bottom" title="Unshortlist">Unshortlist</a>');
		$('.content_shortlisted_proposal').append(p);
		if(ele != undefined){
			$(ele).addClass('unshortlist active');
			$(ele).attr("onclick", "removeFromShortlist('"+proposal_id+"', this)");
			$(ele).html("Unshortlist");
		}
		$('[href="#shortlisted_proposal"]').parent().show();
	}
	
	function removeFromShortlist(proposal_id){
		var $ = jQuery;
		
		$('.propal_'+proposal_id).find('.unshortlist.active').attr("onclick", "moveToShortlist('"+proposal_id+"', this)");
		$('.propal_'+proposal_id).find('.unshortlist.active').html('Shortlist');
		$('.propal_'+proposal_id).find('.unshortlist.active').removeClass('active unshortlist');
		
		$('.content_shortlisted_proposal').find('.propal_'+proposal_id).remove();
		if($('.content_shortlisted_proposal .media').length == 0){
			$('[href="#shortlisted_proposal"]').parent().hide();
			//$('[href="#all_propasal"]').parent().addClass('active');
			//$('[href="#all_propasal"]').trigger('click');
			$('[href="#all_propasal"]').click();
		}
	}
	
</script> 
<script>
//document.getElementById('main').click(alert("HH"));

	
  function askquestion(){         
    $("#proposal_div").hide();
    $("#askquestion_div").slideToggle('slow');
     
  }  
  
  function bid(){ 
    $("#askquestion_div").hide();
    $("#proposal_div").slideToggle('slow');
    
  }  
  
  function getbid(v){ 
    if(v!=""){
        var charges=<?php echo $bidwin_charge;?>;
        var amt=parseFloat(v)+parseFloat(((v*charges)/100));
        var com = parseFloat(((v*charges)/100));
        $("#bidamount").val(amt);
        $("#comission").html(com);
    }
  }
   function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if(charCode=='46'){
			 return true;
		}else if (charCode > 31 && (charCode < 48 || charCode > 57)){
           return false;
        }
        else{
          return true;
        }
   }
   
  function movefile2(evt){ 
     		$("#upimg").show();
             $.ajaxFileUpload({
                 url:'<?php echo VPATH;?>jobdetails/test/',
                 secureuri:false,
                 fileElementId:'attachment',
                 dataType: 'json',              
                 success: function (data){                       
                    $("#upload_file").val(data.msg);
					$("#upimg").hide();
					 $("#flname").html("File: "+data.msg);
                    
                  //   $("#upload_file").val(data.msg);   
                 }
         });
        
    }

 function addMore(){ 
   
   var c=parseInt($("#div_count").val())+1;
   $("#div_count").val(parseInt(c));   
 
   var v="<div class='form-group'><div class='invite_form' id='fname_div"+c+"'><div class=\"col-sm-6 col-12\"><input type='text' value='' name='fname[]' id='fname' class='form-control' placeholder='Friend&rsquo;s Name' ><div class='error-invite' id='fnameError'><?php echo form_error('fname');?></div></div></div><div class=\"col-sm-6 col-12\"><div class='invite_form' id='femail_div"+c+"'><img src='<?php echo ASSETS?>images/close-icon.png' style='float: right;margin-top: 10px;margin-bottom: -3px;position: absolute;right: 30px;' id='close"+c+"' onclick='removeMore("+c+")'><input type='text' id='femail' name='femail[]' value='' class='form-control' placeholder='Friend&rsquo;s Email' ><div class='error-invite' id='femailError'><?php echo form_error('femail');?></div></div></div></div>"; 
  $("#jbinvite").append(v);
}

function removeMore(v){ 
  var c=parseInt($("#div_count").val());  
  if(c>1){
    $("#fname_div"+v).remove();
    $("#femail_div"+v).remove();
    $("#close"+v).remove();
      c=parseInt($("#div_count").val()-1);
    $("#div_count").val(parseInt(c));      
  }   
}


/*function hidemessageboard(){ 
	$("#proposal_div").slideDown().hide();
	$("#askquestion_div").slideDown().hide();
}*/


</script> 
<script>
function movebidfile(evt){ 
      
        var n=document.getElementById('userfile').files[0];
       
        $.ajaxFileUpload({
            url:'<?php echo VPATH;?>jobdetails/bidtest/',
            secureuri:false,
            fileElementId:'userfile',
            dataType: 'json',
            data:{name:n.name, id:'id'},
            success: function (data){              
                var flist=data.msg;
                $("#upload_file").val(flist);                
                $("#flist_div").html("<div class='flisttext' id='sp_"+data.msg.replace(".","")+"'>"+data.msg+"<i class='zmdi zmdi-delete' onclick='removespan(this.id)' id='"+data.msg+"'></i></div>");
                
               // $("flist_div").text(data.msg);
                $("#flist_div").show();
                
            }
    });
      
     
  }
  function removespan(v)
{
	
	var dataString = 'img='+v;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>jobdetails/rmvimage/"+v,
     success:function(return_data)
     {
		$("#upload_file").val('');
		$('#sp_'+v.replace(".","")).remove();
      	
     }
    });	
}
</script> 
<script>
/* 
*Not in use any more :

function prvdHire(id)
{

        var dataString = 'userid='+id+'&projectid=<?php echo $pid?>&hire=1';
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/getProvider",
			 success:function(return_data)
			 {
				$('.hire_sec_'+id).before(return_data);
				$('.hire_sec_'+id).hide();
			 }
		});
    
}

*/
function prvdHire(ele, id)
{	
		if(typeof ele != 'undefined'){
			$(ele).attr('disabled', 'disabled');
			$(ele).html(LOADER);
		}
        var dataString = 'userid='+id+'&projectid=<?php echo $pid?>&hire=1';
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/getProvider",
			 dataType: 'json',
			 success:function(return_data){
				 
				if(return_data.status == 1){
					location.reload();
				}
				$('#hireResponse').html(return_data['msg']);
				
				/* if(return_data.status == 1){
					$('.hire_sec_'+id).hide();
					$('#hire_div').html('');
				} */
				
			 }
		});
    
}

$(".circle-bar").loading();
</script> 
<script src="<?php echo ASSETS;?>js/jquery.min.js"></script> 
<script src="https://checkout.stripe.com/checkout.js"></script>

<script>
$(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              //if( log ) alert(log);
          }

      });
  });
  
});
</script> 
<script>
$(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              //if( log ) alert(log);
          }

      });
  });
  
});
</script> 
<script>

function search_freelancer(val){
	$.get('<?php echo base_url('postjob/search_freelancer')?>?project_id=<?php echo $pid;?>&term='+val, function(res){
		$('#freelancer_list').show();
		$('#freelancer_list').html(res);
		checkInviteSelected();
	});
}

function checkInviteSelected(){
	var len = $('#selected_freelancer_list').find('.item.selected').length;
	if(len > 0){
		$('#invite_user_button').removeAttr('disabled');
	}else{
		$('#invite_user_button').attr('disabled', 'disabled');
	}
}

function setActive(e){
	var choosen_f = $(e).clone();
	var u_id = $(e).attr('data-user');
	if($(e).is('.selected')){
		$(e).remove();
		$('#freelancer_row_'+u_id).show();
		if($('#selected_freelancer_list').find('.item.selected').length == 0){
			$('#selected_freelancer_list').hide();
		}
	}else{
		choosen_f.addClass('selected');
		choosen_f.append('<input type="hidden" name="freelancer[]" value="'+u_id+'"/>');
		$('#freelancer_row_'+u_id).hide();
		$('#selected_freelancer_list').show();
		if($('#selected_freelancer_list').find('#freelancer_row_'+u_id).length == 0){
			$('#selected_freelancer_list').append(choosen_f);
		}
		
	}
	checkInviteSelected();
}

$(document).ready(function(){
$('#invite_user_button').click(function(e){
	e.preventDefault();
	$(this).attr('disabled', 'disabled');
	$(this).html('Sending...');
	var f = $('#invite_user_form'),
	data = f.serialize();
	if(f.find('input[name="freelancer[]"]').length == 0){
		alert("<?php echo __('jobdetails_please_choose_some_user_first','Please choose some user first'); ?>");
		$(this).removeAttr('disabled');
		$(this).html('Invite');
	}else{
		$.ajax({
			url : '<?php echo base_url('jobdetails/invite_user');?>',
			data: data,
			type: 'post',
			dataType: 'json',
			success: function(res){
				if(res.status == 1){
					f.html('<div class="alert alert-success"> <strong>Success!</strong> <?php echo __('jobdetails_invitation_successfully_send','Invitation successfully send'); ?></div>');
				}
			}
		});
	}
	
	
});

	$('[name="payment_at"]').change(function(){
		var val = $(this).val();
		
		if(val == 'P'){
			$('#payment_project_wrapper').show();
			$('#payment_milestone_wrapper').hide();
			$('#payment_milestone_wrapper').find('input').attr('disabled', 'disabled');
			$('#payment_project_wrapper').find('input').removeAttr('disabled');
		}else{
			$('#payment_project_wrapper').hide();
			$('#payment_milestone_wrapper').show();
			$('#payment_project_wrapper').find('input').attr('disabled', 'disabled');
			$('#payment_milestone_wrapper').find('input').removeAttr('disabled');
		}
	});
	
	
	
	$('[name="payment_at"]:checked').change();
	
	$('#required_days').blur(function(){
		var val = $(this).val();
		if(isNaN(val)){
			$(this).val(0);
		}
	});
	
});


function checkAmount(ele){
	var val  = parseFloat($(ele).val());
	if(isNaN(val)){
		val = 0;
	}
	var comm_percent = <?php echo SITE_COMMISSION; ?>;
	var comm = (val*(comm_percent/100));
	var to_pay = val + comm;
	$('#project_pay_amount').html('<?php echo CURRENCY;?>'+to_pay.toFixed(2));
	
	
}

function checkAmountByMilestone(){
	var val = 0;
	var p = $('#milestone_wrapper');
	p.find('[name="amount[]"]').each(function(){
		
		if(isNaN($(this).val())){
			$(this).val(0);
		}
		
		var f_val =  parseFloat($(this).val());
		
		if(isNaN(f_val)){
			f_val = 0;
		}
		val += f_val;
	});
	var comm_percent = <?php echo SITE_COMMISSION; ?>;
	var comm = (val*(comm_percent/100));
	var to_pay = val + comm;
	$('#milestone_pay_amt').html(to_pay.toFixed(2));
	
	
}

function checkAmountByHourly(){
	var val = parseFloat($('#total_amount').val());
	if(isNaN(val)){
		val = 0;
	}
	
	var comm_percent = <?php echo SITE_COMMISSION; ?>;
	var comm = (val*(comm_percent/100));
	var to_pay = val + comm;
	$('#hourly_pay_amt').html(to_pay.toFixed(2));
	
	
}


<?php if(!empty($revised_data[0]['payment_at'])){ ?>

function initPaymentType(){
	var val = '<?php echo $revised_data[0]['payment_at']; ?>';
	
	if(val == 'P'){
		$('#payment_project_wrapper').show();
		$('#payment_milestone_wrapper').hide();
		$('#payment_milestone_wrapper').find('input').attr('disabled', 'disabled');
		$('#payment_project_wrapper').find('input').removeAttr('disabled');
	}else{
		$('#payment_project_wrapper').hide();
		$('#payment_milestone_wrapper').show();
		$('#payment_project_wrapper').find('input').attr('disabled', 'disabled');
		$('#payment_milestone_wrapper').find('input').removeAttr('disabled');
	}
	
	var val  = parseFloat($('#payment_project_wrapper').find('[name="amount[]"]').val());
	var comm_percent = <?php echo SITE_COMMISSION; ?>;
	var comm = (val*(comm_percent/100));
	var to_pay = val + comm;
	$('#project_pay_amount').html('<?php echo CURRENCY;?>'+to_pay.toFixed(2));
	
}

initPaymentType();
<?php } ?>

function addFund(amt, bid_id, ele){
	if(ele){
		$(ele).attr('disabled','disabled');
		$(ele).html('Processing..');
	}
	location.href = '<?php echo base_url('myfinance/add_fund_paypal'); ?>?amt='+amt+'&b_id='+bid_id+'&cmd=award_job';
	/* if(amt && bidder_id){
		$.ajax({
			url : '<?php echo base_url('myfinance/add_fund_ajax')?>',
			data: {amount: amt, bid_id: bid_id, cmd: 'award_job'},
			type: 'POST',
			
		});
	} */
	
}

function addStripeFund(amt, bid_id, ele){
	if(ele){
		$(ele).attr('disabled','disabled');
		$(ele).html('Processing..');
	}
	amt = parseFloat(amt);
	if(amt > 0){
		var option = {
			amount: amt,
			bid_id: bid_id,
			cmd: 'award_job',
		}
		paycard(option);
	}else{
		return false;
	}
	
}

<?php 
$user_email = getField('email', 'user', 'user_id', $user_id);
?>

function paycard(options){
	event.preventDefault();
	handler = stripe_checkout(options);
	handler.open({
		image: '<?php echo ASSETS;?>img/<?php echo SITE_LOGO;?>',
		locale: 'auto',
		name: "ProRenoDeals",
		description: "Add Fund",
		amount: options.amount*100,
		email: '<?php echo $user_email;?>',
		currency:'CAD',
    });
	
}

function stripe_checkout(options) {
  var handler = StripeCheckout.configure({
    key: '<?php echo STRIPE_PUBLISHABLE_KEY; ?>',
    token: function(token) {
      // Send the charge through
      $.post("<?php echo base_url('myfinance/make_payment_stripe');?>?cmd="+options.cmd+'&b_id='+options.bid_id, 
       {token: token.id, amount: options.amount}, function(data) {
        if (data["status"] == "ok") {
          location.reload();
        } else {
         alert(data["message"]);
        }
      },'json');
    }
  });
  return handler;
 }
 
</script> 

