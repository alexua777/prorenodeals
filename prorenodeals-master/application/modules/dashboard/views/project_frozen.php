<?php
$login_user_id = $user_id;
?>
<script type="text/javascript">
							
$('[data-toggle="tooltip"]').tooltip();
function onchangeOption(v,i){
// alert(v);alert(i);

if(v=="VF"){ 
window.location.href=$("#vf_"+i).attr('href');
}

else if(v=="WR"){
window.location.href=$("#wr_"+i).attr('href');

}
else if(v=="PC"){

window.location.href=$("#pc_"+i).attr('href');

}
else if(v=='M'){

window.location.href=$("#m_"+i).attr('href');

}
else if(v=='GB'){

window.location.href=$("#gb_"+i).attr('href');

}
else if(v=='EC'){

window.location.href=$("#ec_"+i).attr('href');

}
else if(v=='VP'){

window.location.href=$("#vp_"+i).attr('href');

}
}
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();   
});		
</script>
<style>
.extratext{
width:100%;
float:left;
}
#exampleTabs_wrapper .table-responsive {
	overflow-x:visible
}
</style>

<div class="clearfix"></div>

<table id="exampleTabs" class="table table-dashboard">
<thead><tr><th><?php echo __('dashboard_myproject_client_project_name','Project Name'); ?></th><th class="text-center" hidden><?php echo __('dashboard_myproject_client_project_type','Project Type'); ?></th><th class="text-center">Project Budget</th><th class="text-center"><?php echo __('dashboard_myproject_client_bids','Bids'); ?></th><th class="text-center"><?php echo __('dashboard_myproject_client_workroom','Workroom'); ?></th><th class="text-center"><?php echo __('dashboard_myproject_posted_date','Posted date'); ?></th><th><?php echo __('dashboard_myproject_client_status','Status'); ?></th><th><?php echo __('dashboard_myproject_client_action','Action'); ?></th></tr>
</thead>
<tbody>
<?php
$u = $this->session->userdata('user');
$user_id = $u[0]->user_id;
$this->load->model('projectdashboard_new/projectdashboard_model');
$this->load->model('myfinance/myfinance_model');
/* get_print($projects, false); */
if(count($projects) > 0){foreach($projects as $k => $v){
	//get_print($v, false);
$feedback= $this->projectdashboard_model->getProjectFeedback($v['project_id']);
		//get_print($feedback, false);	
$v = filter_data($v);
if($v['project_type'] == 'H' AND $v['multi_freelancer'] == 'Y'){
	$project_type='<i class="zmdi zmdi-time" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.__('dashboard_myproject_hourly','Hourly').'"></i>';
}else{
	$project_type='<i class="zmdi zmdi-lock" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.__('dashboard_myproject_fixed','Fixed').'"></i>';
}

if($status == 'RO'){
	$status = 'O';
}

$budget = '';
/* if($v['buget_min'] > 0 && $v['buget_max'] > 0 && ($v['buget_min'] != $v['buget_max'])){
	$budget = CURRENCY.$v['buget_min'] . ' to '.CURRENCY.$v['buget_max'];
}else if($v['buget_min'] > 0 && $v['buget_max'] > 0 && ($v['buget_min'] == $v['buget_max'])){
	$budget = CURRENCY.$v['buget_min'];
}else if($v['buget_min'] > 0 && ($v['buget_max'] == 0)){
	$budget = 'Min '. CURRENCY. $v['buget_min'];
}else if($v['buget_max'] > 0 && ($v['buget_min'] == 0)){
	$budget = 'Max '. CURRENCY. $v['buget_max'];
} */

$budget = get_project_budget($v['project_id']);

if($status == 'P' || $status == 'C'){
	$BIDDER_ID = getField('bidder_id', 'projects', 'project_id', $v['project_id']);
	
	if($BIDDER_ID){
		$BID_INFO = get_row(array(
			'select' => 'bidder_amt,admin_fee,tax_amount,total_amt',
			'from' => 'bids',
			'where' => array('bidder_id' => $BIDDER_ID, 'project_id' => $v['project_id']),
		));
		
		if($BID_INFO){
			$budget = CURRENCY.($BID_INFO['bidder_amt']+$BID_INFO['admin_fee']);
		}
	}
}

?>
<tr>
	<td><a href="<?php echo VPATH.'job-'.seo_string($v['title']).'-'.$v['project_id']; ?>"><?php echo $v['title'];?></a></td>
	<td align="center" hidden><?php echo $project_type;?></td>
	<td align="center"><?php echo $budget;?></td>
	<td align="center"><?php echo $v['bidder_details']; ?></td>
	<td align="center"> <?php if($status == 'O' || $status == 'E' || $status == 'CNL'){}else{ ?><a href="<?php echo base_url('projectdashboard_new/employer/overview/'.$v['project_id']); ?>" data-toggle="tooltip" title="<?php echo __('dashboard_myproject_client_workroom','Work Room'); ?>"><i class="icon-feather-home"></i></a><?php } ?></td>
	<td align="center"><?php echo date('d M,Y',strtotime($v['posted_date']));?></td>
	<td align="center"><?php if($v['project_status']=='Y'){echo "<a href='javascript:void(0)' class='hourly' data-toggle='tooltip' data-placement='top' title='".__('dashboard_myproject_active','Active')."'><i class='fa fa-check-circle'></i></div>";}else{echo "<div class='hourly' title='".__('dashboard_myproject_waiting_for_admin_approval','Awaiting admin approval')."'><i class='fa fa-spinner'></i></a>";}?></td>
	<td>
		<?php if($status == 'C'){
		
		$feedback_by_freelancer = array();
		$feedback_to_freelancer = array();
		$all_bidders = explode(',', $v['bidder_id']);
		
		
		if(count($all_bidders) > 0){ foreach($all_bidders as $key => $bidder){
			$is_freelancer_feedback_done = false;
			$is_employer_feedback_done = false;
			$freelancer_given_public_feedback = $freelancer_given_private_feedback = array();
			if(empty($bidder)){
				continue;
			}
			
			if(!empty($feedback['public'][$bidder.'|'.$user_id])){
				$freelancer_given_public_feedback =$feedback['public'][$bidder.'|'.$user_id];
				$is_freelancer_feedback_done=true;
			}
			
			if(!empty($feedback['private'][$v['freelancer_id'].'|'.$user_id])){
				$freelancer_given_private_feedback =$feedback['private'][$bidder.'|'.$user_id];
				$is_freelancer_feedback_done=true;
			}
			
			if(!empty($feedback['public'][$user_id.'|'.$bidder])){
				$is_employer_feedback_done = true;
				
			}
			
			if($is_freelancer_feedback_done){
				$u_info = get_row(array('select' => 'fname,lname,user_id', 'from' => 'user', 'where' => array('user_id' => $bidder)));
				$u_info['freelancer_given_public_feedback'] = $freelancer_given_public_feedback;
				$u_info['freelancer_given_private_feedback'] = $freelancer_given_private_feedback;
				
				$feedback_by_freelancer[] = $u_info;
				
			}
			
			if(!$is_employer_feedback_done){
				
				if($v['project_type'] == 'H'){
					$s_row = get_row(array('select' => 'is_contract_end', 'from' => 'project_schedule', 'where' => array('project_id' => $v['project_id'], 'freelancer_id' => $bidder_id)));
					if(!empty($s_row) && $s_row['is_contract_end'] == 1){
						$feedback_to_freelancer[] = get_row(array('select' => 'fname,lname,user_id', 'from' => 'user', 'where' => array('user_id' => $bidder)));
					}
				}else{
					$feedback_to_freelancer[] = get_row(array('select' => 'fname,lname,user_id', 'from' => 'user', 'where' => array('user_id' => $bidder)));
				}
				
				
			}
			
		}
		
		}
		?>
		<?php if(count($feedback_by_freelancer) > 0 && $v['project_type'] == 'H'){ ?>
		<li class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">View Feedback <span class="caret"></span></a>        	
          <ul class="dropdown-menu">
			<?php foreach($feedback_by_freelancer as $freelancer){ ?>
			 <li><a href="javascript:void(0);" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($freelancer['freelancer_given_public_feedback']); ?>' data-private-feedback='<?php echo json_encode($freelancer['freelancer_private_public_feedback']); ?>' data-name="<?php echo $freelancer['fname'].' '.$freelancer['lname']; ?>"><?php echo $freelancer['fname'].' '.$freelancer['lname']; ?></a></li>
			<?php } ?>
          </ul>
        </li>
		<?php } ?>
		
		<?php /*if(count($feedback_by_freelancer) > 0 && $v['project_type'] == 'F'){ ?>
		<a href="javascript:void(0);" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($feedback_by_freelancer[0]['freelancer_given_public_feedback']); ?>' data-private-feedback='<?php echo json_encode($feedback_by_freelancer[0]['freelancer_private_public_feedback']); ?>' data-name="<?php echo $feedback_by_freelancer[0]['fname'].' '.$feedback_by_freelancer[0]['lname']; ?>">View Feedback</a>
		<?php } */ ?>
		
		<?php if(count($feedback_to_freelancer) > 0 && $v['project_type'] == 'H'){ ?>
		<li class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Leave Feedback <span class="caret"></span></a>        	
          <ul class="dropdown-menu">
			<?php foreach($feedback_to_freelancer as $freelancer){ ?>
			 <li><a href="javascript:void(0);" data-freelancer-id="<?php echo $freelancer['user_id']; ?>" data-name="<?php echo $freelancer['fname'].' '.$freelancer['lname']; ?>" data-project-id="<?php echo $v['project_id']; ?>" onclick="updateFeedback(this)"><?php echo $freelancer['fname'].' '.$freelancer['lname']; ?></a></li>
			<?php } ?>
          </ul>
        </li>
		<?php } ?>
		
		<?php if(count($feedback_to_freelancer) > 0 && $v['project_type'] == 'F'){ ?>
		<!--<a href="javascript:void(0);" data-freelancer-id="<?php echo $feedback_to_freelancer[0]['user_id']; ?>" data-name="<?php echo $feedback_to_freelancer[0]['fname'].' '.$feedback_to_freelancer[0]['lname']; ?>" data-project-id="<?php echo $v['project_id']; ?>" onclick="updateFeedback(this)">Leave Feedback</a>-->
		<a href="javascript:void(0)" onclick="rating_review(this);" data-project-id="<?php echo $v['project_id']; ?>" data-freelancer-id="<?php echo $feedback_to_freelancer[0]['user_id']; ?>">Leave Feedback</a>
		<?php } ?>
		
		
		<?php }else{
			if($status == 'O'){?>
			<a href="javascript:void(0);" onclick="actionPerform('E',<?php echo $v['id'];?>)" data-toggle="tooltip" title="<?php echo __('dashboard_myproject_edit','Edit'); ?>"><i class="fa fa-edit"></i></a>

			<a href="javascript:void(0);" onclick="actionPerform('C',<?php echo $v['id'];?>)" data-toggle="tooltip" title="<?php echo __('dashboard_myproject_close','Close'); ?>"><i class="fa fa-ban"></i></a>
			<?php	
			}
			if($v['is_completed'] == 'R'){
				echo __('dashboard_myproject_client_request_for_complete','Requested for complete');
			}else if($v['is_cancelled'] == 'R'){
				if($v['cancel_requested_by'] == $user_id || empty($v['cancel_requested_by'])){
					echo 'Requested for cancelled ';
					if($v['note']){
						echo '<a href="javascript:void(0)" data-toggle="popover" title="Reason" data-content="'.$v['note'].'"><i class="fa fa-lg fa-info-circle"></i></a>';
					}
					
				}else{
					$cnl_y = base_url('dashboard/project_cancel_confirm/'.$v['project_id'].'/'.'Y?next=dashboard/myproject_client');
					$cnl_n = base_url('dashboard/project_cancel_confirm/'.$v['project_id'].'/'.'N?next=dashboard/myproject_client');
					echo 'Cancelled ? ';
					if($v['note']){
						echo '<a href="javascript:void(0)" data-toggle="popover" title="Reason" data-content="'.$v['note'].'"><i class="fa fa-lg fa-info-circle"></i></a>';
					}
					
					echo '<br/>';
					echo '<a href="'.$cnl_y.'">Yes</a> | <a href="'.$cnl_n.'">No</a>';
				}
				
				
			}else{
				
			if($status == 'S'){
				echo '<a href="'.base_url('projectroom/employer/overview/'.$v['project_id']).'">Visit work room </a>';
			}else{
			
			$allowed_p_sts = array('P', 'PS', 'E');
			
		?>
		<?php if(in_array($status, $allowed_p_sts) && !is_dispute_project($v['project_id'])){ ?>
		<select class="form-control" data-project-id="<?php echo $v['project_id']; ?>" onchange="triggerAction(this)" data-id="<?php echo $v['id']; ?>">
			<option value=""><?php echo __('dashboard_myproject_client_choose_action','choose action'); ?> </option>
			<?php if($status=='P'){ ?>
			<?php if($v['project_type'] == 'F'){ 
			$return_row=$this->myfinance_model->checkproject_milestone($v['project_id']);
			?>
			<?php if($return_row == 0){ ?>
			<option value="C"><?php echo __('dashboard_myproject_client_completed','Completed'); ?></option>
			<?php } ?>
			<option value="CNL"><?php echo __('dashboard_myproject_client_cancelled','Cancelled'); ?></option>
			<?php } ?>
			<?php if($v['project_type'] == 'H'){ ?>
			<option value="PS"><?php echo __('dashboard_myproject_client_pause','Pause'); ?></option>
			<?php } ?>
			<?php }else if($status=='F'){ ?>
			<?php if($v['project_type'] == 'F'){ ?>
			<option value="CNL"><?php echo __('dashboard_myproject_client_cancelled','Cancelled'); ?></option>
			<?php } ?>
			
			<?php }else if($status=='PS'){ ?>
			<option value="P"><?php echo __('dashboard_myproject_client_resume','Resume'); ?></option>
			<?php if($v['project_type'] == 'F'){ ?>
			<option value="CNL"><?php echo __('dashboard_myproject_client_cancelled','Cancelled'); ?></option>
			<?php } ?>
			<?php } ?>						
			<option value="REPOST"><?php echo __('dashboard_myproject_client_repost','Repost'); ?></option>
			
			<?php if($status == 'E'){ ?>
			<option value="RO">Reopen</option>
			<?php } ?>
			
		</select>
		<?php } ?>
		<?php } } }	 ?>
	</td>
</tr>

<?php } } ?>

</tbody>
</table>

<script>
function triggerAction(e){
	
	var p_id = $(e).attr('data-project-id');
	var id = $(e).attr('data-id');
	var val = $(e).val();				
	if(val == 'REPOST'){			
		location.href = '<?php echo base_url('postjob/repost?project_id=');?>'+p_id;			
		return;		
	}else if(val == 'RO'){
		location.href = '<?php echo base_url('postjob/editjob');?>/'+id+'?action=RO';	/* Re Open Project */		
		return;
	}
	
	if(val == 'CNL'){
		
		var reason_html = $('<div><p>Enter Reason of cancellation </p><textarea class="form-control" id="cancel_reason_input"></textarea></div>');
		var $reason_input = reason_html.find('#cancel_reason_input');

		$.confirm({
			title : 'Cancel Project !',
			content: reason_html,
			buttons: {
				confirm : function(){
					
					var cancel_reason = $reason_input.val();
					if(cancel_reason.trim().length == 0){
						$reason_input.addClass('invalid');
						return false;
					}
					
					if(p_id){
						
						$.ajax({

							url : '<?php echo base_url('dashboard/project_action_status');?>',

							type: 'post',

							data: {status: val, project_id: p_id, reason: cancel_reason},

							dataType: 'json',

							success: function(res){

								if(res.status == 1){

									location.reload();

								}

							}

						});

					}
					
				},
				close: function(){
					
				}
			}
			
		});

	}else{
		if(val != ''){
			$.ajax({
				url : '<?php echo base_url('dashboard/project_action_status');?>',
				type: 'post',
				data: {status: val, project_id: p_id},
				dataType: 'json',
				success: function(res){
					if(res.status == 1){
						location.reload();
					}
				}
			});
		}
	}
	
}

$(document).ready(function(){
  $('[data-toggle="popover"]').popover(); 
});


var serialize = function(obj) {
  var str = [];
  for (var p in obj)
    if (obj.hasOwnProperty(p)) {
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    }
  return str.join("&");
}

function rating_review(ele){
	var p_id = $(ele).data('projectId');
	var freelancer_id = $(ele).data('freelancerId');
	var data = {
		page : 'rating_review',
		review_to_user: freelancer_id,
		review_from_user: '<?php echo $login_user_id;?>',
		job_id: p_id,
		review_to: 'freelancer',
		next: 'dashboard/myproject_client',
	};
	
	var query_str = serialize(data);
	var url = '<?php echo base_url('review/load_ajax_page')?>?'+query_str;
	load_ajax_modal(url);	
	console.log(query_str);
}





</script>

<?php /* $this->load->view('projectdashboard_new/employer_rating_review'); */ ?>