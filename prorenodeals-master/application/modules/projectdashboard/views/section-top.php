<div class="parallax-banner-sm" style="background-image:url(<?php echo IMAGE;?>parallax1.jpg); height:auto">
  <div class="container">
    <div class="dashboard_New">
      <div class="row-10">
        <aside class="col-md-9 col-sm-8 col-xs-12">
          <div class="inner">
            <h3 style="margin-top:10px"><?php echo !empty($project_details['title'])? $project_details['title'] : ''; ?></h3>
            
            <table class="table">
            <tbody>
            <tr>            	                
                <td><span><i class="fa fa-eye"></i> <?php echo __('projectdashboard_sectop_posted_on','Posted on'); ?>:</span> <?php echo !empty($project_details['post_date'])? date('d F Y', strtotime($project_details['post_date'])) : ''; ?></td>
                
                <td><span><i class="fa fa-dollar"></i> <?php echo __('projectdashboard_sectop_budget','Budget'); ?>:</span> <?php echo CURRENCY; ?><?php echo !empty($project_details['buget_min'])? $project_details['buget_min'] : ''; ?> - <?php echo CURRENCY; ?><?php echo !empty($project_details['buget_max'])? $project_details['buget_max'] : ''; ?></td>                
                
                <!--<td><span><i class="fa fa-file"></i> Project Type:</span> Hourly</td>
                <td><span><i class="fa fa-clock-o"></i> Time:</span> 160 days left</td>-->
                <td><span><?php echo __('projectdashboard_sectop_status','Status'); ?>: </span> &nbsp;
			<?php if($project_details['user_id'] == $user_id){ ?>
			<a href="#" class="btn-link" <?php if($project_details['user_id'] == $user_id){ ?>data-toggle="modal" data-target="#active_project_Modal" <?php } ?>>
			<?php } ?>
			<?php
			switch($project_details['status']){
				case 'O':
						echo __('projectdashboard_sectop_open','Open');
						break;
				case 'C':
						echo __('projectdashboard_sectop_complete','Complete');
						break;
				case 'P':
						echo __('projectdashboard_sectop_active','Active');
						break;
				case 'F':
						echo __('projectdashboard_sectop_pending','Pending');
						break;
				case 'E':
						echo __('projectdashboard_sectop_expired','Expired');
						break;
				case 'PS':
						echo __('projectdashboard_sectop_paused','Paused');
						break;
				case 'CNL':
						echo __('projectdashboard_sectop_cancelled','Cancelled');
						break;
			}
			?>
			<?php if($project_details['user_id'] == $user_id){ ?>
			</a>
			<?php } ?>
			</td>
                </tr>
                
            </tbody>
            </table>                                                
			
			<?php if($project_details['is_completed'] == 'R'){echo __('projectdashboard_sectop_requested_for_complete','Requested for complete'); } ?>
			<?php if($project_details['is_cancelled'] == 'R'){echo __('projectdashboard_sectop_requested_for_cancel','Requested for canclelled'); } ?>

            <p><?php echo !empty($project_details['description'])? $project_details['description'] : ''; ?></p>
          </div>
        </aside>
        <aside class="col-md-3 col-sm-4 col-xs-12">
          <div class="c_details text-center">
            <div class="profile">
              <div class="profile_pic"> <span>
                <?php
                    if($project_user['logo']!='')
                    {
						if(file_exists('assets/uploaded/cropped_'.$project_user['logo'])){
							$project_user['logo']="cropped_".$project_user['logo'];
						}
                    ?>
                <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $project_details['user_id'];?>"><img src="<?php echo VPATH;?>assets/uploaded/<?php echo $project_user['logo'];?>"></a>
                <?php	
                    }
                    else
                    {
                    ?>
                <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $project_details['user_id'];?>"><img src="<?php echo VPATH;?>assets/images/user.png"></a>
                <?php	
                    }
                    ?>
                </span> </div>
            </div>
            <div class="profile-details">
              <h4 class=""> <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $project_details['user_id'];?>"><?php echo !empty($project_user['fname'])? $project_user['fname'].' '.$project_user['lname'] : ''; ?></a></h4>
<h4>
 <?php
	if($user[0]['rating'][0]['num']>0)
	{
		$avg_rating=$user[0]['rating'][0]['avg']/$user[0]['rating'][0]['num'];
		for($i=0;$i < $avg_rating;$i++)
		{
	?>
			<i class="zmdi zmdi-star"></i>
	<?php		
		}
		for($i=0;$i < (5-$avg_rating);$i++)
		{
	?>
			<i class="zmdi zmdi-star-outline"></i>
	<?
		}
	}
	else
	{
	?>
	<i class="zmdi zmdi-star"></i>
	<i class="zmdi zmdi-star"></i>
	<i class="zmdi zmdi-star"></i>
	<i class="zmdi zmdi-star-outline"></i>
	<i class="zmdi zmdi-star-outline"></i>
	<?php
	}
	?>
</h4>
              <p><img src="<?php echo ASSETS;?>images/cuntryflag/<?php echo !empty($cityCounrty['Code2'])? $cityCounrty['Code2'] : ''; ?>.png"> <span><?php echo !empty($cityCounrty['city_name'])? $cityCounrty['city_name'] : ''; ?></span> , <?php echo !empty($cityCounrty['Name'])? $cityCounrty['Name'] : ''; ?></p>
			  
			  <?php 
				
				$this->load->model('clientdetails/clientdetails_model');
				$this->load->model('jobdetails/jobdetails_model');
				$user_totalproject = $this->jobdetails_model->gettotaluserproject($project_user['user_id']);
				
				?>
				 <p><i class="zmdi zmdi-case"></i> <?php echo $user_totalproject;?> <?php echo __('projectdashboard_sectop_job_posted','Jobs Posted'); ?></p>
				 
				<p><i class="zmdi zmdi-money-box"></i> <?php echo CURRENCY;?><?php echo $this->clientdetails_model->get_total_expenditure($project_user['user_id']);?> <?php echo __('projectdashboard_sectop_total_spent','Total Spent'); ?></p>
			  
				
		
             
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="active_project_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
	<form id="project_status_form">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('projectdashboard_sectop_project_status','Project status'); ?></h4>
      </div>
      <div class="modal-body">
		<input type="hidden" name="project_id" value="<?php echo $project_details['project_id']; ?>"/>
		<?php 
		
		if($project_details['status'] == 'P' && $project_details['is_completed'] == 'N' && $project_details['is_cancelled'] == 'N'){ ?>
		
		<?php if($project_details['project_type'] != 'H'){ ?>
		<div class="radio">
          <input type="radio" class="magic-radio" id="CNL" name="status" value="CNL"/>
          <label for="CNL"><?php echo __('projectdashboard_sectop_cancelled','Cancelled'); ?></label>
        </div>
		<div class="radio">
          <input type="radio" class="magic-radio" id="C" name="status" value="C"/>
          <label for="C"><?php echo __('projectdashboard_sectop_complete','Complete'); ?></label>
        </div>
		<?php } ?>
		
		<div class="radio">
          <input type="radio" class="magic-radio" id="PS" name="status" value="PS"/>
          <label for="PS"><?php echo __('projectdashboard_sectop_paused','Pause'); ?></label>
        </div>
		
		
		<?php }else  if($project_details['status'] == 'PS' && $project_details['is_completed'] == 'N' && $project_details['is_cancelled'] == 'N'){ ?>
		<div class="radio">
          <input type="radio" class="magic-radio" id="P" name="status" value="P"/>
          <label for="P"><?php echo __('projectdashboard_sectop_resume','Resume'); ?></label>
        </div>
		
       <?php if($project_details['project_type'] != 'H'){ ?>
		<div class="radio">
          <input type="radio" class="magic-radio" id="CNL" name="status" value="CNL"/>
          <label for="CNL">Cancelled</label>
        </div>
		<?php } ?>
		
		<?php }else if($project_details['status'] == 'F' && $project_details['is_completed'] == 'N' && $project_details['is_cancelled'] == 'N'){ ?>
		
		 <div class="radio">
          <input type="radio" class="magic-radio" id="CNL" name="status" value="CNL"/>
          <label for="CNL">"><?php echo __('projectdashboard_sectop_cancelled','Cancelled'); ?></label>
        </div>
		
		<?php }else if($project_details['status'] == 'C'){
			echo '<p>'.__('projectdashboard_sectop_complete','Complete').'</p>';
		}else if($project_details['status'] == 'CNL'){
			echo '<p>'.__('projectdashboard_sectop_cancelled','Cancelled').'</p>';
		}else{  ?>
		<p><?php echo __('projectdashboard_sectop_no_action_can_be_performed','No action can be performed.'); ?></p>
		<?php } ?>
		
		<?php if($project_details['is_completed'] == 'R'){
			echo "<p>".__('projectdashboard_sectop_requested_for_complete','Requested for complete')."</p>";
		}else if($project_details['is_cancelled'] == 'R'){
			echo "<p>".__('projectdashboard_sectop_requested_for_cancel','Requested for canclelled')."</p>";
		}?>
		
		
      </div>
      <div class="modal-footer">
        <button type="button" onclick="change_project_status()" class="btn btn-site"><?php echo __('projectdashboard_sectop_save','Save'); ?></button>
      </div>
    </div>
	</form>
	
  </div>
</div>

<script>
function change_project_status(){
	var f = $('#project_status_form'),
		fdata = f.serialize();
	$.ajax({
		url: '<?php echo base_url('dashboard/project_action_status'); ?>',
		data: fdata,
		type: 'POST',
		dataType: 'json',
		success: function(res){
			if(res.status == 1){
				location.reload();
			}
		}
	});
}
</script>