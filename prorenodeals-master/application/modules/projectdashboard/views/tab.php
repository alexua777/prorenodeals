<ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="<?php echo $page == 'index' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard/index/'.$project_id);?>"><?php echo __('projectdashboard_tab_overview','Overview'); ?></a></li>
	  
	  <?php if($account_type == 'F'){ ?>
	  
		  <?php if($project_info['type'] == 'H'){ ?>
		   <li role="presentation" class="<?php echo $page == 'hourly' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard/hourly_freelancer/'.$project_id); ?>"><?php echo __('projectdashboard_tab_hour','Hour'); ?></a></li>
		  <?php }else{  ?>
		  <li role="presentation" class="<?php echo $page == 'milestone' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard/milestone_freelancer/'.$project_id); ?>"><?php echo __('projectdashboard_tab_milestone','Milestone'); ?></a></li>
		  <?php } ?>
	  
	  <?php }else{ ?>
	  
		<?php if($project_info['type'] == 'H'){ ?>
		   <li role="presentation" class="<?php echo $page == 'hourly' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard/hourly_employer/'.$project_id); ?>"><?php echo __('projectdashboard_tab_hour','Hour'); ?></a></li>
		  <?php }else{  ?>
		  <li role="presentation" class="<?php echo $page == 'milestone' ? 'active' : '';?>"><a href="<?php echo base_url('projectdashboard/milestone_employer/'.$project_id); ?>"><?php echo __('projectdashboard_tab_milestone','Milestone'); ?></a></li>
		  <?php } ?>
	  
	  <?php } ?>
      
</ul>