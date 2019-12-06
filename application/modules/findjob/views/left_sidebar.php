<?php

function check_query($key='' , $arr=array()){
	if(is_array($key)){
		foreach($key as $v){
			if(array_key_exists($v , $arr)){
			unset($arr[$v]);
		}
		}
	}else{
		if(array_key_exists($key , $arr)){
			unset($arr[$key]);
		}
	}
	return count($arr) > 0 ? http_build_query($arr).'&' : '';
}

$lang = $this->session->userdata('lang');



?>
<aside class="col-lg-3 col-12">
	<a href="javascript:void(0)" class="float-right d-lg-none btn btn-sm btn-success" id="filter" title="Filter"><i class="icon-feather-filter"></i> Filter</a>
    <div class="clearfix"></div>
    <div class="left_sidebar mb-3">
		<?php /*		<h4 class="title-sm"><?php echo __('findjob_sidebar_category','Category'); ?></h4>    	
		<ul class="list-group scroll-bar">
			<?php foreach($parent_category as $key =>$val){ 
			
			switch($lang){
				case 'arabic':
					$categoryName = !empty($val['arabic_cat_name'])? $val['arabic_cat_name'] : $val['cat_name'];
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$categoryName = !empty($val['spanish_cat_name'])? $val['spanish_cat_name'] : $val['cat_name'];
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$categoryName = !empty($val['swedish_cat_name'])? $val['swedish_cat_name'] : $val['cat_name'];
					break;
				default :
					$categoryName = $val['cat_name'];
					break;
			}
			
			?>
			<li <?php echo (!empty($srch_param['category_id']) AND $srch_param['category_id'] == $val['cat_id']) ? 'class="active"' : '';?>><a href="<?php echo base_url('findjob/browse').'/'.$this->auto_model->getcleanurl($val['cat_name']).'/'.$val['cat_id'];?>" id="parent_<?php echo $val['cat_id']?>" data-child="<?php echo $val['cat_id']?>"><?php echo $categoryName;?></a></li>
			<?php } ?>
		</ul>
		
		<?php if(!empty($srch_param['category_id'])){ ?>
		<h4 class="title-sm"><?php echo __('findjob_sidebar_sub_category','Sub Category'); ?></h4>    	
		<ul class="list-group scroll-bar">
			<?php foreach($child_category as $key =>$val){ 
			
			switch($lang){
				case 'arabic':
					$sub_categoryName = !empty($val['arabic_cat_name'])? $val['arabic_cat_name'] : $val['cat_name'];
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$sub_categoryName = !empty($val['spanish_cat_name'])? $val['spanish_cat_name'] : $val['cat_name'];
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$sub_categoryName = !empty($val['swedish_cat_name'])? $val['swedish_cat_name'] : $val['cat_name'];
					break;
				default :
					$sub_categoryName = $val['cat_name'];
					break;
			}
			
			
			?>
			<li <?php echo (!empty($srch_param['sub_catgory_id']) AND $srch_param['sub_catgory_id'] == $val['cat_id']) ? 'class="active"' : '';?>><a href="<?php echo base_url('findjob/browse').'/'.$srch_param['category'].'/'.$srch_param['category_id'].'/'.$this->auto_model->getcleanurl($val['cat_name']).'/'.$val['cat_id'];?>" id="parent_<?php echo $val['cat_id']?>" data-child="<?php echo $val['cat_id']?>"><?php echo $sub_categoryName;?></a></li>
			<?php } ?>
		</ul>
		<?php } ?>
		

		<h4 class="title-sm"><?php echo __('findjob_sidebar_project_type','Project Type'); ?></h4>
		<?php $url = !empty($srch_string) ? '?'.check_query('ptype' , $srch_string)  : '?'; ?>
		<ul class="list-group shadow_1">
			<li <?php echo (!empty($srch_param['ptype']) AND $srch_param['ptype'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'ptype=All';?>"><?php echo __('findjob_sidebar_all','All'); ?></a></li>
			<li <?php echo (!empty($srch_param['ptype']) AND $srch_param['ptype'] == 'H') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'ptype=H';?>"><?php echo __('findjob_sidebar_hourly','Hourly'); ?></a></li>
			<li <?php echo (!empty($srch_param['ptype']) AND $srch_param['ptype'] == 'F') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'ptype=F';?>"><?php echo __('findjob_sidebar_fixed','Fixed'); ?></a></li>       
		</ul>
		
		<h4 class="title-sm hide"><?php echo __('findjob_experience_level','Experience level'); ?></h4>
		<?php $url = !empty($srch_string) ? '?'.check_query('exp_level' , $srch_string)  : '?'; ?>
		<ul class="hide list-group shadow_1">
		<li <?php echo (!empty($srch_param['exp_level']) AND $srch_param['exp_level'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'exp_level=All';?>"><?php echo __('findjob_sidebar_all','All'); ?></a></li>
			<?php if(count($exp_levels) > 0){foreach($exp_levels as $k => $v){ ?>
			<li <?php echo (!empty($srch_param['exp_level']) AND $srch_param['exp_level'] == $v['id']) ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'exp_level='.$v['id'];?>"><?php echo $v['name']; ?></a></li>
			<?php } } ?>
		</ul>*/ ?>
		
		<?php /*
		<h4 class="title-sm"><?php echo __('findjob_sidebar_featured_project','Featured Project'); ?></h4>
		<?php $url = !empty($srch_string) ? '?'.check_query('featured' , $srch_string) : '?'; ?>
		<ul class="list-group shadow_1">
			<li <?php echo (!empty($srch_param['featured']) AND $srch_param['featured'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'featured=All';?>"><?php echo __('findjob_sidebar_all','All'); ?></a></li>
			<li <?php echo (!empty($srch_param['featured']) AND $srch_param['featured'] == 'Y') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'featured=Y';?>"><?php echo __('findjob_sidebar_featured','Featured'); ?></a></li>
			<li <?php echo (!empty($srch_param['featured']) AND $srch_param['featured'] == 'N') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'featured=N';?>"><?php echo __('findjob_sidebar_non_featured','Non-Featured'); ?></a></li>       
		</ul>
		
		
		<h4 class="title-sm"><?php echo __('findjob_sidebar_project_environment','Project Environment'); ?></h4>
		<?php $url = !empty($srch_string) ? '?'.check_query('env' , $srch_string) : '?'; ?>
		<ul class="list-group shadow_1">
			<li <?php echo (!empty($srch_param['env']) AND $srch_param['env'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'env=All';?>"><?php echo __('findjob_sidebar_all','All'); ?></a></li>
			
			<li <?php echo (!empty($srch_param['env']) AND $srch_param['env'] == 'ON') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'env=ON';?>"><?php echo __('findjob_sidebar_online','Online'); ?></a></li>
			
			<li <?php echo (!empty($srch_param['env']) AND $srch_param['env'] == 'OFF') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'env=OFF';?>"><?php echo __('findjob_sidebar_offline','Offline'); ?></a></li>       
		</ul>
		*/?>
		<div class="catcontent">
		<h4 class="title-sm"><?php echo __('findjob_sidebar_budget','Budget'); ?></h4>
		<div class='doller clearfix'>
		<form action="" method="get">		        
        <div class="input-group" style="margin-bottom:10px">
          <div class="input-group-prepend"><span class="input-group-text"><?php echo CURRENCY;?></span></div>
          <input type='text' name='min' id="budget_min" class='form-control' placeholder="Min" value="<?php echo !empty($srch_param['min']) ? $srch_param['min'] : '';?>">
        </div>
        <div class="input-group" style="margin-bottom:10px">
          <div class="input-group-prepend"><span class="input-group-text"><?php echo CURRENCY;?></span></div>
          <input type='text' name='max' id="budget_max" class='form-control' placeholder="Max" value="<?php echo !empty($srch_param['max']) ? $srch_param['max'] : '';?>">
        </div>
        <button type='submit' class='btn btn-site btn-block ok-btn mb-3'><?php echo __('findjob_sidebar_submit','Submit'); ?></button>

		</form>
		</div>
		</div>
		
		<h4 class="title-sm">Skills</h4>
        <div class="well mb-4 scroll-bar">
		<?php 
		
		$skill = $this->db->get('skills')->result_array(); 
		$selected_skills_array = array();
		if($selected_skills){
			foreach($selected_skills as $k => $v){
				$selected_skills_array[] = $v['id'];

			}

		}
		
		foreach($skill as $k => $v){ ?>
		<div class="radio">
			<input type="checkbox" class="magic-checkbox" value="<?php echo $v['id']; ?>" name="skills[]" id="skill_<?php echo $v['id'];?>" form="srchForm" <?php echo in_array($v['id'], $selected_skills_array) ? 'checked' : ''; ?> onclick="submitSearch();" />
			<label for="skill_<?php echo $v['id'];?>"><?php echo $v['skill_name'];?></label>
		</div>
		<?php } ?>
		</div>


		<h4 class="title-sm"><?php echo __('findjob_sidebar_posted_within','Posted within'); ?></h4>
		<?php
			$url = !empty($srch_string) ? '?'. check_query('posted' , $srch_string) : '?';
		?>
        <div class="well">
		<ul class="list-group list-group-x">
			<li <?php echo (!empty($srch_param['posted']) AND $srch_param['posted'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'posted=All';?>"><?php echo __('findjob_sidebar_all','All'); ?></a></li>
			<li <?php echo (!empty($srch_param['posted']) AND $srch_param['posted'] == '1') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'posted=1';?>"><?php echo __('findjob_sidebar_posted_within_24_hours','Posted within 24 hours'); ?></a></li>
			<li <?php echo (!empty($srch_param['posted']) AND $srch_param['posted'] == '3') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'posted=3';?>"><?php echo __('findjob_sidebar_posted_within_3_days','Posted within 3 days'); ?></a></li>
			<li <?php echo (!empty($srch_param['posted']) AND $srch_param['posted'] == '7') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'posted=7';?>"><?php echo __('findjob_sidebar_posted_within_7_days','Posted within 7 days'); ?></a></li>    
		</ul>
        </div>
		<?php /*
		<h4 class="title-sm"><?php echo __('findjob_sidebar_country','Country'); ?></h4>
			<?php $url = !empty($srch_string) ? '?'.check_query(array('ccode' , 'country') , $srch_string) : '?'; ?>
		<ul class="list-group scroll-bar">
			<li <?php echo (!empty($srch_param['ccode']) AND $srch_param['ccode'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'country=All&ccode=All';?>"><?php echo __('findjob_sidebar_all','All'); ?></a></li>
			
			<?php foreach($countries as $key=>$val) { ?>
			<li <?php echo (!empty($srch_param['ccode']) AND $srch_param['ccode'] == $val['Code']) ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'country='.$this->auto_model->getcleanurl($val['Name']).'&ccode='.$val['Code'];?>"><?php echo $val['Name'];?></a></li>
			<?php } ?>       
		</ul>  		*/?>		

    </div>
</aside>

<script src="<?php echo JS;?>jquery.nicescroll.min.js"></script>
<script>
  $(document).ready(function() {  	    
	$(".scroll-bar").niceScroll();
	$('#filter').click(function(){
    $('.left_sidebar').slideToggle();
  });
  });
</script>
<style>
.mobile-menu {
	display:none
}
</style>