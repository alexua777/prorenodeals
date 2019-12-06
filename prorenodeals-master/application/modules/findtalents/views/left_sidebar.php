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



$lang=$this->session->userdata('lang');



?>

<aside class="col-lg-3 col-12">
	<a href="javascript:void(0)" class="float-right d-lg-none btn btn-sm btn-success" id="filter" title="Filter"><i class="icon-feather-filter"></i> Filter</a>
    <div class="clearfix"></div>
  <div class="left_sidebar mb-3">
    <h4 class="title-sm" hidden>Freelancers</h4>
    <div class="input-group" hidden>
      <input type="text" class="form-control" name="q" placeholder="Search by name..." autocomplete="off" value="<?php echo !empty($srch_param['q']) ? $srch_param['q'] : ''; ?>" form="srchForm">
      <span class="input-group-append">
      <button type="submit" class="btn btn-site" form="srchForm"><i class="zmdi zmdi-search"></i> <?php echo __('findjob_search','Search'); ?></button>
      </span> </div>
    <h4 class="title-sm">Skills</h4>
    <div class="well mb-4 scroll-bar">
    <?php 
		
		$skill = $this->db->order_by('skill_name', 'asc')->get('skills')->result_array();
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
    <?php if(!empty($srch_param['ccode']) AND $srch_param['ccode'] != 'All'){ ?>
    <h4 class="title-sm"><?php echo __('findtalents_sidebar_city','City'); ?></h4>
    <?php $url = !empty($srch_string) ? '?'.check_query('city' , $srch_string) : '?'; ?>

    <ul class="well list-group list-group-x scroll-bar">
      <li <?php echo (!empty($srch_param['city']) AND $srch_param['city'] == 'All') ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'city=All';?>"><?php echo __('findtalents_sidebar_all','All'); ?></a></li>
      <?php foreach($cities as $key=>$val) { ?>
      <li <?php echo (!empty($srch_param['city']) AND $srch_param['city'] == $val['ID']) ? 'class="active"' : '';?>><a href="<?php echo base_url().$srch_url.$url.'city='.$val['ID'];?>"><?php echo $val['Name'];?></a></li>
      <?php } ?>
    </ul>

    <?php } ?>
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