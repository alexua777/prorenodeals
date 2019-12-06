<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">

<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script>

<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script>

<script type="text/javascript" charset="utf-8">

$(document).ready(function() {

$('#example').dataTable({

columns: [

{},

{ },

{ orderable:      false, },

{  },

{ orderable:      false,},



],

"order": [[ 3, "desc" ]]

});

} );

</script>

<table id="example" class="table table-hover">

<thead><tr><th>Project Name</th><th hidden>Project Type</th><th>Posted By</th><th>Posted date</th><th>Action</th></tr>

</thead>

<tbody>	

<?php

$this->load->model('projectdashboard_new/projectdashboard_model');
if(count($working_projects)>0)

{

foreach($working_projects as $key=>$val)

{

	

$allend=explode(",",$val['end_contractor']);

$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);

$username=$this->auto_model->getFeild('fname','user','user_id',$val['user_id']);



///////////////////////////Check Milestone Status/////////////////////////////

$count_milestone=$this->auto_model->count_results('id','project_milestone','project_id',$val['project_id']);

if($count_milestone>0)

{

$client_approval_Y=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'Y'));

$client_approval_N=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'N'));

$client_approval_D=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'D'));

$request_by=$this->auto_model->getFeild('request_by','project_milestone','project_id',$val['project_id']);

}

//////////////////////////End Checkinh Milestone////////////////////////////////

$type="";

if($val['project_type']=="F")

{

$type="Fixed";

}

else

{

$type="Hourly";

}



$is_escrowed = 0;

if($val['project_type']=="F"){

	$milestone_row_all = $this->projectdashboard_model->getsetMilestone($val['project_id']);

	$milestone_row = !empty($milestone_row_all[0]) ? $milestone_row_all[0] : array();

	if($milestone_row){

		$escrow_row = $this->db->where('milestone_id', $milestone_row['id'])->get('escrow_new')->row_array();

		if(!empty($escrow_row)){

			$is_escrowed = 1;

		}

	}



}else{

	$milestone_row = array();

}

?>

<tr><td>

<?php

if($val['project_type']=='F')

{

?>

<a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><?php echo $project_name;?></a>

<?php

}

else

{

?>

<a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><?php echo $project_name;?></a>

<?php	

}

?>

</td>

<td hidden><?php echo $type;?></td>

<td><?php echo $username;?></td>

<td><?php echo $this->auto_model->date_format($val['post_date']);?></td>

<?php

if($val['project_type']=='F')

{  

?>

<td>



<!--<a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><i class="fa fa-home"></i></a>-->



<?php /*if($val['is_cancelled'] != 'R' && $val['is_completed'] != 'R'){ ?>



<?php if($milestone_row && $milestone_row['release_payment']=='D'){ ?>



<?php }else{ ?>

<div>

<select class="form-control" onchange="triggerAction(this)" data-project-id="<?php echo $val['project_id'];?>" data-milestone-id="<?php echo $milestone_row['id'] ; ?>">

	<option value="">choose action</option>

	<?php if($milestone_row['release_payment']!='R'){ ?>

	<option value="CNL">Request Cancellation</option>

	<?php } ?>

	<?php if($escrow_row && ($is_escrowed == 1) && ($escrow_row['status'] == 'P') && $milestone_row && ($milestone_row['release_payment']=='R')){ ?>

	<option value="D">Dispute</option>

	<?php } ?>

</select>

</div>

<?php } ?>

<?php }*/ ?>





<?php if($val['is_cancelled'] != 'R' && $val['is_completed'] != 'R'){ ?>



<?php if($milestone_row && $milestone_row['release_payment']=='D'){ ?>



<?php }else{ ?>



<?php if($milestone_row['release_payment']!='R'){ ?>

<a href="javascript:void(0);" class="text-danger" onclick="cancelProject('<?php echo $val['project_id']; ?>', this)">Request Cancellation</a> | 

<?php } ?>



<?php if($escrow_row && ($is_escrowed == 1) && ($escrow_row['status'] == 'P') && $milestone_row && ($milestone_row['release_payment']=='R')){ ?>

<a href="<?php echo base_url('myfinance/disputeMilestone/'. $milestone_row['id'].'/'.$val['project_id']); ?>">Dispute  </a> |

<?php }  ?>

<?php }  ?>



<?php } ?>



<?php if($val['is_completed'] == 'R' && (empty($val['completed_requested_by']) || $val['completed_requested_by'] != $user_id)){ ?>

 &nbsp; &nbsp; Completed?<br /> <a href="<?php echo base_url('dashboard/project_complete_confirm/'.$val['project_id'].'/'.'Y?next=dashboard/myproject_working');?>">Yes</a> | <a href="<?php echo base_url('dashboard/project_complete_confirm/'.$val['project_id'].'/'.'N?next=dashboard/myproject_working');?>">No </a> 

<?php }else if($val['is_completed'] == 'R'){ 

		echo '<p>'.__('dashboard_myproject_client_request_for_complete','Requested for complete').'</p>';

}else{  ?>



<?php } ?>





<?php if($val['is_cancelled'] == 'R' && (empty($val['cancel_requested_by']) || $val['cancel_requested_by'] != $user_id)){ ?>

 &nbsp; &nbsp; Cancelled?
 <?php if($val['note']){echo '<a href="javascript:void(0)" data-toggle="popover" title="Reason" data-content="'.$val['note'].'"><i class="fa fa-lg fa-info-circle"></i></a>'; }  ?>
 <br /> <a href="<?php echo base_url('dashboard/project_cancel_confirm/'.$val['project_id'].'/'.'Y?next=dashboard/myproject_working');?>">Yes</a> | <a href="<?php echo base_url('dashboard/project_cancel_confirm/'.$val['project_id'].'/'.'N?next=dashboard/myproject_working');?>">No </a> 

<?php }else if($val['is_cancelled'] == 'R'){

	echo '<p>Requested for cancelled</p> ';
	if($val['note']){
		echo '<a href="javascript:void(0)" data-toggle="popover" title="Reason" data-content="'.$val['note'].'"><i class="fa fa-lg fa-info-circle"></i></a>';
	}
	

} 

?>





<?php 



if($milestone_row['client_approval']=='N'){

	echo "Not Approve";

}elseif($milestone_row['client_approval']=='Y'){

	if($milestone_row['fund_release']=='P'){

		

		$str = '<a href="javascript:void(0);" class="confirm_first" data-href="'.VPATH.'dashboard/FundRequest/'.$milestone_row['id'].'?next=dashboard/myproject_working" style="float:none">Request Payment & Send Invoice</a>';

		 

		echo $str;

	}elseif($milestone_row['fund_release']=='R' && $milestone_row['release_payment'] == 'R'){ ?>

	

		 Unpaid | <?php if($milestone_row['invoice_id'] > 0){ ?><a href="<?php echo base_url('/invoice/detail/'.$milestone_row['invoice_id'].'/'.'F')?>" target="_blank">Invoice</a><?php }else{ echo 'N/A'; } ?>

		 

		 <?php

	}else if($milestone_row['fund_release']=='R' && $milestone_row['release_payment'] == 'D'){
		
		$dispute_id = get_dispute_id($milestone_row['id'], $val['project_id']);
		if(($is_escrowed == 1 ) && ($escrow_row['status'] == 'D')){ 

			echo ' Disputed | <a href="'.base_url('projectdashboard/dispute_room/'.$dispute_id).'">View</a>';

		}

	}elseif($val['fund_release']=='A'){ ?>

	

		<i class="zmdi zmdi-check-circle f16 green-text" title="Fund Approve"></i> | <?php if($milestone_row['invoice_id'] > 0){?><a href="<?php echo base_url('/invoice/detail/'.$milestone_row['invoice_id'].'/'.'F')?>" target="_blank">Invoice</a><?php }else{ echo 'N/A';}?> | <?php if($milestone_row['commission_invoice_id'] > 0){?><a href="<?php echo base_url('/invoice/detail/'.$milestone_row['commission_invoice_id'].'/'.'F'); ?>" target="_blank">Commission invoice</a><?php }else{ echo 'N/A';}?>

		

		<?php 

	}else if($milestone_row['release_payment']=='C'){

		echo 'Cancelled <a href="javascript:void(0);" class="confirm_first" data-href="'.VPATH.'dashboard/FundRequest/'.$milestone_row['id'].'?next=dashboard/myproject_working">Resend</a> | ';

		if($milestone_row['invoice_id'] > 0){

			echo '<a href="'.base_url('/invoice/detail/'.$milestone_row['invoice_id'].'/'.'F').'" target="_blank">Invoice</a>';

		}else{

			echo 'N/A';

		}

	}

	

}

?>



</td>



<?php

}

else

{

?>	

<td><? if($allend && in_array($user_id,$allend)){?><a href="<?=VPATH?>projectcontractor/freelancer/<?php echo $val['project_id'];?>">End Contract</a> |<? } ?> 

<!-- <a href="<?=VPATH?>projectdashboard/index_freelancer/<?php echo $val['project_id'];?>"><i class="fa fa-home"></i></a> -->

<a href="<?=VPATH?>projectdashboard_new/freelancer/overview/<?php echo $val['project_id'];?>"><i class="fa fa-home"></i></a>

<?php if($val['is_completed'] == 'R'){ ?>

 &nbsp; &nbsp; Completed?<br /> <a href="<?php echo base_url('dashboard/project_complete_confirm/'.$val['project_id'].'/'.'Y?next=dashboard/myproject_working');?>">Yes</a> | <a href="<?php echo base_url('dashboard/project_complete_confirm/'.$val['project_id'].'/'.'N?next=dashboard/myproject_working');?>">No </a> 

<?php } ?>



<?php if($val['is_cancelled'] == 'R'){ ?>

 &nbsp; &nbsp; Cancelled?<br /> <a href="<?php echo base_url('dashboard/project_cancel_confirm/'.$val['project_id'].'/'.'Y?next=dashboard/myproject_working');?>">Yes</a> | <a href="<?php echo base_url('dashboard/project_cancel_confirm/'.$val['project_id'].'/'.'N?next=dashboard/myproject_working');?>">No </a> 

<?php } ?>



</td>



<?php	

}

?>

</tr>

<?php

}

}



?>	

</tbody>

</table>

<script>

function triggerAction(e){

	

	var p_id = $(e).attr('data-project-id');

	var milestone_id = $(e).attr('data-milestone-id');

	var val = $(e).val();

	console.log(p_id);

	if(val != '' && val != 'D'){

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

	}else if(val == 'D' && milestone_id && p_id){

		var url = '<?php echo base_url('myfinance/disputeMilestone'); ?>/'+milestone_id+'/'+p_id;

		location.href= url;

	}

}



$('.one_click').click(function(){

	var href = $(this).attr('data-href');

	if(href){

		$(this).replaceWith('Processing... ');

		location.href = href;

	}

	

});

$('.confirm_first').click(function(){

	var href = $(this).attr('data-href');

	$.confirm({
		title: 'Confirm!',
		content: 'Are you sure this project is complete ?',
		buttons: {
			confirm: function () {
				location.href = href;
			},
			cancel: function () {
				
			}
		}
	});

});





function cancelProject(p_id, ele){

	var val = 'CNL';
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
					
					$(ele).replaceWith('Processing... ');

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
	

}

$(document).ready(function(){
  $('[data-toggle="popover"]').popover(); 
});
</script>
