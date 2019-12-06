<style>

.left_sidebar .table > tbody > tr > th, .left_sidebar .table > tbody > tr > td {

	padding: 8px 0;

}

</style>



<?php

$p_user_image = '';



if($project_user['logo']!=''){

	$p_user_image = base_url('assets/uploaded/'.$project_user['logo']) ;

if(file_exists('assets/uploaded/cropped_'.$project_user['logo'])){

	$p_user_image = base_url('assets/uploaded/cropped_'.$project_user['logo']) ;

}

}else{

	$p_user_image = base_url('assets/images/user.png'); 

}



$this->load->model('jobdetails/jobdetails_model');

$this->load->model('dashboard/dashboard_model');

$user_totalproject = $this->jobdetails_model->gettotaluserproject($project_user['user_id']);

$rating_employer = $this->dashboard_model->getrating_new($project_user['user_id']);

?>


<div class="col-lg-3 col-12">
<div class="right_panel card">
<div class="card-body c_details">
<div class="profile">
  <div class="profile_pic">

  	<span><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $project_detail['user_id'];?>"><img src="<?php echo $p_user_image;?>" class="media-object"></a></span>

  </div>


</div>

<div class="profile-details text-center">

    <h4><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $project_detail['user_id'];?>"><?php echo !empty($project_user['fname'])? $project_user['fname'].' '.$project_user['lname'] : ''; ?></a></h4>

    <h4 class="d-none">

	<?php

		if($rating_employer[0]['num']>0){

			$avg_rating=$rating_employer[0]['avg']/$rating_employer[0]['num'];

			for($i=1; $i<=5; $i++){

				if($i <= $avg_rating){

					echo '<i class="zmdi zmdi-star"></i>';

				}else{

					echo '<i class="zmdi zmdi-star-outline"></i>';

				}

			}

			

			

		}else{

			echo '<i class="zmdi zmdi-star-outline"></i> <i class="zmdi zmdi-star-outline"></i> <i class="zmdi zmdi-star-outline"></i> <i class="zmdi zmdi-star-outline"></i> <i class="zmdi zmdi-star-outline"></i>';

		

		}

		?>

    </h4>

	<div class="star-rating" data-rating="<?php echo round($avg_rating); ?>"></div>

    <p><img src="<?php echo ASSETS;?>images/cuntryflag/<?php echo !empty($cityCountry['Code2'])? strtolower($cityCountry['Code2']) : ''; ?>.png"> <span><?php echo !empty($cityCountry['city_name']) ? $cityCountry['city_name'] : ''; ?></span> , <?php echo !empty($cityCountry['Name'])? $cityCountry['Name'] : ''; ?></p>

    

    <h5>Jobs Posted</h5>
	<h3><?php echo $user_totalproject; ?></h3>
    <div class="spacer-10"></div>
    <h5><?php echo get_project_spend_amount($project_detail['user_id']);?> <?php echo __('jobdetails_total_spent','Total Spent'); ?></h5>
    <h3><?php echo CURRENCY;?></h3>
    <div class="spacer-10"></div>

</div>

<h5 class="text-center"><?php echo !empty($project_detail['title'])? $project_detail['title'] : ''; ?></h5>

<table class="table">

<tbody>

    <tr>

        <th><?php echo __('projectdashboard_sectop_posted_on','Posted on'); ?>: </th><td><?php echo !empty($project_detail['post_date'])? date('d M, Y', strtotime($project_detail['post_date'])) : ''; ?></td>

    </tr>

    <tr>

        <th> <?php echo __('projectdashboard_sectop_budget','Budget'); ?>: </th><td><?php echo CURRENCY; ?><?php echo !empty($project_detail['buget_min'])? $project_detail['buget_min'] : ''; ?> - <?php echo CURRENCY; ?><?php echo !empty($project_detail['buget_max'])? $project_detail['buget_max'] : ''; ?></td>

    </tr>

    <tr>

        <th><?php echo __('projectdashboard_sectop_status','Status'); ?>: </th>

		<td>

		<?php

			 $bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_detail['project_id']);

			 if($project_detail['project_type'] == 'F'){

				 $pending_dispute_amount = $this->projectdashboard_model->getPendingDispute($project_detail['project_id'], $bidder_id);

			 }else{

				$pending_dispute_amount = 0;

			 }

			 

			switch($project_detail['status']){

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

			

			if($project_detail['user_id'] == $user_id && $project_detail['status'] != 'C' && ($pending_dispute_amount > 0 === false)){

				/* echo ' &nbsp; <a href="javascript:void(0)" data-toggle="modal" data-target="#active_project_Modal">Edit</a>'; */

			}

			?>

		</td>

    </tr>

</tbody>

</table>

<?php if($project_detail['is_completed'] == 'R' && $project_detail['status'] != 'C'){echo __('projectdashboard_sectop_requested_for_complete','Requested for complete'); } ?>

<?php if($project_detail['is_cancelled'] == 'R' && $project_detail['status'] != 'CNL'){echo __('projectdashboard_sectop_requested_for_cancel','Requested for canclelled'); } ?>


</div>

</div>
</div>


<script>

$(window).load(function(){

	$('#mainpage').css('min-height', 800);

    var height = $('#mainpage').height();

	var w = $(window).width();

	if(w > 991){		

    	$('.right_panel').css('height', height);

	}

});  

</script>

<script>

$(window).load(function(){      

  var w = $(window).width();

  if(w > 601){

	  $(".nav-menu").sticky({ topSpacing: 0 });

	 }

});

</script>



<!-- Modal -->

<div class="modal fade" id="active_project_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

	<form id="project_status_form">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#active_project_Modal').modal('hide');"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel"><?php echo __('projectdashboard_sectop_project_status','Project status'); ?></h4>

      </div>

      <div class="modal-body">

		<input type="hidden" name="project_id" value="<?php echo $project_detail['project_id']; ?>"/>

		<?php 

		$show_btn = 0;

		if($project_detail['status'] == 'P' && $project_detail['is_completed'] == 'N' && $project_detail['is_cancelled'] == 'N'){ ?>

		

		<?php if($project_detail['project_type'] != 'H'){ $show_btn = 1; ?>

		<div class="radio">

          <input type="radio" class="magic-radio" id="CNL" name="status" value="CNL"/>

          <label for="CNL"><?php echo __('projectdashboard_sectop_cancelled','Cancelled'); ?></label>

        </div>

		<?php } ?>

		

		<?php if($project_detail['status'] == 'P' && $project_detail['project_type'] == 'H'){ $show_btn = 1; ?>

		<div class="radio">

          <input type="radio" class="magic-radio" id="C" name="status" value="C"/>

          <label for="C"><?php echo __('projectdashboard_sectop_complete','Complete'); ?></label>

        </div>

		<?php } ?>

		

		<?php if($project_detail['project_type'] == 'H'){ $show_btn = 1; ?>

		<div class="radio">

          <input type="radio" class="magic-radio" id="PS" name="status" value="PS"/>

          <label for="PS"><?php echo __('projectdashboard_sectop_paused','Pause'); ?></label>

        </div>

		<?php } ?>

		

		<?php }else  if($project_detail['status'] == 'PS' && $project_detail['is_completed'] == 'N' && $project_detail['is_cancelled'] == 'N'){ $show_btn = 1; ?>

		<div class="radio">

          <input type="radio" class="magic-radio" id="P" name="status" value="P"/>

          <label for="P"><?php echo __('projectdashboard_sectop_resume','Resume'); ?></label>

        </div>

		

		

		<?php }else if($project_detail['status'] == 'F' && $project_detail['is_completed'] == 'N' && $project_detail['is_cancelled'] == 'N'){ ?>

		

		

		

		<?php }else if($project_detail['status'] == 'C'){

			echo '<p>'.__('projectdashboard_sectop_complete','Complete').'</p>';

		}else if($project_detail['status'] == 'CNL'){

			echo '<p>'.__('projectdashboard_sectop_cancelled','Cancelled').'</p>';

		}else{  ?>

		<p><?php echo __('projectdashboard_sectop_no_action_can_be_performed','No action can be performed.'); ?></p>

		<?php } ?>

		

		<?php if($project_detail['is_completed'] == 'R'){

			echo "<p>".__('projectdashboard_sectop_requested_for_complete','Requested for complete')."</p>";

		}else if($project_detail['is_cancelled'] == 'R'){

			echo "<p>".__('projectdashboard_sectop_requested_for_cancel','Requested for canclelled')."</p>";

		}?>

		

		

      </div>

	  <div id="pending_payment_cError"></div>

      <div class="modal-footer">

		<?php if($show_btn){ ?>

        <button type="button" onclick="change_project_status()" class="btn btn-site"><?php echo __('projectdashboard_sectop_save','Save'); ?></button>

		<?php } ?>

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

		dataType: 'json',

		type: 'POST',

		success: function(res){

			if(res.status == 1){

				location.reload();



			}else{

				var error = res.errors;

				for(var i in error){

					$('#'+i+'Error').html(error[i]);

				}

			}

		}

	});

}

</script>

