<script type="text/javascript" src="<?php echo JS;?>jQuery-plugin-progressbar.js"></script>
<link href="<?php echo CSS;?>jQuery-plugin-progressbar.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/chosen/chosen.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/chosen/chosen.jquery.min.js" type="text/javascript"></script>


<?php $lang=$this->session->userdata('lang'); ?>


<section class="sec">
  <div class="container">
  <?php echo $breadcrumb;?>	
    <div class="row">
      <?php $this->load->view('left_sidebar'); ?>
      <aside class="col-lg-9 col-12">	
	  
        <div class="searchbox">
           <form id="srchForm">
				<!--<div class="form-group">                
					<?php 
					$selected_skills_array = array();
					$skill = $this->db->limit(50)->get('skills')->result_array();
					if($selected_skills){
						foreach($selected_skills as $k => $v){
							$selected_skills_array[] = $v['id'];
						}
					}
					?>
					<select class="form-control inputtag" name="skills[]" multiple>
					<?php if(count($skill) > 0){foreach($skill as $k => $v){ ?>
						<option value="<?php echo $v['id']; ?>" <?php echo in_array($v['id'], $selected_skills_array) ? 'selected="selected"' : '';?>><?php echo $v['skill_name']; ?></option>
					<?php } } ?>
					</select>
				
                
                </div> -->
                
       
				<div class="sort-by mb-15">
                    <span>Sort by:</span>
                    <select class="selectpicker hide-tick" name="sort_by" onchange="submitSearch();">
                        <option value="relevance" <?php echo (!empty($srch_param['sort_by']) && $srch_param['sort_by'] == 'relevance') ? 'selected' : '';?>>Relevance</option>
                        <option value="new" <?php echo (!empty($srch_param['sort_by']) && $srch_param['sort_by'] == 'new') ? 'selected' : '';?>>Newest</option>
                        <option value="old" <?php echo (!empty($srch_param['sort_by']) && $srch_param['sort_by'] == 'old') ? 'selected' : '';?>>Oldest</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="input-group">
					<input type="text" class="form-control form-control-lg" name="q" placeholder="Search by name..." autocomplete="off" value="<?php echo !empty($srch_param['q']) ? $srch_param['q'] : ''; ?>">
					<div class="input-group-append">
						<button type="submit" class="btn btn-site"><?php echo __('findjob_search','Search'); ?></button>
					</div> 
				</div>

                
                
                
				
		  
				<input type="hidden" name="append_skill" value="<?php echo $srch_param['append_skill'] == 1 ? $srch_param['append_skill'] : 0;?>"/>
			</form>
  
          <p class="text-right" style="display:none;"><a href="#"><?php echo __('findtalents_advanced_search','Advanced Search'); ?></a></p>
        </div>
        <div class="listings-container" id="talent">
       <?php /*   <p>( <?php echo $total_freelancers;?> ) Freelancer found</p> */ ?>
          <?php 
  

  if(count($freelancers)){ 
	

  foreach ($freelancers as $row){
  	$previouscon=in_array($row['user_id'],$previousfreelancer);
?>
          <?php
if($this->session->userdata('user'))
{
	$user=$this->session->userdata('user');
	$account_type=$user[0]->account_type;
	if($user[0]->user_id==$row['user_id'])
	{
		$lnk=VPATH."dashboard/profile_professional";
	}
	else
	{
		$lnk=VPATH."clientdetails/showdetails/".$row['user_id']."/".$this->auto_model->getcleanurl($row['fname']." ".$row['lname'])."/";
	}

	$action = 'add';
	$fav_cls = '';
	if(is_fav($row['user_id'], 'FREELANCER', $user[0]->user_id)){
		$action = 'remove';
		$fav_cls = 'bookmarked';
	}
	
}
else
{
	$lnk=VPATH."clientdetails/showdetails/".$row['user_id']."/".$this->auto_model->getcleanurl($row['fname']." ".$row['lname'])."/";	
}
 $logo= get_user_logo($row['user_id']);
?>
          <div class="job-listing">
            <div class="job-listing-details">
			<div class="job-listing-company-logo"> <a href="<?php echo $lnk;?>">
				<img src="<?php echo $logo;?>" class="rounded-circle" />
              </a>
              <div class="spacer-10"></div>
              <?php if($row['featured'] && $row['featured'] == '1'){ ?><div class="text-center"><span class="badge badge-success">Featured</span></div><?php } ?>
            </div>
            <div class="job-listing-description">
           
		    <!-- Bookmark Icon -->
          <span class="bookmark-icon mark-fav-button <?php echo $fav_cls;?>" data-object-id="<?php echo $row['user_id'];?>" data-object-type="FREELANCER" data-action="<?php echo $action;?>"></span>
		  
<?php 
  $membership_logo="";
  $membership_logo=$this->auto_model->getFeild('icon','membership_plan','id',$row['membership_plan']); 
  $membership_title=$this->auto_model->getFeild('name','membership_plan','id',$row['membership_plan']); 
  $slogan = $this->auto_model->getFeild('slogan','user','user_id',$row['user_id']);
  $overview = $this->auto_model->getFeild('overview','user','user_id',$row['user_id']);
  $reg_date = $this->auto_model->getFeild('reg_date','user','user_id',$row['user_id']);
   $avg_rating=get_user_rating($row['user_id']);
?>
              <h3 class="job-listing-title"><a href="<?php echo $lnk;?>"><?php echo get_full_name($row['user_id']); ?></a></h3>              
              <p class="designation"><a href="<?php echo $lnk;?>"><?php echo $slogan;?></a></p>
              <div class="star-rating" data-rating="<?php echo $avg_rating; ?>"></div>
              <p class="bio"><i class="icon-feather-map-pin"></i> <?php echo get_user_city($row['user_id']); ?></p>
              <p><?php echo strlen(strip_tags($overview)) > 200 ? substr(strip_tags($overview) , 0 , 200).'... <a href="'.$lnk.'">'.__('findtalents_more','more').'</a>' : strip_tags($overview); ?> </p>
              <ul class="skills mb-0">

              <?php 
      $skill_list=$row['skills'];
	
      if(count($skill_list)){
		foreach($skill_list as $k => $v){
			
			$skill_name=$v['skill_name'];
			switch($lang){
				case 'arabic':
					$skill_name = !empty($v['arabic_skill_name'])? $v['arabic_skill_name'] : $v['skill_name'];
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$skill_name = !empty($v['spanish_skill_name'])? $v['spanish_skill_name'] : $v['skill_name'];
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$skill_name = !empty($v['swedish_skill_name'])? $v['swedish_skill_name'] : $v['skill_name'];
					break;
				default :
					$skill_name = $v['skill_name'];
					break;
			}
	?>
              <li><a href="<?php echo base_url('findtalents?skills[]='.$v['skill_id']);?>"> <?php // echo $v['skill'];?>
			  <?php echo $skill_name; ?> </a> </li>
              <?php
             
      } } 
      else{ 
    ?>
              <li><a href="javascript:void(0);"><?php echo __('findtalents_skills_not_set_yet','Skill Not Set Yet'); ?></a> </li>
              <?php  
      }
   ?>
            </ul>
            </div>
            
            </div>
            <div class="job-listing-footer">
				<?php 
                    $row['total_project'] = $row['total_project'] == 0 ? 1 : $row['total_project'];
                    $success_prjct = (int) $row['com_project'] * 100 / (int) $row['total_project'];
                    $earned_amount = get_earned_amount($row['user_id']);
                ?>
            	<ul>
                	<li><span><i class="icon-feather-clock"></i> Since:</span> <b><?php echo date('d M, Y', strtotime($reg_date));?></b></li>
                    <li><span>Total Earned:</span> <b><?php echo CURRENCY . format_money($earned_amount,TRUE);?></b></li>
                    <li><span><?php echo __('findtalents_compleated_projects','Completed Project'); ?>:</span> <b><?php echo $row['com_project'];?></b></li>
                    <li><button class="btn btn-site btn-sm" onclick="invite_contactor(this)" data-user-id="<?php echo $row['user_id']; ?>" data-user-name="<?php echo $row['fname'].' '.$row['lname'];?>">Invite Now</button></li>
                </ul>
            </div>
          </div>
          
          <?php 
}

}
else{ 
    echo "<div class='alert alert-danger'>".__('findtalents_no_record_found','No record found')."</div>";
}
?>
        </div>
        <nav aria-label="Page navigation" id="pagi_span">
          <?php     echo $links;  ?>
        </nav>
      </aside>
    </div>
  </div>
</section>

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
		<input type="hidden" name="freelancer_id" value=""/>
		<input type="hidden" name="employer_id" value="<?php echo $usr[0]->user_id;?>"/>
        <textarea rows="4" name="message" class="form-control" placeholder="Write your invitation" style="margin-bottom:10px"></textarea>
		
		
		<?php if(count($user_project) > 0){?>
        <select id="choosen_project" class="form-control" style="margin-bottom:10px" name="project_id" onchange="check_project_type();">
		<option value="">Choose project</option>
			<?php if(count($user_project) > 0){foreach($user_project as $k => $v){ ?>
				<option value="<?php echo $v['project_id'];?>" data-project-type="<?php echo $v['project_type'];?>"><?php echo $v['title']; ?></option>
			<?php } }  ?>
        
		</select>
		<?php }else{ ?>
		<p>You have no open project . <a href="javascript:void(0)" onclick="post_user_project()">Post a project</a> now to invite this user </p>
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
        <button type="button" onclick="invite_user();" class="btn btn-success btn-block" style="margin:5px 0">Invite to quote</button>
        <?php } ?>
		</form>    
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>
<script type="text/javascript">
<?php $srch_url = !empty($srch_param) ? '?'.http_build_query($srch_param, '', '&').'&' : '?';?>
var srch_url = '<?php echo base_url('findtalents/ajaxsearch').$srch_url;?>';

/* $(document).ready(function(){
	$('#srch').keyup(function(){
		var val = $(this).val();
		$.get(srch_url+'q='+val , function(res , status){
			$('#talent').html(res);
			$('#pagi_span').hide();
		});
	});
}); */

$(".circle-bar").loading();

$('.inputtag').chosen()
.change(function(){
	$('#srchForm').submit();
});

function submitSearch(){
	$('#srchForm').submit();
}
</script>
<script src="<?=JS?>bootstrap-select.min.js" type="text/javascript"></script>

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

function post_user_project(){
	var $invite_modal = $('#inviteModal');
	
	var url = '<?php echo base_url('postjob')?>';
	var selected_freelaner_id = $invite_modal.find('[name="freelancer_id"]').val();
	if(selected_freelaner_id > 0){
		url += '?inv_user='+selected_freelaner_id;
	}
	location.href = url;
}

function invite_contactor(ele){
	var f_user_id = $(ele).data('userId');
	var u_name = $(ele).data('userName');
	var msg = 'Hi '+u_name+', I noticed your profile and would like to offer you my project. We can discuss any details over chat.';
	var $invite_modal = $('#inviteModal');
	$invite_modal.find('[name="message"]').val(msg);
	$invite_modal.find('[name="freelancer_id"]').val(f_user_id);
	$invite_modal.modal('show');
}
</script>