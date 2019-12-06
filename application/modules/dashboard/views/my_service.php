
<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/chosen/chosen.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/chosen/chosen.jquery.min.js" type="text/javascript"></script> 

<section id="mainpage">
<div class="container-fluid">
<div class="row">
<?php $this->load->view('dashboard-left'); ?>
<aside class="col-lg-10 col-md-9 col-12">
   <?php echo $breadcrumb; ?>
   <article class="card">	        
        <div class="card-header">
            <h4><?php echo __('myprofile_services','Services'); ?> <a href="javascript:void(0)" class="float-right" onclick="$('#editSkillForm').show(); $('#skill_list').hide(); "><i class="icon-feather-edit-3"></i></a></h4>
        </div>
        <div class="card-body">
			<div id="skill_list">
			<ul class="skills mb-0">                    
			<?php 
			  if(count($user_skill)){
				foreach($user_skill as $k => $v){
			?>
			   <li><a href="javascript:void(0)">
				  <?php echo $v['skill'];?>
			  </a> </li>
			<?php
					 
			  } } 
			  else{ 
			?>
				<li><a href="javascript:void(0);"><?php echo __('myprofile_skill_not_set_yet','Skill Not Set Yet'); ?></a> </li>
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
        </article>
  
</aside>

</div>

</div>

</section>









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






